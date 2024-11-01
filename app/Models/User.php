<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const ADMIN = 'admin';
    const ORGANIZER = 'organizer';
    const ATTENDEE = 'attendee';


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === self::ADMIN;
    }

    public function isOrganizer()
    {
        return $this->role === self::ORGANIZER;
    }

    public function isAttendee()
    {
        return $this->role === self::ATTENDEE;
    }

}
