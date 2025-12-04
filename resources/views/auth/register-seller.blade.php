<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Penjual - PojokKampus</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                    <img src="{{ asset('images/logo.png') }}" alt="PojokKampus Logo" class="h-10 w-auto">
                </a>
                
                <a href="{{ route('welcome') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-indigo-50/50 to-white">
        <div class="max-w-4xl mx-auto">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Mulai Berjualan di PojokKampus</h1>
                <p class="text-gray-500 text-lg">Lengkapi data di bawah ini untuk membuka toko Anda.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                
                <form method="POST" action="{{ route('seller.register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="bg-gray-50/50 border-b border-gray-100 px-8 py-6">
                        <div class="flex items-center justify-between relative">
                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10 rounded-full"></div>
                            
                            <div class="flex flex-col items-center bg-white px-2 z-10">
                                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold shadow-lg shadow-indigo-200 mb-2">1</div>
                                <span class="text-xs font-semibold text-indigo-700 uppercase tracking-wider">Akun</span>
                            </div>

                            <div class="flex flex-col items-center bg-white px-2 z-10">
                                <div class="w-10 h-10 rounded-full bg-white border-2 border-indigo-200 text-indigo-600 flex items-center justify-center font-bold mb-2">2</div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Toko</span>
                            </div>

                            <div class="flex flex-col items-center bg-white px-2 z-10">
                                <div class="w-10 h-10 rounded-full bg-white border-2 border-indigo-200 text-indigo-600 flex items-center justify-center font-bold mb-2">3</div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dokumen</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-10">
                        
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-2">
                                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900">Informasi Akun</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-400 text-sm">
                                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-400 text-sm">
                                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" id="password" required placeholder="Min. 8 karakter"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-400 text-sm">
                                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-400 text-sm">
                                    @error('password_confirmation') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-2">
                                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900">Informasi Toko</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_toko" id="nama_toko" value="{{ old('nama_toko') }}" required placeholder="Nama brand atau toko Anda"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-400 text-sm">
                                    @error('nama_toko') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                    <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="2" placeholder="Jual apa saja di toko ini?"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-400 text-sm">{{ old('deskripsi_singkat') }}</textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penanggung Jawab (PIC) <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_pic" id="nama_pic" value="{{ old('nama_pic') }}" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email PIC <span class="text-red-500">*</span></label>
                                    <input type="email" name="email_pic" id="email_pic" value="{{ old('email_pic') }}" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Toko <span class="text-red-500">*</span></label>
                                    <textarea name="alamat" id="alamat" rows="2" required placeholder="Jalan, RT/RW, No. Rumah"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">{{ old('alamat') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                                    <select name="provinsi" id="provinsi" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm bg-white">
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                    <select name="kabupaten_kota" id="kabupaten_kota" required disabled class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm bg-white disabled:bg-gray-100">
                                        <option value="">-- Pilih Provinsi Dahulu --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                    <select name="kecamatan" id="kecamatan" required disabled class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm bg-white disabled:bg-gray-100">
                                        <option value="">-- Pilih Kota Dahulu --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa <span class="text-red-500">*</span></label>
                                    <select name="nama_kelurahan" id="nama_kelurahan" required disabled class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm bg-white disabled:bg-gray-100">
                                        <option value="">-- Pilih Kecamatan Dahulu --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-2">
                                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900">Verifikasi Dokumen</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">No. KTP (16 Digit) <span class="text-red-500">*</span></label>
                                    <input type="text" name="no_ktp_pic" id="no_ktp_pic" value="{{ old('no_ktp_pic') }}" required maxlength="16" placeholder="1234567890123456"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Sesuai KTP <span class="text-red-500">*</span></label>
                                    <input type="text" name="alamat_ktp_pic" id="alamat_ktp_pic" value="{{ old('alamat_ktp_pic') }}" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload File KTP (Max 2MB) <span class="text-red-500">*</span></label>
                                    
                                    <!-- Hidden File Input -->
                                    <input id="file_ktp_pic" name="file_ktp_pic" type="file" class="hidden" accept="image/jpeg,image/jpg,image/png,application/pdf" required>
                                    
                                    <!-- Upload Button -->
                                    <button type="button" id="upload-btn" class="w-full mb-3 px-4 py-3 bg-white border-2 border-indigo-600 text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Pilih File KTP
                                    </button>
                                    
                                    <!-- Dropzone Area -->
                                    <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-indigo-400 hover:bg-indigo-50/50 transition-all cursor-pointer">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="text-sm text-gray-600 mb-1">atau <span class="font-semibold text-indigo-600">drag & drop file</span> di sini</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, atau PDF (maksimal 2MB)</p>
                                    </div>
                                    
                                    <!-- File Display -->
                                    <div id="file-preview" class="hidden mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div>
                                                    <p id="filename-display" class="font-semibold text-green-800"></p>
                                                    <p id="filesize-display" class="text-xs text-green-600"></p>
                                                </div>
                                            </div>
                                            <button type="button" id="remove-file" class="text-red-600 hover:text-red-800 font-semibold text-sm">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                    
                                    @error('file_ktp_pic') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">
                            Sudah punya akun? <span class="underline">Login disini</span>
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            <span>Daftar Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // -- LOGIC 1: Enhanced File Upload with Drag & Drop --
            const fileInput = document.getElementById('file_ktp_pic');
            const uploadBtn = document.getElementById('upload-btn');
            const dropzone = document.getElementById('dropzone');
            const filePreview = document.getElementById('file-preview');
            const fileNameDisplay = document.getElementById('filename-display');
            const fileSizeDisplay = document.getElementById('filesize-display');
            const removeFileBtn = document.getElementById('remove-file');
            
            // Click upload button to trigger file input
            uploadBtn.addEventListener('click', function() {
                fileInput.click();
            });

            // Click dropzone to trigger file input
            dropzone.addEventListener('click', function() {
                fileInput.click();
            });
            
            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                console.log('✓ File input change event triggered');
                console.log('✓ Files selected:', this.files);
                
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    console.log('✓ File details:', {
                        name: file.name,
                        size: file.size,
                        type: file.type
                    });
                    
                    if (validateFile(file)) {
                        displayFilePreview(file);
                    }
                } else {
                    hideFilePreview();
                }
            });

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, function() {
                    dropzone.classList.add('border-indigo-500', 'bg-indigo-100', 'scale-105');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, function() {
                    dropzone.classList.remove('border-indigo-500', 'bg-indigo-100', 'scale-105');
                }, false);
            });

            dropzone.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                console.log('✓ File dropped:', files);
                
                if (files.length > 0) {
                    // Manually set files to input (doesn't work in all browsers, use DataTransfer)
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]);
                    fileInput.files = dataTransfer.files;
                    
                    console.log('✓ File assigned to input:', fileInput.files);
                    
                    if (validateFile(files[0])) {
                        displayFilePreview(files[0]);
                    }
                }
            }, false);

            function displayFilePreview(file) {
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                const sizeInKB = (file.size / 1024).toFixed(0);
                const displaySize = file.size < 1024 * 1024 ? `${sizeInKB} KB` : `${sizeInMB} MB`;
                
                fileNameDisplay.textContent = file.name;
                fileSizeDisplay.textContent = displaySize;
                filePreview.classList.remove('hidden');
                dropzone.classList.add('hidden');
                uploadBtn.classList.add('hidden');
                
                console.log('✓ File preview displayed');
            }

            function hideFilePreview() {
                filePreview.classList.add('hidden');
                dropzone.classList.remove('hidden');
                uploadBtn.classList.remove('hidden');
                fileInput.value = '';
                
                console.log('✓ File preview hidden');
            }

            removeFileBtn.addEventListener('click', function() {
                hideFilePreview();
            });

            function validateFile(file) {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                const maxSize = 2 * 1024 * 1024; // 2MB

                console.log('Validating file type:', file.type);
                
                if (!allowedTypes.includes(file.type)) {
                    alert('❌ Format file tidak didukung!\n\nHanya file JPG, PNG, atau PDF yang diperbolehkan.');
                    fileInput.value = '';
                    return false;
                }

                if (file.size > maxSize) {
                    const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                    alert(`❌ File terlalu besar!\n\nUkuran file: ${sizeInMB} MB\nMaksimal: 2 MB`);
                    fileInput.value = '';
                    return false;
                }

                console.log('✓ File validation passed');
                return true;
            }

            // -- LOGIC 2: Real-time Validation (Copied & Adapted) --
            const form = document.querySelector('form');
            const validationRules = {
                name: { pattern: /^[a-zA-Z\s]+$/, minLength: 3, message: 'Nama hanya boleh huruf dan spasi (min 3)' },
                email: { pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, message: 'Format email tidak valid' },
                password: { minLength: 8, pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/, message: 'Min 8 char, ada huruf besar, kecil, angka, simbol' },
                nama_toko: { pattern: /^[a-zA-Z0-9\s\-\.]+$/, minLength: 3, message: 'Karakter tidak valid (min 3)' },
                nama_pic: { pattern: /^[a-zA-Z\s]+$/, minLength: 3, message: 'Hanya huruf dan spasi (min 3)' },
                no_ktp_pic: { pattern: /^[0-9]{16}$/, message: 'Harus 16 digit angka' },
                email_pic: { pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, message: 'Format email tidak valid' },
                alamat: { minLength: 10, message: 'Alamat terlalu pendek (min 10)' },
                file_ktp_pic: { fileTypes: ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'], maxSize: 2 * 1024 * 1024, message: 'Format salah atau > 2MB' }
            };

            function showError(input, message) {
                removeError(input);
                input.classList.add('border-red-500', 'focus:ring-red-500');
                input.classList.remove('border-gray-300', 'focus:ring-indigo-500');
                const errorDiv = document.createElement('p');
                errorDiv.className = 'mt-1 text-xs text-red-600 error-message';
                errorDiv.textContent = message;
                input.parentElement.appendChild(errorDiv);
            }

            function removeError(input) {
                input.classList.remove('border-red-500', 'focus:ring-red-500');
                input.classList.add('border-gray-300', 'focus:ring-indigo-500');
                const existingError = input.parentElement.querySelector('.error-message');
                if (existingError) existingError.remove();
            }

            function validateField(input) {
                const name = input.name;
                const value = input.value.trim();
                const rule = validationRules[name];
                if (!rule) return true;

                if (input.required && !value) { showError(input, 'Wajib diisi'); return false; }
                if (!value && !input.required) { removeError(input); return true; }
                if (rule.minLength && value.length < rule.minLength) { showError(input, rule.message); return false; }
                if (rule.pattern && !rule.pattern.test(value)) { showError(input, rule.message); return false; }

                if (name === 'file_ktp_pic' && input.files.length > 0) {
                    const file = input.files[0];
                    if (!rule.fileTypes.includes(file.type) || file.size > rule.maxSize) {
                        showError(input, rule.message); return false;
                    }
                }
                removeError(input);
                input.classList.add('border-green-500'); // Success Indicator
                return true;
            }

            // Bind Validation Events
            const inputs = form.querySelectorAll('input:not([type="submit"]), textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', () => validateField(input));
                input.addEventListener('input', () => {
                    if(input.value.trim()) { 
                        const err = input.parentElement.querySelector('.error-message');
                        if(err) validateField(input);
                    }
                });
                if (input.id === 'no_ktp_pic') {
                    input.addEventListener('keypress', (e) => { if (!/[0-9]/.test(e.key)) e.preventDefault(); });
                }
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => { if (!validateField(input)) isValid = false; });
                
                // Password Match Check
                const pwd = document.getElementById('password');
                const confirm = document.getElementById('password_confirmation');
                if(confirm.value !== pwd.value) { showError(confirm, 'Password tidak sama'); isValid = false; }

                // Check if file is uploaded
                if (fileInput.files.length === 0) {
                    showError(fileInput, 'File KTP wajib diupload');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon perbaiki data yang merah sebelum submit.');
                    return false;
                }

                // Debug: Log form data before submit
                console.log('Form is valid, submitting...');
                console.log('File to upload:', fileInput.files[0]);
            });

            // -- LOGIC 3: Dynamic Region API (Emsifa) --
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten_kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('nama_kelurahan');

            async function loadProvinsi() {
                try {
                    const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    const provinces = await response.json();
                    provinsiSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
                    provinces.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.name; opt.setAttribute('data-id', p.id); opt.textContent = p.name;
                        provinsiSelect.appendChild(opt);
                    });
                } catch(e) { console.error(e); }
            }

            async function loadRegion(url, selectElement, defaultText) {
                selectElement.innerHTML = '<option value="">Loading...</option>';
                selectElement.disabled = true;
                try {
                    const response = await fetch(url);
                    const data = await response.json();
                    selectElement.innerHTML = `<option value="">${defaultText}</option>`;
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.name; opt.setAttribute('data-id', item.id); opt.textContent = item.name;
                        selectElement.appendChild(opt);
                    });
                    selectElement.disabled = false;
                } catch(e) { console.error(e); }
            }

            provinsiSelect.addEventListener('change', function() {
                const id = this.options[this.selectedIndex].getAttribute('data-id');
                kabupatenSelect.innerHTML = '<option value="">Loading...</option>'; kecamatanSelect.disabled=true; kelurahanSelect.disabled=true;
                if(id) loadRegion(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`, kabupatenSelect, '-- Pilih Kabupaten/Kota --');
            });

            kabupatenSelect.addEventListener('change', function() {
                const id = this.options[this.selectedIndex].getAttribute('data-id');
                kecamatanSelect.innerHTML = '<option value="">Loading...</option>'; kelurahanSelect.disabled=true;
                if(id) loadRegion(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`, kecamatanSelect, '-- Pilih Kecamatan --');
            });

            kecamatanSelect.addEventListener('change', function() {
                const id = this.options[this.selectedIndex].getAttribute('data-id');
                kelurahanSelect.innerHTML = '<option value="">Loading...</option>';
                if(id) loadRegion(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`, kelurahanSelect, '-- Pilih Kelurahan --');
            });

            loadProvinsi();
        });
    </script>
</body>
</html>