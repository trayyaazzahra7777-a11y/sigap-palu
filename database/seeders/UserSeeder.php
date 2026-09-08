<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin (Full Access)
        User::updateOrCreate(
            ['email' => 'admin@sigappalu.com'],
            [
                'name' => 'Administrator SIGAP',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        // 2. Akun Operator (Input Data & Verifikasi)
        User::updateOrCreate(
            ['email' => 'operator@sigappalu.com'],
            [
                'name' => 'Petugas Posko Palu',
                'password' => Hash::make('operator123'),
                'role' => 'operator',
                'status' => 'aktif',
            ]
        );

        // 3. Akun User (Masyarakat/Mahasiswa/Peneliti)
        User::updateOrCreate(
            ['email' => 'trayyaazzahra7777@gmail.com'],
            [
                'name' => 'Trayya Azzahra Baso',
                'password' => Hash::make('Trayya777'),
                'role' => 'user',
                'status' => 'aktif',
            ]
        );
    }
}
