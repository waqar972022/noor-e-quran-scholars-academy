<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentRejected extends Notification
{
    use Queueable;

    public function __construct(public readonly string $reason) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => 'payment_rejected',
            'message' => 'Your payment request was not approved.',
            'reason'  => $this->reason,
        ];
    }
}
