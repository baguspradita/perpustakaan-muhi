<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;

class BukuController extends Controller
{
    /**
     * Menampilkan katalog buku (view saja) - tanpa duplikat judul
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Group by judul dan ambil first record dari setiap group
        $bukuGroups = $query
            ->selectRaw('judul, MIN(id) as first_id, COUNT(*) as total_salinan, COALESCE(SUM(jumlah), 0) as stok_tersedia')
            ->groupBy('judul')
            ->orderByDesc('first_id')
            ->paginate(12);

        // Load relasi untuk first record dari setiap group
        $firstIds = $bukuGroups->pluck('first_id')->toArray();
        $bukuData = Buku::with('kategori', 'subjek')
            ->whereIn('id', $firstIds)
            ->get()
            ->keyBy('id');

        // Attach relasi ke group data
        foreach ($bukuGroups as $group) {
            if (isset($bukuData[$group->first_id])) {
                $group->buku = $bukuData[$group->first_id];
            }
        }

        $kategori = KategoriBuku::all();

        return view('buku.index', compact('bukuGroups', 'kategori'));
    }

    /**
     * Menampilkan detail buku beserta semua salinannya
     */
    public function show($id)
    {
        $buku = Buku::with('kategori', 'subjek')->findOrFail($id);
        
        // Ambil semua exemplar dengan judul yang sama
        $salinan = Buku::where('judul', $buku->judul)
            ->orderBy('id')
            ->get();

        return view('buku.show', compact('buku', 'salinan'));
    }
}
