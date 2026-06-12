<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'farahdivanazwanda@gmail.com'],
            [
                'name' => 'Farah Diva',
                'password' => Hash::make('12345678'),
                'role' => 'pelanggan',
                'email_verified_at' => now(),
            ]
        );
    }
}
