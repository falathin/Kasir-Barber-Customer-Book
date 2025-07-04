<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'note', // hanya satu kolom note
        'kasir_name', // nama kasir yang membuat catatan
    ];

    public function getNoteAttribute($value)
    {
        return $value ?: ''; // Mengembalikan string kosong jika null
    }
}
