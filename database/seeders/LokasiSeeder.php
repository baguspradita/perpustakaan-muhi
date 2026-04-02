<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasi = [
            ['nama_lokasi' => 'Rak A1', 'keterangan' => 'Koleksi Fiksi'],
            ['nama_lokasi' => 'Rak A2', 'keterangan' => 'Koleksi Non-Fiksi'],
            ['nama_lokasi' => 'Rak B1', 'keterangan' => 'Buku Pelajaran'],
            ['nama_lokasi' => 'Rak B2', 'keterangan' => 'Buku Referensi'],
            ['nama_lokasi' => 'Lemari Kaca 01', 'keterangan' => 'Koleksi Langka / Majalah'],
        ];

        foreach ($lokasi as $data) {
            \App\Models\Lokasi::create($data);
        }
    }
}
