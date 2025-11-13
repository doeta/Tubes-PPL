<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlatformUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create platform admin user
        User::create([
            'name' => 'Platform Admin',
            'email' => 'admin@marketplace.com',
            'password' => Hash::make('password'),
            'role' => 'platform',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
