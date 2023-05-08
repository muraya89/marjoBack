<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // defines the relationship between Booking and Car (many-to-one)
    public function car ()
    {
        return $this->belongsTo('App\Models\Car');
    }

    // between Booking and User (many-to-one).
    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }
}
