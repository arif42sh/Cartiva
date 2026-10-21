@extends('layouts.app')

@section('title', 'গ্রুপ পুল — দল বাঁধলে নিশ্চিত পাইকারি মূল্য | Cartiva')

@push('styles')
<style>
    /* Top Dropdown Filter Bar Styles */
    .top-filter-btn {
        transition: all 0.2s ease-in-out !important;
        outline: none !important;
        user-select: none !important;
    }
    .top-filter-btn.is-active {
        background-color: #f0fdf4 !important;
        border-color: #53a318 !important;
        color: #53a318 !important;
        box-shadow: 0 1px 2px rgba(83, 163, 24, 0.15) !important;
    }
    .top-filter-btn.is-active svg {
        color: #53a318 !important;
    }
    #toggle-urgent-stock.is-active {
        background-color: #e11d48 !important;
        border-color: #e11d48 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(225, 29, 72, 0.25) !important;
    }
    .filter-dropdown-menu {
        transform-origin: top;
        animation: dropdownFadeIn 0.15s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: scale(0.97) translateY(-4px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="max-w-[1680px] w-full mx-auto px-3 sm:px-5 lg:px-6 py-4 sm:py-5 space-y-5 antialiased" id="group-pools-app"
     x-data="{
        shareModalOpen: false,
        shareGroupCode: '',
        shareGroupTitle: '',
        copiedToast: false,

        openShare(code, title) {
            this.shareGroupCode = code;
            this.shareGroupTitle = title;
            this.shareModalOpen = true;
        },
        copyShareLink(code) {
            const url = window.location.origin + '/group-buy/' + code;
            navigator.clipboard.writeText(url);
            this.copiedToast = true;
            setTimeout(() => { this.copiedToast = false; }, 3000);
        }
     }">

    <!-- ========================================================
         1. BREADCRUMB
         ======================================================== -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center space-x-1.5 text-xs font-semibold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3 py-1.5 rounded-xl transition-all shadow-2xs group">
                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back</span>
            </a>

            <nav class="hidden sm:flex items-center space-x-2 text-xs font-medium text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-slate-800 transition-colors">Home</a>
                <span>/</span>
                <span class="text-[#53a318] font-bold">Group Pools</span>
            </nav>
        </div>
    </div>


    <!-- ========================================================
         2. HERO RUSH HEADER (CARTIVA BRAND THEME - COLOR CORRECTED)
         ======================================================== -->
    <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-950 via-[#0a2315] to-[#071924] border border-emerald-900/40 p-5 sm:p-6 lg:p-7 text-white shadow-lg">
        
        <!-- Ambient Radial Glows -->
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-[#53a318]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            
            <!-- Left Info Column -->
            <div class="space-y-2.5 max-w-2xl">

                <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight leading-snug">
                    গ্রুপ পুল — দল বাঁধলে নিশ্চিত পাইকারি মূল্য
                </h1>

                <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed font-normal max-w-xl">
                    চলমান যেকোনো পুলে যোগ দিয়ে সাথে সাথে পাইকারি ডিসকাউন্ট আনলক করুন। ১ জন বাকি থাকা পুলে যুক্ত হলে এখনই অর্ডার কনফার্ম হবে। নির্দিষ্ট সময়ে গ্রুপ পূরণ না হলে পাবেন <strong class="text-white underline decoration-[#84cc16] underline-offset-2 font-bold">১০০% অটো-রিফান্ড</strong>।
                </p>

               
            </div>

            <!-- Right Activity Stat Module (High Contrast & Clean Glassmorphism) -->
            <div class="shrink-0 bg-black/60 border border-emerald-500/30 rounded-2xl p-4 sm:p-5 backdrop-blur-md min-w-[280px] shadow-xl">
                <div class="flex items-center justify-between text-[11px] font-bold pb-2.5 border-b border-white/10 mb-3">
                    <span class="text-emerald-400 flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span>লাইভ পুল অ্যাক্টিভিটি</span>
                    </span>
            
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    <!-- Stat 1 -->
                    <div class="bg-slate-900/90 border border-white/10 rounded-xl p-2.5 shadow-inner">
                        <span class="text-[10px] font-bold text-slate-300 block">সক্রিয় পুল</span>
                        <span class="text-2xl font-black text-[#84cc16] mt-0.5 block leading-tight">{{ $stats['active_pools_count'] }}টি</span>
                       
                    </div>

                    <!-- Stat 2 -->
                    <div class="bg-slate-900/90 border border-white/10 rounded-xl p-2.5 shadow-inner">
                        <span class="text-[10px] font-bold text-slate-300 block">১টি স্লট বাকি</span>
                        <span class="text-2xl font-black text-rose-400 mt-0.5 block leading-tight">{{ $stats['almost_full_count'] }}টি</span>
                        
                    </div>

                    <!-- Stat 3 -->
                    <div class="bg-slate-900/90 border border-white/10 rounded-xl p-2.5 shadow-inner">
                        <span class="text-[10px] font-bold text-slate-300 block">আজ যুক্ত হয়েছেন</span>
                        <span class="text-2xl font-black text-cyan-300 mt-0.5 block leading-tight">{{ $stats['verified_buyers_today'] }}+</span>
                       
                    </div>

                    <!-- Stat 4 -->
                    <div class="bg-slate-900/90 border border-white/10 rounded-xl p-2.5 shadow-inner">
                        <span class="text-[10px] font-bold text-slate-300 block">মোট সাশ্রয়</span>
                        <span class="text-lg font-black text-amber-300 mt-1 block leading-tight">৳{{ number_format($stats['total_saved_bdt']) }}</span>
                        
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================
         3. TOP DROPDOWN FILTER & SORT CONTROL BAR (EXACT FLASH SALES FORMAT)
         ======================================================== -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-3 sm:p-3.5 shadow-2xs space-y-2.5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            
            <!-- Left: Filter Dropdowns & Quick Urgency Toggle -->
            <div class="flex flex-wrap items-center gap-2">
                
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider shrink-0 mr-1 flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <span>Filters:</span>
                </span>

                <!-- 1. Category Dropdown -->
                <div class="relative" id="dropdown-category-wrapper">
                    <button type="button" id="btn-dropdown-category"
                            class="top-filter-btn inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 transition-all cursor-pointer">
                        <span id="label-category">Category: All</span>
                        <svg class="w-3 h-3 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="menu-dropdown-category" 
                         class="hidden filter-dropdown-menu absolute left-0 mt-1.5 w-60 bg-white rounded-2xl shadow-xl border border-slate-200 py-1.5 z-40 max-h-64 overflow-y-auto"
                         style="scrollbar-width: thin;">
                        <button type="button" data-val="all" data-name="All Categories" class="category-option w-full text-left px-3 py-1.5 hover:bg-emerald-50 text-xs font-bold text-[#53a318] flex items-center justify-between cursor-pointer">
                            <span>All Categories</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-slate-100 text-slate-600 font-semibold">{{ $pools->total() }}</span>
                        </button>
                        @foreach($categories as $cat)
                            @php
                                $cleanName = trim(preg_replace('/\(.*?\)/', '', $cat->name));
                            @endphp
                            <button type="button" data-val="{{ $cat->slug }}" data-name="{{ $cleanName }}" class="category-option w-full text-left px-3 py-1.5 hover:bg-slate-50 text-xs font-medium text-slate-700 flex items-center justify-between cursor-pointer">
                                <span class="truncate">{{ $cleanName }}</span>
                                <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-slate-100 text-slate-500 font-semibold shrink-0 ml-2">{{ $cat->products_count }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Price Range Dropdown -->
                <div class="relative" id="dropdown-price-wrapper">
                    <button type="button" id="btn-dropdown-price"
                            class="top-filter-btn inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 transition-all cursor-pointer">
                        <span id="label-price">Price: All</span>
                        <svg class="w-3 h-3 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="menu-dropdown-price" 
                         class="hidden filter-dropdown-menu absolute left-0 mt-1.5 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-40 space-y-1 text-xs">
                        <button type="button" data-price="all" data-name="All Prices" class="price-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-emerald-50 text-[#53a318] font-bold cursor-pointer">
                            All Prices
                        </button>
                        <button type="button" data-price="under_1000" data-name="Under ৳1,000" class="price-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            Under ৳1,000
                        </button>
                        <button type="button" data-price="1000_3000" data-name="৳1,000 – ৳3,000" class="price-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            ৳1,000 – ৳3,000
                        </button>
                        <button type="button" data-price="3000_7000" data-name="৳3,000 – ৳7,000" class="price-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            ৳3,000 – ৳7,000
                        </button>
                        <button type="button" data-price="above_7000" data-name="Above ৳7,000" class="price-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            Above ৳7,000
                        </button>
                    </div>
                </div>

                <!-- 3. Urgency Toggle Pill (🔥 ১টি স্লট বাকি) -->
                <button type="button" id="toggle-urgent-stock"
                        class="top-filter-btn inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 transition-all cursor-pointer">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                    <span>Slots Left</span>
                </button>

                <!-- 4. Minimum Discount Dropdown -->
                <div class="relative" id="dropdown-discount-wrapper">
                    <button type="button" id="btn-dropdown-discount"
                            class="top-filter-btn inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 transition-all cursor-pointer">
                        <span id="label-discount">Discount: All</span>
                        <svg class="w-3 h-3 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="menu-dropdown-discount" 
                         class="hidden filter-dropdown-menu absolute left-0 mt-1.5 w-44 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-40 space-y-1 text-xs">
                        <button type="button" data-discount="all" data-name="Any Discount" class="discount-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-emerald-50 text-[#53a318] font-bold cursor-pointer">
                            Any Discount
                        </button>
                        <button type="button" data-discount="20" data-name="20%+ Off" class="discount-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            20%+ Off
                        </button>
                        <button type="button" data-discount="30" data-name="30%+ Off" class="discount-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            30%+ Off
                        </button>
                        <button type="button" data-discount="40" data-name="40%+ Off" class="discount-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            40%+ Off
                        </button>
                        <button type="button" data-discount="50" data-name="50%+ Off" class="discount-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            50%+ Off
                        </button>
                    </div>
                </div>

                <!-- 5. Search Bar Input -->
                <div class="relative w-44 sm:w-56">
                    <input type="text" id="search-input" placeholder="Search..." 
                           class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-[#53a318] focus:outline-none font-semibold text-slate-800">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

            </div>

            <!-- Right: Sort Dropdown & Reset Filters -->
            <div class="flex items-center space-x-2 shrink-0">
                
                <!-- Sort Dropdown -->
                <div class="relative" id="dropdown-sort-wrapper">
                    <button type="button" id="btn-dropdown-sort"
                            class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 transition-all cursor-pointer">
                        <span class="text-slate-400 font-normal">Sort:</span>
                        <span id="label-sort">Urgency</span>
                        <svg class="w-3 h-3 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="menu-dropdown-sort" 
                         class="hidden filter-dropdown-menu absolute right-0 mt-1.5 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-40 space-y-1 text-xs">
                        <button type="button" data-sort="urgency" class="sort-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-emerald-50 text-[#53a318] font-bold cursor-pointer">
                            Urgency
                        </button>
                        <button type="button" data-sort="most_filled" class="sort-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            Most Filled
                        </button>
                        <button type="button" data-sort="discount" class="sort-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            Max Discount
                        </button>
                        <button type="button" data-sort="price_low" class="sort-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            Price: Low to High
                        </button>
                        <button type="button" data-sort="price_high" class="sort-option w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-50 font-semibold text-slate-700 cursor-pointer">
                            Price: High to Low
                        </button>
                    </div>
                </div>

                <!-- Reset Filters Button -->
                <button type="button" id="btn-reset-filters" title="Reset All Filters"
                        class="inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 text-xs font-semibold text-slate-600 transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Reset</span>
                </button>

            </div>

        </div>

        <!-- Active Filter Tags Strip (Shown when any filter is active) -->
        <div id="active-tags-strip" class="hidden flex-wrap items-center gap-1.5 pt-2 border-t border-slate-100 text-xs">
            <span class="text-slate-400 font-bold mr-1 uppercase tracking-wider text-[10px]">Active:</span>
            <div id="active-tags-container" class="flex flex-wrap items-center gap-1.5"></div>
        </div>
    </div>


    <!-- ========================================================
         4. COMPACT GROUP POOL CARDS (5-PER-ROW FORMAT EXACTLY LIKE FLASH SALES)
         ======================================================== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-3 sm:gap-3.5 lg:gap-4 transition-all duration-300" id="group-pools-grid">
        @forelse($pools as $group)
            @php
                $p = $group->product;
                $needed = max(1, $group->required_members - $group->current_members);
                $pct = min(100, round(($group->current_members / max(1, $group->required_members)) * 100));
                $discountPct = round((($p->single_price - $p->group_price) / max(1, $p->single_price)) * 100);
                $saveAmount = $p->single_price - $p->group_price;
                $remainingSecs = max(0, (int) now()->diffInSeconds($group->expires_at, false));
                $isOneLeft = ($needed === 1);
                $cleanCat = $p->category->name ?? 'General';
                $cleanCat = preg_match('/\((.*?)\)/', $cleanCat, $m) ? $m[1] : $cleanCat;
                $joinedMembers = $group->members->take(3);
            @endphp
            <div class="pool-card bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-lg hover:border-[#53a318] hover:-translate-y-1 transition-all duration-300 p-3 sm:p-3.5 flex flex-col justify-between relative group overflow-hidden"
                 data-category="{{ $p->category->slug ?? 'general' }}"
                 data-price="{{ $p->group_price }}"
                 data-discount="{{ $discountPct }}"
                 data-needed="{{ $needed }}"
                 data-seconds="{{ $remainingSecs }}"
                 data-pct="{{ $pct }}"
                 data-title="{{ strtolower($p->title) }}"
                 data-code="{{ strtolower($group->group_code) }}">
                
                <div class="space-y-2.5 relative z-10">
                    
                    <!-- Top Urgency Pill & Monospace Digital Timer -->
                    <div class="flex items-center justify-between gap-1.5">
                        @if($isOneLeft)
                            <span class="px-2 py-0.5 rounded-lg bg-rose-600 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                <span>🔥 ১টি স্লট বাকি!</span>
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-lg bg-amber-500 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                <span>⚡ {{ $needed }}টি স্লট বাকি</span>
                            </span>
                        @endif

                        <!-- Digital Monospace Countdown Timer -->
                        <span class="inline-flex items-center space-x-1 font-mono text-[10px] font-black text-rose-700 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-200/80 shrink-0">
                            <svg class="w-3 h-3 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="card-countdown-ticker" data-seconds="{{ $remainingSecs }}">02:30:15</span>
                        </span>
                    </div>

                    <!-- Product Thumbnail with Fixed Compact Height (h-32 sm:h-36) -->
                    <a href="{{ route('products.show', $p->slug) }}" class="block relative w-full h-32 sm:h-36 rounded-xl overflow-hidden bg-slate-100 group/img shadow-inner">
                        <img src="{{ $p->image_url }}" 
                             alt="{{ $p->title }}" 
                             loading="lazy"
                             class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300">
                        
                        <!-- Top Left: Discount Tag -->
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[9px] font-black bg-rose-600 text-white shadow-2xs tracking-tight">
                            -{{ $discountPct }}%
                        </span>

                        <!-- Bottom Right: Room Code Pill -->
                        <span class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded text-[8px] font-mono font-bold bg-slate-950/80 text-emerald-300 backdrop-blur-xs">
                            {{ $group->group_code }}
                        </span>

                        <!-- Bottom Left: Low Stock Alert Badge -->
                        @if($isOneLeft)
                            <span class="absolute bottom-2 left-2 px-1.5 py-0.5 rounded text-[8px] font-bold bg-amber-400 text-slate-950 shadow-2xs">
                                দ্রুত শেষ হচ্ছে
                            </span>
                        @endif
                    </a>

                    <!-- Product Title & Category -->
                    <div class="space-y-0.5">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-[#53a318] block truncate">
                            {{ $cleanCat }}
                        </span>

                        <h3 class="text-xs font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors min-h-[2rem]">
                            <a href="{{ route('products.show', $p->slug) }}">
                                {{ $p->title }}
                            </a>
                        </h3>
                        
                        <!-- Pricing & Savings Comparison -->
                        <div class="pt-1 flex items-baseline justify-between flex-wrap gap-1">
                            <div class="flex items-baseline space-x-1.5">
                                <span class="text-base font-black text-[#53a318]">৳{{ number_format($p->group_price) }}</span>
                                <span class="text-[11px] text-slate-400 line-through">৳{{ number_format($p->single_price) }}</span>
                            </div>
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-[#53a318] border border-emerald-200/80">
                                সাশ্রয় ৳{{ number_format($saveAmount) }}
                            </span>
                        </div>
                    </div>

                    <!-- Social Proof: Avatar Stack + Member Slots -->
                    <div class="pt-1 border-t border-slate-100 flex items-center justify-between text-[10px]">
                        <div class="flex items-center -space-x-1 overflow-hidden">
                            @foreach($joinedMembers as $mIdx => $m)
                                <div class="w-5 h-5 rounded-full ring-1 ring-white {{ $mIdx === 0 ? 'bg-slate-900 text-amber-300' : 'bg-slate-700 text-white' }} flex items-center justify-center font-bold text-[8px]"
                                     title="{{ $m->user->name ?? 'Customer' }}">
                                    @if($mIdx === 0)
                                        👑
                                    @else
                                        {{ strtoupper(substr($m->user->name ?? 'U', 0, 1)) }}
                                    @endif
                                </div>
                            @endforeach

                            <!-- Pulsing Empty Slot -->
                            <div class="w-5 h-5 rounded-full border border-dashed border-rose-400 bg-rose-50 text-rose-600 flex items-center justify-center text-[8px] font-black animate-pulse" 
                                 title="শেষ স্লটটিতে যোগ দিন!">
                                +১
                            </div>
                        </div>

                        <span class="text-[10px] font-bold text-slate-500">
                            {{ $group->current_members }}/{{ $group->required_members }} যুক্ত
                        </span>
                    </div>

                    <!-- Gradient Animated Progress Bar -->
                    <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full transition-all duration-500" 
                             style="width: {{ $pct }}%"></div>
                    </div>

                </div>

                <!-- Action CTAs: Direct 1-Click Join & Share Button -->
                <div class="pt-2.5 relative z-10 grid grid-cols-4 gap-1.5">
                    <a href="{{ route('group-buy.show', $group->group_code) }}" 
                       class="col-span-3 py-2 px-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs hover:shadow-md flex items-center justify-center space-x-1 active:scale-95">
                        <span>⚡ স্লটে জয়েন</span>
                    </a>

                    <button type="button" @click="openShare('{{ $group->group_code }}', '{{ addslashes($p->title) }}')"
                            title="ইনভাইট শেয়ার করুন"
                            class="col-span-1 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 px-6 text-center bg-white rounded-2xl border border-slate-200/90 text-slate-500 space-y-3 shadow-2xs">
                <span class="text-4xl block">👥</span>
                <h3 class="text-base font-black text-slate-800">বর্তমানে কোনো সক্রিয় পুল পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন অথবা হোমপেজ থেকে পছন্দের পণ্য বাছাই করে নতুন পুল খুলুন।</p>
            </div>
        @endforelse
    </div>

    <!-- Client-Side Empty State Filter Fallback -->
    <div id="filter-empty-state" class="hidden py-16 px-6 text-center bg-white rounded-2xl border border-slate-200/90 text-slate-500 space-y-3 shadow-2xs">
        <span class="text-4xl block">🔍</span>
        <h3 class="text-base font-black text-slate-800">এই ফিল্টারে কোনো সক্রিয় পুল নেই</h3>
        <p class="text-xs text-slate-400 max-w-sm mx-auto">আপনার নির্বাচিত ফিল্টারের সাথে মিলে এমন কোনো সক্রিয় টিম ডিল পাওয়া যায়নি।</p>
        <button type="button" id="reset-filter-btn" class="inline-block py-2.5 px-6 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs transition-colors shadow-xs cursor-pointer">
            সব ফিল্টার ক্লিয়ার করুন
        </button>
    </div>

    <!-- Pagination -->
    <div class="pt-4 flex justify-center">
        {{ $pools->links() }}
    </div>


    <!-- ========================================================
         5. 3 SOURCING & PLATFORM ASSURANCE PILLARS
         ======================================================== -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-3.5 pt-2">
        <!-- Pillar 1: 100% Refund -->
        <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#53a318] flex items-center justify-center text-xl shrink-0 font-black">
                🛡️
            </div>
            <div class="space-y-1">
                <h4 class="text-xs font-black text-slate-900">১০০% অটো-রিফান্ড গ্যারান্টি</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    নির্ধারিত সময়ে পুল পূর্ণ না হলে কোনো প্রশ্ন ছাড়াই আপনার অ্যাকাউন্টে তাৎক্ষণিক সম্পূর্ণ টাকা স্বয়ংক্রিয়ভাবে বিকাশ/নগদ/ওয়ালেটে ফেরত দেওয়া হবে।
                </p>
            </div>
        </div>

        <!-- Pillar 2: Separate Home Delivery -->
        <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0 font-black">
                📦
            </div>
            <div class="space-y-1">
                <h4 class="text-xs font-black text-slate-900">সবার ঠিকানায় আলাদা ডেলিভারি</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    গ্রুপে অন্য মেম্বার কে বা কোথায় থাকে তা দেখার বিষয় নয়; প্রত্যেকের পার্সেল নিজস্ব ঠিকানায় আলাদাভাবে হোম ডেলিভারি সম্পন্ন হবে।
                </p>
            </div>
        </div>

        <!-- Pillar 3: Authentic Factory Sourcing -->
        <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 font-black">
                🏭
            </div>
            <div class="space-y-1">
                <h4 class="text-xs font-black text-slate-900">সরাসরি ফ্যাক্টরি ও মার্চেন্ট রেট</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    কোনো মধ্যস্বত্বভোগী বা ব্রোকার কমিশন নেই — সরাসরি অনুমোদিত প্রস্তুতকারক ও ভেরিফাইড ডিস্ট্রিবিউটর থেকে শতভাগ আসল পণ্য।
                </p>
            </div>
        </div>
    </section>


    <!-- ========================================================
         6. SOCIAL SHARE MODAL
         ======================================================== -->
    <div x-show="shareModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
        
        <div @click.outside="shareModalOpen = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-3xl p-6 sm:p-7 max-w-md w-full shadow-2xl space-y-5 border border-slate-100">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center space-x-2.5">
                    <span class="w-8 h-8 rounded-xl bg-green-50 text-[#53a318] flex items-center justify-center text-lg">
                        📲
                    </span>
                    <h3 class="text-base font-black text-slate-900">ইনভাইট ও গ্রুপ শেয়ার করুন</h3>
                </div>
                <button type="button" @click="shareModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-xl cursor-pointer">&times;</button>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-500">গ্রুপ ডিল:</span>
                <p class="text-sm font-black text-slate-800" x-text="shareGroupTitle"></p>
                <div class="flex items-center space-x-2 pt-1">
                    <span class="text-xs font-bold text-slate-500">রুম কোড:</span>
                    <span class="font-mono text-xs font-black bg-slate-900 text-emerald-300 px-2.5 py-1 rounded-lg" x-text="shareGroupCode"></span>
                </div>
            </div>

            <!-- Share Buttons Grid -->
            <div class="grid grid-cols-2 gap-2.5 pt-1">
                <!-- WhatsApp -->
                <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('আমার সাথে কার্টিভায় গ্রুপ পুলে যোগ দিয়ে পাইকারি রেট আনলক করুন! রুম কোড: ' + shareGroupCode + ' লিংক: ' + window.location.origin + '/group-buy/' + shareGroupCode)"
                   target="_blank"
                   class="py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center space-x-1.5 transition-colors border border-emerald-200">
                    <span>WhatsApp Share</span>
                </a>

                <!-- Messenger -->
                <a :href="'fb-messenger://share/?link=' + encodeURIComponent(window.location.origin + '/group-buy/' + shareGroupCode)"
                   target="_blank"
                   class="py-2.5 px-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center space-x-1.5 transition-colors border border-blue-200">
                    <span>Messenger</span>
                </a>
            </div>

            <!-- Direct Link Copy Field -->
            <div class="space-y-1.5 pt-1">
                <span class="text-xs font-bold text-slate-500">অথবা সরাসরি লিঙ্ক কপি করুন:</span>
                <div class="flex items-center space-x-2">
                    <input type="text" readonly 
                           :value="window.location.origin + '/group-buy/' + shareGroupCode"
                           class="w-full text-xs font-mono bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 focus:outline-none">
                    <button type="button" @click="copyShareLink(shareGroupCode)"
                            class="px-4 py-2.5 bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs rounded-xl transition-colors shrink-0 flex items-center space-x-1 cursor-pointer">
                        <span x-text="copiedToast ? 'কপি হয়েছে!' : 'কপি'"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- ========================================================
     7. VANILLA JAVASCRIPT CONTROLLERS (FULL REAL-TIME FUNCTIONALITY)
     ======================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    /* ----------------------------------------------------
       A. PER-CARD INDIVIDUAL DIGITAL COUNTDOWN TICKERS
       ---------------------------------------------------- */
    (function initCardTimers() {
        const cardTimerEls = document.querySelectorAll('.card-countdown-ticker');

        cardTimerEls.forEach(el => {
            let secs = parseInt(el.getAttribute('data-seconds'), 10) || 7200;

            function tick() {
                if (secs <= 0) {
                    el.textContent = 'Expired';
                    return;
                }

                const h = Math.floor(secs / 3600);
                const m = Math.floor((secs % 3600) / 60);
                const s = secs % 60;

                el.textContent = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                secs--;
            }

            tick();
            setInterval(tick, 1000);
        });
    })();


    /* ----------------------------------------------------
       B. TOP DROPDOWN FILTER & SORT CONTROLLERS
       ---------------------------------------------------- */
    const poolsGrid = document.getElementById('group-pools-grid');
    const poolCards = document.querySelectorAll('.pool-card');
    const emptyStateEl = document.getElementById('filter-empty-state');
    const resetFilterBtn = document.getElementById('reset-filter-btn');
    const btnResetFilters = document.getElementById('btn-reset-filters');
    const activeTagsStrip = document.getElementById('active-tags-strip');
    const activeTagsContainer = document.getElementById('active-tags-container');
    const searchInput = document.getElementById('search-input');

    // State Variables
    let currentCategory = 'all';
    let currentCategoryName = 'All Categories';
    let currentPrice = 'all';
    let currentPriceName = 'All Prices';
    let currentDiscount = 'all';
    let currentDiscountName = 'Any Discount';
    let urgentOnly = false;
    let currentSort = 'urgency';
    let currentSearch = '';

    // Dropdown Elements
    const dropdownWrappers = [
        { btnId: 'btn-dropdown-category', menuId: 'menu-dropdown-category' },
        { btnId: 'btn-dropdown-price', menuId: 'menu-dropdown-price' },
        { btnId: 'btn-dropdown-discount', menuId: 'menu-dropdown-discount' },
        { btnId: 'btn-dropdown-sort', menuId: 'menu-dropdown-sort' }
    ];

    function closeAllDropdowns() {
        dropdownWrappers.forEach(d => {
            const menu = document.getElementById(d.menuId);
            const btn = document.getElementById(d.btnId);
            if (menu) menu.classList.add('hidden');
            if (btn) {
                const icon = btn.querySelector('svg');
                if (icon) icon.classList.remove('rotate-180');
            }
        });
    }

    dropdownWrappers.forEach(d => {
        const btn = document.getElementById(d.btnId);
        const menu = document.getElementById(d.menuId);
        if (btn && menu) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isCurrentlyOpen = !menu.classList.contains('hidden');
                closeAllDropdowns();
                if (!isCurrentlyOpen) {
                    menu.classList.remove('hidden');
                    const icon = btn.querySelector('svg');
                    if (icon) icon.classList.add('rotate-180');
                }
            });
            menu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    });

    document.addEventListener('click', function () {
        closeAllDropdowns();
    });

    // 1. Category Options
    const categoryOptions = document.querySelectorAll('.category-option');
    const labelCategory = document.getElementById('label-category');
    const btnCategory = document.getElementById('btn-dropdown-category');

    categoryOptions.forEach(opt => {
        opt.addEventListener('click', function () {
            currentCategory = this.getAttribute('data-val');
            currentCategoryName = this.getAttribute('data-name');
            labelCategory.textContent = currentCategory === 'all' ? 'Category: All' : currentCategoryName;
            
            if (currentCategory !== 'all') {
                btnCategory.classList.add('is-active');
            } else {
                btnCategory.classList.remove('is-active');
            }

            categoryOptions.forEach(o => {
                if (o.getAttribute('data-val') === currentCategory) {
                    o.classList.add('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.remove('text-slate-700');
                } else {
                    o.classList.remove('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.add('text-slate-700');
                }
            });

            closeAllDropdowns();
            applyFiltersAndSort();
        });
    });

    // 2. Price Options
    const priceOptions = document.querySelectorAll('.price-option');
    const labelPrice = document.getElementById('label-price');
    const btnPrice = document.getElementById('btn-dropdown-price');

    priceOptions.forEach(opt => {
        opt.addEventListener('click', function () {
            currentPrice = this.getAttribute('data-price');
            currentPriceName = this.getAttribute('data-name');

            labelPrice.textContent = currentPrice === 'all' ? 'Price: All' : currentPriceName;

            if (currentPrice !== 'all') {
                btnPrice.classList.add('is-active');
            } else {
                btnPrice.classList.remove('is-active');
            }

            priceOptions.forEach(o => {
                if (o.getAttribute('data-price') === currentPrice) {
                    o.classList.add('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.remove('text-slate-700');
                } else {
                    o.classList.remove('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.add('text-slate-700');
                }
            });

            closeAllDropdowns();
            applyFiltersAndSort();
        });
    });

    // 3. Discount Options
    const discountOptions = document.querySelectorAll('.discount-option');
    const labelDiscount = document.getElementById('label-discount');
    const btnDiscount = document.getElementById('btn-dropdown-discount');

    discountOptions.forEach(opt => {
        opt.addEventListener('click', function () {
            currentDiscount = this.getAttribute('data-discount');
            currentDiscountName = this.getAttribute('data-name');

            labelDiscount.textContent = currentDiscount === 'all' ? 'Discount: All' : `${currentDiscount}%+`;

            if (currentDiscount !== 'all') {
                btnDiscount.classList.add('is-active');
            } else {
                btnDiscount.classList.remove('is-active');
            }

            discountOptions.forEach(o => {
                if (o.getAttribute('data-discount') === currentDiscount) {
                    o.classList.add('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.remove('text-slate-700');
                } else {
                    o.classList.remove('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.add('text-slate-700');
                }
            });

            closeAllDropdowns();
            applyFiltersAndSort();
        });
    });

    // 4. Quick Urgency Toggle Pill
    const toggleUrgentStock = document.getElementById('toggle-urgent-stock');
    if (toggleUrgentStock) {
        toggleUrgentStock.addEventListener('click', function () {
            urgentOnly = !urgentOnly;
            if (urgentOnly) {
                this.classList.add('is-active');
            } else {
                this.classList.remove('is-active');
            }
            applyFiltersAndSort();
        });
    }

    // 5. Search Bar Input
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            currentSearch = this.value.trim().toLowerCase();
            applyFiltersAndSort();
        });
    }

    // 6. Sorting Dropdown
    const sortOptions = document.querySelectorAll('.sort-option');
    const labelSort = document.getElementById('label-sort');

    sortOptions.forEach(opt => {
        opt.addEventListener('click', function () {
            currentSort = this.getAttribute('data-sort');
            labelSort.textContent = this.textContent.trim();

            sortOptions.forEach(o => {
                if (o.getAttribute('data-sort') === currentSort) {
                    o.classList.add('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.remove('text-slate-700');
                } else {
                    o.classList.remove('font-bold', 'text-[#53a318]', 'bg-emerald-50');
                    o.classList.add('text-slate-700');
                }
            });

            closeAllDropdowns();
            applyFiltersAndSort();
        });
    });

    // 7. Reset Filters Function
    function resetAllFilters() {
        currentCategory = 'all';
        currentCategoryName = 'All Categories';
        labelCategory.textContent = 'Category: All';
        btnCategory.classList.remove('is-active');

        currentPrice = 'all';
        currentPriceName = 'All Prices';
        labelPrice.textContent = 'Price: All';
        btnPrice.classList.remove('is-active');

        currentDiscount = 'all';
        currentDiscountName = 'Any Discount';
        labelDiscount.textContent = 'Discount: All';
        btnDiscount.classList.remove('is-active');

        urgentOnly = false;
        if (toggleUrgentStock) toggleUrgentStock.classList.remove('is-active');

        currentSearch = '';
        if (searchInput) searchInput.value = '';

        applyFiltersAndSort();
    }

    if (btnResetFilters) btnResetFilters.addEventListener('click', resetAllFilters);
    if (resetFilterBtn) resetFilterBtn.addEventListener('click', resetAllFilters);

    // 8. Update Active Filter Tags Strip
    function updateActiveTags() {
        if (!activeTagsStrip || !activeTagsContainer) return;
        activeTagsContainer.innerHTML = '';

        const tags = [];

        if (currentCategory !== 'all') {
            tags.push({
                label: `Category: ${currentCategoryName}`,
                clearFn: () => {
                    currentCategory = 'all';
                    labelCategory.textContent = 'Category: All';
                    btnCategory.classList.remove('is-active');
                    applyFiltersAndSort();
                }
            });
        }

        if (currentPrice !== 'all') {
            tags.push({
                label: `Price: ${currentPriceName}`,
                clearFn: () => {
                    currentPrice = 'all';
                    labelPrice.textContent = 'Price: All';
                    btnPrice.classList.remove('is-active');
                    applyFiltersAndSort();
                }
            });
        }

        if (urgentOnly) {
            tags.push({
                label: 'Urgent: ১টি স্লট বাকি',
                clearFn: () => {
                    urgentOnly = false;
                    if (toggleUrgentStock) toggleUrgentStock.classList.remove('is-active');
                    applyFiltersAndSort();
                }
            });
        }

        if (currentDiscount !== 'all') {
            tags.push({
                label: `Discount: ${currentDiscount}%+`,
                clearFn: () => {
                    currentDiscount = 'all';
                    labelDiscount.textContent = 'Discount: All';
                    btnDiscount.classList.remove('is-active');
                    applyFiltersAndSort();
                }
            });
        }

        if (currentSearch) {
            tags.push({
                label: `Search: "${currentSearch}"`,
                clearFn: () => {
                    currentSearch = '';
                    if (searchInput) searchInput.value = '';
                    applyFiltersAndSort();
                }
            });
        }

        if (tags.length === 0) {
            activeTagsStrip.classList.add('hidden');
        } else {
            activeTagsStrip.classList.remove('hidden');
            tags.forEach(t => {
                const tagEl = document.createElement('span');
                tagEl.className = 'inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-[#53a318] border border-emerald-200 text-xs font-bold shadow-2xs';
                tagEl.innerHTML = `<span>${t.label}</span><button type="button" class="tag-remove text-emerald-600 hover:text-emerald-900 font-black cursor-pointer">&times;</button>`;
                tagEl.querySelector('.tag-remove').addEventListener('click', t.clearFn);
                activeTagsContainer.appendChild(tagEl);
            });
        }
    }

    // 9. Core Filter & Sorting Engine
    function applyFiltersAndSort() {
        let visibleCount = 0;
        const visibleCards = [];

        poolCards.forEach(card => {
            const cardCat = card.getAttribute('data-category') || '';
            const cardPrice = parseFloat(card.getAttribute('data-price')) || 0;
            const cardDiscount = parseFloat(card.getAttribute('data-discount')) || 0;
            const cardNeeded = parseInt(card.getAttribute('data-needed'), 10) || 1;
            const cardTitle = card.getAttribute('data-title') || '';
            const cardCode = card.getAttribute('data-code') || '';

            // Category matching
            let matchCategory = (currentCategory === 'all') || (cardCat === currentCategory);
            if (!matchCategory && (currentCategory === 'smart-tech-audio' || currentCategory === 'tech-accessories')) {
                matchCategory = (cardCat === 'smart-tech-audio' || cardCat === 'tech-accessories');
            }

            // Price matching
            let matchPrice = true;
            if (currentPrice === 'under_1000') matchPrice = (cardPrice < 1000);
            else if (currentPrice === '1000_3000') matchPrice = (cardPrice >= 1000 && cardPrice <= 3000);
            else if (currentPrice === '3000_7000') matchPrice = (cardPrice >= 3000 && cardPrice <= 7000);
            else if (currentPrice === 'above_7000') matchPrice = (cardPrice > 7000);

            // Discount matching
            let matchDiscount = true;
            if (currentDiscount !== 'all') {
                matchDiscount = (cardDiscount >= parseFloat(currentDiscount));
            }

            // Urgency matching
            let matchUrgent = true;
            if (urgentOnly) {
                matchUrgent = (cardNeeded === 1);
            }

            // Search matching
            let matchSearch = true;
            if (currentSearch) {
                matchSearch = cardTitle.includes(currentSearch) || cardCode.includes(currentSearch);
            }

            const isVisible = matchCategory && matchPrice && matchDiscount && matchUrgent && matchSearch;

            if (isVisible) {
                card.classList.remove('hidden');
                visibleCards.push(card);
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Sorting
        visibleCards.sort((a, b) => {
            const priceA = parseFloat(a.getAttribute('data-price')) || 0;
            const priceB = parseFloat(b.getAttribute('data-price')) || 0;
            const discA = parseFloat(a.getAttribute('data-discount')) || 0;
            const discB = parseFloat(b.getAttribute('data-discount')) || 0;
            const needA = parseInt(a.getAttribute('data-needed'), 10) || 1;
            const needB = parseInt(b.getAttribute('data-needed'), 10) || 1;
            const secsA = parseInt(a.getAttribute('data-seconds'), 10) || 999999;
            const secsB = parseInt(b.getAttribute('data-seconds'), 10) || 999999;
            const pctA = parseFloat(a.getAttribute('data-pct')) || 0;
            const pctB = parseFloat(b.getAttribute('data-pct')) || 0;

            if (currentSort === 'price_low') return priceA - priceB;
            if (currentSort === 'price_high') return priceB - priceA;
            if (currentSort === 'discount') return discB - discA;
            if (currentSort === 'most_filled') return pctB - pctA;
            
            // Urgency default: 1 slot first, then soonest expiry
            if (needA !== needB) return needA - needB;
            return secsA - secsB;
        });

        visibleCards.forEach(card => poolsGrid.appendChild(card));

        // Empty state toggle
        if (visibleCount === 0) {
            emptyStateEl.classList.remove('hidden');
        } else {
            emptyStateEl.classList.add('hidden');
        }

        updateActiveTags();
    }

});
</script>
@endsection
