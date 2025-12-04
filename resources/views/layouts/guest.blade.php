<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Decorative -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-teal-500 via-teal-600 to-cyan-700 relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative z-10 flex flex-col justify-center items-center text-white p-12">
                    <img src="{{ asset('images/logo.png') }}" alt="PojokKampus Logo" class="h-32 w-auto mb-8 drop-shadow-2xl">
                    <p class="text-xl text-teal-100 text-center max-w-md">Marketplace terpercaya untuk kebutuhan kampus Anda</p>
                    <div class="mt-12 grid grid-cols-3 gap-8 text-center">
                        <div>
                            <div class="text-3xl font-bold">1000+</div>
                            <div class="text-sm text-teal-100">Produk</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">500+</div>
                            <div class="text-sm text-teal-100">Penjual</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">98%</div>
                            <div class="text-sm text-teal-100">Kepuasan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50">
                <!-- Logo for Mobile -->
                <div class="lg:hidden mb-8">
                    <a href="/" class="flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="PojokKampus Logo" class="h-20 w-auto mb-3">
                        <h1 class="text-2xl font-bold text-gray-900">PojokKampus</h1>
                    </a>
                </div>

                <!-- Content Card -->
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                        {{ $slot }}
                    </div>
                </div>

            <!-- Back to Home Link -->
            <div class="mt-6">
                <a href="{{ route('welcome') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </body>
</html>
