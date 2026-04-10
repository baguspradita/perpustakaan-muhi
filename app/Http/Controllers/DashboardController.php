<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard perpustakaan
     */
    public function index()
    {
        // Mengambil data statistik sederhana dari database
        $stats = [
            'total_buku' => \App\Models\Buku::count(),
            'total_anggota' => \App\Models\User::whereIn('role', ['siswa', 'guru'])->count(),
            'total_peminjaman' => \App\Models\Peminjaman::count(),
        ];

        // Mengirim data statistik ke view 'dashboard'
        return view('dashboard', compact('stats'));
    }
}
