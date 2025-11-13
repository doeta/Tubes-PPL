@extends('layouts.seller')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Penjual</h1>
    <p class="text-gray-600 mt-1">Kelola toko dan produk Anda</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Produk</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_products']) }}</p>
            </div>
            <div class="bg-purple-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-green-600 font-medium">{{ $stats['active_products'] }} Produk Aktif</span>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_orders']) }}</p>
            </div>
            <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-yellow-600 font-medium">{{ $stats['pending_orders'] }} Pending</span>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Pendapatan</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-gray-500">{{ $stats['total_sold'] }} Produk Terjual</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Products -->
    <div class="bg-white rounded-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Produk Terbaru</h2>
                <a href="{{ route('seller.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recent_products as $product)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex gap-4">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-lg object-cover">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $product->category->name ?? 'No Category' }}</p>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-500">Stock: {{ $product->stock }}</span>
                            @if($product->status === 'active')
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                            @else
                                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded-full">{{ ucfirst($product->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <p class="mb-4">Belum ada produk</p>
                <a href="{{ route('seller.products.create') }}" class="inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                    Tambah Produk Pertama
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recent_orders as $order)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between mb-2">
                    <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                    @if($order->status === 'pending')
                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending</span>
                    @elseif($order->status === 'processing')
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Processing</span>
                    @elseif($order->status === 'shipped')
                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Shipped</span>
                    @elseif($order->status === 'delivered')
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Delivered</span>
                    @else
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Cancelled</span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">{{ $order->product->name ?? 'Produk Dihapus' }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->user->name }} • {{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                Belum ada pesanan
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg p-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold mb-2">Mulai Berjualan!</h3>
            <p class="text-indigo-100">Tambahkan produk baru dan raih lebih banyak pembeli</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="px-6 py-3 bg-white text-indigo-600 rounded-lg font-bold hover:bg-gray-100 transition-colors">
            + Tambah Produk
        </a>
    </div>
</div>
@endsection
