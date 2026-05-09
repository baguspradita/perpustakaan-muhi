<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa (hanya untuk admin/petugas)
     */
    public function index(Request $request)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat melihat daftar siswa.');
        }

        // Query dasar mengambil siswa dan relasi jurusannya
        $query = User::with(['siswa', 'jurusan'])->where('role', 'siswa');

        // Jika ada filter jurusan dari request (dropdown)
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan_id);
            });
        }

        // Jika ada pencarian nama
        if ($request->has('cari') && $request->cari != '') {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        // Jika ada filter status dari request
        if ($request->has('status') && $request->status != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Ambil data siswa dengan pagination
        $siswa = $query->latest()->paginate(12)->withQueryString();

        // Ambil semua jurusan untuk dropdown filter
        $jurusan = Jurusan::where('status', 'aktif')->get();

        // Hitung statistik untuk dashboard atas
        $stats = [
            'total'       => Siswa::count(),
            'aktif'       => Siswa::where('status', 'aktif')->count(),
            'lulus'       => Siswa::where('status', 'lulus')->count(),
            'dikeluarkan' => Siswa::where('status', 'dikeluarkan')->count() + Siswa::where('status', 'pindah')->count(),
        ];

        // Tampilkan view 'siswa.index' dengan data siswa, jurusan, dan statistik
        return view('siswa.index', compact('siswa', 'jurusan', 'stats'));
    }

    /**
     * Menampilkan detail siswa
     */
    public function show($id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::with(['siswa', 'jurusan'])->where('role', 'siswa')->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Menampilkan form edit data siswa
     */
    public function edit($id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::with(['siswa', 'jurusan'])->where('role', 'siswa')->findOrFail($id);
        $jurusan = Jurusan::where('status', 'aktif')->get();

        return view('siswa.edit', compact('siswa', 'jurusan'));
    }

    /**
     * Menyimpan perubahan data siswa
     */
    public function update(Request $request, $id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $id,
            'no_telp'    => 'nullable|string|max:20',
            'alamat'     => 'nullable|string|max:500',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'kelas'      => 'nullable|string|max:50',
            'status'     => 'nullable|in:aktif,lulus,dikeluarkan,pindah',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan oleh pengguna lain.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Simpan perubahan ke tabel users
        $siswa->update([
            'nama'    => $validated['nama'],
            'email'   => $validated['email'],
            'no_telp' => $validated['no_telp'],
            'alamat'  => $validated['alamat'],
        ]);

        // Simpan perubahan ke tabel siswa (detail profil)
        $siswaData = [
            'jurusan_id' => $validated['jurusan_id'],
            'kelas'      => $validated['kelas'],
        ];

        if (isset($validated['status'])) {
            $siswaData['status'] = $validated['status'];
        }

        $siswa->siswa()->update($siswaData);

        return redirect()->route('siswa.show', $id)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa (soft delete)
     */
    public function destroy($id)
    {
        // Periksa apakah user adalah admin/petugas
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses ditolak.');
        }

        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Cek apakah siswa memiliki peminjaman aktif
        $activeLoan = \App\Models\Peminjaman::where('user_id', $id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($activeLoan) {
            return back()->with('error', 'Tidak bisa menghapus siswa! Siswa masih memiliki peminjaman aktif.');
        }

        // Soft delete siswa dan user
        $siswa->delete();
        $siswa->siswa()->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function editStatus($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit-status', compact('siswa'));
    }

    /**
     * Update status siswa
     */
    public function updateStatus(Request $request, $id)
    {
        // $id di sini adalah user_id
        $user = User::where('role', 'siswa')->findOrFail($id);
        $siswa = $user->siswa;

        if (!$siswa) {
            return back()->with('error', 'Data profil siswa tidak ditemukan.');
        }

        $validated = $request->validate([
            'status' => 'required|in:aktif,lulus,dikeluarkan,pindah',
        ]);

        try {
            DB::beginTransaction();

            $siswa->update($validated);

            DB::commit();

            $statusText = match ($validated['status']) {
                'aktif' => 'Aktif',
                'lulus' => 'Lulus',
                'dikeluarkan' => 'Dikeluarkan',
                'pindah' => 'Pindah',
            };

            return redirect()->route('siswa.index')
                ->with('success', "Status siswa '{$user->nama}' berhasil diubah menjadi '{$statusText}'.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle/Quick change status siswa
     */
    public function quickChangeStatus(Request $request, $id)
    {
        // $id di sini adalah user_id
        $user = User::where('role', 'siswa')->findOrFail($id);
        $siswa = $user->siswa;

        if (!$siswa) {
            return back()->with('error', 'Data profil siswa tidak ditemukan.');
        }

        $validated = $request->validate([
            'status' => 'required|in:aktif,lulus,dikeluarkan,pindah',
        ]);

        try {
            DB::beginTransaction();

            $siswa->update($validated);

            DB::commit();

            $statusText = match ($validated['status']) {
                'aktif' => 'Aktif',
                'lulus' => 'Lulus',
                'dikeluarkan' => 'Dikeluarkan',
                'pindah' => 'Pindah',
            };

            return back()->with('success', "Status siswa '{$user->nama}' berhasil diubah menjadi '{$statusText}'.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
