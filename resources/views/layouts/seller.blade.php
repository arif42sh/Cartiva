<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa] text-slate-800 antialiased font-sans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Merchant Hub - Cartiva Seller Portal')</title>
    <meta name="description" content="Manage your products, live group-buying sessions, customer deliveries, and sales analytics with Cartiva Merchant Hub.">

    <!-- Fonts: Inter & Hind Siliguri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:100,200,300,400,500,600,700,800,900|hind-siliguri:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full flex flex-col font-sans bg-[#f8f9fa] text-slate-800 selection:bg-[#53a318] selection:text-white"
      x-data="{ userMenuOpen: false, notifMenuOpen: false }">

    <!-- Dedicated Executive Merchant Header (Crisp White Executive Bar with Official Brand Logo) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 text-slate-800 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            
            <!-- Left: Official Cartiva Logo & Merchant Badge -->
            <div class="flex items-center space-x-3.5 flex-shrink-0">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-2.5 group">
                    <img src="{{ asset('images/cartiva-logo.png') }}" 
                         alt="Cartiva" 
                         class="h-7 sm:h-8 w-auto object-contain transition-transform group-hover:scale-105">
                    <div class="hidden sm:block h-5 w-px bg-slate-200"></div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-emerald-50 text-[#53a318] border border-emerald-200 uppercase tracking-wider">
                        Merchant Hub
                    </span>
                </a>
            </div>

            <!-- Middle: Internal Merchant Search Bar -->
            <div class="hidden md:flex flex-1 max-w-md mx-4">
                <form action="{{ route('seller.products') }}" method="GET" class="w-full relative">
                    <input type="text" name="q" placeholder="Search product SKU, title, or keywords..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-[#53a318] focus:bg-white transition-all font-medium">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </form>
            </div>

            <!-- Right: Actions, Storefront View & Profile -->
            <div class="flex items-center space-x-3 flex-shrink-0">
                
                <!-- View Public Storefront Link -->
                <a href="{{ route('shop.show', auth()->user()) }}" target="_blank"
                   class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors shadow-2xs"
                   title="Preview your public shop page as seen by customers">
                    <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span>Live Storefront ↗</span>
                </a>

                <!-- Switch to Marketplace / Shopper View -->
                <a href="{{ route('home') }}" 
                   class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors hidden lg:inline-flex items-center space-x-1">
                    <span>Marketplace</span>
                </a>

                <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>

                <!-- Merchant Profile Dropdown -->
                <div class="relative" @click.outside="userMenuOpen = false">
                    <button type="button" @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center space-x-2.5 p-1 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                        <div class="w-8 h-8 rounded-lg overflow-hidden bg-slate-800 border border-slate-200 flex items-center justify-center text-xs font-black text-white flex-shrink-0"
                             style="background: linear-gradient(135deg, #53a318 0%, #10b981 100%);">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->shop_name ?? auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(auth()->user()->shop_name ?? auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="block text-xs font-bold text-slate-900 leading-tight truncate max-w-[120px]">
                                {{ auth()->user()->shop_name ?? auth()->user()->name }}
                            </span>
                            <span class="block text-[10px] text-emerald-600 font-semibold leading-tight">Verified Seller</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="userMenuOpen" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-1.5 z-50 text-slate-800 divide-y divide-slate-100">
                        
                        <div class="px-4 py-2.5">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">Signed in as Merchant</span>
                            <span class="text-xs font-extrabold text-slate-900 block truncate">{{ auth()->user()->shop_name ?? auth()->user()->name }}</span>
                            <span class="text-[11px] text-slate-500 block truncate">{{ auth()->user()->email }}</span>
                        </div>

                        <div class="py-1 text-xs font-semibold">
                            <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-[#53a318]">
                                Dashboard Overview
                            </a>
                            <a href="{{ route('seller.profile') }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-[#53a318]">
                                Store Profile & Settings
                            </a>
                            <a href="{{ route('shop.show', auth()->user()) }}" target="_blank" class="block px-4 py-2 hover:bg-slate-50 text-emerald-600 font-bold">
                                View Public Storefront ↗
                            </a>
                        </div>

                        <div class="py-1 text-xs font-semibold">
                            <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-slate-50 text-slate-600">
                                Switch to Marketplace Home
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-rose-50 text-rose-600 font-bold cursor-pointer">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Workspace Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Clean Executive Merchant Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16 py-6 text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="font-black text-slate-900">Cartiva Merchant Central</span>
                <span>•</span>
                <span>Version 2.0</span>
                <span>•</span>
                <span class="text-emerald-600 font-semibold">Platform Operational</span>
            </div>

            <div class="flex items-center space-x-4 text-xs font-medium text-slate-600">
                <a href="{{ route('seller.dashboard') }}" class="hover:text-slate-900">Dashboard</a>
                <a href="{{ route('seller.products') }}" class="hover:text-slate-900">Products</a>
                <a href="{{ route('seller.orders') }}" class="hover:text-slate-900">Orders</a>
                <a href="{{ route('seller.profile') }}" class="hover:text-slate-900">Store Profile</a>
                <a href="{{ route('home') }}" class="hover:text-slate-900">Customer Marketplace</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
