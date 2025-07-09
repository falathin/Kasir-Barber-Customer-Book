<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    User::updateOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin Utama',
            'password' => Hash::make('admin1234'),
            'level' => 'admin',
        ]
    );
    // User::updateOrCreate(
    //     ['email' => 'kasir@gmail.com'],
    //     [
    //         'name' => 'Kasir testing',
    //         'password' => Hash::make('admin1234'),
    //         'level' => 'kasir',
    //     ]
    // );
}
}
