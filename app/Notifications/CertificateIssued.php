<?php

namespace App\Notifications;

use App\Models\Certificate;
use Illuminate\Notifications\Notification;

class CertificateIssued extends Notification
{
    public function __construct(private readonly Certificate $certificate) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'               => 'certificate_issued',
            'message'            => 'Congratulations! Your certificate for "' . $this->certificate->course->title . '" is ready.',
            'course_title'       => $this->certificate->course->title,
            'certificate_number' => $this->certificate->certificate_number,
            'certificate_id'     => $this->certificate->id,
        ];
    }
}
