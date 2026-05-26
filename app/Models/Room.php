<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['code', 'name', 'building_id', 'capacity', 'facilities', 'code'];

    // TAMBAHKAN INI:
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}