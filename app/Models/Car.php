<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    // This model defines the relationships between Car and Booking (one-to-many)
    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }

    // This model defines the relationships between Car and Location (many-to-one).
    public function location ()
    {
        return $this->belongsTo('App\Models\Location');
    }
}
