<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentRequest;
use App\Models\UserSubscription;
use App\Notifications\PaymentApproved;
use App\Notifications\PaymentRejected;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $status  = $request->query('status', 'pending');
        $allowed = ['pending', 'approved', 'rejected', 'all'];
        if (! in_array($status, $allowed, true)) {
            $status = 'pending';
        }

        $query = PaymentRequest::with(['user', 'plan'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $paymentRequests = $query->paginate(20)->withQueryString();

        $counts = [
            'pending'  => PaymentRequest::where('status', 'pending')->count(),
            'approved' => PaymentRequest::where('status', 'approved')->count(),
            'rejected' => PaymentRequest::where('status', 'rejected')->count(),
            'all'      => PaymentRequest::count(),
        ];

        return view('admin.payments.index', compact('paymentRequests', 'status', 'counts'));
    }

    public function show(PaymentRequest $paymentRequest): View
    {
        $paymentRequest->load(['user', 'plan', 'reviewer']);
        return view('admin.payments.show', compact('paymentRequest'));
    }

    public function screenshot(PaymentRequest $paymentRequest): StreamedResponse
    {
        $disk = Storage::disk('local');
        abort_unless($paymentRequest->screenshot && $disk->exists($paymentRequest->screenshot), 404);

        return $disk->response($paymentRequest->screenshot, null, ['Cache-Control' => 'private, no-store']);
    }

    public function approve(PaymentRequest $paymentRequest): RedirectResponse
    {
        if ($paymentRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        DB::transaction(function () use ($paymentRequest) {
            $user = $paymentRequest->user;
            $plan = $paymentRequest->plan;

            // Renewal stacking: extend existing subscription or create a fresh one
            $active = $user->activeSubscription();

            if ($active) {
                $newEndDate = $active->end_date->copy()->addDays($plan->duration_days);
                $active->update([
                    'plan_id'  => $plan->id,
                    'end_date' => $newEndDate,
                ]);
                $subscription = $active;
            } else {
                $subscription = UserSubscription::create([
                    'user_id'    => $user->id,
                    'plan_id'    => $plan->id,
                    'status'     => 'active',
                    'start_date' => today(),
                    'end_date'   => today()->addDays($plan->duration_days),
                ]);
            }

            $paymentRequest->update([
                'status'      => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            Payment::create([
                'user_id'        => $user->id,
                'plan_id'        => $plan->id,
                'amount'         => $paymentRequest->amount,
                'transaction_id' => $paymentRequest->transaction_id,
                'paid_at'        => now(),
            ]);

            $user->notify(new PaymentApproved($subscription, $plan));
        });

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment approved and subscription activated.');
    }

    public function reject(Request $request, PaymentRequest $paymentRequest): RedirectResponse
    {
        if ($paymentRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $paymentRequest->update([
            'status'      => 'rejected',
            'admin_note'  => $request->input('admin_note'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $paymentRequest->user->notify(new PaymentRejected($request->input('admin_note')));

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment request rejected.');
    }
}
