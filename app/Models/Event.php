<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'description', 'location', 'date', 'capacity', 'created_by', 'is_full'];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }
}
