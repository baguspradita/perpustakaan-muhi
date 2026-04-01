<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     * Kita menggunakan middleware 'guest' di routes agar user yang sudah login tidak bisa ke sini
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman register
     */
    public function showRegister()
    {
        $jurusan = Jurusan::all();
        return view('auth.register', compact('jurusan'));
    }

    /**
     * Memproses data registrasi siswa baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8|confirmed',
            'nisn'       => 'required|string|max:20|unique:siswa,nisn',
            'no_telp'    => 'required|string|max:20',
            'jurusan_id' => 'required|exists:jurusan,id',
            'kelas'      => 'required|in:10,11,12',
            'alamat'     => 'required|string',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nisn.required'      => 'NISN wajib diisi.',
            'nisn.unique'        => 'NISN sudah terpakai.',
            'no_telp.required'   => 'Nomor telepon wajib diisi.',
            'jurusan_id.required' => 'Silakan pilih jurusan.',
            'kelas.required'     => 'Silakan pilih kelas.',
            'alamat.required'    => 'Alamat wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat akun baru di tabel users
            $user = User::create([
                'nama'     => $validated['nama'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'alamat'   => $validated['alamat'],
                'no_telp'  => $validated['no_telp'],
                'role'     => 'siswa',
            ]);

            // 2. Buat detail data di tabel siswa
            Siswa::create([
                'user_id'    => $user->id,
                'nisn'       => $validated['nisn'],
                'jurusan_id' => $validated['jurusan_id'],
                'kelas'      => $validated['kelas'],
            ]);

            DB::commit();

            // Langsung login setelah registrasi
            Auth::login($user);

            return redirect('/')
                ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->nama . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    /**
     * Memproses data login yang dikirim dari form
     */
    public function login(\Illuminate\Http\Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah credentials (email & pass) cocok dengan data di database
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            // Jika sukses, buat session baru
            $request->session()->regenerate();

            // Redirect ke halaman dashboard
            return redirect()->intended('/');
        }

        // Jika gagal, kembali ke login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Mengeluarkan user dari session (Logout)
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();

        // Hancurkan session agar tidak bisa dipakai lagi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
