<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Menampilkan daftar semua jurusan
     * Mengambil data dari database dan mengirim ke view index
     */
    public function index()
    {
        // Ambil semua data jurusan dari database
        $jurusan = Jurusan::all();
        
        // Kirim data ke view dengan variabel 'jurusan'
        return view('master.jurusan.index', compact('jurusan'));
    }

    /**
     * Menampilkan form untuk menambah jurusan baru
     * Menampilkan halaman create.blade.php
     */
    public function create()
    {
        // Tampilkan form untuk menambah jurusan baru
        return view('master.jurusan.create');
    }

    /**
     * Menyimpan data jurusan baru ke database
     * Menerima data dari form dan melakukan validasi
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        // - nama_jurusan: harus diisi, max 50 karakter, dan unik (belum ada di database)
        // - deskripsi: opsional (boleh kosong)
        $validated = $request->validate([
            'nama_jurusan' => 'required|max:50|unique:jurusan',
            'deskripsi' => 'nullable'
        ]);

        // Simpan data ke database menggunakan model Jurusan
        Jurusan::create($validated);
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }

    /**
     * Menampilkan form untuk mengedit jurusan
     * Menerima parameter $jurusan (route model binding)
     */
    public function edit(Jurusan $jurusan)
    {
        // Kirim data jurusan ke form edit
        return view('master.jurusan.edit', compact('jurusan'));
    }

    /**
     * Mengupdate data jurusan yang sudah ada
     * Menerima data dari form dan melakukan validasi
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        // Validasi input dari form
        // nama_jurusan harus unik di database, tapi exclude record yang sedang diedit
        $validated = $request->validate([
            'nama_jurusan' => 'required|max:50|unique:jurusan,nama_jurusan,' . $jurusan->id,
            'deskripsi' => 'nullable'
        ]);

        // Update data jurusan dengan nilai baru
        $jurusan->update($validated);
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui');
    }

    /**
     * Menghapus data jurusan dari database
     * Menerima parameter $jurusan (route model binding)
     */
    public function destroy(Jurusan $jurusan)
    {
        // Hapus data jurusan dari database
        $jurusan->delete();
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}