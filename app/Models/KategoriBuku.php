<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    // Tentukan nama tabel (jika berbeda dari nama model plural)
    protected $table = 'kategori_buku';
    
    // Tentukan kolom yang dapat diisi massal (mass assignable)
    // Hanya kolom ini yang boleh diisi melalui create() atau update()
    protected $fillable = ['nama_kategori', 'deskripsi'];
    
    // Disable timestamps (created_at, updated_at) jika tidak ada di tabel
    public $timestamps = false;

    /**
     * Relasi ke model Buku (one to many)
     * Satu kategori dapat memiliki banyak buku
     */
    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}

