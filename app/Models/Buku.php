<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // Tentukan nama tabel (jika berbeda dari nama model plural)
    protected $table = 'buku';
    
    // Tentukan kolom yang dapat diisi massal (mass assignable)
    // Hanya kolom ini yang boleh diisi melalui create() atau update()
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'kategori_id', 'jumlah'];

    /**
     * Relasi ke model KategoriBuku (many to one)
     * Banyak buku dapat memiliki satu kategori
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }

    /**
     * Relasi ke model DetailPeminjaman (one to many)
     * Satu buku dapat memiliki banyak detail peminjaman
     */
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}

