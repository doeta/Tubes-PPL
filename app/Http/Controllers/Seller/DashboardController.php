<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();

        if (!$seller->seller) {
            return redirect()->route('welcome')->with('error', 'Anda belum terdaftar sebagai penjual.');
        }

        // Get seller's products
        $products = Product::where('user_id', $seller->id)->get();

        $stats = [
            'total_products' => $products->count(),
            'active_products' => $products->where('status', 'active')->count(),
            'total_stock' => $products->sum('stock'),
            'low_stock' => $products->where('stock', '<', 2)->count(),
            'out_of_stock' => $products->where('stock', 0)->count(),
            'total_revenue' => Order::where('seller_id', $seller->id)->where('status', 'delivered')->sum('total'),
            'total_orders' => Order::where('seller_id', $seller->id)->count(),
            'pending_orders' => Order::where('seller_id', $seller->id)->where('status', 'pending')->count(),
        ];

        $recent_products = Product::where('user_id', $seller->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $recent_orders = Order::where('seller_id', $seller->id)
            ->with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        // Chart 1: Stock Distribution per Product (SRS-MartPlace-08)
        // Grafik Sebaran Stok untuk setiap produk
        $stockByProduct = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'stock' => $product->stock
            ];
        })->sortByDesc('stock')->take(10)->values();

        // Chart 2: Rating Distribution per Product (SRS-MartPlace-08)
        // Grafik Sebaran Rating per Produk
        $ratingByProduct = $products->map(function ($product) {
            $avgRating = $product->reviews()->avg('rating') ?? 0;
            return [
                'name' => $product->name,
                'rating' => round($avgRating, 2),
                'review_count' => $product->reviews()->count()
            ];
        })->sortByDesc('rating')->take(10)->values();

        // Chart 3: Review Distribution per Product (SRS-MartPlace-08 & SRS-06)
        // Grafik Jumlah Review per Produk (karena review sekarang dari guest tanpa user_id)
        $productIds = $products->pluck('id');
        $ratingsByProvince = DB::table('reviews')
            ->whereIn('reviews.product_id', $productIds)
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('COUNT(*) as total'), DB::raw('AVG(reviews.rating) as avg_rating'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        return view('seller.dashboard', compact(
            'stats',
            'recent_products',
            'recent_orders',
            'stockByProduct',
            'ratingByProduct',
            'ratingsByProvince'
        ));
    }
}
