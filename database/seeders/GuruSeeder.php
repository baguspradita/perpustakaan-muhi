<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            [
                'nama'     => 'Drs. H. Ahmad Sahal',
                'email'    => 'ahmad.sahal@muhi.sch.id',
                'nip'      => '197001011995011001',
                'mapel'    => 'Pendidikan Agama Islam',
                'no_telp'  => '081234567890',
                'alamat'   => 'Yogyakarta, Indonesia',
            ],
            [
                'nama'     => 'Siti Aminah, S.Pd.',
                'email'    => 'siti.aminah@muhi.sch.id',
                'nip'      => '198205122010012005',
                'mapel'    => 'Bahasa Indonesia',
                'no_telp'  => '082134567812',
                'alamat'   => 'Bantul, Yogyakarta',
            ],
            [
                'nama'     => 'Bambang Triyadi, M.Kom.',
                'email'    => 'bambang.tri@muhi.sch.id',
                'nip'      => '199008202018011010',
                'mapel'    => 'Informatika',
                'no_telp'  => '085678901234',
                'alamat'   => 'Sleman, Yogyakarta',
            ],
        ];

        foreach ($gurus as $data) {
            $user = \App\Models\User::create([
                'nama'     => $data['nama'],
                'email'    => $data['email'],
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'no_telp'  => $data['no_telp'],
                'alamat'   => $data['alamat'],
                'role'     => 'guru',
            ]);

            \App\Models\Guru::create([
                'user_id' => $user->id,
                'nip'     => $data['nip'],
                'mapel'   => $data['mapel'],
            ]);
        }
    }
}
