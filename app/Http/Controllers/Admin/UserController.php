<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $users = User::where('role', 'user')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->withCount([
                'subscriptions as active_sub_count' => fn ($q) => $q
                    ->where('status', 'active')
                    ->where('end_date', '>=', today()),
            ])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function show(User $user): View
    {
        abort_if($user->role === 'admin', 404);

        $user->load([
            'subscriptions.plan',
            'paymentRequests.plan',
        ]);

        $plans              = SubscriptionPlan::where('status', 'active')->orderBy('sort_order')->get();
        $activeSubscription = $user->activeSubscription()?->load('plan');

        return view('admin.users.show', compact('user', 'plans', 'activeSubscription'));
    }

    public function setPassword(Request $request, User $user): RedirectResponse
    {
        abort_if($user->role === 'admin', 403);

        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update(['password' => $request->input('new_password')]);

        return back()->with('success', "Password updated for {$user->name}.");
    }

    public function activateSubscription(Request $request, User $user): RedirectResponse
    {
        abort_if($user->role === 'admin', 403);

        $request->validate([
            'plan_id'     => ['required', 'exists:subscription_plans,id'],
            'custom_days' => ['nullable', 'integer', 'min:1', 'max:3650'],
        ]);

        $plan = SubscriptionPlan::findOrFail($request->integer('plan_id'));
        $days = $request->filled('custom_days')
            ? $request->integer('custom_days')
            : $plan->duration_days;

        $active = $user->activeSubscription();

        if ($active) {
            $newEndDate = $active->end_date->copy()->addDays($days);
            $active->update(['plan_id' => $plan->id, 'end_date' => $newEndDate]);
        } else {
            UserSubscription::create([
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'status'     => 'active',
                'start_date' => today(),
                'end_date'   => today()->addDays($days),
            ]);
        }

        return back()->with('success', "Subscription activated/extended for {$user->name}.");
    }

    public function revokeSubscription(Request $request, User $user): RedirectResponse
    {
        abort_if($user->role === 'admin', 403);

        $active = $user->activeSubscription();

        if (! $active) {
            return back()->with('error', 'No active subscription to revoke.');
        }

        $active->update(['status' => 'revoked', 'end_date' => today()->subDay()]);

        return back()->with('success', "Subscription revoked for {$user->name}.");
    }
}
