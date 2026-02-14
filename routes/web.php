<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\SiswaController;

// Halaman utama (Dashboard) - Harus login
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Katalog Buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index')->middleware('auth');

// Daftar Siswa (Hanya untuk Admin/Petugas)
Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index')->middleware('auth');
Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show')->middleware('auth');
