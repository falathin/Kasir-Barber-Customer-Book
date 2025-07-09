<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capster extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'inisial',
        'jenis_kelamin',
        'no_hp',
        'tgl_lahir',
        'asal',
        'foto',
        'status',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('images/bb-logo.png');
    }
}
