<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\User;
use App\Notifications\SellerVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SellerVerificationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of pending seller registrations.
     */
    public function index()
    {
        // Check if user is platform admin
        if (!Auth::check() || Auth::user()->role !== 'platform') {
            abort(403, 'Unauthorized action.');
        }

        $pendingSellers = Seller::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->paginate(10);

        return view('platform.seller-verification.index', compact('pendingSellers'));
    }

    /**
     * Display the specified seller registration for review.
     */
    public function show(Seller $seller)
    {
        // Check if user is platform admin
        if (!Auth::check() || Auth::user()->role !== 'platform') {
            abort(403, 'Unauthorized action.');
        }

        return view('platform.seller-verification.show', compact('seller'));
    }

    /**
     * Approve the seller registration.
     */
    public function approve(Request $request, Seller $seller)
    {
        // Check if user is platform admin
        if (!Auth::check() || Auth::user()->role !== 'platform') {
            abort(403, 'Unauthorized action.');
        }

        $seller->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        // Update user status to active
        $seller->user->update([
            'status' => 'active',
        ]);

        // Send approval notification email
        $seller->user->notify(new SellerVerificationNotification($seller, 'approved'));

        return redirect()->route('platform.seller-verification.index')
            ->with('success', 'Penjual berhasil diverifikasi dan disetujui. Email notifikasi telah dikirim.');
    }

    /**
     * Reject the seller registration.
     */
    public function reject(Request $request, Seller $seller)
    {
        // Check if user is platform admin
        if (!Auth::check() || Auth::user()->role !== 'platform') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $seller->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        // Update user status to inactive
        $seller->user->update([
            'status' => 'inactive',
        ]);

        // Send rejection notification email
        $seller->user->notify(new SellerVerificationNotification($seller, 'rejected', $request->rejection_reason));

        return redirect()->route('platform.seller-verification.index')
            ->with('success', 'Pendaftaran penjual ditolak. Email notifikasi telah dikirim.');
    }
}
