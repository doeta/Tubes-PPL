<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = User::where('role', 'seller')->get();
        $categories = Category::all();

        if ($sellers->isEmpty() || $categories->isEmpty()) {
            echo "Please run UserSeeder and CategorySeeder first!\n";
            return;
        }

        $products = [
            // Elektronik
            [
                'name' => 'Laptop Asus VivoBook',
                'description' => 'Laptop untuk mahasiswa dengan performa tinggi dan harga terjangkau',
                'price' => 8500000,
                'stock' => 15,
                'category_name' => 'Elektronik',
                'image_url' => 'https://via.placeholder.com/300x300?text=Laptop+Asus',
                'weight' => 2000,
                'condition' => 'new',
                'is_featured' => true,
            ],
            [
                'name' => 'Mouse Gaming RGB',
                'description' => 'Mouse gaming dengan LED RGB dan DPI tinggi',
                'price' => 250000,
                'stock' => 30,
                'category_name' => 'Elektronik',
                'image_url' => 'https://via.placeholder.com/300x300?text=Mouse+Gaming',
                'weight' => 200,
                'condition' => 'new',
                'is_featured' => false,
            ],
            [
                'name' => 'Powerbank 20000mAh',
                'description' => 'Powerbank dengan kapasitas besar untuk kebutuhan sehari-hari',
                'price' => 150000,
                'stock' => 25,
                'category_name' => 'Elektronik',
                'image_url' => 'https://via.placeholder.com/300x300?text=Powerbank',
                'weight' => 500,
                'condition' => 'new',
                'is_featured' => true,
            ],

            // Fashion
            [
                'name' => 'Kaos Polos Premium',
                'description' => 'Kaos polos berbahan cotton combed 30s yang nyaman dipakai',
                'price' => 75000,
                'stock' => 50,
                'category_name' => 'Fashion',
                'image_url' => 'https://via.placeholder.com/300x300?text=Kaos+Polos',
                'weight' => 200,
                'condition' => 'new',
                'is_featured' => false,
            ],
            [
                'name' => 'Jaket Hoodie Unisex',
                'description' => 'Jaket hoodie dengan bahan fleece yang hangat dan nyaman',
                'price' => 185000,
                'stock' => 20,
                'category_name' => 'Fashion',
                'image_url' => 'https://via.placeholder.com/300x300?text=Jaket+Hoodie',
                'weight' => 600,
                'condition' => 'new',
                'is_featured' => true,
            ],

            // Makanan & Minuman
            [
                'name' => 'Kopi Arabica Premium',
                'description' => 'Kopi arabica pilihan dengan cita rasa yang khas dan aroma yang harum',
                'price' => 85000,
                'stock' => 40,
                'category_name' => 'Makanan & Minuman',
                'image_url' => 'https://via.placeholder.com/300x300?text=Kopi+Arabica',
                'weight' => 250,
                'condition' => 'new',
                'is_featured' => true,
            ],
            [
                'name' => 'Snack Sehat Mix',
                'description' => 'Campuran snack sehat untuk teman belajar atau bekerja',
                'price' => 35000,
                'stock' => 60,
                'category_name' => 'Makanan & Minuman',
                'image_url' => 'https://via.placeholder.com/300x300?text=Snack+Mix',
                'weight' => 300,
                'condition' => 'new',
                'is_featured' => false,
            ],

            // Buku & Alat Tulis
            [
                'name' => 'Buku Catatan A5',
                'description' => 'Buku catatan dengan kualitas kertas yang bagus untuk mahasiswa',
                'price' => 25000,
                'stock' => 100,
                'category_name' => 'Buku & Alat Tulis',
                'image_url' => 'https://via.placeholder.com/300x300?text=Buku+Catatan',
                'weight' => 300,
                'condition' => 'new',
                'is_featured' => false,
            ],
            [
                'name' => 'Set Alat Tulis Lengkap',
                'description' => 'Set alat tulis lengkap dengan pensil, pulpen, penggaris, dan penghapus',
                'price' => 45000,
                'stock' => 35,
                'category_name' => 'Buku & Alat Tulis',
                'image_url' => 'https://via.placeholder.com/300x300?text=Alat+Tulis',
                'weight' => 250,
                'condition' => 'new',
                'is_featured' => true,
            ],

            // Olahraga
            [
                'name' => 'Matras Yoga Anti Slip',
                'description' => 'Matras yoga dengan permukaan anti slip untuk olahraga yang nyaman',
                'price' => 125000,
                'stock' => 18,
                'category_name' => 'Olahraga',
                'image_url' => 'https://via.placeholder.com/300x300?text=Matras+Yoga',
                'weight' => 1000,
                'condition' => 'new',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category_name'])->first();
            $seller = $sellers->random();
            
            if ($category) {
                $slug = \Illuminate\Support\Str::slug($productData['name']) . '-' . rand(1000, 9999);
                
                Product::create([
                    'name' => $productData['name'],
                    'slug' => $slug,
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'category_id' => $category->id,
                    'user_id' => $seller->id,
                    'image' => $productData['image_url'],
                    'status' => 'active',
                ]);
            }
        }

        echo "Products created successfully!\n";
    }
}