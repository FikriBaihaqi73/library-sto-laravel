<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Library',
            'role' => 'admin',
            'email' => 'admin@library.com',
            'password' => Hash::make('password'),
        ]);

        // Create Staff User
        User::create([
            'name' => 'Staff Library',
            'role' => 'staff',
            'email' => 'staff@library.com',
            'password' => Hash::make('password'),
        ]);
    }
}
