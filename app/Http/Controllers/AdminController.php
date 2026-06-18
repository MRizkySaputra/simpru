<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_ruangan' => Room::count(),
            'ruangan_tersedia' => Room::count(),
            'total_permohonan' => Booking::count(),
            'permohonan_menunggu' => Booking::where('status', 'menunggu')->count(),
            'total_disetujui' => Booking::where('status', 'disetujui')->count(),
            'total_ditolak' => Booking::where('status', 'ditolak')->count(),
        ];

        $totalBulanIni = Booking::whereMonth('created_at', date('m'))->count();
        $disetujuiBulanIni = Booking::whereMonth('created_at', date('m'))->where('status', 'disetujui')->count();
        $ditolakBulanIni = Booking::whereMonth('created_at', date('m'))->where('status', 'ditolak')->count();

        $stats['persentase_disetujui'] = $totalBulanIni > 0 ? '+' . round(($disetujuiBulanIni / $totalBulanIni) * 100) . '%' : '0%';
        $stats['persentase_ditolak'] = $totalBulanIni > 0 ? '-' . round(($ditolakBulanIni / $totalBulanIni) * 100) . '%' : '0%';

        $menungguList = Booking::with(['user', 'room'])
                        ->where('status', 'menunggu')
                        ->latest()
                        ->take(5)
                        ->get();

        $todaySchedule = Booking::with(['user', 'room'])
                        ->whereIn('status', ['disetujui', 'menunggu'])
                        ->whereDate('date', date('Y-m-d'))
                        ->orderBy('start_time')
                        ->take(6)
                        ->get();

        return view('admin.dashboard', compact('stats', 'menungguList', 'todaySchedule'));
    }

    public function ruangan()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::whereDoesntHave('bookings', function($q) {
            $q->where('status', 'disetujui')->whereDate('date', date('Y-m-d'));
        })->count();
        $activeBookingsToday = Booking::where('status', 'disetujui')->whereDate('date', date('Y-m-d'))->count();

        $rooms = Room::all();

        return view('admin.ruangan', compact('rooms', 'totalRooms', 'availableRooms', 'activeBookingsToday'));
    }

    public function storeRuangan(Request $request)
    {
        $maxId = \App\Models\Room::max('id') ?? 0;
        $newCode = 'R-' . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);

        while (\App\Models\Room::where('code', $newCode)->exists()) {
            $maxId++;
            $newCode = 'R-' . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
        }

        \App\Models\Room::create([
            'code'        => $newCode,
            'name'        => $request->name,
            'building_id' => $request->building_id,
            'capacity'    => $request->capacity,
            'facilities'  => $request->facilities,
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function updateRuangan(Request $request, $id)
    {
        $room = \App\Models\Room::findOrFail($id);

        $room->update([
            'name'        => $request->name,
            'building_id' => $request->building_id,
            'capacity'    => $request->capacity,
            'facilities'  => $request->facilities,
        ]);

        return redirect()->back()->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function deleteRuangan($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
    }

    public function permohonan(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::with(['user', 'room'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $permohonans = $query->get();

        return view('admin.permohonan', compact('permohonans', 'status'));
    }

    public function detailPermohonan($id)
    {
        $booking = Booking::with(['user', 'room'])->findOrFail($id);
        return view('admin.detail-permohonan', compact('booking'));
    }

    public function prosesPermohonan(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $action = $request->input('action');

        if ($action === 'setujui') {
            $booking->status = 'disetujui';
        } elseif ($action === 'tolak') {
            $booking->status = 'ditolak';
            $booking->rejection_reason = $request->input('alasan_penolakan');
        }

        $booking->save();

        return redirect('/admin/permohonan')->with('success', 'Status permohonan berhasil diperbarui.');
    }

    public function jadwal()
    {
        $rooms = Room::all()->map(function($r) {
            return [
                'code' => $r->code,
                'gedung' => $r->building_id,
                'name' => $r->name,
                'building' => 'Gedung ' . $r->building_id,
                'capacity' => $r->capacity
            ];
        });

        $dbBookings = Booking::with(['user', 'room'])
                        ->whereIn('status', ['menunggu', 'disetujui'])
                        ->get();

        $bookingsList = $dbBookings->map(function($b) {
            return [
                'roomCode' => $b->room ? $b->room->code : '',
                'gedung' => $b->room ? $b->room->building_id : '',
                'roomName' => $b->room ? $b->room->name : '',
                'startHour' => (int) substr($b->start_time, 0, 2),
                'endHour' => (int) substr($b->end_time, 0, 2),
                'status' => $b->status,
                'title' => $b->activity_name,
                'booker' => $b->user ? $b->user->name : '',
                'dateStr' => $b->date,
            ];
        });

        return view('admin.jadwal', compact('rooms', 'bookingsList'));
    }

    public function users(Request $request)
    {
        $totalUsersCount = \App\Models\User::count();
        $mahasiswaCount = \App\Models\User::where('role', 'mahasiswa')->count();
        $dosenCount = \App\Models\User::where('role', 'dosen')->count();
        $inactiveCount = \App\Models\User::where('is_active', false)->count();

        $query = \App\Models\User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('identity_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $statusVal = $request->status === 'active' ? true : false;
            $query->where('is_active', $statusVal);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users', compact('users', 'totalUsersCount', 'mahasiswaCount', 'dosenCount', 'inactiveCount'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'identity_number' => 'required|string|unique:users,identity_number',
            'role'            => 'required|in:mahasiswa,dosen,staf,organisasi,admin',
            'password'        => 'required|string|min:8',
        ]);

        \App\Models\User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'identity_number' => $validated['identity_number'],
            'role'            => $validated['role'],
            'password'        => bcrypt($validated['password']),
            'is_active'       => true,
        ]);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function changeRole(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->role = $request->role_change;
        $user->save();

        return back()->with('success', 'Role pengguna berhasil diubah!');
    }

    public function toggleStatus($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status pengguna berhasil diperbarui!');
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus permanen!');
    }

    public function laporan()
    {
        $total = Booking::count();
        $disetujui = Booking::where('status', 'disetujui')->count();
        $menunggu = Booking::where('status', 'menunggu')->count();
        $ditolak = Booking::where('status', 'ditolak')->count();

        $bars = [
            ['label' => 'Fakultas', 'value' => Booking::where('activity_type', 'Fakultas')->count(), 'height' => 80],
            ['label' => 'Ormawa', 'value' => Booking::where('activity_type', 'Ormawa')->count(), 'height' => 60],
            ['label' => 'Umum', 'value' => Booking::where('activity_type', 'Umum')->count(), 'height' => 45],
        ];

        $riwayats = Booking::with(['user', 'room'])->latest()->paginate(10);

        return view('admin.laporan', compact('total', 'disetujui', 'menunggu', 'ditolak', 'bars', 'riwayats'));
    }

    public function notifikasi()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        return view('admin.notifikasi', compact('notifications'));
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
