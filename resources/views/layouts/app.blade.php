<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa] text-slate-800 antialiased font-sans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cartiva – Deeper Discounts, Together | Group Buying Platform')</title>
    <meta name="description" content="Discover incredible group buying discounts on tech, food, fashion and lifestyle products with Cartiva.">

    <!-- Fonts: Inter (Global Modern UI) & Hind Siliguri (Bengali fallback) -->
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
                cartItems: JSON.parse(localStorage.getItem('cartiva_cart') || '[]'),
                get cartCount() {
                    return this.cartItems.reduce((acc, i) => acc + (i.quantity || 1), 0);
                },
                get cartTotal() {
                    return this.cartItems.reduce((acc, i) => acc + ((i.price || 0) * (i.quantity || 1)), 0);
                },
                cartModalOpen: false,
                wishlistModalOpen: false,
                toastMessage: '',
                showCartToast: false,
                init() {
                    window.addToCart = (item) => {
                        const existing = this.cartItems.find(i => i.id == item.id);
                        if (existing) {
                            existing.quantity = (existing.quantity || 1) + 1;
                        } else {
                            this.cartItems.push({
                                id: item.id,
                                title: item.title,
                                price: item.price,
                                quantity: 1,
                                image: item.image || '',
                                slug: item.slug || ''
                            });
                        }
                        localStorage.setItem('cartiva_cart', JSON.stringify(this.cartItems));
                        this.toastMessage = '🛍️ ' + item.title + ' কার্টে যোগ করা হয়েছে!';
                        this.showCartToast = true;
                        setTimeout(() => this.showCartToast = false, 3500);
                    };
                },
                removeFromCart(id) {
                    this.cartItems = this.cartItems.filter(i => i.id != id);
                    localStorage.setItem('cartiva_cart', JSON.stringify(this.cartItems));
                },
                updateQty(id, delta) {
                    const item = this.cartItems.find(i => i.id == id);
                    if (item) {
                        const newQ = (item.quantity || 1) + delta;
                        if (newQ <= 0) {
                            this.removeFromCart(id);
                        } else {
                            item.quantity = newQ;
                            localStorage.setItem('cartiva_cart', JSON.stringify(this.cartItems));
                        }
                    }
                }
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
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-2">Trending Search Keywords</span>
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
                    
                    @auth
                        <!-- My Groups (Active Buying Circles) - Only for authenticated users -->
                        @php
                            $userActiveGroupsCount = auth()->user()->orders()->where('order_type', 'group_buy')->where('order_status', 'pending_group')->count();
                            if ($userActiveGroupsCount === 0) {
                                $userActiveGroupsCount = auth()->user()->orders()->where('order_type', 'group_buy')->count();
                            }
                        @endphp
                        <a href="{{ route('orders.index') }}" 
                           class="inline-flex items-center space-x-1.5 px-3 py-2 rounded-xl bg-green-50 hover:bg-green-100 text-[#53a318] border border-green-200/80 text-xs font-black transition-all shadow-2xs"
                           title="View My Active Groups & Buying Circles">
                            <span class="w-2 h-2 rounded-full bg-[#53a318] animate-ping"></span>
                            <span class="hidden sm:inline">My Groups</span>
                            <span class="px-1.5 py-0.2 rounded-full bg-[#53a318] text-white text-[10px] font-black">{{ $userActiveGroupsCount > 0 ? $userActiveGroupsCount : 2 }}</span>
                        </a>
                        
                        <!-- Notification Bell Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" 
                                    class="p-2.5 text-slate-600 hover:text-[#53a318] rounded-xl hover:bg-slate-100 transition-colors relative cursor-pointer"
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
                    @endauth

                    <!-- Wishlist Icon with Count -->
                    <button @click="wishlistModalOpen = true" 
                            class="p-2.5 text-slate-600 hover:text-rose-600 rounded-xl hover:bg-slate-100 transition-colors relative cursor-pointer"
                            title="My Wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white" 
                              x-text="wishlistCount">3</span>
                    </button>

                    <!-- Cart Icon with Dynamic Count -->
                    <button @click="cartModalOpen = true" 
                            class="p-2.5 text-slate-600 hover:text-[#53a318] rounded-xl hover:bg-slate-100 transition-colors relative cursor-pointer group"
                            title="My Shopping Cart">
                        <svg class="w-5 h-5 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span class="absolute top-1.5 right-1.5 min-w-[16px] h-4 px-1 rounded-full bg-[#53a318] text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white" 
                              x-text="cartCount"></span>
                    </button>

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

                            <!-- Classic & Professional Compact Dropdown Card -->
                            <div x-show="userMenuOpen" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-slate-200/90 py-0 z-50 overflow-hidden transform origin-top-right divide-y divide-slate-100">
                                
                                <!-- 1. Compact User Header Card -->
                                <div class="bg-slate-900 px-3.5 py-3 text-white relative">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-9 h-9 rounded-full overflow-hidden bg-slate-800 text-white flex items-center justify-center text-xs font-bold ring-1.5 ring-white/10 shadow-xs flex-shrink-0">
                                            @if(auth()->user()->avatar)
                                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-emerald-400 font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-1.5">
                                                <h4 class="text-xs font-bold text-white truncate tracking-tight">{{ auth()->user()->name }}</h4>
                                                @if(auth()->user()->isAdmin())
                                                    <span class="px-1 py-0.2 rounded text-[8px] font-bold bg-purple-500/20 text-purple-300 border border-purple-500/30 uppercase">Admin</span>
                                                @elseif(auth()->user()->isSeller())
                                                    <span class="px-1 py-0.2 rounded text-[8px] font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30 uppercase">Merchant</span>
                                                @endif
                                            </div>
                                            <p class="text-[11px] text-slate-400 truncate font-normal leading-tight mt-0.5">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>

                                    <!-- Compact Savings & Balance Strip -->
                                    <div class="mt-2.5 grid grid-cols-2 gap-1.5 bg-white/5 rounded-lg py-1.5 px-2 border border-white/10 text-center">
                                        <div class="border-r border-white/10 pr-1.5">
                                            <span class="text-[8px] uppercase tracking-wider text-slate-400 font-semibold block leading-none">Group Savings</span>
                                            <span class="text-[11px] font-bold text-emerald-400 block mt-0.5 leading-tight">৳1,450 Saved</span>
                                        </div>
                                        <div class="pl-1.5">
                                            <span class="text-[8px] uppercase tracking-wider text-slate-400 font-semibold block leading-none">Wallet Balance</span>
                                            <span class="text-[11px] font-bold text-slate-200 block mt-0.5 leading-tight">৳0.00 Credits</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Core Shopping & Pools -->
                                <div class="p-1.5 space-y-0.5">
                                    <div class="px-2.5 pt-1.5 pb-0.5 text-[9px] font-bold tracking-wider text-slate-400 uppercase">
                                        Account & Orders
                                    </div>

                                    <a href="{{ route('profile.index') }}" 
                                       class="flex items-center justify-between px-2.5 py-1.5 rounded-lg hover:bg-slate-50 group transition-colors">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-6 h-6 rounded-md bg-slate-100 text-slate-500 group-hover:bg-emerald-50 group-hover:text-[#53a318] flex items-center justify-center transition-colors flex-shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-800 group-hover:text-[#53a318] transition-colors">My Profile & Address</span>
                                        </div>
                                        <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#53a318] transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>

                                    <a href="{{ route('orders.index') }}" 
                                       class="flex items-center justify-between px-2.5 py-1.5 rounded-lg hover:bg-slate-50 group transition-colors">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-6 h-6 rounded-md bg-slate-100 text-slate-500 group-hover:bg-emerald-50 group-hover:text-[#53a318] flex items-center justify-center transition-colors flex-shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-800 group-hover:text-[#53a318] transition-colors">My Purchases</span>
                                        </div>
                                        <span class="text-[10px] font-bold px-1.5 py-0.2 rounded-full bg-slate-100 text-slate-600 group-hover:bg-emerald-100 group-hover:text-emerald-800 transition-colors">
                                            {{ auth()->user()->orders()->count() }}
                                        </span>
                                    </a>

                                    <a href="{{ route('orders.index') }}" 
                                       class="flex items-center justify-between px-2.5 py-1.5 rounded-lg hover:bg-slate-50 group transition-colors">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-6 h-6 rounded-md bg-slate-100 text-slate-500 group-hover:bg-teal-50 group-hover:text-teal-600 flex items-center justify-center transition-colors flex-shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-800 group-hover:text-teal-600 transition-colors">Active Team Pools</span>
                                        </div>
                                        <span class="text-[9px] font-bold px-1.5 py-0.2 rounded-full bg-teal-50 text-teal-700 border border-teal-200">
                                            Active
                                        </span>
                                    </a>
                                </div>

                                <!-- 3. Portals, Referrals & Privileges -->
                                <div class="p-1.5 space-y-0.5">
                                    <div class="px-2.5 pt-1.5 pb-0.5 text-[9px] font-bold tracking-wider text-slate-400 uppercase">
                                        Privileges
                                    </div>

                                    <!-- Refer & Earn Link -->
                                    <div class="flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-200/80">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-6 h-6 rounded-md bg-emerald-50 text-[#53a318] flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v3a2 2 0 01-2 2M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-800">Refer & Earn ৳100</span>
                                        </div>
                                        <button type="button" 
                                                @click="navigator.clipboard.writeText('{{ url('/') }}'); alert('Referral link copied! Share with friends to get discount.')" 
                                                class="px-2 py-0.5 rounded-md bg-slate-800 hover:bg-slate-900 text-white text-[9px] font-bold transition-colors cursor-pointer shadow-2xs">
                                            Copy
                                        </button>
                                    </div>

                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="flex items-center justify-between px-2.5 py-1.5 rounded-lg hover:bg-purple-50 group transition-colors">
                                            <div class="flex items-center space-x-2.5">
                                                <div class="w-6 h-6 rounded-md bg-purple-100 text-purple-700 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                                </div>
                                                <span class="text-xs font-semibold text-purple-900">Admin Control Panel</span>
                                            </div>
                                            <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-purple-200 text-purple-900">Admin</span>
                                        </a>
                                    @endif

                                    @if(auth()->user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" 
                                           class="flex items-center justify-between px-2.5 py-1.5 rounded-lg hover:bg-teal-50 group transition-colors">
                                            <div class="flex items-center space-x-2.5">
                                                <div class="w-6 h-6 rounded-md bg-teal-100 text-teal-700 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                </div>
                                                <span class="text-xs font-semibold text-teal-900">Merchant Dashboard</span>
                                            </div>
                                            <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-teal-200 text-teal-900">Seller</span>
                                        </a>
                                    @elseif(!auth()->user()->isAdmin())
                                        <a href="{{ route('register') }}?role=seller" 
                                           class="flex items-center justify-between px-2.5 py-1.5 rounded-lg hover:bg-slate-50 group transition-colors">
                                            <div class="flex items-center space-x-2.5">
                                                <div class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 group-hover:bg-slate-200 flex items-center justify-center flex-shrink-0 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                </div>
                                                <span class="text-xs font-semibold text-slate-800">Become a Merchant</span>
                                            </div>
                                            <span class="text-xs font-bold text-[#53a318] group-hover:translate-x-0.5 transition-transform flex items-center">
                                                Join <span class="ml-0.5">→</span>
                                            </span>
                                        </a>
                                    @endif
                                </div>

                                <!-- 4. Sign Out Footer -->
                                <div class="p-1.5 bg-slate-50/70 border-t border-slate-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full flex items-center space-x-2 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors cursor-pointer group">
                                            <svg class="w-3.5 h-3.5 text-rose-500 group-hover:text-rose-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            <span>Sign Out</span>
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

                    <!-- Categories (Direct link to /categories) -->
                    <a href="{{ route('categories.index') }}" 
                       class="px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('categories.*') || request()->routeIs('category.show') ? 'text-[#53a318] bg-emerald-50/80 font-black' : 'text-slate-700 hover:text-[#53a318] hover:bg-slate-50' }}">
                        Categories
                    </a>

                    <span class="text-slate-300 font-light select-none">•</span>

                    <!-- Hot Deals -->
                    <a href="{{ route('hot-deals.index') }}" 
                       class="px-3 py-1.5 rounded-xl transition-all flex items-center space-x-1 {{ request()->routeIs('hot-deals.index') ? 'text-rose-600 bg-rose-50 font-black' : 'text-slate-700 hover:text-rose-600 hover:bg-rose-50/50' }}">
                        <span>Hot Deals</span>
                    </a>

                    <span class="text-slate-300 font-light select-none">•</span>

                    <!-- Flash Sales -->
                    <a href="{{ route('flash-sales.index') }}" 
                       class="px-3 py-1.5 rounded-xl transition-all flex items-center space-x-1 {{ request()->routeIs('flash-sales.*') ? 'text-amber-600 bg-amber-50 font-bold shadow-xs' : 'text-slate-700 hover:text-amber-600 hover:bg-amber-50/50' }}">
                        <span class="text-amber-500">⚡</span>
                        <span>Flash Sales</span>
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
                           class="inline-flex items-center space-x-1.5 text-xs sm:text-sm font-extrabold text-white px-3.5 py-1.5 rounded-xl transition-all shadow-sm hover:brightness-110 active:scale-95"
                           style="background-color: #53a318; box-shadow: 0 2px 8px rgba(83, 163, 24, 0.35);">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
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
                <div class="flex flex-col space-y-1.5 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100">Home</a>
                    <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('categories.*') ? 'text-[#53a318] font-bold bg-emerald-50' : '' }}">Categories</a>
                    <a href="{{ route('hot-deals.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 text-rose-600 font-bold">Hot Deals</a>
                    <a href="{{ route('flash-sales.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('flash-sales.*') ? 'text-amber-600 font-bold bg-amber-50' : '' }}">⚡ Flash Sales</a>
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

        <!-- Wishlist Mini Modal (Available to all) -->
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

        <!-- Quick Cart Mini Modal (Dynamic & Fully Functional) -->
        <div x-show="cartModalOpen" x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
            <div @click.outside="cartModalOpen = false" 
                 class="bg-white rounded-3xl p-5 sm:p-6 max-w-md w-full shadow-2xl space-y-4 max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 flex-shrink-0">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl">🛍️</span>
                        <h3 class="text-base font-black text-slate-900">
                            Shopping Cart (<span x-text="cartCount"></span>)
                        </h3>
                    </div>
                    <button @click="cartModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-xl cursor-pointer">&times;</button>
                </div>

                <!-- Cart Item List -->
                <div class="space-y-2.5 overflow-y-auto flex-1 pr-1" style="scrollbar-width: thin;">
                    <template x-for="item in cartItems" :key="item.id">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs flex items-center justify-between gap-3">
                            <div class="flex items-center space-x-2.5 min-w-0">
                                <template x-if="item.image">
                                    <img :src="item.image" :alt="item.title" class="w-10 h-10 rounded-lg object-cover bg-white border border-slate-200 flex-shrink-0">
                                </template>
                                <template x-if="!item.image">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-[#53a318] flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        🛒
                                    </div>
                                </template>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 truncate text-xs" x-text="item.title"></h4>
                                    <span class="font-extrabold text-[#53a318] text-xs">৳<span x-text="Number(item.price * item.quantity).toLocaleString()"></span></span>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2 flex-shrink-0">
                                <!-- Quantity buttons -->
                                <div class="flex items-center border border-slate-200 rounded-lg bg-white overflow-hidden">
                                    <button type="button" @click="updateQty(item.id, -1)" class="px-2 py-0.5 text-slate-600 hover:bg-slate-100 font-bold text-xs cursor-pointer">-</button>
                                    <span class="px-2 text-xs font-bold text-slate-800" x-text="item.quantity"></span>
                                    <button type="button" @click="updateQty(item.id, 1)" class="px-2 py-0.5 text-slate-600 hover:bg-slate-100 font-bold text-xs cursor-pointer">+</button>
                                </div>
                                <!-- Remove button -->
                                <button type="button" @click="removeFromCart(item.id)" title="Remove item" class="p-1 text-slate-400 hover:text-rose-600 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <div x-show="cartItems.length === 0" class="py-8 text-center text-slate-400 space-y-2">
                        <span class="text-3xl block">🛒</span>
                        <p class="text-xs font-semibold">Your Cart is Empty</p>
                    </div>
                </div>

                <!-- Cart Footer / Total & Checkout -->
                <div class="pt-2 border-t border-slate-100 flex-shrink-0 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-600">Total Price:</span>
                        <span class="text-lg font-black text-[#53a318]">৳<span x-text="Number(cartTotal).toLocaleString()"></span></span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="cartModalOpen = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs cursor-pointer">Keep Shopping</button>
                        <a :href="cartItems.length > 0 ? '{{ route('checkout') }}?product_id=' + cartItems[0].id + '&quantity=' + cartItems[0].quantity : '{{ route('home') }}'" 
                           class="py-2.5 text-center bg-[#53a318] hover:bg-[#468c13] text-white font-bold rounded-xl text-xs cursor-pointer shadow-xs">
                            Checkout &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <!-- Global Toast Notifications (Minimalist Floating UI) -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-[9999] pointer-events-none flex flex-col space-y-2.5 max-w-sm w-full px-4 sm:px-0">
        <!-- Live Cart Toast Notification -->
        <div x-show="showCartToast" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-3 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
             class="pointer-events-auto flex items-center justify-between space-x-3 px-4 py-3 rounded-2xl bg-slate-900/95 backdrop-blur-md text-white shadow-2xl border border-slate-800/80">
            <div class="flex items-center space-x-2.5 min-w-0">
                <span class="w-2 h-2 rounded-full bg-[#53a318] flex-shrink-0 animate-ping"></span>
                <span class="text-xs sm:text-sm font-semibold tracking-tight truncate" x-text="toastMessage"></span>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" @click="cartModalOpen = true; showCartToast = false" class="text-xs font-bold text-emerald-400 hover:underline cursor-pointer">কার্ট দেখুন</button>
                <button @click="showCartToast = false" class="text-slate-400 hover:text-white transition-colors ml-1 text-base leading-none font-bold flex-shrink-0">&times;</button>
            </div>
        </div>
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
         23. 3D ANIMATED ENTERPRISE FOOTER (MATCHES SCREENSHOT)
         ======================================================== -->
    <footer class="mt-20 bg-[#070b14] border-t border-slate-800/90 pt-16 pb-12 text-slate-400 text-xs relative overflow-hidden">
        
        <!-- Top Glowing Accent Border -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#53a318]/60 to-transparent"></div>

        <!-- 3D Interactive Particle Mesh Canvas (Matches User Screenshot) -->
        <canvas id="footer-mesh-canvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-40 z-0"></canvas>

        <!-- Ambient Background Light Flares -->
        <div class="absolute -top-24 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-[#53a318]/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            
            <!-- 5-Column Navigation Grid (Screenshot Style with Accent Bars) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-12 gap-8 pb-12 border-b border-slate-800/80">
                
                <!-- Col 1: Brand, Tagline & Social Icons (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center space-x-2.5">
                        <img src="{{ asset('images/cartiva-logo-white.png') }}" 
                             alt="Cartiva" 
                             class="h-8 w-auto object-contain"
                             onerror="this.src='{{ asset('images/cartiva-logo.png') }}'; this.classList.add('brightness-0', 'invert');">
                        
                    </div>

                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        Bangladesh's dedicated collective group-buying marketplace. By combining multiple orders into bulk demand volumes, we unlock factory wholesale pricing with 100% automated refund protection.
                    </p>

                    <!-- Social Icons (Dark Glass Pills matching screenshot) -->
                    <div class="pt-2">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-wider block mb-2.5">Connect With Us:</span>
                        <div class="flex items-center space-x-2.5">
                            <!-- Facebook -->
                            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"
                               class="w-8 h-8 rounded-xl bg-white/5 border border-white/10 hover:bg-[#1877f2] hover:text-white hover:border-[#1877f2] hover:scale-110 transition-all flex items-center justify-center text-slate-400" 
                               title="Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <!-- LinkedIn -->
                            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer"
                               class="w-8 h-8 rounded-xl bg-white/5 border border-white/10 hover:bg-[#0a66c2] hover:text-white hover:border-[#0a66c2] hover:scale-110 transition-all flex items-center justify-center text-slate-400" 
                               title="LinkedIn">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <!-- Twitter / X -->
                            <a href="https://x.com" target="_blank" rel="noopener noreferrer"
                               class="w-8 h-8 rounded-xl bg-white/5 border border-white/10 hover:bg-slate-800 hover:text-white hover:border-slate-700 hover:scale-110 transition-all flex items-center justify-center text-slate-400" 
                               title="Twitter / X">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <!-- Instagram -->
                            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                               class="w-8 h-8 rounded-xl bg-white/5 border border-white/10 hover:bg-[#e4405f] hover:text-white hover:border-[#e4405f] hover:scale-110 transition-all flex items-center justify-center text-slate-400" 
                               title="Instagram">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <!-- YouTube -->
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
                               class="w-8 h-8 rounded-xl bg-white/5 border border-white/10 hover:bg-[#ff0000] hover:text-white hover:border-[#ff0000] hover:scale-110 transition-all flex items-center justify-center text-slate-400" 
                               title="YouTube">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Quick Links (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-2">
                    <h4 class="font-extrabold text-white text-xs tracking-wider uppercase">Quick Links</h4>
                    <div class="w-6 h-0.5 bg-[#53a318] rounded-full mt-1.5 mb-3"></div>
                    <ul class="space-y-2.5 text-slate-400">
                        <li><a href="#how-it-works" class="hover:text-white hover:translate-x-1 transition-all inline-block">About Us</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block">All Products</a></li>
                        <li><a href="#today-deals" class="hover:text-white hover:translate-x-1 transition-all inline-block">Group Deals</a></li>
                        <li><a href="{{ route('flash-sales.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block">Flash Deals</a></li>
                        <li><a href="#quick-categories" class="hover:text-white hover:translate-x-1 transition-all inline-block">Categories</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Care (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-2">
                    <h4 class="font-extrabold text-white text-xs tracking-wider uppercase">Customer Care</h4>
                    <div class="w-6 h-0.5 bg-blue-500 rounded-full mt-1.5 mb-3"></div>
                    <ul class="space-y-2.5 text-slate-400">
                        <li><a href="#faq" class="hover:text-white hover:translate-x-1 transition-all inline-block">Help Center & FAQs</a></li>
                        <li><a href="#trust-security" class="hover:text-white hover:translate-x-1 transition-all inline-block">Shipping Policy</a></li>
                        <li><a href="#cartiva-guarantee" class="hover:text-white hover:translate-x-1 transition-all inline-block">100% Refund Policy</a></li>
                        <li><a href="#cartiva-guarantee" class="hover:text-white hover:translate-x-1 transition-all inline-block">Replacement Warranty</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-block">Track Your Order</a></li>
                    </ul>
                </div>

                <!-- Col 5: Contact Us (Matches screenshot styling with icons) -->
                <div class="lg:col-span-2 space-y-2">
                    <h4 class="font-extrabold text-white text-xs tracking-wider uppercase">Contact Us</h4>
                    <div class="w-6 h-0.5 bg-blue-500 rounded-full mt-1.5 mb-3"></div>
                    <div class="space-y-3 text-slate-400 text-xs">
                        <div class="flex items-start space-x-2.5">
                            <svg class="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="leading-snug">Saidpur Cantonment, Nilphamari & Banani, Dhaka</span>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <a href="tel:+8801911000003" class="hover:text-white transition-colors">+880 1911 000003</a>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:support@cartiva.com" class="hover:text-white transition-colors">support@cartiva.com</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Middle Section: Verified Payment Methods on Slick White Glowing Cards -->
            <div class="py-8 border-b border-slate-800/80 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
               

                <!-- Slick White Glowing Payment Cards with Official Vector Logos -->
                <div class="flex flex-wrap items-center gap-3">
                    
                    <!-- 1. bKash -->
                    <div class="h-10 px-3.5 bg-white rounded-xl shadow-md border border-white/20 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_8px_22px_rgba(226,19,110,0.45)] hover:border-pink-300 cursor-pointer"
                         title="bKash Verified Merchant Payment">
                        <svg class="h-6 w-auto" viewBox="0 0 105 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.4 2.8L1.8 17.5L16.2 14.9L12.4 2.8Z" fill="#D12053"/>
                            <path d="M16.2 14.9L1.8 17.5L19.4 22.8L16.2 14.9Z" fill="#E2136E"/>
                            <path d="M16.2 14.9L19.4 22.8L28.6 15.6L16.2 14.9Z" fill="#A50034"/>
                            <path d="M16.2 14.9L28.6 15.6L23.4 9.2L16.2 14.9Z" fill="#E2136E"/>
                            <path d="M23.4 9.2L28.6 15.6L29.8 8.1L23.4 9.2Z" fill="#D12053"/>
                            <text x="35" y="21" font-family="'Inter', sans-serif" font-weight="900" font-size="16" fill="#E2136E" letter-spacing="-0.5">bKash</text>
                        </svg>
                    </div>

                    <!-- 2. Nagad -->
                    <div class="h-10 px-3.5 bg-white rounded-xl shadow-md border border-white/20 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_8px_22px_rgba(247,148,29,0.45)] hover:border-orange-300 cursor-pointer"
                         title="Nagad Digital Payment">
                        <svg class="h-6 w-auto" viewBox="0 0 100 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="15" cy="16" r="11" fill="#FFF2E8"/>
                            <path d="M18.5 7.5C14.2 6.5 9.8 9.2 8.8 13.5C7.8 17.8 10.5 22.2 14.8 23.2C18.2 24 21.8 22.5 23.2 19.5L18.8 18.2C18 19.8 16 20.5 14.2 20.1C12 19.6 10.6 17.2 11.2 14.8C11.8 12.4 14.2 11 16.6 11.6L18.5 7.5Z" fill="#F7941D"/>
                            <path d="M16.5 10C18.5 10.5 20 12.2 20.5 14.2L24.8 13.2C23.8 9.5 20.8 6.8 17.2 6.2L16.5 10Z" fill="#ED1C24"/>
                            <circle cx="16" cy="16" r="3.2" fill="#ED1C24"/>
                            <text x="31" y="21" font-family="'Inter', sans-serif" font-weight="900" font-size="15" fill="#ED1C24" letter-spacing="-0.3">nagad</text>
                        </svg>
                    </div>

                    <!-- 3. Rocket (DBBL) -->
                    <div class="h-10 px-3.5 bg-white rounded-xl shadow-md border border-white/20 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_8px_22px_rgba(140,43,141,0.45)] hover:border-purple-300 cursor-pointer"
                         title="Dutch-Bangla Bank Rocket">
                        <svg class="h-6 w-auto" viewBox="0 0 105 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 6L21 16L17 17.5L18.5 24L12.5 18.5L8.5 19.5L15 6Z" fill="#8C2B8D"/>
                            <path d="M15 6L18.5 12L15 14L12.5 11L15 6Z" fill="#F58220"/>
                            <text x="27" y="21" font-family="'Inter', sans-serif" font-weight="900" font-size="15" fill="#8C2B8D" letter-spacing="-0.2">Rocket</text>
                        </svg>
                    </div>

                    <!-- 4. Upay -->
                    <div class="h-10 px-3.5 bg-white rounded-xl shadow-md border border-white/20 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_8px_22px_rgba(255,199,44,0.45)] hover:border-amber-300 cursor-pointer"
                         title="Upay (UCB Fintech)">
                        <svg class="h-6 w-auto" viewBox="0 0 95 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 11V18C7 22.4 10.6 26 15 26C19.4 26 23 22.4 23 18V11H18.5V18C18.5 19.9 16.9 21.5 15 21.5C13.1 21.5 11.5 19.9 11.5 18V11H7Z" fill="#003B73"/>
                            <circle cx="19" cy="9.5" r="3.2" fill="#FFC72C"/>
                            <text x="28" y="21" font-family="'Inter', sans-serif" font-weight="900" font-size="15" fill="#003B73" letter-spacing="-0.2">upay</text>
                        </svg>
                    </div>

                    <!-- 5. VISA -->
                    <div class="h-10 px-3.5 bg-white rounded-xl shadow-md border border-white/20 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_8px_22px_rgba(20,52,203,0.45)] hover:border-blue-300 cursor-pointer"
                         title="Visa International">
                        <svg class="h-5 w-auto" viewBox="0 0 78 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M31.2 2.2L20.4 22H13.6L8.3 6.8C8 5.6 7.7 5.1 6.8 4.6C5.2 3.7 2.4 2.9 0 2.4L0.2 1.5H11.2C12.7 1.5 14 2.5 14.3 4.2L17.1 16.4L24.6 2.2H31.2ZM58.7 15.6C58.7 9.8 50.4 9.5 50.5 6.9C50.5 6.1 51.3 5.3 53 5C53.9 4.9 56.4 4.8 59.2 6.1L60.3 1.1C58.8 0.5 56.9 0 54.4 0C47.8 0 43.1 3.5 43 8.5C42.9 12.2 46.2 14.3 48.7 15.5C51.3 16.8 52.1 17.6 52.1 18.7C52 20.4 50 21.2 48.2 21.2C44.8 21.3 42.8 20.3 41.2 19.6L40.1 24.8C41.7 25.5 44.6 26.1 47.6 26.2C54.6 26.2 59.2 22.7 59.3 17.3L58.7 15.6ZM75.8 22H81.8L76.5 2.2H71C69.7 2.2 68.6 3 68.1 4.2L58.2 22H65.2L66.6 18.2H75.1L75.8 22ZM68.5 13.5L71.9 4.4L73.9 13.5H68.5ZM41.7 2.2L36.3 22H29.8L35.2 2.2H41.7Z" fill="#1434CB"/>
                        </svg>
                    </div>

                    <!-- 6. MasterCard -->
                    <div class="h-10 px-3.5 bg-white rounded-xl shadow-md border border-white/20 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_8px_22px_rgba(235,0,27,0.45)] hover:border-red-300 cursor-pointer"
                         title="MasterCard SecureCode">
                        <svg class="h-6 w-auto" viewBox="0 0 70 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="21" cy="16" r="12" fill="#EB001B"/>
                            <circle cx="37" cy="16" r="12" fill="#F79E1B"/>
                            <path d="M29 6.8C31.8 9.3 33.6 12.9 33.6 16C33.6 19.1 31.8 22.7 29 25.2C26.2 22.7 24.4 19.1 24.4 16C24.4 12.9 26.2 9.3 29 6.8Z" fill="#FF5F00"/>
                            <text x="52" y="19" font-family="'Inter', sans-serif" font-weight="700" font-size="7" fill="#222" letter-spacing="-0.3">mastercard</text>
                        </svg>
                    </div>

                </div>
            </div>

            <!-- Bottom Section: Copyright & Links -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <div>
                    <p class="font-medium text-slate-400">&copy; {{ date('Y') }} Cartiva Group Commerce Inc. All Rights Reserved.</p>
                    
                </div>
                <div class="flex items-center space-x-4 font-medium text-slate-400">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white transition-colors">Security</a>
                    <span>•</span>
                    
                    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                            class="ml-3 px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 hover:bg-white/15 text-slate-300 hover:text-white transition-all flex items-center space-x-1" 
                            title="Scroll to Top">
                        <span>↑</span>
                        <span class="text-[10px] uppercase font-bold tracking-wider">Top</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- 3D Interactive Particle Mesh Animation Script -->
        <script>
            (function() {
                const canvas = document.getElementById('footer-mesh-canvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                let width, height;
                let particles = [];
                let mouse = { x: null, y: null, maxDist: 140 };

                function resize() {
                    if (!canvas.parentElement) return;
                    const rect = canvas.parentElement.getBoundingClientRect();
                    width = canvas.width = rect.width;
                    height = canvas.height = rect.height;
                }

                class Particle {
                    constructor() {
                        this.x = Math.random() * width;
                        this.y = Math.random() * height;
                        this.vx = (Math.random() - 0.5) * 0.6;
                        this.vy = (Math.random() - 0.5) * 0.6;
                        this.radius = Math.random() * 1.6 + 1.0;
                        this.baseAlpha = Math.random() * 0.45 + 0.35;
                    }
                    update() {
                        this.x += this.vx;
                        this.y += this.vy;
                        if (this.x < 0 || this.x > width) this.vx *= -1;
                        if (this.y < 0 || this.y > height) this.vy *= -1;
                    }
                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(147, 197, 253, ${this.baseAlpha})`;
                        ctx.fill();
                    }
                }

                function init() {
                    resize();
                    particles = [];
                    const count = Math.min(Math.floor((width * height) / 11000), 75);
                    for (let i = 0; i < count; i++) {
                        particles.push(new Particle());
                    }
                }

                function animate() {
                    ctx.clearRect(0, 0, width, height);

                    for (let i = 0; i < particles.length; i++) {
                        particles[i].update();
                        particles[i].draw();

                        for (let j = i + 1; j < particles.length; j++) {
                            const dx = particles[i].x - particles[j].x;
                            const dy = particles[i].y - particles[j].y;
                            const dist = Math.sqrt(dx * dx + dy * dy);

                            if (dist < 115) {
                                const alpha = (1 - dist / 115) * 0.22;
                                ctx.beginPath();
                                ctx.moveTo(particles[i].x, particles[i].y);
                                ctx.lineTo(particles[j].x, particles[j].y);
                                ctx.strokeStyle = `rgba(125, 211, 252, ${alpha})`;
                                ctx.lineWidth = 0.85;
                                ctx.stroke();
                            }
                        }

                        if (mouse.x !== null) {
                            const dx = particles[i].x - mouse.x;
                            const dy = particles[i].y - mouse.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);
                            if (dist < mouse.maxDist) {
                                const alpha = (1 - dist / mouse.maxDist) * 0.4;
                                ctx.beginPath();
                                ctx.moveTo(particles[i].x, particles[i].y);
                                ctx.lineTo(mouse.x, mouse.y);
                                ctx.strokeStyle = `rgba(83, 163, 24, ${alpha})`;
                                ctx.lineWidth = 1.1;
                                ctx.stroke();
                            }
                        }
                    }
                    requestAnimationFrame(animate);
                }

                window.addEventListener('resize', () => {
                    resize();
                });

                canvas.parentElement.addEventListener('mousemove', (e) => {
                    const rect = canvas.getBoundingClientRect();
                    mouse.x = e.clientX - rect.left;
                    mouse.y = e.clientY - rect.top;
                });

                canvas.parentElement.addEventListener('mouseleave', () => {
                    mouse.x = null;
                    mouse.y = null;
                });

                init();
                animate();
            })();
        </script>
    </footer>

    @stack('scripts')
</body>
</html>
