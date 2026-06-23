<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $notifications = $user->notifications()->latest()->paginate(20);

        // Mark all as read on page open
        $user->unreadNotifications->markAsRead();

        return view('user.notifications', compact('notifications'));
    }

    public function markAllRead(): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}
