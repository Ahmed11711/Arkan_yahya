<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'phone' => '01000000000',
            'affiliate_code' => Str::random(8),
            'active' => true,
            'verified_kyc' => true,
            'type' => 'admin',
        ]);

         User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'phone' => '01111111111',
            'affiliate_code' => Str::random(8),
            'coming_affiliate' => null,
            'active' => true,
            'verified_kyc' => false,
            'type' => 'user',
        ]);

         User::factory(3)->create(); 
    }
}
