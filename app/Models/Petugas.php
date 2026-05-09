<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'user_id',
        'nip',
        'jabatan',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
