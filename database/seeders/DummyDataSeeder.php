<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'icon' => '💻'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => '👕'],
            ['name' => 'Rumah & Furniture', 'slug' => 'rumah-furniture', 'icon' => '🏠'],
            ['name' => 'Buku & Alat Tulis', 'slug' => 'buku-alat-tulis', 'icon' => '📚'],
            ['name' => 'Mainan & Hobi', 'slug' => 'mainan-hobi', 'icon' => '🎮'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'icon' => '📦'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'icon' => $cat['icon'],
                'description' => 'Kategori ' . $cat['name'],
                'is_active' => true,
            ]);
        }

        // Create Sellers with Seller Profile
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "Seller $i",
                'email' => "seller$i@test.com",
                'password' => Hash::make('password'),
                'role' => 'seller',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            Seller::create([
                'user_id' => $user->id,
                'nama_toko' => "Toko Seller $i",
                'deskripsi_singkat' => "Toko yang menjual berbagai produk berkualitas",
                'nama_pic' => "PIC Seller $i",
                'no_ktp_pic' => str_pad($i, 16, '0', STR_PAD_LEFT),
                'alamat_ktp_pic' => "Alamat KTP Seller $i",
                'email_pic' => "seller$i@test.com",
                'alamat' => "Jalan Raya No. $i, Jakarta",
                'nama_kelurahan' => 'Kelurahan ' . $i,
                'kecamatan' => 'Kecamatan ' . $i,
                'kabupaten_kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'verification_status' => 'approved',
                'verified_at' => now(),
            ]);

            // Create Products for each seller
            $categoryIds = Category::pluck('id')->toArray();
            
            for ($j = 1; $j <= 5; $j++) {
                $product = Product::create([
                    'user_id' => $user->id,
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'name' => "Produk $j dari Seller $i",
                    'slug' => Str::slug("Produk $j dari Seller $i") . '-' . uniqid(),
                    'description' => "Deskripsi lengkap untuk Produk $j dari Seller $i. Produk berkualitas tinggi dengan harga terjangkau.",
                    'price' => rand(10000, 500000),
                    'stock' => rand(10, 100),
                    'image' => 'https://via.placeholder.com/400x400?text=Product+' . $j,
                    'status' => 'active',
                    'views' => rand(0, 1000),
                    'sold' => rand(0, 50),
                ]);
            }
        }

        // Create Buyer
        $buyer = User::create([
            'name' => 'Buyer Test',
            'email' => 'buyer@test.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create some Orders
        $products = Product::with('user')->get();
        foreach ($products->take(10) as $product) {
            Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $buyer->id,
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
                'price' => $product->price,
                'total' => $product->price * rand(1, 3),
                'status' => ['pending', 'processing', 'shipped', 'delivered'][array_rand(['pending', 'processing', 'shipped', 'delivered'])],
                'shipping_address' => 'Jl. Test No. 123, Jakarta',
                'phone' => '08123456789',
            ]);
        }

        echo "\nDummy data created successfully!\n";
        echo "Categories: 6\n";
        echo "Sellers: 3 (seller1@test.com, seller2@test.com, seller3@test.com)\n";
        echo "Products: 15 (5 per seller)\n";
        echo "Buyer: 1 (buyer@test.com)\n";
        echo "Orders: 10\n";
        echo "\nPassword for all test accounts: password\n";
    }
}
