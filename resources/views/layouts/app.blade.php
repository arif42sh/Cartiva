<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa] text-slate-800 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cartiva – Deeper Discounts, Together | Group Buying Platform')</title>
    <meta name="description" content="Discover incredible group buying discounts on tech, food, campus merchandise and lifestyle products with Cartiva.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900|hind-siliguri:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans bg-[#f8f9fa] text-slate-800 selection:bg-[#53a318] selection:text-white" 
      x-data="{ mobileMenuOpen: false, notifOpen: false, userDropdownOpen: false }">

    <!-- 1. Top Live Community Activity Marquee Ticker -->
    <div class="bg-[#111827] text-white text-xs font-semibold py-2 px-4 overflow-hidden border-b border-slate-800 shadow-inner">
        <div class="max-w-[1600px] mx-auto flex items-center justify-between gap-4">
            
            <!-- Live Activity Marquee Ticker -->
            <div class="flex-1 overflow-hidden relative flex items-center">
                <span class="inline-flex items-center px-2 py-0.5 rounded font-black bg-[#53a318] text-white text-[10px] uppercase tracking-wider mr-3 flex-shrink-0 z-10 shadow-sm animate-pulse">
                    ⚡ LIVE TICKER
                </span>

                <div class="overflow-hidden w-full whitespace-nowrap">
                    <div class="animate-marquee flex items-center space-x-10 text-[11px] sm:text-xs text-slate-300">
                        <span class="flex items-center space-x-1.5 font-bold text-amber-300">
                            <span>🔥 আজ মোট সাশ্রয়:</span>
                            <span class="text-white font-black bg-amber-500/30 px-1.5 py-0.2 rounded">৳৬৪,২০০+</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-emerald-400">৩৮টি গ্রুপ ডিল সফলভাবে আনলক হয়েছে!</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center space-x-1.5">
                            <span class="text-amber-400 font-bold">Arif S. (Saidpur)</span>
                            <span>just joined BAUST Hoodie group •</span>
                            <span class="text-[#84cc16] font-extrabold">৳২৫০ saved!</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center space-x-1.5">
                            <span class="text-emerald-400 font-bold">SoundCore ANC Headphones</span>
                            <span>deal is 80% filled •</span>
                            <span class="text-rose-400 font-extrabold">Only 1 slot left!</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center space-x-1.5">
                            <span class="text-cyan-400 font-bold">Fuad H. (Dhaka)</span>
                            <span>unlocked Tier 3 bulk price on Mechanical Keyboard •</span>
                            <span class="text-amber-300 font-extrabold">Order Confirmed</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center space-x-1.5">
                            <span class="text-purple-400 font-bold">Promo Voucher:</span>
                            <span class="bg-amber-400 text-slate-950 px-1.5 py-0.2 rounded font-mono font-black text-[10px]">CARTIVA20</span>
                            <span>for extra 20% discount on team checkout</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Guarantee Links -->
            <div class="hidden lg:flex items-center space-x-5 text-slate-300 text-xs flex-shrink-0">
                <span class="flex items-center space-x-1 text-emerald-400 font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>100% Refund Guarantee</span>
                </span>
                <span>|</span>
                <a href="#how-it-works" class="hover:text-white transition-colors">How It Works</a>
                <span>|</span>
                <a href="{{ route('register') }}" class="text-[#84cc16] font-bold hover:underline">Sell on Cartiva</a>
            </div>

        </div>
    </div>

    <!-- 2. Main High-Density Header (Full Width & Professional) -->
    <header class="sticky top-0 z-40 bg-white border-b border-gray-200/90 shadow-xs backdrop-blur-md"
            x-data="{ 
                searchOpen: false, 
                searchQuery: '{{ request('q') }}',
                categoriesDropdownOpen: false,
                wishlistCount: 3,
                cartCount: 1,
                cartModalOpen: false,
                wishlistModalOpen: false
            }">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex items-center justify-between h-20 gap-3 sm:gap-6 lg:gap-8">
                
                <!-- Brand Logo & Tagline -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group">
                        <img src="{{ asset('images/cartiva-logo.png') }}" 
                             alt="Cartiva" 
                             class="h-8 sm:h-9 w-auto max-w-[150px] sm:max-w-[180px] object-contain transition-transform group-hover:scale-105">
                        <div class="hidden sm:block leading-none border-l border-slate-200 pl-2.5">
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-blue-50 text-blue-800 uppercase tracking-wider block w-max">
                                GROUP BUY
                            </span>
                            <span class="block text-[9px] font-extrabold text-slate-400 tracking-wider uppercase mt-1">
                                Buy Together, Pay Less
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Smart Search Bar with Category Filter & Real-Time Pool Search -->
                <div class="hidden lg:flex flex-1 max-w-3xl mx-2 relative">
                    <form action="{{ route('home') }}" method="GET" class="w-full flex items-center bg-white border-2 border-[#53a318] rounded-xl overflow-hidden shadow-xs hover:border-[#468c13] focus-within:ring-4 focus-within:ring-[#53a318]/20 transition-all">
                        
                        <!-- Category Filter Selector -->
                        <div class="w-48 flex items-center px-3 py-2.5 bg-slate-50 border-r border-slate-200">
                            <svg class="w-3.5 h-3.5 text-slate-400 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            <select name="category" class="w-full text-xs text-slate-700 bg-transparent focus:outline-none font-bold cursor-pointer">
                                <option value="">All Categories</option>
                                <option value="tech-accessories" {{ request('category') == 'tech-accessories' ? 'selected' : '' }}>🎧 Electronics</option>
                                <option value="campus-merchandise" {{ request('category') == 'campus-merchandise' ? 'selected' : '' }}>🎓 Campus Specials</option>
                                <option value="fashion-wearables" {{ request('category') == 'fashion-wearables' ? 'selected' : '' }}>👕 Fashion</option>
                                <option value="dry-food-fmcg" {{ request('category') == 'dry-food-fmcg' ? 'selected' : '' }}>🥫 Grocery FMCG</option>
                                <option value="kitchen-appliances" {{ request('category') == 'kitchen-appliances' ? 'selected' : '' }}>🍳 Kitchen</option>
                                <option value="home-lifestyle" {{ request('category') == 'home-lifestyle' ? 'selected' : '' }}>🏠 Home & Living</option>
                            </select>
                        </div>

                        <!-- Left Field: What / Keyword / Group Code -->
                        <div class="flex-1 flex items-center px-4 py-2.5 relative">
                            <svg class="w-4 h-4 text-slate-400 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="q" x-model="searchQuery" 
                                   @focus="searchOpen = true"
                                   @click.outside="searchOpen = false"
                                   placeholder="Search products or Group Code (e.g. GRP-BAUST05)..." 
                                   class="w-full text-xs text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none font-semibold">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-[#53a318] hover:bg-[#468c13] text-white px-6 py-3 text-xs font-black transition-colors flex items-center space-x-1.5 flex-shrink-0">
                            <span>Search Deals</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>

                    <!-- Search Suggestions / Autocomplete Dropdown -->
                    <div x-show="searchOpen" x-cloak 
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 z-50 divide-y divide-slate-100">
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-2">🔥 Trending Search Keywords</span>
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button" @click="searchQuery = 'BAUST Hoodie'; $el.closest('form')?.submit()" 
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-green-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                                    🎓 BAUST Hoodie
                                </button>
                                <button type="button" @click="searchQuery = 'SoundCore Ultra ANC'; $el.closest('form')?.submit()" 
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-green-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                                    🎧 SoundCore ANC Headphones
                                </button>
                                <button type="button" @click="searchQuery = 'Mechanical Keyboard'; $el.closest('form')?.submit()" 
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-green-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                                    ⌨️ Mechanical Keyboard
                                </button>
                                <button type="button" @click="searchQuery = 'Air Fryer'; $el.closest('form')?.submit()" 
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-green-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                                    🍳 Digital Air Fryer
                                </button>
                                <button type="button" @click="searchQuery = 'Fast Charger'; $el.closest('form')?.submit()" 
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-green-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                                    ⚡ 65W GaN Charger
                                </button>
                            </div>
                        </div>

                        <div class="pt-3 mt-3">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-2">⚡ Direct Active Group Codes</span>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <a href="{{ route('group-buy.show', 'GRP-BAUST05') }}" class="p-2 rounded-xl bg-amber-50 border border-amber-200/60 hover:bg-amber-100 transition-all flex items-center justify-between">
                                    <div>
                                        <span class="font-mono font-black text-amber-900 block">GRP-BAUST05</span>
                                        <span class="text-[10px] text-amber-700">BAUST Hoodie (4/5 joined)</span>
                                    </div>
                                    <span class="text-[10px] font-black bg-amber-200 text-amber-900 px-1.5 py-0.5 rounded">1 Left</span>
                                </a>
                                <a href="{{ route('group-buy.show', 'GRP-SOUND99') }}" class="p-2 rounded-xl bg-emerald-50 border border-emerald-200/60 hover:bg-emerald-100 transition-all flex items-center justify-between">
                                    <div>
                                        <span class="font-mono font-black text-emerald-900 block">GRP-SOUND99</span>
                                        <span class="text-[10px] text-emerald-700">SoundCore ANC (1/2 joined)</span>
                                    </div>
                                    <span class="text-[10px] font-black bg-emerald-200 text-emerald-900 px-1.5 py-0.5 rounded">1 Left</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Controls & Dropdowns (My Groups, Wishlist, Cart, Notifications, Auth) -->
                <div class="flex items-center space-x-1.5 sm:space-x-2.5 flex-shrink-0">
                    
                    <!-- My Groups (Active Buying Circles) -->
                    <a href="{{ route('orders.index') }}" 
                       class="inline-flex items-center space-x-1.5 px-3 py-2 rounded-xl bg-green-50 hover:bg-green-100 text-[#53a318] border border-green-200/80 text-xs font-black transition-all shadow-2xs"
                       title="View My Active Groups & Buying Circles">
                        <span class="w-2 h-2 rounded-full bg-[#53a318] animate-ping"></span>
                        <span class="hidden sm:inline">My Groups</span>
                        <span class="px-1.5 py-0.2 rounded-full bg-[#53a318] text-white text-[10px] font-black">2</span>
                    </a>
                    
                    <!-- Notification Bell Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" 
                                class="p-2.5 text-slate-600 hover:text-[#53a318] rounded-xl hover:bg-slate-100 transition-colors relative"
                                title="Live Deal Notifications">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                        </button>

                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-100 py-3 z-50">
                            <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-black text-slate-800 uppercase tracking-wider">Live Deal Alerts</span>
                                <span class="text-[10px] font-black text-[#53a318] bg-green-50 px-2 py-0.5 rounded-full">2 High Urgency</span>
                            </div>
                            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                                <a href="{{ route('group-buy.show', 'GRP-BAUST05') }}" class="p-3.5 flex items-start space-x-3 hover:bg-slate-50 transition-colors block">
                                    <span class="text-lg flex-shrink-0">⚡</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">BAUST Hoodie Deal: Only 1 buyer left!</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Tier 3 (৳৭৫০) unlocks once 1 more student joins.</p>
                                        <span class="text-[10px] text-[#53a318] font-mono font-bold mt-1 block">GRP-BAUST05 • 5 hours left</span>
                                    </div>
                                </a>
                                <a href="{{ route('group-buy.show', 'GRP-SOUND99') }}" class="p-3.5 flex items-start space-x-3 hover:bg-slate-50 transition-colors block">
                                    <span class="text-lg flex-shrink-0">⏱</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">SoundCore ANC Headphones Deal ending soon!</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Only 3 hours remaining to lock in 30% discount.</p>
                                        <span class="text-[10px] text-rose-600 font-mono font-bold mt-1 block">GRP-SOUND99 • 1 slot left</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist Icon with Count -->
                    <button @click="wishlistModalOpen = true" 
                            class="p-2.5 text-slate-600 hover:text-rose-600 rounded-xl hover:bg-slate-100 transition-colors relative"
                            title="My Wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white" 
                              x-text="wishlistCount">3</span>
                    </button>

                    <!-- Cart Icon with Count -->
                    <button @click="cartModalOpen = true" 
                            class="p-2.5 text-slate-600 hover:text-[#53a318] rounded-xl hover:bg-slate-100 transition-colors relative"
                            title="My Shopping Cart">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-[#53a318] text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white" 
                              x-text="cartCount">1</span>
                    </button>

                    <!-- User Account Dropdown / Sign In -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" 
                                    class="flex items-center space-x-2 py-2 px-3 rounded-xl border border-slate-200 hover:border-slate-300 text-xs font-bold text-slate-800 bg-white transition-all shadow-2xs">
                                <div class="w-6 h-6 rounded-full bg-[#53a318] text-white flex items-center justify-center text-[11px] font-black">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
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
                            <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white shadow-xs transition-all">
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

            <!-- 3. Category Navigation Menu (Section 1 Checklist) -->
            <div class="hidden md:flex items-center justify-between border-t border-slate-100 py-2.5 text-xs font-bold text-slate-600">
                <div class="flex items-center space-x-6 overflow-x-auto no-scrollbar">
                    
                    <!-- Categories Mega Dropdown -->
                    <div class="relative" x-data="{ catOpen: false }">
                        <button @click="catOpen = !catOpen" @click.outside="catOpen = false" 
                                class="flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#53a318] hover:text-white text-slate-800 transition-all font-black text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            <span>Categories</span>
                            <svg class="w-3.5 h-3.5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="catOpen" x-cloak 
                             class="absolute left-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-slate-100 p-3 z-50 divide-y divide-slate-100">
                            <div class="grid grid-cols-1 gap-1 py-1">
                                <a href="{{ route('home') }}?category=tech-accessories" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <span class="text-xl">🎧</span>
                                    <div class="leading-tight">
                                        <p class="font-bold text-slate-800 text-xs">Electronics & Gadgets</p>
                                        <p class="text-[10px] text-slate-400">Headphones, chargers & audio</p>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}?category=campus-merchandise" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <span class="text-xl">🎓</span>
                                    <div class="leading-tight">
                                        <p class="font-bold text-slate-800 text-xs">Campus Specials (BAUST)</p>
                                        <p class="text-[10px] text-slate-400">Winter fleece hoodies & kits</p>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}?category=fashion-wearables" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <span class="text-xl">👕</span>
                                    <div class="leading-tight">
                                        <p class="font-bold text-slate-800 text-xs">Fashion & Apparel</p>
                                        <p class="text-[10px] text-slate-400">Smartwatches, outfits & jackets</p>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}?category=dry-food-fmcg" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <span class="text-xl">🥫</span>
                                    <div class="leading-tight">
                                        <p class="font-bold text-slate-800 text-xs">Grocery & Food FMCG</p>
                                        <p class="text-[10px] text-slate-400">Dates, honey, tea & combos</p>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}?category=home-lifestyle" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <span class="text-xl">🏠</span>
                                    <div class="leading-tight">
                                        <p class="font-bold text-slate-800 text-xs">Home & Living</p>
                                        <p class="text-[10px] text-slate-400">Lamps, coffee machines & decor</p>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}?category=kitchen-appliances" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                    <span class="text-xl">🍳</span>
                                    <div class="leading-tight">
                                        <p class="font-bold text-slate-800 text-xs">Kitchen & Appliances</p>
                                        <p class="text-[10px] text-slate-400">Air fryers & blenders</p>
                                    </div>
                                </a>
                            </div>
                            <div class="pt-2 text-center">
                                <a href="{{ route('home') }}#quick-categories" class="text-[11px] font-bold text-[#53a318] hover:underline">
                                    View All 12 Categories &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="text-[#53a318] hover:text-[#468c13] flex items-center space-x-1 font-extrabold">
                        <span>Home</span>
                    </a>
                    <a href="{{ route('home') }}#browse-category" class="hover:text-[#53a318] transition-colors">
                        All Products / Shop
                    </a>
                    <a href="{{ route('home') }}#today-deals" class="hover:text-[#53a318] transition-colors">
                        Group Deals
                    </a>
                    <a href="{{ route('home') }}#almost-there" class="text-rose-600 hover:text-rose-700 flex items-center space-x-1 font-extrabold">
                        <span>⚡ Almost Full Groups</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                    </a>
                    <a href="{{ route('home') }}#flash-deals" class="hover:text-amber-600 transition-colors">
                        Flash Deals 🔥
                    </a>
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-[#53a318] transition-colors">
                        How It Works
                    </a>
                    <a href="{{ route('home') }}#seller-promo" class="text-slate-500 hover:text-[#53a318] transition-colors">
                        Become a Seller
                    </a>
                </div>

                <div class="flex items-center space-x-4 flex-shrink-0 pl-4 text-[11px]">
                    <a href="#cartiva-guarantee" class="text-emerald-700 font-bold flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>100% Refund Guarantee</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div x-show="mobileMenuOpen" x-cloak class="lg:hidden pb-4 pt-2 border-t border-slate-100">
                <form action="{{ route('home') }}" method="GET" class="mb-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search deals or group code (e.g. GRP-BAUST05)..." class="w-full px-4 py-2.5 text-xs bg-slate-100 border border-slate-200 rounded-lg">
                </form>
                <div class="flex flex-col space-y-2 text-xs font-bold text-slate-700">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100">Home</a>
                    <a href="{{ route('home') }}#today-deals" class="px-3 py-2 rounded-lg hover:bg-slate-100">Today's Best Group Deals</a>
                    <a href="{{ route('home') }}#almost-there" class="px-3 py-2 rounded-lg hover:bg-slate-100 text-rose-600">Almost Completed Groups</a>
                    <a href="{{ route('home') }}#flash-deals" class="px-3 py-2 rounded-lg hover:bg-slate-100">Flash Deals</a>
                    <a href="{{ route('home') }}#browse-category" class="px-3 py-2 rounded-lg hover:bg-slate-100">Browse by Category</a>
                    <a href="{{ route('home') }}#how-it-works" class="px-3 py-2 rounded-lg hover:bg-slate-100">How Group Buying Works</a>
                    <a href="{{ route('home') }}#seller-promo" class="px-3 py-2 rounded-lg hover:bg-slate-100">Become a Seller</a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 text-[#53a318]">My Orders & Groups</a>
                    @endauth
                </div>
            </div>

        </div>

        <!-- Wishlist Mini Modal -->
        <div x-show="wishlistModalOpen" x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
            <div @click.outside="wishlistModalOpen = false" 
                 class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b pb-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl">❤️</span>
                        <h3 class="text-base font-black text-slate-900">My Saved Wishlist</h3>
                    </div>
                    <button @click="wishlistModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>
                </div>
                <div class="space-y-3 text-xs max-h-72 overflow-y-auto">
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-800">BAUST Fleece Winter Hoodie</p>
                            <p class="text-emerald-700 font-bold">Group Price: ৳৭৫০ (Save ৳২৫০)</p>
                        </div>
                        <a href="{{ route('group-buy.show', 'GRP-BAUST05') }}" class="px-3 py-1.5 bg-[#53a318] text-white font-bold rounded-lg text-[11px]">Join</a>
                    </div>
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-800">SoundCore ANC Headphones</p>
                            <p class="text-emerald-700 font-bold">Group Price: ৳৩,১৫০ (Save ৳১,৩৫০)</p>
                        </div>
                        <a href="{{ route('group-buy.show', 'GRP-SOUND99') }}" class="px-3 py-1.5 bg-[#53a318] text-white font-bold rounded-lg text-[11px]">Join</a>
                    </div>
                </div>
                <button @click="wishlistModalOpen = false" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs">Close</button>
            </div>
        </div>

        <!-- Quick Cart Mini Modal -->
        <div x-show="cartModalOpen" x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
            <div @click.outside="cartModalOpen = false" 
                 class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b pb-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl">🛍️</span>
                        <h3 class="text-base font-black text-slate-900">Your Cart & Active Reservations</h3>
                    </div>
                    <button @click="cartModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>
                </div>
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-black text-slate-800">Keyforge K8 Pro Wireless RGB</span>
                        <span class="font-black text-[#53a318]">৳২,৭০০</span>
                    </div>
                    <p class="text-[11px] text-slate-600">Reserved in Active Group. 10-Minute Checkout Lock Active.</p>
                </div>
                <div class="flex items-center justify-between text-xs font-bold pt-2">
                    <span>Estimated Total:</span>
                    <span class="text-base font-black text-[#53a318]">৳২,৭০০</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button @click="cartModalOpen = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs">Keep Shopping</button>
                    <a href="{{ route('orders.index') }}" class="py-2.5 text-center bg-[#53a318] hover:bg-[#468c13] text-white font-bold rounded-xl text-xs">View Orders</a>
                </div>
            </div>
        </div>

    </header>

    <!-- Global Flash Notification Alerts -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 mt-4 w-full">
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

    <!-- Main Content Area (Fluid Edge-to-Edge) -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- ========================================================
         23. COMPLETE FOOTER SECTION (CHECKLIST COMPLIANT)
         ======================================================== -->
    <footer class="mt-20 bg-white border-t border-slate-200 pt-16 pb-12 text-slate-600 text-xs">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <!-- 5-Column Navigation Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 pb-12 border-b border-slate-200">
                
                <!-- Col 1: Company -->
                <div class="space-y-3">
                    <h4 class="font-black text-slate-900 uppercase text-xs tracking-wider">Company</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li><a href="#how-it-works" class="hover:text-[#53a318] transition-colors">About CARTIVA</a></li>
                        <li><a href="#contact-section" class="hover:text-[#53a318] transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Careers & Internships</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Platform Blog & News</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Community Guidelines</a></li>
                    </ul>
                </div>

                <!-- Col 2: Shop -->
                <div class="space-y-3">
                    <h4 class="font-black text-slate-900 uppercase text-xs tracking-wider">Shop</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li><a href="{{ route('home') }}" class="hover:text-[#53a318] transition-colors">All Products</a></li>
                        <li><a href="#today-deals" class="hover:text-[#53a318] transition-colors">Group Deals</a></li>
                        <li><a href="#flash-deals" class="hover:text-[#53a318] transition-colors">Flash Deals</a></li>
                        <li><a href="#quick-categories" class="hover:text-[#53a318] transition-colors">Categories</a></li>
                        <li><a href="#new-arrivals" class="hover:text-[#53a318] transition-colors">New Arrivals</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Service -->
                <div class="space-y-3">
                    <h4 class="font-black text-slate-900 uppercase text-xs tracking-wider">Customer Service</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li><a href="#faq" class="hover:text-[#53a318] transition-colors">Help Center & FAQs</a></li>
                        <li><a href="#trust-security" class="hover:text-[#53a318] transition-colors">Shipping & Logistics Policy</a></li>
                        <li><a href="#cartiva-guarantee" class="hover:text-[#53a318] transition-colors">Return & 100% Refund Policy</a></li>
                        <li><a href="#cartiva-guarantee" class="hover:text-[#53a318] transition-colors">Defect Replacement Policy</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-[#53a318] transition-colors">Track Your Order</a></li>
                    </ul>
                </div>

                <!-- Col 4: Account & Group Buying -->
                <div class="space-y-3">
                    <h4 class="font-black text-slate-900 uppercase text-xs tracking-wider">Account & Groups</h4>
                    <ul class="space-y-2 text-slate-500">
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="hover:text-[#53a318] transition-colors">My Account & Profile</a></li>
                            <li><a href="{{ route('orders.index') }}" class="hover:text-[#53a318] transition-colors">My Orders</a></li>
                            <li><a href="{{ route('orders.index') }}" class="hover:text-[#53a318] transition-colors">My Active Groups</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-[#53a318] transition-colors">Login to Account</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-[#53a318] transition-colors">Register as Customer</a></li>
                        @endauth
                        <li><a href="#start-own-group" class="hover:text-[#53a318] transition-colors">Create a Buying Group</a></li>
                        <li><a href="{{ route('register') }}" class="text-[#53a318] font-bold hover:underline">Become a Merchant</a></li>
                    </ul>
                </div>

                <!-- Col 5: Legal & Social Links -->
                <div class="space-y-3">
                    <h4 class="font-black text-slate-900 uppercase text-xs tracking-wider">Legal & Social</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-[#53a318] transition-colors">Merchant SLA & Agreement</a></li>
                    </ul>
                    <div class="pt-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-2">Connect With Us:</span>
                        <div class="flex items-center space-x-3 text-slate-400">
                            <a href="#" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-[#1877f2] hover:text-white flex items-center justify-center transition-colors" title="Facebook">
                                <span class="font-bold text-xs">f</span>
                            </a>
                            <a href="#" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-[#e4405f] hover:text-white flex items-center justify-center transition-colors" title="Instagram">
                                <span class="font-bold text-xs">in</span>
                            </a>
                            <a href="#" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-[#ff0000] hover:text-white flex items-center justify-center transition-colors" title="YouTube">
                                <span class="font-bold text-xs">yt</span>
                            </a>
                            <a href="#" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-[#0a66c2] hover:text-white flex items-center justify-center transition-colors" title="LinkedIn">
                                <span class="font-bold text-xs">li</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Middle Section: Brand Description & Payment Method Badges -->
            <div class="py-8 border-b border-slate-200 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-6 space-y-3">
                    <div class="flex items-center space-x-2.5">
                        <img src="{{ asset('images/cartiva-logo.png') }}" alt="Cartiva" class="h-7 w-auto object-contain">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-800">BANGLADESH</span>
                    </div>
                    <p class="text-slate-500 text-xs leading-relaxed max-w-xl">
                        Cartiva is Bangladesh's dedicated collective group-buying marketplace. By combining multiple individual orders into bulk volumes, we unlock factory wholesale prices with guaranteed 100% automated refunds on unfilled groups.
                    </p>
                </div>

                <!-- Accepted Digital Payment Methods -->
                <div class="lg:col-span-6 lg:text-right space-y-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">
                        Verified Secure Payment Gateways & Partners:
                    </span>
                    <div class="inline-flex flex-wrap items-center gap-2 lg:justify-end">
                        <span class="px-3 py-1.5 rounded-lg bg-pink-50 border border-pink-200 text-pink-700 font-black text-xs">
                            bKash
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-orange-50 border border-orange-200 text-orange-700 font-black text-xs">
                            Nagad
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-200 text-purple-700 font-black text-xs">
                            Rocket
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 font-black text-xs">
                            Upay
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 font-black text-xs">
                            VISA
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-red-50 border border-red-200 text-red-700 font-black text-xs">
                            MasterCard
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & Academic Attribution -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <div>
                    <p>&copy; {{ date('Y') }} Cartiva Group Commerce Inc. All rights reserved.</p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Academic Project for Course: <strong>CSE 3200 (Web Engineering Project)</strong> • <strong>BAUST, Saidpur Cantonment</strong>
                    </p>
                </div>
                <div class="flex items-center space-x-5 font-semibold text-slate-500">
                    <a href="#" class="hover:text-[#53a318]">Privacy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-[#53a318]">Terms</a>
                    <span>•</span>
                    <a href="#" class="hover:text-[#53a318]">Security</a>
                    <span>•</span>
                    <span class="text-[#53a318] font-black">Currency: BDT (৳)</span>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
