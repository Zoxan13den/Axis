<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\Mail;

class EmailNotificationService implements NotificationInterface
{
    public function send($notifiable, $notification)
    {
        Mail::to($notifiable)->send($notification);
    }
}