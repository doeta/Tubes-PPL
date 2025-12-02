<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewThankYou;

class ReviewController extends Controller
{
    /**
     * Store a newly created review
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Create review
        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(), // null for guest
            'guest_name' => $validated['guest_name'],
            'guest_phone' => $validated['guest_phone'],
            'guest_email' => $validated['guest_email'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Send thank you email
        try {
            Mail::to($validated['guest_email'])->send(new ReviewThankYou($review, $product));
        } catch (\Exception $e) {
            // Log error but don't fail the review submission
            \Log::error('Failed to send review thank you email: ' . $e->getMessage());
        }

        return redirect()
            ->route('catalog.show', $product->slug)
            ->with('success', 'Terima kasih! Review Anda telah berhasil ditambahkan. Email konfirmasi telah dikirim.');
    }
}
