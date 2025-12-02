<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerRegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Public Catalog Routes
Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/p/{category:slug}', [CatalogController::class, 'indexByCategory'])->name('catalog.category');
Route::get('/products/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Public Cart Routes (for guest users)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/add/{product:slug}', [\App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::patch('/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('update');
    Route::delete('/{cart}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('destroy');
    Route::post('/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('clear');
});

// Public Review Routes (for guest users)
Route::post('/products/{product:slug}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

// Public Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('success');
});

// Seller Registration Routes (Public)
Route::get('/register-seller', [SellerRegistrationController::class, 'create'])->name('seller.register.form');
Route::post('/register-seller', [SellerRegistrationController::class, 'store'])->name('seller.register');
Route::get('/register-seller/success', [SellerRegistrationController::class, 'success'])->name('seller.registration.success');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Seller Management
    Route::get('/sellers', [AdminSellerController::class, 'index'])->name('sellers.index');
    Route::get('/sellers/{seller}', [AdminSellerController::class, 'show'])->name('sellers.show');
    Route::post('/sellers/{seller}/approve', [AdminSellerController::class, 'approve'])->name('sellers.approve');
    Route::post('/sellers/{seller}/reject', [AdminSellerController::class, 'reject'])->name('sellers.reject');
    Route::post('/sellers/{seller}/suspend', [AdminSellerController::class, 'suspend'])->name('sellers.suspend');
    Route::post('/sellers/{seller}/activate', [AdminSellerController::class, 'activate'])->name('sellers.activate');
});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', SellerProductController::class);
});

// Auth Routes (fallback dashboard)
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('welcome');
    }
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isSeller()) {
        return redirect()->route('seller.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
