<?php

namespace App\Http\Controllers;

use App\Models\PaymentRequest;
use App\Models\SubscriptionPlan;
use App\Notifications\PaymentSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(SubscriptionPlan $plan): View
    {
        abort_if($plan->status !== 'active', 404);

        return view('checkout', compact('plan'));
    }

    public function store(Request $request, SubscriptionPlan $plan): RedirectResponse
    {
        abort_if($plan->status !== 'active', 404);

        $request->validate([
            'transaction_id' => [
                'required',
                'string',
                'max:100',
                'unique:payment_requests,transaction_id',
            ],
            'screenshot' => 'required|file|max:5120|mimes:jpg,jpeg,png,webp',
        ], [
            'transaction_id.unique' => 'This transaction ID has already been submitted. Contact support if this is an error.',
        ]);

        $screenshot = $request->file('screenshot');

        // Validate real MIME type — guards against extension spoofing
        $realMime = (new \finfo(\FILEINFO_MIME_TYPE))->file($screenshot->getPathname());
        if (! in_array($realMime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return back()
                ->withErrors(['screenshot' => 'The screenshot must be a valid image (JPG, PNG, or WebP).'])
                ->withInput();
        }

        $filename = 'pmt-' . $request->user()->id . '-' . time() . '.' . $screenshot->extension();
        $screenshot->move(public_path('payment-screenshots'), $filename);

        PaymentRequest::create([
            'user_id'        => $request->user()->id,
            'plan_id'        => $plan->id,
            'amount'         => $plan->price,
            'transaction_id' => trim($request->input('transaction_id')),
            'screenshot'     => 'payment-screenshots/' . $filename,
            'status'         => 'pending',
        ]);

        $request->user()->notify(new PaymentSubmitted($plan->name, trim($request->input('transaction_id'))));

        return redirect()->route('dashboard')
            ->with('success', 'Payment request received. Your access will be activated within 24 hours once verified.');
    }
}
