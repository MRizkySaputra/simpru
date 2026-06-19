<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPeminjaman(Request $request)
    {
        $room = \App\Models\Room::findOrFail($request->room_id);
        return view('user.detail-peminjaman', compact('room'));
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    protected static function booted()
    {
        static::created(function ($booking) {
            \App\Models\AdminNotification::create([
                'title' => 'Permohonan Baru: ' . ($booking->room->name ?? 'Ruangan') . ' oleh ' . ($booking->user->name ?? 'Pengguna'),
                'message' => 'Seseorang baru saja mengajukan peminjaman ruangan untuk kegiatan "' . $booking->activity_name . '".',
                'type' => 'urgent',
                'is_read' => false,
                'action_link' => '/admin/detail-permohonan/' . $booking->id,
                'action_text' => 'Detail Berkas',
            ]);
        });
    }
}
