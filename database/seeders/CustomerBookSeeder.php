<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerBook;
use Illuminate\Support\Str;

class CustomerBookSeeder extends Seeder
{
    public function run(): void
    {
        $barbers = [
            "BBmen's Haircut 1",
            "BBmen's Haircut 2",
            "BBmen's Haircut 3",
            "BBmen's Haircut 4"
        ];

        $haircuts = [
            ['type' => 'Gentle', 'price' => 40000],
            ['type' => 'Ladies', 'price' => 55000],
        ];

        $names = ['Rizky', 'Putra', 'Sari', 'Agus', 'Lina', 'Fajar', 'Nina', 'Dimas', 'Vina', 'Asep'];

        for ($i = 1; $i <= 40; $i++) {
            $name = $names[array_rand($names)] . ' ' . strtoupper(Str::random(3));
            $haircut = $haircuts[array_rand($haircuts)];
            $price = $haircut['price'] + rand(-5000, 5000); // variasi harga ±5k

            CustomerBook::create([
                'customer' => $name,
                'cap' => 'Cap ' . rand(1, 30),
                'haircut_type' => $haircut['type'],
                'barber_name' => $barbers[array_rand($barbers)],
                'colouring_other' => rand(0, 3) == 1 ? 'Highlight' : null,
                'sell_use_product' => rand(0, 3) == 1 ? 'Pomade' : null,
                'price' => $price,
                'qr' => strtoupper(Str::random(10)),
            ]);
        }
    }
}