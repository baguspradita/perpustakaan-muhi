<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil user yang sedang login
     */
    public function edit()
    {
        $user = auth()->user();
        $jurusan = Jurusan::all();
        
        return view('profile.edit', compact('user', 'jurusan'));
    }

    /**
     * Menyimpan perubahan profil
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'no_telp'    => 'nullable|string|max:20',
            'alamat'     => 'nullable|string|max:500',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'kelas'      => 'nullable|string|max:50',
        ], [
            'nama.required'     => 'Nama wajib diisi.',
        ]);

        // Update data dasar
        $user->nama = $validated['nama'];
        $user->no_telp = $validated['no_telp'];
        $user->alamat = $validated['alamat'];
        $user->jurusan_id = $validated['jurusan_id'];
        $user->kelas = $validated['kelas'];

        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
