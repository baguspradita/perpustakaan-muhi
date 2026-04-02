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
        // Hanya ambil user dengan role 'guru' yang belum terdaftar di tabel guru
        $availableUsers = User::where('role', 'guru')
            ->doesntHave('guru')
            ->get();

        return view('guru.create', compact('availableUsers'));
    }

    /**
     * Menyimpan guru baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:guru,user_id',
            'nip' => 'required|string|max:20|unique:guru,nip',
            'mapel' => 'required|string|max:100',
        ], [
            'user_id.unique' => 'User ini sudah terdaftar sebagai guru.',
            'nip.unique' => 'Nomor NIP sudah digunakan.',
        ]);

        try {
            DB::beginTransaction();

            Guru::create($validated);

            DB::commit();

            return redirect()->route('guru.index')
                ->with('success', 'Data guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:guru,nip,' . $id,
            'mapel' => 'required|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $guru->update($validated);

            DB::commit();

            return redirect()->route('guru.show', $id)
                ->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
}
