<?php

namespace App\Notifications;

use ReflectionClass;
use Illuminate\Notifications\Notification;

class DatabaseNotificationChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toArray($notifiable);
        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,
            'type' => (new ReflectionClass($notification))->getShortName(),//short name php function ja only class ferot dey
            'data' => $data,
            'read_at' => null,
        ]);
    }
}
