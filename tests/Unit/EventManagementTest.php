<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->post('/events', [
            'title' => 'Sample Event',
            'location' => 'Sample Location',
            'date' => now()->addDays(2),
            'capacity' => 50,
        ]);

        $response->assertStatus(302); // Redirect on success
        $this->assertDatabaseHas('events', ['title' => 'Sample Event']);
    }

    public function test_admin_can_update_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $event = Event::factory()->create([
            'title' => 'Old Event',
            'description' => 'Old Description',
            'location' => 'Old Location',
            'date' => now()->addDays(5),
            'capacity' => 100,
            'created_by' => $admin->id,
        ]);


        $response = $this->put("/events/{$event->id}", [
            'title' => 'Updated Event',
            'description' => 'Updated Description',
            'location' => 'Updated Location',
            'date' => $event->date,
            'capacity' => $event->capacity,
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Event',
            'description' => 'Updated Description',
            'location' => 'Updated Location',
        ]);
    }

    public function test_admin_can_delete_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $event = Event::factory()->create();
        $response = $this->delete("/events/{$event->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
