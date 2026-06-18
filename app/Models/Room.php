<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'building_id',
        'capacity',
        'facilities',
        'image_path',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
