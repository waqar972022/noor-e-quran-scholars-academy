<?php

namespace App\Notifications;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentApproved extends Notification
{
    use Queueable;

    public function __construct(
        public readonly UserSubscription $subscription,
        public readonly SubscriptionPlan $plan,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'     => 'payment_approved',
            'message'  => 'Your payment has been approved. Subscription active until '
                . $this->subscription->end_date->format('d M Y') . '.',
            'plan'     => $this->plan->name,
            'end_date' => $this->subscription->end_date->toDateString(),
        ];
    }
}
