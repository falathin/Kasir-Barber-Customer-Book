<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CustomerBookSeeder;
use Database\Seeders\CapsterSeeder; // Import CapsterSeeder
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create(); // contoh user
        $this->call(CustomerBookSeeder::class);
        $this->call(CapsterSeeder::class); // Panggil CapsterSeeder di sini
    }
}