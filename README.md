# Perpustakaan Muhi

Sistem manajemen perpustakaan sekolah modern dengan fitur lengkap untuk mengelola buku, peminjaman, dan pengembalian.

## itur

- ✅ Manajemen data siswa, guru, dan petugas
- ✅ Katalog buku dengan kategori dan subjek
- ✅ Sistem peminjaman dan pengembalian
- ✅ Tracking stok dan lokasi buku
- ✅ Sistem denda otomatis
- ✅ Laporan peminjaman dan statistik
- ✅ Role-based access control

## Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Blade + Vite
- **Database:** MySQL
- **PHP:** 8.2+

## Quick Start

### Install

```bash
# Clone repository
git clone https://github.com/username/perpustakaan-muhi.git
cd perpustakaan-muhi

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Build assets
npm run dev

# Run 
php artisan serve

# Testing
php artisan test

# Troubleshooting
php artisan migrate:fresh --seed