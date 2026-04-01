<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rplId = Jurusan::where('nama_jurusan', 'RPL')->first()->id ?? 1;
        $tiId = Jurusan::where('nama_jurusan', 'TI')->first()->id ?? 2;

        $user1 = User::updateOrCreate(
            ['email' => 'budi@mail.com'],
            [
                'nama' => 'Budiman',
                'password' => Hash::make('password'),
                'alamat' => 'Jl. Merdeka No. 1',
                'no_telp' => '08123456789',
                'role' => 'siswa',
            ]
        );

        Siswa::updateOrCreate(
            ['user_id' => $user1->id],
            [
                'nisn' => '0011223344',
                'jurusan_id' => $rplId,
                'kelas' => '10',
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'susi@mail.com'],
            [
                'nama' => 'Susi Susanti',
                'password' => Hash::make('password'),
                'alamat' => 'Jl. Sudirman No. 10',
                'no_telp' => '08987654321',
                'role' => 'siswa',
            ]
        );

        Siswa::updateOrCreate(
            ['user_id' => $user2->id],
            [
                'nisn' => '0055667788',
                'jurusan_id' => $tiId,
                'kelas' => '11',
            ]
        );

        $user3 = User::updateOrCreate(
            ['email' => 'rendy@mail.com'],
            [
                'nama' => 'Ahmad Rendy',
                'password' => Hash::make('password'),
                'alamat' => 'Jl. Gajah Mada No. 5',
                'no_telp' => '087788990011',
                'role' => 'siswa',
            ]
        );

        Siswa::updateOrCreate(
            ['user_id' => $user3->id],
            [
                'nisn' => '0099001122',
                'jurusan_id' => $rplId,
                'kelas' => '12',
            ]
        );
    }
}
