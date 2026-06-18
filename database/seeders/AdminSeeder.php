<?php

namespace Database\Seeders;

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
            'email' => 'admin@simpru.com',
            'password' => \Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
