<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman
     * - Siswa/Guru: Hanya melihat peminjaman miliknya sendiri
     * - Petugas: Melihat semua peminjaman
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'detailPeminjaman.buku', 'pengembalian']);

        // Filter berdasarkan role user yang login
        if (auth()->user()->role !== 'petugas') {
            // Siswa/Guru hanya bisa lihat peminjaman miliknya sendiri
            $query->where('user_id', auth()->id());
        }

        // Filter status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan form tambah peminjaman
     */
    public function create()
    {
        // Ambil siswa yang memiliki jurusan (exclude yang sudah didelete)
        $siswa = User::where('role', 'siswa')
            ->whereNull('deleted_at')
            ->whereHas('siswa', function($query) {
                $query->whereNotNull('jurusan_id');
            })
            ->with('siswa.jurusan')
            ->orderBy('nama')
            ->get()
            ->map(function($user) {
                $user->jurusan_name = $user->siswa->jurusan->nama_jurusan ?? '-';
                return $user;
            });
        
        // Ambil semua guru (exclude yang sudah didelete)
        $guru = User::where('role', 'guru')
            ->whereNull('deleted_at')
            ->whereHas('guru', function($query) {
                $query->whereNull('deleted_at');
            })
            ->with(['guru' => function($query) {
                $query->whereNull('deleted_at');
            }])
            ->orderBy('nama')
            ->get()
            ->map(function($user) {
                $user->guru_mapel = $user->guru->mapel ?? '-';
                return $user;
            });
        
        // Get unique book titles with count of available exemplars
        // Ambil data buku, kelompokkan berdasarkan metadata yang sama, ambil ID terkecil sebagai perwakilan
        $bukuByTitle = Buku::withoutTrashed()
            ->where('jumlah', '>', 0)
            ->groupBy('judul', 'kategori_id', 'nama_penulis', 'penerbit', 'tahun_terbit')
            ->selectRaw('judul, kategori_id, nama_penulis, penerbit, tahun_terbit, MIN(id) as id, MIN(nomor_salinan) as nomor_salinan, SUM(jumlah) as total_exemplar')
            ->with('kategori')
            ->get();
        
        return view('peminjaman.create', compact('siswa', 'guru', 'bukuByTitle'));
    }

    /**
     * Menyimpan data peminjaman baru dengan auto-assign exemplar
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|array',
            'buku_id.*' => 'exists:buku,id',
            'tgl_pinjam' => 'required|date',
            'tgl_jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        // Cegah peminjaman untuk user yang sudah didelete
        $user = User::withTrashed()->findOrFail($request->user_id);
        if ($user->deleted_at !== null) {
            return back()->with('error', 'Tidak bisa membuat peminjaman! Siswa/Guru ini sudah dihapus dari sistem.');
        }

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::create([
                'user_id' => $request->user_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
                'status' => 'dipinjam',
            ]);

            foreach ($request->buku_id as $bukuJudulId) {
                // bukuJudulId adalah first_id (ID dari judul) dari GROUP BY query
                // Ambil jumlah buku yang dipinjam untuk buku ini, default 1
                $jumlahPinjam = (int)($request->buku_jumlah[$bukuJudulId] ?? 1);
                
                // Cari exemplar pertama yang tersedia dengan judul yang sama (exclude soft deleted)
                $firstBuku = Buku::withoutTrashed()->find($bukuJudulId);
                
                if (!$firstBuku) {
                    throw new \Exception("Buku dengan ID $bukuJudulId tidak ditemukan");
                }

                // Loop berdasarkan jumlah yang diminta
                for ($i = 0; $i < $jumlahPinjam; $i++) {
                    // Prioritas: gunakan buku ID yang dipilih langsung jika masih tersedia
                    $availableExemplar = null;
                    if ($i === 0 && $firstBuku->jumlah > 0) {
                        $availableExemplar = $firstBuku;
                    } else {
                        // Jika tidak, cari exemplar lain dari spesifikasi yang sama (judul, kategori, penulis, dll)
                        $query = Buku::withoutTrashed()
                            ->where('judul', $firstBuku->judul)
                            ->where('kategori_id', $firstBuku->kategori_id)
                            ->where('jumlah', '>', 0);

                        // Tambahkan metadata lain jika tersedia untuk akurasi tinggi
                        
                        // Handle nullable fields to ensure exact match
                        foreach (['nama_penulis', 'penerbit', 'tahun_terbit'] as $field) {
                            if (is_null($firstBuku->$field)) {
                                $query->whereNull($field);
                            } else {
                                $query->where($field, $firstBuku->$field);
                            }
                        }

                        $availableExemplar = $query->orderBy('id')->first();
                    }

                    if (!$availableExemplar) {
                        throw new \Exception("Tidak cukup salinan buku '{$firstBuku->judul}'. Hanya tersedia " . ($i) . " dari " . $jumlahPinjam . " yang diminta");
                    }

                    // Kurangi stok buku
                    $availableExemplar->decrement('jumlah');

                    // Catat detail peminjaman dengan id_eksamplar
                    $peminjaman->detailPeminjaman()->create([
                        'peminjaman_id' => $peminjaman->id,
                        'buku_id' => $availableExemplar->id,
                        'id_eksamplar' => $availableExemplar->nomor_salinan,
                        'jumlah' => 1,
                    ]);
                }
            }

            \Log::info('--- PEMINJAMAN DIAGNOSTIC END ---');
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat. Exemplar telah auto-assign.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail peminjaman
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user.jurusan', 'detailPeminjaman.buku.kategori', 'pengembalian'])->findOrFail($id);
        
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Menangani pengembalian buku
     */
    public function kembali($id)
    {
        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($id);

            if ($peminjaman->status === 'kembali') {
                return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
            }

            // Hitung denda: Rp 1.000 per hari keterlambatan
            // tgl_jatuh_tempo diparse ke Carbon untuk mencegah error unknown method di beberapa environment
            $tglKembali    = \Carbon\Carbon::today(); // Hari ini jam 00:00:00
            $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->startOfDay();
            $denda         = 0;

            if ($tglKembali->gt($tglJatuhTempo)) {
                $selisihHari = $tglJatuhTempo->diffInDays($tglKembali);
                $denda       = $selisihHari * 1000;
            }

            // Simpan data pengembalian
            \App\Models\Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali'   => $tglKembali->toDateString(),
                'denda'         => $denda,
            ]);

            // Update status peminjaman
            $peminjaman->update(['status' => 'kembali']);

            // Kembalikan stok buku
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->buku) {
                    $detail->buku->increment('jumlah');
                }
            }

            DB::commit();

            $pesan = 'Buku berhasil dikembalikan.';
            if ($denda > 0) {
                $pesan .= ' Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.');
            } else {
                $pesan .= ' Tidak ada denda (tepat waktu).';
            }

            return redirect()->route('peminjaman.index')->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
