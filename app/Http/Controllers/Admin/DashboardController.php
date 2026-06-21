<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Models\UserSubscription;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'total_users'          => User::where('role', 'user')->count(),
            'active_subscriptions' => UserSubscription::where('status', 'active')->count(),
            'pending_payments'     => PaymentRequest::where('status', 'pending')->count(),
            'total_courses'        => Course::count(),
            'published_courses'    => Course::where('status', 'published')->count(),
        ];

        $recent = User::where('role', 'user')
            ->latest()
            ->take(8)
            ->get(['id', 'name', 'email', 'phone', 'account_status', 'created_at']);

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
