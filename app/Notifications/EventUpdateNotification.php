<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class EventUpdateNotification extends Notification
{
    use Queueable;

    protected $event;
    protected $message;

    public function __construct($event, $message)
    {
        $this->event = $event;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->message . ' for ' . $this->event->title,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message . ' for ' . $this->event->title,
        ];
    }
}
