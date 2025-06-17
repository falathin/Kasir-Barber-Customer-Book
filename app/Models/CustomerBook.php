<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerBook extends Model
{
    protected $fillable = [
        'customer',
        'cap',
        'haircut_type',
        'barber_name',
        'colouring_other',
        'sell_use_product',
        'price',
        'qr',
    ];
    public function capster()
    {
        return $this->belongsTo(Capster::class, 'cap', 'inisial');
    }

}