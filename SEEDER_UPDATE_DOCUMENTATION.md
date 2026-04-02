# Dokumentasi Update Seeder - Struktur SLiMS Baru

## Ringkasan Perubahan

Semua seeder telah diperbarui sesuai dengan struktur database baru yang menggunakan format label SLiMS (Senayan Library Management System) dengan field nama_depan_penulis dan nama_belakang_penulis terpisah.

## File yang Diperbarui

### 1. **BukuSeeder.php** ✅
**Perubahan Utama:**
- ✅ Mengganti field `penulis` (full name) dengan `nama_depan_penulis` dan `nama_belakang_penulis`
- ✅ Menambahkan mapping `subjek_id` untuk setiap buku
- ✅ Mapping kategori ke subjek DDC:
  - **Fiksi** → Subjek DDC **800** (Sastra & Retorika)
  - **Sains** → Subjek DDC **500** (Sains Murni)
  - **Teknologi** → Subjek DDC **000** (Komputer & Informasi)

**Contoh Data:**
```php
[
    'judul' => 'Laskar Pelangi',
    'nama_depan_penulis' => 'Andrea',           // ✅ Field baru
    'nama_belakang_penulis' => 'Hirata',        // ✅ Field baru
    'penerbit' => 'Bentang Pustaka',
    'tahun_terbit' => '2005',
    'kategori_id' => $fiksiId,
    'subjek_id' => $sastraId,                   // ✅ Relasi ke subjek_buku
    'lokasi_id' => $rakFiksi,
    'jumlah' => 10,
],
```

**Data Yang Di-seed:**
- **Total buku:** 21 buku (7 fiksi + 6 sains + 8 teknologi)
- **Lokasi:** 5 lokasi berbeda (Rak A1, Rak A2, Rak B1, Rak B2, Lemari Kaca 01)
- **Subjek:** 3 subjek DDC utama (000, 500, 800)

### 2. **app/Models/Buku.php** ✅
**Perubahan:**
- ✅ Menghapus `'penulis'` dari array `$fillable`
- ✅ Menjaga `'nama_depan_penulis'` dan `'nama_belakang_penulis'` dalam `$fillable`

**Sebelum:**
```php
protected $fillable = [
    'judul', 
    'penulis',                    // ❌ Dihapus
    'nama_depan_penulis',
    'nama_belakang_penulis',
    ...
];
```

**Sesudah:**
```php
protected $fillable = [
    'judul', 
    'nama_depan_penulis',         // ✅ Tetap
    'nama_belakang_penulis',      // ✅ Tetap
    'penerbit', 
    'tahun_terbit', 
    'kategori_id', 
    'subjek_id',
    'lokasi_id', 
    'jumlah',
    'huruf_judul_awal',
    'nomor_salinan'
];
```

### 3. **Database Migrations** ✅

#### a. `2026_02_12_101435_create_buku_table.php` ✅
**Perubahan:**
- Menghapus foreign key constraints untuk lokasi_id dan subjek_id dari CREATE TABLE
- Mengubah menjadi simple `unsignedBigInteger` columns
- Foreign key constraints ditambahkan di migration terpisah

**Alasan:** Migration dependency order - diperlukan untuk menghindari circular dependency dengan tabel lokasi dan subjek_buku yang di-create later

#### b. `2026_04_02_080152_add_lokasi_id_to_buku_table.php` ✅
**Perubahan:**
- Mengubah dari menambah column menjadi hanya menambah foreign key constraint
- Menghapus foreign key untuk subjek_id (dipindahkan ke migration terpisah)

#### c. `2026_04_02_090001_add_subjek_id_foreign_to_buku_table.php` ✅ **BARU**
**Fungsi:** Menambahkan foreign key constraint untuk subjek_id setelah tabel subjek_buku dibuat
- Constraint: `buku.subjek_id` → `subjek_buku.id` dengan `onDelete('set null')`
- Timestamp: `2026_04_02_090001` (setelah create_subjek_buku_table di `2026_04_02_090000`)

### 4. **Seeder Lain** ✅
Seeders berikut NO CHANGES (sudah sesuai):
- ✅ **KategoriBukuSeeder.php** - Kategori: Fiksi, Sains, Teknologi, Sejarah
- ✅ **LokasiSeeder.php** - Lokasi: Rak A1, A2, B1, B2, Lemari Kaca 01
- ✅ **SubjekBukuSeeder.php** - 66 standar DDC classifications (000-990)
- ✅ **DatabaseSeeder.php** - Order sudah benar (SubjekBuku sebelum Buku)

## Migration Execution Order

```
✅ Migrations dijalankan dalam urutan yang benar:

1. 0001_01_01_000000_create_jurusan_table
2. 0001_01_01_000001_create_users_table
3. 0001_01_01_000002_create_cache_table
4. 0001_01_01_000003_create_jobs_table
5. 2026_02_12_101405_create_kategori_buku_table
6. 2026_02_12_101435_create_buku_table              (tanpa FK constraints)
7. 2026_02_12_101436_create_peminjaman_table
8. 2026_02_12_101437_create_detail_peminjaman_table
9. 2026_02_12_101438_create_pengembalian_table
10. 2026_04_01_200500_create_siswa_table
11. 2026_04_01_200501_create_petugas_table
12. 2026_04_02_073841_create_guru_table
13. 2026_04_02_080138_create_lokasi_table
14. 2026_04_02_080152_add_lokasi_id_to_buku_table    (FK untuk lokasi)
15. 2026_04_02_090000_create_subjek_buku_table
16. 2026_04_02_090001_add_subjek_id_foreign_to_buku (FK untuk subjek) ← BARU
```

## Seeding Execution Order

