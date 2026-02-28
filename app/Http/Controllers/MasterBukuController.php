<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;

class MasterBukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Hanya `petugas` yang dapat mengakses controller ini
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || auth()->user()->role !== 'petugas') {
                abort(403, 'Akses ditolak. Hanya petugas.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar master buku (dengan tabel)
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Filter by kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul', 'like', "%$search%")
                  ->orWhere('penulis', 'like', "%$search%")
                  ->orWhere('penerbit', 'like', "%$search%");
        }

        $buku = $query->latest()->paginate(20);
        $kategori = KategoriBuku::all();

        return view('master-buku.index', compact('buku', 'kategori'));
    }

    /**
     * Tampilkan form untuk membuat buku baru
     */
    public function create()
    {
        $kategori = KategoriBuku::all();
        return view('master-buku.create', compact('kategori'));
    }

    /**
     * Simpan buku baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        Buku::create($validated);

        return redirect()->route('master-buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail buku
     */
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('master-buku.show', compact('buku'));
    }

    /**
     * Tampilkan form edit buku
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = KategoriBuku::all();
        return view('master-buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update buku di database
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'jumlah' => 'required|integer|min:0',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($validated);

        return redirect()->route('master-buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Hapus buku dari database
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return redirect()->route('master-buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
