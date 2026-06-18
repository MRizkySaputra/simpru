<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\User::create([
        'name' => 'Super Admin',
        'email' => 'admin@simpru.test',
        'password' => \Hash::make('password123'), // Kamu bisa ganti password-nya
        'role' => 'admin', // Sesuaikan dengan field role di database-mu
    ]);
}
}
