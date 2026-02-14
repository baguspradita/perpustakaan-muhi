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
            // Kategori Fiksi
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
                'jumlah' => 8,
            ],
            [
                'judul' => 'Kuliner Nusantara',
                'penulis' => 'Habiburrahman El Shirazy',
                'penerbit' => 'Republika',
                'tahun_terbit' => '2016',
                'kategori_id' => $fiksiId,
                'jumlah' => 6,
            ],
            [
                'judul' => 'Negeri Para Bedebah',
                'penulis' => 'Tere Liye',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2015',
                'kategori_id' => $fiksiId,
                'jumlah' => 7,
            ],
            [
                'judul' => 'Sang Pemimpi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2006',
                'kategori_id' => $fiksiId,
                'jumlah' => 5,
            ],
            [
                'judul' => 'Malam Minggu di Manthili',
                'penulis' => 'Nugroho Notosusanto',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2008',
                'kategori_id' => $fiksiId,
                'jumlah' => 4,
            ],
            [
                'judul' => 'Ayat-ayat Cinta',
                'penulis' => 'Habiburrahman El Shirazy',
                'penerbit' => 'Republika',
                'tahun_terbit' => '2004',
                'kategori_id' => $fiksiId,
                'jumlah' => 12,
            ],
            
            // Kategori Sains
            [
                'judul' => 'Cosmos',
                'penulis' => 'Carl Sagan',
                'penerbit' => 'Random House',
                'tahun_terbit' => '1980',
                'kategori_id' => $sainsId,
                'jumlah' => 3,
            ],
            [
                'judul' => 'A Brief History of Time',
                'penulis' => 'Stephen Hawking',
                'penerbit' => 'Bantam Books',
                'tahun_terbit' => '1988',
                'kategori_id' => $sainsId,
                'jumlah' => 5,
            ],
            [
                'judul' => 'Alam Semesta dalam Sepucuk Surat',
                'penulis' => 'Carl Sagan',
                'penerbit' => 'Pustaka Populer Obor',
                'tahun_terbit' => '1997',
                'kategori_id' => $sainsId,
                'jumlah' => 4,
            ],
            [
                'judul' => 'Materi dan Energi',
                'penulis' => 'Albert Einstein',
                'penerbit' => 'Physics Today',
                'tahun_terbit' => '1945',
                'kategori_id' => $sainsId,
                'jumlah' => 2,
            ],
            [
                'judul' => 'Biologi Dasar',
                'penulis' => 'Neil A. Campbell',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => '2010',
                'kategori_id' => $sainsId,
                'jumlah' => 8,
            ],
            [
                'judul' => 'Kimia Organik',
                'penulis' => 'T.W. Graham Solomons',
                'penerbit' => 'John Wiley & Sons',
                'tahun_terbit' => '2011',
                'kategori_id' => $sainsId,
                'jumlah' => 6,
            ],

            // Kategori Teknologi
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
                'jumlah' => 5,
            ],
            [
                'judul' => 'Design Patterns',
                'penulis' => 'Gang of Four',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => '1994',
                'kategori_id' => $teknoId,
                'jumlah' => 3,
            ],
            [
                'judul' => 'The Art of Computer Programming',
                'penulis' => 'Donald E. Knuth',
                'penerbit' => 'Addison-Wesley',
                'tahun_terbit' => '1968',
                'kategori_id' => $teknoId,
                'jumlah' => 2,
            ],
            [
                'judul' => 'Introduction to Algorithms',
                'penulis' => 'Thomas H. Cormen',
                'penerbit' => 'MIT Press',
                'tahun_terbit' => '2009',
                'kategori_id' => $teknoId,
                'jumlah' => 6,
            ],
            [
                'judul' => 'Web Development with Node.js',
                'penulis' => 'Mike Cantelon',
                'penerbit' => 'Manning Publications',
                'tahun_terbit' => '2013',
                'kategori_id' => $teknoId,
                'jumlah' => 4,
            ],
            [
                'judul' => 'Mastering Laravel',
                'penulis' => 'Samuel Nyongesa',
                'penerbit' => 'Packt Publishing',
                'tahun_terbit' => '2017',
                'kategori_id' => $teknoId,
                'jumlah' => 8,
            ],
            [
                'judul' => 'Python for Data Analysis',
                'penulis' => 'Wes McKinney',
                'penerbit' => "O'Reilly Media",
                'tahun_terbit' => '2017',
                'kategori_id' => $teknoId,
                'jumlah' => 9,
            ],
        ];

        foreach ($books as $b) {
            \App\Models\Buku::create($b);
        }
    }
}
