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

        $approvedCount = Booking::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $pendingCount = Booking::where('user_id', $user->id)->where('status', 'menunggu')->count();
        $rejectedCount = Booking::where('user_id', $user->id)->where('status', 'ditolak')->count();

        $recentBookings = Booking::with('room')->where('user_id', $user->id)->latest()->take(3)->get();

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
        $booking = Booking::with('room')->findOrFail($id);

        return view('user.riwayat-detail', compact('booking'));
    }

    public function cetakBukti($id)
    {
        $booking = \App\Models\Booking::with('room')->findOrFail($id);

        if (Auth::user()->role !== 'admin' && $booking->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        if ($booking->status !== 'disetujui') {
            return back()->with('error', 'Permohonan belum disetujui.');
        }

        return view('user.cetak-bukti', compact('booking'));
    }

    public function profil()
    {
        $user = Auth::user();
        $totalBookings = Booking::where('user_id', $user->id)->count();

        return view('user.profil', compact('user', 'totalBookings'));
    }

    public function notifikasi()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $notifications = Booking::with('room')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();

        $total = $notifications->count();
        $pending = $notifications->where('status', 'menunggu')->count();
        $approved = $notifications->where('status', 'disetujui')->count();
        $rejected = $notifications->where('status', 'ditolak')->count();

        return view('user.notifikasi', compact('notifications', 'total', 'pending', 'approved', 'rejected'));
    }
}
