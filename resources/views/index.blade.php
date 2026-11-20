@extends('layouts.app')

@section('title', 'Cartiva — Group Buying Platform | Buy Together, Pay Less')

@section('content')<!-- Global Container for Group Buying Platform with Dynamic Theme -->
<div class="max-w-[1600px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-4 sm:py-5 space-y-10 sm:space-y-12"
     x-data="{
        shareModalOpen: false,
        shareGroupCode: '{{ $spotlightGroup ? $spotlightGroup->group_code : 'GRP-HOODIE05' }}',
        shareGroupTitle: '{{ $spotlightGroup ? addslashes($spotlightGroup->product->title) : 'Cartiva Premium Fleece Winter Hoodie' }}',
        rulesModalOpen: false,
        copiedToast: false,
        activeFilterTab: 'all',
        openFaq: null,

        copyShareLink(code) {
            const url = window.location.origin + '/group-buy/' + code;
            navigator.clipboard.writeText(url);
            this.copiedToast = true;
            setTimeout(() => { this.copiedToast = false; }, 3000);
        },
        openShare(code, title) {
            this.shareGroupCode = code;
            this.shareGroupTitle = title;
            this.shareModalOpen = true;
        }
     }">

    @if(request()->filled('q'))
    <!-- ========================================================
         SEARCH RESULTS SECTION (PROMINENT RESULTS FOR QUERY)
         ======================================================== -->
    <section id="search-results" class="bg-white rounded-3xl border-2 border-[#53a318] shadow-xl p-5 sm:p-7 space-y-6 scroll-mt-24">
        
        <!-- Header Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div class="space-y-1">
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-[#53a318]">
                        🔍Search Results
                    </span>
                    <span class="text-xs text-slate-400">•</span>
                    <span class="text-xs font-bold text-slate-600">
                        {{ $products->total() }} টি পণ্য পাওয়া গেছে
                    </span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    “<span class="text-[#53a318]">{{ request('q') }}</span>” এর জন্য ফলাফল
                </h2>
            </div>

            <div class="flex items-center space-x-2 shrink-0">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-700 hover:text-rose-600 text-xs font-bold transition-all border border-slate-200/80 cursor-pointer">
                    <span>✕ Clear</span>
                </a>
                <a href="{{ route('categories.index', ['q' => request('q')]) }}" 
                   class="inline-flex items-center space-x-1 px-4 py-2 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white text-xs font-bold transition-all shadow-xs cursor-pointer">
                    <span>Filter</span>
                    
                </a>
            </div>
        </div>

        @php
            $matchingActiveGroups = isset($activeGroups) ? $activeGroups->filter(function($grp) {
                $q = strtolower(request('q'));
                return str_contains(strtolower($grp->group_code), $q) || ($grp->product && str_contains(strtolower($grp->product->title), $q));
            }) : collect();
        @endphp

        @if($matchingActiveGroups->count() > 0)
        <!-- Matching Active Group Rooms Strip -->
        <div class="space-y-3 p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-amber-900 flex items-center gap-1.5">
                    <span>👥 Active Group Pools</span>
                    <span class="px-2 py-0.5 rounded-full bg-amber-200 text-amber-950 text-[10px] font-bold">{{ $matchingActiveGroups->count() }} টি লাইভ</span>
                </span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($matchingActiveGroups->take(3) as $grp)
                <div class="p-3 bg-white rounded-xl border border-amber-200 shadow-2xs flex items-center justify-between space-x-3">
                    <div class="min-w-0 flex-1">
                        <span class="font-mono font-black text-xs text-amber-900 block">{{ $grp->group_code }}</span>
                        <h4 class="text-xs font-bold text-slate-800 truncate mt-0.5">{{ $grp->product ? $grp->product->title : '' }}</h4>
                        <span class="text-[10px] font-semibold text-[#53a318] block mt-0.5">গ্রুপ মূল্য: ৳{{ number_format($grp->product ? $grp->product->group_price : 0) }}</span>
                    </div>
                    <a href="{{ route('group-buy.show', $grp->group_code) }}" 
                       class="px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-black shrink-0 transition-colors">
                        পুলে যোগ দিন
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($products->count() > 0)
        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach($products as $product)
                @php
                    $discountPct = $product->discount_percent;
                    $saveAmount = $product->single_price - $product->group_price;
                    $activeSession = $product->activeGroupSessions->first();
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-lg hover:border-[#53a318] hover:-translate-y-1 transition-all duration-300 p-3.5 flex flex-col justify-between group">
                    
                    <div class="space-y-2">
                        <!-- Thumbnail -->
                        <a href="{{ route('products.show', $product->slug) }}" class="block relative w-full h-40 sm:h-44 rounded-xl overflow-hidden bg-slate-100 group/img shadow-inner">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300">
                            @if($discountPct > 0)
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[9px] font-black bg-rose-600 text-white shadow-2xs">
                                -{{ $discountPct }}%
                            </span>
                            @endif
                            @if($activeSession)
                            <span class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded text-[8px] font-mono font-bold bg-slate-950/80 text-emerald-300 backdrop-blur-xs">
                                {{ $activeSession->group_code }}
                            </span>
                            @endif
                        </a>

                        <!-- Category & Title -->
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#53a318] block truncate">
                                {{ $product->category ? $product->category->name : 'General' }}
                            </span>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors mt-0.5 min-h-[2.25rem]">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->title }}
                                </a>
                            </h3>
                        </div>

                        <!-- Pricing -->
                        <div class="pt-1 flex items-baseline justify-between flex-wrap gap-1">
                            <div class="flex items-baseline space-x-1.5">
                                <span class="text-base sm:text-lg font-black text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                <span class="text-xs text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                            </div>
                            @if($saveAmount > 0)
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-[#53a318] border border-emerald-200/80">
                                সাশ্রয় ৳{{ number_format($saveAmount) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-2">
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="flex-1 py-2 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs text-center transition-all shadow-xs flex items-center justify-center space-x-1 active:scale-95">
                            <span>Join Deal</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <button type="button" 
                                @click="window.addToCart({ id: {{ $product->id }}, title: '{{ addslashes($product->title) }}', price: {{ $product->group_price }}, image: '{{ $product->image_url }}', slug: '{{ $product->slug }}' })" 
                                title="কার্টে যোগ করুন (Add to Cart)"
                                class="w-9 h-9 shrink-0 rounded-xl bg-slate-100 hover:bg-[#53a318] text-slate-700 hover:text-white transition-colors flex items-center justify-center cursor-pointer border border-slate-200/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="pt-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
        @endif

        @else
        <!-- No Products Found Empty State -->
        <div class="py-10 px-4 text-center max-w-md mx-auto space-y-4">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto shadow-inner">
                🔍
            </div>
            <div class="space-y-1">
                <h3 class="text-base sm:text-lg font-black text-slate-900">
                    “{{ request('q') }}” এর জন্য কোনো পণ্য পাওয়া যায়নি
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    বানান চেক করে আবার চেষ্টা করুন অথবা নিচের জনপ্রিয় ডিলগুলো দেখতে পারেন:
                </p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-1.5 pt-1">
                <a href="{{ route('home', ['q' => 'Hoodie']) }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                    🧥 Hoodie
                </a>
                <a href="{{ route('home', ['q' => 'SoundCore']) }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                    🎧 Headphones
                </a>
                <a href="{{ route('home', ['q' => 'Keyboard']) }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                    ⌨️ Keyboard
                </a>
                <a href="{{ route('home', ['q' => 'Charger']) }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                    ⚡ Charger
                </a>
                <a href="{{ route('home', ['q' => 'Air Fryer']) }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-[#53a318] text-xs font-semibold text-slate-700 transition-colors">
                    🍳 Air Fryer
                </a>
            </div>

            <div class="pt-3">
                <a href="{{ route('categories.index') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white text-xs font-black shadow-md transition-all">
                    <span>সব পণ্য ক্যাটালগ দেখুন</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
        @endif

    </section>
    @endif

    <!-- ========================================================
         2. HIGH-CONVERSION HERO POSTER CAROUSEL (FLASH SALES & HOT DEALS)
         Inspired by: Clean, high-impact eCommerce Hero Slider with Live Countdown
         Features: Left-to-Right Animated Transition, Dynamic Countdown Timer,
                   3D Tilt Card Floating Product Showcase, and Full Merchant-Linked Deals
         ======================================================== -->
    @php
        $heroFlashProduct = $flashDeals->first() ?? $products->first();
        $heroHotSession = $urgentGroups->first();
        $heroHotProduct = ($heroHotSession ? $heroHotSession->product : null) ?? ($todayDeals->first() ?? $products->skip(1)->first() ?? $products->first());
        $heroGroupProduct = ($spotlightGroup ? $spotlightGroup->product : null) ?? ($products->skip(2)->first() ?? $products->first());

        // 1. Functional & Logical Flash Sale Expiry:
        // Flash deals run in timed cycles (e.g. today's flash block or active session expiry).
        $flashSession = $heroFlashProduct ? $heroFlashProduct->activeGroupSessions()->where('status', 'active')->where('expires_at', '>', now())->orderBy('expires_at', 'asc')->first() : null;
        $flashExpiry = $flashSession ? $flashSession->expires_at : now()->endOfDay();
        $flashTargetMs = (int) ($flashExpiry->timestamp * 1000);
        $flashDiff = max(0, (int) ($flashExpiry->timestamp - now()->timestamp));
        $flashInitialHours = str_pad(floor($flashDiff / 3600), 2, '0', STR_PAD_LEFT);
        $flashInitialMinutes = str_pad(floor(($flashDiff % 3600) / 60), 2, '0', STR_PAD_LEFT);
        $flashInitialSeconds = str_pad($flashDiff % 60, 2, '0', STR_PAD_LEFT);

        // 2. Functional & Logical Hot Deals Expiry:
        // Directly bound to the displayed group session's real expires_at!
        $hotExpiry = $heroHotSession ? $heroHotSession->expires_at : ($heroHotProduct && $heroHotProduct->activeGroupSessions()->where('status', 'active')->where('expires_at', '>', now())->first() ? $heroHotProduct->activeGroupSessions()->where('status', 'active')->where('expires_at', '>', now())->first()->expires_at : now()->addHours(2)->addMinutes(35));
        $hotTargetMs = (int) ($hotExpiry->timestamp * 1000);
        $hotDiff = max(0, (int) ($hotExpiry->timestamp - now()->timestamp));
        $hotInitialHours = str_pad(floor($hotDiff / 3600), 2, '0', STR_PAD_LEFT);
        $hotInitialMinutes = str_pad(floor(($hotDiff % 3600) / 60), 2, '0', STR_PAD_LEFT);
        $hotInitialSeconds = str_pad($hotDiff % 60, 2, '0', STR_PAD_LEFT);
    @endphp

    <section class="relative overflow-hidden rounded-3xl border border-slate-800/40 shadow-2xl group select-none"
             x-data="{
                activeSlide: 0,
                slideCount: 3,
                timer: null,
                touchStartX: 0,
                flashTimer: {
                    targetMs: {{ $flashTargetMs }},
                    hours: '{{ $flashInitialHours }}',
                    minutes: '{{ $flashInitialMinutes }}',
                    seconds: '{{ $flashInitialSeconds }}',
                    tick() {
                        const diff = Math.max(0, Math.floor((this.targetMs - Date.now()) / 1000));
                        const h = Math.floor(diff / 3600);
                        const m = Math.floor((diff % 3600) / 60);
                        const s = diff % 60;
                        this.hours = String(h).padStart(2, '0');
                        this.minutes = String(m).padStart(2, '0');
                        this.seconds = String(s).padStart(2, '0');
                    }
                },
                hotTimer: {
                    targetMs: {{ $hotTargetMs }},
                    hours: '{{ $hotInitialHours }}',
                    minutes: '{{ $hotInitialMinutes }}',
                    seconds: '{{ $hotInitialSeconds }}',
                    tick() {
                        const diff = Math.max(0, Math.floor((this.targetMs - Date.now()) / 1000));
                        const h = Math.floor(diff / 3600);
                        const m = Math.floor((diff % 3600) / 60);
                        const s = diff % 60;
                        this.hours = String(h).padStart(2, '0');
                        this.minutes = String(m).padStart(2, '0');
                        this.seconds = String(s).padStart(2, '0');
                    }
                },
                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.slideCount;
                },
                prev() {
                    this.activeSlide = (this.activeSlide - 1 + this.slideCount) % this.slideCount;
                },
                goTo(idx) {
                    this.activeSlide = idx;
                },
                startAutoPlay() {
                    this.stopAutoPlay();
                    this.timer = setInterval(() => {
                        this.next();
                    }, 6000);
                },
                stopAutoPlay() {
                    if (this.timer) {
                        clearInterval(this.timer);
                        this.timer = null;
                    }
                }
             }"
             x-init="
                flashTimer.tick();
                hotTimer.tick();
                startAutoPlay();
                setInterval(() => {
                    flashTimer.tick();
                    hotTimer.tick();
                }, 1000);
             "
             @mouseenter="stopAutoPlay()"
             @mouseleave="startAutoPlay()"
             @touchstart="touchStartX = $event.touches[0].clientX"
             @touchend="
                if (touchStartX - $event.changedTouches[0].clientX > 40) next();
                else if ($event.changedTouches[0].clientX - touchStartX > 40) prev();
             ">

        <!-- Slider Track: Smooth Left-to-Right Horizontal Slide -->
        <div class="flex transition-transform duration-500 ease-out"
             :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">

            <!-- ================= SLIDE 1: FLASH SALE (Deep Ruby & Crimson Wine Gradient) ================= -->
            <div class="w-full flex-shrink-0 grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 p-5 sm:p-8 lg:p-12 items-center min-h-[440px] sm:min-h-[460px] relative overflow-hidden text-white"
                 style="background: linear-gradient(135deg, #2b0409 0%, #680f1b 30%, #881337 70%, #450a0a 100%);">
                
                <!-- Luminous Ambient Light Rings & Glows (fills middle space with glowing depth) -->
                <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full bg-rose-500/25 blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/3 top-1/2 -translate-y-1/2 w-80 h-80 rounded-full bg-amber-500/15 blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -bottom-20 w-96 h-96 rounded-full bg-red-600/30 blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[580px] h-[580px] rounded-full border border-white/5 pointer-events-none"></div>
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[420px] h-[420px] rounded-full border border-white/5 pointer-events-none"></div>

                <!-- Left Column: Headline, Discount, Subtitle, Live Timer, CTAs -->
                <div class="lg:col-span-7 space-y-3.5 sm:space-y-5 relative z-10">
                    
                    <!-- Pill Tag -->
                    <div class="inline-flex items-center space-x-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-amber-300 text-[11px] sm:text-xs font-bold uppercase tracking-wider shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        <span class="w-2 h-2 rounded-full bg-amber-400 -ml-3"></span>
                        <span>⚡ LIMITED-TIME FLASH SALE</span>
                    </div>

                    <!-- Bold Classical Headline & High-Contrast Discount -->
                    <div>
                        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-none drop-shadow-sm">
                            FLASH SALE
                        </h2>
                        <div class="text-2xl sm:text-4xl lg:text-5xl font-black text-amber-300 tracking-tight leading-tight mt-1 sm:mt-1.5 drop-shadow-sm">
                            UP TO {{ $heroFlashProduct && $heroFlashProduct->discount_percent ? $heroFlashProduct->discount_percent . '% OFF' : '45% OFF' }}
                        </div>
                    </div>

                    <!-- Subtitle -->
                    <p class="text-xs sm:text-sm text-rose-100/90 max-w-xl font-normal leading-relaxed line-clamp-2 sm:line-clamp-none">
                        Grab massive discounts on premium verified tech, fashion, and lifestyle gear. Prices drop every hour with guaranteed authenticity and express delivery.
                    </p>

                    <!-- Real-Time Chronograph Countdown -->
                    <div class="flex items-center space-x-2 sm:space-x-3 pt-1 flex-nowrap">
                        <div class="w-13 h-14 sm:w-16 sm:h-18 rounded-2xl bg-black/50 backdrop-blur-md text-white flex flex-col items-center justify-center shadow-lg border border-white/20 shrink-0">
                            <span class="text-lg sm:text-2xl font-black font-mono leading-none tracking-tight text-white" x-text="flashTimer.hours">{{ $flashInitialHours }}</span>
                            <span class="text-[8px] sm:text-[9px] font-bold text-amber-200/80 uppercase tracking-widest mt-0.5 sm:mt-1">HOURS</span>
                        </div>
                        <span class="text-lg sm:text-2xl font-black text-white/50 shrink-0">:</span>
                        <div class="w-13 h-14 sm:w-16 sm:h-18 rounded-2xl bg-black/50 backdrop-blur-md text-white flex flex-col items-center justify-center shadow-lg border border-white/20 shrink-0">
                            <span class="text-lg sm:text-2xl font-black font-mono leading-none tracking-tight text-white" x-text="flashTimer.minutes">{{ $flashInitialMinutes }}</span>
                            <span class="text-[8px] sm:text-[9px] font-bold text-amber-200/80 uppercase tracking-widest mt-0.5 sm:mt-1">MINUTES</span>
                        </div>
                        <span class="text-lg sm:text-2xl font-black text-white/50 shrink-0">:</span>
                        <div class="w-13 h-14 sm:w-16 sm:h-18 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 text-slate-950 flex flex-col items-center justify-center shadow-xl border border-amber-300 shrink-0">
                            <span class="text-lg sm:text-2xl font-black font-mono leading-none tracking-tight text-slate-950" x-text="flashTimer.seconds">{{ $flashInitialSeconds }}</span>
                            <span class="text-[8px] sm:text-[9px] font-black text-slate-900 uppercase tracking-widest mt-0.5 sm:mt-1">SECONDS</span>
                        </div>
                    </div>

                    <!-- Dual Action Buttons -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 pt-2">
                        <a href="{{ route('flash-sales.index') }}" 
                           class="px-5 sm:px-7 py-3 sm:py-3.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-slate-950 font-black text-xs sm:text-sm shadow-xl shadow-black/25 hover:shadow-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center space-x-2">
                            <span>Shop Flash Deals</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="{{ route('categories.index') }}" 
                           class="px-4 sm:px-6 py-3 sm:py-3.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold text-xs sm:text-sm border border-white/30 hover:border-white/50 shadow-xs hover:-translate-y-0.5 transition-all">
                            View Categories
                        </a>
                    </div>

                </div>

                <!-- Right Column: Luxury Framed Merchant Showcase Card (Pops Against Gradient!) -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end relative z-10 w-full">
                    @if($heroFlashProduct)
                    <a href="{{ route('products.show', $heroFlashProduct->slug) }}" 
                       class="group/card block w-full max-w-sm sm:max-w-md mx-auto rounded-3xl bg-white p-3.5 sm:p-5 border border-white/80 shadow-2xl shadow-black/35 hover:shadow-black/50 hover:-translate-y-1 transition-all duration-300 text-slate-900">
                        
                        <!-- Product Viewport Stage -->
                        <div class="relative w-full h-44 sm:h-56 rounded-2xl bg-gradient-to-b from-slate-50 to-slate-100/80 border border-slate-100 flex items-center justify-center p-3 overflow-hidden">
                            <!-- Discount Badge -->
                            <span class="absolute top-2.5 left-2.5 px-3 py-1 rounded-lg bg-red-600 text-white font-black text-xs shadow-md tracking-wide z-10">
                                -{{ $heroFlashProduct->discount_percent ? $heroFlashProduct->discount_percent . '%' : '35%' }} OFF
                            </span>
                            <!-- Verified Tag -->
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-1 rounded-md bg-white/95 backdrop-blur-xs text-slate-700 font-bold text-[10px] border border-slate-200 shadow-2xs z-10">
                                 Verified Deal
                            </span>

                            <img src="{{ $heroFlashProduct->image_url ?? ($heroFlashProduct->image ? asset('storage/' . $heroFlashProduct->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80') }}" 
                                 alt="{{ $heroFlashProduct->title }}" 
                                 class="max-h-full max-w-full object-contain group-hover/card:scale-105 transition-transform duration-500 drop-shadow-sm">
                        </div>

                        <!-- Product Information Strip -->
                        <div class="pt-3.5 space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                    {{ $heroFlashProduct->category->name ?? 'Special Pick' }}
                                </span>
                                <div class="flex items-center text-amber-500 font-bold text-xs">
                                    <span>★</span>
                                    <span class="ml-1 text-slate-700">{{ number_format($heroFlashProduct->rating ?? 4.8, 1) }}</span>
                                </div>
                            </div>

                            <h3 class="text-sm sm:text-base font-bold text-slate-900 line-clamp-1 group-hover/card:text-red-600 transition-colors">
                                {{ $heroFlashProduct->title }}
                            </h3>

                            <div class="flex items-baseline justify-between pt-1.5 border-t border-slate-100">
                                <div>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Flash Price</span>
                                    <span class="text-lg sm:text-xl font-black text-slate-900 leading-none">
                                        ৳{{ number_format($heroFlashProduct->group_price) }}
                                    </span>
                                </div>
                                @if($heroFlashProduct->price > $heroFlashProduct->group_price)
                                <div class="text-right">
                                    <span class="text-[10px] font-semibold text-slate-400 block line-through">
                                        ৳{{ number_format($heroFlashProduct->price) }}
                                    </span>
                                    <span class="text-xs font-bold text-emerald-600">
                                        Save ৳{{ number_format($heroFlashProduct->price - $heroFlashProduct->group_price) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endif
                </div>

            </div>

            <!-- ================= SLIDE 2: HOT DEALS (Deep Heritage Bronze & Warm Amber Gradient) ================= -->
            <div class="w-full flex-shrink-0 grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 p-5 sm:p-8 lg:p-12 items-center min-h-[440px] sm:min-h-[460px] relative overflow-hidden text-white"
                 style="background: linear-gradient(135deg, #1f1105 0%, #592507 30%, #78350f 70%, #351402 100%);">
                
                <!-- Luminous Ambient Light Glows -->
                <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full bg-amber-500/25 blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/3 top-1/2 -translate-y-1/2 w-80 h-80 rounded-full bg-orange-500/15 blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -bottom-20 w-96 h-96 rounded-full bg-amber-600/30 blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[580px] h-[580px] rounded-full border border-white/5 pointer-events-none"></div>

                <!-- Left Column: Hot Deals Proposition -->
                <div class="lg:col-span-7 space-y-3.5 sm:space-y-5 relative z-10">
                    
                    <!-- Pill Tag -->
                    <div class="inline-flex items-center space-x-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-amber-300 text-[11px] sm:text-xs font-bold uppercase tracking-wider shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        <span class="w-2 h-2 rounded-full bg-amber-400 -ml-3"></span>
                        <span>🔥 RUSH HOUR HOT DEALS</span>
                    </div>

                    <!-- Bold Headline & High-Contrast Discount -->
                    <div>
                        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-none drop-shadow-sm">
                            HOT DEALS
                        </h2>
                        <div class="text-2xl sm:text-4xl lg:text-5xl font-black text-amber-300 tracking-tight leading-tight mt-1 sm:mt-1.5 drop-shadow-sm">
                            TEAM UP & SAVE UP TO {{ $heroHotProduct && $heroHotProduct->discount_percent ? $heroHotProduct->discount_percent . '%' : '40%' }}
                        </div>
                    </div>

                    <!-- Subtitle -->
                    <p class="text-xs sm:text-sm text-amber-100/90 max-w-xl font-normal leading-relaxed line-clamp-2 sm:line-clamp-none">
                        High-demand group pools filling fast! Lock in tier-discounted wholesale prices by joining active teams before the time slots expire.
                    </p>

                    <!-- Real-Time Chronograph Countdown -->
                    <div class="flex items-center space-x-2 sm:space-x-3 pt-1 flex-nowrap">
                        <div class="w-13 h-14 sm:w-16 sm:h-18 rounded-2xl bg-black/50 backdrop-blur-md text-white flex flex-col items-center justify-center shadow-lg border border-white/20 shrink-0">
                            <span class="text-lg sm:text-2xl font-black font-mono leading-none tracking-tight text-white" x-text="hotTimer.hours">{{ $hotInitialHours }}</span>
                            <span class="text-[8px] sm:text-[9px] font-bold text-amber-200/80 uppercase tracking-widest mt-0.5 sm:mt-1">HOURS</span>
                        </div>
                        <span class="text-lg sm:text-2xl font-black text-white/50 shrink-0">:</span>
                        <div class="w-13 h-14 sm:w-16 sm:h-18 rounded-2xl bg-black/50 backdrop-blur-md text-white flex flex-col items-center justify-center shadow-lg border border-white/20 shrink-0">
                            <span class="text-lg sm:text-2xl font-black font-mono leading-none tracking-tight text-white" x-text="hotTimer.minutes">{{ $hotInitialMinutes }}</span>
                            <span class="text-[8px] sm:text-[9px] font-bold text-amber-200/80 uppercase tracking-widest mt-0.5 sm:mt-1">MINUTES</span>
                        </div>
                        <span class="text-lg sm:text-2xl font-black text-white/50 shrink-0">:</span>
                        <div class="w-13 h-14 sm:w-16 sm:h-18 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 text-slate-950 flex flex-col items-center justify-center shadow-xl border border-amber-300 shrink-0">
                            <span class="text-lg sm:text-2xl font-black font-mono leading-none tracking-tight text-slate-950" x-text="hotTimer.seconds">{{ $hotInitialSeconds }}</span>
                            <span class="text-[8px] sm:text-[9px] font-black text-slate-900 uppercase tracking-widest mt-0.5 sm:mt-1">SECONDS</span>
                        </div>
                    </div>

                    <!-- Dual Action Buttons -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 pt-2">
                        <a href="{{ route('hot-deals.index') }}" 
                           class="px-5 sm:px-7 py-3 sm:py-3.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-slate-950 font-black text-xs sm:text-sm shadow-xl shadow-black/25 hover:shadow-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center space-x-2">
                            <span>Explore Hot Deals</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="{{ $heroHotSession ? route('products.show', ['product' => $heroHotProduct->slug, 'join' => $heroHotSession->group_code]) : '#urgent-pools' }}" 
                           class="px-4 sm:px-6 py-3 sm:py-3.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold text-xs sm:text-sm border border-white/30 hover:border-white/50 shadow-xs hover:-translate-y-0.5 transition-all">
                            Join Active Pool
                        </a>
                    </div>

                </div>

                <!-- Right Column: Luxury Framed Merchant Showcase Card -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end relative z-10 w-full">
                    @if($heroHotProduct)
                    <a href="{{ route('products.show', $heroHotProduct->slug) }}" 
                       class="group/card block w-full max-w-sm sm:max-w-md mx-auto rounded-3xl bg-white p-3.5 sm:p-5 border border-white/80 shadow-2xl shadow-black/35 hover:shadow-black/50 hover:-translate-y-1 transition-all duration-300 text-slate-900">
                        
                        <!-- Product Viewport Stage -->
                        <div class="relative w-full h-44 sm:h-56 rounded-2xl bg-gradient-to-b from-slate-50 to-slate-100/80 border border-slate-100 flex items-center justify-center p-3 overflow-hidden">
                            <!-- Hot Pick Badge -->
                            <span class="absolute top-2.5 left-2.5 px-3 py-1 rounded-lg bg-amber-600 text-white font-black text-xs shadow-md tracking-wide z-10">
                                🔥 HOT PICK
                            </span>
                            <!-- Stock Alert -->
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-1 rounded-md bg-white/95 backdrop-blur-xs text-amber-700 font-bold text-[10px] border border-amber-200 shadow-2xs z-10">
                                Almost Full
                            </span>

                            <img src="{{ $heroHotProduct->image_url ?? ($heroHotProduct->image ? asset('storage/' . $heroHotProduct->image) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80') }}" 
                                 alt="{{ $heroHotProduct->title }}" 
                                 class="max-h-full max-w-full object-contain group-hover/card:scale-105 transition-transform duration-500 drop-shadow-sm">
                        </div>

                        <!-- Product Information Strip -->
                        <div class="pt-3.5 space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                    {{ $heroHotProduct->category->name ?? 'Rush Deal' }}
                                </span>
                                <div class="flex items-center text-amber-500 font-bold text-xs">
                                    <span>★</span>
                                    <span class="ml-1 text-slate-700">{{ number_format($heroHotProduct->rating ?? 4.9, 1) }}</span>
                                </div>
                            </div>

                            <h3 class="text-sm sm:text-base font-bold text-slate-900 line-clamp-1 group-hover/card:text-amber-700 transition-colors">
                                {{ $heroHotProduct->title }}
                            </h3>

                            <div class="flex items-baseline justify-between pt-1.5 border-t border-slate-100">
                                <div>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Hot Deal Price</span>
                                    <span class="text-lg sm:text-xl font-black text-slate-900 leading-none">
                                        ৳{{ number_format($heroHotProduct->group_price) }}
                                    </span>
                                </div>
                                @if($heroHotProduct->price > $heroHotProduct->group_price)
                                <div class="text-right">
                                    <span class="text-[10px] font-semibold text-slate-400 block line-through">
                                        ৳{{ number_format($heroHotProduct->price) }}
                                    </span>
                                    <span class="text-xs font-bold text-emerald-600">
                                        Save ৳{{ number_format($heroHotProduct->price - $heroHotProduct->group_price) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endif
                </div>

            </div>

            <!-- ================= SLIDE 3: SOCIAL COMMERCE (Deep Royal Emerald & Cartiva Green Gradient) ================= -->
            <div class="w-full flex-shrink-0 grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 p-5 sm:p-8 lg:p-12 items-center min-h-[440px] sm:min-h-[460px] relative overflow-hidden text-white"
                 style="background: linear-gradient(135deg, #02241b 0%, #064e3b 30%, #0f5132 70%, #032b1f 100%);">
                
                <!-- Luminous Ambient Light Glows -->
                <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full bg-emerald-500/25 blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/3 top-1/2 -translate-y-1/2 w-80 h-80 rounded-full bg-green-500/15 blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -bottom-20 w-96 h-96 rounded-full bg-teal-600/30 blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[580px] h-[580px] rounded-full border border-white/5 pointer-events-none"></div>

                <!-- Left Column: Core Value Proposition -->
                <div class="lg:col-span-7 space-y-3.5 sm:space-y-5 relative z-10">
                    
                    <!-- Pill Tag -->
                    <div class="inline-flex items-center space-x-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-emerald-300 text-[11px] sm:text-xs font-bold uppercase tracking-wider shadow-sm">
                        <span>👥 CARTIVA SOCIAL COMMERCE</span>
                    </div>

                    <!-- Bold Headline & Slogan -->
                    <div>
                        <h2 class="text-xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-snug drop-shadow-sm">
                            "একা কিনলে সাধারণ দাম,
                        </h2>
                        <div class="text-2xl sm:text-4xl lg:text-5xl font-black text-emerald-300 tracking-tight leading-tight mt-1 sm:mt-1.5 drop-shadow-sm">
                            দল বাঁধলে পাইকারি দাম!"
                        </div>
                    </div>

                    <!-- Subtitle -->
                    <p class="text-xs sm:text-sm text-emerald-100/90 max-w-xl font-normal leading-relaxed line-clamp-2 sm:line-clamp-none">
                        অনলাইনে খুচরা মূল্যে অতিরিক্ত টাকা দেওয়ার দিন শেষ! বন্ধুদের সাথে বা সহ-ক্রেতাদের সাথে দল গঠন করে সরাসরি পাইকারি দামে পণ্য অর্ডার করুন। সময় শেষ হলে সফট কোটায় অটো ডেলিভারি অথবা ১০০% রিফান্ড গ্যারান্টি।
                    </p>

                    <!-- Trust Stats Row in Glass Cards -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-2.5 pt-1 max-w-md">
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-sm text-center sm:text-left">
                            <span class="text-emerald-200/80 block text-[8px] sm:text-[9px] uppercase font-bold tracking-wider">মোট সাশ্রয়</span>
                            <span class="text-xs sm:text-sm font-black text-emerald-300">৳{{ number_format($stats['total_saved'] ?? 2850000) }}+</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-sm text-center sm:text-left">
                            <span class="text-emerald-200/80 block text-[8px] sm:text-[9px] uppercase font-bold tracking-wider">সফল ডিল</span>
                            <span class="text-xs sm:text-sm font-black text-white">{{ number_format($stats['completed_groups'] ?? 1450) }}+</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-sm text-center sm:text-left">
                            <span class="text-emerald-200/80 block text-[8px] sm:text-[9px] uppercase font-bold tracking-wider">নিরাপত্তা</span>
                            <span class="text-xs sm:text-sm font-black text-emerald-300">১০০% রিফান্ড</span>
                        </div>
                    </div>

                    <!-- Dual Action Buttons -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 pt-2">
                        <a href="{{ route('group-pools.index') }}" 
                           class="px-5 sm:px-7 py-3 sm:py-3.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs sm:text-sm shadow-xl shadow-green-950/30 hover:shadow-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center space-x-2">
                            <span>Join Active Pool Now</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="#active-deals" 
                           class="px-4 sm:px-6 py-3 sm:py-3.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold text-xs sm:text-sm border border-white/30 hover:border-white/50 shadow-xs hover:-translate-y-0.5 transition-all">
                            Explore Deals &rarr;
                        </a>
                    </div>

                </div>

                <!-- Right Column: Luxury Framed Merchant Showcase Card -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end relative z-10 w-full">
                    @if($heroGroupProduct)
                    <a href="{{ route('products.show', $heroGroupProduct->slug) }}" 
                       class="group/card block w-full max-w-sm sm:max-w-md mx-auto rounded-3xl bg-white p-3.5 sm:p-5 border border-white/80 shadow-2xl shadow-black/35 hover:shadow-black/50 hover:-translate-y-1 transition-all duration-300 text-slate-900">
                        
                        <!-- Product Viewport Stage -->
                        <div class="relative w-full h-44 sm:h-56 rounded-2xl bg-gradient-to-b from-slate-50 to-slate-100/80 border border-slate-100 flex items-center justify-center p-3 overflow-hidden">
                            <!-- Team Buy Badge -->
                            <span class="absolute top-2.5 left-2.5 px-3 py-1 rounded-lg bg-[#53a318] text-white font-black text-xs shadow-md tracking-wide z-10">
                                👥 TEAM BUY
                            </span>
                            <!-- Save Tag -->
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-1 rounded-md bg-white/95 backdrop-blur-xs text-emerald-800 font-bold text-[10px] border border-emerald-200 shadow-2xs z-10">
                                Save {{ $heroGroupProduct->discount_percent ? $heroGroupProduct->discount_percent . '%' : '30%' }}
                            </span>

                            <img src="{{ $heroGroupProduct->image_url ?? ($heroGroupProduct->image ? asset('storage/' . $heroGroupProduct->image) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80') }}" 
                                 alt="{{ $heroGroupProduct->title }}" 
                                 class="max-h-full max-w-full object-contain group-hover/card:scale-105 transition-transform duration-500 drop-shadow-sm">
                        </div>

                        <!-- Product Information Strip -->
                        <div class="pt-3.5 space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                    {{ $heroGroupProduct->category->name ?? 'Group Buy' }}
                                </span>
                                <div class="flex items-center text-amber-500 font-bold text-xs">
                                    <span>★</span>
                                    <span class="ml-1 text-slate-700">{{ number_format($heroGroupProduct->rating ?? 4.8, 1) }}</span>
                                </div>
                            </div>

                            <h3 class="text-sm sm:text-base font-bold text-slate-900 line-clamp-1 group-hover/card:text-[#53a318] transition-colors">
                                {{ $heroGroupProduct->title }}
                            </h3>

                            <div class="flex items-baseline justify-between pt-1.5 border-t border-slate-100">
                                <div>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Wholesale Pool Price</span>
                                    <span class="text-lg sm:text-xl font-black text-[#53a318] leading-none">
                                        ৳{{ number_format($heroGroupProduct->group_price) }}
                                    </span>
                                </div>
                                @if($heroGroupProduct->price > $heroGroupProduct->group_price)
                                <div class="text-right">
                                    <span class="text-[10px] font-semibold text-slate-400 block line-through">
                                        ৳{{ number_format($heroGroupProduct->price) }}
                                    </span>
                                    <span class="text-xs font-bold text-emerald-600">
                                        Save ৳{{ number_format($heroGroupProduct->price - $heroGroupProduct->group_price) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endif
                </div>

            </div>

        </div>

        <!-- Left Navigation Arrow (Glassmorphism, Hidden on small mobile screens to prevent overlay clutter) -->
        <button @click="prev()" 
                aria-label="Previous Slide" 
                class="hidden sm:flex absolute left-3.5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/40 hover:bg-black/60 backdrop-blur-md border border-white/25 text-white shadow-xl items-center justify-center transition-all z-20 hover:scale-110 active:scale-95 focus:outline-hidden opacity-0 group-hover:opacity-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Right Navigation Arrow (Glassmorphism, Hidden on small mobile screens) -->
        <button @click="next()" 
                aria-label="Next Slide" 
                class="hidden sm:flex absolute right-3.5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/40 hover:bg-black/60 backdrop-blur-md border border-white/25 text-white shadow-xl items-center justify-center transition-all z-20 hover:scale-110 active:scale-95 focus:outline-hidden opacity-0 group-hover:opacity-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Bottom Dot Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center space-x-2 z-20">
            <button @click="goTo(0)" 
                    class="h-2 rounded-full transition-all duration-300 shadow-sm cursor-pointer"
                    :class="activeSlide === 0 ? 'w-8 bg-amber-400' : 'w-2.5 bg-white/40 hover:bg-white/70'"></button>
            <button @click="goTo(1)" 
                    class="h-2 rounded-full transition-all duration-300 shadow-sm cursor-pointer"
                    :class="activeSlide === 1 ? 'w-8 bg-amber-400' : 'w-2.5 bg-white/40 hover:bg-white/70'"></button>
            <button @click="goTo(2)" 
                    class="h-2 rounded-full transition-all duration-300 shadow-sm cursor-pointer"
                    :class="activeSlide === 2 ? 'w-8 bg-amber-400' : 'w-2.5 bg-white/40 hover:bg-white/70'"></button>
        </div>
    </section>


    <!-- ========================================================
         2.5 TOP CATEGORIES STRIP (ORIGINAL SOCIAL COMMERCE NAVIGATION)
         ======================================================== -->
    @php
        $currentCat = request('category');
        $topNavCategories = [
            [
                'name' => 'Laptops & PC',
                'slug' => 'computers-accessories',
                'bg' => 'bg-emerald-50 group-hover:bg-emerald-100',
                'border' => 'border-emerald-200/70',
                'svg' => '<svg class="w-7 h-7 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2" fill="#10b981" fill-opacity="0.15"/><path d="M2 20h20"/><path d="M10 16h4"/></svg>'
            ],
            [
                'name' => 'Audio & Sound',
                'slug' => 'smart-tech-audio',
                'bg' => 'bg-cyan-50 group-hover:bg-cyan-100',
                'border' => 'border-cyan-200/70',
                'svg' => '<svg class="w-7 h-7 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3" fill="#06b6d4" fill-opacity="0.15"/></svg>'
            ],
            [
                'name' => 'Mobiles & Tabs',
                'slug' => 'mobile-accessories',
                'bg' => 'bg-blue-50 group-hover:bg-blue-100',
                'border' => 'border-blue-200/70',
                'svg' => '<svg class="w-7 h-7 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="3" fill="#3b82f6" fill-opacity="0.15"/><path d="M12 18h.01"/><path d="M10 5h4"/></svg>'
            ],
            [
                'name' => 'Smartwatches',
                'slug' => 'wearables-watches',
                'bg' => 'bg-purple-50 group-hover:bg-purple-100',
                'border' => 'border-purple-200/70',
                'svg' => '<svg class="w-7 h-7 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="6" width="14" height="12" rx="3" fill="#a855f7" fill-opacity="0.15"/><path d="M9 2h6l-.8 4H9.8L9 2z"/><path d="M9 22h6l-.8-4H9.8L9 22z"/><circle cx="12" cy="12" r="2"/></svg>'
            ],
            [
                'name' => 'Gaming Gear',
                'slug' => 'computing-gaming',
                'bg' => 'bg-rose-50 group-hover:bg-rose-100',
                'border' => 'border-rose-200/70',
                'svg' => '<svg class="w-7 h-7 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="4" fill="#f43f5e" fill-opacity="0.15"/><path d="M6 12h4m-2-2v4"/><circle cx="15" cy="11" r="1" fill="currentColor"/><circle cx="17" cy="13" r="1" fill="currentColor"/></svg>'
            ],
            [
                'name' => 'Winter Apparel',
                'slug' => 'winter-specials',
                'bg' => 'bg-amber-50 group-hover:bg-amber-100',
                'border' => 'border-amber-200/70',
                'svg' => '<svg class="w-7 h-7 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.5a2 2 0 0 0 1.98 1.67H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10.86h1.16a2 2 0 0 0 1.98-1.67l.58-3.5a2 2 0 0 0-1.34-2.23z" fill="#f59e0b" fill-opacity="0.15"/><path d="M12 6v6"/></svg>'
            ],
            [
                'name' => 'Kitchen Gear',
                'slug' => 'kitchen-appliances',
                'bg' => 'bg-orange-50 group-hover:bg-orange-100',
                'border' => 'border-orange-200/70',
                'svg' => '<svg class="w-7 h-7 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2v6a4 4 0 0 0 8 0V2"/><path d="M10 12v10"/><path d="M18 2v20" fill="#f97316" fill-opacity="0.15"/></svg>'
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'bg' => 'bg-indigo-50 group-hover:bg-indigo-100',
                'border' => 'border-indigo-200/70',
                'svg' => '<svg class="w-7 h-7 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="#6366f1" fill-opacity="0.15"/><path d="M9 22V12h6v10"/></svg>'
            ],
            [
                'name' => 'Grocery & Food',
                'slug' => 'dry-food-fmcg',
                'bg' => 'bg-green-50 group-hover:bg-green-100',
                'border' => 'border-green-200/70',
                'svg' => '<svg class="w-7 h-7 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" fill="#22c55e" fill-opacity="0.15"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>'
            ],
            [
                'name' => 'Bags & Travel',
                'slug' => 'fashion-bags',
                'bg' => 'bg-teal-50 group-hover:bg-teal-100',
                'border' => 'border-teal-200/70',
                'svg' => '<svg class="w-7 h-7 text-teal-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="6" width="16" height="15" rx="3" fill="#14b8a6" fill-opacity="0.15"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M4 11h16"/></svg>'
            ],
        ];
    @endphp
    <section class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-4 sm:p-5 space-y-4" x-data="categoriesSlider()" x-init="init()">
        
        <!-- Header Row -->
        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div class="flex items-center space-x-2.5">
                <span class="w-2.5 h-5 rounded-full bg-[#53a318]"></span>
                <h2 class="text-sm sm:text-base font-black text-slate-900 tracking-tight flex items-center gap-1.5">
                    <span>Top Categories</span>
                </h2>
                @if($currentCat)
                    <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[#53a318] text-[11px] font-bold">
                        <span>Active: {{ ucwords(str_replace('-', ' ', $currentCat)) }}</span>
                        <a href="{{ route('home') }}" class="hover:text-emerald-950 font-black ml-0.5" title="Clear category filter">&times;</a>
                    </div>
                @endif
            </div>
            
            <div class="flex items-center space-x-2 shrink-0">
                @if($currentCat)
                    <a href="{{ route('home') }}" class="font-bold text-slate-500 hover:text-rose-600 transition-colors text-xs mr-1">
                        ✕ Clear Filter
                    </a>
                @endif
                <!-- See all categories -> goes to categories page -->
                <a href="{{ route('categories.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-[#53a318] hover:text-[#418212] px-3.5 py-2 rounded-xl border border-slate-200 hover:border-[#53a318] bg-white transition-all shadow-2xs group">
                    <span>See all</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <!-- Left / Right Manual Navigation Arrows -->
                <div class="flex items-center space-x-1">
                    <button type="button" @click="scrollPrev()" aria-label="Previous Category" 
                            class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-[#53a318] hover:border-[#53a318] flex items-center justify-center shadow-2xs transition-all active:scale-90 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" @click="scrollNext()" aria-label="Next Category" 
                            class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-[#53a318] hover:border-[#53a318] flex items-center justify-center shadow-2xs transition-all active:scale-90 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Horizontal Animated Transition Track -->
        <div x-ref="catSlider" 
             @mouseenter="isHovered = true" 
             @mouseleave="isHovered = false"
             class="flex items-stretch gap-3 overflow-x-auto no-scrollbar scroll-smooth pb-2 pt-1 -mx-4 px-4 sm:mx-0 sm:px-0 select-none">
            @foreach($topNavCategories as $item)
                @php
                    $isItemActive = ($currentCat === $item['slug']) 
                        || ($item['slug'] === 'smart-tech-audio' && $currentCat === 'tech-accessories')
                        || ($item['slug'] === 'home-living' && $currentCat === 'home-lifestyle');
                @endphp
                <a href="{{ route('category.show', $item['slug']) }}" 
                   class="category-slider-card flex-none flex flex-col items-center justify-center p-3 rounded-2xl {{ $isItemActive ? 'bg-emerald-50/70 border-2 border-[#53a318] ring-2 ring-[#53a318]/20 shadow-sm' : 'bg-white hover:bg-slate-50/80 border border-slate-200/80 hover:border-[#53a318]' }} shadow-2xs hover:shadow-md hover:-translate-y-1 transition-all duration-200 group text-center cursor-pointer relative"
                   style="width: 140px; min-width: 140px; max-width: 140px;">
                    
                    @if($isItemActive)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#53a318]"></span>
                    @endif

                    <!-- Big Icon Box -->
                    <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl {{ $item['bg'] }} border {{ $item['border'] }} flex items-center justify-center transition-all group-hover:scale-110 shadow-2xs">
                        {!! $item['svg'] !!}
                    </div>
                    
                    <!-- English Title -->
                    <span class="text-[11px] sm:text-xs font-bold {{ $isItemActive ? 'text-[#53a318]' : 'text-slate-800' }} group-hover:text-[#53a318] transition-colors mt-2 text-center leading-tight truncate w-full px-1">
                        {{ $item['name'] }}
                    </span>
                </a>
            @endforeach
        </div>

    </section>


    <!-- ========================================================
         2.5 HOT DEALS / ALMOST FILLED POOLS (ANIMATED TRANSITION CAROUSEL)
         ======================================================== -->
    @if(isset($urgentGroups) && $urgentGroups->count() > 0)
    <section id="urgent-pools" class="space-y-4" x-data="hotDealsSlider()" x-init="init()">
        
        <!-- Section Header with Real-Time Badges & Animated Controls -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200/80 pb-3">
            <div class="flex items-center space-x-3">
                <span class="relative flex items-center justify-center w-10 h-10 rounded-2xl bg-gradient-to-tr from-rose-500 to-amber-500 text-white shadow-md shadow-rose-500/25">
                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-rose-500 border-2 border-white animate-ping"></span>
                </span>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight flex items-center gap-1.5">
                            <span> HOT DEAL-শেষ মুহূর্তের অফার</span>
                        
                        </h2>
                       
                    </div>
                  
                </div>
            </div>

            <!-- Carousel Controls: Auto-slide Indicator & Manual Arrows -->
            <div class="flex items-center space-x-2 shrink-0">
               
                <!-- See All Hot Deals Link -->
                <a href="{{ route('hot-deals.index') }}" 
                   class="inline-flex items-center space-x-1.5 text-xs font-bold text-[#53a318] hover:text-[#418212] px-3.5 py-2 rounded-xl border border-slate-200 hover:border-[#53a318] bg-white transition-all shadow-2xs group">
                    <span>See all</span>
                    <svg class="w-3.5 h-3.5 text-[#53a318] group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <!-- Left / Right Manual Navigation Arrows -->
                <div class="flex items-center space-x-1">
                    <button type="button" @click="scrollPrev()" aria-label="Previous Deals" 
                            class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-[#53a318] hover:border-[#53a318] flex items-center justify-center shadow-2xs transition-all active:scale-90 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" @click="scrollNext()" aria-label="Next Deals" 
                            class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-[#53a318] hover:border-[#53a318] flex items-center justify-center shadow-2xs transition-all active:scale-90 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Horizontal Animated Transition Track (Smooth Left-to-Right Flow with Hover-Pause) -->
        <div x-ref="hotSlider" 
             @mouseenter="isHovered = true" 
             @mouseleave="isHovered = false"
             class="flex items-stretch gap-4 sm:gap-5 overflow-x-auto no-scrollbar scroll-smooth pb-3 pt-1 -mx-4 px-4 sm:mx-0 sm:px-0 select-none">
            @foreach($urgentGroups as $group)
                @php
                    $discountPct = round((($group->product->single_price - $group->product->group_price) / $group->product->single_price) * 100);
                    $needed = max(1, $group->required_members - $group->current_members);
                    $pct = min(100, round(($group->current_members / $group->required_members) * 100));
                    $rawCat = $group->product->category->name ?? 'General';
                    $cleanCat = preg_match('/\((.*?)\)/', $rawCat, $m) ? $m[1] : $rawCat;
                    $saveAmount = $group->product->single_price - $group->product->group_price;
                    $remainingSecs = max(0, (int) now()->diffInSeconds($group->expires_at, false));
                    $joinedMembers = $group->members->take(4);
                @endphp
                <div class="hot-deal-card flex-none bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-lg hover:border-[#53a318] hover:-translate-y-1 transition-all duration-300 p-3.5 flex flex-col justify-between relative group overflow-hidden"
                     style="width: 265px; min-width: 265px; max-width: 265px;"
                     x-data="groupCountdown({{ $remainingSecs }})"
                     x-init="start()">
                    
                    <div class="space-y-2.5 relative z-10">
                        <!-- Top Urgency Pill & Monospace Digital Timer -->
                        <div class="flex items-center justify-between gap-1.5">
                            @if($needed === 1)
                                <span class="px-2 py-0.5 rounded-lg bg-rose-600 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                    <span>Slot left</span>
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-lg bg-amber-500 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                    <span>{{ $needed }} Slot left</span>
                                </span>
                            @endif

                            <span class="inline-flex items-center space-x-1 font-mono text-[10px] font-black text-rose-700 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-200/80">
                                <svg class="w-3 h-3 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span x-text="timeString"></span>
                            </span>
                        </div>

                        <!-- Product Thumbnail with Fixed Compact Height -->
                        <a href="{{ route('products.show', $group->product->slug) }}" class="block relative w-full h-36 rounded-xl overflow-hidden bg-slate-100 group/img shadow-inner">
                            <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300">
                            
                            <!-- Discount Badge -->
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[9px] font-black bg-rose-600 text-white shadow-2xs tracking-tight">
                                -{{ $discountPct }}%
                            </span>

                            <!-- Room Code Pill -->
                            <span class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded text-[8px] font-mono font-bold bg-slate-950/80 text-emerald-300 backdrop-blur-xs">
                                {{ $group->group_code }}
                            </span>

                            <!-- Low Stock Alert Badge -->
                            <span class="absolute bottom-2 left-2 px-1.5 py-0.5 rounded text-[8px] font-bold bg-amber-400 text-slate-950 shadow-2xs">
                                সীমিত স্টক
                            </span>
                        </a>

                        <!-- Product Title & Category -->
                        <div class="space-y-0.5">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-[#53a318] block truncate">
                                {{ $cleanCat }}
                            </span>

                            <h3 class="text-xs font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors min-h-[2rem]">
                                <a href="{{ route('products.show', $group->product->slug) }}">
                                    {{ $group->product->title }}
                                </a>
                            </h3>
                            
                            <!-- Pricing & Savings Comparison -->
                            <div class="pt-1 flex items-baseline justify-between flex-wrap gap-1">
                                <div class="flex items-baseline space-x-1.5">
                                    <span class="text-base font-black text-[#53a318]">৳{{ number_format($group->product->group_price) }}</span>
                                    <span class="text-[11px] text-slate-400 line-through">৳{{ number_format($group->product->single_price) }}</span>
                                </div>
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-[#53a318] border border-emerald-200/80">
                                    সাশ্রয় ৳{{ number_format($saveAmount) }}
                                </span>
                            </div>
                        </div>

                        <!-- Social Proof: Avatar Stack of Members + Missing Slot -->
                        <div class="pt-1 border-t border-slate-100 flex items-center justify-between text-[10px]">
                            <div class="flex items-center -space-x-1 overflow-hidden">
                                @foreach($joinedMembers as $member)
                                    <div class="w-5 h-5 rounded-full bg-slate-800 text-white border border-white flex items-center justify-center text-[8px] font-bold" 
                                         title="{{ $member->user->name ?? 'Customer' }}">
                                        {{ strtoupper(substr($member->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endforeach
                                <!-- Empty Pulsing Slot -->
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
                            <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full" 
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>

                    <!-- Action CTAs: Direct 1-Click Join -->
                    <div class="pt-2.5 relative z-10">
                        <a href="{{ route('group-buy.show', $group->group_code) }}" 
                           class="w-full py-2 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs hover:shadow-md flex items-center justify-center space-x-1.5 active:scale-95">
                            <span>Join Slot</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- ========================================================
         2.6 FLASH SALES (RIGHT-TO-LEFT ANIMATED TRANSITION CAROUSEL)
         Matching Hot Deals Box Size & Smooth Auto-Slide
         ======================================================== -->
    @if(isset($flashDeals) && $flashDeals->count() > 0)
    <section id="flash-sales" class="space-y-4" x-data="flashSalesSlider()" x-init="init()">
        
        <!-- Header Row -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200/80 pb-3">
            <div class="flex items-center space-x-3">
                <span class="relative flex items-center justify-center w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white shadow-md shadow-amber-500/25">
                    <span class="text-xl">⚡</span>
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-amber-400 border-2 border-white animate-ping"></span>
                </span>
                <div>
                    <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight flex items-center gap-1.5">
                        <span>Flash Sales - ধামাকা ফ্ল্যাশ ডিলস</span>
                    </h2>
                </div>
            </div>

            <!-- Controls: See All Link & Left/Right Navigation Arrows -->
            <div class="flex items-center space-x-2 shrink-0">
                <!-- See All Flash Sales Link (Goes to Flash Sales Page) -->
                <a href="{{ route('flash-sales.index') }}" 
                   class="inline-flex items-center space-x-1.5 text-xs font-bold text-[#53a318] hover:text-[#418212] px-3.5 py-2 rounded-xl border border-slate-200 hover:border-[#53a318] bg-white transition-all shadow-2xs group">
                    <span>See all</span>
                    <svg class="w-3.5 h-3.5 text-[#53a318] group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <!-- Left / Right Manual Navigation Arrows -->
                <div class="flex items-center space-x-1">
                    <button type="button" @click="scrollPrev()" aria-label="Previous Flash Deal" 
                            class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-[#53a318] hover:border-[#53a318] flex items-center justify-center shadow-2xs transition-all active:scale-90 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" @click="scrollNext()" aria-label="Next Flash Deal" 
                            class="w-9 h-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-[#53a318] hover:border-[#53a318] flex items-center justify-center shadow-2xs transition-all active:scale-90 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Horizontal Animated Transition Track (Matching Hot Deals Exact Box Size) -->
        <div x-ref="flashSlider" 
             @mouseenter="isHovered = true" 
             @mouseleave="isHovered = false"
             class="flex items-stretch gap-4 sm:gap-5 overflow-x-auto no-scrollbar scroll-smooth pb-3 pt-1 -mx-4 px-4 sm:mx-0 sm:px-0 select-none">
            @foreach($flashDeals as $product)
                @php
                    $discountPct = round((($product->single_price - $product->group_price) / max(1, $product->single_price)) * 100);
                    $saveAmount = $product->single_price - $product->group_price;
                    $rawCat = $product->category->name ?? 'General';
                    $cleanCat = preg_match('/\((.*?)\)/', $rawCat, $m) ? $m[1] : $rawCat;
                    $activeSession = $product->activeGroupSessions->first();
                @endphp
                <div class="flash-deal-card flex-none bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-lg hover:border-[#53a318] hover:-translate-y-1 transition-all duration-300 p-3.5 flex flex-col justify-between relative group overflow-hidden"
                     style="width: 265px; min-width: 265px; max-width: 265px;">
                    
                    <div class="space-y-2.5 relative z-10">
                        <!-- Top Pill & Stock Indicator -->
                        <div class="flex items-center justify-between gap-1.5">
                            <span class="px-2 py-0.5 rounded-lg bg-amber-500 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                <span>⚡ Flash Deal</span>
                            </span>

                            <span class="inline-flex items-center space-x-1 font-mono text-[10px] font-black text-amber-700 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-200/80">
                                <span>{{ $product->stock ?? 12 }} pcs left</span>
                            </span>
                        </div>

                        <!-- Product Thumbnail with Fixed Compact Height -->
                        <a href="{{ route('products.show', $product->slug) }}" class="block relative w-full h-36 rounded-xl overflow-hidden bg-slate-100 group/img shadow-inner">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300">
                            
                            <!-- Discount Badge -->
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[9px] font-black bg-rose-600 text-white shadow-2xs tracking-tight">
                                -{{ $discountPct }}%
                            </span>

                            @if($activeSession)
                                <!-- Room Code Pill -->
                                <span class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded text-[8px] font-mono font-bold bg-slate-950/80 text-emerald-300 backdrop-blur-xs">
                                    {{ $activeSession->group_code }}
                                </span>
                            @endif
                        </a>

                        <!-- Product Title & Category -->
                        <div class="space-y-0.5">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-[#53a318] block truncate">
                                {{ $cleanCat }}
                            </span>

                            <h3 class="text-xs font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors min-h-[2rem]">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->title }}
                                </a>
                            </h3>
                            
                            <!-- Pricing & Savings Comparison -->
                            <div class="pt-1 flex items-baseline justify-between flex-wrap gap-1">
                                <div class="flex items-baseline space-x-1.5">
                                    <span class="text-base font-black text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                    <span class="text-[11px] text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                                </div>
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-[#53a318] border border-emerald-200/80">
                                    সাশ্রয় ৳{{ number_format($saveAmount) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-2">
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="flex-1 py-2 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs text-center transition-all shadow-xs flex items-center justify-center space-x-1 active:scale-95">
                            <span>Join Deal</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <button type="button" 
                                @click="window.addToCart({ id: {{ $product->id }}, title: '{{ addslashes($product->title) }}', price: {{ $product->group_price }}, image: '{{ $product->image_url }}', slug: '{{ $product->slug }}' })" 
                                title="কার্টে যোগ করুন (Add to Cart)"
                                class="w-9 h-9 shrink-0 rounded-xl bg-slate-100 hover:bg-[#53a318] text-slate-700 hover:text-white transition-colors flex items-center justify-center cursor-pointer border border-slate-200/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </button>
                    </div>

                </div>
            @endforeach
        </div>
    </section>
    @endif



    <!-- ========================================================
         2.7 AUTHORIZED BRAND PARTNERS & WHOLESALE SOURCING STRIP (RYANS-STYLE TRUST)
         ======================================================== -->
    <section class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-5 sm:p-6 space-y-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-[#53a318]"></span>
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">AUTHENTIC WHOLESALE PARTNERS</span>
                </div>
                <h3 class="text-sm sm:text-base font-black text-slate-900 tracking-tight mt-0.5">
                    Authorized Brand Partners & Wholesale Sourcing
                </h3>
            </div>

        </div>

        <!-- Brand Cards Grid (8 Core Sourcing Brands) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2.5 sm:gap-3">
            
            <!-- Brand 1: Anker / SoundCore -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-blue-400 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-blue-600 transition-colors">ANKER</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Sound & Power</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-blue-100 text-blue-700">18M Warranty</span>
            </div>

            <!-- Brand 2: Sony -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-slate-800 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-slate-950 transition-colors">SONY</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Audio & Optics</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-slate-200 text-slate-800">Auth Dealer</span>
            </div>

            <!-- Brand 3: Xiaomi -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-orange-400 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-orange-600 transition-colors">XIAOMI</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Smart Living</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-orange-100 text-orange-700">Global Hub</span>
            </div>

            <!-- Brand 4: Baseus -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-amber-400 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-amber-600 transition-colors">BASEUS</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Fast Chargers</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-amber-100 text-amber-800">Direct Pool</span>
            </div>

            <!-- Brand 5: Logitech -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-cyan-400 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-cyan-600 transition-colors">LOGITECH</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Productivity</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-cyan-100 text-cyan-800">Official Tech</span>
            </div>

            <!-- Brand 6: Philips -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-blue-400 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-blue-700 transition-colors">PHILIPS</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Home Appliance</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-blue-100 text-blue-800">2-Year Cover</span>
            </div>

            <!-- Brand 7: Keychron -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-rose-400 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-rose-600 transition-colors">KEYCHRON</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Mechanical PC</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-rose-100 text-rose-700">Official Dist</span>
            </div>

            <!-- Brand 8: Remax -->
            <div class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/90 border border-slate-200/70 hover:border-emerald-400 transition-all flex flex-col items-center text-center space-y-1.5 group cursor-default">
                <span class="text-sm font-black text-slate-800 tracking-tight group-hover:text-emerald-600 transition-colors">REMAX</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Mobile Gadgets</span>
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-emerald-100 text-[#53a318]">Direct Import</span>
            </div>

        </div>

        <!-- Micro-Assurance Footnote -->
        <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-slate-100 text-[11px] font-bold text-slate-500">
            <div class="flex items-center space-x-1.5">
                <span class="text-[#53a318]">🛡️</span>
                <span>১০০% অথেনটিক ব্র্যান্ড ওয়ারেন্টি</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="text-cyan-600">⚡</span>
                <span>বাল্ক অর্ডারে সরাসরি পাইকারি আমদানি রেট</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="text-amber-500">🔒</span>
                <span>গ্রুপ অপূর্ণ থাকলে ১০০% ইনস্ট্যান্ট রিফান্ড</span>
            </div>
        </div>

    </section>


    <!-- ========================================================
         3. "HOW IT WORKS" (CONNECTED CIRCULAR ENERGY PIPELINE)
         Concept 2: Interactive SVG Circuit Beam, Circular Progress HUD,
                    Chain Reaction Flow & Real-time Energy Particles
         ======================================================== -->
    <section id="how-it-works" class="space-y-8 py-6 select-none"
             x-data="{
                activeStep: 1,
                maxUnlocked: 2,
                autoPlayTimer: null,
                isHovered: false,
                stepInfo: [
                    { num: 1, pct: 25, title: 'ডিল ও পণ্য বাছাই' },
                    { num: 2, pct: 50, title: 'গ্রুপে জয়েন বা গঠন' },
                    { num: 3, pct: 75, title: 'ইনভাইট ও শেয়ার' },
                    { num: 4, pct: 100, title: 'পাইকারি ডেলিভারি' }
                ],
                hoverStep(step) {
                    this.activeStep = step;
                    this.maxUnlocked = Math.max(this.maxUnlocked, Math.min(step + 1, 4));
                    this.isHovered = true;
                    this.clearTimer();
                },
                leaveStep() {
                    this.isHovered = false;
                    this.resetTimer();
                },
                startAutoPlay() {
                    this.clearTimer();
                    this.autoPlayTimer = setInterval(() => {
                        if (!this.isHovered) {
                            this.activeStep = (this.activeStep % 4) + 1;
                            this.maxUnlocked = Math.max(this.maxUnlocked, Math.min(this.activeStep + 1, 4));
                        }
                    }, 4200);
                },
                clearTimer() {
                    if (this.autoPlayTimer) {
                        clearInterval(this.autoPlayTimer);
                        this.autoPlayTimer = null;
                    }
                },
                resetTimer() {
                    this.clearTimer();
                    setTimeout(() => {
                        if (!this.isHovered) this.startAutoPlay();
                    }, 2500);
                }
             }"
             x-init="startAutoPlay()">

        <!-- Section Header with Dynamic Circular Progress HUD -->
        <div class="flex flex-col items-center text-center max-w-3xl mx-auto space-y-3 px-4">
            
            <!-- Rotating Circular Progress Bar HUD Pill -->
            <div class="inline-flex items-center space-x-3 px-4 py-2 rounded-full bg-white border border-slate-200/90 shadow-sm hover:shadow-md transition-all duration-300">
                <!-- SVG Circular Rotating Progress Gauge -->
                <div class="relative w-10 h-10 flex items-center justify-center shrink-0">
                    <svg class="w-10 h-10 -rotate-90 transform" viewBox="0 0 36 36">
                        <!-- Track Background -->
                        <path class="text-slate-100" stroke-width="3.5" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <!-- Animated Progress Stroke -->
                        <path class="transition-all duration-700 ease-out" 
                              :class="{
                                  'text-[#53a318]': activeStep === 1,
                                  'text-amber-500': activeStep === 2,
                                  'text-sky-500': activeStep === 3,
                                  'text-purple-600': activeStep === 4
                              }"
                              stroke-width="3.8" 
                              stroke-linecap="round"
                              stroke="currentColor" 
                              fill="none"
                              :stroke-dasharray="(activeStep * 25) + ', 100'"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <!-- Percentage text in center -->
                    <span class="absolute font-black font-mono text-[11px] text-slate-800" 
                          x-text="(activeStep * 25) + '%'"></span>
                </div>

                <!-- Active Step Description Label -->
                <div class="text-left pr-1">
                    <div class="flex items-center space-x-1.5">
                        <span class="w-1.5 h-1.5 rounded-full"
                              :class="{
                                  'bg-[#53a318]': activeStep === 1,
                                  'bg-amber-500': activeStep === 2,
                                  'bg-sky-500': activeStep === 3,
                                  'bg-purple-600': activeStep === 4
                              }"></span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400"
                              x-text="'ধাপ ০' + activeStep + ' / ০৪'">
                        </span>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block leading-tight" 
                          x-text="stepInfo[activeStep - 1].title">
                    </span>
                </div>
            </div>

            <!-- Main Heading & Subtitle -->
            <div class="space-y-1.5 pt-1">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Cartiva কিভাবে কাজ করে?
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                    ৪টি সহজ ধাপে যৌথ কেনাকাটার মাধ্যমে পাইকারি সাশ্রয় উপভোগ করুন।
                </p>
            </div>

        </div>

        <!-- Connected Circular Energy Pipeline Container -->
        <div class="relative pt-6 pb-2">
            
            <!-- Glowing Circuit Line (SVG Beam behind the circles on Desktop & Tablet) -->
            <div class="hidden lg:block absolute top-[54px] left-[12.5%] right-[12.5%] h-6 z-0 pointer-events-none">
                <svg class="w-full h-8 overflow-visible" preserveAspectRatio="none" viewBox="0 0 1000 24">
                    <defs>
                        <!-- Glow Filters -->
                        <filter id="circuitGlow1" x="-20%" y="-40%" width="140%" height="180%">
                            <feGaussianBlur stdDeviation="3.5" result="blur" />
                            <feMerge>
                                <feMergeNode in="blur" />
                                <feMergeNode in="SourceGraphic" />
                            </feMerge>
                        </filter>
                        <!-- Gradients for the 3 connecting segments -->
                        <linearGradient id="beamGrad1" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#53a318" />
                            <stop offset="100%" stop-color="#f59e0b" />
                        </linearGradient>
                        <linearGradient id="beamGrad2" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#f59e0b" />
                            <stop offset="100%" stop-color="#0284c7" />
                        </linearGradient>
                        <linearGradient id="beamGrad3" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#0284c7" />
                            <stop offset="100%" stop-color="#7c3aed" />
                        </linearGradient>
                    </defs>

                    <!-- Segment 1 -> 2 (0 to 333) -->
                    <line x1="0" y1="12" x2="333" y2="12" stroke="#e2e8f0" stroke-width="4" stroke-dasharray="6 6" />
                    <line x1="0" y1="12" x2="333" y2="12" stroke="url(#beamGrad1)" stroke-width="4.5" stroke-linecap="round" filter="url(#circuitGlow1)"
                          class="transition-all duration-700 ease-out"
                          :stroke-dasharray="activeStep >= 1 ? '333' : '0'" stroke-dashoffset="0" />

                    <!-- Segment 2 -> 3 (333 to 666) -->
                    <line x1="333" y1="12" x2="666" y2="12" stroke="#e2e8f0" stroke-width="4" stroke-dasharray="6 6" />
                    <line x1="333" y1="12" x2="666" y2="12" stroke="url(#beamGrad2)" stroke-width="4.5" stroke-linecap="round" filter="url(#circuitGlow1)"
                          class="transition-all duration-700 ease-out"
                          :stroke-dasharray="activeStep >= 2 ? '333' : '0'" stroke-dashoffset="0" />

                    <!-- Segment 3 -> 4 (666 to 1000) -->
                    <line x1="666" y1="12" x2="1000" y2="12" stroke="#e2e8f0" stroke-width="4" stroke-dasharray="6 6" />
                    <line x1="666" y1="12" x2="1000" y2="12" stroke="url(#beamGrad3)" stroke-width="4.5" stroke-linecap="round" filter="url(#circuitGlow1)"
                          class="transition-all duration-700 ease-out"
                          :stroke-dasharray="activeStep >= 3 ? '333' : '0'" stroke-dashoffset="0" />

                    <!-- Traveling Light Photons (Native Smooth SVG Particle Animation) -->
                    <!-- Particle 1 -> 2 -->
                    <g :class="activeStep === 1 ? 'opacity-100' : 'opacity-0'" class="transition-opacity duration-300">
                        <circle r="6" fill="#53a318" filter="url(#circuitGlow1)">
                            <animate attributeName="cx" from="0" to="333" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="cy" values="12;12" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="opacity" values="0.2;1;0.2" dur="1.3s" repeatCount="indefinite" />
                        </circle>
                        <circle r="3" fill="#ffffff">
                            <animate attributeName="cx" from="0" to="333" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="cy" values="12;12" dur="1.3s" repeatCount="indefinite" />
                        </circle>
                    </g>

                    <!-- Particle 2 -> 3 -->
                    <g :class="activeStep === 2 ? 'opacity-100' : 'opacity-0'" class="transition-opacity duration-300">
                        <circle r="6" fill="#f59e0b" filter="url(#circuitGlow1)">
                            <animate attributeName="cx" from="333" to="666" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="cy" values="12;12" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="opacity" values="0.2;1;0.2" dur="1.3s" repeatCount="indefinite" />
                        </circle>
                        <circle r="3" fill="#ffffff">
                            <animate attributeName="cx" from="333" to="666" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="cy" values="12;12" dur="1.3s" repeatCount="indefinite" />
                        </circle>
                    </g>

                    <!-- Particle 3 -> 4 -->
                    <g :class="activeStep === 3 ? 'opacity-100' : 'opacity-0'" class="transition-opacity duration-300">
                        <circle r="6" fill="#0284c7" filter="url(#circuitGlow1)">
                            <animate attributeName="cx" from="666" to="1000" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="cy" values="12;12" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="opacity" values="0.2;1;0.2" dur="1.3s" repeatCount="indefinite" />
                        </circle>
                        <circle r="3" fill="#ffffff">
                            <animate attributeName="cx" from="666" to="1000" dur="1.3s" repeatCount="indefinite" />
                            <animate attributeName="cy" values="12;12" dur="1.3s" repeatCount="indefinite" />
                        </circle>
                    </g>
                </svg>
            </div>

            <!-- 4 Connected Circular Step Stages -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-7 relative z-10">
                
                <!-- ================= STEP 01: CHOOSE A DEAL ================= -->
                <div @mouseenter="hoverStep(1)" 
                     @mouseleave="leaveStep()"
                     @click="hoverStep(1)"
                     class="flex flex-col items-center cursor-pointer group transition-all duration-300">
                    
                    <!-- Circular Node Sphere -->
                    <div class="relative w-22 h-22 sm:w-24 sm:h-24 rounded-full flex items-center justify-center transition-all duration-500 ease-out shadow-lg"
                         :class="{
                             'scale-115 -translate-y-2 ring-4 ring-[#53a318]/50 ring-offset-4 ring-offset-white bg-gradient-to-tr from-[#53a318] to-emerald-400 text-white shadow-emerald-500/35': activeStep === 1,
                             'ring-2 ring-emerald-300 bg-emerald-50 text-[#53a318] shadow-emerald-500/10': activeStep > 1,
                             'bg-white border-2 border-slate-200 text-slate-500 hover:border-slate-300': activeStep < 1
                         }">
                        
                        <!-- Step Number Badge (Pill at Top) -->
                        <span class="absolute -top-2 px-2.5 py-0.5 rounded-full text-[9px] font-black tracking-wider uppercase transition-colors shadow-xs"
                              :class="{
                                  'bg-white text-emerald-900 border border-emerald-200': activeStep === 1,
                                  'bg-emerald-600 text-white': activeStep > 1,
                                  'bg-slate-200 text-slate-700': activeStep < 1
                              }">
                            01
                        </span>

                        <!-- Main Icon -->
                        <span class="text-3xl sm:text-4xl transition-transform duration-300 group-hover:scale-110">🏷️</span>

                        <!-- Unlocked Checkmark (When finished) -->
                        <template x-if="activeStep > 1">
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-xs">
                                ✓
                            </span>
                        </template>
                    </div>

                    <!-- Step Content Card (Classic, Clean & Elegant) -->
                    <div class="w-full mt-5 rounded-2xl p-5 border transition-all duration-500 text-center space-y-2"
                         :class="{
                             'bg-white border-2 border-[#53a318] shadow-xl shadow-emerald-600/10 -translate-y-1': activeStep === 1,
                             'bg-white/80 border-slate-200/80 shadow-2xs hover:border-slate-300': activeStep !== 1
                         }">
                        <span class="inline-block text-[11px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full"
                              :class="activeStep === 1 ? 'bg-emerald-50 text-[#53a318]' : 'bg-slate-100 text-slate-500'">
                            ধাপ ০১
                        </span>
                        <h3 class="text-base font-black text-slate-900 transition-colors"
                            :class="activeStep === 1 ? 'text-[#53a318]' : ''">
                            ডিল ও পণ্য বাছাই
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            পছন্দের পণ্যটি নির্বাচন করে টিম ডিসকাউন্ট ডিল বেছে নিন।
                        </p>
                    </div>

                </div>

                <!-- ================= STEP 02: FORM OR JOIN A GROUP ================= -->
                <div @mouseenter="hoverStep(2)" 
                     @mouseleave="leaveStep()"
                     @click="hoverStep(2)"
                     class="flex flex-col items-center cursor-pointer group transition-all duration-300">
                    
                    <!-- Circular Node Sphere -->
                    <div class="relative w-22 h-22 sm:w-24 sm:h-24 rounded-full flex items-center justify-center transition-all duration-500 ease-out shadow-lg"
                         :class="{
                             'scale-115 -translate-y-2 ring-4 ring-amber-500/50 ring-offset-4 ring-offset-white bg-gradient-to-tr from-amber-500 to-orange-400 text-white shadow-amber-500/35': activeStep === 2,
                             'ring-2 ring-amber-300 bg-amber-50 text-amber-600 shadow-amber-500/10': activeStep > 2,
                             'ring-2 ring-amber-200/80 bg-amber-50/40 text-amber-700 animate-pulse': maxUnlocked >= 2 && activeStep < 2,
                             'bg-white border-2 border-slate-200 text-slate-400': maxUnlocked < 2
                         }">
                        
                        <!-- Step Number Badge -->
                        <span class="absolute -top-2 px-2.5 py-0.5 rounded-full text-[9px] font-black tracking-wider uppercase transition-colors shadow-xs"
                              :class="{
                                  'bg-white text-amber-900 border border-amber-200': activeStep === 2,
                                  'bg-amber-600 text-white': activeStep > 2,
                                  'bg-slate-200 text-slate-700': activeStep < 2
                              }">
                            02
                        </span>

                        <!-- Main Icon -->
                        <span class="text-3xl sm:text-4xl transition-transform duration-300 group-hover:scale-110">👥</span>

                        <!-- Unlocked Checkmark -->
                        <template x-if="activeStep > 2">
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-xs">
                                ✓
                            </span>
                        </template>
                    </div>

                    <!-- Step Content Card (Classic, Clean & Elegant) -->
                    <div class="w-full mt-5 rounded-2xl p-5 border transition-all duration-500 text-center space-y-2"
                         :class="{
                             'bg-white border-2 border-amber-500 shadow-xl shadow-amber-600/10 -translate-y-1': activeStep === 2,
                             'bg-white/80 border-slate-200/80 shadow-2xs hover:border-slate-300': activeStep !== 2
                         }">
                        <span class="inline-block text-[11px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full"
                              :class="activeStep === 2 ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-500'">
                            ধাপ ০২
                        </span>
                        <h3 class="text-base font-black text-slate-900 transition-colors"
                            :class="activeStep === 2 ? 'text-amber-600' : ''">
                            গ্রুপে জয়েন বা গঠন
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            চলমান কোনো পুলে যোগ দিন অথবা নিজের টিম গ্রুপ তৈরি করুন।
                        </p>
                    </div>

                </div>

                <!-- ================= STEP 03: SHARE & INVITE ================= -->
                <div @mouseenter="hoverStep(3)" 
                     @mouseleave="leaveStep()"
                     @click="hoverStep(3)"
                     class="flex flex-col items-center cursor-pointer group transition-all duration-300">
                    
                    <!-- Circular Node Sphere -->
                    <div class="relative w-22 h-22 sm:w-24 sm:h-24 rounded-full flex items-center justify-center transition-all duration-500 ease-out shadow-lg"
                         :class="{
                             'scale-115 -translate-y-2 ring-4 ring-sky-500/50 ring-offset-4 ring-offset-white bg-gradient-to-tr from-sky-500 to-blue-500 text-white shadow-sky-500/35': activeStep === 3,
                             'ring-2 ring-sky-300 bg-sky-50 text-sky-600 shadow-sky-500/10': activeStep > 3,
                             'ring-2 ring-sky-200/80 bg-sky-50/40 text-sky-700 animate-pulse': maxUnlocked >= 3 && activeStep < 3,
                             'bg-white border-2 border-slate-200 text-slate-400': maxUnlocked < 3
                         }">
                        
                        <!-- Step Number Badge -->
                        <span class="absolute -top-2 px-2.5 py-0.5 rounded-full text-[9px] font-black tracking-wider uppercase transition-colors shadow-xs"
                              :class="{
                                  'bg-white text-sky-900 border border-sky-200': activeStep === 3,
                                  'bg-sky-600 text-white': activeStep > 3,
                                  'bg-slate-200 text-slate-700': activeStep < 3
                              }">
                            03
                        </span>

                        <!-- Main Icon -->
                        <span class="text-3xl sm:text-4xl transition-transform duration-300 group-hover:scale-110">📲</span>

                        <!-- Unlocked Checkmark -->
                        <template x-if="activeStep > 3">
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-sky-500 text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-xs">
                                ✓
                            </span>
                        </template>
                    </div>

                    <!-- Step Content Card (Classic, Clean & Elegant) -->
                    <div class="w-full mt-5 rounded-2xl p-5 border transition-all duration-500 text-center space-y-2"
                         :class="{
                             'bg-white border-2 border-sky-500 shadow-xl shadow-sky-600/10 -translate-y-1': activeStep === 3,
                             'bg-white/80 border-slate-200/80 shadow-2xs hover:border-slate-300': activeStep !== 3
                         }">
                        <span class="inline-block text-[11px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full"
                              :class="activeStep === 3 ? 'bg-sky-50 text-sky-700' : 'bg-slate-100 text-slate-500'">
                            ধাপ ০৩
                        </span>
                        <h3 class="text-base font-black text-slate-900 transition-colors"
                            :class="activeStep === 3 ? 'text-sky-600' : ''">
                            ইনভাইট ও শেয়ার
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            বন্ধুদের সাথে লিঙ্ক শেয়ার করে দ্রুত গ্রুপের কোটা পূরণ করুন।
                        </p>
                    </div>

                </div>

                <!-- ================= STEP 04: UNLOCK & SHIP ================= -->
                <div @mouseenter="hoverStep(4)" 
                     @mouseleave="leaveStep()"
                     @click="hoverStep(4)"
                     class="flex flex-col items-center cursor-pointer group transition-all duration-300">
                    
                    <!-- Circular Node Sphere -->
                    <div class="relative w-22 h-22 sm:w-24 sm:h-24 rounded-full flex items-center justify-center transition-all duration-500 ease-out shadow-lg"
                         :class="{
                             'scale-115 -translate-y-2 ring-4 ring-purple-500/50 ring-offset-4 ring-offset-white bg-gradient-to-tr from-purple-600 to-indigo-500 text-white shadow-purple-500/35': activeStep === 4,
                             'ring-2 ring-purple-200/80 bg-purple-50/40 text-purple-700 animate-pulse': maxUnlocked >= 4 && activeStep < 4,
                             'bg-white border-2 border-slate-200 text-slate-400': maxUnlocked < 4
                         }">
                        
                        <!-- Step Number Badge -->
                        <span class="absolute -top-2 px-2.5 py-0.5 rounded-full text-[9px] font-black tracking-wider uppercase transition-colors shadow-xs"
                              :class="{
                                  'bg-white text-purple-900 border border-purple-200': activeStep === 4,
                                  'bg-slate-200 text-slate-700': activeStep < 4
                              }">
                            04
                        </span>

                        <!-- Main Icon -->
                        <span class="text-3xl sm:text-4xl transition-transform duration-300 group-hover:scale-110">📦</span>

                        <!-- Unlocked Celebration Badge -->
                        <template x-if="activeStep === 4">
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-purple-500 text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-xs animate-spin-slow">
                                ⚡
                            </span>
                        </template>
                    </div>

                    <!-- Step Content Card (Classic, Clean & Elegant) -->
                    <div class="w-full mt-5 rounded-2xl p-5 border transition-all duration-500 text-center space-y-2"
                         :class="{
                             'bg-white border-2 border-purple-600 shadow-xl shadow-purple-600/10 -translate-y-1': activeStep === 4,
                             'bg-white/80 border-slate-200/80 shadow-2xs hover:border-slate-300': activeStep !== 4
                         }">
                        <span class="inline-block text-[11px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full"
                              :class="activeStep === 4 ? 'bg-purple-50 text-purple-700' : 'bg-slate-100 text-slate-500'">
                            ধাপ ০৪
                        </span>
                        <h3 class="text-base font-black text-slate-900 transition-colors"
                            :class="activeStep === 4 ? 'text-purple-600' : ''">
                            পাইকারি ডেলিভারি
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            টার্গেট পূরণ হতেই সবার ঠিকানায় সরাসরি ডেলিভারি শুরু হবে।
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ========================================================
         5. SOURCING & PLATFORM ASSURANCE PILLARS
         ======================================================== -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
        <!-- Pillar 1: 100% Refund -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#53a318] flex items-center justify-center text-xl shrink-0 font-black">
                🛡️
            </div>
            <div class="space-y-1">
                <h4 class="text-xs font-black text-slate-900">১০০% অটো-রিফান্ড গ্যারান্টি</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    নির্ধারিত সময়ে পুল পূর্ণ না হলে কোনো প্রশ্ন ছাড়াই আপনার অ্যাকাউন্টে তাৎক্ষণিক সম্পূর্ণ টাকা স্বয়ংক্রিয়ভাবে ফেরত দেওয়া হবে।
                </p>
            </div>
        </div>

        <!-- Pillar 2: Separate Home Delivery -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0 font-black">
                📦
            </div>
            <div class="space-y-1">
                <h4 class="text-xs font-black text-slate-900">সবার ঠিকানায় আলাদা ডেলিভারি</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    গ্রুপে অন্য মেম্বার কে বা কোথায় থাকে তা দেখার বিষয় নয়; প্রত্যেকের পার্সেল নিজস্ব ঠিকানায় আলাদাভাবে হোম ডেলিভারি হবে।
                </p>
            </div>
        </div>

        <!-- Pillar 3: Authentic Factory Sourcing -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-3.5">
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
         7. MERCHANT / SELLER ACQUISITION SECTION
         Theme: Rich Emerald / Dark Navy B2B Gradient Banner
         ======================================================== -->
    <section id="seller-acquisition" class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-[#0a1f2e] to-[#0a200e] border border-slate-800 text-white p-8 sm:p-12 shadow-2xl">
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <div class="lg:col-span-8 space-y-4">
                <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-green-500/20 text-[#84cc16] text-[10px] font-black uppercase tracking-wider border border-green-500/30">
                    💼 B2B & SELLER HUB
                </span>

                <h2 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
                    "Sell in Bulk with Guaranteed Demand"<br>
                    <span class="text-[#84cc16]">বাল্ক সেল করুন নিশ্চিত বিক্রির নিশ্চয়তায়</span>
                </h2>

                <p class="text-xs sm:text-sm text-slate-300 max-w-xl leading-relaxed">
                    কার্টিভার মাধ্যমে খুচরা বিক্রির অনিশ্চয়তা দূর করুন। দলভিত্তিক কেনাকাটার মাধ্যমে একসাথে ডজন ও শত শত ইউনিটের অর্ডার পান সরাসরি আপনার শপে।
                </p>

                <!-- Bullet Points -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 space-y-1 backdrop-blur-xs">
                        <span class="text-emerald-400 font-black block">🛡️ Zero Unsold Inventory</span>
                        <p class="text-[11px] text-slate-300">অর্ডার কনফার্মেশনের পরেই বাল্ক পণ্য প্যাকেজিং ও শিপমেন্ট।</p>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 space-y-1 backdrop-blur-xs">
                        <span class="text-amber-300 font-black block">📦 Pre-Committed Volumes</span>
                        <p class="text-[11px] text-slate-300">গ্রাহকদের সমন্বিত চাহিদা অনুযায়ী বড় লটের বিক্রি নিশ্চিত।</p>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 space-y-1 backdrop-blur-xs">
                        <span class="text-cyan-300 font-black block">⚡ Low Commission</span>
                        <p class="text-[11px] text-slate-300">স্বচ্ছ ডিজিটাল পেমেন্ট ও সর্বনিম্ন প্ল্যাটফর্ম কমিশন রেট।</p>
                    </div>
                </div>
            </div>

            <!-- CTA Button Box -->
            <div class="lg:col-span-4 lg:text-right space-y-3">
                <a href="{{ route('register', ['role' => 'seller']) }}" 
                   class="inline-block w-full sm:w-auto px-8 py-4 rounded-2xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs sm:text-sm shadow-xl shadow-green-950/60 hover:scale-105 active:scale-95 transition-all text-center">
                    Register as a Seller / Merchant &rarr;
                </a>
                <p class="text-[11px] text-slate-400 lg:text-right">
                    যাচাইকৃত ট্রেড লাইসেন্স বা ভেরিফাইড বিজনেস এপ্রুভাল প্রয়োজন।
                </p>
            </div>

        </div>
    </section>


    <!-- ========================================================
         8. TRUST & POLICY BADGES (SAFETY REASSURANCE)
         Theme: 3 Elevated Professional Protection Pillars
         ======================================================== -->
    <section id="trust-policy" class="space-y-6 pt-2">
        
        <div class="text-center max-w-lg mx-auto space-y-2">
            
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                সুরক্ষা ও বিশ্বাসযোগ্যতা
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto">
                কার্টিভায় প্রতিটি অর্ডার ও লেনদেন শতভাগ নিরাপদ ও ঝুঁকিমুক্ত
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
            
            <!-- Pillar 1: 100% Auto-Refund Guarantee -->
            <div class="group relative bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 hover:border-emerald-300 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-[#53a318] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="space-y-3.5">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#53a318] flex items-center justify-center border border-emerald-100 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-[#53a318] transition-colors">
                            ১০০% অটো-রিফান্ড গ্যারান্টি
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1.5">
                            নির্ধারিত সময়ে গ্রুপের লক্ষ্য পূরণ না হলে কোনো ফি ছাড়াই সম্পূর্ণ টাকা তাৎক্ষণিক স্বয়ংক্রিয় ফেরত।
                        </p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 mt-4 flex items-center justify-between">
                    <button type="button" @click="rulesModalOpen = true" class="inline-flex items-center text-xs font-bold text-[#53a318] hover:text-emerald-700 transition-colors">
                        রিফান্ড পলিসি দেখুন
                        <svg class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                   
                </div>
            </div>

            <!-- Pillar 2: Secure Checkout -->
            <div class="group relative bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 hover:border-sky-300 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-400 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="space-y-3.5">
                    <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                            এসক্রো সুরক্ষিত পেমেন্ট
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1.5">
                            বিকাশ, নগদ, কার্ড বা ক্যাশ অন ডেলিভারি — পণ্য হাতে পাওয়া পর্যন্ত অর্থ সম্পূর্ণ নিরাপদ থাকে।
                        </p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 mt-4 flex items-center justify-between">
                    
                  
                </div>
            </div>

            <!-- Pillar 3: Verified Sellers -->
            <div class="group relative bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 hover:border-purple-300 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-400 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="space-y-3.5">
                    <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-purple-600 transition-colors">
                            ভেরিফাইড সেলার ও আসল পণ্য
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1.5">
                            অ্যাডমিন পরীক্ষিত জেনুইন মার্চেন্ট, শতভাগ আসল পণ্য এবং ৪৮ ঘণ্টার সহজ রিপ্লেসমেন্ট সুবিধা।
                        </p>
                    </div>
                </div>

               
            </div>

        </div>
    </section>


    <!-- ========================================================
         POPUP MODALS: SHARE MODAL & RULES MODAL
         ======================================================== -->
    
    <!-- ========================================================
         SHARE / VIRAL MODAL (PROFESSIONAL CIRCULAR BRANDED)
         ======================================================== -->
    @include('partials.share-modal')


    <!-- Rules & Refund Policy Modal -->
    <div x-show="rulesModalOpen" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
        <div @click.outside="rulesModalOpen = false" 
             class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4 max-h-[85vh] overflow-y-auto">
            
            <div class="flex items-center justify-between border-b pb-3">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">📜</span>
                    <h3 class="text-base font-black text-slate-900">Cartiva Group Buying Rules & Guarantee</h3>
                </div>
                <button @click="rulesModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-2xl leading-none">&times;</button>
            </div>

            <div class="space-y-3.5 text-xs text-slate-600 leading-relaxed">
                <div class="p-3.5 rounded-2xl bg-green-50 border border-green-200 text-green-950">
                    <strong class="block font-black text-sm text-[#53a318]">১. ফ্ল্যাট টায়ার সেটেলমেন্ট (Flat Tier Pricing):</strong>
                    গ্রুপে নির্ধারিত বা সর্বোচ্চ আনলক হওয়া টায়ার অনুযায়ী সকল অংশগ্রহণকারী একক কম মূল্যে পণ্য পাবেন। অতিরিক্ত প্রদত্ত টাকা তাৎক্ষণিক ওয়ালেটে বা মূল পেমেন্ট মেথডে ফেরত আসবে।
                </div>

                <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-950">
                    <strong class="block font-black text-sm text-amber-800">২. ব্যর্থ গ্রুপের ১০০% রিফান্ড (Failed Groups Policy):</strong>
                    কাউন্টডাউন শেষ হওয়ার আগে ন্যূনতম সদস্য টার্গেট পূরণ না হলে অর্ডার স্ট্যাটাস স্বয়ংক্রিয়ভাবে বাতিল হবে এবং সম্পূর্ণ প্রিপেইড পেমেন্ট তাৎক্ষণিক রিফান্ড হবে।
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800">
                    <strong class="block font-black text-sm">৩. লজিস্টিকস ও ঠিকানা লক (Shipping Address Lockdown):</strong>
                    গ্রুপ সফলভাবে সম্পন্ন হওয়ার সাথে সাথে স্বয়ংক্রিয় কুরিয়ার রাউটিং শুরু হয়, তাই সফল গ্রুপের পর ডেলিভারি অ্যাড্রেস পরিবর্তন গ্রহণযোগ্য নয়।
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800">
                    <strong class="block font-black text-sm">৪. ডিফেক্ট হ্যান্ডলিং (Defect Replacement):</strong>
                    পণ্য কোনো কারণে ভাঙা বা ত্রুটিযুক্ত পেলে ৪৮ ঘণ্টার মধ্যে আনবক্সিং প্রমাণ জমা দিলে সরাসরি রিপ্লেসমেন্ট প্রদান করা হবে।
                </div>
            </div>

            <button type="button" @click="rulesModalOpen = false" class="w-full py-3 bg-[#53a318] hover:bg-[#468c13] text-white font-bold rounded-xl text-xs transition-colors">
                I Understand & Agree
            </button>
        </div>
    </div>


    <!-- Floating Copy Toast Notification -->
    <div x-show="copiedToast" x-cloak 
         class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-5 py-3 rounded-2xl shadow-2xl border border-white/10 flex items-center space-x-2 text-xs font-bold animate-in slide-in-from-bottom duration-300">
        <svg class="w-4 h-4 text-[#84cc16]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        <span>গ্রুপ লিংক কপি করা হয়েছে! বন্ধুদের সাথে শেয়ার করুন।</span>
    </div>

</div>

<!-- Alpine Live Countdown Helper Component -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('hotDealsSlider', () => ({
            autoPlay: true,
            interval: null,
            isHovered: false,

            init() {
                this.startAutoScroll();
            },

            startAutoScroll() {
                this.stopAutoScroll();
                this.interval = setInterval(() => {
                    if (!this.isHovered && this.autoPlay) {
                        this.scrollNext();
                    }
                }, 3500);
            },

            stopAutoScroll() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            },

            scrollNext() {
                const slider = this.$refs.hotSlider;
                if (!slider) return;
                const card = slider.querySelector('.hot-deal-card');
                const step = card ? (card.offsetWidth + 16) : 320;
                const maxScroll = slider.scrollWidth - slider.clientWidth;

                if (slider.scrollLeft >= maxScroll - 15) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: step, behavior: 'smooth' });
                }
            },

            scrollPrev() {
                const slider = this.$refs.hotSlider;
                if (!slider) return;
                const card = slider.querySelector('.hot-deal-card');
                const step = card ? (card.offsetWidth + 16) : 320;

                if (slider.scrollLeft <= 15) {
                    slider.scrollTo({ left: slider.scrollWidth, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: -step, behavior: 'smooth' });
                }
            },

            toggleAutoPlay() {
                this.autoPlay = !this.autoPlay;
                if (this.autoPlay) {
                    this.startAutoScroll();
                } else {
                    this.stopAutoScroll();
                }
            }
        }));

        Alpine.data('categoriesSlider', () => ({
            autoPlay: true,
            interval: null,
            isHovered: false,

            init() {
                this.startAutoScroll();
            },

            startAutoScroll() {
                this.stopAutoScroll();
                this.interval = setInterval(() => {
                    if (!this.isHovered && this.autoPlay) {
                        this.scrollNext();
                    }
                }, 3000);
            },

            stopAutoScroll() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            },

            scrollNext() {
                const slider = this.$refs.catSlider;
                if (!slider) return;
                const card = slider.querySelector('.category-slider-card');
                const step = card ? (card.offsetWidth + 12) : 152;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (maxScroll <= 10) return;

                if (slider.scrollLeft >= maxScroll - 15) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: step, behavior: 'smooth' });
                }
            },

            scrollPrev() {
                const slider = this.$refs.catSlider;
                if (!slider) return;
                const card = slider.querySelector('.category-slider-card');
                const step = card ? (card.offsetWidth + 12) : 152;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (maxScroll <= 10) return;

                if (slider.scrollLeft <= 15) {
                    slider.scrollTo({ left: maxScroll, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: -step, behavior: 'smooth' });
                }
            }
        }));

        Alpine.data('flashSalesSlider', () => ({
            autoPlay: true,
            interval: null,
            isHovered: false,

            init() {
                this.startAutoScroll();
            },

            startAutoScroll() {
                this.stopAutoScroll();
                this.interval = setInterval(() => {
                    if (!this.isHovered && this.autoPlay) {
                        this.scrollNext();
                    }
                }, 3500);
            },

            stopAutoScroll() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            },

            scrollNext() {
                const slider = this.$refs.flashSlider;
                if (!slider) return;
                const card = slider.querySelector('.flash-deal-card');
                const step = card ? (card.offsetWidth + 16) : 281;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (maxScroll <= 10) return;

                if (slider.scrollLeft >= maxScroll - 15) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: step, behavior: 'smooth' });
                }
            },

            scrollPrev() {
                const slider = this.$refs.flashSlider;
                if (!slider) return;
                const card = slider.querySelector('.flash-deal-card');
                const step = card ? (card.offsetWidth + 16) : 281;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (maxScroll <= 10) return;

                if (slider.scrollLeft <= 15) {
                    slider.scrollTo({ left: maxScroll, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: -step, behavior: 'smooth' });
                }
            }
        }));

        Alpine.data('groupCountdown', (initialSeconds) => ({
            secondsLeft: initialSeconds,
            timeString: '00:00:00',
            timer: null,

            start() {
                this.updateString();
                this.timer = setInterval(() => {
                    if (this.secondsLeft > 0) {
                        this.secondsLeft--;
                        this.updateString();
                    } else {
                        this.timeString = '00:00:00 (Ending)';
                        clearInterval(this.timer);
                    }
                }, 1000);
            },

            updateString() {
                if (this.secondsLeft <= 0) {
                    this.timeString = '00:00:00';
                    return;
                }
                const h = Math.floor(this.secondsLeft / 3600);
                const m = Math.floor((this.secondsLeft % 3600) / 60);
                const s = this.secondsLeft % 60;
                this.timeString = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            }
        }));
    });
</script>

@endsection
