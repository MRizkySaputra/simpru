<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['code', 'name', 'building_id', 'capacity', 'facilities', 'code'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
