<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;

echo "=== Testing Checkout Process ===\n";

// 1. Create test cart
$sessionId = Str::uuid()->toString();
$product = Product::first();

if (!$product) {
    echo "ERROR: No products found!\n";
    exit;
}

echo "1. Adding product to cart: {$product->name}\n";
echo "   Original stock: {$product->stock}\n";

$cart = Cart::create([
    'session_id' => $sessionId,
    'product_id' => $product->id,
    'quantity' => 2,
    'price' => $product->price,
]);

// 2. Test order creation
echo "2. Creating order...\n";

$orderData = [
    'user_id' => null,
    'order_number' => 'TEST-' . strtoupper(Str::random(6)),
    'status' => 'pending',
    'guest_name' => 'Test User',
    'guest_email' => 'test@example.com',
    'guest_phone' => '08123456789',
    'product_id' => $product->id,
    'quantity' => 2,
    'price' => $product->price,
    'total_amount' => $product->price * 2,
    'payment_method' => 'transfer_bank',
    'payment_status' => 'pending',
    'shipping_address' => 'Test Address, Jakarta, DKI Jakarta 12345',
    'shipping_city' => 'Jakarta',
    'shipping_province' => 'DKI Jakarta',
    'shipping_postal_code' => '12345',
    'phone' => '08123456789',
];

try {
    $order = Order::create($orderData);
    echo "   Order created successfully: {$order->order_number}\n";
    
    // 3. Test stock decrement
    $product->decrementStock(2);
    $product->refresh();
    echo "3. Stock after decrement: {$product->stock}\n";
    
    // 4. Clean up
    $cart->delete();
    $order->delete();
    $product->increment('stock', 2);
    $product->decrement('sold', 2);
    
    echo "4. Test completed successfully!\n";
    echo "✅ Checkout should work now!\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    $cart->delete();
}