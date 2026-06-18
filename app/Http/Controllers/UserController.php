<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $approvedCount = Booking::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $pendingCount = Booking::where('user_id', $user->id)->where('status', 'menunggu')->count();
        $rejectedCount = Booking::where('user_id', $user->id)->where('status', 'ditolak')->count();

        $recentBookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $recommendedRooms = Room::inRandomOrder()->take(2)->get();

        return view('user.dashboard', compact(
            'approvedCount',
            'pendingCount',
            'rejectedCount',
            'recentBookings',
            'recommendedRooms'
        ));
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
        $booking = Booking::with('room')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.riwayat-detail', compact('booking'));
    }

    public function profil()
    {
        $user = Auth::user();
        $totalBookings = Booking::where('user_id', $user->id)->count();

        return view('user.profil', compact('user', 'totalBookings'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama tidak boleh kosong.',
            'email.required'     => 'Email tidak boleh kosong.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan akun lain.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function notifikasi()
    {
        $user = Auth::user();

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
