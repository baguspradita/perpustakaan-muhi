<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use SoftDeletes;
    // Tentukan nama tabel (jika berbeda dari nama model plural)
    protected $table = 'buku';
    
    // Tentukan kolom yang dapat diisi massal (mass assignable)
    // Hanya kolom ini yang boleh diisi melalui create() atau update()
    protected $fillable = [
        'judul', 
        'nama_depan_penulis',
        'nama_belakang_penulis',
        'penerbit', 
        'tahun_terbit', 
        'kategori_id', 
        'subjek_id',
        'lokasi_id', 
        'jumlah',
        'huruf_judul_awal',
        'nomor_salinan'
    ];

    /**
     * Relasi ke model KategoriBuku (many to one)
     * Banyak buku dapat memiliki satu kategori
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }

    /**
     * Relasi ke model SubjekBuku (many to one)
     * Banyak buku dapat memiliki satu subjek
     */
    public function subjek()
    {
        return $this->belongsTo(SubjekBuku::class, 'subjek_id');
    }

    /**
     * Relasi ke model Lokasi (many to one)
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
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

