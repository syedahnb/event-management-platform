<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['event_id', 'user_id', 'rating', 'comment', 'submitted_at'];
}
