<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'organizer']);
    }

    public function update(User $user, Event $event)
    {
        return $user->id === $event->created_by || $user->role === 'admin';
    }

    public function delete(User $user, Event $event)
    {
        return $user->id === $event->created_by || $user->role === 'admin';
    }

    public function view(User $user, Event $event)
    {
        return true; // All roles can view events
    }

}
