<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventReminderNotification extends Notification
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Event Reminder')
            ->line("This is a reminder for the event: {$this->event->title}.")
            ->line("Location: {$this->event->location}")
            ->line("Date and Time: {$this->event->date->format('F j, Y, g:i a')}")
            ->line("We look forward to seeing you there!")
            ->action('View Event', url("/events/{$this->event->id}"));
    }
}
