<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fiksiId = \App\Models\KategoriBuku::where('nama_kategori', 'Fiksi')->first()->id;
        $sainsId = \App\Models\KategoriBuku::where('nama_kategori', 'Sains')->first()->id;
        $teknoId = \App\Models\KategoriBuku::where('nama_kategori', 'Teknologi')->first()->id;

        $books = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2005',
                'kategori_id' => $fiksiId,
                'jumlah' => 10,
            ],
            [
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2014',
                'kategori_id' => $fiksiId,
                'jumlah' => 5,
            ],
            [
                'judul' => 'Cosmos',
                'penulis' => 'Carl Sagan',
                'penerbit' => 'Random House',
                'tahun_terbit' => '1980',
                'kategori_id' => $sainsId,
                'jumlah' => 3,
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'penerbit' => 'Pearson',
                'tahun_terbit' => '2008',
                'kategori_id' => $teknoId,
                'jumlah' => 7,
            ],
            [
                'judul' => 'Pragmatic Programmer',
                'penulis' => 'Andrew Hunt',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => '1999',
                'kategori_id' => $teknoId,
                'jumlah' => 0, // Habis
            ],
        ];

        foreach ($books as $b) {
            \App\Models\Buku::create($b);
        }
    }
}
