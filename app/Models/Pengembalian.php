<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $fillable = ['peminjaman_id', 'tgl_kembali', 'denda'];

    protected $casts = [
        'tgl_kembali' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
