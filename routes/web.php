<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MasterBukuController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\SubjekBukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RiwayatPeminjamanController;
use App\Http\Controllers\LokasiController;

// Halaman utama (Dashboard) - Harus login
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Akun/Profil (Update Biodata Mandiri)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Master Data Routes (CRUD untuk Jurusan, Kategori Buku, dan Kelola Buku)
Route::middleware('auth')->group(function () {
    // Master Data - Jurusan
    Route::resource('jurusan', JurusanController::class);

    // Master Data - Guru
    Route::resource('guru', GuruController::class);

    // Master Data - Kategori Buku
    Route::resource('kategori-buku', KategoriBukuController::class);

    // Master Data - Subjek Buku/DDC
    Route::resource('subjek-buku', SubjekBukuController::class);

    // Master Data - Kelola/Manajemen Buku (CRUD)
    Route::resource('master-buku', MasterBukuController::class);
    Route::get('master-buku/{id}/label', [MasterBukuController::class, 'printLabel'])->name('master-buku.printLabel');
    Route::get('master-buku-trash/view', [MasterBukuController::class, 'trash'])->name('master-buku.trash');
    Route::post('master-buku/{id}/restore', [MasterBukuController::class, 'restore'])->name('master-buku.restore');
    Route::delete('master-buku/{id}/permanent-delete', [MasterBukuController::class, 'permanentDelete'])->name('master-buku.permanent-delete');

    // Master Data - Lokasi Buku
    Route::resource('lokasi', LokasiController::class);

    // Katalog Buku (Index & Show - View saja)
    Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('buku/{id}', [BukuController::class, 'show'])->name('buku.show');

    // Peminjaman
    Route::resource('peminjaman', PeminjamanController::class);
    Route::post('peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');

    // Riwayat Peminjaman (untuk siswa/guru melihat history mereka sendiri)
    Route::get('/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index'])->name('riwayat-peminjaman.index');
    Route::get('/riwayat-peminjaman/{id}', [RiwayatPeminjamanController::class, 'show'])->name('riwayat-peminjaman.show');

    // Riwayat Peminjaman SEMUA ANGGOTA (hanya untuk PETUGAS)
    Route::get('/riwayat-peminjaman-all', [RiwayatPeminjamanController::class, 'indexAll'])->name('riwayat-peminjaman.index-all');
    Route::get('/riwayat-peminjaman-all/{id}', [RiwayatPeminjamanController::class, 'showAll'])->name('riwayat-peminjaman.show-all');
});

// Daftar Siswa (Hanya untuk Admin/Petugas)
Route::middleware('auth')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});
