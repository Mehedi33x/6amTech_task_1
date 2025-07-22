<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Developer',
            'email' => 'developer@test.com',
            'password' => Hash::make('123456'),
            'role' => 'developer',
        ]);
    }
}