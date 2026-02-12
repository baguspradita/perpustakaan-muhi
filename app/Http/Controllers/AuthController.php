<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
