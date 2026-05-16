<?php

namespace App\Notifications;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAssignmentCreated extends Notification
{
    use Queueable;

    protected $assignment;

    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'New Assignment',
            'title' => 'New Assignment: ' . $this->assignment->title,
            'message' => 'An assignment has been posted for ' . $this->assignment->classRoom->name . '.',
            'assignment_id' => $this->assignment->id,
            'due_date' => $this->assignment->due_date->format('Y-m-d'),
        ];
    }
}
