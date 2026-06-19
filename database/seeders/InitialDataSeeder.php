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
        User::create([
            'name' => 'Admin SIMPRU',
            'email' => 'admin@simpru.com',
            'password' => Hash::make(env('ADMIN_INITIAL_PASSWORD', 'GantiSegera123!')),
            'role' => 'admin',
            'identity_number' => '12345678',
            'is_active' => true,
        ]);

        $gedungA = Building::create([
            'name' => 'Gedung Kuliah Bersama (GKB)',
            'description' => 'Gedung utama perkuliahan',
        ]);

        Room::create([
            'building_id' => $gedungA->id,
            'code' => 'LAB-01',
            'name' => 'Laboratorium Komputer',
            'capacity' => 40,
        ]);
    }
}
