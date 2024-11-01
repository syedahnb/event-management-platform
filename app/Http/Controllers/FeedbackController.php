<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\StoreFeedbackRequest;
use App\Models\Event;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(StoreFeedbackRequest $request, Event $event)
    {

        $isEligible = $event->registrations()
                ->where('user_id', Auth::id())
                ->exists() && $event->date < now();

        if (!$isEligible) {
            return response()->json(['message' => 'You are not eligible to leave feedback for this event.'], 403);
        }

        // Store feedback
        Feedback::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,

        ]);

        return back()->with('success', 'Thank you for your feedback.');
    }
}
