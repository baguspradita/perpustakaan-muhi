<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Hanya `petugas` yang dapat mengakses controller ini
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || auth()->user()->role !== 'petugas') {
                abort(403, 'Akses ditolak. Hanya petugas yang dapat mengelola data guru.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar semua guru
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $guru = Guru::with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                })
                ->orWhere('nip', 'like', "%$search%")
                ->orWhere('mapel', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('guru.index', compact('guru', 'search'));
    }

    /**
     * Menampilkan form untuk menambah guru
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Menyimpan guru baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:20|unique:guru,nip',
            'mapel' => 'required|string|max:100',
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'nip.unique' => 'Nomor NIP sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat User baru dengan role guru
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'guru',
            ]);

            // 2. Buat data Guru yang terhubung ke user
            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'mapel' => $request->mapel,
                'status' => 'aktif',
            ]);

            DB::commit();

            return redirect()->route('guru.index')
                ->with('success', "Guru '{$user->nama}' berhasil didaftarkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail guru
     */
    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        return view('guru.show', compact('guru'));
    }

    /**
     * Menampilkan form edit guru
     */
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('guru.edit', compact('guru'));
    }

    /**
     * Memperbarui data guru
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $guru->user_id,
            'password' => 'nullable|string|min:8',
            'nip' => 'required|string|max:20|unique:guru,nip,' . $id,
            'mapel' => 'required|string|max:100',
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh user lain.',
            'nip.unique' => 'Nomor NIP sudah digunakan.',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update data User
            $userData = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
            
            $guru->user->update($userData);

            // 2. Update data Guru
            $guru->update([
                'nip' => $request->nip,
                'mapel' => $request->mapel,
            ]);

            DB::commit();

            return redirect()->route('guru.show', $id)
                ->with('success', "Data guru '{$guru->user->nama}' berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus guru
     */
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $namaGuru = $guru->user->nama;

        try {
            DB::beginTransaction();

            $guru->delete();

            DB::commit();

            return redirect()->route('guru.index')
                ->with('success', "Data guru '{$namaGuru}' berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update status guru
     */
    public function updateStatus(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            DB::beginTransaction();

            $guru->update($validated);

            DB::commit();

            $statusText = $validated['status'] === 'aktif' ? 'Diaktifkan' : 'Dinonaktifkan';
            return back()->with('success', "Status guru '{$guru->user->nama}' berhasil {$statusText}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
