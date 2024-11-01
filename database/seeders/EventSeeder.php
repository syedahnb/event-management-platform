<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get an array of admin and organizer user IDs
        $userIds = User::whereIn('role', ['admin', 'organizer'])->pluck('id')->toArray();

        // Create 50 sample events
        Event::factory()->count(50)->create([
            'created_by' => function () use ($userIds) {
                return $userIds[array_rand($userIds)];
            }
        ]);
    }
}
