<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Fiksi', 'deskripsi' => 'Buku cerita rekaan'],
            ['nama_kategori' => 'Sains', 'deskripsi' => 'Buku ilmu pengetahuan alam'],
            ['nama_kategori' => 'Teknologi', 'deskripsi' => 'Buku perkembangan teknologi'],
            ['nama_kategori' => 'Sejarah', 'deskripsi' => 'Buku peristiwa masa lalu'],
        ];

        foreach ($categories as $c) {
            \App\Models\KategoriBuku::create($c);
        }
    }
}
