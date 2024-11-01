<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            // Share authenticated user
            'auth' => [
                'user' => $request->user(),
            ],

            // Share Ziggy configuration for route generation in JavaScript
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],

            // Share notifications if user is authenticated
            'notifications' => function () use ($request) {
                return $request->user()
                    ? $request->user()->unreadNotifications // Get unread notifications
                    : [];
            },
        ];
    }
}
