<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa] text-slate-800 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cartiva – Deeper Discounts, Together | Group Buying Platform')</title>
    <meta name="description" content="Discover incredible group buying discounts on tech, food, fashion and lifestyle products with Cartiva.">

    <!-- Fonts (Inter for World-Class UI & Hind Siliguri for Crisp Bengali) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900|hind-siliguri:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full flex flex-col font-sans bg-[#f8f9fa] text-slate-800 selection:bg-[#53a318] selection:text-white" 
      x-data="{ mobileMenuOpen: false, notifOpen: false, userDropdownOpen: false }">

    <!-- 1. Top Live Community Activity Marquee Ticker -->
    <div class="bg-[#111827] text-white text-xs font-semibold py-1 px-4 overflow-hidden border-b border-slate-800 shadow-inner">
        <div class="max-w-[1600px] mx-auto flex items-center justify-between gap-4">
            
            <!-- Live Activity Marquee Ticker -->
            <div class="flex-1 overflow-hidden relative flex items-center">
                <span class="inline-flex items-center px-2 py-0.5 rounded font-black bg-[#53a318] text-white text-[10px] uppercase tracking-wider mr-3 flex-shrink-0 z-10 shadow-sm animate-pulse">
                    LIVE
                </span>

                <div class="overflow-hidden w-full whitespace-nowrap">
                    <div class="animate-marquee flex items-center space-x-10 text-[11px] sm:text-xs text-slate-300">
                        <span class="flex items-center space-x-1.5 font-bold text-amber-300">
                            <span>Today's Total Savings:</span>
                            <span class="text-white font-black bg-amber-500/30 px-1.5 py-0.2 rounded">৳64,200+</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-emerald-400">38 Group Deals Successfully Unlocked!</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center space-x-1.5">
                            <span class="text-amber-400 font-bold">Arif S. (Saidpur)</span>
                            <span>just joined Premium Winter Hoodie team •</span>
                            <span class="text-[#84cc16] font-extrabold">৳250 saved!</span>
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
            <div class="flex items-center justify-between h-16 sm:h-[68px] gap-3 sm:gap-6 lg:gap-8">
                
                <!-- Brand Logo & Tagline -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group">
                        <img src="{{ asset('images/cartiva-logo.png') }}" 
                             alt="Cartiva" 
                             class="h-7 sm:h-8 w-auto max-w-[140px] sm:max-w-[170px] object-contain transition-transform group-hover:scale-105">
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
                                <option value="winter-specials" {{ request('category') == 'winter-specials' ? 'selected' : '' }}>🧥 Winter Specials</option>
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
                                   placeholder="Search products or Group Code (e.g. GRP-HOODIE05)..." 
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
                                <button type="button" @click="searchQuery = 'Fleece Hoodie'; $el.closest('form')?.submit()" 
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-green-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                                    🧥 Winter Fleece Hoodie
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
                                <a href="{{ route('group-buy.show', 'GRP-HOODIE05') }}" class="p-2 rounded-xl bg-amber-50 border border-amber-200/60 hover:bg-amber-100 transition-all flex items-center justify-between">
                                    <div>
                                        <span class="font-mono font-black text-amber-900 block">GRP-HOODIE05</span>
                                        <span class="text-[10px] text-amber-700">Fleece Hoodie (4/5 joined)</span>
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
                                <a href="{{ route('group-buy.show', 'GRP-HOODIE05') }}" class="p-3.5 flex items-start space-x-3 hover:bg-slate-50 transition-colors block">
                                    <span class="text-lg flex-shrink-0">⚡</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">Winter Hoodie Deal: Only 1 buyer left!</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Tier 3 (৳750) unlocks once 1 more buyer joins.</p>
                                        <span class="text-[10px] text-[#53a318] font-mono font-bold mt-1 block">GRP-HOODIE05 • 5 hours left</span>
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
                    <!-- User Account Dropdown / Sign In -->
                    @auth
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <!-- Trigger Button -->
                            <button @click="userMenuOpen = !userMenuOpen" @click.outside="userMenuOpen = false" 
                                    class="flex items-center space-x-2 py-1.5 px-2.5 sm:px-3 rounded-2xl border border-slate-200/90 hover:border-emerald-300 text-xs font-bold text-slate-800 bg-white hover:bg-slate-50/80 transition-all shadow-2xs group cursor-pointer"
                                    title="Account & Profile">
                                <div class="relative">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl overflow-hidden bg-gradient-to-tr from-[#53a318] to-emerald-400 text-white flex items-center justify-center text-xs font-black shadow-xs ring-2 ring-emerald-500/20 group-hover:scale-105 transition-transform flex-shrink-0">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="absolute -bottom-0.5 -right-0.5 w-2 h-2 bg-emerald-500 rounded-full ring-2 ring-white"></span>
                                </div>
                                <div class="hidden md:flex flex-col text-left leading-tight">
                                    <span class="font-extrabold text-slate-900 group-hover:text-[#53a318] transition-colors truncate max-w-[110px]">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-semibold capitalize">
                                        {{ auth()->user()->role === 'admin' ? 'Admin' : (auth()->user()->role === 'seller' ? 'Merchant' : 'Customer') }}
                                    </span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-transform duration-200" 
                                     :class="userMenuOpen ? 'rotate-180 text-[#53a318]' : ''" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Modern Dropdown Card -->
                            <div x-show="userMenuOpen" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute right-0 mt-2.5 w-80 bg-white rounded-3xl shadow-2xl border border-slate-100 py-0 z-50 overflow-hidden transform origin-top-right divide-y divide-slate-100/90">
                                
                                <!-- 1. User Header & Status Card -->
                                <div class="bg-slate-900 p-4 text-white relative overflow-hidden">
                                    <div class="relative z-10">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-11 h-11 rounded-2xl overflow-hidden bg-slate-800 text-white flex items-center justify-center text-sm font-black ring-1 ring-white/10 shadow-md flex-shrink-0">
                                                @if(auth()->user()->avatar)
                                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-black text-white truncate tracking-tight">{{ auth()->user()->name }}</h4>
                                                <p class="text-[11px] text-slate-400 truncate font-medium">{{ auth()->user()->email }}</p>
                                                <div class="mt-1 flex items-center gap-1.5">
                                                    @if(auth()->user()->isAdmin())
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-purple-500/20 text-purple-300 border border-purple-500/30 uppercase tracking-wider">
                                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                            Administrator
                                                        </span>
                                                    @elseif(auth()->user()->isSeller())
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30 uppercase tracking-wider">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                            Merchant Partner
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 uppercase tracking-wider">
                                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                            Verified Customer
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Savings Counter -->
                                        <div class="mt-3.5 grid grid-cols-2 gap-2 bg-white/5 rounded-2xl p-2.5 border border-white/10 text-center">
                                            <div class="border-r border-white/10 pr-2">
                                                <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold block">Group Savings</span>
                                                <span class="text-xs font-black text-emerald-400 block mt-0.5">৳1,450 Saved</span>
                                            </div>
                                            <div class="pl-2">
                                                <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold block">Wallet Balance</span>
                                                <span class="text-xs font-black text-slate-300 block mt-0.5">৳0.00 Credits</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Core Shopping & Pools -->
                                <div class="p-2 space-y-0.5">
                                    <div class="px-3 py-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                                        Account & Orders
                                    </div>

                                    <a href="{{ route('profile.index') }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded-2xl hover:bg-slate-50 group transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-emerald-50 group-hover:text-[#53a318] flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800 group-hover:text-[#53a318] transition-colors">My Profile & Address</p>
                                                <p class="text-[10px] text-slate-400">Settings, map address & security</p>
                                            </div>
                                        </div>
                                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#53a318] transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>

                                    <a href="{{ route('orders.index') }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded-2xl hover:bg-slate-50 group transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-emerald-50 group-hover:text-[#53a318] flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800 group-hover:text-[#53a318] transition-colors">My Purchases</p>
                                                <p class="text-[10px] text-slate-400">Order tracking & history</p>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 group-hover:bg-emerald-100 group-hover:text-emerald-800 transition-colors">
                                            {{ auth()->user()->orders()->count() }}
                                        </span>
                                    </a>

                                    <a href="{{ route('orders.index') }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded-2xl hover:bg-slate-50 group transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-teal-50 group-hover:text-teal-600 flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Active Team Pools</p>
                                                <p class="text-[10px] text-slate-400">Ongoing team countdowns</p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center space-x-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 border border-teal-200">
                                            <span>Active</span>
                                        </span>
                                    </a>
                                </div>

                                <!-- 3. Portals, Referrals & Privileges -->
                                <div class="p-2 space-y-0.5">
                                    <div class="px-3 py-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                                        Privileges
                                    </div>

                                    <!-- Refer & Earn Link -->
                                    <div class="mx-1 my-1 p-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#53a318] flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v3a2 2 0 01-2 2M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Refer & Earn ৳100</p>
                                                <p class="text-[10px] text-slate-500">Invite friends to your pool</p>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                @click="navigator.clipboard.writeText('{{ url('/') }}'); alert('Referral link copied! Share with friends to get discount.')" 
                                                class="px-2.5 py-1 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold transition-colors cursor-pointer">
                                            Copy
                                        </button>
                                    </div>

                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="flex items-center justify-between px-3 py-2 rounded-2xl hover:bg-purple-50 group transition-colors">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-purple-900">Admin Control Panel</p>
                                                    <p class="text-[10px] text-purple-600">Users, pools, products & analytics</p>
                                                </div>
                                            </div>
                                            <span class="text-[10px] font-black px-1.5 py-0.5 rounded bg-purple-200 text-purple-900">Admin</span>
                                        </a>
                                    @endif

                                    @if(auth()->user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" 
                                           class="flex items-center justify-between px-3 py-2 rounded-2xl hover:bg-teal-50 group transition-colors">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-teal-900">Merchant Dashboard</p>
                                                    <p class="text-[10px] text-teal-600">Manage catalog, group pricing & orders</p>
                                                </div>
                                            </div>
                                            <span class="text-[10px] font-black px-1.5 py-0.5 rounded bg-teal-200 text-teal-900">Seller</span>
                                        </a>
                                    @elseif(!auth()->user()->isAdmin())
                                        <a href="{{ route('register') }}?role=seller" 
                                           class="flex items-center justify-between px-3 py-2 rounded-2xl hover:bg-slate-50 group transition-colors">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-slate-200 flex items-center justify-center transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-800">Become a Merchant</p>
                                                    <p class="text-[10px] text-slate-400">Sell at scale with group buying</p>
                                                </div>
                                            </div>
                                            <span class="text-[10px] font-black text-[#53a318] group-hover:underline">Join &rarr;</span>
                                        </a>
                                    @endif
                                </div>

                                <!-- 4. Support & Sign Out Footer -->
                                <div class="p-2 bg-slate-50/70">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full flex items-center justify-between px-3 py-2 rounded-2xl text-xs font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors cursor-pointer group">
                                            <div class="flex items-center space-x-2.5">
                                                <svg class="w-4 h-4 text-rose-400 group-hover:text-rose-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                <span>Sign Out from Cartiva</span>
                                            </div>
                                            <span class="text-[10px] text-slate-400 font-normal">Secure logout</span>
                                        </button>
                                    </form>
                                </div>

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

            <!-- 3. Category & Core Navigation Bar -->
            @if(!request()->routeIs('login', 'register'))
            <div class="hidden md:flex items-center justify-center relative border-t border-slate-200/80 py-2.5 text-sm font-semibold text-slate-700 min-h-[46px]">
                
                <!-- Center: Clean Primary Navigation Links -->
                <nav class="flex items-center justify-center space-x-1 lg:space-x-2 text-xs sm:text-sm font-semibold">
                    <!-- Home -->
                    <a href="{{ route('home') }}" 
                       class="px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('home') && !request()->has('filter') && !request()->has('category') ? 'text-[#53a318] bg-emerald-50/80 font-black' : 'text-slate-700 hover:text-[#53a318] hover:bg-slate-50' }}">
                        Home
                    </a>

                    <span class="text-slate-300 font-light select-none">•</span>

                    <!-- Hot Deals -->
                    <a href="{{ route('hot-deals.index') }}" 
                       class="px-3 py-1.5 rounded-xl transition-all flex items-center space-x-1 {{ request()->routeIs('hot-deals.index') ? 'text-rose-600 bg-rose-50 font-black' : 'text-slate-700 hover:text-rose-600 hover:bg-rose-50/50' }}">
                        <span>Hot Deals</span>
                    </a>

                    <span class="text-slate-300 font-light select-none">•</span>

                    <!-- Flash Sales -->
                    <a href="{{ route('home') }}#flash-deals" 
                       class="px-3 py-1.5 rounded-xl transition-all flex items-center space-x-1 text-slate-700 hover:text-amber-600 hover:bg-amber-50/50">
                        <span>Flash Sales</span>
                    </a>

                    <span class="text-slate-300 font-light select-none">•</span>

                    <!-- Group Pools -->
                    <a href="{{ route('home') }}#active-deals" 
                       class="px-3 py-1.5 rounded-xl transition-all flex items-center space-x-1 text-slate-700 hover:text-[#53a318] hover:bg-emerald-50/50">
                        <span>Group Pools</span>
                    </a>

                    <span class="text-slate-300 font-light select-none">•</span>

                    <!-- How It Works -->
                    <a href="{{ route('home') }}#how-it-works" 
                       class="px-3 py-1.5 rounded-xl transition-all text-slate-700 hover:text-[#53a318] hover:bg-slate-50">
                        How It Works
                    </a>

                    <span class="text-slate-300 font-light select-none">•</span>

                    <!-- Track Order -->
                    <a href="{{ route('orders.index') }}" 
                       class="px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('orders.*') ? 'text-[#53a318] bg-emerald-50/80 font-black' : 'text-slate-700 hover:text-[#53a318] hover:bg-slate-50' }}">
                        Track Order
                    </a>
                </nav>

                <!-- Right: Become a Seller & Trust Assurance -->
                <div class="absolute right-0 flex items-center space-x-3 shrink-0">
                    <div class="h-4 w-px bg-slate-200"></div>

                    @if(auth()->check() && auth()->user()->isSeller())
                        <a href="{{ route('seller.dashboard') }}" 
                           class="inline-flex items-center space-x-1.5 text-xs sm:text-sm font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200/80 px-3.5 py-1.5 rounded-xl transition-all shadow-2xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span>Seller Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('home') }}#seller-acquisition" 
                           class="inline-flex items-center space-x-1.5 text-xs sm:text-sm font-bold text-slate-700 hover:text-[#53a318] hover:border-[#53a318] bg-slate-50 hover:bg-white border border-slate-200 px-3.5 py-1.5 rounded-xl transition-all shadow-2xs group">
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#53a318] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>Become a seller</span>
                        </a>
                    @endif
                </div>

            </div>
            @endif

            <!-- Mobile Drawer Menu -->
            <div x-show="mobileMenuOpen" x-cloak class="lg:hidden pb-4 pt-2 border-t border-slate-100">
                <form action="{{ route('home') }}" method="GET" class="mb-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search deals or group code (e.g. GRP-HOODIE05)..." class="w-full px-4 py-2.5 text-xs bg-slate-100 border border-slate-200 rounded-lg">
                </form>
                <div class="flex flex-col space-y-2 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100">Home</a>
                    <a href="{{ route('hot-deals.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 text-rose-600 font-bold">Hot Deals</a>
                    <a href="{{ route('home') }}#flash-deals" class="px-3 py-2 rounded-lg hover:bg-slate-100">Flash Sales</a>
                    <a href="{{ route('home') }}#active-deals" class="px-3 py-2 rounded-lg hover:bg-slate-100">Group Pools</a>
                    <a href="{{ route('home') }}#how-it-works" class="px-3 py-2 rounded-lg hover:bg-slate-100">How It Works</a>
                    <a href="{{ route('orders.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('orders.*') ? 'text-[#53a318] font-bold' : '' }}">
                        Track Order
                    </a>
                    @if(auth()->check() && auth()->user()->isSeller())
                        <a href="{{ route('seller.dashboard') }}" class="px-3 py-2 rounded-lg bg-teal-50 text-teal-700 font-bold">Seller Dashboard</a>
                    @else
                        <a href="{{ route('home') }}#seller-acquisition" class="px-3 py-2 rounded-lg hover:bg-slate-100">Become a seller</a>
                    @endif
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
                            <p class="font-bold text-slate-800">Premium Fleece Winter Hoodie</p>
                            <p class="text-emerald-700 font-bold">Group Price: ৳750 (Save ৳250)</p>
                        </div>
                        <a href="{{ route('group-buy.show', 'GRP-HOODIE05') }}" class="px-3 py-1.5 bg-[#53a318] text-white font-bold rounded-lg text-[11px]">Join</a>
                    </div>
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-800">SoundCore ANC Headphones</p>
                            <p class="text-emerald-700 font-bold">Group Price: ৳3,150 (Save ৳1,350)</p>
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
                        <span class="font-black text-[#53a318]">৳2,700</span>
                    </div>
                    <p class="text-[11px] text-slate-600">Reserved in Active Group. 10-Minute Checkout Lock Active.</p>
                </div>
                <div class="flex items-center justify-between text-xs font-bold pt-2">
                    <span>Estimated Total:</span>
                    <span class="text-base font-black text-[#53a318]">৳2,700</span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button @click="cartModalOpen = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs">Keep Shopping</button>
                    <a href="{{ route('orders.index') }}" class="py-2.5 text-center bg-[#53a318] hover:bg-[#468c13] text-white font-bold rounded-xl text-xs">View Orders</a>
                </div>
            </div>
        </div>

    </header>

    <!-- Global Toast Notifications (Minimalist Floating UI) -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-[9999] pointer-events-none flex flex-col space-y-2.5 max-w-sm w-full px-4 sm:px-0">
        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-cloak
                 x-init="setTimeout(() => show = false, 3500)"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="pointer-events-auto flex items-center justify-between space-x-3 px-4 py-3 rounded-2xl bg-slate-900/95 backdrop-blur-md text-white shadow-2xl border border-slate-800/80">
                <div class="flex items-center space-x-2.5 min-w-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0 animate-pulse"></span>
                    <span class="text-xs sm:text-sm font-medium tracking-tight truncate">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-white transition-colors ml-2 text-base leading-none font-bold flex-shrink-0">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-cloak
                 x-init="setTimeout(() => show = false, 4000)"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="pointer-events-auto flex items-center justify-between space-x-3 px-4 py-3 rounded-2xl bg-rose-950/95 backdrop-blur-md text-rose-50 shadow-2xl border border-rose-900/80">
                <div class="flex items-center space-x-2.5 min-w-0">
                    <span class="w-2 h-2 rounded-full bg-rose-400 flex-shrink-0"></span>
                    <span class="text-xs sm:text-sm font-medium tracking-tight truncate">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-300 hover:text-white transition-colors ml-2 text-base leading-none font-bold flex-shrink-0">&times;</button>
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
                        <li><a href="#how-it-works" class="hover:text-[#53a318] transition-colors">About</a></li>
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

            <!-- Bottom Copyright & Branding -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <div>
                    <p>&copy; {{ date('Y') }} Cartiva Group Commerce Inc. All rights reserved.</p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Cartiva Social Commerce Platform • Verified Group Deals & Safe Escrow Protection
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

    @stack('scripts')
</body>
</html>
