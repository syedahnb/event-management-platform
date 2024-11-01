<?php


namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendee_can_register_for_event()
    {
        $this->markTestIncomplete('Test needs further configuration.');


        $this->withoutBroadcasting();

        $user = User::factory()->create(['role' => 'attendee']);
        $event = Event::factory()->create(['capacity' => 2]);

        $this->actingAs($user);
        $response = $this->post("/events/{$event->id}/register");

        $response->assertStatus(302);
        $this->assertDatabaseHas('registrations', ['user_id' => $user->id, 'event_id' => $event->id]);
    }

    public function test_event_is_full_after_capacity_is_reached()
    {

        $this->markTestIncomplete('Test needs further configuration.');


        $this->withoutBroadcasting();
        $event = Event::factory()->create(['capacity' => 1]);

        // Register the first attendee
        $firstUser = User::factory()->create(['role' => 'attendee']);
        $this->actingAs($firstUser);
        $this->post("/events/{$event->id}/register");

        // Try to register the second attendee
        $secondUser = User::factory()->create(['role' => 'attendee']);
        $this->actingAs($secondUser);
        $response = $this->post("/events/{$event->id}/register");

        $response->assertStatus(403); // Forbidden as the event is full
    }
}
