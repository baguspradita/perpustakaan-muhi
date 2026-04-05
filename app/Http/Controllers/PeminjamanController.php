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
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'detailPeminjaman.buku', 'pengembalian']);

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
        // Ambil siswa yang memiliki jurusan
        $siswa = User::where('role', 'siswa')
            ->whereHas('siswa', function($query) {
                $query->whereNotNull('jurusan_id');
            })
            ->with('siswa.jurusan')
            ->get()
            ->map(function($user) {
                $user->peminjam_type = 'Siswa';
                $user->jurusan_name = $user->siswa->jurusan->nama ?? '-';
                return $user;
            });
        
        // Ambil semua guru
        $guru = User::where('role', 'guru')
            ->with('guru')
            ->get()
            ->map(function($user) {
                $user->peminjam_type = 'Guru';
                $user->guru_mapel = $user->guru->mapel ?? '-';
                return $user;
            });
        
        // Gabungkan siswa dan guru, lalu sort berdasarkan nama
        $peminjam = $siswa->merge($guru)->sortBy('nama');
        
        // Get unique book titles with count of available exemplars
        // Otomatis exclude soft deleted books karena SoftDeletes trait
        $bukuByTitle = Buku::where('jumlah', '>', 0)
            ->groupBy('judul', 'kategori_id')
            ->selectRaw('judul, kategori_id, MIN(id) as id, COUNT(*) as total_exemplar')
            ->with('kategori')
            ->get();

        return view('peminjaman.create', compact('peminjam', 'bukuByTitle'));
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
                
                // Cari exemplar pertama yang tersedia dengan judul yang sama
                $firstBuku = Buku::find($bukuJudulId);
                
                if (!$firstBuku) {
                    throw new \Exception("Buku dengan ID $bukuJudulId tidak ditemukan");
                }

                // Loop berdasarkan jumlah yang diminta
                for ($i = 0; $i < $jumlahPinjam; $i++) {
                    // Cari exemplar pertama dari judul yang sama yang belum dipinjam
                    $availableExemplar = Buku::where('judul', $firstBuku->judul)
                        ->whereNotIn('id', function($query) {
                            // Exclude id yang sedang dipinjam (status aktif)
                            $query->select('buku_id')
                                ->from('detail_peminjaman')
                                ->join('peminjaman', 'peminjaman.id', '=', 'detail_peminjaman.peminjaman_id')
                                ->where('peminjaman.status', 'dipinjam');
                        })
                        ->orderBy('id')
                        ->first();

                    if (!$availableExemplar) {
                        throw new \Exception("Tidak cukup salinan buku '{$firstBuku->judul}'. Hanya tersedia " . ($i) . " dari " . $jumlahPinjam . " yang diminta");
                    }

                    // Hitung ID Eksamplar dengan format 5 digit
                    $idEksamplar = str_pad($availableExemplar->id, 5, '0', STR_PAD_LEFT);

                    // Catat detail peminjaman dengan id_eksamplar
                    DetailPeminjaman::create([
                        'peminjaman_id' => $peminjaman->id,
                        'buku_id' => $availableExemplar->id,
                        'id_eksamplar' => $idEksamplar,
                        'jumlah' => 1,
                    ]);

                    // Kurangi stok buku
                    $availableExemplar->decrement('jumlah');
                }
            }

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
