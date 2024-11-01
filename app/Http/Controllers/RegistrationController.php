<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Notifications\RegistrationSuccessNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegistrationController extends Controller
{

    public function show(Event $event)
    {
        $user = auth()->user();
        $isRegistered = $event->registrations()->where('user_id', $user->id)->exists();
        $registeredCount = $event->registrations()->count();
        $remainingSpots = max($event->capacity - $registeredCount, 0);
        $feedback = $event->feedback()->with('user')->orderBy('submitted_at', 'desc')->get();


        return Inertia::render('Events/Show', [
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'location' => $event->location,
                'date' => $event->date,
                'capacity' => $event->capacity,
                'is_full' => $event->is_full,
                'remaining_spots' => $remainingSpots,
            ],
            'is_registered' => $isRegistered,
            'feedback' => $feedback,
        ]);
    }

    /**
     * Store a new registration.
     */
    public function store(Event $event)
    {
        // Check if the event is full
        if ($event->is_full) {
            return redirect()->back()->withErrors(['message' => 'This event is full. Registration is closed.']);
        }

        // Check if the user is already registered
        if ($event->registrations()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->withErrors(['message' => 'You are already registered for this event.']);
        }

        // Register the user for the event
        $event->registrations()->create([
            'user_id' => Auth::id(),
        ]);


        Auth::user()->notify(new RegistrationSuccessNotification($event));

        if ($event->registrations()->count() >= $event->capacity) {
            $event->update(['is_full' => true]);
        }

        return redirect()->back()->with('success', 'Successfully registered for the event.');
    }
}
