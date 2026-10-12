@extends('layouts.app')

@section('title', 'Hot Deals & Buying Pools — Cartiva')

@section('content')
<div class="max-w-[1680px] w-full mx-auto px-3 sm:px-5 lg:px-6 py-4 sm:py-5 space-y-5"
     x-data="{
        mobileFilterOpen: false,
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
         1. BREADCRUMB NAVIGATION
         ======================================================== -->
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center space-x-1.5 text-xs font-semibold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3 py-1.5 rounded-xl transition-all group">
            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Home</span>
        </a>

        <nav class="flex items-center space-x-2 text-xs font-medium text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-[#53a318] transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Hot Deals</span>
        </nav>
    </div>


    <!-- ========================================================
         2. CLEAN COMPACT HEADER BANNER (NO EMOJIS, HIGH DENSITY)
         ======================================================== -->
    <section class="rounded-2xl bg-slate-900 border border-slate-800 text-white p-4 sm:p-5 lg:p-6 shadow-md relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1.5 max-w-2xl">
                

                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold tracking-tight text-white">
                    Hot Deals & Group Pools
                </h1>

                <p class="text-xs text-slate-400 leading-relaxed font-normal">
                    Join ongoing community pools to secure volume wholesale rates before group countdowns expire.
                </p>
            </div>

            <!-- Stats Box -->
            <div class="flex items-center p-3 sm:p-4 rounded-xl bg-slate-800/80 border border-slate-700/80 gap-5 text-center self-start md:self-auto">
                <div class="px-2">
                    <span class="text-xl sm:text-2xl font-extrabold text-white block">
                        {{ $hotGroups->total() }}
                    </span>
                    <span class="text-[9px] text-slate-400 font-semibold uppercase tracking-wider block mt-0.5">
                        Active Pools
                    </span>
                </div>
                <div class="h-7 w-px bg-slate-700"></div>
                <div class="px-2">
                    <span class="text-xl sm:text-2xl font-extrabold text-[#84cc16] block">
                        45%
                    </span>
                    <span class="text-[9px] text-slate-400 font-semibold uppercase tracking-wider block mt-0.5">
                        Max Savings
                    </span>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================
         3. MAIN LAYOUT: SLIM SIDEBAR (220px) + 5-COL GRID
         ======================================================== -->
    <div class="flex flex-col lg:flex-row items-start gap-4 xl:gap-5">
        
        <!-- ====================================================
             A. DESKTOP COMPACT FILTER SIDEBAR (w-52 xl:w-56)
             ==================================================== -->
        <aside class="hidden lg:block w-52 xl:w-56 shrink-0 sticky top-20"
               x-data="{
                   categoryOpen: {{ ($selectedCategory && $selectedCategory !== 'all') ? 'true' : 'false' }},
                   priceOpen: {{ ($pricePreset || request()->filled('min_price') || request()->filled('max_price')) ? 'true' : 'false' }},
                   statusOpen: {{ ($filter && $filter !== 'all') ? 'true' : 'false' }},
                   discountOpen: {{ !empty($minDiscount) ? 'true' : 'false' }}
               }">
            <div class="bg-white rounded-xl border border-slate-200/90 p-3 sm:p-3.5 shadow-2xs space-y-2.5">
                
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <h2 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">Filters</h2>
                    </div>

                    @if(request()->hasAny(['category', 'price_range', 'min_price', 'max_price', 'filter', 'min_discount', 'q']))
                        <a href="{{ route('hot-deals.index') }}" 
                           class="text-[10px] font-semibold text-rose-600 hover:text-rose-700 transition-colors">
                            Reset All
                        </a>
                    @endif
                </div>

                <!-- 1. Categories Filter (Foldable) -->
                <div class="border-b border-slate-100 pb-2.5">
                    <button type="button" 
                            @click="categoryOpen = !categoryOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-[#53a318] transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Category</span>
                            @if($selectedCategory && $selectedCategory !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if($selectedCategory && $selectedCategory !== 'all')
                                <span class="text-[9px] font-medium text-[#53a318] bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-transform duration-200" 
                                 :class="categoryOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="categoryOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-0.5 max-h-48 overflow-y-auto pr-1 text-[11px]"
                         style="scrollbar-width: thin;">
                        <a href="{{ request()->fullUrlWithQuery(['category' => 'all']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>All Categories</span>
                            <span class="text-[9px] text-slate-400 px-1 py-0.2 rounded bg-slate-100">{{ $categories->sum('products_count') }}</span>
                        </a>

                        @foreach($categories as $cat)
                            @php
                                $cleanName = trim(preg_replace('/\(.*?\)/', '', $cat->name));
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" 
                               class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $selectedCategory === $cat->slug ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span class="truncate">{{ $cleanName }}</span>
                                <span class="text-[9px] text-slate-400 px-1 py-0.2 rounded bg-slate-100 shrink-0 ml-1.5">{{ $cat->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Price Range Filter (Foldable) -->
                <div class="border-b border-slate-100 pb-2.5">
                    <button type="button" 
                            @click="priceOpen = !priceOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-[#53a318] transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Price Range</span>
                            @if($pricePreset || request()->filled('min_price') || request()->filled('max_price'))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if($pricePreset || request()->filled('min_price') || request()->filled('max_price'))
                                <span class="text-[9px] font-medium text-[#53a318] bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-transform duration-200" 
                                 :class="priceOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="priceOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-1.5 text-[11px]">
                        <!-- Presets -->
                        <div class="space-y-0.5">
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => null, 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ empty($pricePreset) && !request()->filled('min_price') ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>All Prices</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => 'under_1000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === 'under_1000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>Under ৳1,000</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => '1000_3000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === '1000_3000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>৳1,000 – ৳3,000</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => '3000_7000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === '3000_7000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>৳3,000 – ৳7,000</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => 'above_7000', 'min_price' => null, 'max_price' => null]) }}" 
                               class="flex items-center px-2 py-1 rounded-md transition-colors {{ $pricePreset === 'above_7000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>Above ৳7,000</span>
                            </a>
                        </div>

                        <!-- Custom Min / Max Inputs -->
                        <form method="GET" action="{{ route('hot-deals.index') }}" class="pt-0.5">
                            @if($selectedCategory)
                                <input type="hidden" name="category" value="{{ $selectedCategory }}">
                            @endif
                            @if($filter !== 'all')
                                <input type="hidden" name="filter" value="{{ $filter }}">
                            @endif
                            @if($sort !== 'urgency')
                                <input type="hidden" name="sort" value="{{ $sort }}">
                            @endif
                            @if($minDiscount)
                                <input type="hidden" name="min_discount" value="{{ $minDiscount }}">
                            @endif

                            <div class="flex items-center space-x-1.5">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                                       class="w-full px-2 py-1 rounded-md border border-slate-200 text-[11px] focus:ring-1 focus:ring-[#53a318] focus:outline-none">
                                <span class="text-slate-400 text-[10px]">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                                       class="w-full px-2 py-1 rounded-md border border-slate-200 text-[11px] focus:ring-1 focus:ring-[#53a318] focus:outline-none">
                                <button type="submit" 
                                        class="px-2 py-1 rounded-md bg-slate-900 hover:bg-slate-800 text-white text-[11px] font-semibold transition-colors cursor-pointer">
                                    Go
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 3. Pool Status / Urgency Filter (Foldable) -->
                <div class="border-b border-slate-100 pb-2.5">
                    <button type="button" 
                            @click="statusOpen = !statusOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-[#53a318] transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Pool Status</span>
                            @if($filter && $filter !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if($filter && $filter !== 'all')
                                <span class="text-[9px] font-medium text-[#53a318] bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-transform duration-200" 
                                 :class="statusOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="statusOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-0.5 text-[11px]">
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $filter === 'all' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>All Active Pools</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => '1_slot']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $filter === '1_slot' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>1 Slot Remaining</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'ending_today']) }}" 
                           class="flex items-center justify-between px-2 py-1 rounded-md transition-colors {{ $filter === 'ending_today' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>Ending in 12h</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Minimum Discount Filter (Foldable) -->
                <div>
                    <button type="button" 
                            @click="discountOpen = !discountOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-[11px] font-bold text-slate-800 uppercase tracking-wider hover:text-[#53a318] transition-colors group cursor-pointer">
                        <div class="flex items-center space-x-1.5">
                            <span>Discount Tier</span>
                            @if(!empty($minDiscount))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-1">
                            @if(!empty($minDiscount))
                                <span class="text-[9px] font-medium text-[#53a318] bg-emerald-50 px-1.5 py-0.2 rounded-full normal-case">Active</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-transform duration-200" 
                                 :class="discountOpen ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="discountOpen" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pt-1.5 space-y-0.5 text-[11px]">
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => null]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ empty($minDiscount) ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>Any Discount</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 20]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ $minDiscount == '20' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>20% and above</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 30]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ $minDiscount == '30' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>30% and above</span>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 40]) }}" 
                           class="flex items-center px-2 py-1 rounded-md transition-colors {{ $minDiscount == '40' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>40% and above</span>
                        </a>
                    </div>
                </div>

            </div>
        </aside>


        <!-- ====================================================
             B. RIGHT PRODUCTS COLUMN (FLEX-1)
             ==================================================== -->
        <main class="flex-1 min-w-0 space-y-4">

            <!-- Top Controls Bar: Sorting & Active Filters -->
            <div class="bg-white rounded-xl border border-slate-200 px-3 py-2 sm:py-2.5 shadow-2xs space-y-2">
                <div class="flex items-center justify-between gap-2.5">
                    
                    <!-- Mobile Filter Trigger -->
                    <div>
                        <button type="button" @click="mobileFilterOpen = true" 
                                class="lg:hidden inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            <span>Filters</span>
                        </button>
                    </div>

                    <!-- Sorting Dropdown -->
                    <div class="flex items-center space-x-2 text-xs ml-auto">
                        <span class="text-slate-400 font-medium text-[11px]">Sort:</span>
                        <div class="relative" x-data="{ sortMenuOpen: false }">
                            <button @click="sortMenuOpen = !sortMenuOpen" @click.outside="sortMenuOpen = false" 
                                    class="inline-flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white font-semibold text-slate-800 hover:border-slate-300 transition-colors">
                                <span>
                                    @if($sort === 'discount') Highest Discount
                                    @elseif($sort === 'price_low') Price: Low to High
                                    @elseif($sort === 'price_high') Price: High to Low
                                    @elseif($sort === 'most_filled') Most Filled First
                                    @elseif($sort === 'latest') Newest First
                                    @else Closing Soonest
                                    @endif
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="sortMenuOpen" x-cloak 
                                 class="absolute right-0 mt-1 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-30 text-xs">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'urgency']) }}" class="block px-3 py-1.5 hover:bg-slate-50 font-medium {{ $sort === 'urgency' ? 'text-[#53a318] font-bold' : 'text-slate-700' }}">Closing Soonest</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'most_filled']) }}" class="block px-3 py-1.5 hover:bg-slate-50 font-medium {{ $sort === 'most_filled' ? 'text-[#53a318] font-bold' : 'text-slate-700' }}">Most Filled First</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'discount']) }}" class="block px-3 py-1.5 hover:bg-slate-50 font-medium {{ $sort === 'discount' ? 'text-[#53a318] font-bold' : 'text-slate-700' }}">Highest Discount</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" class="block px-3 py-1.5 hover:bg-slate-50 font-medium {{ $sort === 'price_low' ? 'text-[#53a318] font-bold' : 'text-slate-700' }}">Price: Low to High</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" class="block px-3 py-1.5 hover:bg-slate-50 font-medium {{ $sort === 'price_high' ? 'text-[#53a318] font-bold' : 'text-slate-700' }}">Price: High to Low</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="block px-3 py-1.5 hover:bg-slate-50 font-medium {{ $sort === 'latest' ? 'text-[#53a318] font-bold' : 'text-slate-700' }}">Newest First</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Active Filter Tags Strip -->
                @if(request()->hasAny(['category', 'price_range', 'min_price', 'max_price', 'filter', 'min_discount']))
                    <div class="flex flex-wrap items-center gap-1.5 pt-2 border-t border-slate-100 text-[11px]">
                        <span class="text-slate-400 font-medium mr-1">Active:</span>

                        @if($selectedCategory && $selectedCategory !== 'all')
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <span>Category: {{ $selectedCategory }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        @if($pricePreset)
                            <a href="{{ request()->fullUrlWithQuery(['price_range' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <span>Price: {{ str_replace('_', ' ', $pricePreset) }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @elseif(request()->filled('min_price') || request()->filled('max_price'))
                            <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <span>৳{{ request('min_price', 0) }} - ৳{{ request('max_price', 'Any') }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        @if($filter !== 'all')
                            <a href="{{ request()->fullUrlWithQuery(['filter' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <span>{{ $filter === '1_slot' ? '1 slot left' : 'ending today' }}</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        @if($minDiscount)
                            <a href="{{ request()->fullUrlWithQuery(['min_discount' => null]) }}" 
                               class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <span>Min {{ $minDiscount }}% off</span>
                                <span class="font-bold">&times;</span>
                            </a>
                        @endif

                        <a href="{{ route('hot-deals.index') }}" 
                           class="text-[11px] font-semibold text-rose-600 hover:underline ml-1.5">
                            Clear all
                        </a>
                    </div>
                @endif
            </div>

            <!-- Products Grid: 5 columns on desktop, 4 on laptop, 3 on tablet, 2 on mobile -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 min-[1240px]:grid-cols-5 xl:grid-cols-5 gap-3 sm:gap-3.5">
                @forelse($hotGroups as $group)
                    @php
                        $product = $group->product;
                        $discountPct = round((($product->single_price - $product->group_price) / $product->single_price) * 100);
                        $needed = max(1, $group->required_members - $group->current_members);
                        $pct = min(100, round(($group->current_members / $group->required_members) * 100));
                        $rawCat = $product->category->name ?? 'General';
                        $cleanCat = trim(preg_replace('/\(.*?\)/', '', $rawCat));
                        $remainingSecs = max(0, (int) now()->diffInSeconds($group->expires_at, false));
                    @endphp

                    <!-- Clean Enterprise Compact Product Card (5 per row on desktop) -->
                    <div class="bg-white rounded-xl border {{ $needed === 1 ? 'border-amber-300 ring-1 ring-amber-300/30' : 'border-slate-200/90' }} shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between overflow-hidden group"
                         x-data="groupCountdown({{ $remainingSecs }})"
                         x-init="start()">
                        
                        <div>
                            <!-- Product Image Frame (Compact & Framed Inset) -->
                            <div class="p-2 pb-0">
                                <a href="{{ route('products.show', $product->slug) }}" class="block relative w-full h-32 sm:h-36 rounded-lg bg-slate-50 overflow-hidden border border-slate-100/80">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    
                                    <!-- Top Left: Category Tag -->
                                    <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 rounded text-[9px] font-semibold bg-white/95 text-slate-700 shadow-2xs truncate max-w-[65%]">
                                        {{ $cleanCat }}
                                    </span>

                                    <!-- Top Right: Discount Pill -->
                                    <span class="absolute top-1.5 right-1.5 px-1.5 py-0.5 rounded text-[9px] font-bold bg-rose-600 text-white shadow-2xs">
                                        -{{ $discountPct }}%
                                    </span>

                                    <!-- Bottom Overlay: Countdown Bar -->
                                    <div class="absolute bottom-1.5 left-1.5 right-1.5 flex items-center justify-between bg-slate-900/80 backdrop-blur-xs text-white px-1.5 py-0.5 rounded text-[9px] font-mono">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span x-text="timeString"></span>
                                        </div>
                                        <span class="text-slate-400 font-sans font-medium text-[8px] truncate max-w-[45px]">{{ $group->group_code }}</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Card Body -->
                            <div class="p-2.5 space-y-2">
                                <h3 class="text-xs font-semibold text-slate-900 line-clamp-2 leading-tight group-hover:text-[#53a318] transition-colors min-h-[2rem]">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                                </h3>

                                <!-- Compact Pricing Box -->
                                <div class="p-2 rounded-lg bg-slate-50 border border-slate-100 space-y-1">
                                    <div class="flex items-baseline justify-between text-[10px]">
                                        <span class="text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                                        <span class="text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1 py-0.2 rounded">
                                            Save ৳{{ number_format($product->single_price - $product->group_price) }}
                                        </span>
                                    </div>
                                    <div class="flex items-baseline justify-between">
                                        <span class="text-sm sm:text-base font-extrabold text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded {{ $needed === 1 ? 'bg-amber-100 text-amber-900' : 'bg-slate-200/70 text-slate-700' }}">
                                            {{ $needed === 1 ? '1 slot left' : $needed . ' slots' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-[10px]">
                                        <span class="text-slate-500 font-medium">{{ $group->current_members }}/{{ $group->required_members }} joined</span>
                                        <span class="text-slate-800 font-bold">{{ $pct }}%</span>
                                    </div>
                                    <div class="w-full h-1 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full bg-[#53a318] rounded-full transition-all" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="p-2.5 pt-0 flex items-center gap-1.5">
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="flex-1 py-1.5 px-2 rounded-lg bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-[11px] text-center transition-all shadow-2xs flex items-center justify-center space-x-1">
                                <span>Join Pool</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>

                            <button type="button" @click="openShare('{{ $group->group_code }}', '{{ addslashes($product->title) }}')" 
                                    title="Share Pool"
                                    class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors shrink-0 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </button>
                        </div>

                    </div>
                @empty
                    <!-- Clean Minimal Empty State (Zero Emojis) -->
                    <div class="col-span-full py-12 px-6 text-center bg-white rounded-xl border border-slate-200 text-slate-500 space-y-3">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">No active pools match your filters</h3>
                        <p class="text-[11px] text-slate-500 max-w-sm mx-auto">Try clearing one or more filters or explore all current group buys.</p>
                        <div class="pt-1">
                            <a href="{{ route('hot-deals.index') }}" 
                               class="inline-block py-1.5 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition-colors">
                                Reset All Filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pt-4 flex justify-center">
                {{ $hotGroups->links() }}
            </div>

        </main>

    </div>


    <!-- ========================================================
         4. MOBILE SLIDE-OUT FILTER DRAWER (FOLDABLE ACCORDIONS)
         ======================================================== -->
    <div x-show="mobileFilterOpen" x-cloak 
         class="fixed inset-0 z-50 flex justify-end bg-black/50 backdrop-blur-xs lg:hidden">
        <div @click.outside="mobileFilterOpen = false" 
             x-data="{
                 mobCategoryOpen: {{ ($selectedCategory && $selectedCategory !== 'all') ? 'true' : 'false' }},
                 mobPriceOpen: {{ ($pricePreset || request()->filled('min_price') || request()->filled('max_price')) ? 'true' : 'false' }},
                 mobStatusOpen: {{ ($filter && $filter !== 'all') ? 'true' : 'false' }},
                 mobDiscountOpen: {{ !empty($minDiscount) ? 'true' : 'false' }}
             }"
             class="w-full max-w-xs bg-white h-full overflow-y-auto p-5 shadow-2xl flex flex-col justify-between">
            
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Filters</h3>
                    </div>
                    <button @click="mobileFilterOpen = false" class="text-slate-400 hover:text-slate-700 text-lg font-bold p-1 cursor-pointer">&times;</button>
                </div>

                <!-- 1. Categories (Foldable) -->
                <div class="border-b border-slate-100 pb-3">
                    <button type="button" @click="mobCategoryOpen = !mobCategoryOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <span>Category</span>
                            @if($selectedCategory && $selectedCategory !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobCategoryOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobCategoryOpen" x-cloak class="pt-2 space-y-1 text-xs max-h-48 overflow-y-auto" style="scrollbar-width: thin;">
                        <a href="{{ request()->fullUrlWithQuery(['category' => 'all']) }}" 
                           class="block px-2.5 py-1.5 rounded-lg {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">
                            All Categories
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" 
                               class="flex items-center justify-between px-2.5 py-1.5 rounded-lg {{ $selectedCategory === $cat->slug ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">
                                <span class="truncate">{{ trim(preg_replace('/\(.*?\)/', '', $cat->name)) }}</span>
                                <span class="text-[10px] text-slate-400">{{ $cat->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Price Range (Foldable) -->
                <div class="border-b border-slate-100 pb-3">
                    <button type="button" @click="mobPriceOpen = !mobPriceOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <span>Price Range</span>
                            @if($pricePreset || request()->filled('min_price') || request()->filled('max_price'))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobPriceOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobPriceOpen" x-cloak class="pt-2 space-y-1 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => null, 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ empty($pricePreset) && !request()->filled('min_price') ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">All Prices</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => 'under_1000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === 'under_1000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">Under ৳1,000</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => '1000_3000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === '1000_3000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">৳1,000 – ৳3,000</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => '3000_7000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === '3000_7000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">৳3,000 – ৳7,000</a>
                        <a href="{{ request()->fullUrlWithQuery(['price_range' => 'above_7000', 'min_price' => null, 'max_price' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $pricePreset === 'above_7000' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">Above ৳7,000</a>
                    </div>
                </div>

                <!-- 3. Status (Foldable) -->
                <div class="border-b border-slate-100 pb-3">
                    <button type="button" @click="mobStatusOpen = !mobStatusOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <span>Pool Status</span>
                            @if($filter && $filter !== 'all')
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobStatusOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobStatusOpen" x-cloak class="pt-2 space-y-1 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" class="block px-2.5 py-1.5 rounded-lg {{ $filter === 'all' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">All Active</a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => '1_slot']) }}" class="block px-2.5 py-1.5 rounded-lg {{ $filter === '1_slot' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">1 Slot Remaining</a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'ending_today']) }}" class="block px-2.5 py-1.5 rounded-lg {{ $filter === 'ending_today' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">Ending Within 12 Hours</a>
                    </div>
                </div>

                <!-- 4. Discount (Foldable) -->
                <div>
                    <button type="button" @click="mobDiscountOpen = !mobDiscountOpen" 
                            class="w-full flex items-center justify-between text-left py-1 text-xs font-bold text-slate-800 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <span>Discount Tier</span>
                            @if(!empty($minDiscount))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#53a318]"></span>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="mobDiscountOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="mobDiscountOpen" x-cloak class="pt-2 space-y-1 text-xs">
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => null]) }}" class="block px-2.5 py-1.5 rounded-lg {{ empty($minDiscount) ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">Any Discount</a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 20]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $minDiscount == '20' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">20% and above</a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 30]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $minDiscount == '30' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">30% and above</a>
                        <a href="{{ request()->fullUrlWithQuery(['min_discount' => 40]) }}" class="block px-2.5 py-1.5 rounded-lg {{ $minDiscount == '40' ? 'bg-emerald-50 text-[#53a318] font-bold' : 'text-slate-600' }}">40% and above</a>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
                <a href="{{ route('hot-deals.index') }}" class="flex-1 py-2 text-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                    Reset
                </a>
                <button type="button" @click="mobileFilterOpen = false" class="flex-1 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition-colors cursor-pointer">
                    Close
                </button>
            </div>

        </div>
    </div>


    <!-- ========================================================
         5. SHARE MODAL (ALPINE.JS, CLEAN NO EMOJIS)
         ======================================================== -->
    <div x-show="shareModalOpen" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
        <div @click.outside="shareModalOpen = false" 
             class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4 border border-slate-100">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Share Buying Pool</h3>
                <button @click="shareModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <div>
                <p class="text-xs text-slate-600 font-medium" x-text="shareGroupTitle"></p>
                <div class="flex items-center space-x-2 mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="font-mono text-xs font-semibold text-slate-800 flex-1 truncate" x-text="window.location.origin + '/group-buy/' + shareGroupCode"></span>
                    <button type="button" @click="copyShareLink(shareGroupCode)" 
                            class="px-3 py-1.5 rounded-lg bg-[#53a318] hover:bg-[#468c13] text-white text-xs font-semibold transition-all">
                        <span x-text="copiedToast ? 'Copied' : 'Copy'">Copy</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 text-xs font-semibold pt-1">
                <a :href="'https://wa.me/?text=' + encodeURIComponent('Join our Cartiva group buy pool: ' + window.location.origin + '/group-buy/' + shareGroupCode)" 
                   target="_blank" class="py-2.5 px-3 rounded-xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 text-center transition-colors">
                    WhatsApp
                </a>
                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.origin + '/group-buy/' + shareGroupCode)" 
                   target="_blank" class="py-2.5 px-3 rounded-xl bg-blue-50 text-blue-800 hover:bg-blue-100 text-center transition-colors">
                    Facebook
                </a>
            </div>

        </div>
    </div>

</div>

<!-- Alpine Countdown Helper -->
<script>
    function groupCountdown(initialSeconds) {
        return {
            secondsRemaining: initialSeconds,
            timeString: '00:00:00',
            timerInterval: null,
            start() {
                this.updateTimeString();
                this.timerInterval = setInterval(() => {
                    if (this.secondsRemaining > 0) {
                        this.secondsRemaining--;
                        this.updateTimeString();
                    } else {
                        clearInterval(this.timerInterval);
                        this.timeString = 'Expired';
                    }
                }, 1000);
            },
            updateTimeString() {
                const h = Math.floor(this.secondsRemaining / 3600);
                const m = Math.floor((this.secondsRemaining % 3600) / 60);
                const s = this.secondsRemaining % 60;
                this.timeString = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
            }
        };
    }
</script>
@endsection
