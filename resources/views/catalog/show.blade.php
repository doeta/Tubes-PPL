<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - PojokKampus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Hide scrollbar for gallery thumbnails */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <header class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm backdrop-blur-md bg-opacity-90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 gap-8">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-2 hover:opacity-80 transition">
                    <img src="{{ asset('images/logo.png') }}" alt="PojokKampus Logo" class="h-10 w-auto">
                </a>
                
                <form method="GET" action="{{ route('catalog.index') }}" class="flex-1 max-w-2xl relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari produk, toko, atau brand..."
                        class="block w-full pl-11 pr-4 py-2.5 bg-gray-100 border-transparent text-gray-900 placeholder-gray-500 rounded-full focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-all duration-200">
                </form>

                <div class="flex gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 self-center">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors group">
                <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center group-hover:border-indigo-600 group-hover:text-indigo-600 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <span>Kembali ke Katalog</span>
            </a>
        </div>

        <!-- Breadcrumb -->
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500">
            <a href="{{ route('catalog.index') }}" class="hover:text-indigo-600">Katalog</a>
            <span class="mx-2">/</span>
            <a href="{{ route('catalog.index', ['category' => $product->category_id]) }}" class="hover:text-indigo-600">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium truncate max-w-xs">{{ $product->name }}</span>
        </nav>

        <!-- Product Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Image Section -->
                <div class="lg:col-span-5">
                    <div class="sticky top-28 space-y-4">
                        <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 relative group">
                            <img src="{{ Storage::url($product->image) }}" 
                                id="mainImage"
                                class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-500"
                                alt="{{ $product->name }}">
                        </div>
                        
                        @if($product->images && count($product->images) > 0)
                            <div class="flex gap-3 overflow-x-auto no-scrollbar pb-2">
                                <button class="flex-shrink-0 w-20 h-20 rounded-xl border-2 border-indigo-600 overflow-hidden bg-gray-50 p-1"
                                    onclick="updateMainImage(this, '{{ Storage::url($product->image) }}')">
                                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover rounded-lg">
                                </button>
                                @foreach($product->images as $img)
                                    <button class="flex-shrink-0 w-20 h-20 rounded-xl border-2 border-transparent hover:border-indigo-300 overflow-hidden bg-gray-50 p-1 transition-all"
                                        onclick="updateMainImage(this, '{{ Storage::url($img) }}')">
                                        <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover rounded-lg">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="lg:col-span-7 flex flex-col">
                    <!-- Title & Rating -->
                    <div class="border-b border-gray-100 pb-6 mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">{{ $product->name }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm">
                            <div class="flex items-center gap-1 text-yellow-500">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="font-bold text-gray-900 text-base">{{ number_format($product->averageRating(), 1) }}</span>
                                <span class="text-gray-400 font-normal">({{ $product->totalReviews() }} Ulasan)</span>
                            </div>
                            <span class="text-gray-300">|</span>
                            <span class="text-gray-600">Terjual <span class="font-semibold text-gray-900">{{ $product->sold ?? 0 }}</span></span>
                            <span class="text-gray-300">|</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->status == 'active' ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-8">
                        <p class="text-4xl font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    <!-- Product Info Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Kategori</p>
                                <p class="text-sm font-medium text-gray-900">{{ $product->category->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Kondisi</p>
                                <p class="text-sm font-medium text-gray-900">{{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Berat</p>
                                <p class="text-sm font-medium text-gray-900">{{ $product->weight ?? '-' }} Gram</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Stok</p>
                                <p class="text-sm font-medium {{ $product->stock < 5 ? 'text-red-600' : 'text-gray-900' }}">{{ $product->stock }} Unit</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seller Info -->
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between mb-8 border border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-indigo-600 font-bold text-lg border border-gray-100">
                                {{ substr($product->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $product->user->name }}</p>
                                @if($product->user->seller)
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $product->user->seller->city }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto flex flex-col sm:flex-row gap-3">
                        <button class="flex-1 px-6 py-4 bg-white border-2 border-indigo-600 text-indigo-600 rounded-xl font-bold hover:bg-indigo-50 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Tambah Keranjang
                        </button>
                        <button class="flex-1 px-6 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Deskripsi Produk
                    </h3>
                    <div class="prose prose-indigo prose-sm max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $product->description }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Ulasan Pembeli
                        </h3>
                        <span class="text-sm text-gray-500">{{ $product->totalReviews() }} Ulasan</span>
                    </div>

                    @if($product->reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach($product->reviews as $review)
                                <div class="border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center font-bold text-white flex-shrink-0 shadow-md">
                                            {{ substr($review->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <p class="font-semibold text-gray-900 text-sm">{{ $review->name }}</p>
                                                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="flex items-center gap-1 mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                @endfor
                                            </div>
                                            @if($review->comment)
                                                <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-3 rounded-lg">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-gray-500 font-medium">Belum ada ulasan</p>
                            <p class="text-xs text-gray-400">Jadilah yang pertama mengulas produk ini!</p>
                        </div>
                    @endif

                    <!-- Review Form - SRS-MartPlace-06 -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <button onclick="toggleReviewForm()" class="w-full px-6 py-3 bg-gradient-to-r from-teal-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-indigo-700 transition-all shadow-lg shadow-teal-200 flex items-center justify-center gap-2 hover:scale-[1.02] active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Tulis Ulasan
                        </button>

                        <!-- Review Form Modal -->
                        <div id="reviewFormContainer" class="hidden mt-6 bg-gradient-to-br from-teal-50/50 via-white to-indigo-50/50 rounded-2xl p-6 border-2 border-teal-100 shadow-lg">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-xl font-bold bg-gradient-to-r from-teal-600 to-indigo-600 bg-clip-text text-transparent">Berikan Ulasan Anda</h4>
                                <button onclick="toggleReviewForm()" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            @if(session('success'))
                                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-teal-50 border-2 border-green-200 rounded-xl flex items-start gap-3 animate-pulse">
                                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            @endif

                            <form action="{{ route('review.store', $product->slug) }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('name') border-red-500 @enderror"
                                            placeholder="Masukkan nama Anda">
                                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP <span class="text-red-500">*</span></label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" required
                                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('phone') border-red-500 @enderror"
                                            placeholder="08xxxxxxxxxx">
                                        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('email') border-red-500 @enderror"
                                        placeholder="email@example.com">
                                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                    <p class="mt-1 text-xs text-gray-500">Email akan digunakan untuk mengirimkan notifikasi ucapan terima kasih</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Rating <span class="text-red-500">*</span></label>
                                    <div class="flex gap-1" id="rating-container">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer group" data-rating="{{ $i }}">
                                                <input type="radio" name="rating" value="{{ $i }}" class="hidden rating-input" required {{ old('rating') == $i ? 'checked' : '' }}>
                                                <svg class="w-10 h-10 star-icon transition-all duration-200 {{ old('rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Klik bintang untuk memberikan rating (1-5)</p>
                                    @error('rating') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Komentar (Opsional)</label>
                                    <textarea name="comment" rows="4"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('comment') border-red-500 @enderror"
                                        placeholder="Bagikan pengalaman Anda tentang produk ini...">{{ old('comment') }}</textarea>
                                    @error('comment') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-teal-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]">
                                        Kirim Ulasan
                                    </button>
                                    <button type="button" onclick="toggleReviewForm()" class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                @if($relatedProducts->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h3 class="font-bold text-gray-900 mb-4">Produk Serupa</h3>
                        <div class="space-y-4">
                            @foreach($relatedProducts as $related)
                                <a href="{{ route('catalog.show', $related) }}" class="flex gap-4 group hover:bg-gray-50 p-2 rounded-xl transition-colors">
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        <img src="{{ Storage::url($related->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <div class="flex-1 min-w-0 py-1">
                                        <h4 class="text-sm font-medium text-gray-900 truncate mb-1 group-hover:text-indigo-600 transition-colors">{{ $related->name }}</h4>
                                        <p class="text-sm font-bold text-indigo-600 mb-1">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                        <div class="flex items-center gap-1 text-xs text-gray-500">
                                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span>{{ number_format($related->averageRating(), 1) }}</span>
                                            <span class="text-gray-300">•</span>
                                            <span>{{ $related->sold ?? 0 }} Terjual</span>
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
        function updateMainImage(button, src) {
            // Update Image
            const mainImage = document.getElementById('mainImage');
            mainImage.style.opacity = '0.5';
            setTimeout(() => {
                mainImage.src = src;
                mainImage.style.opacity = '1';
            }, 150);

            // Update Border State
            document.querySelectorAll('.flex-shrink-0').forEach(btn => {
                btn.classList.remove('border-indigo-600');
                btn.classList.add('border-transparent');
            });
            button.classList.remove('border-transparent');
            button.classList.add('border-indigo-600');
        }

        // Toggle Review Form (SRS-MartPlace-06)
        function toggleReviewForm() {
            const formContainer = document.getElementById('reviewFormContainer');
            formContainer.classList.toggle('hidden');
            
            // Scroll to form if opening
            if (!formContainer.classList.contains('hidden')) {
                formContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        // Interactive Rating Stars
        document.addEventListener('DOMContentLoaded', function() {
            const ratingContainer = document.getElementById('rating-container');
            const stars = ratingContainer.querySelectorAll('.star-icon');
            const inputs = ratingContainer.querySelectorAll('.rating-input');
            let selectedRating = {{ old('rating', 0) }};

            // Initialize selected rating
            updateStars(selectedRating);

            // Click event
            inputs.forEach((input, index) => {
                input.parentElement.addEventListener('click', function() {
                    selectedRating = index + 1;
                    updateStars(selectedRating);
                });
            });

            // Hover effect
            stars.forEach((star, index) => {
                star.parentElement.addEventListener('mouseenter', function() {
                    updateStars(index + 1, true);
                });
            });

            ratingContainer.addEventListener('mouseleave', function() {
                updateStars(selectedRating);
            });

            function updateStars(rating, isHover = false) {
                stars.forEach((star, index) => {
                    star.classList.remove('text-yellow-400', 'text-yellow-300', 'text-gray-300');
                    if (index < rating) {
                        star.classList.add(isHover ? 'text-yellow-300' : 'text-yellow-400');
                        if (!isHover) {
                            star.style.transform = 'scale(1.15)';
                            setTimeout(() => {
                                star.style.transform = 'scale(1)';
                            }, 200);
                        }
                    } else {
                        star.classList.add('text-gray-300');
                    }
                });
            }

            // Auto-show form if there are validation errors
            @if($errors->any() || old('name') || old('email') || old('phone') || old('rating') || old('comment'))
                const formContainer = document.getElementById('reviewFormContainer');
                formContainer.classList.remove('hidden');
                formContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            @endif

            // Auto-hide success message after showing form
            @if(session('success'))
                setTimeout(() => {
                    const formContainer = document.getElementById('reviewFormContainer');
                    formContainer.classList.add('hidden');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 5000);
            @endif
        });
    </script>
</body>
</html>