@extends('layouts.app')

@section('title', '⚡ ফ্ল্যাশ সেল — লিমিটেড টাইম সুপার ডিল | Cartiva')

@section('content')
<div class="max-w-[1680px] w-full mx-auto px-3 sm:px-5 lg:px-6 py-4 sm:py-5 space-y-5 antialiased" id="flash-sales-app">

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
                <span class="text-[#53a318] font-bold flex items-center space-x-1">
                    <span>⚡</span>
                    <span>Flash Sales</span>
                </span>
            </nav>
        </div>

    </div>


    <!-- ========================================================
         2. HERO RUSH HEADER (CARTIVA BRAND THEME - NO FLUFF)
         ======================================================== -->
    <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-950 via-[#0a2315] to-[#071924] border border-emerald-900/40 p-5 sm:p-6 lg:p-7 text-white shadow-lg">
        
        <!-- Clean Ambient Glow Accent -->
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-[#53a318]/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            
            <!-- Left Info Column -->
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-600 text-white text-[10px] font-black uppercase tracking-wider shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                    <span>⚡ FLASH DEALS</span>
                </div>

                <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight leading-snug">
                    ফ্ল্যাশ সেল — সীমিত সময়ের স্পেশাল অফার
                </h1>

                <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed font-normal max-w-xl">
                    সেরা ব্র্যান্ডের নির্দিষ্ট কিছু পণ্যে বিশেষ পাইকারি ছাড়। নির্দিষ্ট সময় পর পণ্যের দাম আবার আগের মূল্যে ফিরে যাবে।
                </p>
            </div>

            <!-- Right Countdown Clock Module -->
            <div class="shrink-0 bg-black/50 border border-emerald-500/30 rounded-2xl p-4 sm:p-5 backdrop-blur-md text-center min-w-[270px] shadow-xl">
                <div class="flex items-center justify-between text-[11px] font-bold pb-2.5 border-b border-white/10 mb-3">
                    <span class="text-rose-400 flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        <span>অফার শেষ হতে বাকি:</span>
                    </span>
                </div>

                <!-- Digital Number Tiles -->
                <div class="flex items-center justify-center space-x-2 text-center" id="countdown-tiles">
                    <!-- Hours -->
                    <div class="bg-slate-900 border border-emerald-500/30 rounded-xl p-2 sm:p-2.5 min-w-[62px] sm:min-w-[68px] shadow-inner">
                        <span id="countdown-hours" class="block text-2xl sm:text-3xl font-black text-white font-mono tracking-tight">03</span>
                        <span class="text-[9px] uppercase font-bold text-slate-400">ঘণ্টা</span>
                    </div>

                    <span class="text-xl font-black text-emerald-400 animate-pulse">:</span>

                    <!-- Minutes -->
                    <div class="bg-slate-900 border border-emerald-500/30 rounded-xl p-2 sm:p-2.5 min-w-[62px] sm:min-w-[68px] shadow-inner">
                        <span id="countdown-minutes" class="block text-2xl sm:text-3xl font-black text-white font-mono tracking-tight">39</span>
                        <span class="text-[9px] uppercase font-bold text-slate-400">মিনিট</span>
                    </div>

                    <span class="text-xl font-black text-emerald-400 animate-pulse">:</span>

                    <!-- Seconds -->
                    <div class="bg-slate-900 border border-emerald-500/30 rounded-xl p-2 sm:p-2.5 min-w-[62px] sm:min-w-[68px] shadow-inner">
                        <span id="countdown-seconds" class="block text-2xl sm:text-3xl font-black text-rose-400 font-mono tracking-tight">44</span>
                        <span class="text-[9px] uppercase font-bold text-slate-400">সেকেন্ড</span>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================
         3. TIME-SLOT SCHEDULING TABS (CLEAN & HIGH CONTRAST)
         ======================================================== -->
    <div class="sticky top-0 sm:top-16 z-30 bg-[#f8f9fa]/95 backdrop-blur-md py-2.5 -mx-3 sm:-mx-5 lg:-mx-6 px-3 sm:px-5 lg:px-6 border-b border-slate-200 shadow-2xs">
        <div class="max-w-[1680px] mx-auto flex items-center justify-between gap-4 overflow-x-auto no-scrollbar">
            
            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0" id="slot-tabs-container">
                @foreach($timeSlots as $slot)
                    @php
                        $isActive = ($slot['id'] === $selectedSlot);
                        $isEnded = $slot['is_ended'];
                    @endphp
                    <button type="button" 
                            data-slot-id="{{ $slot['id'] }}"
                            class="slot-tab-btn px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold transition-all flex items-center space-x-2.5 cursor-pointer text-left border
                            {{ $isActive ? 'active-slot bg-[#53a318] text-white border-[#53a318] shadow-sm' : ($isEnded ? 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200/60' : 'bg-white text-slate-900 border-slate-200 hover:border-slate-300 hover:bg-slate-50') }}">
                        
                        <!-- Status Dot -->
                        @if($slot['is_live'])
                            <span class="slot-dot w-2.5 h-2.5 rounded-full {{ $isActive ? 'bg-amber-300 animate-ping' : 'bg-amber-500' }}"></span>
                        @elseif($isEnded)
                            <span class="slot-dot w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                        @else
                            <span class="slot-dot w-2.5 h-2.5 rounded-full {{ $isActive ? 'bg-white' : 'bg-blue-600' }}"></span>
                        @endif

                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="slot-time text-sm font-black tracking-tight {{ $isActive ? 'text-white' : ($isEnded ? 'text-slate-600' : 'text-slate-900') }}">
                                    {{ $slot['time'] }}
                                </span>
                                <span class="slot-badge text-[10px] font-black uppercase px-1.5 py-0.2 rounded {{ $isActive ? 'bg-white/20 text-white' : ($isEnded ? 'bg-slate-200 text-slate-600' : ($slot['is_live'] ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900')) }}">
                                    {{ $slot['badge'] }}
                                </span>
                            </div>
                            <span class="slot-subtext text-[10px] block font-semibold {{ $isActive ? 'text-emerald-100' : ($isEnded ? 'text-slate-400' : 'text-slate-500') }}">
                                {{ $slot['subtext'] }}
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>

            <!-- Timezone Note -->
            <div class="hidden xl:flex items-center space-x-1.5 text-xs font-semibold text-slate-500 shrink-0">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>ঢাকা সময় (GMT+6)</span>
            </div>

        </div>
    </div>


    <!-- ========================================================
         4. CATEGORY & FILTER PILLS (CLEAN, NO HABIJABI)
         ======================================================== -->
    <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-1" id="filter-pills-container">
        <span class="text-xs font-black text-slate-400 uppercase tracking-wider shrink-0 mr-1">Filters:</span>

        <button type="button" data-filter="all" 
                class="filter-pill-btn active px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 shrink-0 bg-[#53a318] text-white shadow-xs cursor-pointer">
            <span>All</span>
            <span class="text-[10px] px-1.5 py-0.2 bg-white/20 rounded-full font-black count-badge">{{ count($enrichedDeals) }}</span>
        </button>

        <button type="button" data-filter="deep_discount" 
                class="filter-pill-btn px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-slate-300 cursor-pointer">
            <span>Flat Discount 50%</span>
        </button>

        <button type="button" data-filter="under_999" 
                class="filter-pill-btn px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-slate-300 cursor-pointer">
            <span>Under ৳999</span>
        </button>

        <button type="button" data-filter="almost_sold" 
                class="filter-pill-btn px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-slate-300 cursor-pointer">
            <span>Almost Sold</span>
        </button>

        <button type="button" data-filter="gadgets" 
                class="filter-pill-btn px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-slate-300 cursor-pointer">
            <span>Gadgets & Audio</span>
        </button>

        <button type="button" data-filter="apparel" 
                class="filter-pill-btn px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 shrink-0 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 hover:border-slate-300 cursor-pointer">
            <span>Winter</span>
        </button>
    </div>


    <!-- ========================================================
         5. COMPACT FLASH DEAL CARDS (HOT DEALS 5-PER-ROW FORMAT)
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
                            <span>Remind Me</span>
                        </button>
                    @else
                        <a href="{{ route('products.show', $deal['slug']) }}" 
                           class="w-full py-2 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs hover:shadow-md flex items-center justify-center space-x-1.5 active:scale-95">
                            <span>Join Slot</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center space-y-4 bg-white rounded-3xl border border-slate-200 p-8">
                <div class="w-16 h-16 mx-auto rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-2xl font-black">
                    ⚡
                </div>
                <h3 class="text-lg font-black text-slate-800">No Flash Deal Found</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    আপনার নির্বাচিত ফিল্টারে বর্তমানে কোনো প্রোডাক্ট নেই। পরবর্তী স্লটের জন্য অপেক্ষা করুন অথবা অন্যান্য গ্রুপ পুল দেখুন।
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-[#53a318] text-white text-xs font-bold hover:bg-[#468c13]">
                    <span>Back to Home</span>
                </a>
            </div>
        @endforelse
    </div>

</div>


<!-- ========================================================
     6. FLOATING TOAST NOTIFICATION CONTAINER
     ======================================================== -->
<div id="flash-toast" 
     class="fixed bottom-5 right-5 z-50 transform translate-y-24 opacity-0 transition-all duration-300 max-w-sm w-full bg-slate-900 border border-slate-700 text-white rounded-2xl p-4 shadow-2xl flex items-start space-x-3 pointer-events-none">
    <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 text-base font-black">
        🔔
    </div>
    <div class="flex-1 space-y-0.5">
        <h5 class="text-xs font-black text-white" id="flash-toast-title">রিমাইন্ডার সক্রিয় হয়েছে!</h5>
        <p class="text-[11px] text-slate-300 leading-relaxed" id="flash-toast-msg">
            অফার আনলক হওয়ার ৫ মিনিট আগে আপনাকে নোটিফিকেশন পাঠানো হবে।
        </p>
    </div>
    <button type="button" id="flash-toast-close" class="text-slate-400 hover:text-white p-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>


<!-- ========================================================
     7. VANILLA JAVASCRIPT CONTROLLERS
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

        let totalSeconds = (3 * 3600) + (39 * 60) + 44;

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
       C. INTERACTIVE TIME-SLOT TABS SWITCHER (ROBUST STYLING)
       ---------------------------------------------------- */
    const slotButtons = document.querySelectorAll('.slot-tab-btn');
    const dealCards = document.querySelectorAll('.deal-card');

    let currentSlot = 'live';

    function updateSlotTabsUI(selectedId) {
        slotButtons.forEach(btn => {
            const slotId = btn.getAttribute('data-slot-id');
            const isTarget = (slotId === selectedId);
            const isEnded = (slotId === 'ended');
            const isLive = (slotId === 'live');

            const timeEl = btn.querySelector('.slot-time');
            const badgeEl = btn.querySelector('.slot-badge');
            const subtextEl = btn.querySelector('.slot-subtext');
            const dotEl = btn.querySelector('.slot-dot');

            if (isTarget) {
                btn.className = 'slot-tab-btn active-slot px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold transition-all flex items-center space-x-2.5 cursor-pointer text-left border bg-[#53a318] text-white border-[#53a318] shadow-sm';
                if (timeEl) timeEl.className = 'slot-time text-sm font-black tracking-tight text-white';
                if (badgeEl) badgeEl.className = 'slot-badge text-[10px] font-black uppercase px-1.5 py-0.2 rounded bg-white/20 text-white';
                if (subtextEl) subtextEl.className = 'slot-subtext text-[10px] block font-semibold text-emerald-100';
                if (dotEl) dotEl.className = 'slot-dot w-2.5 h-2.5 rounded-full ' + (isLive ? 'bg-amber-300 animate-ping' : 'bg-white');
            } else if (isEnded) {
                btn.className = 'slot-tab-btn px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold transition-all flex items-center space-x-2.5 cursor-pointer text-left border bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200/60';
                if (timeEl) timeEl.className = 'slot-time text-sm font-bold tracking-tight text-slate-600';
                if (badgeEl) badgeEl.className = 'slot-badge text-[10px] font-black uppercase px-1.5 py-0.2 rounded bg-slate-200 text-slate-600';
                if (subtextEl) subtextEl.className = 'slot-subtext text-[10px] block font-semibold text-slate-400';
                if (dotEl) dotEl.className = 'slot-dot w-2.5 h-2.5 rounded-full bg-slate-400';
            } else {
                btn.className = 'slot-tab-btn px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl font-bold transition-all flex items-center space-x-2.5 cursor-pointer text-left border bg-white text-slate-900 border-slate-200 hover:border-slate-300 hover:bg-slate-50';
                if (timeEl) timeEl.className = 'slot-time text-sm font-black tracking-tight text-slate-900';
                if (badgeEl) badgeEl.className = 'slot-badge text-[10px] font-black uppercase px-1.5 py-0.2 rounded ' + (isLive ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900');
                if (subtextEl) subtextEl.className = 'slot-subtext text-[10px] block font-semibold text-slate-500';
                if (dotEl) dotEl.className = 'slot-dot w-2.5 h-2.5 rounded-full ' + (isLive ? 'bg-amber-500' : 'bg-blue-600');
            }
        });
    }

    slotButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const slotId = this.getAttribute('data-slot-id');
            currentSlot = slotId;
            updateSlotTabsUI(slotId);
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
                p.classList.remove('bg-[#53a318]', 'text-white', 'shadow-xs');
                p.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            });

            this.classList.remove('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            this.classList.add('bg-[#53a318]', 'text-white', 'shadow-xs');

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
        const activeCountBadge = document.querySelector('.filter-pill-btn.bg-\\[\\#53a318\\] .count-badge');
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
            const productTitle = this.getAttribute('data-product-title') || 'এই ফ্ল্যাশ ডিল';
            const unlockTime = this.getAttribute('data-unlock-time') || 'নির্ধারিত সময়ে';

            // Visual button transformation
            this.classList.remove('bg-slate-900', 'hover:bg-slate-800');
            this.classList.add('bg-[#53a318]', 'text-white');
            this.innerHTML = `
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                <span>✓ রিমাইন্ডার সেট হয়েছে</span>
            `;

            showToast(
                '⚡ রিমাইন্ডার সক্রিয় হয়েছে!', 
                `"${productTitle.substring(0, 28)}..." ড্রপটি ${unlockTime}-এ শুরু হওয়ার ৫ মিনিট আগে আপনাকে অ্যালার্ট দেওয়া হবে।`
            );
        });
    });

});
</script>
@endsection
