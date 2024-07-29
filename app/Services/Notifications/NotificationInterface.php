<?php

namespace App\Services\Notifications;

interface NotificationInterface
{
    public function send($notifiable, $notification);
}