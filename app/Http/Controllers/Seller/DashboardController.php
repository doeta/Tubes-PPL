<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();
        
        $stats = [
            'total_products' => Product::where('user_id', $seller->id)->count(),
            'active_products' => Product::where('user_id', $seller->id)->where('status', 'active')->count(),
            'total_orders' => Order::where('seller_id', $seller->id)->count(),
            'pending_orders' => Order::where('seller_id', $seller->id)->where('status', 'pending')->count(),
            'total_revenue' => Order::where('seller_id', $seller->id)->where('status', 'delivered')->sum('total'),
            'total_sold' => Product::where('user_id', $seller->id)->sum('sold'),
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

        return view('seller.dashboard', compact('stats', 'recent_products', 'recent_orders'));
    }
}
