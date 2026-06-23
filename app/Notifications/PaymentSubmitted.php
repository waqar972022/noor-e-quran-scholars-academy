<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class PaymentSubmitted extends Notification
{
    public function __construct(
        private readonly string $planName,
        private readonly string $transactionId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'           => 'payment_submitted',
            'message'        => 'Your payment request for "' . $this->planName . '" has been received and is under review. You will be notified once it is processed.',
            'transaction_id' => $this->transactionId,
        ];
    }
}
