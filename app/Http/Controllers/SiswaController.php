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
        $query = User::with(['siswa', 'jurusan'])->where('role', 'siswa');

        // Jika ada filter jurusan dari request (dropdown)
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan_id);
            });
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

        $siswa = User::with(['siswa', 'jurusan'])->where('role', 'siswa')->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Menampilkan form edit data siswa
     */
    public function edit($id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::with(['siswa', 'jurusan'])->where('role', 'siswa')->findOrFail($id);
        $jurusan = \App\Models\Jurusan::all();

        return view('siswa.edit', compact('siswa', 'jurusan'));
    }

    /**
     * Menyimpan perubahan data siswa
     */
    public function update(Request $request, $id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $id,
            'no_telp'    => 'nullable|string|max:20',
            'alamat'     => 'nullable|string|max:500',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'kelas'      => 'nullable|string|max:50',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan oleh pengguna lain.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Simpan perubahan ke tabel users
        $siswa->update([
            'nama'    => $validated['nama'],
            'email'   => $validated['email'],
            'no_telp' => $validated['no_telp'],
            'alamat'  => $validated['alamat'],
        ]);

        // Simpan perubahan ke tabel siswa (detail profil)
        $siswa->siswa()->update([
            'jurusan_id' => $validated['jurusan_id'],
            'kelas'      => $validated['kelas'],
        ]);

        return redirect()->route('siswa.show', $id)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa (soft delete)
     */
    public function destroy($id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Cek apakah siswa memiliki peminjaman aktif
        $activeLoan = \App\Models\Peminjaman::where('user_id', $id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($activeLoan) {
            return back()->with('error', 'Tidak bisa menghapus siswa! Siswa masih memiliki peminjaman aktif.');
        }

        // Soft delete siswa dan user
        $siswa->delete();
        $siswa->siswa()->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
