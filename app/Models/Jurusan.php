<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    // Tentukan nama tabel (jika berbeda dari nama model plural)
    protected $table = 'jurusan';
    
    // Tentukan kolom yang dapat diisi massal (mass assignable)
    // Hanya kolom ini yang boleh diisi melalui create() atau update()
    protected $fillable = ['nama_jurusan', 'deskripsi'];
    
    /**
     * Relasi ke model User (one to many)
     * Satu jurusan dapat memiliki banyak user/siswa
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

