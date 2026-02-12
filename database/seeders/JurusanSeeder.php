<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = [
            ['nama_jurusan' => 'RPL', 'deskripsi' => 'Rekayasa Perangkat Lunak'],
            ['nama_jurusan' => 'TI', 'deskripsi' => 'Teknik Informatika'],
            ['nama_jurusan' => 'SI', 'deskripsi' => 'Sistem Informasi'],
            ['nama_jurusan' => 'AK', 'deskripsi' => 'Akuntansi'],
            ['nama_jurusan' => 'PM', 'deskripsi' => 'Pemasaran'],
        ];

        foreach ($jurusan as $j) {
            \App\Models\Jurusan::create($j);
        }
    }
}
