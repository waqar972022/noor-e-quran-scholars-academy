<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class SubscriptionExpired extends Notification
{
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => 'subscription_expired',
            'message' => 'Your subscription has expired. Renew now to regain access to all course content.',
        ];
    }
}
