<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sellers' => User::where('role', 'seller')->count(),
            'pending_sellers' => User::where('role', 'seller')->where('status', 'pending')->count(),
            'active_sellers' => User::where('role', 'seller')->where('status', 'active')->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
        ];

        $recent_sellers = User::where('role', 'seller')
            ->with('seller')
            ->latest()
            ->take(5)
            ->get();

        $recent_orders = Order::with(['user', 'seller', 'product'])
            ->latest()
            ->take(5)
            ->get();

        // Chart Data for SRS-MartPlace-07

        // 1. Product Distribution by Category
        $productsByCategory = Product::select('category_id', DB::raw('COUNT(*) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category->name ?? 'Tanpa Kategori',
                    'total' => $item->total,
                ];
            });

        // 2. Store Distribution by Province
        $storesByProvince = Seller::selectRaw('provinsi, COUNT(*) as total')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })
            ->groupBy('provinsi')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        // 3. Seller Status Statistics
        $sellerStats = [
            'active' => User::where('role', 'seller')->where('status', 'active')->count(),
            'inactive' => User::where('role', 'seller')->where('status', '!=', 'active')->count(),
        ];

        // 4. Review Statistics (SRS-06: Reviews are from guests, no login required)
        $totalReviews = Review::count();
        $uniqueReviewers = Review::distinct('email')->count('email');

        $participationStats = [
            'total_reviews' => $totalReviews,
            'unique_reviewers' => $uniqueReviewers,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_sellers',
            'recent_orders',
            'productsByCategory',
            'storesByProvince',
            'sellerStats',
            'participationStats'
        ));
    }
}
