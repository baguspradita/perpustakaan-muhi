<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $fillable = [
        'nama_lokasi',
        'keterangan',
        'status',
    ];

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

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
}
