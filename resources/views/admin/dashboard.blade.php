@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-600 mt-1">Statistik dan Monitoring Platform PojokKampus (SRS-MartPlace-07)</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Sellers -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Penjual</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_sellers']) }}</p>
            </div>
            <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2">
            <span class="text-sm text-yellow-600 font-medium">{{ $stats['pending_sellers'] }} Pending</span>
            <span class="text-gray-300">•</span>
            <span class="text-sm text-green-600 font-medium">{{ $stats['active_sellers'] }} Active</span>
        </div>
    </div>

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
            <div class="bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-indigo-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-gray-500">Dari pesanan delivered</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Sellers -->
    <div class="bg-white rounded-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Penjual Terbaru</h2>
                <a href="{{ route('admin.sellers.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recent_sellers as $seller)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-100 w-10 h-10 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-bold">{{ substr($seller->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $seller->name }}</p>
                            <p class="text-sm text-gray-500">{{ $seller->seller->nama_toko ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($seller->status === 'pending')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending</span>
                        @elseif($seller->status === 'active')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                        @else
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Suspended</span>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">{{ $seller->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                Belum ada penjual terdaftar
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

<!-- Charts Section (SRS-MartPlace-07) -->
<div class="mt-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Grafik & Statistik</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Product Distribution by Category -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Sebaran Produk per Kategori</h3>
            <canvas id="productsByCategoryChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Store Distribution by Province -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Sebaran Toko per Provinsi (Top 10)</h3>
            <canvas id="storesByProvinceChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Seller Status Statistics -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Status Penjual</h3>
            <canvas id="sellerStatusChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Review Statistics (SRS-06) -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Review (SRS-06)</h3>
            <canvas id="participationChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart Data -->
<div id="chartData" style="display:none;"
     data-product-category-names="{{ json_encode($productsByCategory->pluck('name')) }}"
     data-product-category-totals="{{ json_encode($productsByCategory->pluck('total')) }}"
     data-province-names="{{ json_encode($storesByProvince->pluck('provinsi')) }}"
     data-province-totals="{{ json_encode($storesByProvince->pluck('total')) }}"
     data-seller-active="{{ $sellerStats['active'] }}"
     data-seller-inactive="{{ $sellerStats['inactive'] }}"
     data-total-reviews="{{ $participationStats['total_reviews'] }}"
     data-unique-reviewers="{{ $participationStats['unique_reviewers'] }}">
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/admin-charts.js') }}"></script>
@endsection
