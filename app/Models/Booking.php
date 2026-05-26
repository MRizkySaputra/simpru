<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi: Permohonan dimiliki oleh 1 User (Peminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Permohonan meminjam 1 Ruangan
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}