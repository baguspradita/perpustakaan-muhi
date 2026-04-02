# Panduan Update Stok Buku - SLiMS Library Management

## Permasalahan Lama ❌
Saat melakukan update pada buku, stok tidak bertambah karena:
- Field `jumlah` di database mewakili **stok individual per copy** (setiap copy adalah satu rekord)
- Update method tidak memiliki logika untuk menambah copies baru
- Form hanya menampilkan field `jumlah` tanpa cara untuk increment

## Solusi Baru ✅
Sekarang sistem menggunakan **two-phase workflow**:

### Fase 1: CREATE (Saat Tambah Buku Baru)
**Field: "Jumlah Stok"** - Menentukan berapa banyak copies dibuat
```
Contoh: Input 10 → Sistem membuat 10 records (c.1, c.2, ... c.10)
```

**Hasil:**
- Laskar Pelangi (c.1) - Record 1
- Laskar Pelangi (c.2) - Record 2
- ...
- Laskar Pelangi (c.10) - Record 10

### Fase 2: UPDATE (Saat Edit Buku)
**Field: "Tambah Stok"** - Untuk increment copies yang sudah ada
```
Current: 10 salinan
Input: 5 → Sistem membuat 5 records baru (c.11, c.12, ... c.15)
Result: 15 salinan total
```

## Workflow Edit Buku - Step by Step

### 1️⃣ Klik Menu "Kelola Buku"
Lihat list buku yang sudah dikelompokkan per judul dengan badge salinan:
```
Laskar Pelangi [10 salinan] - Status: 10 copies active
```

### 2️⃣ Klik "Edit" pada Buku yang Ingin Update
Tampilan form edit:
```
Judul Buku:              Laskar Pelangi
Nama Depan Penulis:      Andrea
Nama Belakang Penulis:   Hirata
Penerbit:                Bentang Pustaka
Tahun Terbit:            2005
Kategori:                Fiksi
Subjek/DDC:              800 - Sastra & Retorika
─────────────────────────────────────────
📊 Total Salinan Saat Ini: 10 salinan   (ℹ️ Read-only - informasi)
Tambah Stok:             [___] salinan  (✏️ Input untuk menambah)
```

### 3️⃣ Isi Field "Tambah Stok"
Contoh: Ingin menambah 3 salinan baru
```
Tambah Stok: 3

ℹ️ Sistem akan membuat 3 records baru:
   - c.11 (Laskar Pelangi copy 11)
   - c.12 (Laskar Pelangi copy 12)
   - c.13 (Laskar Pelangi copy 13)
```

### 4️⃣ Klik "Perbarui Buku"
Sistem:
- ✅ Update info buku (judul, penulis, penerbit, dll)
- ✅ Create 3 records baru dengan nomor salinan c.11 hingga c.13
- ✅ Original 10 records tetap ada + tidak berubah

### 5️⃣ Verifikasi di Detail Buku
Klik "Lihat" untuk melihat semua 13 salinan:
```
[ Daftar Semua Salinan (13) ]

No Salinan | Huruf | Lokasi      | ID Eksamplar
-----------|-------|-------------|----------
c.1        | L     | Rak A1      | 00001
c.2        | L     | Rak A1      | 00002
c.3        | L     | Rak A1      | 00003
...
c.10       | L     | Rak A1      | 00010
c.11       | L     | Rak A1      | 00115
c.12       | L     | Rak A1      | 00116
c.13       | L     | Rak A1      | 00117
```

## Contoh Skenario Real

### Skenario 1: Buku Baru dengan 5 Copy
```
Tambah Buku Baru:
- Judul: "Bumi"
- Penulis: Tere Liye
- Jumlah Stok: 5 ← Membuat 5 copies

Hasil: c.1, c.2, c.3, c.4, c.5 (5 records di database)
```

### Skenario 2: Tambah Stok Existing Book (dari 5 menjadi 8)
```
Edit Buku "Bumi":
- Total Salinan Saat Ini: 5 (read-only)
- Tambah Stok: 3 ← Menambah 3 copies baru

Sebelum update: c.1, c.2, c.3, c.4, c.5
Sesudah update: c.1, c.2, c.3, c.4, c.5, c.6, c.7, c.8 (8 records total)
```

### Skenario 3: Update Info Tanpa Tambah Stok
```
Edit Buku "Cosmos":
- Current: 3 salinan
- Update: Ubah penerbit, tahun terbit, dll
- Tambah Stok: 0 (atau kosongkan)

Hasil: Info ter-update, jumlah salinan tetap 3
```

## Important Notes ⚠️

### ✅ Yang Bisa Di-Edit di Update
- ✅ Judul Buku
- ✅ Nama Penulis (depan & belakang)
- ✅ Penerbit
- ✅ Tahun Terbit
- ✅ Kategori
- ✅ Subjek/DDC
- ✅ **TAMBAH Stok** (increment copies)

### ❌ Yang TIDAK Bisa Di-Edit di Update
- ❌ **Kurangi Stok** - Harus hapus manually dengan "Hapus" (menghapus ALL copies)
- ❌ Nomor Salinan (auto-generated)
- ❌ Huruf Judul Awal (auto-generated dari judul)

### ⚠️ Hapus Buku
Saat klik "Hapus Semua" di index atau detail:
- ❌ Menghapus **SEMUA salinan** sekaligus (tidak bisa kurangi individual)
- Contoh: "Laskar Pelangi [10 salinan]" → Hapus semua 10 copies sekaligus

## Database Structure 🗄️

Setiap "buku" adalah rekord terpisah di tabel `buku`:
```
id  | judul          | nomor_salinan | kategori_id | lokasi_id | created_at
----|----------------|---------------|-------------|-----------|----------
1   | Laskar Pelangi | c.1           | 1           | 1         | 2026-04-02
2   | Laskar Pelangi | c.2           | 1           | 1         | 2026-04-02
3   | Laskar Pelangi | c.3           | 1           | 1         | 2026-04-02
...
```

## Troubleshooting 🔧

### Q: Update tapi stok tidak berubah?
**A:** Perhatikan field "Tambah Stok" harus > 0
```
Total Salinan: 10
Tambah Stok: 0 ← Ini tidak akan menambah apapun
Tambah Stok: 5 ← Ini akan menambah 5 copies baru
```

### Q: Ingin kurangi stok dari 10 menjadi 8?
**A:** Saat ini tidak ada fitur direct reduce. Opsi:
1. ✅ Hapus buku + buat ulang dengan jumlah yang tepat
2. ✅ Delete individual records via database (advanced)
3. 🔜 Feature request: Implement reduce stok di future update

### Q: Ingin ubah lokasi untuk copy tertentu?
**A:** Setiap copy adalah record terpisah, bisa edit individual copy:
1. Klik "Lihat" di detail buku untuk lihat semua copies
2. Edit lokasi per copy via database (advanced)
3. 🔜 Feature request: Implement bulk location change

## Fitur Query/Reporting

### Lihat Total Stok per Buku
```
Query: SELECT judul, COUNT(*) as total_salinan FROM buku GROUP BY judul
Hasil: Laskar Pelangi → 13 salinan
```

### Lihat Semua Lokasi per Copy
```
Klik "Lihat" di detail buku → Lihat tabel dengan kolom "Lokasi" untuk tiap copy
```

### Lihat Yang Membutuhkan Tambah Stok
```
List di Kelola Buku menampilkan badge "10 salinan" → Indikator current stock
```

---

**Version:** v1.0  
**Last Update:** 2026-04-02  
**Status:** ✅ READY FOR USE
