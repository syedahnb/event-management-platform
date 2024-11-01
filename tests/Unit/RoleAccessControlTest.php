<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendee_cannot_create_event()
    {
        $attendee = User::factory()->create(['role' => 'attendee']);
        $this->actingAs($attendee);

        $response = $this->post('/events', [
            'title' => 'Unauthorized Event',
            'location' => 'Somewhere',
            'date' => now()->addDay(),
            'capacity' => 10,
        ]);

        $response->assertStatus(403); // Forbidden
    }

    public function test_organizer_can_create_event()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $this->actingAs($organizer);

        $response = $this->post('/events', [
            'title' => 'Organizer Event',
            'location' => 'Conference Room',
            'date' => now()->addDay(),
            'capacity' => 100,
        ]);

        $response->assertStatus(302); // Success
        $this->assertDatabaseHas('events', ['title' => 'Organizer Event']);
    }
}
