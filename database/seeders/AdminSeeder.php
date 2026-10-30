<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Dear Haens',
            // Mengambil email dari file .env
            'email' => env('ADMIN_EMAIL', 'admin@pustaka.com'), 
            // Mengambil password dari file .env
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')), 
        ]);
    }
}