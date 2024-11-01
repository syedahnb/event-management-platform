<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Notifications\EventReminderNotification;
use Carbon\Carbon;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';

    protected $description = 'Send reminders to attendees for events happening in the next 24 hours';

    public function handle()
    {
        // Get events scheduled 24 hours from now
        $events = Event::where('date', Carbon::now()->addDay()->startOfHour())
            ->with('registrations.user') // Load attendees with registrations
            ->get();

        foreach ($events as $event) {
            foreach ($event->registrations as $registration) {
                $registration->user->notify(new EventReminderNotification($event));
            }
        }

        $this->info('Event reminders have been sent successfully.');
    }
}
