<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Add this line
use Illuminate\Database\Eloquent\Model;

class Capster extends Model
{
    use HasFactory; // <-- Add this line

    protected $fillable = [
        'nama',
        'inisial',
        'jenis_kelamin',
        'no_hp',
        'tgl_lahir',
        'asal',
        'foto',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    /**
     * Helper untuk mengembalikan URL foto (atau default avatar).
     */
    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('images/bb-logo.png'); // Ganti dengan path default avatar
    }
}