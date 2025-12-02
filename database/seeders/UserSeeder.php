<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin PojokKampus',
            'email' => 'admin@pojokkampus.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Sellers
        $sellers_data = [
            [
                'name' => 'Toko Elektronik Jaya',
                'email' => 'elektronik.jaya@gmail.com',
                'password' => Hash::make('seller123'),
                'role' => 'seller',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Fashion Store',
                'email' => 'fashion.store@gmail.com',
                'password' => Hash::make('seller123'),
                'role' => 'seller',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Warung Kampus',
                'email' => 'warung.kampus@gmail.com',
                'password' => Hash::make('seller123'),
                'role' => 'seller',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($sellers_data as $seller_data) {
            $user = User::create($seller_data);
            
            // Create seller profile
            Seller::create([
                'user_id' => $user->id,
                'nama_toko' => $user->name,
                'deskripsi_singkat' => 'Toko terpercaya dengan produk berkualitas',
                'nama_pic' => $user->name,
                'no_ktp_pic' => '3171' . str_pad($user->id, 12, '0', STR_PAD_LEFT),
                'alamat_ktp_pic' => 'Jl. Contoh No. ' . $user->id . ', Jakarta',
                'email_pic' => $user->email,
                'alamat' => 'Jl. Toko No. ' . $user->id . ', Jakarta',
                'nama_kelurahan' => 'Kelurahan Contoh',
                'kecamatan' => 'Kecamatan Contoh',
                'kabupaten_kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'verification_status' => 'approved',
            ]);
        }

        // Create regular users
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'buyer',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'buyer',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user_data) {
            User::create($user_data);
        }

        echo "Users and Sellers created successfully!\n";
    }
}