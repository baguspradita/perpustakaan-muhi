<?php

namespace App\Traits;

use App\Models\Siswa;
use App\Models\Guru;

trait ChecksUserStatus
{
    /**
     * Cek apakah user masih aktif
     */
    public function isUserActive($user): bool
    {
        if ($user->role === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            return $siswa && $siswa->status === 'aktif';
        }

        if ($user->role === 'guru') {
            $guru = Guru::where('user_id', $user->id)->first();
            return $guru && $guru->status === 'aktif';
        }

        return true;
    }

    /**
     * Ambil pesan error sesuai tipe user
     */
    public function getInactiveMessage($user): string
    {
        if ($user->role === 'siswa') {
            return 'Akun siswa tidak aktif. Hubungi petugas perpustakaan.';
        }

        if ($user->role === 'guru') {
            return 'Akun guru tidak aktif. Hubungi petugas perpustakaan.';
        }

        return 'Akun Anda tidak aktif. Hubungi petugas perpustakaan.';
    }
}