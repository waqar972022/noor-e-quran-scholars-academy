<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Notifications\Notification;

class SubscriptionExpiringSoon extends Notification
{
    public function __construct(private readonly UserSubscription $subscription) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'     => 'subscription_expiring_soon',
            'message'  => 'Your subscription expires in 3 days on '
                . $this->subscription->end_date->format('d M Y')
                . '. Renew now to keep your access to all courses.',
            'end_date' => $this->subscription->end_date->toDateString(),
        ];
    }
}
