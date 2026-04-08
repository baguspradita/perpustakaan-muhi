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
            'jurusan_id' => $user->role === 'siswa' ? 'nullable|exists:jurusan,id' : 'nullable',
            'kelas'      => $user->role === 'siswa' ? 'nullable|string|max:50' : 'nullable',
        ], [
            'nama.required'     => 'Nama wajib diisi.',
        ]);

        // Update data dasar
        $user->nama = $validated['nama'];
        $user->no_telp = $validated['no_telp'];
        $user->alamat = $validated['alamat'];

        if ($user->role === 'siswa') {
            $user->jurusan_id = $validated['jurusan_id'];
            $user->kelas = $validated['kelas'];
        }

        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Memperbarui kata sandi user
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required'         => 'Kata sandi baru wajib diisi.',
            'password.min'              => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = auth()->user();

        // Cek apakah kata sandi saat ini benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak sesuai.']);
        }

        // Simpan kata sandi baru
        /** @var \App\Models\User $user */
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Kata sandi Anda berhasil diperbarui.');
    }
}
