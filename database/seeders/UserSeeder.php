<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Admin
        User::create([
            'name' => 'Admin Handal',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Membuat Validator
        User::create([
            'name' => 'Validator Sulsel',
            'email' => 'validator@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'validator',
            'status' => 'active',
        ]);

    }
}