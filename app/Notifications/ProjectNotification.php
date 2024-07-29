<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class ProjectNotification extends Mailable implements ShouldQueue
{
    use Queueable;

    private Task $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($project)
    {
        $this->data['header_text'] = 'A new Project was created';
        $this->data['text'] = "$project->name was created";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.text_email')->with($this->data);
    }
}
