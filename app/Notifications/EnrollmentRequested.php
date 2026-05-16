<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EnrollmentRequest;

class EnrollmentRequested extends Notification implements ShouldQueue
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
            'type' => 'Enrollment Request',
            'title' => 'New Enrollment Request',
            'message' => $this->enrollmentRequest->student->user->name . ' has requested to join ' . $this->enrollmentRequest->classRoom->name,
            'enrollment_request_id' => $this->enrollmentRequest->id,
            'url' => route('teacher.dashboard') // or a specific requests route
        ];
    }
}
