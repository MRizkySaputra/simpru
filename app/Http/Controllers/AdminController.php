<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Building;
use App\Models\Booking;
use Illuminate\Http\Request;

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
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
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
    // Mengambil notifikasi milik admin (atau global) yang terbaru
    $notifications = auth()->user()->notifications()->latest()->paginate(10);
    
    return view('admin.notifikasi', compact('notifications'));
}

// Fungsi untuk menandai semua dibaca
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