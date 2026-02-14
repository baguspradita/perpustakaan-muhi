<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa (hanya untuk admin/petugas)
     */
    public function index(Request $request)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat melihat daftar siswa.');
        }

        // Query dasar mengambil siswa dan relasi jurusannya
        $query = User::with('jurusan')->where('role', 'siswa');

        // Jika ada filter jurusan dari request (dropdown)
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Jika ada pencarian nama
        if ($request->has('cari') && $request->cari != '') {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        // Ambil data siswa dengan pagination
        $siswa = $query->latest()->paginate(12);

        // Ambil semua jurusan untuk dropdown filter
        $jurusan = \App\Models\Jurusan::all();

        // Tampilkan view 'siswa.index' dengan data siswa dan jurusan
        return view('siswa.index', compact('siswa', 'jurusan'));
    }

    /**
     * Menampilkan detail siswa
     */
    public function show($id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::with('jurusan')->where('role', 'siswa')->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }
}
