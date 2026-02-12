<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar katalog buku
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // Query dasar mengambil buku dan relasi kategorinya
        $query = \App\Models\Buku::with('kategori');

        // Jika ada filter kategori dari request (dropdown)
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Ambil data buku terbaru (limit 20)
        $buku = $query->latest()->paginate(12);
        
        // Ambil semua kategori untuk dropdown filter
        $kategori = \App\Models\KategoriBuku::all();

        // Tampilkan view 'buku.index' dengan data buku dan kategori
        return view('buku.index', compact('buku', 'kategori'));
    }
}
