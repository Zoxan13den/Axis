<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class TaskNotification extends Mailable implements ShouldQueue
{
    use Queueable;

    private Task $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->data['header_text'] = 'A new Task was created';
        $this->data['text'] = "$task->name was created";
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
