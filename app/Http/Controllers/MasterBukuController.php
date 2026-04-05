<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\SubjekBuku;
use App\Models\Lokasi;

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
     * Menampilkan daftar master buku (dikelompokkan per judul)
     */
    public function index(Request $request)
    {
        // Build base query - otomatis exclude soft deleted records
        $baseQuery = Buku::query();

        // Filter by kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $baseQuery->where('kategori_id', $request->kategori_id);
        }

        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $baseQuery->where(function($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('nama_penulis', 'like', "%$search%")
                  ->orWhere('penerbit', 'like', "%$search%");
            });
        }

        // Group by judul dan ambil first record sebagai representative
        $bukuGroups = $baseQuery
            ->selectRaw('judul, MIN(id) as first_id, COUNT(*) as total_salinan, COALESCE(SUM(jumlah), 0) as stok_tersedia')
            ->groupBy('judul')
            ->orderByDesc('first_id')
            ->paginate(20);

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

        return view('master.buku.index', compact('bukuGroups', 'kategori'))->with('buku', $bukuGroups);
    }

    /**
     * Tampilkan form untuk membuat buku baru
     */
    public function create()
    {
        $kategori = KategoriBuku::all();
        $subjek = SubjekBuku::orderBy('kode_ddc')->get();
        return view('master.buku.create', compact('kategori', 'subjek'));
    }

    /**
     * Simpan buku baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'nama_penulis' => 'required|string|max:200',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'subjek_id' => 'required|exists:subjek_buku,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Auto-generate huruf judul awal dari karakter pertama (non-spasi)
        $validated['huruf_judul_awal'] = $this->extractFirstLetter($validated['judul']);

        // Auto-generate nomor salinan untuk semua copy
        for ($i = 1; $i <= $validated['jumlah']; $i++) {
            $copy = $validated;
            $copy['nomor_salinan'] = "c.$i";
            Buku::create($copy);
        }

        return redirect()->route('master-buku.index')->with('success', "Buku berhasil ditambahkan dengan {$validated['jumlah']} salinan.");
    }

    /**
     * Tampilkan detail buku beserta semua saliinannya
     */
    public function show($id)
    {
        $buku = Buku::with('kategori', 'subjek')->findOrFail($id);
        $allCopies = Buku::where('judul', $buku->judul)
            ->with('lokasi')
            ->orderBy('nomor_salinan')
            ->get();
        return view('master.buku.show', compact('buku', 'allCopies'));
    }

    /**
     * Tampilkan form edit buku
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $allCopies = Buku::where('judul', $buku->judul)
            ->with('lokasi')
            ->orderBy('nomor_salinan')
            ->get();
        $kategori = KategoriBuku::all();
        $subjek = SubjekBuku::orderBy('kode_ddc')->get();
        $lokasi = Lokasi::all();
        return view('master.buku.edit', compact('buku', 'allCopies', 'kategori', 'subjek', 'lokasi'));
    }

    /**
     * Update buku di database
     */
    public function update(Request $request, $id)
    {
        // Log incoming request for debugging
        \Log::info('MasterBukuController@update - Processing request', [
            'buku_id' => $id,
            'tambah_stok_raw' => $request->input('tambah_stok'),
            'all_input' => $request->all()
        ]);

        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'nama_penulis' => 'required|string|max:200',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'subjek_id' => 'required|exists:subjek_buku,id',
            'lokasi_id' => 'nullable|exists:lokasi,id',
            'tambah_stok' => 'nullable|numeric|min:0',
        ]);

        // Extract dan cast tambah_stok dengan explicit handling
        $tambahStokInput = $request->input('tambah_stok', '0');
        $tambahStok = (int) filter_var($tambahStokInput, FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 0]]);
        
        \Log::info('MasterBukuController@update - Tambah Stok Processing', [
            'input_value' => $tambahStokInput,
            'casted_value' => $tambahStok,
            'type' => gettype($tambahStok),
            'is_greater_than_zero' => $tambahStok > 0
        ]);
        
        // Remove dari validated karena bukan field database
        unset($validated['tambah_stok']);
        
        $buku = Buku::findOrFail($id);
        
        // Auto-generate huruf judul awal dari karakter pertama (non-spasi)
        $validated['huruf_judul_awal'] = $this->extractFirstLetter($validated['judul']);
        
        // Update buku yang dipilih
        $buku->update($validated);
        
        // Jika ada penambahan stok, buat copies baru
        $copiesCreated = 0;
        if ($tambahStok > 0) {
            \Log::info('MasterBukuController@update - Creating new copies', [
                'judul' => $buku->judul,
                'tambah_stok' => $tambahStok
            ]);

            // Hitung total salinan setelah update
            $currentCopies = Buku::where('judul', $buku->judul)->count();
            $startNumber = $currentCopies + 1;
            
            \Log::debug('Copy creation details', [
                'current_copies_count' => $currentCopies,
                'start_number' => $startNumber,
                'will_create' => $tambahStok
            ]);
            
            // Prepare base data untuk semua copies baru
            $baseData = [
                'judul' => $buku->judul,
                'nama_penulis' => $buku->nama_penulis,
                'penerbit' => $buku->penerbit,
                'tahun_terbit' => $buku->tahun_terbit,
                'kategori_id' => $buku->kategori_id,
                'subjek_id' => $buku->subjek_id,
                'lokasi_id' => $buku->lokasi_id,
                'huruf_judul_awal' => $buku->huruf_judul_awal,
                'jumlah' => 1
            ];
            
            // Buat copies baru satu per satu
            try {
                for ($i = 0; $i < $tambahStok; $i++) {
                    $newCopy = $baseData;
                    $newCopy['nomor_salinan'] = 'c.' . ($startNumber + $i);
                    Buku::create($newCopy);
                    $copiesCreated++;
                    
                    \Log::debug('Copy created', [
                        'iteration' => $i,
                        'nomor_salinan' => $newCopy['nomor_salinan']
                    ]);
                }
                
                \Log::info('MasterBukuController@update - Copies created successfully', [
                    'total_created' => $copiesCreated
                ]);
            } catch (\Exception $e) {
                // Log error tapi tetap success update buku
                \Log::error('Error creating book copies: ' . $e->getMessage(), [
                    'exception' => $e,
                    'copies_created_before_error' => $copiesCreated
                ]);
            }
        } else {
            \Log::info('MasterBukuController@update - No copies to create', [
                'tambah_stok' => $tambahStok,
                'reason' => $tambahStok <= 0 ? 'Value is 0 or negative' : 'Unknown'
            ]);
        }

        // Buat pesan success yang lebih informatif
        $message = 'Buku berhasil diperbarui.';
        if ($copiesCreated > 0) {
            $message .= " ✅ Ditambahkan $copiesCreated salinan baru.";
        } elseif ($tambahStok === 0) {
            $message .= " (Tidak ada penambahan stok)";
        }
        
        \Log::info('MasterBukuController@update - Redirect with message', [
            'message' => $message,
            'copies_created' => $copiesCreated
        ]);
        
        return redirect()->route('master-buku.index')->with('success', $message);
    }

    /**
     * Hapus semua salinan buku dari database berdasarkan judul
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $judul = $buku->judul;
        
        // Cek apakah ada buku dengan judul ini yang sedang dipinjam (status 'dipinjam')
        $bukuWithActiveBorrow = Buku::where('judul', $judul)
            ->whereHas('detailPeminjaman', function($query) {
                $query->whereHas('peminjaman', function($q) {
                    $q->where('status', 'dipinjam');
                });
            })
            ->exists();
        
        if ($bukuWithActiveBorrow) {
            return back()->with('error', "Tidak bisa menghapus buku '$judul' karena masih ada yang sedang dipinjam. Pastikan semua salinan sudah dikembalikan terlebih dahulu.");
        }
        
        // Soft delete semua buku dengan judul yang sama (semua salinan)
        $count = Buku::where('judul', $judul)->delete();
        
        return redirect()->route('master-buku.index')->with('success', "Buku '$judul' dan semua $count saliinannya berhasil diarsipkan (soft deleted).");
    }

    /**
     * Menampilkan daftar buku yang sudah di-soft delete
     */
    public function trash()
    {
        // Query buku yang sudah dihapus (soft delete)
        $bukuDeleted = Buku::onlyTrashed()
            ->selectRaw('judul, MIN(id) as first_id, COUNT(*) as total_salinan, COALESCE(SUM(jumlah), 0) as stok_tersedia')
            ->groupBy('judul')
            ->orderByDesc('deleted_at')
            ->paginate(20);

        // Load relasi untuk first record dari setiap group
        $firstIds = $bukuDeleted->pluck('first_id')->toArray();
        $bukuData = Buku::onlyTrashed()
            ->with('kategori', 'subjek')
            ->whereIn('id', $firstIds)
            ->get()
            ->keyBy('id');

        // Attach relasi ke group data
        foreach ($bukuDeleted as $group) {
            if (isset($bukuData[$group->first_id])) {
                $group->buku = $bukuData[$group->first_id];
            }
        }

        return view('master.buku.trash', compact('bukuDeleted'));
    }

    /**
     * Restore buku yang sudah di-soft delete
     */
    public function restore($id)
    {
        $buku = Buku::onlyTrashed()->findOrFail($id);
        $judul = $buku->judul;

        // Restore semua buku dengan judul yang sama
        $count = Buku::onlyTrashed()
            ->where('judul', $judul)
            ->restore();

        return redirect()->route('master-buku.trash')->with('success', "Buku '$judul' ($count salinan) berhasil di-restore.");
    }

    /**
     * Hapus permanen buku yang sudah di-soft delete
     */
    public function permanentDelete($id)
    {
        $buku = Buku::onlyTrashed()->findOrFail($id);
        $judul = $buku->judul;

        // Hapus permanen semua buku dengan judul yang sama
        $count = Buku::onlyTrashed()
            ->where('judul', $judul)
            ->forceDelete();

        return redirect()->route('master-buku.trash')->with('success', "Buku '$judul' ($count salinan) berhasil dihapus permanen dari database.");
    }

    /**
     * Extract first letter dari teks (skip spaces)
     */
    private function extractFirstLetter($text)
    {
        $text = trim($text);
        for ($i = 0; $i < strlen($text); $i++) {
            if ($text[$i] !== ' ') {
                return strtoupper($text[$i]);
            }
        }
        return '';
    }

    /**
     * Tampilkan halaman cetak label buku
     */
    public function printLabel($id)
    {
        $buku = Buku::with('subjek')->findOrFail($id);
        
        // Ambil semua copies dari buku dengan judul yang sama
        $copies = Buku::where('judul', $buku->judul)
            ->orderBy('nomor_salinan', 'asc')
            ->get();
        
        return view('master.buku.label', compact('buku', 'copies'));
    }
}
