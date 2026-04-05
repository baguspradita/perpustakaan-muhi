<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'alamat',
        'no_telp',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Relasi shortcut ke Jurusan melalui Siswa
     */
    public function jurusan()
    {
        return $this->hasOneThrough(
            Jurusan::class,
            Siswa::class,
            'user_id',    // FK di tabel siswa
            'id',         // FK di tabel jurusan
            'id',         // Local key di tabel users
            'jurusan_id'  // Local key di tabel siswa
        );
    }

    /**
     * Accessor untuk jurusan_id dari tabel siswa
     */
    public function getJurusanIdAttribute()
    {
        return $this->siswa->jurusan_id ?? null;
    }

    /**
     * Accessor untuk kelas dari tabel siswa
     */
    public function getKelasAttribute()
    {
        return $this->siswa->kelas ?? null;
    }

    /**
     * Relasi ke model Guru
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * Accessor untuk NIP dari tabel guru
     */
    public function getNipAttribute()
    {
        return $this->guru->nip ?? null;
    }

    /**
     * Accessor untuk Mapel dari tabel guru
     */
    public function getMapelAttribute()
    {
        return $this->guru->mapel ?? null;
    }
}
