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
            'email' => 'admin@handal.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Membuat Validator
        User::create([
            'name' => 'Validator Sulsel',
            'email' => 'validator@handal.com',
            'password' => Hash::make('password123'),
            'role' => 'validator',
            'status' => 'active',
        ]);
    }
}