<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportingController extends Controller
{
    public function index()
    {
        // Total events created
        $totalEvents = Event::count();

        // Total registrations
        $totalRegistrations = DB::table('registrations')->count();

        // Average feedback rating per event
        $averageFeedbackRatings = DB::table('feedback')
            ->select('event_id', DB::raw('AVG(rating) as average_rating'))
            ->groupBy('event_id')
            ->pluck('average_rating', 'event_id');

        // Top-rated events and the number of attendees for each
        $topRatedEvents = Event::select('events.*')
            ->selectSub(
                DB::table('feedback')
                    ->selectRaw('AVG(rating)')
                    ->whereColumn('feedback.event_id', 'events.id')
                    ->groupBy('feedback.event_id'),
                'average_rating'
            )
            ->withCount('registrations')
            ->orderByDesc('average_rating')
            ->take(5)
            ->get();

        return Inertia::render('Admin/Report', [
            'totalEvents' => $totalEvents,
            'totalRegistrations' => $totalRegistrations,
            'averageFeedbackRatings' => $averageFeedbackRatings,
            'topRatedEvents' => $topRatedEvents,
        ]);
    }
}
