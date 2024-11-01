<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {

        $events = Event::where('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->through(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'location' => $event->location,
                    'date' => $event->date,
                    'capacity' => $event->capacity,
                    'is_full' => $event->is_full,
                    'can_edit' => auth()->user()->can('update', $event),
                    'can_delete' => auth()->user()->can('delete', $event),
                ];
            });

        $canCreate = auth()->user()->can('create', Event::class);


        return Inertia::render('Events/Index', [
            'events' => $events,
            'can_create' => $canCreate,
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Event::class);

        return Inertia::render('Events/Create');
    }

    public function store(StoreEventRequest $request)
    {
        Gate::authorize('create', Event::class);


        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'capacity' => $request->capacity,
            'created_by' => auth()->id(),
            'is_full' => false,
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        Gate::authorize('update', $event);

        return Inertia::render('Events/Edit', [
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'location' => $event->location,
                'date' => $event->date,
                'capacity' => $event->capacity,
            ],
        ]);
    }

    public function update(Event $event, UpdateEventRequest  $request)
    {
        Gate::authorize('update', $event);

        $event->update($request->validated());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        Gate::authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
