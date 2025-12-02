<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - PojokKampus</title>
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
        <div class="mb-4">
            <a href="{{ route('catalog.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                ← Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <!-- Left Column: Images -->
            <div class="col-span-2">
                <div class="bg-white rounded-lg p-4 sticky top-24">
                    <img src="{{ Storage::url($product->image) }}" 
                        id="mainImage"
                        class="w-full h-80 object-contain rounded-lg mb-3"
                        alt="{{ $product->name }}">
                    
                    @if($product->images && count($product->images) > 0)
                        <div class="grid grid-cols-5 gap-2">
                            <img src="{{ Storage::url($product->image) }}" 
                                class="w-full h-16 object-cover rounded border-2 border-indigo-500 cursor-pointer hover:opacity-80 transition"
                                onclick="document.getElementById('mainImage').src = this.src; highlightThumb(this)">
                            @foreach($product->images as $img)
                                <img src="{{ Storage::url($img) }}" 
                                    class="w-full h-16 object-cover rounded border-2 border-gray-200 cursor-pointer hover:opacity-80 transition hover:border-indigo-300"
                                    onclick="document.getElementById('mainImage').src = this.src; highlightThumb(this)">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="col-span-3 space-y-3">
                <!-- Product Details -->
                <div class="bg-white rounded-lg p-5">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $product->name }}</h1>
                            <a href="{{ route('catalog.index', ['category' => $product->category_id]) }}" class="inline-flex items-center text-gray-600 hover:text-indigo-600 text-sm">
                                <span class="mr-1">{{ $product->category->icon }}</span>
                                {{ $product->category->name }}
                            </a>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 mb-4 pb-3 border-b text-sm">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400 text-lg">★</span>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($product->averageRating(), 1) }}</span>
                        </div>
                        <div class="h-4 w-px bg-gray-300"></div>
                        <div class="text-gray-600">
                            <span class="font-semibold">{{ $product->totalReviews() }}</span> ulasan
                        </div>
                        <div class="h-4 w-px bg-gray-300"></div>
                        <div class="text-gray-600">
                            <span class="font-semibold">{{ $product->sold ?? 0 }}</span> terjual
                        </div>
                    </div>

                    <div class="mb-5">
                        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-5">
                        @if($product->brand)
                            <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded text-sm">
                                <span class="text-lg">🏷️</span>
                                <div>
                                    <p class="text-xs text-gray-500">Brand</p>
                                    <p class="font-medium text-gray-900">{{ $product->brand }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded text-sm">
                            <span class="text-lg">{{ $product->condition == 'new' ? '✨' : '🔄' }}</span>
                            <div>
                                <p class="text-xs text-gray-500">Kondisi</p>
                                <p class="font-medium text-gray-900">{{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded text-sm">
                            <span class="text-lg">📦</span>
                            <div>
                                <p class="text-xs text-gray-500">Stok</p>
                                <p class="font-medium {{ $product->stock < 10 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $product->stock }} unit
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded text-sm">
                            <span class="text-lg">🛒</span>
                            <div>
                                <p class="text-xs text-gray-500">Min. Pembelian</p>
                                <p class="font-medium text-gray-900">{{ $product->min_order }} unit</p>
                            </div>
                        </div>
                        @if($product->weight)
                            <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded text-sm">
                                <span class="text-lg">⚖️</span>
                                <div>
                                    <p class="text-xs text-gray-500">Berat</p>
                                    <p class="font-medium text-gray-900">{{ $product->weight }} gram</p>
                                </div>
                            </div>
                        @endif
                        @if($product->sku)
                            <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded text-sm">
                                <span class="text-lg">🔖</span>
                                <div>
                                    <p class="text-xs text-gray-500">SKU</p>
                                    <p class="font-medium text-gray-900">{{ $product->sku }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add', $product->slug) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="flex items-center gap-3 mb-3">
                            <label class="text-sm font-medium text-gray-700">Jumlah:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="decrementQuantity()" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                <input type="number" name="quantity" id="quantity" value="{{ $product->min_order }}" min="{{ $product->min_order }}" max="{{ $product->stock }}" class="w-16 text-center border-0 focus:ring-0 py-1">
                                <button type="button" onclick="incrementQuantity()" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                            </div>
                            <span class="text-sm text-gray-500">Stok: {{ $product->stock }}</span>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-4 py-3 bg-white border-2 border-indigo-600 text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition text-sm">
                                + Keranjang
                            </button>
                            <a href="{{ route('cart.index') }}" class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition text-sm text-center">
                                Beli Sekarang
                            </a>
                        </div>
                    </form>
                    
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-lg text-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <!-- Store Info -->
                <div class="bg-white rounded-lg p-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Informasi Toko</h2>
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-lg font-bold text-white">{{ substr($product->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $product->user->name }}</h3>
                                @if($product->user->seller)
                                    <p class="text-gray-600 text-xs flex items-center gap-1">
                                        <span>📍</span>
                                        {{ $product->user->seller->city }}, {{ $product->user->seller->province }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('catalog.index', ['store' => $product->user->name]) }}" 
                            class="px-3 py-2 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 text-xs font-medium rounded transition">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg p-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Produk</h2>
                    <div class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $product->description }}</div>
                </div>

                <!-- Reviews -->
                <div class="bg-white rounded-lg p-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Ulasan Pembeli <span class="font-normal text-gray-600">({{ $product->totalReviews() }})</span></h2>

                    <!-- Add Review Form -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Berikan Ulasan Anda</h3>
                        <form action="{{ route('reviews.store', $product->slug) }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                                    <input type="text" name="guest_name" required value="{{ old('guest_name') }}" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    @error('guest_name')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP *</label>
                                    <input type="text" name="guest_phone" required value="{{ old('guest_phone') }}" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    @error('guest_phone')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="guest_email" required value="{{ old('guest_email') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @error('guest_email')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rating *</label>
                                <div class="flex gap-1" id="rating-container">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" required class="hidden">
                                        <label for="rating{{ $i }}" class="rating-star cursor-pointer text-4xl text-gray-300 hover:text-yellow-400 transition" data-value="{{ $i }}">★</label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Komentar (Opsional)</label>
                                <textarea name="comment" rows="3" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition text-sm">
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>

                    @if($product->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($product->reviews as $review)
                                <div class="border-b pb-3 last:border-0">
                                    <div class="flex items-start gap-2">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm font-bold text-white">{{ substr($review->reviewer_name, 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-sm text-gray-900">{{ $review->reviewer_name }}</p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <div class="flex items-center gap-0.5">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500">• {{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if($review->comment)
                                                <p class="text-sm text-gray-700 mt-2">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <span class="text-4xl mb-2 block">💬</span>
                            <p class="text-sm text-gray-500">Belum ada ulasan untuk produk ini</p>
                        </div>
                    @endif
                </div>

                <!-- Related Products -->
                @if($relatedProducts->count() > 0)
                    <div class="bg-white rounded-lg p-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Produk Serupa</h2>
                        <div class="grid grid-cols-5 gap-3">
                            @foreach($relatedProducts as $related)
                                <a href="{{ route('catalog.show', $related) }}" 
                                    class="group border border-gray-200 rounded overflow-hidden hover:shadow-lg transition">
                                    <div class="relative overflow-hidden">
                                        <img src="{{ Storage::url($related->image) }}" 
                                            class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300"
                                            alt="{{ $related->name }}">
                                    </div>
                                    <div class="p-2">
                                        <h3 class="text-xs text-gray-900 mb-1 line-clamp-2">{{ $related->name }}</h3>
                                        <p class="text-sm font-bold text-gray-900">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
                                            <span class="text-yellow-400">★</span>
                                            <span>{{ number_format($related->averageRating(), 1) }}</span>
                                            <span>•</span>
                                            <span>{{ $related->sold ?? 0 }} terjual</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
    function highlightThumb(element) {
        document.querySelectorAll('.grid img').forEach(img => {
            img.classList.remove('border-indigo-500');
            img.classList.add('border-gray-200');
        });
        element.classList.remove('border-gray-200');
        element.classList.add('border-indigo-500');
    }

    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const min = parseInt(input.min);
        const current = parseInt(input.value);
        if (current > min) {
            input.value = current - 1;
        }
    }

    // Rating star interaction
    document.addEventListener('DOMContentLoaded', function() {
        const ratingContainer = document.getElementById('rating-container');
        const stars = ratingContainer.querySelectorAll('.rating-star');
        let selectedRating = 0;

        stars.forEach(star => {
            // Click to select
            star.addEventListener('click', function() {
                const value = parseInt(this.dataset.value);
                selectedRating = value;
                document.getElementById('rating' + value).checked = true;
                updateStars(value);
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.dataset.value);
                updateStars(value);
            });

            // Reset on mouse leave
            ratingContainer.addEventListener('mouseleave', function() {
                updateStars(selectedRating);
            });
        });

        function updateStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }
    });
    </script>
</body>
</html>
