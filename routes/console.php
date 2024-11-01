<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;



Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



Artisan::command('events:send-reminders', function () {
    $this->call('App\Console\Commands\SendEventReminders');
});


$schedule = app(Schedule::class);
$schedule->command('events:send-reminders')->hourly();
