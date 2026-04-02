<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Peminjaman;

class PeminjamanPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // User hanya bisa melihat peminjaman miliknya sendiri
        return $user->id === $peminjaman->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Hanya user dengan role 'siswa' atau 'guru' yang bisa membuat peminjaman
        return in_array($user->role, ['siswa', 'guru']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Peminjaman $peminjaman): bool
    {
        // Hanya petugas yang bisa update peminjaman
        return $user->role === 'petugas';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Peminjaman $peminjaman): bool
    {
        // Hanya petugas yang bisa delete peminjaman
        return $user->role === 'petugas';
    }
}
