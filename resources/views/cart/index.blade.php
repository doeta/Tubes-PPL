<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - PojokKampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700">PojokKampus</a>
                
                <form method="GET" action="{{ route('catalog.index') }}" class="flex-1 max-w-2xl mx-8">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari produk, toko, atau brand..."
                            class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>

                <div class="flex gap-4">
                    <a href="{{ route('catalog.index') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600">Belanja</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600">Dashboard</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Keranjang Belanja</h1>
            <p class="text-gray-600">Kelola produk yang ingin Anda beli</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex gap-4">
                                <!-- Product Image -->
                                <a href="{{ route('catalog.show', $item->product->slug) }}" class="flex-shrink-0">
                                    <img src="{{ Storage::url($item->product->image) }}" 
                                        alt="{{ $item->product->name }}"
                                        class="w-24 h-24 object-cover rounded-lg">
                                </a>

                                <!-- Product Info -->
                                <div class="flex-1">
                                    <a href="{{ route('catalog.show', $item->product->slug) }}" 
                                        class="font-semibold text-gray-900 hover:text-indigo-600 block mb-1">
                                        {{ $item->product->name }}
                                    </a>
                                    <p class="text-sm text-gray-600 mb-2">{{ $item->product->category->name }}</p>
                                    <p class="text-lg font-bold text-indigo-600">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Quantity & Actions -->
                                <div class="flex flex-col items-end justify-between">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm">
                                            🗑️ Hapus
                                        </button>
                                    </form>

                                    <div>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button type="button" onclick="updateQuantity({{ $item->id }}, -1, {{ $item->product->min_order }}, {{ $item->product->stock }})" 
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                <input type="number" 
                                                    name="quantity" 
                                                    id="quantity-{{ $item->id }}" 
                                                    value="{{ $item->quantity }}" 
                                                    min="{{ $item->product->min_order }}" 
                                                    max="{{ $item->product->stock }}"
                                                    class="w-16 text-center border-0 focus:ring-0 py-1"
                                                    onchange="this.form.submit()">
                                                <button type="button" onclick="updateQuantity({{ $item->id }}, 1, {{ $item->product->min_order }}, {{ $item->product->stock }})" 
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                            </div>
                                        </form>
                                        <p class="text-xs text-gray-500 mt-1 text-right">Stok: {{ $item->product->stock }}</p>
                                    </div>

                                    <p class="text-lg font-bold text-gray-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="col-span-1">
                    <div class="bg-white rounded-lg p-5 shadow-sm sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Belanja</h2>
                        
                        <div class="space-y-3 mb-4 pb-4 border-b">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-medium">{{ $cartItems->sum('quantity') }} produk</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Harga</span>
                                <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition mb-3 text-center">
                            Lanjutkan ke Pembayaran
                        </a>

                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm"
                                onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                Kosongkan Keranjang
                            </button>
                        </form>

                        <a href="{{ route('catalog.index') }}" class="block text-center mt-4 text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                            ← Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg p-12 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Keranjang Belanja Kosong</h2>
                <p class="text-gray-600 mb-6">Ayo mulai belanja dan tambahkan produk ke keranjang!</p>
                <a href="{{ route('catalog.index') }}" 
                    class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <script>
    function updateQuantity(itemId, change, min, max) {
        const input = document.getElementById('quantity-' + itemId);
        let newValue = parseInt(input.value) + change;
        
        if (newValue < min) newValue = min;
        if (newValue > max) {
            alert('Stok tidak mencukupi. Maksimal: ' + max);
            newValue = max;
        }
        
        input.value = newValue;
        input.form.submit();
    }
    </script>
</body>
</html>
