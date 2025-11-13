<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class SellerRegistrationController extends Controller
{
    /**
     * Display the seller registration form.
     */
    public function create()
    {
        return view('auth.register-seller');
    }

    /**
     * Handle the seller registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            // User credentials
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Seller information
            'nama_toko' => ['required', 'string', 'max:255'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:1000'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'no_ktp_pic' => ['required', 'string', 'size:16', 'unique:sellers,no_ktp_pic'],
            'alamat_ktp_pic' => ['required', 'string', 'max:500'],
            'email_pic' => ['required', 'email', 'max:255'],
            'alamat' => ['required', 'string', 'max:500'],
            'nama_kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kabupaten_kota' => ['required', 'string', 'max:255'],
            'provinsi' => ['required', 'string', 'max:255'],
            'file_ktp_pic' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'seller',
            'status' => 'pending',
        ]);

        // Upload KTP file
        $ktpPath = null;
        if ($request->hasFile('file_ktp_pic')) {
            $ktpPath = $request->file('file_ktp_pic')->store('ktp-files', 'public');
        }

        // Create seller profile
        Seller::create([
            'user_id' => $user->id,
            'nama_toko' => $request->nama_toko,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'nama_pic' => $request->nama_pic,
            'no_ktp_pic' => $request->no_ktp_pic,
            'alamat_ktp_pic' => $request->alamat_ktp_pic,
            'email_pic' => $request->email_pic,
            'alamat' => $request->alamat,
            'nama_kelurahan' => $request->nama_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
            'file_ktp_pic' => $ktpPath,
            'verification_status' => 'pending',
        ]);

        return redirect()->route('seller.registration.success')
            ->with('success', 'Registrasi berhasil! Silakan tunggu proses verifikasi dari tim kami. Anda akan menerima email konfirmasi.');
    }

    /**
     * Display the registration success page.
     */
    public function success()
    {
        return view('auth.register-seller-success');
    }
}
