<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - PojokKampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="PojokKampus Logo" class="h-16 w-auto">
                </a>
                
                <!-- Search Bar -->
                <form method="GET" class="flex-1 max-w-2xl mx-8">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari produk, toko, atau brand..."
                            class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>

                <div class="flex gap-4 items-center">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600">Dashboard</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">
            <!-- Sidebar Filter -->
            <aside class="w-64 flex-shrink-0">
                <div class="bg-white rounded-lg border border-gray-200 p-4 sticky top-24">
                    <h2 class="font-bold text-gray-900 mb-4">Filter</h2>
                    
                    <form method="GET" id="filterForm">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Category Filter -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-700 mb-2">Kategori</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()" class="mr-2">
                                    <span class="text-sm">Semua</span>
                                </label>
                                @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()" class="mr-2">
                                        <span class="text-sm">{{ $category->icon }} {{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Store Filter -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-700 mb-2">Nama Toko</h3>
                            <input type="text" name="store" value="{{ request('store') }}"
                                placeholder="Cari toko..."
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                        </div>

                        <!-- Location Filter -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-700 mb-2">Lokasi</h3>
                            <input type="text" name="province" value="{{ request('province') }}"
                                placeholder="Provinsi..."
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm mb-2">
                            <input type="text" name="city" value="{{ request('city') }}"
                                placeholder="Kota/Kabupaten..."
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                        </div>

                        <button type="submit" 
                            class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">
                            Terapkan Filter
                        </button>

                        @if(request()->hasAny(['category', 'store', 'province', 'city']))
                            <a href="{{ route('catalog.index') }}" 
                                class="block w-full px-4 py-2 mt-2 text-center border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1">
                <!-- Sort & Count -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6 flex justify-between items-center">
                    <p class="text-gray-600">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</p>
                    
                    <form method="GET" class="flex items-center gap-2">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <label class="text-sm text-gray-600">Urutkan:</label>
                        <select name="sort" onchange="this.form.submit()"
                            class="px-3 py-1 border border-gray-300 rounded text-sm">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </form>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="product-grid mb-6">
                        @foreach($products as $product)
                            <a href="{{ route('catalog.show', $product) }}" class="product-card">
                                <img src="{{ Storage::url($product->image) }}" class="product-card__image" alt="{{ $product->name }}">
                                <div class="product-card__body">
                                    <p class="text-xs font-semibold text-gray-800 leading-tight line-clamp-2 h-8">{{ $product->name }}</p>
                                    <p class="text-sm font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <div class="flex items-center gap-1 text-[11px] text-gray-500 mt-1">
                                        <span class="text-yellow-400">★</span>
                                        <span>{{ number_format($product->averageRating(), 1) }}</span>
                                        <span>•</span>
                                        <span>{{ $product->sold ?? 0 }} terjual</span>
                                    </div>
                                    <p class="text-[11px] text-gray-400 mt-1 truncate">{{ $product->user->name }}</p>
                                    @if($product->user->seller)
                                        <p class="text-[11px] text-gray-400 truncate">{{ $product->user->seller->city }}, {{ $product->user->seller->province }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                        <p class="text-gray-500 mb-4">Tidak ada produk yang ditemukan</p>
                        @if(request()->hasAny(['search', 'category', 'store', 'province', 'city']))
                            <a href="{{ route('catalog.index') }}" 
                                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium inline-block">
                                Lihat Semua Produk
                            </a>
                        @endif
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
