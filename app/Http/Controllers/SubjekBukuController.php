<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjekBuku;

class SubjekBukuController extends Controller
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
     * Tampilkan daftar subjek buku (dengan tabel)
     */
    public function index(Request $request)
    {
        $query = SubjekBuku::query();

        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('kode_ddc', 'like', "%$search%")
                  ->orWhere('nama_subjek', 'like', "%$search%");
        }

        $subjek = $query->orderBy('kode_ddc')->paginate(20);

        return view('master.subjek-buku.index', compact('subjek'));
    }

    /**
     * Tampilkan form untuk membuat subjek baru
     */
    public function create()
    {
        return view('master.subjek-buku.create');
    }

    /**
     * Simpan subjek baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_ddc' => 'required|string|max:10|unique:subjek_buku,kode_ddc',
            'nama_subjek' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        SubjekBuku::create($validated);

        return redirect()->route('subjek-buku.index')->with('success', 'Subjek buku berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail subjek
     */
    public function show($id)
    {
        $subjek = SubjekBuku::with('buku')->findOrFail($id);
        return view('master.subjek-buku.show', compact('subjek'));
    }

    /**
     * Tampilkan form edit subjek
     */
    public function edit($id)
    {
        $subjek = SubjekBuku::findOrFail($id);
        return view('master.subjek-buku.edit', compact('subjek'));
    }

    /**
     * Update subjek di database
     */
    public function update(Request $request, $id)
    {
        $subjek = SubjekBuku::findOrFail($id);

        $validated = $request->validate([
            'kode_ddc' => 'required|string|max:10|unique:subjek_buku,kode_ddc,' . $id,
            'nama_subjek' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $subjek->update($validated);

        return redirect()->route('subjek-buku.index')->with('success', 'Subjek buku berhasil diperbarui.');
    }

    /**
     * Hapus subjek dari database
     */
    public function destroy($id)
    {
        $subjek = SubjekBuku::findOrFail($id);
        
        if ($subjek->buku()->count() > 0) {
            return redirect()->route('subjek-buku.index')->with('error', 'Tidak dapat menghapus subjek yang masih memiliki buku. Silakan ubah subjek buku terlebih dahulu.');
        }

        $subjek->delete();
        return redirect()->route('subjek-buku.index')->with('success', 'Subjek buku berhasil dihapus.');
    }

    /**
     * Update status subjek
     */
    public function updateStatus(Request $request, $id)
    {
        $subjek = SubjekBuku::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            $subjek->update($validated);
            
            $statusText = $validated['status'] === 'aktif' ? 'Diaktifkan' : 'Dinonaktifkan';
            return back()->with('success', "Status subjek '{$subjek->nama_subjek}' berhasil {$statusText}.");
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
