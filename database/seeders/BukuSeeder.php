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

        // Ambil ID subjek yang tersedia
        $sastraId = \App\Models\SubjekBuku::where('kode_ddc', '800')->first()->id;
        $sainsSubjekId = \App\Models\SubjekBuku::where('kode_ddc', '500')->first()->id;
        $komputerId = \App\Models\SubjekBuku::where('kode_ddc', '000')->first()->id;

        // Ambil ID lokasi yang tersedia
        $rakFiksi = \App\Models\Lokasi::where('nama_lokasi', 'Rak A1')->first()->id;
        $rakSains = \App\Models\Lokasi::where('nama_lokasi', 'Rak A2')->first()->id;
        $rakPelajaran = \App\Models\Lokasi::where('nama_lokasi', 'Rak B1')->first()->id;
        $rakReferensi = \App\Models\Lokasi::where('nama_lokasi', 'Rak B2')->first()->id;
        $lemariKaca = \App\Models\Lokasi::where('nama_lokasi', 'Lemari Kaca 01')->first()->id;

        $books = [
            // Kategori Fiksi (Subjek: 800 - Sastra)
            [
                'judul' => 'Laskar Pelangi',
                'nama_depan_penulis' => 'Andrea',
                'nama_belakang_penulis' => 'Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2005',
                'kategori_id' => $fiksiId,
                'subjek_id' => $sastraId,
                'lokasi_id' => $rakFiksi,
                'jumlah' => 10,
            ],
            [
                'judul' => 'Bumi',
                'nama_depan_penulis' => 'Tere',
                'nama_belakang_penulis' => 'Liye',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2014',
                'kategori_id' => $fiksiId,
                'subjek_id' => $sastraId,
                'lokasi_id' => $rakFiksi,
                'jumlah' => 8,
            ],
            [
                'judul' => 'Kuliner Nusantara',
                'nama_depan_penulis' => 'Habiburrahman',
                'nama_belakang_penulis' => 'El Shirazy',
                'penerbit' => 'Republika',
                'tahun_terbit' => '2016',
                'kategori_id' => $fiksiId,
                'subjek_id' => $sastraId,
                'lokasi_id' => $lemariKaca,
                'jumlah' => 6,
            ],
            [
                'judul' => 'Negeri Para Bedebah',
                'nama_depan_penulis' => 'Tere',
                'nama_belakang_penulis' => 'Liye',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2015',
                'kategori_id' => $fiksiId,
                'subjek_id' => $sastraId,
                'lokasi_id' => $rakFiksi,
                'jumlah' => 7,
            ],
            [
                'judul' => 'Sang Pemimpi',
                'nama_depan_penulis' => 'Andrea',
                'nama_belakang_penulis' => 'Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2006',
                'kategori_id' => $fiksiId,
                'subjek_id' => $sastraId,
                'lokasi_id' => $rakFiksi,
                'jumlah' => 5,
            ],
            [
                'judul' => 'Malam Minggu di Manthili',
                'nama_depan_penulis' => 'Nugroho',
                'nama_belakang_penulis' => 'Notosusanto',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2008',
                'kategori_id' => $fiksiId,
                'subjek_id' => $sastraId,
                'lokasi_id' => $rakFiksi,
                'jumlah' => 4,
            ],
            [
                'judul' => 'Ayat-ayat Cinta',
                'nama_depan_penulis' => 'Habiburrahman',
                'nama_belakang_penulis' => 'El Shirazy',
                'penerbit' => 'Republika',
                'tahun_terbit' => '2004',
                'kategori_id' => $fiksiId,
                'subjek_id' => $sastraId,
                'lokasi_id' => $rakFiksi,
                'jumlah' => 12,
            ],
            
            // Kategori Sains (Subjek: 500 - Sains)
            [
                'judul' => 'Cosmos',
                'nama_depan_penulis' => 'Carl',
                'nama_belakang_penulis' => 'Sagan',
                'penerbit' => 'Random House',
                'tahun_terbit' => '1980',
                'kategori_id' => $sainsId,
                'subjek_id' => $sainsSubjekId,
                'lokasi_id' => $rakSains,
                'jumlah' => 3,
            ],
            [
                'judul' => 'A Brief History of Time',
                'nama_depan_penulis' => 'Stephen',
                'nama_belakang_penulis' => 'Hawking',
                'penerbit' => 'Bantam Books',
                'tahun_terbit' => '1988',
                'kategori_id' => $sainsId,
                'subjek_id' => $sainsSubjekId,
                'lokasi_id' => $rakSains,
                'jumlah' => 5,
            ],
            [
                'judul' => 'Alam Semesta dalam Sepucuk Surat',
                'nama_depan_penulis' => 'Carl',
                'nama_belakang_penulis' => 'Sagan',
                'penerbit' => 'Pustaka Populer Obor',
                'tahun_terbit' => '1997',
                'kategori_id' => $sainsId,
                'subjek_id' => $sainsSubjekId,
                'lokasi_id' => $rakSains,
                'jumlah' => 4,
            ],
            [
                'judul' => 'Materi dan Energi',
                'nama_depan_penulis' => 'Albert',
                'nama_belakang_penulis' => 'Einstein',
                'penerbit' => 'Physics Today',
                'tahun_terbit' => '1945',
                'kategori_id' => $sainsId,
                'subjek_id' => $sainsSubjekId,
                'lokasi_id' => $rakReferensi,
                'jumlah' => 2,
            ],
            [
                'judul' => 'Biologi Dasar',
                'nama_depan_penulis' => 'Neil',
                'nama_belakang_penulis' => 'Campbell',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => '2010',
                'kategori_id' => $sainsId,
                'subjek_id' => $sainsSubjekId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 8,
            ],
            [
                'judul' => 'Kimia Organik',
                'nama_depan_penulis' => 'T.W.',
                'nama_belakang_penulis' => 'Graham Solomons',
                'penerbit' => 'John Wiley & Sons',
                'tahun_terbit' => '2011',
                'kategori_id' => $sainsId,
                'subjek_id' => $sainsSubjekId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 6,
            ],

            // Kategori Teknologi (Subjek: 000 - Komputer)
            [
                'judul' => 'Clean Code',
                'nama_depan_penulis' => 'Robert',
                'nama_belakang_penulis' => 'Martin',
                'penerbit' => 'Pearson',
                'tahun_terbit' => '2008',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 7,
            ],
            [
                'judul' => 'Pragmatic Programmer',
                'nama_depan_penulis' => 'Andrew',
                'nama_belakang_penulis' => 'Hunt',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => '1999',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 5,
            ],
            [
                'judul' => 'Design Patterns',
                'nama_depan_penulis' => 'Gang',
                'nama_belakang_penulis' => 'of Four',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => '1994',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 3,
            ],
            [
                'judul' => 'The Art of Computer Programming',
                'nama_depan_penulis' => 'Donald',
                'nama_belakang_penulis' => 'Knuth',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => '1968',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 2,
            ],
            [
                'judul' => 'Introduction to Algorithms',
                'nama_depan_penulis' => 'Thomas',
                'nama_belakang_penulis' => 'Cormen',
                'penerbit' => 'MIT Press',
                'tahun_terbit' => '2009',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 6,
            ],
            [
                'judul' => 'Web Development with Node.js',
                'nama_depan_penulis' => 'Mike',
                'nama_belakang_penulis' => 'Cantelon',
                'penerbit' => 'Manning Publications',
                'tahun_terbit' => '2013',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 4,
            ],
            [
                'judul' => 'Mastering Laravel',
                'nama_depan_penulis' => 'Samuel',
                'nama_belakang_penulis' => 'Nyongesa',
                'penerbit' => 'Packt Publishing',
                'tahun_terbit' => '2017',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 8,
            ],
            [
                'judul' => 'Python for Data Analysis',
                'nama_depan_penulis' => 'Wes',
                'nama_belakang_penulis' => 'McKinney',
                'penerbit' => "O'Reilly Media",
                'tahun_terbit' => '2017',
                'kategori_id' => $teknoId,
                'subjek_id' => $komputerId,
                'lokasi_id' => $rakPelajaran,
                'jumlah' => 9,
            ],
        ];

        foreach ($books as $b) {
            // Extract huruf pertama dari judul (non-spasi)
            $hurufPertama = $this->extractFirstLetter($b['judul']);
            
            // Gabungkan nama penulis
            $namaPenulis = trim($b['nama_depan_penulis'] . ' ' . $b['nama_belakang_penulis']);
            
            // Generate nomor salinan untuk setiap copy
            $jumlah = $b['jumlah'];
            unset($b['jumlah'], $b['nama_depan_penulis'], $b['nama_belakang_penulis']); // Hapus field yang tidak perlu
            
            for ($i = 1; $i <= $jumlah; $i++) {
                $copy = $b;
                $copy['huruf_judul_awal'] = $hurufPertama;
                $copy['nama_penulis'] = $namaPenulis;
                $copy['nomor_salinan'] = "c.$i";
                $copy['jumlah'] = 1; // Setiap copy adalah satu item
                $copy['status'] = 'aktif';
                \App\Models\Buku::create($copy);
            }
        }
    }

    /**
     * Extract huruf pertama dari string (non-whitespace)
     */
    private function extractFirstLetter($text)
    {
        // Ambil karakter pertama yang bukan whitespace
        if (empty($text)) {
            return '?';
        }
        
        $text = trim($text);
        if (empty($text)) {
            return '?';
        }
        
        return strtoupper($text[0]);
    }
}
