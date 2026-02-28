<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;

class BukuController extends Controller
{
    /**
     * Menampilkan katalog buku (view saja)
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        $buku = $query->latest()->paginate(12);
        $kategori = KategoriBuku::all();

        return view('buku.index', compact('buku', 'kategori'));
    }

    /**
     * Menampilkan detail buku
     */
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('buku.show', compact('buku'));
    }
}
