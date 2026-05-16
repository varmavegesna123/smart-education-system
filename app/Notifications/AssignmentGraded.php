<?php

namespace App\Notifications;

use App\Models\AssignmentSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AssignmentGraded extends Notification
{
    use Queueable;

    protected $submission;

    public function __construct(AssignmentSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'Assignment Graded',
            'title' => 'Assignment Graded: ' . $this->submission->assignment->title,
            'message' => 'Your submission has been reviewed. Marks: ' . $this->submission->marks_awarded . '/' . $this->submission->assignment->total_marks,
            'submission_id' => $this->submission->id,
        ];
    }
}
