<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    /**
     * Menampilkan daftar semua kategori buku
     * Mengambil data dari database dan mengirim ke view index
     */
    public function index()
    {
        // Ambil semua data kategori buku dari database
        $kategori = KategoriBuku::all();
        
        // Kirim data ke view dengan variabel 'kategori'
        return view('master.kategori-buku.index', compact('kategori'));
    }

    /**
     * Menampilkan form untuk menambah kategori buku baru
     * Menampilkan halaman create.blade.php
     */
    public function create()
    {
        return view('master.kategori-buku.create');
    }

    /**
     * Menyimpan data kategori buku baru ke database
     * Menerima data dari form dan melakukan validasi
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        // - nama_kategori: harus diisi, maksimal 50 karakter, dan unik
        // - deskripsi: opsional (boleh kosong)
        $validated = $request->validate([
            'nama_kategori' => 'required|max:50|unique:kategori_buku',
            'deskripsi' => 'nullable'
        ]);

        // Simpan data ke database menggunakan model KategoriBuku
        KategoriBuku::create($validated);
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori-buku.index')->with('success', 'Kategori Buku berhasil ditambahkan');
    }

    /**
     * Menampilkan form untuk mengedit kategori buku
     * Menerima parameter $kategoriBuku (route model binding)
     */
    public function edit(KategoriBuku $kategoriBuku)
    {
        // Kirim data kategori ke form edit
        return view('master.kategori-buku.edit', compact('kategoriBuku'));
    }

    /**
     * Mengupdate data kategori buku yang sudah ada
     * Menerima data dari form dan melakukan validasi
     */
    public function update(Request $request, KategoriBuku $kategoriBuku)
    {
        // Validasi input dari form
        // nama_kategori harus unik kecuali untuk data yang sedang diedit
        $validated = $request->validate([
            'nama_kategori' => 'required|max:50|unique:kategori_buku,nama_kategori,' . $kategoriBuku->id,
            'deskripsi' => 'nullable'
        ]);

        // Update data kategori dengan nilai baru
        $kategoriBuku->update($validated);
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori-buku.index')->with('success', 'Kategori Buku berhasil diperbarui');
    }

    /**
     * Menghapus data kategori buku dari database
     * Menerima parameter $kategoriBuku (route model binding)
     */
    public function destroy(KategoriBuku $kategoriBuku)
    {
        // Hapus data kategori dari database
        $kategoriBuku->delete();
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori-buku.index')->with('success', 'Kategori Buku berhasil dihapus');
    }
}
