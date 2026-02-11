<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@handal.com',
            'password' => Hash::make('adminhandal123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Validator
        User::create([
            'name' => 'Validator',
            'email' => 'validator@handal.com',
            'password' => Hash::make('validatorhandal123'),
            'role' => 'validator',
            'status' => 'active',
        ]);

    }
}