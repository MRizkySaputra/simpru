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

    public function detailPeminjaman(Request $request)
{
    $room = \App\Models\Room::findOrFail($request->room_id);
    return view('user.detail-peminjaman', compact('room'));
}

    // Relasi: Permohonan meminjam 1 Ruangan
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    protected static function booted()
{
    static::created(function ($booking) {
        // Otomatis membuat notifikasi admin saat ada booking baru
        \App\Models\AdminNotification::create([
            'title' => 'Permohonan Baru: ' . ($booking->room->name ?? 'Ruangan') . ' oleh ' . (auth()->user()->name ?? 'Pengguna'),
            'message' => 'Seseorang baru saja mengajukan peminjaman ruangan untuk kegiatan "' . $booking->activity_name . '".',
            'type' => 'urgent', // Mengatur tipe menjadi urgent agar muncul badge merah
            'is_read' => false,
            'action_link' => '/admin/detail-permohonan/' . $booking->id,
            'action_text' => 'Detail Berkas',
        ]);
    });
}
}