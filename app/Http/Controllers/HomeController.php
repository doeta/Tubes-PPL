<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured categories (top 6 with most products)
        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();

        // Get featured products (top rated or most sold)
        $featuredProducts = Product::with(['category', 'user.seller'])
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get stats
        $stats = [
            'total_sellers' => User::where('role', 'seller')->count(),
            'total_products' => Product::count(),
            'total_transactions' => 0, // Placeholder, update when transaction table exists
            'average_rating' => Product::whereHas('reviews')
                ->with('reviews')
                ->get()
                ->avg(function ($product) {
                    return $product->reviews->avg('rating');
                }) ?? 4.8,
        ];

        return view('welcome', compact('categories', 'featuredProducts', 'stats'));
    }
}
