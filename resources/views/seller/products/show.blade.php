@extends('layouts.seller')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('seller.products.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
            ← Kembali ke Daftar Produk
        </a>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <!-- Left Column: Images -->
        <div class="col-span-1">
            <div class="bg-white rounded-lg border border-gray-200 p-4 sticky top-4">
                <img src="{{ Storage::url($product->image) }}" 
                    class="w-full h-64 object-cover rounded-lg mb-4"
                    alt="{{ $product->name }}">
                
                @if($product->images)
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($product->images as $img)
                            <img src="{{ Storage::url($img) }}" 
                                class="w-full h-20 object-cover rounded-lg border cursor-pointer hover:opacity-80"
                                onclick="document.querySelector('.col-span-1 img').src = this.src"
                                alt="Additional">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Product Info -->
        <div class="col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $product->category->icon }} {{ $product->category->name }}</p>
                    </div>
                    <span class="px-4 py-2 text-sm font-semibold
                        {{ $product->status == 'active' ? 'text-green-700 bg-green-100' : '' }}
                        {{ $product->status == 'draft' ? 'text-yellow-700 bg-yellow-100' : '' }}
                        {{ $product->status == 'inactive' ? 'text-gray-700 bg-gray-100' : '' }}
                        rounded-full">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center gap-1">
                        <span class="text-yellow-500 text-xl">★</span>
                        <span class="text-xl font-bold text-gray-900">{{ number_format($product->averageRating(), 1) }}</span>
                    </div>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-600">{{ $product->totalReviews() }} ulasan</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-600">{{ $product->sold ?? 0 }} terjual</span>
                </div>

                <div class="text-4xl font-bold text-indigo-600 mb-6">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    @if($product->sku)
                        <div>
                            <span class="text-gray-600">SKU:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $product->sku }}</span>
                        </div>
                    @endif
                    @if($product->brand)
                        <div>
                            <span class="text-gray-600">Brand:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $product->brand }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-gray-600">Kondisi:</span>
                        <span class="font-medium text-gray-900 ml-2">{{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Stok:</span>
                        <span class="font-medium {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-900' }} ml-2">
                            {{ $product->stock }} unit
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600">Min. Pembelian:</span>
                        <span class="font-medium text-gray-900 ml-2">{{ $product->min_order }} unit</span>
                    </div>
                    @if($product->weight)
                        <div>
                            <span class="text-gray-600">Berat:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $product->weight }} gram</span>
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-bold text-gray-900 mb-2">Deskripsi Produk</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('seller.products.edit', $product) }}"
                        class="flex-1 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-center">
                        Edit Produk
                    </a>
                    <form method="POST" action="{{ route('seller.products.destroy', $product) }}" 
                        onsubmit="return confirm('Yakin hapus produk ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">
                            Hapus Produk
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reviews -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Ulasan Produk ({{ $product->totalReviews() }})</h2>

                @if($product->reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($product->reviews as $review)
                            <div class="border-b pb-4 last:border-b-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center shadow-md">
                                        <span class="font-bold text-white">{{ substr($review->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $review->name }}</p>
                                        <div class="flex items-center gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if($review->comment)
                                    <p class="text-gray-700 ml-12">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Belum ada ulasan untuk produk ini</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
