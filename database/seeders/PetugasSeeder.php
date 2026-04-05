<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('password'),
                'alamat' => 'Perpustakaan Muhi',
                'no_telp' => '081234567890',
                'role' => 'petugas',
            ]
        );

        Petugas::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nip' => '197001012023011001',
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'petugas1@mail.com'],
            [
                'nama' => 'Petugas Satu',
                'password' => Hash::make('password'),
                'alamat' => 'Yogyakarta',
                'no_telp' => '081222333444',
                'role' => 'petugas',
            ]
        );

        Petugas::updateOrCreate(
            ['user_id' => $user2->id],
            [
                'nip' => '198505052023011002',
            ]
        );
    }
}
