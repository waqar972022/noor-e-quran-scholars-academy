<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        /** @var User $user */
        $user          = auth()->user();
        $subscription  = $user->activeSubscription()?->load('plan');
        $daysRemaining = $subscription
            ? max(0, (int) today()->diffInDays($subscription->end_date))
            : null;
        $courseCount         = Course::where('status', 'published')->count();
        $pendingCount        = $user->paymentRequests()->where('status', 'pending')->count();
        $recentPayments      = $user->paymentRequests()->with('plan')->latest()->limit(3)->get();
        $unreadNotifications = $user->unreadNotifications()->latest()->limit(5)->get();

        return view('user.dashboard', compact(
            'subscription', 'daysRemaining', 'courseCount', 'pendingCount',
            'recentPayments', 'unreadNotifications'
        ));
    }

    public function learning(): View
    {
        /** @var User $user */
        $user         = auth()->user();
        $isSubscribed = $user->hasActiveSubscription();
        $courses      = Course::with(['category', 'videos', 'files'])
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('user.learning', compact('isSubscribed', 'courses'));
    }

    public function subscription(): View
    {
        /** @var User $user */
        $user          = auth()->user();
        $subscription  = $user->activeSubscription()?->load('plan');
        $history       = $user->subscriptions()->with('plan')->latest()->get();
        $daysRemaining = $subscription
            ? max(0, (int) today()->diffInDays($subscription->end_date))
            : null;

        return view('user.subscription', compact('subscription', 'history', 'daysRemaining'));
    }

    public function payments(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $payments = $user->paymentRequests()
            ->with('plan')
            ->latest()
            ->paginate(15);

        return view('user.payments', compact('payments'));
    }

}
