<?php

namespace Database\Seeders;

use App\Models\Capster; // Import model Capster
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapsterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data capster yang ada sebelum seeding baru (opsional)
        Capster::truncate();

        // Buat 20 data capster dummy menggunakan factory
        Capster::factory()->count(20)->create();
    }
}