<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 1. ROLES =====
        $roles = [
            ['name' => 'Admin', 'icon' => 'admin_panel_settings', 'color' => 'red',
                'description' => 'Akses penuh ke seluruh fitur sistem.',
                'permissions' => ['Kelola Pengguna', 'Kelola Role', 'Kelola Ruangan', 'Setujui Permohonan', 'Tolak Permohonan', 'Lihat Laporan', 'Kelola Jadwal', 'Lihat Jadwal Publik', 'Lihat Semua Riwayat']],
            ['name' => 'Dosen', 'icon' => 'person_pin', 'color' => 'purple',
                'description' => 'Akses prioritas peminjaman ruangan.',
                'permissions' => ['Ajukan Peminjaman', 'Lihat Jadwal Publik', 'Lihat Riwayat Sendiri']],
            ['name' => 'Mahasiswa', 'icon' => 'school', 'color' => 'emerald',
                'description' => 'Akses dasar mengajukan peminjaman ruangan.',
                'permissions' => ['Ajukan Peminjaman', 'Lihat Jadwal Publik', 'Lihat Riwayat Sendiri']],
        ];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r['name']], $r);
        }

        // ===== 2. ADMIN =====
        $admin = User::firstOrCreate(
            ['email' => 'admin@simpru.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make(env('ADMIN_INITIAL_PASSWORD', 'Admin123!Demo')),
                'role' => 'admin',
                'identity_number' => 'ADM-0001',
                'is_active' => true,
            ]
        );

        // ===== 3. USER DUMMY (mahasiswa & dosen) =====
        $namaMahasiswa = ['Andi Saputra', 'Budi Santoso', 'Citra Lestari', 'Dewi Anggraini', 'Eko Prasetyo', 'Fitri Handayani', 'Gilang Ramadhan', 'Hana Permata'];
        $namaDosen = ['Dr. Hadi Wijaya', 'Prof. Siti Aminah', 'Dr. Rahmat Hidayat'];

        $users = collect();
        foreach ($namaMahasiswa as $i => $nama) {
            $users->push(User::firstOrCreate(
                ['email' => 'mhs' . ($i+1) . '@simpru.test'],
                [
                    'name' => $nama,
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa',
                    'identity_number' => '2026' . str_pad($i+1, 4, '0', STR_PAD_LEFT),
                    'is_active' => true,
                ]
            ));
        }
        foreach ($namaDosen as $i => $nama) {
            $users->push(User::firstOrCreate(
                ['email' => 'dosen' . ($i+1) . '@simpru.test'],
                [
                    'name' => $nama,
                    'password' => Hash::make('password123'),
                    'role' => 'dosen',
                    'identity_number' => 'NIDN' . str_pad($i+1, 4, '0', STR_PAD_LEFT),
                    'is_active' => true,
                ]
            ));
        }

        // ===== 4. RUANGAN =====
        $roomsData = [
            ['code' => 'R-001', 'name' => 'Aula Serbaguna Lt. 3', 'building_id' => 'A', 'capacity' => 150, 'facilities' => 'Sound System, AC Central, Panggung, Proyektor'],
            ['code' => 'R-002', 'name' => 'Ruang Sidang Utama', 'building_id' => 'A', 'capacity' => 30, 'facilities' => 'AC, Proyektor, Meja Rapat'],
            ['code' => 'R-003', 'name' => 'Laboratorium Komputer 1', 'building_id' => 'B', 'capacity' => 40, 'facilities' => 'PC, AC, Proyektor'],
            ['code' => 'R-004', 'name' => 'Ruang Seminar Ekonomi', 'building_id' => 'C', 'capacity' => 60, 'facilities' => 'AC, Sound System, Proyektor'],
            ['code' => 'R-005', 'name' => 'Ruang Kelas Teori 2.1', 'building_id' => 'B', 'capacity' => 35, 'facilities' => 'AC, Whiteboard, Proyektor'],
            ['code' => 'R-006', 'name' => 'Auditorium Kampus', 'building_id' => 'A', 'capacity' => 300, 'facilities' => 'Sound System Premium, AC Central, Panggung Utama'],
        ];

        $rooms = collect();
        foreach ($roomsData as $rd) {
            $rooms->push(Room::firstOrCreate(['code' => $rd['code']], $rd));
        }

        // ===== 5. BOOKING DUMMY (campuran status: menunggu, disetujui, ditolak) =====
        $aktivitas = [
            ['name' => 'Seminar Nasional Teknologi AI', 'type' => 'Fakultas'],
            ['name' => 'Rapat Koordinasi Ormawa', 'type' => 'Ormawa'],
            ['name' => 'Sidang Skripsi Genap 2026', 'type' => 'Sidang'],
            ['name' => 'Workshop Kewirausahaan', 'type' => 'Umum'],
            ['name' => 'Pelatihan Microsoft Office', 'type' => 'Fakultas'],
            ['name' => 'Diskusi Panel Ekonomi Digital', 'type' => 'Fakultas'],
            ['name' => 'Rapat Pleno BEM', 'type' => 'Ormawa'],
            ['name' => 'Ujian Komprehensif', 'type' => 'Sidang'],
        ];

        $statuses = ['menunggu', 'menunggu', 'disetujui', 'disetujui', 'disetujui', 'ditolak'];
        $jamMulai = [8, 9, 10, 13, 14, 15, 16];

        for ($i = 0; $i < 20; $i++) {
            $status = $statuses[array_rand($statuses)];
            $jam = $jamMulai[array_rand($jamMulai)];
            $aktv = $aktivitas[array_rand($aktivitas)];
            $tanggal = Carbon::now()->addDays(rand(-5, 14))->format('Y-m-d');

            $booking = Booking::create([
                'req_id' => 'REQ-' . Carbon::now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
                'user_id' => $users->random()->id,
                'room_id' => $rooms->random()->id,
                'date' => $tanggal,
                'start_time' => str_pad($jam, 2, '0', STR_PAD_LEFT) . ':00:00',
                'end_time' => str_pad($jam + 2, 2, '0', STR_PAD_LEFT) . ':00:00',
                'activity_type' => $aktv['type'],
                'activity_name' => $aktv['name'],
                'participants' => rand(15, 80),
                'document_path' => null,
            ]);

            $booking->status = $status;
            if ($status === 'ditolak') {
                $booking->rejection_reason = 'Jadwal bentrok dengan kegiatan kampus lainnya pada waktu yang sama.';
            }
            $booking->save();
        }

        $this->command->info('✅ Data dummy SIMPRU berhasil dibuat!');
        $this->command->info('Login admin: admin@simpru.test / ' . env('ADMIN_INITIAL_PASSWORD', 'Admin123!Demo'));
        $this->command->info('Login mahasiswa: mhs1@simpru.test / password123');
        $this->command->info('Login dosen: dosen1@simpru.test / password123');
    }
}
