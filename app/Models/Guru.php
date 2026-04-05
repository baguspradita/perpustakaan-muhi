<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'mapel',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
