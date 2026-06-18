<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Building;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // 1. Halaman Dashboard Admin
    public function dashboard()
    {
        // 1. Hitung Statistik Utama
        $stats = [
            'total_ruangan' => Room::count(),
            'ruangan_tersedia' => Room::count(), // Idealnya ini dihitung berdasarkan jadwal kosong
            'total_permohonan' => Booking::count(),
            'permohonan_menunggu' => Booking::where('status', 'menunggu')->count(),
            'total_disetujui' => Booking::where('status', 'disetujui')->count(),
            'total_ditolak' => Booking::where('status', 'ditolak')->count(),
        ];

        // 2. Hitung Persentase Disetujui & Ditolak (Bulan Ini)
        $totalBulanIni = Booking::whereMonth('created_at', date('m'))->count();
        $disetujuiBulanIni = Booking::whereMonth('created_at', date('m'))->where('status', 'disetujui')->count();
        $ditolakBulanIni = Booking::whereMonth('created_at', date('m'))->where('status', 'ditolak')->count();

        $stats['persentase_disetujui'] = $totalBulanIni > 0 ? '+' . round(($disetujuiBulanIni / $totalBulanIni) * 100) . '%' : '0%';
        $stats['persentase_ditolak'] = $totalBulanIni > 0 ? '-' . round(($ditolakBulanIni / $totalBulanIni) * 100) . '%' : '0%';

        // 3. Ambil Daftar Permohonan yang Masih "Menunggu"
        $menungguList = Booking::with(['user', 'room'])
                        ->where('status', 'menunggu')
                        ->latest()
                        ->take(5)
                        ->get();

        // 4. Jadwal Hari Ini (Semua permohonan yang disetujui/menunggu untuk hari ini)
        $todaySchedule = Booking::with(['user', 'room'])
                        ->whereIn('status', ['disetujui', 'menunggu'])
                        ->whereDate('date', date('Y-m-d'))
                        ->orderBy('start_time')
                        ->take(6)
                        ->get();

        return view('admin.dashboard', compact('stats', 'menungguList', 'todaySchedule'));
    }
    // 2. Halaman Manajemen Ruangan
    public function ruangan()
{
    // Mengambil data statistik
    $totalRooms = Room::count();
    $availableRooms = Room::whereDoesntHave('bookings', function($q) {
        $q->where('status', 'disetujui')->whereDate('date', date('Y-m-d'));
    })->count();
    $activeBookingsToday = Booking::where('status', 'disetujui')->whereDate('date', date('Y-m-d'))->count();

    // Mengambil semua data ruangan
    $rooms = Room::all();

    return view('admin.ruangan', compact('rooms', 'totalRooms', 'availableRooms', 'activeBookingsToday'));
}

    public function storeRuangan(Request $request)
{
    // 1. Ambil ID tertinggi dari tabel ruangan saat ini
    $maxId = \App\Models\Room::max('id') ?? 0;
    
    // 2. Buat kandidat kode baru
    $newCode = 'R-' . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);

    // 3. (Penjaga Gawang) Pastikan kodenya benar-benar belum dipakai!
    // Jika ternyata sudah ada, sistem akan terus menambah angkanya sampai ketemu yang kosong
    while (\App\Models\Room::where('code', $newCode)->exists()) {
        $maxId++;
        $newCode = 'R-' . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
    }

    // 4. Simpan ke database
    \App\Models\Room::create([
        'code'        => $newCode,
        'name'        => $request->name,
        'building_id' => $request->building_id,
        'capacity'    => $request->capacity,
        'facilities'  => $request->facilities,
    ]);

    return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');

    }public function updateRuangan(Request $request, $id)
{
    // Cari ruangan berdasarkan ID
    $room = \App\Models\Room::findOrFail($id);

    // Update data ruangan
    $room->update([
        'name'        => $request->name,
        'building_id' => $request->building_id,
        'capacity'    => $request->capacity,
        'facilities'  => $request->facilities,
    ]);

    // Kembalikan ke halaman ruangan dengan pesan sukses
    return redirect()->back()->with('success', 'Data ruangan berhasil diperbarui!');
}

    public function deleteRuangan($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
    }

    // 3. Halaman Permohonan Masuk
    public function permohonan(Request $request)
    {
        $status = $request->query('status'); // Bisa 'menunggu', 'disetujui', 'ditolak'
        
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
        $action = $request->input('action'); // 'setujui' atau 'tolak'

        if ($action === 'setujui') {
            $booking->status = 'disetujui';
        } elseif ($action === 'tolak') {
            $booking->status = 'ditolak';
            $booking->rejection_reason = $request->input('alasan_penolakan');
        }

        $booking->save();

        return redirect('/admin/permohonan')->with('success', 'Status permohonan berhasil diperbarui.');
    }

    // 4. Halaman Jadwal Ruangan
    public function jadwal()
    {
        // 1. Ambil data ruangan
        $rooms = Room::all()->map(function($r) {
            return [
                'code' => $r->code,
                'gedung' => $r->building_id,
                'name' => $r->name,
                'building' => 'Gedung ' . $r->building_id,
                'capacity' => $r->capacity
            ];
        });

        // 2. Ambil data permohonan yang disetujui & menunggu
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

    // 5. Halaman Manajemen Pengguna
    public function users(Request $request)
    {
        // 1. Hitung statistik untuk kartu
        $totalUsersCount = \App\Models\User::count();
        $mahasiswaCount = \App\Models\User::where('role', 'mahasiswa')->count();
        $dosenCount = \App\Models\User::where('role', 'dosen')->count();
        $inactiveCount = \App\Models\User::where('is_active', false)->count();

        // 2. Query data user + fitur pencarian & filter
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

        // Pastikan role disingkat/diseragamkan ke format standar sistem jika ada perbedaan ENUM
        // Mengambil kata pertama saja dan dijadikan lowercase (misal: "Staf Akademik" jadi "staf")
        $safeRole = strtolower(explode(' ', $validated['role'])[0]);

        \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'identity_number' => $validated['identity_number'],
            'role' => $safeRole, // Pakai role yang sudah diseragamkan
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

    // Halaman Manajemen Role
    public function roles()
    {
        // Mengambil semua role dari database beserta hitungan usernya
        $roles = \App\Models\Role::withCount('users')->get();
        
        // Daftar semua fitur/izin yang ada di aplikasi SIMPRU
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
            'icon' => 'verified_user', // Icon default
            'color' => 'blue', // Warna default
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
        
        // Mencegah akun Admin terhapus secara tidak sengaja
        if (strtolower($role->name) === 'admin') {
            return back()->with('error', 'Role Admin tidak dapat dihapus dari sistem!');
        }
        
        $role->delete();
        return back()->with('success', 'Role berhasil dihapus!');
    }

    // 6. Halaman Laporan & Settings (Statis Sementara)
    public function laporan()
{
    // 1. Hitung data untuk Donut Chart (Distribusi Status)
    $total = Booking::count();
    $disetujui = Booking::where('status', 'disetujui')->count();
    $menunggu = Booking::where('status', 'menunggu')->count();
    $ditolak = Booking::where('status', 'ditolak')->count();

    // 2. Data Bar Chart (Volume per bulan atau tipe - di sini contoh per tipe)
    // Kamu bisa sesuaikan query-nya dengan kebutuhan
    $bars = [
        ['label' => 'Fakultas', 'value' => Booking::where('activity_type', 'Fakultas')->count(), 'height' => 80],
        ['label' => 'Ormawa', 'value' => Booking::where('activity_type', 'Ormawa')->count(), 'height' => 60],
        ['label' => 'Umum', 'value' => Booking::where('activity_type', 'Umum')->count(), 'height' => 45],
    ];

    // 3. Ambil riwayat lengkap dengan pagination
    $riwayats = Booking::with(['user', 'room'])->latest()->paginate(10);

    return view('admin.laporan', compact('total', 'disetujui', 'menunggu', 'ditolak', 'bars', 'riwayats'));
}

    public function notifikasi()
{
    // Ambil semua notifikasi admin, urutkan dari yang terbaru
    $notifications = \App\Models\AdminNotification::latest()->get();
    
    // Hitung total notifikasi
    $total = $notifications->count();
    
    return view('admin.notifikasi', compact('notifications', 'total'));
}

// Fungsi untuk menandai semua dibaca
    public function readAll()
    {
        // Ubah status is_read menjadi true untuk semua notifikasi yang belum dibaca
        \App\Models\AdminNotification::where('is_read', false)->update(['is_read' => true]);
        
        return back()->with('success', 'Semua notifikasi sistem telah ditandai sebagai dibaca.');
    }

   public function settings()
{
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    
    // Ambil list file di folder backup
    $files = Storage::disk('local')->files('Laravel'); 
    
    return view('admin.settings', compact('settings', 'files'));
}

    public function updateSettings(Request $request)
    {
        // Ambil semua input KECUALI token CSRF dan file logo/favicon
        $data = $request->except(['_token', 'app_logo', 'app_favicon']);

        // Simpan setiap inputan ke tabel (Kalau sudah ada di-update, kalau belum dibuat baru)
        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Khusus upload file Logo
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'app_logo'], ['value' => $path]);
        }

        // Khusus upload file Favicon
        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'app_favicon'], ['value' => $path]);
        }

        return back()->with('success', 'Semua pengaturan berhasil disimpan ke database!');
    }

    // ==========================================
    // FUNGSI SISTEM & ZONA BERBAHAYA
    // ==========================================

    public function clearCache()
    {
        // Mengeksekusi perintah terminal langsung dari PHP
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return back()->with('success', 'Cache sistem berhasil dibersihkan! Performa aplikasi kembali optimal.');
    }

    public function createBackup()
    {
        try {
            // Menjalankan backup database saja
            \Illuminate\Support\Facades\Artisan::call('backup:run --only-db');
            return back()->with('success', 'Backup database berhasil dibuat! File tersimpan di folder storage.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal backup: ' . $e->getMessage());
        }
    }

    public function toggleMaintenance()
    {
        // Mengubah status maintenance di tabel settings (Aman, tidak me-lockout admin)
        $current = \App\Models\Setting::where('key', 'maintenance_mode')->first();
        $newStatus = ($current && $current->value == '1') ? '0' : '1';
        
        \App\Models\Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $newStatus]);
        
        $msg = $newStatus == '1' ? 'Mode Maintenance AKTIF! User tidak bisa login sementara.' : 'Mode Maintenance DIMATIKAN! Sistem kembali normal.';
        return back()->with('success', $msg);
    }

    public function resetData()
    {
        // Menghapus seluruh riwayat peminjaman (aman dari error foreign key)
        \App\Models\Booking::query()->delete();
        
        // Opsional: Hapus notifikasi juga biar bersih
        \App\Models\AdminNotification::query()->delete();

        return back()->with('success', 'ZONA BERBAHAYA: Seluruh data riwayat peminjaman dan notifikasi berhasil dihapus permanen!');
    }

    public function factoryReset()
    {
        // Menghapus seluruh konfigurasi agar kembali ke setelan awal
        \App\Models\Setting::truncate();
        return back()->with('success', 'ZONA BERBAHAYA: Seluruh pengaturan aplikasi telah dikembalikan ke setelan pabrik!');
    }
}