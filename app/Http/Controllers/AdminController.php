<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'identity_number' => 'required|string|unique:users,identity_number',
            'role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $safeRole = strtolower(explode(' ', $validated['role'])[0]);

        \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'identity_number' => $validated['identity_number'],
            'role' => $safeRole,
            'password' => bcrypt($validated['password']),
            'is_active' => true,
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

    public function roles()
    {
        $roles = \App\Models\Role::withCount('users')->get();

        $allPermissions = [
            'Ajukan Peminjaman', 'Lihat Jadwal Publik', 'Lihat Riwayat Sendiri',
            'Setujui Permohonan', 'Tolak Permohonan', 'Kelola Ruangan',
            'Kelola Pengguna', 'Kelola Role', 'Lihat Semua Riwayat', 'Export Laporan'
        ];

        return view('admin.roles', compact('roles', 'allPermissions'));
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        \App\Models\Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'permissions' => $validated['permissions'] ?? [],
            'icon' => 'verified_user',
            'color' => 'blue',
        ]);

        return back()->with('success', 'Role baru berhasil ditambahkan!');
    }

    public function updateRole(Request $request, $id)
    {
        $role = \App\Models\Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'permissions' => $validated['permissions'] ?? [],
        ]);

        return back()->with('success', 'Role dan hak akses berhasil diperbarui!');
    }

    public function deleteRole($id)
    {
        $role = \App\Models\Role::findOrFail($id);

        if (strtolower($role->name) === 'admin') {
            return back()->with('error', 'Role Admin tidak dapat dihapus dari sistem!');
        }

        $role->delete();
        return back()->with('success', 'Role berhasil dihapus!');
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
        $notifications = \App\Models\AdminNotification::latest()->get();
        $total = $notifications->count();

        return view('admin.notifikasi', compact('notifications', 'total'));
    }

    public function readAll()
    {
        \App\Models\AdminNotification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi sistem telah ditandai sebagai dibaca.');
    }

    public function settings()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $files = Storage::disk('local')->files('Laravel');

        return view('admin.settings', compact('settings', 'files'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except(['_token', 'app_logo', 'app_favicon']);

        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'app_logo'], ['value' => $path]);
        }

        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'app_favicon'], ['value' => $path]);
        }

        return back()->with('success', 'Semua pengaturan berhasil disimpan ke database!');
    }

    public function clearCache()
    {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return back()->with('success', 'Cache sistem berhasil dibersihkan! Performa aplikasi kembali optimal.');
    }

    public function createBackup()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('backup:run --only-db');
            return back()->with('success', 'Backup database berhasil dibuat! File tersimpan di folder storage.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal backup: ' . $e->getMessage());
        }
    }

    public function toggleMaintenance()
    {
        $current = \App\Models\Setting::where('key', 'maintenance_mode')->first();
        $newStatus = ($current && $current->value == '1') ? '0' : '1';

        \App\Models\Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $newStatus]);

        $msg = $newStatus == '1' ? 'Mode Maintenance AKTIF! User tidak bisa login sementara.' : 'Mode Maintenance DIMATIKAN! Sistem kembali normal.';
        return back()->with('success', $msg);
    }

    public function resetData()
    {
        \App\Models\Booking::query()->delete();
        \App\Models\AdminNotification::query()->delete();

        return back()->with('success', 'ZONA BERBAHAYA: Seluruh data riwayat peminjaman dan notifikasi berhasil dihapus permanen!');
    }

    public function factoryReset()
    {
        \App\Models\Setting::truncate();
        return back()->with('success', 'ZONA BERBAHAYA: Seluruh pengaturan aplikasi telah dikembalikan ke setelan pabrik!');
    }
}
