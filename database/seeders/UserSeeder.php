<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin ManChi',
            'email' => 'admin@manchistore.com',
            'password' => Hash::make('password123'), // Password default
        ]);
    }
}