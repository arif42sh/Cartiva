@extends('layouts.app')

@section('title', '⚡ Flash Rush Sales • Up to 70% Clearance Deals | Cartiva')

@section('content')
<div class="max-w-[1680px] w-full mx-auto px-3 sm:px-5 lg:px-6 py-4 sm:py-6 space-y-6 antialiased" id="flash-sales-app">

    <!-- ========================================================
         1. BREADCRUMB & LIVE BADGE
         ======================================================== -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center space-x-1.5 text-xs font-semibold text-slate-700 hover:text-amber-600 bg-white border border-slate-200 hover:border-amber-400 px-3 py-1.5 rounded-xl transition-all shadow-2xs group">
                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-amber-600 group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Home</span>
            </a>

            <nav class="hidden sm:flex items-center space-x-2 text-xs font-medium text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-slate-800 transition-colors">Home</a>
                <span>/</span>
                <span class="text-amber-600 font-bold flex items-center space-x-1">
                    <span>⚡</span>
                    <span>Flash Sales</span>
                </span>
            </nav>
        </div>

        <div class="flex items-center space-x-2">
            <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-700 text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                <span class="w-2 h-2 rounded-full bg-amber-500 -ml-3.5"></span>
                <span>Active 4-Hour Rush Window</span>
            </span>
        </div>
    </div>


    <!-- ========================================================
         2. HERO RUSH HEADER & LIVE COUNTDOWN (FOMO BAR)
         ======================================================== -->
    <section class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-slate-950 via-[#0a192f] to-[#040c18] border border-blue-900/40 p-6 sm:p-8 lg:p-10 text-white shadow-2xl">
        <!-- Ambient Radial Glow Mesh -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Geometric Wireframe Overlay -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            
            <!-- Left Info Column -->
            <div class="space-y-4 max-w-2xl">
                <!-- Urgency Tag -->
                <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-amber-500/20 via-orange-500/20 to-rose-500/20 border border-amber-400/30 text-amber-300 text-[11px] font-black uppercase tracking-wider shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    <span>⚡ FLASH RUSH • UP TO 70% CLEARANCE</span>
                </div>

                <div class="space-y-2">
                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight bg-gradient-to-r from-white via-slate-100 to-amber-200 bg-clip-text text-transparent">
                        Lightning Deals & Deep Factory Drops
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                        Limited inventory drops refreshed every 4 hours. Prices revert once stock or timer hits 0. Combine with Cartiva Group Buying for an additional wholesale kickback!
                    </p>
                </div>

                <!-- Trust Micro-Pills -->
                <div class="flex flex-wrap items-center gap-2 pt-2 text-[11px] font-bold text-slate-300">
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-white/10 border border-white/10">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        <span>100% Authentic Guaranteed</span>
                    </span>
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-white/10 border border-white/10">
                        <svg class="w-3.5 h-3.5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path></svg>
                        <span>Fast Express Dispatch</span>
                    </span>
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-white/10 border border-white/10 text-amber-300">
                        <span>⚡ Max 2 Units Per Customer</span>
                    </span>
                </div>
            </div>

            <!-- Right Countdown Clock Module -->
            <div class="flex-shrink-0 bg-slate-900/90 border border-amber-500/30 rounded-3xl p-5 sm:p-6 backdrop-blur-xl shadow-2xl space-y-4">
                <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-3">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                        <span class="text-xs font-black uppercase tracking-wider text-rose-400">Current Drop Ends In:</span>
                    </div>
                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold">
                        Slot 02:00 PM
                    </span>
                </div>

                <!-- Digital Flip Tiles (Vanilla JS Target) -->
                <div class="flex items-center space-x-2 sm:space-x-3 text-center" id="countdown-tiles">
                    <!-- Hours -->
                    <div class="bg-gradient-to-b from-slate-800 to-slate-900 border border-white/15 rounded-2xl p-2.5 sm:p-3.5 min-w-[65px] sm:min-w-[78px] shadow-inner">
                        <span id="countdown-hours" class="block text-2xl sm:text-4xl font-black text-amber-400 font-mono tracking-tight">03</span>
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Hours</span>
                    </div>

                    <span class="text-2xl sm:text-3xl font-black text-amber-400/80 animate-pulse">:</span>

                    <!-- Minutes -->
                    <div class="bg-gradient-to-b from-slate-800 to-slate-900 border border-white/15 rounded-2xl p-2.5 sm:p-3.5 min-w-[65px] sm:min-w-[78px] shadow-inner">
                        <span id="countdown-minutes" class="block text-2xl sm:text-4xl font-black text-amber-400 font-mono tracking-tight">42</span>
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Minutes</span>
                    </div>

                    <span class="text-2xl sm:text-3xl font-black text-amber-400/80 animate-pulse">:</span>

                    <!-- Seconds -->
                    <div class="bg-gradient-to-b from-slate-800 to-slate-900 border border-white/15 rounded-2xl p-2.5 sm:p-3.5 min-w-[65px] sm:min-w-[78px] shadow-inner">
                        <span id="countdown-seconds" class="block text-2xl sm:text-4xl font-black text-rose-400 font-mono tracking-tight">18</span>
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Seconds</span>
                    </div>
                </div>

                <!-- Bottom Ticker Line -->
                <div class="flex items-center justify-between text-[11px] text-slate-400 font-medium pt-1">
                    <span>⚡ 1,420 items claimed</span>
                    <span class="text-amber-300 font-bold">Stock burning fast</span>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================
         3. TIME-SLOT SCHEDULING TABS (STICKY / HORIZONTAL SCROLL)
         ======================================================== -->
    <div class="sticky top-0 sm:top-16 z-30 bg-[#f8f9fa]/95 backdrop-blur-md py-3 -mx-3 sm:-mx-5 lg:-mx-6 px-3 sm:px-5 lg:px-6 border-b border-slate-200/80 shadow-xs">
        <div class="max-w-[1680px] mx-auto flex items-center justify-between gap-4 overflow-x-auto no-scrollbar">
            
            <div class="flex items-center space-x-2 sm:space-x-3 flex-shrink-0" id="slot-tabs-container">
                @foreach($timeSlots as $slot)
                    <button type="button" 
                            data-slot-id="{{ $slot['id'] }}"
                            class="slot-tab-btn px-4 sm:px-6 py-2.5 sm:py-3 rounded-2xl font-bold transition-all flex items-center space-x-3 cursor-pointer text-left border relative overflow-hidden group
                            {{ $slot['id'] === $selectedSlot ? 'active-slot bg-gradient-to-r from-slate-900 to-slate-800 text-white border-amber-500 shadow-md ring-2 ring-amber-500/30' : ($slot['is_ended'] ? 'bg-slate-100 text-slate-400 border-slate-200 opacity-60 hover:opacity-90' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300 hover:bg-slate-50') }}">
                        
                        <!-- Glowing Dot for Live Slot -->
                        @if($slot['is_live'])
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                            </span>
                        @elseif($slot['is_ended'])
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        @endif

                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-sm sm:text-base font-black tracking-tight slot-time-text">{{ $slot['time'] }}</span>
                                <span class="text-[10px] font-black uppercase px-1.5 py-0.2 rounded {{ $slot['is_live'] ? 'bg-amber-500 text-slate-950' : ($slot['is_ended'] ? 'bg-slate-200 text-slate-500' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $slot['badge'] }}
                                </span>
                            </div>
                            <span class="text-[11px] block font-medium opacity-80 slot-subtext">{{ $slot['subtext'] }}</span>
                        </div>
                    </button>
                @endforeach
            </div>

            <!-- Fast Timezone Note -->
            <div class="hidden xl:flex items-center space-x-2 text-xs font-semibold text-slate-500 flex-shrink-0">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Dhaka (GMT+6) Auto-Sync</span>
            </div>

        </div>
    </div>


    <!-- ========================================================
         4. CATEGORY & FILTER PILLS
         ======================================================== -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pt-1">
        <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-1" id="filter-pills-container">
            <span class="text-xs font-black text-slate-400 uppercase tracking-wider flex-shrink-0 mr-1">Filter Deals:</span>

            <button type="button" data-filter="all" 
                    class="filter-pill-btn active px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 flex-shrink-0 bg-slate-900 text-white shadow-xs cursor-pointer">
                <span>⚡ All Flash Deals</span>
                <span class="text-[10px] px-1.5 py-0.2 bg-white/20 rounded-full font-black count-badge">{{ count($enrichedDeals) }}</span>
            </button>

            <button type="button" data-filter="deep_discount" 
                    class="filter-pill-btn px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 flex-shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-amber-400 cursor-pointer">
                <span>🔥 50%+ Flat Off</span>
            </button>

            <button type="button" data-filter="under_999" 
                    class="filter-pill-btn px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 flex-shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-emerald-400 cursor-pointer">
                <span>🏷️ Under ৳999</span>
            </button>

            <button type="button" data-filter="almost_sold" 
                    class="filter-pill-btn px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 flex-shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-rose-400 cursor-pointer">
                <span>⚡ Almost Sold Out</span>
            </button>

            <button type="button" data-filter="gadgets" 
                    class="filter-pill-btn px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 flex-shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-blue-400 cursor-pointer">
                <span>🎧 Gadgets & Audio</span>
            </button>

            <button type="button" data-filter="apparel" 
                    class="filter-pill-btn px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 flex-shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-purple-400 cursor-pointer">
                <span>🧥 Campus Apparel</span>
            </button>
        </div>

        <!-- Slot Description Banner -->
        <div class="text-xs font-medium text-slate-500 flex items-center space-x-1.5 flex-shrink-0" id="slot-status-info">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span id="slot-status-text">Showing <strong class="text-slate-800">Live Rush</strong> products eligible for instant checkout</span>
        </div>
    </div>


    <!-- ========================================================
         5. HIGH-CONVERSION FLASH DEAL CARDS GRID
         ======================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 transition-all duration-300" id="flash-deals-grid">
        @forelse($enrichedDeals as $deal)
            @php
                $isEnded = ($deal['slot_id'] === 'ended');
                $isUpcoming = in_array($deal['slot_id'], ['upcoming_1', 'upcoming_2']);
            @endphp
            <div class="deal-card bg-white rounded-3xl border border-slate-200/90 shadow-2xs hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden group relative"
                 data-slot="{{ $deal['slot_id'] }}"
                 data-category="{{ $deal['category_slug'] }}"
                 data-deep-discount="{{ $deal['is_deep_discount'] ? 'true' : 'false' }}"
                 data-under-999="{{ $deal['is_under_999'] ? 'true' : 'false' }}"
                 data-almost-sold="{{ $deal['is_almost_sold_out'] ? 'true' : 'false' }}">
                
                <div>
                    <!-- Product Visual & Aspect-Ratio Container -->
                    <div class="relative w-full aspect-square bg-slate-100 overflow-hidden">
                        <img src="{{ $deal['image_url'] }}" 
                             alt="{{ $deal['title'] }}" 
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500 {{ $isEnded ? 'grayscale' : '' }}">

                        <!-- Gradient Vignette at Top for Badge Contrast -->
                        <div class="absolute inset-x-0 top-0 h-16 bg-gradient-to-b from-black/50 to-transparent pointer-events-none"></div>

                        <!-- Top-Left: Discount Tag Pill -->
                        <div class="absolute top-3 left-3 z-10 flex items-center space-x-1 px-2.5 py-1 rounded-xl text-[10px] font-black bg-gradient-to-r from-amber-500 to-rose-600 text-white shadow-md">
                            <span>⚡ -{{ $deal['discount_percent'] }}% OFF</span>
                        </div>

                        <!-- Top-Right: Stock Urgency Pill -->
                        <div class="absolute top-3 right-3 z-10">
                            @if($isEnded)
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black bg-slate-900/90 text-slate-300 backdrop-blur-md shadow-xs">
                                    Sold Out
                                </span>
                            @elseif($isUpcoming)
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black bg-blue-600 text-white backdrop-blur-md shadow-xs">
                                    ⏰ Drop: {{ $deal['unlock_time'] }}
                                </span>
                            @elseif($deal['is_almost_sold_out'])
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black bg-rose-600 text-white shadow-md animate-pulse">
                                    🔥 Only {{ $deal['stock_left'] }} left!
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold bg-white/95 text-slate-800 backdrop-blur-md shadow-xs">
                                    ⚡ Limited Stock
                                </span>
                            @endif
                        </div>

                        <!-- Bottom-Left Rating & Social Proof -->
                        <div class="absolute bottom-3 left-3 z-10 flex items-center space-x-1.5 bg-slate-950/75 backdrop-blur-md text-white px-2.5 py-1 rounded-xl text-[10px] font-bold">
                            <span class="text-amber-400">★</span>
                            <span>{{ number_format($deal['rating'], 1) }}</span>
                            <span class="text-slate-400">|</span>
                            <span class="text-slate-300 font-normal">({{ $deal['claimed_count'] }}+ claimed)</span>
                        </div>

                        <!-- Upcoming Blurred Veil Indicator (for upcoming slots) -->
                        <div class="upcoming-overlay absolute inset-0 bg-slate-950/40 backdrop-blur-[2px] flex items-center justify-center p-4 transition-opacity {{ $isUpcoming ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }}">
                            <div class="bg-white/95 backdrop-blur-md text-slate-900 px-4 py-2 rounded-2xl text-center shadow-xl space-y-0.5 border border-white/40">
                                <span class="text-[10px] uppercase font-black tracking-wider text-blue-600 block">Upcoming Drop</span>
                                <span class="text-xs font-black block">Unlocks at {{ $deal['unlock_time'] }}</span>
                            </div>
                        </div>

                    </div>

                    <!-- Card Body -->
                    <div class="p-4 sm:p-5 space-y-3.5">
                        
                        <!-- Category Subtext -->
                        <div class="flex items-center justify-between text-[11px] font-bold text-slate-400">
                            <span class="uppercase tracking-wider truncate max-w-[150px]">{{ $deal['category_name'] }}</span>
                            <span class="text-emerald-700 font-extrabold bg-emerald-50 px-2 py-0.5 rounded-md">Save ৳{{ number_format($deal['savings_amount']) }}</span>
                        </div>

                        <!-- Product Title -->
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('products.show', $deal['slug']) }}">
                                {{ $deal['title'] }}
                            </a>
                        </h3>

                        <!-- Dual Price Anchor Box -->
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100/80 space-y-1">
                            <div class="flex items-baseline justify-between text-[11px]">
                                <span class="text-slate-400">Regular: <span class="line-through font-semibold">৳{{ number_format($deal['single_price']) }}</span></span>
                                <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-1.5 py-0.2 rounded">Flash Drop</span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <div>
                                    <span class="text-xl sm:text-2xl font-black text-emerald-800 tracking-tight">৳{{ number_format($deal['flash_price']) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] uppercase font-bold text-slate-400 block">Unit Deal</span>
                                    <span class="text-[11px] font-black text-slate-600">Special Net Rate</span>
                                </div>
                            </div>
                        </div>

                        <!-- Urgency Stock Progress Bar -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-[11px] font-bold">
                                @if($isEnded)
                                    <span class="text-slate-500">Inventory Exhausted</span>
                                    <span class="text-slate-400">100% Claimed</span>
                                @elseif($isUpcoming)
                                    <span class="text-blue-700">Pre-launch Reserved</span>
                                    <span class="text-blue-600 font-black">Ready to Unlock</span>
                                @else
                                    <span class="text-rose-600 flex items-center space-x-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span>
                                        <span>Only {{ $deal['stock_left'] }} items remaining!</span>
                                    </span>
                                    <span class="text-amber-700 font-black">{{ $deal['claimed_percent'] }}% Claimed</span>
                                @endif
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                @if($isEnded)
                                    <div class="h-full bg-slate-300 rounded-full" style="width: 100%"></div>
                                @elseif($isUpcoming)
                                    <div class="h-full bg-blue-500 rounded-full" style="width: 30%"></div>
                                @else
                                    <div class="h-full bg-gradient-to-r from-amber-400 via-orange-500 to-rose-600 rounded-full transition-all duration-500" 
                                         style="width: {{ $deal['claimed_percent'] }}%"></div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Card Bottom Actions & CTAs -->
                <div class="p-4 sm:p-5 pt-0 space-y-2">
                    
                    @if($isEnded)
                        <button type="button" disabled 
                                class="w-full py-2.5 px-4 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs text-center cursor-not-allowed">
                            Drop Concluded
                        </button>
                    @elseif($isUpcoming)
                        <!-- Upcoming Remind Me Button -->
                        <button type="button" 
                                class="remind-me-btn w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center justify-center space-x-2 transition-all shadow-md active:scale-95 cursor-pointer"
                                data-product-title="{{ $deal['title'] }}"
                                data-unlock-time="{{ $deal['unlock_time'] }}">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="btn-label">🔔 Remind Me ({{ $deal['unlock_time'] }})</span>
                        </button>
                    @else
                        <!-- Direct Buyer Flash Deal CTA -->
                        <a href="{{ route('products.show', $deal['slug']) }}" 
                           class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-600 hover:from-amber-600 hover:to-rose-700 text-white font-black text-xs text-center shadow-md shadow-orange-950/20 hover:shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center space-x-1.5">
                            <span>⚡ Grab Flash Deal</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif

                    <!-- Cartiva Collective Buying Secondary Hook -->
                    <a href="{{ route('products.show', $deal['slug']) }}" 
                       class="w-full py-1.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-bold text-center border border-emerald-200/70 transition-all flex items-center justify-center space-x-1.5 group/pool">
                        <svg class="w-3.5 h-3.5 text-emerald-600 group-hover/pool:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Team Pool: Extra -৳{{ number_format($deal['pool_extra_savings']) }} Save</span>
                    </a>

                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center space-y-4 bg-white rounded-3xl border border-slate-200 p-8">
                <div class="w-16 h-16 mx-auto rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-2xl font-black">
                    ⚡
                </div>
                <h3 class="text-lg font-black text-slate-800">No Flash Deals Found</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    There are no live products matching your selected criteria. Check back in the next scheduled flash slot or browse regular group pools.
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800">
                    <span>Back to Catalog</span>
                </a>
            </div>
        @endforelse
    </div>


    <!-- ========================================================
         6. FLASH RULES & BUYER SATISFACTION BANNER
         ======================================================== -->
    <section class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-700 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/10 pb-5">
            <div>
                <h2 class="text-lg sm:text-xl font-black tracking-tight text-white flex items-center space-x-2">
                    <span class="text-amber-400">🛡️</span>
                    <span>Cartiva Flash Sale Rules & Buyer Guarantee</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Ensuring fair access and verified wholesale rates for genuine university and community shoppers.
                </p>
            </div>
            <a href="{{ route('home') }}#how-it-works" class="inline-flex items-center space-x-1 text-xs font-bold text-amber-400 hover:text-amber-300">
                <span>View Full Policy</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 text-xs">
            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-2">
                <span class="text-lg">⚡</span>
                <h4 class="font-black text-white text-sm">Strict Quantity Limits</h4>
                <p class="text-slate-400 leading-relaxed text-[11px]">
                    To avoid scalpers and re-sellers, each verified customer account is limited to maximum 2 items per flash drop.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-2">
                <span class="text-lg">⏱️</span>
                <h4 class="font-black text-white text-sm">15-Min Cart Hold</h4>
                <p class="text-slate-400 leading-relaxed text-[11px]">
                    Once you enter checkout with a flash deal, inventory is temporarily reserved for 15 minutes to finalize payment.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-2">
                <span class="text-lg">🚚</span>
                <h4 class="font-black text-white text-sm">24-Hour Express Hub</h4>
                <p class="text-slate-400 leading-relaxed text-[11px]">
                    All flash deal parcels leave the central merchant warehouse via prioritized express dispatch within 24 hours.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-2">
                <span class="text-lg">🔄</span>
                <h4 class="font-black text-white text-sm">7-Day Free Replacement</h4>
                <p class="text-slate-400 leading-relaxed text-[11px]">
                    Received a defective unit? Hassle-free immediate refund or replacement under Cartiva's Buyer Shield guarantee.
                </p>
            </div>
        </div>
    </section>

</div>


<!-- ========================================================
     7. FLOATING TOAST NOTIFICATION CONTAINER
     ======================================================== -->
<div id="flash-toast" 
     class="fixed bottom-5 right-5 z-50 transform translate-y-24 opacity-0 transition-all duration-300 max-w-sm w-full bg-slate-900 border border-slate-700 text-white rounded-2xl p-4 shadow-2xl flex items-start space-x-3 pointer-events-none">
    <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0 text-base font-black">
        🔔
    </div>
    <div class="flex-1 space-y-0.5">
        <h5 class="text-xs font-black text-white" id="flash-toast-title">Reminder Activated!</h5>
        <p class="text-[11px] text-slate-300 leading-relaxed" id="flash-toast-msg">
            You'll receive an instant notification 5 minutes before this drop unlocks.
        </p>
    </div>
    <button type="button" id="flash-toast-close" class="text-slate-400 hover:text-white p-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>


<!-- ========================================================
     8. VANILLA JAVASCRIPT CONTROLLERS & ENGINE
     ======================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    /* ----------------------------------------------------
       A. HIGH-PRECISION REAL-TIME COUNTDOWN TIMER
       ---------------------------------------------------- */
    (function initCountdown() {
        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const secondsEl = document.getElementById('countdown-seconds');

        if (!hoursEl || !minutesEl || !secondsEl) return;

        // Deadline set to 3 hours 42 minutes 18 seconds
        let totalSeconds = (3 * 3600) + (42 * 60) + 18;

        function updateTimer() {
            if (totalSeconds <= 0) {
                totalSeconds = 4 * 3600; // Auto-cycle
            }

            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;

            hoursEl.textContent = String(h).padStart(2, '0');
            minutesEl.textContent = String(m).padStart(2, '0');
            secondsEl.textContent = String(s).padStart(2, '0');

            totalSeconds--;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    })();


    /* ----------------------------------------------------
       B. INTERACTIVE TIME-SLOT TABS SWITCHER
       ---------------------------------------------------- */
    const slotButtons = document.querySelectorAll('.slot-tab-btn');
    const dealCards = document.querySelectorAll('.deal-card');
    const slotStatusText = document.getElementById('slot-status-text');

    let currentSlot = 'live';

    slotButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const slotId = this.getAttribute('data-slot-id');
            currentSlot = slotId;

            // 1. Update Tab Styles
            slotButtons.forEach(b => {
                b.classList.remove('active-slot', 'bg-gradient-to-r', 'from-slate-900', 'to-slate-800', 'text-white', 'border-amber-500', 'shadow-md', 'ring-2', 'ring-amber-500/30');
                if (b.getAttribute('data-slot-id') === 'ended') {
                    b.className = 'slot-tab-btn px-4 sm:px-6 py-2.5 sm:py-3 rounded-2xl font-bold transition-all flex items-center space-x-3 cursor-pointer text-left border relative overflow-hidden group bg-slate-100 text-slate-400 border-slate-200 opacity-60 hover:opacity-90';
                } else {
                    b.className = 'slot-tab-btn px-4 sm:px-6 py-2.5 sm:py-3 rounded-2xl font-bold transition-all flex items-center space-x-3 cursor-pointer text-left border relative overflow-hidden group bg-white text-slate-700 border-slate-200 hover:border-slate-300 hover:bg-slate-50';
                }
            });

            this.className = 'slot-tab-btn active-slot px-4 sm:px-6 py-2.5 sm:py-3 rounded-2xl font-bold transition-all flex items-center space-x-3 cursor-pointer text-left border relative overflow-hidden group bg-gradient-to-r from-slate-900 to-slate-800 text-white border-amber-500 shadow-md ring-2 ring-amber-500/30';

            // 2. Update status info text
            if (slotStatusText) {
                if (slotId === 'live') {
                    slotStatusText.innerHTML = 'Showing <strong class="text-slate-800">Live Rush</strong> products eligible for instant checkout';
                } else if (slotId === 'ended') {
                    slotStatusText.innerHTML = 'Viewing <strong class="text-slate-800">Past Concluded Drops</strong> (Archive & Price History)';
                } else if (slotId === 'upcoming_1') {
                    slotStatusText.innerHTML = 'Previewing <strong class="text-blue-700">06:00 PM Upcoming Drop</strong> — Set alerts before inventory goes live';
                } else if (slotId === 'upcoming_2') {
                    slotStatusText.innerHTML = 'Previewing <strong class="text-indigo-700">10:00 PM Midnight Drop</strong> — Exclusive nocturnal factory discounts';
                }
            }

            // 3. Filter Cards with subtle fade
            applyFilters();
        });
    });


    /* ----------------------------------------------------
       C. CATEGORY & SMART PILLS FILTERING
       ---------------------------------------------------- */
    const filterPills = document.querySelectorAll('.filter-pill-btn');
    let currentFilter = 'all';

    filterPills.forEach(pill => {
        pill.addEventListener('click', function () {
            filterPills.forEach(p => {
                p.classList.remove('bg-slate-900', 'text-white', 'shadow-xs');
                p.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            });

            this.classList.remove('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            this.classList.add('bg-slate-900', 'text-white', 'shadow-xs');

            currentFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    function applyFilters() {
        let visibleCount = 0;

        dealCards.forEach(card => {
            const cardSlot = card.getAttribute('data-slot');
            const cardCategory = card.getAttribute('data-category');
            const isDeepDiscount = card.getAttribute('data-deep-discount') === 'true';
            const isUnder999 = card.getAttribute('data-under-999') === 'true';
            const isAlmostSold = card.getAttribute('data-almost-sold') === 'true';

            // Slot Matching
            const matchesSlot = (cardSlot === currentSlot);

            // Filter Matching
            let matchesFilter = false;
            if (currentFilter === 'all') {
                matchesFilter = true;
            } else if (currentFilter === 'deep_discount' && isDeepDiscount) {
                matchesFilter = true;
            } else if (currentFilter === 'under_999' && isUnder999) {
                matchesFilter = true;
            } else if (currentFilter === 'almost_sold' && isAlmostSold) {
                matchesFilter = true;
            } else if (currentFilter === 'gadgets' && (cardCategory.includes('tech') || cardCategory.includes('audio') || cardCategory.includes('gadgets'))) {
                matchesFilter = true;
            } else if (currentFilter === 'apparel' && (cardCategory.includes('winter') || cardCategory.includes('apparel') || cardCategory.includes('fashion'))) {
                matchesFilter = true;
            }

            if (matchesSlot && matchesFilter) {
                card.style.display = 'flex';
                card.style.opacity = '1';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update count badge
        const activeCountBadge = document.querySelector('.filter-pill-btn.bg-slate-900 .count-badge');
        if (activeCountBadge && currentFilter === 'all') {
            activeCountBadge.textContent = visibleCount;
        }
    }

    // Initial filter run
    applyFilters();


    /* ----------------------------------------------------
       D. "REMIND ME" INTERACTIVE TOAST TRIGGER
       ---------------------------------------------------- */
    const toast = document.getElementById('flash-toast');
    const toastTitle = document.getElementById('flash-toast-title');
    const toastMsg = document.getElementById('flash-toast-msg');
    const toastClose = document.getElementById('flash-toast-close');
    let toastTimeout = null;

    function showToast(title, msg) {
        if (!toast) return;
        toastTitle.textContent = title;
        toastMsg.textContent = msg;

        toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');

        if (toastTimeout) clearTimeout(toastTimeout);
        toastTimeout = setTimeout(hideToast, 4000);
    }

    function hideToast() {
        if (!toast) return;
        toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
        toast.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
    }

    if (toastClose) {
        toastClose.addEventListener('click', hideToast);
    }

    document.querySelectorAll('.remind-me-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const productTitle = this.getAttribute('data-product-title') || 'This Flash Deal';
            const unlockTime = this.getAttribute('data-unlock-time') || 'scheduled drop';

            // Visual button transformation
            this.classList.remove('bg-slate-900', 'hover:bg-slate-800');
            this.classList.add('bg-emerald-600', 'text-white');
            this.innerHTML = `
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                <span>✓ Reminder Active</span>
            `;

            showToast(
                '⚡ Alert Activated!', 
                `We will alert you 5 minutes before "${productTitle.substring(0, 32)}..." unlocks at ${unlockTime}.`
            );
        });
    });

});
</script>
@endsection
