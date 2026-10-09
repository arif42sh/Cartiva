<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cartiva – Shop Together, Save More | Group Buying Platform')</title>
    <meta name="description" content="একসাথে কেনাকাটা করুন, ভলিউম ডিসকাউন্ট আনলক করুন! Cartiva - বাংলাদেশের প্রথম আধুনিক সোশ্যাল টিম বায়িং প্ল্যাটফর্ম।">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans selection:bg-emerald-500 selection:text-white" x-data="{ mobileMenuOpen: false, notifOpen: false, categoryDropdownOpen: false }">

    <!-- 1. Top Announcement Bar -->
    <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-slate-900 text-white text-xs font-semibold py-2 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-950 uppercase tracking-wider animate-pulse">LIVE DEALS</span>
                <span class="hidden sm:inline">🔥 "একা কিনলে পুরো দাম, একসাথে কিনলে বিরাট ছাড়!"</span>
                <span class="sm:hidden">🔥 টিম আপ করুন আর বাঁচান ৫০% পর্যন্ত!</span>
            </div>
            <div class="flex items-center space-x-4 sm:space-x-6 text-emerald-100 text-[11px]">
                <span class="flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>১০০% নিরাপদ রিফান্ড গ্যারান্টি</span>
                </span>
                <span class="hidden md:inline">|</span>
                <span class="hidden md:flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>রিয়েল-টাইম টিয়ার আনলক</span>
                </span>
            </div>
        </div>
    </div>

    <!-- 1. Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/90 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo & Slogan -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-600 to-emerald-800 flex items-center justify-center text-white shadow-md shadow-emerald-600/30 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight bg-gradient-to-r from-slate-900 via-emerald-800 to-teal-700 bg-clip-text text-transparent">Cartiva</span>
                            <span class="block text-[10px] font-extrabold tracking-wider text-emerald-600 uppercase">Shop Together, Save More</span>
                        </div>
                    </a>

                    <!-- Category Quick Navigation Dropdown -->
                    <div class="relative hidden xl:block" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" 
                                class="flex items-center space-x-2 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            <span>Categories</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-cloak class="absolute left-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 py-3 z-50">
                            <span class="block px-4 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Top Collections</span>
                            <a href="{{ route('home') }}?category=tech-accessories" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                                <span>🎧</span> <span>টেক ও এক্সেসরিজ</span>
                            </a>
                            <a href="{{ route('home') }}?category=dry-food-fmcg" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                                <span>🥫</span> <span>ড্রাই ফুড ও এফএমসিজি</span>
                            </a>
                            <a href="{{ route('home') }}?category=home-lifestyle" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                                <span>☕</span> <span>হোম ও লাইফস্টাইল</span>
                            </a>
                            <a href="{{ route('home') }}?category=campus-merchandise" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                                <span>🎓</span> <span>ক্যাম্পাস স্পেশাল মার্চেন্ডাইজ</span>
                            </a>
                            <a href="{{ route('home') }}?category=fashion-wearables" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                                <span>⌚</span> <span>ফ্যাশন ও ওয়্যারেবলস</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Live Search Bar (Supports Product name, Category or Group ID like GRP-...) -->
                <div class="hidden lg:flex flex-1 max-w-md mx-6">
                    <form action="{{ route('home') }}" method="GET" class="w-full relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="সার্চ করুন প্রোডাক্ট, ক্যাটাগরি বা গ্রুপ কোড (যেমন: GRP-BAUST05)..." 
                               class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-100/90 border border-slate-200 rounded-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 placeholder-slate-400">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </div>

                <!-- Action Buttons & User Menu -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    
                    <!-- "Start a Group" Shortcut Button -->
                    <a href="{{ route('home') }}#featured-campaigns" 
                       class="hidden sm:inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl text-xs font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white shadow-sm shadow-emerald-600/20 transition-all hover:scale-[1.02]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        <span>Start a Group</span>
                    </a>

                    <!-- "Sell on Cartiva" Button -->
                    @if(!auth()->check() || (auth()->check() && !auth()->user()->isSeller() && !auth()->user()->isAdmin()))
                        <a href="{{ route('register') }}" class="hidden md:inline-flex items-center px-3 py-2 rounded-xl text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition-colors">
                            <span>Sell on Cartiva</span>
                        </a>
                    @endif

                    <!-- Notification Bell with Dropdown Modal -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" @click.outside="notifOpen = false" 
                                class="p-2.5 rounded-full text-slate-600 hover:bg-slate-100 hover:text-emerald-600 relative transition-colors focus:outline-none"
                                title="নোটিফিকেশন ও গ্রুপ সতর্কবার্তা">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                        </button>

                        <div x-show="notifOpen" x-cloak class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-100 py-3 z-50">
                            <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-black text-slate-900 uppercase">Live Group Alerts</span>
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">2 Unread</span>
                            </div>

                            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                                <a href="{{ route('group-buy.show', 'GRP-BAUST05') }}" class="p-3.5 flex items-start space-x-3 hover:bg-slate-50 transition-colors block">
                                    <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 text-xs font-bold">⚡</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">BAUST হুডি গ্রুপে আর মাত্র ১ জন বাকি!</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">১ জন যোগ দিলেই সর্বোচ্চ টিয়ার ডিসকাউন্ট (৳৭৫০) আনলক হবে।</p>
                                        <span class="text-[10px] text-amber-600 font-mono font-bold mt-1 block">GRP-BAUST05 • ৫ ঘণ্টা বাকি</span>
                                    </div>
                                </a>

                                <a href="{{ route('group-buy.show', 'GRP-SOUND99') }}" class="p-3.5 flex items-start space-x-3 hover:bg-slate-50 transition-colors block">
                                    <span class="w-8 h-8 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center flex-shrink-0 text-xs font-bold">⏱</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">SoundCore হেডফোন গ্রুপ এক্সপায়ার হতে চলেছে</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">আর মাত্র ৩ ঘণ্টা ১২ মিনিট বাকি। এখনই যোগ দিয়ে ৩০% ছাড় নিশ্চিত করুন।</p>
                                        <span class="text-[10px] text-rose-600 font-mono font-bold mt-1 block">GRP-SOUND99 • ১টি স্লট বাকি</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile / Multi-Auth Section -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center space-x-2 p-1.5 rounded-full hover:bg-slate-100 transition-colors focus:outline-none">
                                <div class="w-9 h-9 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:block text-xs font-bold text-slate-800">{{ auth()->user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-[11px] font-medium text-slate-400">Signed in as</p>
                                    <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-black rounded-full bg-emerald-100 text-emerald-800 uppercase">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>

                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    My Orders
                                </a>

                                <a href="{{ route('home') }}#live-groups" class="flex items-center px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    My Active Groups
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
                                        Seller Hub
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">
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
                            <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm shadow-emerald-600/30 transition-all">
                                Sign Up
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Trigger -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-slate-600 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Drawer Menu -->
            <div x-show="mobileMenuOpen" x-cloak class="lg:hidden pb-4 pt-2 border-t border-slate-200">
                <form action="{{ route('home') }}" method="GET" class="mb-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="সার্চ প্রোডাক্ট বা গ্রুপ কোড..." class="w-full px-4 py-2 text-xs bg-slate-100 border border-slate-200 rounded-lg">
                </form>
                <div class="flex flex-col space-y-2 text-xs font-bold text-slate-700">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100">Explore Deals</a>
                    <a href="{{ route('home') }}#live-groups" class="px-3 py-2 rounded-lg hover:bg-slate-100">Hot Ticking Groups</a>
                    <a href="{{ route('home') }}#how-it-works" class="px-3 py-2 rounded-lg hover:bg-slate-100">How Cartiva Works</a>
                    <a href="{{ route('register') }}" class="px-3 py-2 rounded-lg hover:bg-teal-50 text-teal-700">Sell on Cartiva</a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100">My Orders</a>
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

    <!-- 8. Footer (তথ্য ও পলিসি লিংকস) -->
    <footer class="mt-20 bg-slate-950 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800/80">
                
                <!-- Col 1: কোম্পানি প্রোফাইল -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-white shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight text-white">Cartiva</span>
                            <span class="block text-[9px] font-bold text-emerald-400 uppercase tracking-widest">Shop Together, Save More</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        কার্তিভা হলো সমষ্টিগত ক্রয়ের (Collective Buying) আধুনিক প্ল্যাটফর্ম। একক ব্যক্তির খুচরা দামের বদলে বন্ধুদের সাথে দলবদ্ধ হয়ে উপভোগ করুন ভলিউম পাইকারি মূল্য।
                    </p>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-800/60 text-[11px] font-semibold text-emerald-400">
                        ⚡ CSE 3200 Web Engineering Project
                    </div>
                </div>

                <!-- Col 2: কাস্টমার কর্নার -->
                <div>
                    <h4 class="text-xs font-black text-white uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">Customer Corner</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li><a href="#how-it-works" class="hover:text-emerald-400 transition-colors">Group Buying Rules (কীভাবে কাজ করে)</a></li>
                        <li><a href="#trust-badges" class="hover:text-emerald-400 transition-colors">100% Refund Policy (রিফান্ড নীতি)</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-emerald-400 transition-colors">Order Tracking & Delivery Status</a></li>
                        <li><a href="#faq-section" class="hover:text-emerald-400 transition-colors">Frequently Asked Questions (FAQ)</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Terms of Collective Service</a></li>
                    </ul>
                </div>

                <!-- Col 3: সেলার কর্নার -->
                <div>
                    <h4 class="text-xs font-black text-white uppercase tracking-wider mb-4 border-l-2 border-teal-500 pl-2">Merchant Hub</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition-colors font-bold text-teal-300">Become a Seller (মার্চেন্ট হন)</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors">Merchant Portal Login</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Seller SLA Policy (৪৮ ঘণ্টার শিপমেন্ট)</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Bulk Logistics & Consignment API</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Zero Ad-Waste Volume Sales</a></li>
                    </ul>
                </div>

                <!-- Col 4: যোগাযোগ ও সাপোর্ট -->
                <div>
                    <h4 class="text-xs font-black text-white uppercase tracking-wider mb-4 border-l-2 border-indigo-500 pl-2">Contact & Support</h4>
                    <div class="space-y-3 text-xs text-slate-400">
                        <div class="flex items-start space-x-2.5">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>support@cartiva.com</span>
                        </div>
                        <div class="flex items-start space-x-2.5">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+880 1711 000001 (Help Line)</span>
                        </div>
                        <div class="flex items-start space-x-2.5">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span>BAUST Campus, Saidpur Cantonment, Nilphamari</span>
                        </div>
                        
                        <!-- Social Media Icons -->
                        <div class="flex items-center space-x-3 pt-2 text-slate-400">
                            <span class="text-[11px] font-bold text-slate-500">Connect:</span>
                            <a href="#" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-colors">fb</a>
                            <a href="#" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-colors">in</a>
                            <a href="#" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-colors">wa</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Subfooter -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-medium">
                <p>&copy; {{ date('Y') }} Cartiva Group Buying Platform. Group 10, Dept of CSE, BAUST.</p>
                <div class="flex items-center space-x-6 mt-4 sm:mt-0">
                    <span class="text-slate-400">Laravel 12 • Tailwind CSS v4 • Alpine.js</span>
                    <span class="text-emerald-500">MySQL Escrow Model</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
