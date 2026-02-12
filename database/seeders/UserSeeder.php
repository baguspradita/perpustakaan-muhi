<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Petugas
        \App\Models\User::create([
            'nama' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'petugas',
        ]);

        $rplId = \App\Models\Jurusan::where('nama_jurusan', 'RPL')->first()->id;
        $tkjId = \App\Models\Jurusan::where('nama_jurusan', 'TI')->first()->id;

        // Siswa 1
        \App\Models\User::create([
            'nama' => 'Budiman',
            'email' => 'budi@mail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'alamat' => 'Jl. Merdeka No. 1',
            'no_telp' => '08123456789',
            'role' => 'siswa',
            'jurusan_id' => $rplId,
            'kelas' => '10',
        ]);

        // Siswa 2
        \App\Models\User::create([
            'nama' => 'Susi',
            'email' => 'susi@mail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'alamat' => 'Jl. Sudirman No. 10',
            'no_telp' => '08987654321',
            'role' => 'siswa',
            'jurusan_id' => $tkjId,
            'kelas' => '11',
        ]);
    }
}
