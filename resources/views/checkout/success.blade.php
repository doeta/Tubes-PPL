<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - PojokKampus</title>
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
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-gray-600">Terima kasih atas pesanan Anda</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-6 pb-6 border-b">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Nomor Pesanan</p>
                    <p class="text-xl font-bold text-gray-900">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($order->total_amount ?? $order->total ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi Pembeli</h3>
                    <div class="space-y-2 text-sm">
                        @if(isset($order->guest_name))
                            <p class="text-gray-600">Nama: <span class="text-gray-900 font-medium">{{ $order->guest_name }}</span></p>
                        @endif
                        @if(isset($order->guest_email))
                            <p class="text-gray-600">Email: <span class="text-gray-900 font-medium">{{ $order->guest_email }}</span></p>
                        @endif
                        @if(isset($order->guest_phone))
                            <p class="text-gray-600">HP: <span class="text-gray-900 font-medium">{{ $order->guest_phone }}</span></p>
                        @endif
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Alamat Pengiriman</h3>
                    <div class="text-sm text-gray-700">
                        <p>{{ $order->shipping_address }}</p>
                        @if(isset($order->shipping_city) && isset($order->shipping_province))
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_province }}</p>
                        @endif
                        @if(isset($order->shipping_postal_code))
                            <p>{{ $order->shipping_postal_code }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Detail Pesanan</h3>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="flex gap-4">
                            <img src="{{ Storage::url($item->product->image) }}" 
                                alt="{{ $item->product->name }}"
                                class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-blue-900 mb-3">📋 Instruksi Pembayaran</h3>
            <div class="text-sm text-blue-800 space-y-2">
                <p>1. Transfer ke rekening berikut:</p>
                <div class="bg-white rounded p-3 my-2">
                    <p class="font-semibold">Bank BCA</p>
                    <p class="text-lg font-bold">1234567890</p>
                    <p>a.n. PojokKampus</p>
                </div>
                <p>2. Nominal transfer: <strong>Rp {{ number_format($order->total_amount ?? $order->total ?? 0, 0, ',', '.') }}</strong></p>
                <p>3. Konfirmasi pembayaran akan dikirim ke email Anda</p>
                <p>4. Pesanan akan diproses setelah pembayaran dikonfirmasi</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4 justify-center">
            <a href="{{ route('catalog.index') }}" 
                class="px-6 py-3 bg-white border-2 border-indigo-600 text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition">
                Lanjut Belanja
            </a>
            <a href="{{ url('/') }}" 
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
