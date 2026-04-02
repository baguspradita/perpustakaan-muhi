<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjekBuku extends Model
{
    // Tentukan nama tabel (jika berbeda dari nama model plural)
    protected $table = 'subjek_buku';
    
    // Tentukan kolom yang dapat diisi massal (mass assignable)
    protected $fillable = ['kode_ddc', 'nama_subjek', 'deskripsi'];

    /**
     * Relasi ke model Buku (one to many)
     * Satu subjek dapat memiliki banyak buku
     */
    public function buku()
    {
        return $this->hasMany(Buku::class, 'subjek_id');
    }
}
