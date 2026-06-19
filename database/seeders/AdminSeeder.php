<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@simpru.test',
            'password' => Hash::make(env('ADMIN_INITIAL_PASSWORD', 'GantiSegera123!')),
            'role' => 'admin',
        ]);
    }
}
