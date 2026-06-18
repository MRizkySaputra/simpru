<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Menghitung statistik peminjaman user yang sedang login
        $approvedCount = Booking::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $pendingCount = Booking::where('user_id', $user->id)->where('status', 'menunggu')->count();
        $rejectedCount = Booking::where('user_id', $user->id)->where('status', 'ditolak')->count();

        // Mengambil 3 riwayat terbaru untuk tabel dashboard
        $recentBookings = Booking::with('room')->where('user_id', $user->id)->latest()->take(3)->get();
        
        // Mengambil 2 ruangan untuk rekomendasi
        $recommendedRooms = Room::inRandomOrder()->take(2)->get();

        return view('user.dashboard', compact('approvedCount', 'pendingCount', 'rejectedCount', 'recentBookings', 'recommendedRooms'));
    }

    public function riwayat()
    {
        $bookings = Booking::with('room')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('user.riwayat', compact('bookings'));
    }

    public function riwayatDetail($id)
    {
        // Cari data booking berdasarkan ID beserta relasi ruangannya
        $booking = Booking::with('room')->findOrFail($id);
        
        return view('user.riwayat-detail', compact('booking'));
    }

    public function cetakBukti($id)
{
    $booking = \App\Models\Booking::with('room')->findOrFail($id);

    // Pastikan hanya user pemilik booking atau admin yang bisa cetak
    if (auth()->user()->role !== 'admin' && $booking->user_id !== auth()->id()) {
        abort(403, 'Akses tidak sah.');
    }

    // Pastikan hanya yang disetujui yang bisa dicetak
    if ($booking->status !== 'disetujui') {
        return back()->with('error', 'Permohonan belum disetujui.');
    }

    return view('user.cetak-bukti', compact('booking'));
}

    public function profil()
    {
        $user = Auth::user();
        // Menghitung total peminjaman sepanjang masa
        $totalBookings = Booking::where('user_id', $user->id)->count();

        return view('user.profil', compact('user', 'totalBookings'));
    }

    public function notifikasi()
{
    // 1. Ambil user yang sedang login
    $user = Auth::user();

    // 2. JAGA-JAGA: Jika $user null (user tidak login), arahkan ke login
    if (!$user) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // 3. Ambil data dengan aman karena $user dipastikan ada
    $notifications = Booking::with('room')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();

    // 4. Hitung statistik
    $total = $notifications->count();
    $pending = $notifications->where('status', 'menunggu')->count();
    $approved = $notifications->where('status', 'disetujui')->count();
    $rejected = $notifications->where('status', 'ditolak')->count();

    return view('user.notifikasi', compact('notifications', 'total', 'pending', 'approved', 'rejected'));
}
}