```
✅ Seeders dijalankan dalam urutan ini:

1. JurusanSeeder              (16 ms)
2. UserSeeder                  (0 ms)
3. PetugasSeeder             (595 ms)
4. GuruSeeder                (858 ms)
5. SiswaSeeder               (907 ms)
6. KategoriBukuSeeder          (9 ms)    - 4 categories
7. LokasiSeeder               (11 ms)    - 5 locations
8. SubjekBukuSeeder          (172 ms)    - 66 DDC subjects ← IMPORTANT: runs before BukuSeeder
9. BukuSeeder                 (46 ms)    - 21 books dengan relasi subjek
```

## Testing Functional - Panduan

### 1. Verifikasi Data Struktur Baru

**Cek daftar buku dengan nama penulis terpisah:**
```
Kunjungi: /master-buku
- Tabel menampilkan kolom "Nama Penulis" (gabungan nama_depan + nama_belakang)
- Contoh tampilan: "Andrea Hirata", "Tere Liye", "Carl Sagan"
```

**Lihat detail buku:**
```
Kunjungi: /master-buku/1
- Bagian "Nama Penulis" menampilkan: "Andrea Hirata"
- Bagian "Subjek/DDC" menampilkan: "800 - Sastra & Retorika"
```

### 2. Verifikasi Subjek/DDC Mapping

**Kunjungi halaman Subjek Buku:**
```
Kunjungi: /subjek-buku
- Subjek 800 (Sastra) → 7 buku (Fiksi)
- Subjek 500 (Sains) → 6 buku (Sains)
- Subjek 000 (Komputer) → 8 buku (Teknologi)
```

**Lihat statistik subjek:**
```
Kunjungi: /subjek-buku/statistics/view
- KPI cards menampilkan: Total Subjek (3), Total Buku (21), Rata-rata (7), Max (8)
- Progress bars menunjukkan distribusi buku per subjek
```

### 3. Verifikasi Label Printing

**Test label print:**
```
Kunjungi: /master-buku
- Klik "Label" pada salah satu buku (misalnya "Laskar Pelangi")
- Halaman print menampilkan format label SLiMS:
  - Subjek: 800
  - Nama Depan: ANDREA
  - Huruf Judul: L (dari "Laskar")
  - Nomor Salinan: c.1, c.2, ... c.10
```

### 4. Verifikasi Form Input

**Buat buku baru:**
```
Kunjungi: /master-buku/create
✅ Form fields:
  - Judul (required)
  - Nama Depan Penulis (required) 
  - Nama Belakang Penulis (optional)
  - Penerbit (required)
  - Tahun Terbit (required)
  - Jumlah Stok (required)
  - Kategori (required dropdown)
  - Subjek/DDC (required dropdown)
  
❌ Field "Nama Lengkap Penulis" should NOT appear (removed)
```

**Edit buku:**
```
Kunjungi: /master-buku/1/edit
✅ Form pre-populated dengan:
  - nama_depan_penulis: "Andrea"
  - nama_belakang_penulis: "Hirata"
  
❌ Field "Nama Lengkap Penulis" should NOT appear
```

### 5. Verifikasi Search & Filter

**Search by author name:**
```
Kunjungi: /master-buku
- Cari "Andrea" → hasilnya buku-buku karya Andrea
- Cari "Hirata" → hasilnya buku-buku dengan last name Hirata
- Cari "Carl" → hasilnya buku-buku karya Carl Sagan
```

**Filter by category:**
```
- Pilih kategori "Fiksi" → 7 buku terlihat
- Pilih kategori "Sains" → 6 buku terlihat
- Pilih kategori "Teknologi" → 8 buku terlihat
```

## Data Sample untuk Testing

| Judul | Nama Depan | Nama Belakang | Kategori | Subjek DDC | Jumlah |
|-------|-----------|---------------|----------|-----------|--------|
| Laskar Pelangi | Andrea | Hirata | Fiksi | 800 | 10 |
| Bumi | Tere | Liye | Fiksi | 800 | 8 |
| Cosmos | Carl | Sagan | Sains | 500 | 3 |
| Clean Code | Robert | Martin | Teknologi | 000 | 7 |
| Mastering Laravel | Samuel | Nyongesa | Teknologi | 000 | 8 |

## Catatan Penting

### ⚠️ Mitigasi Foreign Key Issues
- Migration `2026_02_12_101435_create_buku_table` sekarang membuat columns tanpa FK constraints
- FK constraints ditambahkan di migration terpisah yang lebih late:
  - `2026_04_02_080152` untuk lokasi_id
  - `2026_04_02_090001` untuk subjek_id (BARU)
- **Alasan:** Menghindari circular dependency dan migration order issues

### ✅ Verified Success
- ✅ Semua 16 migrations berhasil dijalankan
- ✅ Semua 9 seeders berhasil di-seed tanpa error
- ✅ Total 21 buku di-seed dengan struktur baru
- ✅ Relasi kategori → subjek → buku established
- ✅ Database constraints verified

### 🚀 Ready for Functional Testing
Seeder telah di-update dengan data testing yang comprehensive:
- Multiple authors dengan nama depan-belakang berbeda
- Books distributed across 3 categories dan 3 DDC subjects
- Various quantities untuk testing label generation (c.1, c.2, ... copying)
- Pre-populated lokasi untuk realistic testing

## Rollback Instructions

Jika diperlukan rollback:
```bash
# Rollback semua migrations
php artisan migrate:rollback

# Atau rollback step-by-step
php artisan migrate:rollback --steps=1
```

---
**Status:** ✅ COMPLETED & VERIFIED
**Date:** 2026-04-02
**Test Status:** Ready for functional testing
