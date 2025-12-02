<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class CheckoutController extends Controller
{
    /**
     * Get or create session ID for guest users
     */
    private function getSessionId(Request $request): string
    {
        if (!$request->session()->has('cart_session_id')) {
            $request->session()->put('cart_session_id', Str::uuid()->toString());
        }
        
        return $request->session()->get('cart_session_id');
    }

    /**
     * Show checkout form
     */
    public function index(Request $request)
    {
        $sessionId = $this->getSessionId($request);
        
        $cartItems = Cart::with('product')
            ->bySession($sessionId)
            ->get();

        if ($cartItems->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $total = $cartItems->sum('subtotal');

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:transfer_bank',
        ]);

        $sessionId = $this->getSessionId($request);
        
        $cartItems = Cart::with('product')
            ->bySession($sessionId)
            ->get();

        if ($cartItems->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok produk {$item->product->name} tidak mencukupi!");
            }
        }

        $total = $cartItems->sum('subtotal');

        // For multiple items, create separate orders OR use the first item for main order
        $firstItem = $cartItems->first();

        // Create main order with required fields
        $orderData = [
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'status' => 'pending',
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'product_id' => $firstItem->product_id, // Required field
            'quantity' => $firstItem->quantity, // Required field  
            'price' => $firstItem->price, // Required field
            'total_amount' => $total,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'shipping_address' => $validated['shipping_address'] . ', ' . 
                                 $validated['shipping_city'] . ', ' . 
                                 $validated['shipping_province'] . ' ' . 
                                 $validated['shipping_postal_code'],
            'shipping_city' => $validated['shipping_city'],
            'shipping_province' => $validated['shipping_province'],
            'shipping_postal_code' => $validated['shipping_postal_code'],
            'phone' => $validated['guest_phone'], // Required field
        ];
        
        $order = Order::create($orderData);

        // Create order items for all cart items and update stock
        foreach ($cartItems as $item) {
            // Only create order_items if there are multiple items
            if ($cartItems->count() > 1) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // Decrease stock for all items
            $item->product->decrementStock($item->quantity);
        }

        // Clear cart
        Cart::bySession($sessionId)->delete();

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Pesanan Anda berhasil dibuat!');
    }

    /**
     * Show success page
     */
    public function success(Order $order)
    {
        $order->load('orderItems.product');

        return view('checkout.success', compact('order'));
    }
}
