@extends('layouts.app')

@section('title', 'সকল ক্যাটাগরি ও প্রোডাক্ট সমাহার — All Categories & Products | Cartiva')

@push('styles')
<style>
    .cat-pill {
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .cat-pill:hover {
        transform: translateY(-1px);
    }
    .view-mode-btn.is-active {
        background-color: #53a318 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(83, 163, 24, 0.25) !important;
    }
    .view-mode-btn:not(.is-active) {
        background-color: #ffffff !important;
        color: #334155 !important;
    }
</style>
@endpush

@section('content')
<div class="max-w-[1600px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-5 sm:py-7 space-y-7"
     x-data="{
        viewMode: '{{ $viewMode ?? 'all' }}',
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
         1. BREADCRUMBS
         ======================================================== -->
    <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-[#53a318] transition-colors flex items-center space-x-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Home</span>
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-900 font-bold">Categories (ক্যাটাগরি সমূহ)</span>
        @if($selectedCategoryModel)
            <span class="text-slate-300">/</span>
            <span class="text-[#53a318] font-bold">{{ $selectedCategoryModel->name }}</span>
        @endif
    </nav>


    <!-- ========================================================
         2. CATEGORY DIRECTORY HERO BANNER
         ======================================================== -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-[#071926] to-[#062012] border border-slate-800 text-white p-6 sm:p-8 lg:p-9 shadow-xl">
        <div class="absolute -top-20 -left-20 w-80 h-80 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-[#53a318]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-[#84cc16] text-[11px] font-black uppercase tracking-wider">
                    <span>🛍️</span>
                    <span>ALL CATEGORIES & PRODUCTS DIRECTORY</span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
                    @if($selectedCategoryModel)
                        {{ $selectedCategoryModel->icon ?? '📂' }} {{ $selectedCategoryModel->name }}
                    @else
                        সকল ক্যাটাগরি ও প্রোডাক্ট সমাহার
                    @endif
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                    @if($selectedCategoryModel)
                        {{ $selectedCategoryModel->description ?? 'এই ক্যাটাগরির সমস্ত ভেরিফাইড পাইকারি ও গ্রুপ বাই প্রোডাক্ট তালিকাভুক্ত করা হয়েছে।' }}
                    @else
                        ক্যাটাগরি অনুযায়ী আপনার পছন্দের পণ্য বেছে নিন অথবা সাইটের সমস্ত প্রোডাক্ট একসাথে ব্রাউজ করে আকর্ষণীয় গ্রুপ বাই অফারে কিনুন।
                    @endif
                </p>

                <!-- Value Highlights -->
                <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-emerald-300 font-bold flex items-center space-x-1">
                        <span>🛡️</span>
                        <span>১০০% অফিসিয়াল অথেনটিক পণ্য</span>
                    </span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-cyan-300 font-bold flex items-center space-x-1">
                        <span>👥</span>
                        <span>গ্রুপ বাই পাইকারি মূল্য</span>
                    </span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-amber-300 font-bold flex items-center space-x-1">
                        <span>⚡</span>
                        <span>সর্বোচ্চ ৫০% পর্যন্ত ডিসকাউন্ট</span>
                    </span>
                </div>
            </div>

            <!-- Header Quick Stats Box -->
            <div class="flex md:flex-col items-center justify-around md:justify-center p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md gap-4 text-center min-w-[220px] shrink-0">
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-[#84cc16] block">
                        {{ $totalProductsCount }}+
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                        Available Products
                    </span>
                </div>
                <div class="hidden md:block w-full border-t border-white/10"></div>
                <div>
                    <span class="text-xl sm:text-2xl font-black text-white block">
                        {{ count($megaCategories ?? []) ?: $categories->count() }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                        Active Categories
                    </span>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================
         3. CATEGORY PILLS BAR (HORIZONTAL FILTERING)
         ======================================================== -->
    <section class="bg-white rounded-2xl border border-slate-200/90 p-3 sm:p-4 shadow-xs space-y-3">
        <div class="flex items-center justify-between pb-1 border-b border-slate-100">
            <div class="flex items-center space-x-2">
                <span class="text-base">📂</span>
                <h3 class="text-xs sm:text-sm font-bold text-slate-800">ক্যাটাগরি অনুযায়ী ফিল্টার করুন:</h3>
            </div>
            @if($selectedCategorySlug !== 'all' || request()->filled('q'))
                <a href="{{ route('categories.index') }}" 
                   class="text-xs font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-2.5 py-1 rounded-lg transition-colors flex items-center space-x-1">
                    <span>✕ ফিল্টার মুছুন (Clear Filter)</span>
                </a>
            @endif
        </div>

        <!-- Scrollable Category Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1.5 scrollbar-thin scrollbar-thumb-slate-200">
            <!-- All Option -->
            <a href="{{ route('categories.index', array_merge(request()->except(['category', 'page']), ['category' => 'all'])) }}"
               class="cat-pill shrink-0 inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer {{ $selectedCategorySlug === 'all' ? 'bg-[#53a318] text-white border-[#53a318] shadow-sm' : 'bg-slate-50 hover:bg-emerald-50 text-slate-700 border-slate-200/80 hover:border-emerald-300' }}">
                <span>🌟</span>
                <span>সবগুলো একসাথে (All)</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedCategorySlug === 'all' ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $totalProductsCount }}
                </span>
            </a>

            <!-- Individual Categories -->
            @foreach($megaCategories ?? [] as $mCat)
                @php
                    $isActive = ($selectedCategorySlug === $mCat['slug']);
                @endphp
                <a href="{{ route('categories.index', array_merge(request()->except(['category', 'page']), ['category' => $mCat['slug']])) }}"
                   class="cat-pill shrink-0 inline-flex items-center space-x-1.5 px-3 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer {{ $isActive ? 'bg-[#53a318] text-white border-[#53a318] shadow-sm' : 'bg-white hover:bg-emerald-50 text-slate-700 border-slate-200/80 hover:border-emerald-300' }}">
                    <span class="text-sm">{{ $mCat['icon'] }}</span>
                    <span>{{ $mCat['name_bn'] }}</span>
                    @if($mCat['count'] > 0)
                        <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $isActive ? 'bg-white/25 text-white' : 'bg-slate-100 text-slate-600' }}">
                            {{ $mCat['count'] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </section>


    <!-- ========================================================
         4. TOOLBAR: VIEW MODES, SEARCH & SORTING
         ======================================================== -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white rounded-2xl border border-slate-200/90 p-3 sm:p-4 shadow-xs">
        
        <!-- Left: View Mode Toggle -->
        <div class="flex items-center space-x-2">
            <span class="text-xs font-semibold text-slate-500 hidden sm:inline">ডিসপ্লে মোড:</span>
            <div class="inline-flex rounded-xl bg-slate-100 p-1 border border-slate-200/70 text-xs font-bold">
                <!-- All Products Unified Grid Mode -->
                <button type="button" 
                        @click="viewMode = 'all'"
                        class="view-mode-btn flex items-center space-x-1.5 px-3 py-1.5 rounded-lg transition-all cursor-pointer"
                        :class="viewMode === 'all' ? 'is-active' : ''">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>সবগুলো একসাথে (All Products)</span>
                </button>

                <!-- Grouped by Category Section View Mode -->
                <button type="button" 
                        @click="viewMode = 'grouped'"
                        class="view-mode-btn flex items-center space-x-1.5 px-3 py-1.5 rounded-lg transition-all cursor-pointer"
                        :class="viewMode === 'grouped' ? 'is-active' : ''">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>ক্যাটাগরি অনুযায়ী সেকশন (Category-Wise)</span>
                </button>
            </div>
        </div>

        <!-- Right: Search & Sorting Form -->
        <form action="{{ route('categories.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <!-- Search Input -->
            <div class="relative flex-1 sm:w-64">
                <input type="text" 
                       name="q" 
                       value="{{ $searchQ }}" 
                       placeholder="প্রোডাক্ট খুঁজুন..." 
                       class="w-full pl-9 pr-3.5 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#53a318]/30 font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Sort Selector -->
            <div class="flex items-center space-x-1.5 shrink-0">
                <select name="sort" 
                        onchange="this.form.submit()" 
                        class="px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#53a318]/30 cursor-pointer">
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>নতুন যোগ হওয়া</option>
                    <option value="discount" {{ $sort === 'discount' ? 'selected' : '' }}>সর্বোচ্চ ডিসকাউন্ট</option>
                    <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>জনপ্রিয় ডিল</option>
                    <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>দাম: কম থেকে বেশি</option>
                    <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>দাম: বেশি থেকে কম</option>
                </select>
            </div>
        </form>

    </div>


    <!-- ========================================================
         5. VIEW 1: UNIFIED ALL PRODUCTS GRID (সবগুলো একসাথে)
         ======================================================== -->
    <div x-show="viewMode === 'all'" x-transition:enter="transition ease-out duration-200">
        
        <!-- Active Filter Indicator Banner -->
        @if($selectedCategorySlug !== 'all' || request()->filled('q'))
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3 p-3.5 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl">
                <div class="flex items-center space-x-2 text-xs text-slate-700 font-semibold">
                    <span class="text-emerald-700">🔍 ফলাফল ফিল্টার:</span>
                    @if($selectedCategoryModel)
                        <span class="px-2.5 py-0.5 rounded-lg bg-emerald-100 font-bold text-emerald-800">
                            {{ $selectedCategoryModel->icon ?? '📂' }} {{ $selectedCategoryModel->name }}
                        </span>
                    @endif
                    @if(request()->filled('q'))
                        <span class="px-2.5 py-0.5 rounded-lg bg-slate-200 font-bold text-slate-800">
                            "{{ request('q') }}"
                        </span>
                    @endif
                    <span class="text-slate-500">({{ $products->total() }}টি প্রোডাক্ট পাওয়া গেছে)</span>
                </div>

                <a href="{{ route('categories.index') }}" 
                   class="text-xs font-bold text-emerald-800 hover:text-emerald-950 underline">
                    সব প্রোডাক্ট একসাথে দেখুন →
                </a>
            </div>
        @endif

        @if($products->count() > 0)
            <!-- Products Grid: 4 Columns on Desktop, 2 on Mobile -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
                @foreach($products as $product)
                    @php
                        $singleP = $product->single_price;
                        $groupP = $product->group_price;
                        $saveP = $singleP - $groupP;
                        $discountPct = $singleP > 0 ? round(($saveP / $singleP) * 100) : 0;
                        $activePool = $product->activeGroupSessions->where('status', 'active')->first();
                    @endphp

                    <div class="group relative bg-white rounded-2xl border border-slate-200/80 hover:border-emerald-400 overflow-hidden shadow-2xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        
                        <!-- Top Image Area -->
                        <div class="relative w-full aspect-square bg-slate-50 overflow-hidden">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" 
                                     alt="{{ $product->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </a>

                            <!-- Discount Tag Badge -->
                            @if($discountPct > 0)
                                <div class="absolute top-2.5 left-2.5 bg-rose-600 text-white text-[10px] sm:text-[11px] font-black px-2 py-0.5 rounded-lg shadow-sm">
                                    {{ $discountPct }}% OFF
                                </div>
                            @endif

                            <!-- Category Pill -->
                            @if($product->category)
                                <a href="{{ route('categories.index', ['category' => $product->category->slug]) }}" 
                                   class="absolute top-2.5 right-2.5 bg-white/90 backdrop-blur-xs text-slate-700 hover:text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md border border-slate-200/70 shadow-2xs truncate max-w-[120px]">
                                    {{ $product->category->name }}
                                </a>
                            @endif

                            <!-- Active Pool Ribbon -->
                            @if($activePool)
                                <div class="absolute bottom-2 left-2 right-2 bg-emerald-950/85 backdrop-blur-xs text-emerald-200 px-2 py-1 rounded-lg text-[10px] font-bold flex items-center justify-between">
                                    <span class="flex items-center space-x-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        <span>লাইভ পুল</span>
                                    </span>
                                    <span>{{ $activePool->current_members }}/{{ $activePool->required_members }} জন</span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between space-y-3">
                            <div>
                                <!-- Product Title -->
                                <h4 class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-emerald-700 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->title }}
                                    </a>
                                </h4>

                                <!-- Price Block -->
                                <div class="mt-2.5 flex items-baseline space-x-2">
                                    <span class="text-base sm:text-lg font-black text-[#53a318]">
                                        ৳{{ number_format($groupP, 0) }}
                                    </span>
                                    <span class="text-xs text-slate-400 line-through">
                                        ৳{{ number_format($singleP, 0) }}
                                    </span>
                                </div>

                                <!-- Savings Callout -->
                                <div class="text-[11px] text-emerald-700 font-semibold mt-0.5">
                                    সাশ্রয়: ৳{{ number_format($saveP, 0) }}
                                </div>
                            </div>

                            <!-- Bottom Action Button -->
                            <div class="pt-2 border-t border-slate-100">
                                @if($activePool)
                                    <a href="{{ route('group-buy.show', $activePool->group_code) }}" 
                                       class="w-full inline-flex items-center justify-center space-x-1.5 py-2 px-3 rounded-xl bg-gradient-to-r from-emerald-600 to-[#53a318] hover:from-emerald-700 hover:to-emerald-600 text-white font-bold text-xs shadow-xs transition-all">
                                        <span>গ্রুপে যোগ দিন</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                @else
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="w-full inline-flex items-center justify-center space-x-1.5 py-2 px-3 rounded-xl bg-slate-900 hover:bg-[#53a318] text-white font-bold text-xs shadow-xs transition-all">
                                        <span>ডিল দেখুন</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center bg-white rounded-3xl border border-slate-200/80 space-y-3">
                <span class="text-4xl block">🔍</span>
                <h3 class="text-base font-bold text-slate-800">কোনো প্রোডাক্ট খুঁজে পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    আপনার নির্বাচিত ফিল্টারে কোনো সক্রিয় প্রোডাক্ট নেই। দয়া করে অন্য ক্যাটাগরি বা সার্চ কি-ওয়ার্ড দিয়ে চেষ্টা করুন।
                </p>
                <div class="pt-2">
                    <a href="{{ route('categories.index') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-[#53a318] text-white text-xs font-bold">
                        <span>সকল প্রোডাক্ট দেখুন</span>
                    </a>
                </div>
            </div>
        @endif

    </div>


    <!-- ========================================================
         6. VIEW 2: CATEGORY-WISE SECTION BREAKDOWN (ক্যাটাগরি অনুযায়ী সেকশন ভিউ)
         ======================================================== -->
    <div x-show="viewMode === 'grouped'" x-transition:enter="transition ease-out duration-200" class="space-y-10">
        
        @foreach($groupedCategories as $cat)
            @if($cat->products->count() > 0)
                <section class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-xs space-y-4">
                    
                    <!-- Section Header -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 gap-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl font-bold border border-emerald-200/60 shadow-2xs">
                                {{ $cat->icon ?? '📦' }}
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight flex items-center space-x-2">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs font-bold text-slate-400">({{ $cat->products_count }}টি প্রোডাক্ট)</span>
                                </h3>
                                @if($cat->description)
                                    <p class="text-xs text-slate-500 font-medium truncate max-w-xl">{{ $cat->description }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Direct View All in Category Link -->
                        <a href="{{ route('categories.index', ['category' => $cat->slug]) }}" 
                           class="text-xs font-bold text-[#53a318] hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-xl transition-colors flex items-center space-x-1 shrink-0">
                            <span>এই ক্যাটাগরির সবগুলো ({{ $cat->products_count }})</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <!-- Products Grid for This Category -->
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                        @foreach($cat->products as $product)
                            @php
                                $singleP = $product->single_price;
                                $groupP = $product->group_price;
                                $saveP = $singleP - $groupP;
                                $discountPct = $singleP > 0 ? round(($saveP / $singleP) * 100) : 0;
                                $activePool = $product->activeGroupSessions->where('status', 'active')->first();
                            @endphp

                            <div class="group relative bg-slate-50/60 hover:bg-white rounded-2xl border border-slate-200/80 hover:border-emerald-400 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                                
                                <div class="relative w-full aspect-square bg-slate-100 overflow-hidden">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" 
                                             alt="{{ $product->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                             loading="lazy">
                                    </a>

                                    @if($discountPct > 0)
                                        <div class="absolute top-2 left-2 bg-rose-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded shadow-xs">
                                            {{ $discountPct }}% OFF
                                        </div>
                                    @endif
                                </div>

                                <div class="p-3 flex-1 flex flex-col justify-between space-y-2">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800 line-clamp-2 group-hover:text-emerald-700 transition-colors">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                {{ $product->title }}
                                            </a>
                                        </h4>
                                        <div class="mt-2 flex items-baseline space-x-1.5">
                                            <span class="text-sm font-black text-[#53a318]">৳{{ number_format($groupP, 0) }}</span>
                                            <span class="text-[11px] text-slate-400 line-through">৳{{ number_format($singleP, 0) }}</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="w-full text-center py-1.5 px-2 rounded-xl bg-slate-900 hover:bg-[#53a318] text-white text-xs font-bold transition-colors">
                                        ডিল দেখুন
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </section>
            @endif
        @endforeach

    </div>

</div>
@endsection
