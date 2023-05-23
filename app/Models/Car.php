<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model','brand','seats','transmission','fuel_type','mileage','year','status','color','location_id','image'
    ];

    // protected $appends = ['location'];

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

    // public function getLocationAttribute()
    // {
    //     return $this->location();
    // }
}
