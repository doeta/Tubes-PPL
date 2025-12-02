<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
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
     * Display cart
     */
    public function index(Request $request)
    {
        $sessionId = $this->getSessionId($request);
        
        $cartItems = Cart::with('product.user')
            ->bySession($sessionId)
            ->get();

        $total = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock availability
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        $sessionId = $this->getSessionId($request);

        // Check if product already in cart
        $cartItem = Cart::bySession($sessionId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
            }

            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            // Create new cart item
            Cart::create([
                'session_id' => $sessionId,
                'user_id' => auth()->id(), // null for guest
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $sessionId = $this->getSessionId($request);

        // Verify ownership
        if ($cart->session_id !== $sessionId) {
            abort(403);
        }

        // Check stock
        if ($cart->product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $cart->product->stock);
        }

        $cart->update([
            'quantity' => $validated['quantity'],
        ]);

        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    /**
     * Remove item from cart
     */
    public function destroy(Request $request, Cart $cart)
    {
        $sessionId = $this->getSessionId($request);

        // Verify ownership
        if ($cart->session_id !== $sessionId) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Clear all cart items
     */
    public function clear(Request $request)
    {
        $sessionId = $this->getSessionId($request);

        Cart::bySession($sessionId)->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
