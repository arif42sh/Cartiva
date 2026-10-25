<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc] text-slate-800 antialiased font-sans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Platform Command Center - Cartiva Administrator')</title>
    <meta name="description" content="Centralized Platform Command Center for Cartiva Multi-Vendor Group Buying Network.">

    <!-- Fonts: Inter & Hind Siliguri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full font-sans bg-[#f8fafc] text-slate-800 selection:bg-purple-600 selection:text-white"
      x-data="{ sidebarOpen: false, userMenuOpen: false }">

    @php
        $sidebarPendingSellers = \App\Models\User::where('role', 'seller')->where('status', 'pending')->count();
        $sidebarPendingRefunds = \App\Models\RefundRequest::where('status', 'pending')->count();
        $sidebarOpenIssues = \App\Models\ReportedIssue::where('status', 'open')->count();
    @endphp

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-cloak 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Modern Vertical Left Sidebar (Shopify / Stripe Standard) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col justify-between transition-transform duration-300 ease-in-out lg:static lg:h-screen lg:sticky lg:top-0 flex-shrink-0">
            
            <!-- Top Section: Brand & Navigation -->
            <div class="flex-1 flex flex-col min-h-0">
                
                <!-- Sidebar Brand Header -->
                <div class="h-16 px-5 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2.5 group">
                        <img src="{{ asset('images/cartiva-logo.png') }}" 
                             alt="Cartiva" 
                             class="h-7 w-auto object-contain transition-transform group-hover:scale-105">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-purple-100 text-purple-900 border border-purple-200 uppercase tracking-wider">
                            Admin
                        </span>
                    </a>

                    <!-- Mobile Close Button -->
                    <button type="button" @click="sidebarOpen = false" class="lg:hidden p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Navigation Links Scroll Container -->
                <nav class="flex-1 px-3 py-4 space-y-6 overflow-y-auto text-xs font-semibold">
                    
                    <!-- 1. CORE SECTION -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">Core</div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    <span>Overview</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.statistics') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.statistics*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.statistics*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <span>Analytics</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 2. USERS SECTION -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">Users</div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.customers.index') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.customers.*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.customers.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span>Customers</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.sellers.index') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.sellers.*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.sellers.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span>Sellers</span>
                                </div>
                                @if($sidebarPendingSellers > 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ request()->routeIs('admin.sellers.*') ? 'bg-white text-purple-700' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $sidebarPendingSellers }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- 3. CATALOG SECTION -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">Catalog</div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.products') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.products*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.products*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <span>Products</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.categories.index') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    <span>Categories</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 4. SALES & ACTIVITY SECTION -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">Sales & Activity</div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.orders') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.orders*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.orders*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span>Orders</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.groups') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.groups*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.groups*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <span>Group Buys</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 5. FINANCE SECTION -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">Finance</div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.payments') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.payments*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.payments*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    <span>Payments</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.refunds') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.refunds*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.refunds*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    <span>Refunds</span>
                                </div>
                                @if($sidebarPendingRefunds > 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ request()->routeIs('admin.refunds*') ? 'bg-white text-purple-700' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $sidebarPendingRefunds }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- 6. SYSTEM SECTION -->
                    <div>
                        <div class="px-3 mb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">System</div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.issues') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.issues*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.issues*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span>Disputes</span>
                                </div>
                                @if($sidebarOpenIssues > 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ request()->routeIs('admin.issues*') ? 'bg-white text-purple-700' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $sidebarOpenIssues }}
                                    </span>
                                @endif
                            </a>

                            <a href="{{ route('admin.announcements') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.announcements*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.announcements*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    <span>Announcements</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.activity-logs') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.activity-logs*') ? 'bg-purple-700 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <div class="flex items-center space-x-2.5">
                                    <svg class="w-4 h-4 {{ request()->routeIs('admin.activity-logs*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span>Audit Logs</span>
                                </div>
                            </a>
                        </div>
                    </div>

                </nav>
            </div>

            <!-- Sidebar Bottom: Admin Profile Card -->
            <div class="p-3 border-t border-slate-100 flex-shrink-0 bg-slate-50/50">
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-white transition-colors">
                    <div class="flex items-center space-x-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-purple-700 text-white font-black text-xs flex items-center justify-center flex-shrink-0 shadow-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</span>
                            <span class="block text-[10px] text-purple-700 font-bold leading-tight">Super Administrator</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" title="Sign Out" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Right Main Workspace -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Sticky Top Header (Executive Topbar) -->
            <header class="bg-white border-b border-slate-200 sticky top-0 z-30 text-slate-800 shadow-2xs">
                <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                    
                    <!-- Left: Mobile Hamburger & System Health Badge -->
                    <div class="flex items-center space-x-3">
                        <button type="button" @click="sidebarOpen = true" 
                                class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <div class="flex items-center space-x-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-slate-800 font-bold">Platform: Healthy</span>
                            <span class="text-slate-300 hidden sm:inline">|</span>
                            <span class="text-slate-500 font-mono text-[11px] hidden sm:inline">PHP {{ PHP_VERSION }}</span>
                        </div>
                    </div>

                    <!-- Right: Direct Storefront Link & Persona Switcher -->
                    <div class="flex items-center space-x-3 flex-shrink-0">
                        <a href="{{ route('home') }}" 
                           class="text-xs font-bold text-slate-600 hover:text-purple-700 transition-colors inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200">
                            <span>Marketplace Home</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>

                        <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>

                        <!-- Fast Switch Persona Menu -->
                        <div class="relative" @click.outside="userMenuOpen = false">
                            <button type="button" @click="userMenuOpen = !userMenuOpen"
                                    class="flex items-center space-x-2 px-2.5 py-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer border border-slate-200">
                                <span class="text-xs font-bold text-slate-700">Switch Account</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="userMenuOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-1.5 z-50 text-slate-800 divide-y divide-slate-100">
                                <div class="px-4 py-2">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">Fast Multi-Auth Switch</span>
                                </div>
                                <div class="py-1 text-xs font-semibold">
                                    <a href="{{ route('switch-user', 'seller') }}" class="flex items-center space-x-2 px-4 py-2 hover:bg-teal-50 text-teal-800 font-bold transition-colors">
                                        <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                                        <span>Merchant Hub</span>
                                    </a>
                                    <a href="{{ route('switch-user', 'customer') }}" class="flex items-center space-x-2 px-4 py-2 hover:bg-emerald-50 text-emerald-800 font-bold transition-colors">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span>Customer</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1">
                <!-- Toast Alerts -->
                @if(session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs">
                            <div class="flex items-center space-x-2.5">
                                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-xs flex-shrink-0">✓</span>
                                <span class="text-sm font-semibold">{{ session('success') }}</span>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 font-black text-base cursor-pointer">&times;</button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-bold flex items-center justify-between shadow-xs">
                            <div class="flex items-center space-x-2.5">
                                <span class="w-6 h-6 rounded-full bg-rose-500 text-white flex items-center justify-center font-black text-xs flex-shrink-0">✕</span>
                                <span class="text-sm font-semibold">{{ session('error') }}</span>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-950 font-black text-base cursor-pointer">&times;</button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Executive Admin Footer -->
            <footer class="bg-white border-t border-slate-200 py-6 text-slate-500 text-xs mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="font-black text-slate-900">Cartiva Platform Operations</span>
                        <span>•</span>
                        <span>SRS 4.4 Admin Engine v2.0</span>
                    </div>
                    <div class="text-slate-400">
                        Cartiva Multi-Vendor Group Buying Network &copy; {{ date('Y') }}
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
