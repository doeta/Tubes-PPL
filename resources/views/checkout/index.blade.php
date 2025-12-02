<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PojokKampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700">PojokKampus</a>
                
                <div class="flex gap-4">
                    <a href="{{ route('catalog.index') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600">Belanja</a>
                    <a href="{{ route('cart.index') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600">Keranjang</a>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
            <p class="text-gray-600">Lengkapi informasi pengiriman Anda</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-3 gap-6">
                <!-- Form Section -->
                <div class="col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Kontak</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                                <input type="text" name="guest_name" required value="{{ old('guest_name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('guest_name') border-red-500 @enderror">
                                @error('guest_name')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" name="guest_email" required value="{{ old('guest_email') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('guest_email') border-red-500 @enderror">
                                    @error('guest_email')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP *</label>
                                    <input type="text" name="guest_phone" required value="{{ old('guest_phone') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('guest_phone') border-red-500 @enderror">
                                    @error('guest_phone')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Alamat Pengiriman</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                                <textarea name="shipping_address" required rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('shipping_address') border-red-500 @enderror">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten *</label>
                                    <input type="text" name="shipping_city" required value="{{ old('shipping_city') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('shipping_city') border-red-500 @enderror">
                                    @error('shipping_city')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                                    <input type="text" name="shipping_province" required value="{{ old('shipping_province') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('shipping_province') border-red-500 @enderror">
                                    @error('shipping_province')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos *</label>
                                <input type="text" name="shipping_postal_code" required value="{{ old('shipping_postal_code') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('shipping_postal_code') border-red-500 @enderror">
                                @error('shipping_postal_code')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Metode Pembayaran</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-indigo-600 rounded-lg cursor-pointer bg-indigo-50">
                                <input type="radio" name="payment_method" value="transfer_bank" checked class="mr-3">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Transfer Bank</p>
                                    <p class="text-sm text-gray-600">Pembayaran melalui transfer bank</p>
                                </div>
                                <span class="text-2xl">🏦</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-span-1">
                    <div class="bg-white rounded-lg p-6 shadow-sm sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-4 pb-4 border-b">
                            @foreach($cartItems as $item)
                                <div class="flex gap-3">
                                    <img src="{{ Storage::url($item->product->image) }}" 
                                        alt="{{ $item->product->name }}"
                                        class="w-16 h-16 object-cover rounded">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-600">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        <p class="text-sm font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-2 mb-4 pb-4 border-b">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ongkir</span>
                                <span class="font-medium text-green-600">Gratis</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                            Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}" class="block text-center mt-4 text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                            ← Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
