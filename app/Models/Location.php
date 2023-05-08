<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // This model defines the relationship between Location and Car (one-to-many).
    public function cars ()
    {
        return $this->hasMany('App\Models\Car');
    }
}
