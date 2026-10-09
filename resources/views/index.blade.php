@extends('layouts.app')

@section('title', 'Cartiva – Deeper Discounts, Together | Inspired by Groupon')

@section('content')

<!-- Global Full-Width Container (Eliminating Awkward Empty Side Margins) -->
<div class="max-w-[1600px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-5 space-y-10">

    <!-- ========================================================
         ১. ANIMATED HERO DEAL CAROUSEL & BILLBOARD (GROUPON STYLE)
         ======================================================== -->
    <div class="relative overflow-hidden rounded-2xl bg-slate-900 shadow-lg text-white" 
         x-data="{ 
            currentSlide: 0, 
            totalSlides: 3,
            autoSlide: null,
            init() {
                this.autoSlide = setInterval(() => { this.next() }, 6000);
            },
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            }
         }"
         @mouseenter="clearInterval(autoSlide)"
         @mouseleave="autoSlide = setInterval(() => { next() }, 6000)">
        
        <!-- Slides Track -->
        <div class="relative min-h-[380px] sm:min-h-[420px] flex items-center">
            
            <!-- Slide 1: Main Platform Value -->
            <div x-show="currentSlide === 0" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-x-12"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-12"
                 class="w-full p-6 sm:p-12 bg-gradient-to-r from-[#172e0d] via-[#244714] to-[#0f172a] relative">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 space-y-4">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-[#53a318] text-white text-[11px] font-black uppercase tracking-wider shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                            <span>OFFICIAL GROUP BUY EVENT • TODAY ONLY</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                            "একা কিনলে পুরো দাম,<br>
                            <span class="text-[#84cc16]">একসাথে কিনলে বিরাট ছাড়!"</span>
                        </h1>

                        <p class="text-xs sm:text-sm text-slate-200 max-w-xl font-medium leading-relaxed">
                            Stop overpaying single retail prices! Join existing buyer circles or invite classmates to unlock wholesale pricing. If your team does not fill before the clock runs out, your money is <strong>100% instantly refunded</strong>.
                        </p>

                        <!-- Promo Code & Direct CTA -->
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <a href="#live-groups" class="px-6 py-3.5 rounded-xl text-xs font-black bg-[#53a318] hover:bg-[#468c13] text-white shadow-md transition-all flex items-center space-x-2 group">
                                <span>Shop Live Ending Soon Deals</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl bg-black/40 border border-white/10 text-xs font-mono">
                                <span class="text-amber-300 font-bold">VOUCHER:</span>
                                <span class="bg-amber-400 text-slate-950 font-black px-2 py-0.5 rounded text-[11px]">CARTIVA20</span>
                            </div>
                        </div>
                    </div>

                    <!-- Side Stats Badge -->
                    <div class="lg:col-span-4 hidden lg:block bg-black/40 backdrop-blur-md rounded-2xl border border-white/10 p-6 space-y-4">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#84cc16] block">
                            COMMUNITY DEMAND METRICS
                        </span>
                        <div class="space-y-3 divide-y divide-white/10 text-xs">
                            <div class="pt-1 flex items-center justify-between">
                                <span class="text-slate-300">সফল গ্রুপ বায়:</span>
                                <span class="text-lg font-black text-[#84cc16]">{{ number_format($stats['completed_groups']) }}+</span>
                            </div>
                            <div class="pt-3 flex items-center justify-between">
                                <span class="text-slate-300">মোট সাশ্রয়:</span>
                                <span class="text-lg font-black text-amber-300">৳{{ number_format($stats['total_saved']) }}+</span>
                            </div>
                            <div class="pt-3 flex items-center justify-between">
                                <span class="text-slate-300">ভেরিফাইড মার্চেন্ট:</span>
                                <span class="text-lg font-black text-cyan-300">{{ $stats['verified_sellers'] }}+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Campus BAUST Special -->
            <div x-show="currentSlide === 1" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-x-12"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-12"
                 class="w-full p-6 sm:p-12 bg-gradient-to-r from-[#1e1b4b] via-[#312e81] to-[#0f172a] relative">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 space-y-4">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-[11px] font-black uppercase tracking-wider">
                            <span>🎓 CAMPUS EXCLUSIVE • BAUST SPECIAL</span>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                            BAUST Heavyweight Winter Fleece Hoodie
                        </h2>
                        <p class="text-xs sm:text-sm text-indigo-100 max-w-xl font-medium leading-relaxed">
                            Official campus merchandise drop. 5 classmates team up to unlock the lowest tier wholesale price: <strong>৳৭৫০</strong> (Regular Retail ৳১,০০০). Only 1 slot remaining in active group!
                        </p>
                        <div class="flex items-center gap-3 pt-2">
                            <a href="{{ route('group-buy.show', 'GRP-BAUST05') }}" class="px-6 py-3.5 rounded-xl text-xs font-black bg-amber-400 hover:bg-amber-300 text-slate-950 shadow-md transition-all">
                                Join Group & Save ৳২৫০ 👥
                            </a>
                            <span class="text-xs text-amber-300 font-mono font-bold">Code: GRP-BAUST05</span>
                        </div>
                    </div>
                    <div class="lg:col-span-4 hidden lg:block text-center">
                        <div class="inline-block p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                            <span class="text-3xl font-black text-amber-400">৳৭৫০</span>
                            <span class="text-sm text-slate-300 line-through ml-2">৳১,০০০</span>
                            <span class="block text-xs font-bold text-emerald-400 mt-1">Tier 3 Maximum Discount</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Tech ANC Headphone Flash Deal -->
            <div x-show="currentSlide === 2" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-x-12"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 -translate-x-12"
                 class="w-full p-6 sm:p-12 bg-gradient-to-r from-[#064e3b] via-[#047857] to-[#0f172a] relative">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 space-y-4">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-600 text-white text-[11px] font-black uppercase tracking-wider">
                            <span>⏱ ENDING IN 3 HOURS</span>
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                            SoundCore Ultra Active Noise-Cancelling Headphones
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-100 max-w-xl font-medium leading-relaxed">
                            Adaptive ANC, 40mm beryllium acoustic drivers, 40-hour playback. Team Buy price: <strong>৳৩,১৫০</strong> (Retail ৳৪,৫০০ — Save ৳১,৩৫০!).
                        </p>
                        <div class="flex items-center gap-3 pt-2">
                            <a href="{{ route('group-buy.show', 'GRP-SOUND99') }}" class="px-6 py-3.5 rounded-xl text-xs font-black bg-white hover:bg-emerald-50 text-slate-900 shadow-md transition-all">
                                Lock In ৳৩,১৫০ Price Now ⚡
                            </a>
                            <span class="text-xs text-emerald-300 font-mono font-bold">Code: GRP-SOUND99</span>
                        </div>
                    </div>
                    <div class="lg:col-span-4 hidden lg:block text-center">
                        <div class="inline-block p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                            <span class="text-3xl font-black text-emerald-400">৳৩,১৫০</span>
                            <span class="text-sm text-slate-300 line-through ml-2">৳৪,৫০০</span>
                            <span class="block text-xs font-bold text-amber-300 mt-1">30% Team Discount</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Carousel Navigation Controls -->
        <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center transition-all focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center transition-all focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Carousel Pagination Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center space-x-2">
            <template x-for="i in totalSlides">
                <button @click="currentSlide = i - 1" 
                        class="h-2 rounded-full transition-all focus:outline-none"
                        :class="currentSlide === (i - 1) ? 'w-8 bg-[#84cc16]' : 'w-2 bg-white/40'"></button>
            </template>
        </div>
    </div>


    <!-- ========================================================
         ২. GROUPON SIGNATURE CIRCULAR CATEGORY BROWSER (FULL-WIDTH)
         ======================================================== -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center space-x-2">
                    <span>Popular Categories</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Browse deals by category to find your team</p>
            </div>
            <a href="{{ route('home') }}" class="text-xs font-bold text-[#53a318] hover:underline flex items-center space-x-1">
                <span>View All Products</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 text-center">
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat) }}" 
                   class="group flex flex-col items-center p-3 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-200">
                    <!-- Circular Icon Container with Hover Animation -->
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-slate-100 border-2 border-slate-200 group-hover:border-[#53a318] flex items-center justify-center text-3xl sm:text-4xl shadow-xs group-hover:scale-110 group-hover:shadow-md transition-all duration-300">
                        {{ $cat->icon ?? '🛍️' }}
                    </div>
                    <span class="mt-3 text-xs font-bold text-slate-800 group-hover:text-[#53a318] transition-colors line-clamp-1">
                        {{ $cat->name }}
                    </span>
                    <span class="text-[10px] font-semibold text-slate-400 group-hover:text-emerald-700">
                        {{ $cat->products_count }} Deals Available
                    </span>
                </a>
            @endforeach
        </div>
    </div>


    <!-- ========================================================
         ৩. "ENDING SOON & HOT GROUPS" (HIGH-URGENCY FLASH DROPS)
         ======================================================== -->
    <section id="live-groups" class="space-y-5">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-slate-200 pb-3">
            <div>
                <div class="flex items-center space-x-2 text-rose-600 text-xs font-black uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-ping"></span>
                    <span>High Urgency Live Drops</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">
                    🔥 Ending Soon & Hot Groups
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    These group campaigns have almost reached their target and are closing soon. Join now to lock in maximum tier discounts!
                </p>
            </div>
            <div class="mt-2 sm:mt-0 text-xs font-bold text-slate-500 flex items-center space-x-1.5 bg-slate-100 px-3 py-1.5 rounded-lg">
                <span class="w-2 h-2 rounded-full bg-[#53a318]"></span>
                <span>Real-time Live Sync</span>
            </div>
        </div>

        @if($activeGroups->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-500">
                <p class="text-sm font-semibold">No active open groups right now.</p>
                <p class="text-xs text-slate-400 mt-1">Be the first to pick any deal below and launch your group!</p>
            </div>
        @else
            <!-- 3 to 4 Column Groupon-Style Deal Cards Grid (Expansive & High-Density) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($activeGroups as $group)
                    @php
                        $sec = max(0, now()->diffInSeconds($group->expires_at, false));
                        $remaining = $group->remainingSlots();
                    @endphp
                    <!-- High-Polish Groupon Deal Card with Micro-Animations -->
                    <div class="deal-card bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between group"
                         x-data="{ 
                            ...groupCountdown({{ $sec }}),
                            wishlisted: false
                         }" 
                         x-init="start()">
                        
                        <div>
                            <!-- Card Image with Badges & Wishlist Heart -->
                            <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                                
                                <!-- Floating Urgency Live Timer Badge -->
                                <div class="absolute top-3 left-3 bg-rose-600 text-white font-black text-[11px] px-2.5 py-1 rounded-lg shadow-md uppercase tracking-wider flex items-center space-x-1 animate-pulse">
                                    <svg class="w-3.5 h-3.5 animate-spin-reverse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span x-text="timeString">00:00:00</span>
                                </div>

                                <!-- Wishlist Heart Button with Bounce Animation -->
                                <button @click="wishlisted = !wishlisted" 
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-xs flex items-center justify-center text-slate-500 hover:text-rose-500 transition-all shadow-sm hover:scale-110 focus:outline-none">
                                    <svg class="w-4 h-4 transition-all" 
                                         :class="wishlisted ? 'fill-rose-500 text-rose-500 scale-125' : 'fill-none'" 
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>

                                <!-- Bottom Group Code Tag -->
                                <div class="absolute bottom-2 left-2 px-2.5 py-0.5 rounded-md bg-black/75 text-white font-mono text-[10px] font-bold">
                                    {{ $group->group_code }}
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-4 space-y-2.5">
                                <!-- Merchant & Location Subheader -->
                                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center justify-between">
                                    <span class="truncate">{{ $group->product->category->name ?? 'Local Deal' }}</span>
                                    <span class="text-slate-500 font-semibold">Saidpur • BAUST Hub</span>
                                </div>

                                <!-- Deal Title -->
                                <h3 class="text-sm font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors">
                                    <a href="{{ route('products.show', $group->product) }}">
                                        {{ $group->product->title }}
                                    </a>
                                </h3>

                                <!-- Star Ratings & Social Proof -->
                                <div class="flex items-center space-x-1.5 text-xs">
                                    <div class="flex items-center text-amber-500">
                                        <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="ml-1 text-slate-800 font-bold">{{ $group->product->rating }}</span>
                                    </div>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-slate-500 text-[11px]">({{ $group->product->sales_count }})</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-[#53a318] font-bold text-[11px]">100+ bought</span>
                                </div>

                                <!-- Visual Progress Bar & Remaining Slots -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span class="text-slate-600 font-semibold">Group Progress:</span>
                                        <span class="font-bold text-[#53a318]">
                                            {{ $group->current_members }}/{{ $group->required_members }} Joined 
                                            @if($remaining > 0)
                                                <span class="text-rose-600 font-black">({{ $remaining }} slot left!)</span>
                                            @endif
                                        </span>
                                    </div>
                                    <!-- Progress Bar with Smooth Fill -->
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-[#53a318] to-emerald-400 h-2 rounded-full transition-all duration-700" 
                                             style="width: {{ ($group->current_members / $group->required_members) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Pricing Display -->
                                <div class="pt-1 flex items-baseline justify-between">
                                    <div class="flex items-baseline space-x-2">
                                        <span class="text-xl font-black text-[#53a318]">৳{{ number_format($group->product->group_price) }}</span>
                                        <span class="text-xs text-slate-400 line-through">৳{{ number_format($group->product->single_price) }}</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full bg-green-100 text-[#53a318] font-black text-[11px]">
                                        {{ $group->product->discount_percent }}% OFF
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action CTA Buttons -->
                        <div class="p-4 pt-0">
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('group-buy.show', $group) }}" 
                                   class="text-center py-2.5 px-3 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                    View Room
                                </a>
                                <form action="{{ route('group-buy.join', $group) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-center py-2.5 px-3 rounded-xl text-xs font-black bg-[#53a318] hover:bg-[#468c13] text-white shadow-sm transition-all hover:scale-[1.02]">
                                        Join Group ⚡
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </section>


    <!-- ========================================================
         ৪. FEATURED DEALS GRID (TIER SLABS PREVIEW - 5 COLUMNS ON WIDE SCREENS)
         ======================================================== -->
    <section id="featured-deals" class="space-y-6 pt-4">
        
        <!-- Section Header with Category Tabs -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-slate-200 pb-3 gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Featured Deals on Cartiva
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Hand-picked volume deals with transparent tier pricing discounts.
                </p>
            </div>

            <!-- Horizontal Filter Pills -->
            <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar pb-1">
                <a href="{{ route('home') }}" 
                   class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap {{ !request('category') ? 'bg-[#53a318] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                    All Deals
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat) }}" 
                       class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap {{ (isset($category) && $category->id === $cat->id) || request('category') === $cat->slug ? 'bg-[#53a318] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 5-Column High-Density Product Grid on Wide Screens -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 sm:gap-6">
            @forelse($products as $product)
                <!-- Groupon Product Card with Hover Lift -->
                <div class="deal-card bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between group">
                    
                    <div>
                        <!-- Image Container with Badges -->
                        <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                            
                            <!-- Discount Badge -->
                            <div class="absolute top-2.5 left-2.5 bg-rose-600 text-white font-black text-[10px] px-2 py-0.5 rounded-md shadow-xs">
                                Up to {{ $product->discount_percent }}% OFF
                            </div>

                            <!-- Stock Indicator -->
                            <div class="absolute top-2.5 right-2.5 bg-black/75 text-white text-[10px] font-bold px-2 py-0.5 rounded-md">
                                {{ $product->stock }} left
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 space-y-2">
                            <!-- Category & Seller -->
                            <div class="flex items-center justify-between text-[11px] text-slate-400 font-bold uppercase tracking-wider">
                                <span class="truncate max-w-[120px]">{{ $product->category->name ?? 'Deal' }}</span>
                                <span class="text-slate-500 truncate max-w-[100px]">{{ $product->seller->name ?? 'Verified' }}</span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors">
                                <a href="{{ route('products.show', $product) }}">
                                    {{ $product->title }}
                                </a>
                            </h3>

                            <!-- Rating -->
                            <div class="flex items-center space-x-1 text-xs">
                                <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-slate-800">{{ $product->rating }}</span>
                                <span class="text-slate-400 text-[11px]">({{ $product->sales_count }} sold)</span>
                            </div>

                            <!-- Pricing Tiers Slabs (Distinct Feature from project spec) -->
                            <div class="mt-2 p-2 rounded-xl bg-slate-50 border border-slate-100 space-y-1 text-[10px]">
                                <span class="font-black text-slate-400 uppercase tracking-wider block">Volume Tier Slabs:</span>
                                <div class="grid grid-cols-3 gap-1 text-center">
                                    <div class="p-1 rounded-md bg-white border border-slate-200">
                                        <span class="block text-slate-400">1-4</span>
                                        <span class="font-bold text-slate-700">৳{{ number_format($product->single_price) }}</span>
                                    </div>
                                    <div class="p-1 rounded-md bg-green-50 border border-green-200">
                                        <span class="block text-[#53a318] font-bold">5-19</span>
                                        <span class="font-bold text-slate-800">৳{{ number_format($product->single_price * 0.9) }}</span>
                                    </div>
                                    <div class="p-1 rounded-md bg-[#53a318] text-white font-bold">
                                        <span class="block text-green-100">20+</span>
                                        <span class="font-black">৳{{ number_format($product->group_price) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Display -->
                            <div class="pt-2 flex items-baseline justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block font-semibold uppercase">From</span>
                                    <span class="text-lg font-black text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                    <span class="text-xs text-slate-400 line-through ml-1">৳{{ number_format($product->single_price) }}</span>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500">
                                    {{ $product->group_size_required }} Buyers Need
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions CTA Buttons -->
                    <div class="p-4 pt-0">
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('checkout', ['product_id' => $product->id, 'type' => 'single', 'action' => 'buy_single']) }}" 
                               class="text-center py-2 px-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                Buy Solo
                            </a>
                            <a href="{{ route('products.show', $product) }}" 
                               class="text-center py-2 px-2 rounded-xl text-xs font-black bg-[#53a318] hover:bg-[#468c13] text-white shadow-xs transition-all hover:scale-[1.02]">
                                View Deal 👥
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-500">
                    <p class="text-base font-semibold">No deals found for this selection.</p>
                    <a href="{{ route('home') }}" class="mt-2 inline-block text-xs font-bold text-[#53a318] hover:underline">
                        Reset filters
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </section>


    <!-- ========================================================
         ৫. HOW GROUP BUYING WORKS ON CARTIVA (3-STEP VISUAL GUIDE)
         ======================================================== -->
    <section id="how-it-works" class="bg-white rounded-2xl border border-slate-200 p-8 sm:p-12 shadow-xs">
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-xs font-black uppercase text-[#53a318] tracking-wider bg-green-50 px-3 py-1 rounded-full border border-green-200">
                Simple & Collaborative Shopping
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">How Cartiva Group Buying Works</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Unlock wholesale volume prices without paying the retail markup.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="text-center space-y-3 p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-green-200 transition-colors">
                <div class="w-14 h-14 rounded-2xl bg-green-100 border border-green-200 text-[#53a318] flex items-center justify-center font-black text-xl mx-auto shadow-xs">
                    1
                </div>
                <h3 class="text-base font-bold text-slate-900">1. Choose Any Product Deal</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Select a product and view its tiered volume discounts. Choose the discounted "Team Buy" price.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center space-y-3 p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-green-200 transition-colors">
                <div class="w-14 h-14 rounded-2xl bg-green-100 border border-green-200 text-[#53a318] flex items-center justify-center font-black text-xl mx-auto shadow-xs">
                    2
                </div>
                <h3 class="text-base font-bold text-slate-900">2. Join or Launch a Group</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Instantly join an active group or create a new team and share the link with friends, classmates, or colleagues.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center space-y-3 p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-green-200 transition-colors">
                <div class="w-14 h-14 rounded-2xl bg-green-100 border border-green-200 text-[#53a318] flex items-center justify-center font-black text-xl mx-auto shadow-xs">
                    3
                </div>
                <h3 class="text-base font-bold text-slate-900">3. Tier Unlocked & Dispatched</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Once the target number of buyers is reached, the discount is finalized and the order ships. If unreached, 100% instant refund!
                </p>
            </div>
        </div>
    </section>


    <!-- ========================================================
         ৬. THE CARTIVA PROMISE (GROUPON PROMISE GUARANTEE)
         ======================================================== -->
    <section id="cartiva-guarantee" class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-2xl text-white p-8 sm:p-10 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
            
            <div class="space-y-2 md:col-span-1">
                <span class="text-xs font-black uppercase text-[#84cc16] tracking-wider">Peace of Mind</span>
                <h3 class="text-2xl font-black leading-tight">The Cartiva Promise</h3>
                <p class="text-xs text-slate-400">Our customer satisfaction & safety policy guarantee.</p>
            </div>

            <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 md:pt-0">
                <div class="space-y-1.5 p-4 rounded-xl bg-white/5 border border-white/10 hover:border-emerald-500/40 transition-colors">
                    <div class="flex items-center space-x-2 text-[#84cc16] font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>100% Automatic Refund</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        If a group countdown expires without meeting buyer thresholds, payments are immediately refunded.
                    </p>
                </div>

                <div class="space-y-1.5 p-4 rounded-xl bg-white/5 border border-white/10 hover:border-emerald-500/40 transition-colors">
                    <div class="flex items-center space-x-2 text-[#84cc16] font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>Escrow Holding</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Merchants receive payment only after verified parcel delivery confirmation from courier APIs.
                    </p>
                </div>

                <div class="space-y-1.5 p-4 rounded-xl bg-white/5 border border-white/10 hover:border-emerald-500/40 transition-colors">
                    <div class="flex items-center space-x-2 text-[#84cc16] font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>Direct Replacement</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        Defective items are directly replaced within 48 hours without compromising group discount terms.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================
         ৭. NEWSLETTER & DEALS SUBSCRIPTION BANNER
         ======================================================== -->
    <section class="bg-white rounded-2xl border border-slate-200 p-8 sm:p-10 text-center space-y-4">
        <div class="max-w-md mx-auto space-y-2">
            <h3 class="text-xl font-black text-slate-900">Never Miss a Flash Group Drop</h3>
            <p class="text-xs text-slate-500">Get daily updates on the biggest community group discounts straight to your inbox.</p>
        </div>
        <form class="max-w-md mx-auto flex items-center space-x-2" onsubmit="event.preventDefault(); alert('Subscribed successfully to Cartiva deal alerts!');">
            <input type="email" required placeholder="Enter your student/work email address..." 
                   class="flex-1 px-4 py-3 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#53a318]">
            <button type="submit" class="bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs px-6 py-3 rounded-xl transition-all shadow-sm hover:scale-[1.02]">
                Subscribe
            </button>
        </form>
    </section>

</div>

<!-- Alpine Live Countdown Helper -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('groupCountdown', (initialSeconds) => ({
            secondsLeft: initialSeconds,
            timeString: '',
            timer: null,

            start() {
                this.updateString();
                this.timer = setInterval(() => {
                    if (this.secondsLeft > 0) {
                        this.secondsLeft--;
                        this.updateString();
                    } else {
                        this.timeString = '00:00:00 (Expired)';
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
