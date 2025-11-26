<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use App\Notifications\SellerApproved;
use App\Notifications\SellerRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = User::where('role', 'seller')
            ->with('seller')
            ->latest()
            ->paginate(20);

        return view('admin.sellers.index', compact('sellers'));
    }

    public function show(User $seller)
    {
        $seller->load('seller', 'products');
        
        return view('admin.sellers.show', compact('seller'));
    }

    public function approve(User $seller)
    {
        $seller->update(['status' => 'active']);
        
        $seller->seller->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        // Send approval email notification
        $seller->notify(new SellerApproved($seller->seller));

        return redirect()->back()->with('success', 'Penjual berhasil disetujui dan email notifikasi telah dikirim!');
    }

    public function reject(Request $request, User $seller)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $seller->update(['status' => 'suspended']);
        
        $seller->seller->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_by' => Auth::id(),
        ]);

        // Send rejection email notification
        $seller->notify(new SellerRejected($seller->seller, $request->rejection_reason));

        return redirect()->back()->with('success', 'Penjual ditolak dan email notifikasi telah dikirim!');
    }

    public function suspend(User $seller)
    {
        $seller->update(['status' => 'suspended']);

        return redirect()->back()->with('success', 'Penjual telah disuspend!');
    }

    public function activate(User $seller)
    {
        $seller->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Penjual telah diaktifkan!');
    }
}
