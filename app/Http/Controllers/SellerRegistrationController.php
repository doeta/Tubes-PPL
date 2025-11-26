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
            // User credentials - Validasi akun login
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email:rfc,dns', 
                'max:255', 
                'unique:'.User::class
            ],
            'password' => [
                'required', 
                'confirmed', 
                'min:8',
                Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            
            // Seller information - Data toko dan PIC
            'nama_toko' => [
                'required', 
                'string', 
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\.]+$/',
                'unique:sellers,nama_toko'
            ],
            'deskripsi_singkat' => ['nullable', 'string', 'min:10', 'max:1000'],
            
            // PIC (Person In Charge) - Penanggung jawab
            'nama_pic' => [
                'required', 
                'string', 
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'no_ktp_pic' => [
                'required', 
                'string', 
                'digits:16',
                'regex:/^[0-9]{16}$/',
                'unique:sellers,no_ktp_pic'
            ],
            'alamat_ktp_pic' => ['required', 'string', 'min:10', 'max:500'],
            'email_pic' => [
                'required', 
                'email:rfc,dns', 
                'max:255',
                'different:email'
            ],
            
            // Alamat toko - Lengkap dengan kelurahan sampai provinsi
            'alamat' => ['required', 'string', 'min:10', 'max:500'],
            'nama_kelurahan' => [
                'required', 
                'string', 
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'kecamatan' => [
                'required', 
                'string', 
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'kabupaten_kota' => [
                'required', 
                'string', 
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'provinsi' => [
                'required', 
                'string', 
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            
            // File KTP - Dokumen identitas
            'file_ktp_pic' => [
                'required', 
                'file', 
                'mimes:jpg,jpeg,png,pdf', 
                'max:2048',
                'mimetypes:image/jpeg,image/png,application/pdf'
            ],
        ], [
            // Custom error messages
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama_toko.regex' => 'Nama toko hanya boleh berisi huruf, angka, spasi, strip, dan titik.',
            'nama_toko.unique' => 'Nama toko sudah digunakan.',
            'no_ktp_pic.digits' => 'Nomor KTP harus 16 digit.',
            'no_ktp_pic.regex' => 'Nomor KTP hanya boleh berisi angka.',
            'no_ktp_pic.unique' => 'Nomor KTP sudah terdaftar.',
            'email_pic.different' => 'Email PIC harus berbeda dengan email akun.',
            'file_ktp_pic.max' => 'Ukuran file KTP maksimal 2MB.',
            'file_ktp_pic.mimes' => 'File KTP harus berformat JPG, JPEG, PNG, atau PDF.',
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
