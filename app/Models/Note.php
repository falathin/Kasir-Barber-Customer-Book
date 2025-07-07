<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'note',
        'kasir_name',
    ];

    public function getNoteAttribute($value)
    {
        return $value ?: '';
    }
}