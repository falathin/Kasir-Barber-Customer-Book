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
        'hair_coloring_price',
        'hair_extension_price',
        'hair_extension_services_price',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'price' => 'decimal:2',
        'hair_coloring_price' => 'decimal:2',
        'hair_extension_price' => 'decimal:2',
        'hair_extension_services_price' => 'decimal:2',
    ];

    public function capster()
    {
        return $this->belongsTo(Capster::class, 'cap', 'inisial');
    }

    public function asistenCapster()
    {
        return $this->belongsTo(Capster::class, 'asisten', 'inisial');
    }

    public function getTotalPenjualanAttribute()
    {
        return (float) $this->price
            + (float) $this->hair_coloring_price
            + (float) $this->hair_extension_price
            + (float) $this->hair_extension_services_price;
    }
}