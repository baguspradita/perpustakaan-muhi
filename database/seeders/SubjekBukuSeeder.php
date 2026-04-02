<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubjekBuku;

class SubjekBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjek = [
            // 000-099: General Knowledge
            ['kode_ddc' => '000', 'nama_subjek' => 'Komputer & Informasi Umum', 'deskripsi' => 'Ilmu Komputer dan Teknologi Informasi'],
            ['kode_ddc' => '004', 'nama_subjek' => 'Komputer & Pengolahan Data', 'deskripsi' => 'Komputer dan sistem pengolahan data'],
            ['kode_ddc' => '006', 'nama_subjek' => 'Spesialisasi Khusus Komputer', 'deskripsi' => 'Spesialisasi khusus dalam ilmu komputer'],
            ['kode_ddc' => '025', 'nama_subjek' => 'Dokumentasi Informasi', 'deskripsi' => 'Dokumentasi dan informasi umum'],

            // 100-199: Philosophy
            ['kode_ddc' => '100', 'nama_subjek' => 'Filsafat & Psikologi', 'deskripsi' => 'Filsafat, epistemologi, dan logika'],
            ['kode_ddc' => '110', 'nama_subjek' => 'Metafisika', 'deskripsi' => 'Metafisika dan ontologi'],
            ['kode_ddc' => '150', 'nama_subjek' => 'Psikologi', 'deskripsi' => 'Ilmu psikologi dan perilaku manusia'],

            // 200-299: Religion
            ['kode_ddc' => '200', 'nama_subjek' => 'Agama', 'deskripsi' => 'Agama dan kepercayaan'],
            ['kode_ddc' => '210', 'nama_subjek' => 'Alam & Existensi Tuhan', 'deskripsi' => 'Teologi alami'],
            ['kode_ddc' => '220', 'nama_subjek' => 'Kitab Suci Kristen', 'deskripsi' => 'Alkitab dan teks Kristen'],
            ['kode_ddc' => '290', 'nama_subjek' => 'Agama Lainnya', 'deskripsi' => 'Agama non-Kristen dan spiritualitas'],

            // 300-399: Social Sciences
            ['kode_ddc' => '300', 'nama_subjek' => 'Ilmu Sosial', 'deskripsi' => 'Ilmu sosial umum'],
            ['kode_ddc' => '320', 'nama_subjek' => 'Ilmu Politik', 'deskripsi' => 'Ilmu politik dan teori negara'],
            ['kode_ddc' => '330', 'nama_subjek' => 'Ilmu Ekonomi', 'deskripsi' => 'Ilmu ekonomi dan keuangan'],
            ['kode_ddc' => '340', 'nama_subjek' => 'Hukum', 'deskripsi' => 'Sistem hukum dan peraturan'],
            ['kode_ddc' => '350', 'nama_subjek' => 'Administrasi Publik', 'deskripsi' => 'Administrasi publik dan pemerintahan'],
            ['kode_ddc' => '360', 'nama_subjek' => 'Layanan Sosial', 'deskripsi' => 'Kesejahteraan sosial dan layanan sosial'],
            ['kode_ddc' => '370', 'nama_subjek' => 'Pendidikan', 'deskripsi' => 'Pendidikan dan proses belajar'],

            // 400-499: Language
            ['kode_ddc' => '400', 'nama_subjek' => 'Bahasa', 'deskripsi' => 'Bahasa dan linguistik'],
            ['kode_ddc' => '420', 'nama_subjek' => 'Bahasa Inggris', 'deskripsi' => 'Bahasa Inggris'],
            ['kode_ddc' => '430', 'nama_subjek' => 'Bahasa Jerman', 'deskripsi' => 'Bahasa Jerman'],
            ['kode_ddc' => '440', 'nama_subjek' => 'Bahasa Prancis', 'deskripsi' => 'Bahasa Prancis'],
            ['kode_ddc' => '450', 'nama_subjek' => 'Bahasa Italia', 'deskripsi' => 'Bahasa Italia'],
            ['kode_ddc' => '460', 'nama_subjek' => 'Bahasa Spanyol', 'deskripsi' => 'Bahasa Spanyol'],
            ['kode_ddc' => '490', 'nama_subjek' => 'Bahasa Lainnya', 'deskripsi' => 'Bahasa-bahasa lain termasuk Indonesia'],

            // 500-599: Science
            ['kode_ddc' => '500', 'nama_subjek' => 'Sains Murni', 'deskripsi' => 'Ilmu sains umum'],
            ['kode_ddc' => '510', 'nama_subjek' => 'Matematika', 'deskripsi' => 'Matematika dan geometri'],
            ['kode_ddc' => '520', 'nama_subjek' => 'Astronomi & Ilmu Antariksa', 'deskripsi' => 'Astronomi dan fisika antariksa'],
            ['kode_ddc' => '530', 'nama_subjek' => 'Fisika', 'deskripsi' => 'Ilmu fisika dan mekanika'],
            ['kode_ddc' => '540', 'nama_subjek' => 'Kimia', 'deskripsi' => 'Ilmu kimia dan reaksi kimia'],
            ['kode_ddc' => '550', 'nama_subjek' => 'Geologi & Ilmu Bumi', 'deskripsi' => 'Geologi dan ilmu bumi'],
            ['kode_ddc' => '560', 'nama_subjek' => 'Paleontologi & Paleozoologi', 'deskripsi' => 'Paleontologi (fosil) dan sejarah kehidupan'],
            ['kode_ddc' => '570', 'nama_subjek' => 'Biologi', 'deskripsi' => 'Biologi dan ilmu hayat'],
            ['kode_ddc' => '580', 'nama_subjek' => 'Botani', 'deskripsi' => 'Botani dan ilmu tumbuhan'],
            ['kode_ddc' => '590', 'nama_subjek' => 'Zoologi', 'deskripsi' => 'Zoologi dan ilmu hewan'],

            // 600-699: Technology
            ['kode_ddc' => '600', 'nama_subjek' => 'Teknologi Terapan', 'deskripsi' => 'Sains terapan dan teknologi'],
            ['kode_ddc' => '610', 'nama_subjek' => 'Kedokteran & Kesehatan', 'deskripsi' => 'Kedokteran dan ilmu kesehatan'],
            ['kode_ddc' => '620', 'nama_subjek' => 'Teknik & Ilmu Terkait', 'deskripsi' => 'Teknik dan rekayasa'],
            ['kode_ddc' => '630', 'nama_subjek' => 'Pertanian & Teknologi Terkait', 'deskripsi' => 'Pertanian dan peternakan'],
            ['kode_ddc' => '640', 'nama_subjek' => 'Ekonomi Rumah Tangga', 'deskripsi' => 'Hal ihwal rumah tangga'],
            ['kode_ddc' => '650', 'nama_subjek' => 'Manajemen & Layanan Sekretariat', 'deskripsi' => 'Manajemen bisnis dan layanan'],
            ['kode_ddc' => '660', 'nama_subjek' => 'Industri Kimia', 'deskripsi' => 'Kimia industri dan manufaktur'],
            ['kode_ddc' => '670', 'nama_subjek' => 'Manufaktur', 'deskripsi' => 'Manufaktur dan pemrosesan'],
            ['kode_ddc' => '680', 'nama_subjek' => 'Manufaktur untuk Kegunaan Spesifik', 'deskripsi' => 'Pembuatan barang spesifik'],
            ['kode_ddc' => '690', 'nama_subjek' => 'Bangunan & Teknik Sipil', 'deskripsi' => 'Konstruksi dan bangunan'],

            // 700-799: Arts
            ['kode_ddc' => '700', 'nama_subjek' => 'Seni & Rekreasi', 'deskripsi' => 'Seni dan seni rupa'],
            ['kode_ddc' => '710', 'nama_subjek' => 'Perencanaan Area & Desain', 'deskripsi' => 'Perencanaan dan desain'],
            ['kode_ddc' => '720', 'nama_subjek' => 'Arsitektur', 'deskripsi' => 'Arsitektur dan bangunan'],
            ['kode_ddc' => '730', 'nama_subjek' => 'Patung & Seni Plastik', 'deskripsi' => 'Patung dan seni plastik'],
            ['kode_ddc' => '740', 'nama_subjek' => 'Menggambar & Seni Dekoratif', 'deskripsi' => 'Seni lukis dan dekoratif'],
            ['kode_ddc' => '750', 'nama_subjek' => 'Melukis & Lukisan', 'deskripsi' => 'Melukis dan karya seni lukis'],
            ['kode_ddc' => '760', 'nama_subjek' => 'Seni Grafis & Teknik Cetak', 'deskripsi' => 'Seni grafis dan percetakan'],
            ['kode_ddc' => '770', 'nama_subjek' => 'Fotografi & Seni Film', 'deskripsi' => 'Fotografi dan sinematografi'],
            ['kode_ddc' => '780', 'nama_subjek' => 'Musik', 'deskripsi' => 'Musik dan seni pertunjukan'],
            ['kode_ddc' => '790', 'nama_subjek' => 'Olahraga, Permainan & Rekreasi', 'deskripsi' => 'Olahraga dan rekreasi'],

            // 800-899: Literature
            ['kode_ddc' => '800', 'nama_subjek' => 'Sastra & Retorika', 'deskripsi' => 'Sastra dan seni bahasa'],
            ['kode_ddc' => '810', 'nama_subjek' => 'Sastra Amerika Inggris', 'deskripsi' => 'Sastra dalam bahasa Inggris'],
            ['kode_ddc' => '820', 'nama_subjek' => 'Sastra Inggris', 'deskripsi' => 'Sastra Inggris'],
            ['kode_ddc' => '830', 'nama_subjek' => 'Sastra Jerman', 'deskripsi' => 'Sastra Jerman'],
            ['kode_ddc' => '840', 'nama_subjek' => 'Sastra Prancis', 'deskripsi' => 'Sastra Prancis'],
            ['kode_ddc' => '850', 'nama_subjek' => 'Sastra Italia', 'deskripsi' => 'Sastra Italia'],
            ['kode_ddc' => '860', 'nama_subjek' => 'Sastra Spanyol', 'deskripsi' => 'Sastra Spanyol'],
            ['kode_ddc' => '890', 'nama_subjek' => 'Sastra Lainnya', 'deskripsi' => 'Sastra bahasa-bahasa lain'],

            // 900-999: History & Geography
            ['kode_ddc' => '900', 'nama_subjek' => 'Sejarah', 'deskripsi' => 'Sejarah dan geografi'],
            ['kode_ddc' => '910', 'nama_subjek' => 'Geografi & Biografi Kolektif', 'deskripsi' => 'Geografi dan perjalanan'],
            ['kode_ddc' => '920', 'nama_subjek' => 'Biografi', 'deskripsi' => 'Biografi dan autobiografi'],
            ['kode_ddc' => '930', 'nama_subjek' => 'Sejarah Kuno', 'deskripsi' => 'Sejarah kuno dan Mesir'],
            ['kode_ddc' => '940', 'nama_subjek' => 'Sejarah Eropa', 'deskripsi' => 'Sejarah Eropa dan Perang Dunia'],
            ['kode_ddc' => '950', 'nama_subjek' => 'Sejarah Asia', 'deskripsi' => 'Sejarah Asia'],
            ['kode_ddc' => '960', 'nama_subjek' => 'Sejarah Afrika', 'deskripsi' => 'Sejarah Afrika'],
            ['kode_ddc' => '970', 'nama_subjek' => 'Sejarah Amerika Utara', 'deskripsi' => 'Sejarah Amerika Utara'],
            ['kode_ddc' => '980', 'nama_subjek' => 'Sejarah Amerika Selatan', 'deskripsi' => 'Sejarah Amerika Selatan'],
            ['kode_ddc' => '990', 'nama_subjek' => 'Sejarah Oseania & Eksplorasi Kutub', 'deskripsi' => 'Sejarah Oseania'],
        ];

        foreach ($subjek as $item) {
            SubjekBuku::updateOrCreate(
                ['kode_ddc' => $item['kode_ddc']],
                $item
            );
        }
    }
}
