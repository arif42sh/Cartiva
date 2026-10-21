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
         5. COMPACT FLASH DEAL CARDS (5 PER ROW ON DESKTOP - HOT DEALS FORMAT)
         ======================================================== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-3 sm:gap-3.5 lg:gap-4 transition-all duration-300" id="flash-deals-grid">
        @forelse($enrichedDeals as $deal)
            @php
                $isEnded = ($deal['slot_id'] === 'ended');
                $isUpcoming = in_array($deal['slot_id'], ['upcoming_1', 'upcoming_2']);
                $isAlmostSold = ($deal['is_almost_sold_out'] ?? false) || ($deal['stock_left'] <= 2);
            @endphp
            <div class="deal-card bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-lg hover:border-[#53a318] hover:-translate-y-1 transition-all duration-300 p-3 sm:p-3.5 flex flex-col justify-between relative group overflow-hidden"
                 data-slot="{{ $deal['slot_id'] }}"
                 data-category="{{ $deal['category_slug'] }}"
                 data-deep-discount="{{ $deal['is_deep_discount'] ? 'true' : 'false' }}"
                 data-under-999="{{ $deal['is_under_999'] ? 'true' : 'false' }}"
                 data-almost-sold="{{ $deal['is_almost_sold_out'] ? 'true' : 'false' }}">
                
                <div class="space-y-2.5 relative z-10">
                    
                    <!-- Top Urgency Pill & Monospace Digital Timer -->
                    <div class="flex items-center justify-between gap-1.5">
                        @if($isEnded)
                            <span class="px-2 py-0.5 rounded-lg bg-slate-800 text-slate-200 text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                <span>স্টক শেষ</span>
                            </span>
                        @elseif($isUpcoming)
                            <span class="px-2 py-0.5 rounded-lg bg-blue-600 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                <span>⏰ {{ $deal['unlock_time'] }}</span>
                            </span>
                        @elseif($isAlmostSold)
                            <span class="px-2 py-0.5 rounded-lg bg-rose-600 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                <span>🔥 ১টি স্লট বাকি!</span>
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-lg bg-rose-600 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                <span>🔥 {{ $deal['stock_left'] }}টি স্লট বাকি</span>
                            </span>
                        @endif

                        <!-- Digital Monospace Countdown Timer -->
                        <span class="inline-flex items-center space-x-1 font-mono text-[10px] font-black text-rose-700 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-200/80 shrink-0">
                            <svg class="w-3 h-3 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="card-countdown-ticker" data-seconds="{{ $deal['remaining_secs'] ?? 9200 }}">02:31:24</span>
                        </span>
                    </div>

                    <!-- Product Thumbnail with Fixed Compact Height (h-32 sm:h-36) -->
                    <a href="{{ route('products.show', $deal['slug']) }}" class="block relative w-full h-32 sm:h-36 rounded-xl overflow-hidden bg-slate-100 group/img shadow-inner">
                        <img src="{{ $deal['image_url'] }}" 
                             alt="{{ $deal['title'] }}" 
                             loading="lazy"
                             class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300 {{ $isEnded ? 'grayscale' : '' }}">
                        
                        <!-- Top Left: Discount Tag -->
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[9px] font-black bg-rose-600 text-white shadow-2xs tracking-tight">
                            -{{ $deal['discount_percent'] }}%
                        </span>

                        <!-- Bottom Right: Room Code Pill -->
                        <span class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded text-[8px] font-mono font-bold bg-slate-950/80 text-emerald-300 backdrop-blur-xs">
                            {{ $deal['room_code'] ?? 'GRP-DEAL' }}
                        </span>

                        <!-- Bottom Left: Low Stock Alert Badge -->
                        @if(!$isEnded && !$isUpcoming)
                            <span class="absolute bottom-2 left-2 px-1.5 py-0.5 rounded text-[8px] font-bold bg-amber-400 text-slate-950 shadow-2xs">
                                স্টক সীমিত
                            </span>
                        @elseif($isUpcoming)
                            <span class="absolute bottom-2 left-2 px-1.5 py-0.5 rounded text-[8px] font-bold bg-blue-500 text-white shadow-2xs">
                                শীঘ্রই আসছে
                            </span>
                        @endif
                    </a>

                    <!-- Product Title & Category -->
                    <div class="space-y-0.5">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-[#53a318] block truncate">
                            {{ $deal['category_name'] }}
                        </span>

                        <h3 class="text-xs font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors min-h-[2rem]">
                            <a href="{{ route('products.show', $deal['slug']) }}">
                                {{ $deal['title'] }}
                            </a>
                        </h3>
                        
                        <!-- Pricing & Savings Comparison -->
                        <div class="pt-1 flex items-baseline justify-between flex-wrap gap-1">
                            <div class="flex items-baseline space-x-1.5">
                                <span class="text-base font-black text-[#53a318]">৳{{ number_format($deal['flash_price']) }}</span>
                                <span class="text-[11px] text-slate-400 line-through">৳{{ number_format($deal['single_price']) }}</span>
                            </div>
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-[#53a318] border border-emerald-200/80">
                                সাশ্রয় ৳{{ number_format($deal['savings_amount']) }}
                            </span>
                        </div>
                    </div>

                    <!-- Social Proof: Avatar Stack + Member Slots -->
                    <div class="pt-1 border-t border-slate-100 flex items-center justify-between text-[10px]">
                        <div class="flex items-center -space-x-1 overflow-hidden">
                            @php
                                $avatarChars = ['F', 'A', 'S', 'M', 'R'];
                                $char1 = $avatarChars[($deal['id'] * 2) % 5];
                                $char2 = $avatarChars[($deal['id'] * 3 + 1) % 5];
                            @endphp
                            <div class="w-5 h-5 rounded-full bg-slate-800 text-white border border-white flex items-center justify-center text-[8px] font-bold">
                                {{ $char1 }}
                            </div>
                            @if(($deal['joined_count'] ?? 1) >= 2)
                                <div class="w-5 h-5 rounded-full bg-slate-700 text-white border border-white flex items-center justify-center text-[8px] font-bold">
                                    {{ $char2 }}
                                </div>
                            @endif
                            <!-- Pulsing Empty Slot -->
                            @if(!$isEnded)
                                <div class="w-5 h-5 rounded-full border border-dashed border-rose-400 bg-rose-50 text-rose-600 flex items-center justify-center text-[8px] font-black animate-pulse" 
                                     title="শেষ স্লটটিতে যোগ দিন!">
                                    +১
                                </div>
                            @endif
                        </div>
                        <span class="text-[10px] font-bold text-slate-500">
                            @if($isEnded)
                                ফুলফিল্ড
                            @else
                                {{ $deal['joined_count'] ?? 1 }}/{{ $deal['required_count'] ?? 2 }} যুক্ত
                            @endif
                        </span>
                    </div>

                    <!-- Gradient Animated Progress Bar -->
                    <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full transition-all duration-500" 
                             style="width: {{ $isEnded ? 100 : ($deal['claimed_percent'] ?? 75) }}%"></div>
                    </div>

                </div>

                <!-- Action CTAs: Direct 1-Click Join or Remind Me -->
                <div class="pt-2.5 relative z-10">
                    @if($isEnded)
                        <button type="button" disabled 
                                class="w-full py-2 px-3 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs text-center cursor-not-allowed">
                            ড্রপ শেষ হয়েছে
                        </button>
                    @elseif($isUpcoming)
                        <button type="button" 
                                class="remind-me-btn w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs text-center transition-all shadow-xs hover:shadow-md flex items-center justify-center space-x-1.5 active:scale-95 cursor-pointer"
                                data-product-title="{{ $deal['title'] }}"
                                data-unlock-time="{{ $deal['unlock_time'] }}">
                            <span>🔔 রিমাইন্ডার সেট করুন</span>
                        </button>
                    @else
                        <a href="{{ route('products.show', $deal['slug']) }}" 
                           class="w-full py-2 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs hover:shadow-md flex items-center justify-center space-x-1.5 active:scale-95">
                            <span>⚡ স্লটে জয়েন করুন</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif
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
       A. HERO COUNTDOWN TIMER
       ---------------------------------------------------- */
    (function initHeroCountdown() {
        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const secondsEl = document.getElementById('countdown-seconds');

        if (!hoursEl || !minutesEl || !secondsEl) return;

        let totalSeconds = (3 * 3600) + (42 * 60) + 18;

        function updateTimer() {
            if (totalSeconds <= 0) {
                totalSeconds = 4 * 3600;
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
       B. PER-CARD INDIVIDUAL DIGITAL COUNTDOWN TICKERS
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
       C. INTERACTIVE TIME-SLOT TABS SWITCHER
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

            // 3. Filter Cards
            applyFilters();
        });
    });


    /* ----------------------------------------------------
       D. CATEGORY & SMART PILLS FILTERING
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
            const cardCategory = card.getAttribute('data-category') || '';
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
            } else if (currentFilter === 'gadgets' && (cardCategory.includes('tech') || cardCategory.includes('audio') || cardCategory.includes('gadgets') || cardCategory.includes('electronics') || cardCategory.includes('computers'))) {
                matchesFilter = true;
            } else if (currentFilter === 'apparel' && (cardCategory.includes('winter') || cardCategory.includes('apparel') || cardCategory.includes('fashion') || cardCategory.includes('hoodie'))) {
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
       E. "REMIND ME" INTERACTIVE TOAST TRIGGER
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
                <span>✓ রিমাইন্ডার সেট হয়েছে</span>
            `;

            showToast(
                '⚡ রিমাইন্ডার সক্রিয় হয়েছে!', 
                `"${productTitle.substring(0, 30)}..." অফারটি ${unlockTime}-এ আনলক হওয়ার ৫ মিনিট আগে আপনাকে জানানো হবে।`
            );
        });
    });

});
</script>
@endsection
