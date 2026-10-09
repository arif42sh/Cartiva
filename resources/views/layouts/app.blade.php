<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cartiva - Team Buying & Group Commerce Platform')</title>
    <meta name="description" content="Shop together, unlock unbeatable wholesale prices, and enjoy group discounts with real-time countdown deals on Cartiva.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans selection:bg-emerald-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-indigo-700 text-white text-xs font-semibold py-2 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950 uppercase tracking-wider animate-pulse">Live</span>
                <span>🔥 Group Buy Special: Team up with 1 friend & save up to 45% off!</span>
            </div>
            <div class="hidden sm:flex items-center space-x-6 text-emerald-100">
                <span class="flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>100% Refund Guarantee</span>
                </span>
                <span>|</span>
                <span>Free Express Shipping</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-slate-900 via-emerald-800 to-teal-700 bg-clip-text text-transparent">Cartiva</span>
                            <span class="block text-[10px] font-bold tracking-widest text-emerald-600 uppercase">Team Buy Platform</span>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-600">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('home') ? 'text-emerald-600 font-bold' : '' }}">
                            Explore Deals
                        </a>
                        <a href="{{ route('home') }}#live-groups" class="hover:text-emerald-600 transition-colors flex items-center space-x-1">
                            <span>Active Teams</span>
                            <span class="px-1.5 py-0.5 text-[10px] bg-emerald-100 text-emerald-700 font-bold rounded-full">Hot</span>
                        </a>
                        @auth
                            <a href="{{ route('orders.index') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('orders.*') ? 'text-emerald-600 font-bold' : '' }}">
                                My Orders
                            </a>
                        @endauth
                    </nav>
                </div>

                <!-- Search Input Bar -->
                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('home') }}" method="GET" class="w-full relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search team products, electronics, gear..." 
                               class="w-full pl-10 pr-4 py-2 text-sm bg-slate-100/80 border border-slate-200 rounded-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 placeholder-slate-400">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </div>

                <!-- User & Role Section -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Role Shortcuts -->
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg bg-purple-50 text-purple-700 border border-purple-200 hover:bg-purple-100 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-purple-600 mr-1.5 animate-pulse"></span>
                                Admin Panel
                            </a>
                        @elseif(auth()->user()->isSeller())
                            <a href="{{ route('seller.dashboard') }}" class="hidden sm:inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-100 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-teal-600 mr-1.5"></span>
                                Seller Hub
                            </a>
                        @endif

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center space-x-2 p-1.5 rounded-full hover:bg-slate-100 transition-colors focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:block text-xs font-bold text-slate-700">{{ auth()->user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50 transition ease-out duration-100">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs font-medium text-slate-500">Signed in as</p>
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 uppercase">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>

                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    My Orders
                                </a>

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-xs font-semibold text-purple-700 hover:bg-purple-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                        Admin Management
                                    </a>
                                @endif

                                @if(auth()->user()->isSeller())
                                    <a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-2 text-xs font-semibold text-teal-700 hover:bg-teal-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Seller Dashboard
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-bold text-slate-700 hover:text-emerald-600 transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold rounded-full bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm shadow-emerald-600/30 hover:shadow-md transition-all">
                                Get Started
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-600 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Search & Menu -->
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden pb-4 pt-2 border-t border-slate-200">
                <form action="{{ route('home') }}" method="GET" class="mb-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="w-full px-4 py-2 text-xs bg-slate-100 border border-slate-200 rounded-lg">
                </form>
                <div class="flex flex-col space-y-2 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="px-2 py-1.5 rounded-lg hover:bg-slate-100">Home</a>
                    <a href="{{ route('home') }}#live-groups" class="px-2 py-1.5 rounded-lg hover:bg-slate-100">Active Group Buys</a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="px-2 py-1.5 rounded-lg hover:bg-slate-100">My Orders</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Global Notification Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs mb-3">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs mb-3">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 flex items-center justify-between shadow-xs mb-3">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-semibold">{{ session('info') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Dynamic Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-20 bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <!-- Col 1 -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-white">Cartiva</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        The next-generation social eCommerce platform where friends, family, and shoppers team up to unlock wholesale prices with zero risk.
                    </p>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-800/60 text-[11px] font-semibold text-emerald-400">
                        ⚡ Powered by Laravel 12 & Alpine.js
                    </div>
                </div>

                <!-- Col 2 -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Trending Deals</a></li>
                        <li><a href="{{ route('home') }}#live-groups" class="hover:text-emerald-400 transition-colors">Active Team Buys</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-emerald-400 transition-colors">Track Orders</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors">Merchant Portal</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">How Team Buy Works</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-start space-x-2">
                            <span class="text-emerald-400 font-bold">1.</span>
                            <span>Choose any product and select Team Buy price</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-emerald-400 font-bold">2.</span>
                            <span>Invite a friend or join an existing open group</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-emerald-400 font-bold">3.</span>
                            <span>Once slots fill up, orders are confirmed & shipped!</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Trust & Guarantees -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">100% Risk Free</h4>
                    <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700 space-y-2 text-xs">
                        <div class="flex items-center space-x-2 text-emerald-400 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Cartiva Safety Shield</span>
                        </div>
                        <p class="text-slate-400 text-[11px] leading-relaxed">
                            If a group countdown expires before reaching target members, your payment is automatically refunded with zero deductions.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Cartiva Group Commerce Inc. All rights reserved.</p>
                <div class="flex items-center space-x-6 mt-4 sm:mt-0 font-medium">
                    <span class="text-slate-400">Database: MySQL (cartiva_db)</span>
                    <span class="text-slate-400">Tailwind v4 & Vite</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
