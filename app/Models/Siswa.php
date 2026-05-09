<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nisn',
        'jurusan_id',
        'kelas',
        'status',
    ];

    // Method helper untuk menampilkan label status
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'aktif' => 'Aktif',
            'lulus' => 'Lulus',
            'dikeluarkan' => 'Dikeluarkan',
            'pindah' => 'Pindah',
            default => 'Unknown'
        };
    }

      // Method helper untuk warna badge
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'aktif' => 'emerald',      // Hijau
            'lulus' => 'blue',         // Biru
            'dikeluarkan' => 'red',    // Merah
            'pindah' => 'amber',       // Kuning/Oranye
            default => 'slate'
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
