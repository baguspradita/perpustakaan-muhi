<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MasterBukuController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\PeminjamanController;

// Halaman utama (Dashboard) - Harus login
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Master Data Routes (CRUD untuk Jurusan, Kategori Buku, dan Kelola Buku)
Route::middleware('auth')->group(function () {
    // Master Data - Jurusan
    Route::resource('jurusan', JurusanController::class);

    // Master Data - Kategori Buku
    Route::resource('kategori-buku', KategoriBukuController::class);

    // Master Data - Kelola/Manajemen Buku (CRUD)
    Route::resource('master-buku', MasterBukuController::class);

    // Katalog Buku (Index & Show - View saja)
    Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('buku/{id}', [BukuController::class, 'show'])->name('buku.show');

    // Peminjaman
    Route::resource('peminjaman', PeminjamanController::class);
    Route::post('peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
});

// Daftar Siswa (Hanya untuk Admin/Petugas)
Route::middleware('auth')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
});
