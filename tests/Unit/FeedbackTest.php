<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Event;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendee_can_leave_feedback_after_event()
    {
        $user = User::factory()->create(['role' => 'attendee']);
        $event = Event::factory()->create(['date' => now()->subDay()]);
        $event->registrations()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->post("/events/{$event->id}/feedback", [
            'rating' => 4,
            'comment' => 'Great event!',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('feedback', ['event_id' => $event->id, 'user_id' => $user->id, 'rating' => 4]);
    }

    public function test_attendee_cannot_leave_feedback_for_future_event()
    {
        $user = User::factory()->create(['role' => 'attendee']);
        $event = Event::factory()->create(['date' => now()->addDay()]);
        $event->registrations()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->post("/events/{$event->id}/feedback", [
            'rating' => 4,
            'comment' => 'Great event!',
        ]);

        $response->assertStatus(403); // Forbidden as event has not passed
    }
}
