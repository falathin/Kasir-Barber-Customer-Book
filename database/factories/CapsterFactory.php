<?php

namespace Database\Factories;

use App\Models\Capster;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage; // Import Storage

class CapsterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Capster::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan direktori ada sebelum menyimpan gambar dummy
        if (!Storage::disk('public')->exists('capsters')) {
            Storage::disk('public')->makeDirectory('capsters');
        }

        // Generate a dummy image and save it to storage/app/public/capsters
        // faker()->image() returns the full path, we only need the relative path from 'public/storage'
        $imagePath = $this->faker->image(
            storage_path('app/public/capsters'), // Directory to save the image
            200, 200, // Width and Height
            'people', // Category
            false // Don't include the full path in the returned value, just the filename
        );

        // Prepend 'capsters/' to the filename to match how it's stored
        $storedImagePath = 'capsters/' . basename($imagePath);

        return [
            'nama' => $this->faker->name(),
            'inisial' => $this->faker->unique()->regexify('[A-Z]{2}'), // Example: generate two uppercase letters
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'no_hp' => $this->faker->unique()->phoneNumber(),
            'tgl_lahir' => $this->faker->date(),
            'asal' => $this->faker->city(),
            'foto' => $storedImagePath, // Store the path to the dummy image
        ];
    }
}