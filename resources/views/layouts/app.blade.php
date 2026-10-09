<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa] text-slate-800 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cartiva – Deeper Discounts, Together | Inspired by Groupon')</title>
    <meta name="description" content="Discover incredible group buying discounts on tech, food, campus merchandise and lifestyle products with Cartiva.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans bg-[#f8f9fa] text-slate-800 selection:bg-[#53a318] selection:text-white" 
      x-data="{ mobileMenuOpen: false, notifOpen: false, userDropdownOpen: false }">

    <!-- 1. Top Groupon-Style Promo Banner Ribbon -->
    <div class="bg-[#1e293b] text-white text-xs font-semibold py-2 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2 text-[11px] sm:text-xs">
                <span class="inline-flex items-center px-2 py-0.5 rounded font-black bg-[#53a318] text-white text-[10px] uppercase tracking-wider">
                    DEAL OF THE DAY
                </span>
                <span>🔥 Use code <strong class="text-amber-300 font-mono font-bold">CARTIVA20</strong> for an extra 20% off all group buys!</span>
            </div>
            <div class="hidden md:flex items-center space-x-5 text-slate-300 text-xs">
                <span class="flex items-center space-x-1 hover:text-white cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>100% Refund Guarantee</span>
                </span>
                <span>|</span>
                <a href="#cartiva-guarantee" class="hover:text-white">Cartiva Promise</a>
                <span>|</span>
                <a href="{{ route('register') }}" class="text-[#53a318] font-bold hover:underline">Sell on Cartiva</a>
            </div>
        </div>
    </div>

    <!-- 2. Main Groupon Header (Logo + Dual Search Bar + User Nav) -->
    <header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Groupon-Style Logo -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                        <div class="w-10 h-10 rounded-xl bg-[#53a318] flex items-center justify-center text-white font-black text-2xl shadow-sm group-hover:bg-[#468c13] transition-colors">
                            C
                        </div>
                        <div class="leading-none">
                            <span class="text-2xl sm:text-3xl font-black tracking-tighter text-[#53a318] uppercase">
                                CARTIVA
                            </span>
                            <span class="block text-[9px] font-bold text-slate-500 tracking-wider uppercase mt-0.5">
                                Group Buying Marketplace
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Groupon Signature Split Dual Search Bar: [What] | [Where] [Search Button] -->
                <div class="hidden lg:flex flex-1 max-w-2xl mx-4">
                    <form action="{{ route('home') }}" method="GET" class="w-full flex items-center bg-white border-2 border-[#53a318] rounded-lg overflow-hidden shadow-xs focus-within:ring-2 focus-within:ring-[#53a318]/30 transition-all">
                        
                        <!-- Left Field: What (Deal, Product or Group ID) -->
                        <div class="flex-1 flex items-center px-3.5 py-2">
                            <svg class="w-4 h-4 text-slate-400 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="q" value="{{ request('q') }}" 
                                   placeholder="Search deals, products, or Group Code (e.g. GRP-BAUST05)..." 
                                   class="w-full text-xs text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none font-medium">
                        </div>

                        <!-- Divider line -->
                        <div class="h-6 w-px bg-slate-200"></div>

                        <!-- Right Field: Where (Location) -->
                        <div class="w-48 flex items-center px-3 py-2 bg-slate-50/70">
                            <svg class="w-4 h-4 text-slate-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <select class="w-full text-xs text-slate-700 bg-transparent focus:outline-none font-medium cursor-pointer">
                                <option>All Locations</option>
                                <option>Saidpur / BAUST</option>
                                <option>Dhaka Metro</option>
                                <option>Chittagong</option>
                                <option>Rajshahi</option>
                            </select>
                        </div>

                        <!-- Green Search Submit Button -->
                        <button type="submit" class="bg-[#53a318] hover:bg-[#468c13] text-white px-5 py-2.5 text-xs font-bold transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </div>

                <!-- Top Right Navigation & User Controls -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    
                    <!-- Notification Bell -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" 
                                class="p-2 text-slate-600 hover:text-[#53a318] rounded-full hover:bg-slate-100 transition-colors relative"
                                title="Deal Notifications">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                        </button>

                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-slate-100 py-3 z-50">
                            <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-black text-slate-800 uppercase">Live Deal Alerts</span>
                                <span class="text-[10px] font-bold text-[#53a318] bg-green-50 px-2 py-0.5 rounded-full">2 New</span>
                            </div>
                            <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                                <a href="{{ route('group-buy.show', 'GRP-BAUST05') }}" class="p-3 flex items-start space-x-2.5 hover:bg-slate-50 transition-colors block">
                                    <span class="text-base">⚡</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">BAUST Hoodie Deal: Only 1 buyer left!</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Tier 3 (৳৭৫০) unlocks once 1 more user joins.</p>
                                    </div>
                                </a>
                                <a href="{{ route('group-buy.show', 'GRP-SOUND99') }}" class="p-3 flex items-start space-x-2.5 hover:bg-slate-50 transition-colors block">
                                    <span class="text-base">⏱</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">SoundCore ANC Headphones Deal ending soon!</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Only 3 hours remaining to lock in 30% discount.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- My Groups / Orders Shortcut -->
                    @auth
                        <a href="{{ route('orders.index') }}" class="hidden sm:flex items-center space-x-1.5 text-xs font-bold text-slate-700 hover:text-[#53a318] transition-colors p-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span class="hidden md:inline">My Stuff</span>
                        </a>
                    @endauth

                    <!-- User Account Dropdown / Sign In -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" 
                                    class="flex items-center space-x-2 py-1.5 px-3 rounded-lg border border-slate-200 hover:border-slate-300 text-xs font-bold text-slate-800 bg-white transition-all">
                                <div class="w-6 h-6 rounded-full bg-[#53a318] text-white flex items-center justify-center text-[11px] font-black">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-[11px] text-slate-400">Signed in as</p>
                                    <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold rounded-full bg-green-100 text-[#53a318] uppercase">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>

                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#53a318]">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    My Orders & Groups
                                </a>

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-xs font-semibold text-purple-700 hover:bg-purple-50">
                                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                        Admin Management
                                    </a>
                                @endif

                                @if(auth()->user()->isSeller())
                                    <a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-2 text-xs font-semibold text-teal-700 hover:bg-teal-50">
                                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Merchant Portal
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-bold text-slate-700 hover:text-[#53a318] transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold rounded-lg bg-[#53a318] hover:bg-[#468c13] text-white shadow-xs transition-all">
                                Sign Up
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Hamburger -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-slate-600 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                </div>

            </div>

            <!-- 3. Groupon Signature Horizontal Category Sub-Navigation Bar -->
            <div class="hidden md:flex items-center justify-between border-t border-slate-100 py-2.5 text-xs font-bold text-slate-600 overflow-x-auto scrollbar-none">
                <div class="flex items-center space-x-7">
                    <a href="{{ route('home') }}" class="text-[#53a318] hover:text-[#468c13] flex items-center space-x-1">
                        <span>Featured Deals</span>
                    </a>
                    <a href="{{ route('home') }}#live-groups" class="hover:text-[#53a318] flex items-center space-x-1 text-rose-600">
                        <span>🔥 Ending Soon</span>
                    </a>
                    <a href="{{ route('home') }}?category=tech-accessories" class="hover:text-[#53a318]">
                        Tech & Gadgets
                    </a>
                    <a href="{{ route('home') }}?category=campus-merchandise" class="hover:text-[#53a318] flex items-center space-x-1">
                        <span>Campus Specials</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[9px] bg-amber-100 text-amber-800 font-black">BAUST</span>
                    </a>
                    <a href="{{ route('home') }}?category=dry-food-fmcg" class="hover:text-[#53a318]">
                        Food & FMCG
                    </a>
                    <a href="{{ route('home') }}?category=home-lifestyle" class="hover:text-[#53a318]">
                        Home & Lifestyle
                    </a>
                    <a href="{{ route('home') }}?category=fashion-wearables" class="hover:text-[#53a318]">
                        Fashion & Wearables
                    </a>
                </div>

                <div class="flex items-center space-x-4 flex-shrink-0 pl-4">
                    <a href="#how-it-works" class="text-slate-500 hover:text-[#53a318] text-[11px] font-semibold">
                        How Group Buying Works
                    </a>
                    <a href="{{ route('register') }}" class="text-[#53a318] hover:underline text-[11px] font-bold">
                        Become a Merchant
                    </a>
                </div>
            </div>

            <!-- Mobile Search Bar & Menu Drawer -->
            <div x-show="mobileMenuOpen" x-cloak class="lg:hidden pb-4 pt-2 border-t border-slate-100">
                <form action="{{ route('home') }}" method="GET" class="mb-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search deals or group code (e.g. GRP-BAUST05)..." class="w-full px-4 py-2.5 text-xs bg-slate-100 border border-slate-200 rounded-lg">
                </form>
                <div class="flex flex-col space-y-2 text-xs font-bold text-slate-700">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100">Featured Deals</a>
                    <a href="{{ route('home') }}#live-groups" class="px-3 py-2 rounded-lg hover:bg-slate-100 text-rose-600">Ending Soon (Live Drops)</a>
                    <a href="{{ route('home') }}?category=campus-merchandise" class="px-3 py-2 rounded-lg hover:bg-slate-100">Campus Merchandise</a>
                    <a href="{{ route('home') }}?category=tech-accessories" class="px-3 py-2 rounded-lg hover:bg-slate-100">Tech & Gadgets</a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100">My Stuff & Orders</a>
                    @endauth
                </div>
            </div>

        </div>
    </header>

    <!-- Global Flash Notification Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-900 flex items-center justify-between shadow-xs mb-3">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-[#53a318] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-xs sm:text-sm font-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between shadow-xs mb-3">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-xs sm:text-sm font-bold">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- 8. Groupon-Style Multi-Column Footer -->
    <footer class="mt-20 bg-white border-t border-slate-200 pt-16 pb-12 text-slate-600 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 pb-12 border-b border-slate-200">
                
                <!-- Col 1: Brand & App Download -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg bg-[#53a318] flex items-center justify-center text-white font-black text-xl">
                            C
                        </div>
                        <span class="text-2xl font-black tracking-tight text-[#53a318] uppercase">CARTIVA</span>
                    </div>
                    <p class="text-slate-500 leading-relaxed text-xs pr-6">
                        Cartiva is the premier group-buying discovery marketplace. By pooling demand together, consumers unlock wholesale volume discounts without paying retail markup.
                    </p>
                    <div class="pt-2 space-y-2">
                        <span class="text-[11px] font-bold text-slate-800 uppercase block">The Cartiva Guarantee:</span>
                        <div class="flex items-center space-x-2 text-[#53a318] font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>100% Automatic Refund on Unfilled Groups</span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Customer Support -->
                <div>
                    <h4 class="font-bold text-slate-900 uppercase text-xs mb-3">Customer Support</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li><a href="#how-it-works" class="hover:text-[#53a318] transition-colors">How Group Buying Works</a></li>
                        <li><a href="#cartiva-guarantee" class="hover:text-[#53a318] transition-colors">Refund & Return Policy</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-[#53a318] transition-colors">Track Orders</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">FAQ & Help Center</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Dispute Resolution</a></li>
                    </ul>
                </div>

                <!-- Col 3: Work with Cartiva (Merchants) -->
                <div>
                    <h4 class="font-bold text-slate-900 uppercase text-xs mb-3">Sell on Cartiva</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li><a href="{{ route('register') }}" class="text-[#53a318] font-bold hover:underline">Merchant Registration</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#53a318] transition-colors">Merchant Portal Login</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Bulk Clearance Solutions</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Courier & Logistics SLA</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Zero Ad-Waste Marketing</a></li>
                    </ul>
                </div>

                <!-- Col 4: Academic Project & Contact -->
                <div>
                    <h4 class="font-bold text-slate-900 uppercase text-xs mb-3">Project & Contact</h4>
                    <p class="text-slate-500 text-xs mb-2">
                        Course: <strong>CSE 3200</strong><br>
                        Web Engineering Project<br>
                        <strong>BAUST, Saidpur Cantonment</strong>
                    </p>
                    <p class="text-slate-500 text-xs">
                        Email: <a href="mailto:support@cartiva.com" class="text-[#53a318]">support@cartiva.com</a><br>
                        Helpline: +880 1711 000001
                    </p>
                </div>

            </div>

            <!-- Bottom Copyright & Legal -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} Cartiva Group Commerce Inc. Group 10, CSE, BAUST. All rights reserved.</p>
                <div class="flex items-center space-x-6 mt-4 sm:mt-0 font-medium">
                    <a href="#" class="hover:text-slate-600">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-600">Terms of Service</a>
                    <a href="#" class="hover:text-slate-600">Merchant Agreement</a>
                    <span class="text-[#53a318] font-bold">Bangladeshi Taka (৳)</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
