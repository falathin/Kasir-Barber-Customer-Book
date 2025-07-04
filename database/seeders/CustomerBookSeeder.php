<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerBook;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
            $price = $haircut['price'] + rand(-5000, 5000);

            $capInisial = 'C' . rand(1, 10);
            $asistenInisial = rand(0, 3) === 1 ? 'C' . rand(11, 20) : null; // kadang ada, kadang tidak

            CustomerBook::create([
                'customer' => $name,
                'cap' => $capInisial,
                'asisten' => $asistenInisial,
                'haircut_type' => $haircut['type'],
                'barber_name' => $barbers[array_rand($barbers)],
                'colouring_other' => rand(0, 3) === 1 ? 'Highlight, Bleaching' : null,
                'sell_use_product' => rand(0, 2) === 1 ? 'Pomade, Tonic' : null,
                'price' => $price,
                'qr' => rand(0, 1) ? 'qr_transfer' : 'cash',
                'rincian' => rand(0, 1) ? 'Cat rambut tambahan' : null,
                'created_time' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 12)),
            ]);
        }
    }
}