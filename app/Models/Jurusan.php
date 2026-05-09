<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    // Tentukan nama tabel (jika berbeda dari nama model plural)
    protected $table = 'jurusan';
    
    // Tentukan kolom yang dapat diisi massal (mass assignable)
    // Hanya kolom ini yang boleh diisi melalui create() atau update()
    protected $fillable = ['nama_jurusan', 'deskripsi', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'nonaktif' => 'Tidak Aktif',
            default => 'Unknown'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'aktif' => 'emerald',
            'nonaktif' => 'red',
            default => 'slate'
        };
    }
    
    /**
     * Relasi ke model Siswa (one to many)
     * Satu jurusan dapat memiliki banyak siswa
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}

