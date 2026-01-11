<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerBook extends Model
{
    protected $fillable = [
        'customer',
        'cap',
        'asisten',
        'haircut_type',
        'barber_name',
        'colouring_other',
        'sell_use_product',
        'price',
        'qr',
        'rincian',
        'created_time',
        'antrian',
        // manual columns
        'hair_coloring_price',
        'hair_extension_price',
        'hair_extension_services_price',
    ];

    public function capster()
    {
        return $this->belongsTo(Capster::class, 'cap', 'inisial');
    }

    public function asistenCapster()
    {
        return $this->belongsTo(Capster::class, 'asisten', 'inisial');
    }
}
