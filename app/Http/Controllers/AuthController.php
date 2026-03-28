<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
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
            'no_telp'    => 'nullable|string|max:20',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'kelas'      => 'nullable|string|max:50',
            'alamat'     => 'nullable|string',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Buat akun baru dengan role default 'siswa'
        $user = User::create([
            'nama'       => $validated['nama'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'no_telp'    => $validated['no_telp'] ?? null,
            'jurusan_id' => $validated['jurusan_id'] ?? null,
            'kelas'      => $validated['kelas'] ?? null,
            'alamat'     => $validated['alamat'] ?? null,
            'role'       => 'siswa', // Default role selalu siswa
        ]);

        // Langsung login setelah registrasi
        Auth::login($user);

        return redirect('/')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->nama . '.');
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
