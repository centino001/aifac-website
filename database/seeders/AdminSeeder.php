<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@anyeniyakfoundation.org'],
            [
                'name' => 'Admin User',
                'email' => 'admin@anyeniyakfoundation.org',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create a secondary admin for backup
        User::firstOrCreate(
            ['email' => 'admin@aifac.org'],
            [
                'name' => 'AIFAC Admin',
                'email' => 'admin@aifac.org',
                'password' => Hash::make('aifac2024'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
