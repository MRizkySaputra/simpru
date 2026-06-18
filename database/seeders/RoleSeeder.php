<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin', 'icon' => 'admin_panel_settings', 'color' => 'red',
                'description' => 'Akses penuh ke seluruh fitur sistem termasuk manajemen pengguna, ruangan, dan laporan.',
                'permissions' => ['Kelola Pengguna', 'Kelola Role', 'Kelola Ruangan', 'Setujui Permohonan', 'Tolak Permohonan', 'Lihat Laporan', 'Kelola Jadwal', 'Lihat Jadwal Publik', 'Lihat Semua Riwayat']
            ],
            [
                'name' => 'Dosen', 'icon' => 'person_pin', 'color' => 'purple',
                'description' => 'Akses prioritas untuk peminjaman ruangan dengan persetujuan yang lebih cepat.',
                'permissions' => ['Ajukan Peminjaman', 'Lihat Jadwal Publik', 'Lihat Riwayat Sendiri']
            ],
            [
                'name' => 'Staf Akademik', 'icon' => 'badge', 'color' => 'blue',
                'description' => 'Akses peminjaman ruangan untuk kegiatan administratif dan akademik kampus.',
                'permissions' => ['Ajukan Peminjaman', 'Lihat Jadwal Publik', 'Lihat Riwayat Sendiri']
            ],
            [
                'name' => 'Mahasiswa', 'icon' => 'school', 'color' => 'emerald',
                'description' => 'Akses dasar untuk mengajukan permohonan peminjaman ruangan.',
                'permissions' => ['Ajukan Peminjaman', 'Lihat Jadwal Publik', 'Lihat Riwayat Sendiri']
            ],
            [
                'name' => 'Organisasi', 'icon' => 'groups', 'color' => 'orange',
                'description' => 'Akses peminjaman untuk kegiatan kemahasiswaan dan organisasi kampus.',
                'permissions' => ['Ajukan Peminjaman', 'Lihat Jadwal Publik', 'Lihat Riwayat Sendiri']
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}