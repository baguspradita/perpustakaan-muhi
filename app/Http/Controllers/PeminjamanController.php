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
        $siswa = User::where('role', 'siswa')->get();
        $buku = Buku::where('jumlah', '>', 0)->get();

        return view('peminjaman.create', compact('siswa', 'buku'));
    }

    /**
     * Menyimpan data peminjaman baru
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

            foreach ($request->buku_id as $bukuId) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $bukuId,
                    'jumlah' => 1, // Default 1 buku per jenis
                ]);

                // Kurangi stok buku
                $buku = Buku::find($bukuId);
                $buku->decrement('jumlah');
            }

            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            // tgl_jatuh_tempo sudah di-cast sebagai Carbon date melalui $casts model
            $tglKembali    = \Carbon\Carbon::today(); // Hari ini jam 00:00:00
            $tglJatuhTempo = $peminjaman->tgl_jatuh_tempo->startOfDay();
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
                $buku = Buku::find($detail->buku_id);
                if ($buku) {
                    $buku->increment('jumlah');
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
