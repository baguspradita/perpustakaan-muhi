<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class RiwayatPeminjamanController extends Controller
{
    /**
     * Konstruktor - Pastikan user sudah login
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar riwayat peminjaman user yang login
     */
    public function index()
    {
        // Ambil semua peminjaman user yang sedang login
        $riwayat = Peminjaman::where('user_id', auth()->id())
            ->with([
                'detailPeminjaman.buku',
                'pengembalian'
            ])
            ->orderByDesc('tgl_pinjam')
            ->paginate(10);

        return view('riwayat-peminjaman.index', [
            'riwayat' => $riwayat,
            'title' => 'Riwayat Peminjaman'
        ]);
    }

    /**
     * Tampilkan detail satu peminjaman
     */
    public function show($id)
    {
        // Ambil peminjaman berdasarkan ID
        $peminjaman = Peminjaman::findOrFail($id);

        // Cek apakah user yang login adalah pemilik peminjaman ini
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke riwayat peminjaman ini.');
        }

        // Load relasi
        $peminjaman->load([
            'user',
            'detailPeminjaman.buku',
            'pengembalian'
        ]);

        // Hitung keterlambatan jika ada
        $keterlambatan = null;
        if ($peminjaman->pengembalian) {
            $tglKembali = $peminjaman->pengembalian->tgl_kembali;
            $tglTempo = $peminjaman->tgl_jatuh_tempo;
            
            if ($tglKembali > $tglTempo) {
                $keterlambatan = $tglKembali->diffInDays($tglTempo);
            }
        }

        return view('riwayat-peminjaman.show', [
            'peminjaman' => $peminjaman,
            'keterlambatan' => $keterlambatan,
            'title' => 'Detail Riwayat Peminjaman'
        ]);
    }

    /**
     * Hitung jumlah peminjaman yang sedang berjalan (belum dikembalikan)
     */
    public function hitungPeminjamanAktif()
    {
        return Peminjaman::where('user_id', auth()->id())
            ->where('status', 'dipinjam')
            ->count();
    }

    /**
     * Hitung jumlah peminjaman yang terlambat
     */
    public function hitungPeminjamanTerlambat()
    {
        return Peminjaman::where('user_id', auth()->id())
            ->where('status', 'dipinjam')
            ->where('tgl_jatuh_tempo', '<', now()->toDateString())
            ->count();
    }

    /**
     * Tampilkan semua riwayat peminjaman anggota (HANYA untuk PETUGAS)
     */
    public function indexAll(Request $request)
    {
        // Cek authorization - hanya petugas yang bisa akses
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }

        // Base query
        $query = Peminjaman::with([
            'user',
            'detailPeminjaman.buku',
            'pengembalian'
        ]);

        // Filter berdasarkan nama anggota (pencarian)
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status peminjaman
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter berdasarkan role anggota
        if ($request->filled('role')) {
            $role = $request->get('role');
            $query->whereHas('user', function ($q) use ($role) {
                $q->where('role', $role);
            });
        }

        // Hitung total statistik dari query yang sudah difilter
        $totalPeminjaman = (clone $query)->count();
        $totalDipinjam = (clone $query)->doesntHave('pengembalian')->count();
        $totalDikembalikan = (clone $query)->has('pengembalian')->count();
        $totalTerlambat = (clone $query)
            ->doesntHave('pengembalian')
            ->where('tgl_jatuh_tempo', '<', now()->toDateString())
            ->count();

        // Urutkan berdasarkan tanggal peminjaman terbaru
        $riwayat = $query->orderByDesc('tgl_pinjam')->paginate(15);

        return view('riwayat-peminjaman.index-all', [
            'riwayat' => $riwayat,
            'totalPeminjaman' => $totalPeminjaman,
            'totalDipinjam' => $totalDipinjam,
            'totalDikembalikan' => $totalDikembalikan,
            'totalTerlambat' => $totalTerlambat,
            'title' => 'Riwayat Peminjaman Semua Anggota'
        ]);
    }

    /**
     * Tampilkan detail peminjaman anggota (HANYA untuk PETUGAS)
     */
    public function showAll($id)
    {
        // Cek authorization - hanya petugas yang bisa akses
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }

        // Load peminjaman dengan relasi
        $peminjaman = Peminjaman::with([
            'user',
            'detailPeminjaman.buku',
            'pengembalian'
        ])->findOrFail($id);

        // Hitung keterlambatan jika ada
        $keterlambatan = null;
        if ($peminjaman->pengembalian) {
            $tglKembali = $peminjaman->pengembalian->tgl_kembali;
            $tglTempo = $peminjaman->tgl_jatuh_tempo;
            
            if ($tglKembali > $tglTempo) {
                $keterlambatan = $tglKembali->diffInDays($tglTempo);
            }
        }

        return view('riwayat-peminjaman.show-all', [
            'peminjaman' => $peminjaman,
            'keterlambatan' => $keterlambatan,
            'title' => 'Detail Riwayat Peminjaman Anggota'
        ]);
    }
}
