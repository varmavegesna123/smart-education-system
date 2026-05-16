<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EnrollmentRequest;

class EnrollmentApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $enrollmentRequest;

    public function __construct(EnrollmentRequest $enrollmentRequest)
    {
        $this->enrollmentRequest = $enrollmentRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'Enrollment Approved',
            'title' => 'Enrollment Approved',
            'message' => 'Your request to join ' . $this->enrollmentRequest->classRoom->name . ' has been approved by ' . $this->enrollmentRequest->teacher->user->name,
            'class_room_id' => $this->enrollmentRequest->class_room_id,
            'url' => route('student.courses')
        ];
    }
}
