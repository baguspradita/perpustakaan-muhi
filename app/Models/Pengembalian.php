<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $fillable = ['peminjaman_id', 'tgl_kembali', 'denda'];
    public $timestamps = false;

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
