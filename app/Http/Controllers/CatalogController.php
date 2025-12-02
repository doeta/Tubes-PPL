<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user', 'reviews'])
            ->where('status', 'active')
            ->where('stock', '>', 0);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        // Filter by seller/store
        if ($storeSearch = $request->input('store')) {
            $query->whereHas('user', function($q) use ($storeSearch) {
                $q->where('name', 'like', "%{$storeSearch}%");
            });
        }

        // Filter by location (jika ada seller profile terpisah)
        if ($province = $request->input('province')) {
            $query->whereHas('user.seller', function($q) use ($province) {
                $q->where('province', 'like', "%{$province}%");
            });
        }

        if ($city = $request->input('city')) {
            $query->whereHas('user.seller', function($q) use ($city) {
                $q->where('city', 'like', "%{$city}%");
            });
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sold', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);
        
        // Load average rating for each product
        $products->getCollection()->transform(function ($product) {
            $product->average_rating = $product->averageRating();
            $product->total_reviews = $product->totalReviews();
            return $product;
        });
        
        $categories = Category::where('is_active', true)->get();

        return view('catalog.index', compact('products', 'categories'));
    }

    public function indexByCategory(Category $category)
    {
        $query = Product::with(['category', 'user'])
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->where('category_id', $category->id);

        $sort = request()->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sold', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);
        $categories = Category::where('is_active', true)->get();

        return view('catalog.index', compact('products', 'categories', 'category'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'user.seller', 'reviews']);
        
        // Only show active products with stock
        if ($product->status !== 'active' || $product->stock <= 0) {
            abort(404);
        }

        // Increment views
        $product->incrementViews();

        // Calculate rating statistics
        $product->average_rating = $product->averageRating();
        $product->total_reviews = $product->totalReviews();

        // Get related products with ratings
        $relatedProducts = Product::with('reviews')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->limit(5)
            ->get()
            ->map(function ($relatedProduct) {
                $relatedProduct->average_rating = $relatedProduct->averageRating();
                $relatedProduct->total_reviews = $relatedProduct->totalReviews();
                return $relatedProduct;
            });

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
