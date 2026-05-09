<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi = Lokasi::latest()->paginate(10);
        return view('master.lokasi.index', compact('lokasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100',
            'keterangan'  => 'nullable|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lokasi $lokasi)
    {
        return redirect()->route('lokasi.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lokasi $lokasi)
    {
        return view('master.lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100',
            'keterangan'  => 'nullable|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        $lokasi->update($request->all());

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lokasi $lokasi)
    {
        // Pastikan tidak ada buku di lokasi ini sebelum dihapus (opsional, tapi disarankan)
        if ($lokasi->buku()->count() > 0) {
            return redirect()->route('lokasi.index')
                ->with('error', 'Lokasi tidak dapat dihapus karena masih digunakan oleh buku.');
        }

        $lokasi->delete();

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }

    /**
     * Update status lokasi
     */
    public function updateStatus(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            $lokasi->update($validated);
            
            $statusText = $validated['status'] === 'aktif' ? 'Diaktifkan' : 'Dinonaktifkan';
            return back()->with('success', "Status lokasi '{$lokasi->nama_lokasi}' berhasil {$statusText}.");
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
