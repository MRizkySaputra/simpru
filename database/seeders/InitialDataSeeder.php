<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin SIMPRU',
            'email' => 'admin@simpru.com',
            'password' => Hash::make('password123'), 
            'role' => 'admin',
            'nim_nidn' => '12345678',
            'phone_number' => '081234567890',
        ]);

        // 2. Buat Contoh Gedung
        $gedungA = Building::create([
            'name' => 'Gedung Kuliah Bersama (GKB)',
            'description' => 'Gedung utama perkuliahan',
        ]);

        // 3. Buat Contoh Ruangan
        Room::create([
            'building_id' => $gedungA->id,
            'code' => 'LAB-01',
            'name' => 'Laboratorium Komputer',
            'capacity' => 40,
        ]);
    }
}