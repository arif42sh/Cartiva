@extends('layouts.app')

@section('title', 'Active Group Pools — Buy Together & Unlock Wholesale Prices | Cartiva')

@section('content')
<div class="max-w-[1680px] w-full mx-auto px-3 sm:px-5 lg:px-6 py-4 sm:py-6 space-y-6"
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
           class="inline-flex items-center space-x-1.5 text-xs font-semibold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3 py-1.5 rounded-xl transition-all shadow-2xs group">
            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Home</span>
        </a>

        <nav class="flex items-center space-x-2 text-xs font-medium text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#53a318] font-bold">Group Pools</span>
        </nav>
    </div>


    <!-- ========================================================
         2. HERO COMMAND BANNER (DEEP NAVY & EMERALD SOCIAL COMMERCE)
         ======================================================== -->
    <section class="rounded-3xl bg-gradient-to-br from-slate-950 via-[#0a1e2b] to-[#072410] border border-slate-800 text-white p-6 sm:p-8 lg:p-10 shadow-2xl relative overflow-hidden">
        <!-- Ambient Radial Glows -->
        <div class="absolute -top-24 -left-24 w-80 h-80 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-[#53a318]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
            
            <div class="lg:col-span-8 space-y-4">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[10px] font-black uppercase tracking-wider shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-[#84cc16] animate-ping"></span>
                    <span>👥 LIVE GROUP BUYING POOLS • রিয়েল-টাইম টিম কমার্স</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                    "দল বাঁধলে বড় ছাড়,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#84cc16] via-emerald-400 to-cyan-300">
                        সরাসরি ফ্যাক্টরি পাইকারি মূল্য!"
                    </span>
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl font-normal leading-relaxed">
                    চলমান সক্রিয় পুলে যোগ দিয়ে সাথে সাথে পাইকারি ডিসকাউন্ট আনলক করুন। মাত্র ১ জন বাকি থাকা পুলে যুক্ত হলে এখনই অর্ডার কনফার্ম হবে। নির্দিষ্ট সময়ে পুল পূরণ না হলে পাবেন <strong class="text-white underline decoration-[#84cc16] underline-offset-2 font-bold">১০০% অটো-রিফান্ড</strong>।
                </p>

                <!-- 4 Quick Assurance Chips -->
                <div class="flex flex-wrap items-center gap-2 pt-2 text-xs">
                    <span class="px-3 py-1 rounded-xl bg-white/5 border border-white/10 text-slate-300 flex items-center space-x-1.5 backdrop-blur-xs">
                        <span class="text-[#84cc16]">✓</span>
                        <span>সবার ঠিকানায় আলাদা পার্সেল</span>
                    </span>
                    <span class="px-3 py-1 rounded-xl bg-white/5 border border-white/10 text-slate-300 flex items-center space-x-1.5 backdrop-blur-xs">
                        <span class="text-cyan-400">⚡</span>
                        <span>১-ক্লিকে ইনস্ট্যান্ট জয়েন</span>
                    </span>
                    <span class="px-3 py-1 rounded-xl bg-white/5 border border-white/10 text-slate-300 flex items-center space-x-1.5 backdrop-blur-xs">
                        <span class="text-amber-400">🛡️</span>
                        <span>১০০% নিরাপদ রিফান্ড গ্যারান্টি</span>
                    </span>
                </div>
            </div>

            <!-- Right Column: Live Counters Box -->
            <div class="lg:col-span-4 bg-white/5 border border-white/10 rounded-2xl p-5 backdrop-blur-md space-y-4 shadow-xl">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block border-b border-white/10 pb-2">
                    📊 LIVE POOL ACTIVITY TODAY
                </span>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-black/30 rounded-xl p-3 border border-white/5">
                        <span class="text-[10px] text-slate-400 block font-bold">সক্রিয় পুল</span>
                        <span class="text-2xl font-black text-[#84cc16] mt-0.5 block">{{ $stats['active_pools_count'] }}টি</span>
                        <span class="text-[9px] text-emerald-400">🟢 লাইভ ওপেন</span>
                    </div>

                    <div class="bg-black/30 rounded-xl p-3 border border-white/5">
                        <span class="text-[10px] text-slate-400 block font-bold">১টি স্লট বাকি</span>
                        <span class="text-2xl font-black text-rose-400 mt-0.5 block">{{ $stats['almost_full_count'] }}টি</span>
                        <span class="text-[9px] text-rose-300">🔥 দ্রুত পূর্ণ হচ্ছে</span>
                    </div>

                    <div class="bg-black/30 rounded-xl p-3 border border-white/5">
                        <span class="text-[10px] text-slate-400 block font-bold">আজ জয়েন করেছেন</span>
                        <span class="text-2xl font-black text-cyan-300 mt-0.5 block">{{ $stats['verified_buyers_today'] }}+</span>
                        <span class="text-[9px] text-cyan-200">সদস্য যুক্ত</span>
                    </div>

                    <div class="bg-black/30 rounded-xl p-3 border border-white/5">
                        <span class="text-[10px] text-slate-400 block font-bold">মোট সাশ্রয়</span>
                        <span class="text-lg font-black text-amber-300 mt-1 block">৳{{ number_format($stats['total_saved_bdt']) }}</span>
                        <span class="text-[9px] text-amber-200">কমিউনিটি সেভিংস</span>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================
         3. DYNAMIC FILTER & SEARCH BAR
         ======================================================== -->
    <section class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 sm:p-5 space-y-4">
        
        <!-- Top Urgency Filter Pills -->
        <div class="flex items-center justify-between gap-3 overflow-x-auto no-scrollbar pb-1">
            <div class="flex items-center space-x-2 text-xs font-bold overflow-x-auto no-scrollbar">
                <!-- All Pools -->
                <a href="{{ route('group-pools.index', array_merge(request()->except(['filter', 'page']), ['filter' => 'all'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0 {{ !request('filter') || request('filter') === 'all' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <span>🌟 সকল পুল</span>
                </a>

                <!-- 1 Slot Away -->
                <a href="{{ route('group-pools.index', array_merge(request()->except(['filter', 'page']), ['filter' => '1_slot'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0 {{ request('filter') === '1_slot' ? 'bg-rose-600 text-white shadow-md' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/60' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping" x-show="'{{ request('filter') }}' === '1_slot'"></span>
                    <span>🔥 ১টি স্লট বাকি</span>
                </a>

                <!-- Ending Soon -->
                <a href="{{ route('group-pools.index', array_merge(request()->except(['filter', 'page']), ['filter' => 'ending_soon'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0 {{ request('filter') === 'ending_soon' ? 'bg-amber-500 text-white shadow-md' : 'bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200/60' }}">
                    <span>⚡ সময় শেষ হচ্ছে</span>
                </a>

                <!-- 40%+ Max Discount -->
                <a href="{{ route('group-pools.index', array_merge(request()->except(['filter', 'page']), ['filter' => '40_percent'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0 {{ request('filter') === '40_percent' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <span>💰 সর্বোচ্চ ছাড় (৪০%+)</span>
                </a>

                <!-- Winter Specials -->
                <a href="{{ route('group-pools.index', array_merge(request()->except(['filter', 'page']), ['filter' => 'winter'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0 {{ request('filter') === 'winter' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <span>🧥 উইন্টার স্পেশাল</span>
                </a>

                <!-- Tech & Gadgets -->
                <a href="{{ route('group-pools.index', array_merge(request()->except(['filter', 'page']), ['filter' => 'tech'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0 {{ request('filter') === 'tech' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <span>🎧 টেক ও অডিও</span>
                </a>
            </div>

            <span class="hidden md:inline-block text-[11px] font-bold text-slate-400 shrink-0">
                মোট {{ $pools->total() }}টি সক্রিয় পুল পাওয়া গেছে
            </span>
        </div>

        <!-- Secondary Filter Controls Form (Category, Price Range, Sort, Search) -->
        <form action="{{ route('group-pools.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 pt-2 border-t border-slate-100">
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif

            <!-- Search Field -->
            <div class="lg:col-span-4 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="সার্চ করুন (পণ্য বা গ্রুপ কোড যেমন: GRP-HOODIE05)..." 
                       class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-[#53a318] focus:outline-none font-semibold">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- Category Selector -->
            <div class="lg:col-span-3">
                <select name="category" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-[#53a318] focus:outline-none font-bold text-slate-700 cursor-pointer">
                    <option value="all">সকল ক্যাটাগরি (All Categories)</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Price Range Preset -->
            <div class="lg:col-span-2">
                <select name="price_range" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-[#53a318] focus:outline-none font-bold text-slate-700 cursor-pointer">
                    <option value="">মূল্যের রেঞ্জ (Price)</option>
                    <option value="under_1000" {{ request('price_range') === 'under_1000' ? 'selected' : '' }}>১,০০০ টাকার নিচে</option>
                    <option value="1000_3000" {{ request('price_range') === '1000_3000' ? 'selected' : '' }}>১,০০০ - ৩,০০০ টাকা</option>
                    <option value="3000_7000" {{ request('price_range') === '3000_7000' ? 'selected' : '' }}>৩,০০০ - ৭,০০০ টাকা</option>
                    <option value="above_7000" {{ request('price_range') === 'above_7000' ? 'selected' : '' }}>৭,০০০ টাকার উপরে</option>
                </select>
            </div>

            <!-- Sort By -->
            <div class="lg:col-span-2">
                <select name="sort" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-[#53a318] focus:outline-none font-bold text-slate-700 cursor-pointer">
                    <option value="urgency" {{ request('sort') === 'urgency' ? 'selected' : '' }}>জরুরি ডিল (Most Urgent)</option>
                    <option value="most_filled" {{ request('sort') === 'most_filled' ? 'selected' : '' }}>সর্বোচ্চ পূর্ণ (Most Filled)</option>
                    <option value="discount" {{ request('sort') === 'discount' ? 'selected' : '' }}>সর্বোচ্চ ছাড় (Max Discount)</option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>দাম: কম থেকে বেশি</option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>দাম: বেশি থেকে কম</option>
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>নতুন পুল (Latest)</option>
                </select>
            </div>

            <!-- Submit / Reset Button -->
            <div class="lg:col-span-1 flex items-center space-x-1">
                <button type="submit" class="w-full py-2 bg-[#53a318] hover:bg-[#468c13] text-white text-xs font-bold rounded-xl transition-colors flex items-center justify-center">
                    ফিল্টার
                </button>
                @if(request('category') || request('filter') || request('price_range') || request('q') || request('sort'))
                    <a href="{{ route('group-pools.index') }}" title="Clear Filters" 
                       class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors flex items-center justify-center text-xs">
                        ✕
                    </a>
                @endif
            </div>
        </form>

    </section>


    <!-- ========================================================
         4. ACTIVE GROUP POOLS GRID
         ======================================================== -->
    <section class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 sm:gap-6">
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
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-2xs hover:shadow-2xl hover:border-[#53a318] hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden group relative"
                     x-data="groupCountdown({{ $remainingSecs }})"
                     x-init="start()">
                    
                    <div>
                        <!-- Pool Room Header Strip (Room Code + Live Monospace Countdown Ticker) -->
                        <div class="px-4 py-2.5 bg-slate-900 text-white flex items-center justify-between gap-1.5 border-b border-slate-800">
                            <!-- Room Code Pill -->
                            <div class="flex items-center space-x-1.5">
                                <span class="font-mono text-[10px] font-bold text-emerald-300 bg-white/10 px-2 py-0.5 rounded-md border border-white/10">
                                    {{ $group->group_code }}
                                </span>
                            </div>

                            <!-- Live Monospace Ticker -->
                            <span class="inline-flex items-center space-x-1 font-mono text-[10px] font-bold text-amber-300 bg-amber-400/15 px-2 py-0.5 rounded-md border border-amber-400/20">
                                <svg class="w-3 h-3 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span x-text="timeString"></span>
                            </span>
                        </div>

                        <!-- Product Thumbnail with Zoom Effect & Overlay Badges -->
                        <a href="{{ route('products.show', $p->slug) }}" class="block relative w-full aspect-square bg-slate-100 overflow-hidden group/img">
                            <img src="{{ $p->image_url }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover/img:scale-106 transition-transform duration-500">
                            
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-xl text-[10px] font-black bg-white/95 text-slate-800 backdrop-blur-md shadow-xs">
                                {{ $cleanCat }}
                            </span>

                            <!-- Discount Tag -->
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-xl text-[10px] font-black bg-rose-600 text-white shadow-xs tracking-tight">
                                -{{ $discountPct }}%
                            </span>

                            <!-- Urgency Ribbon on Thumbnail -->
                            <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between pointer-events-none">
                                @if($isOneLeft)
                                    <span class="px-2 py-0.5 rounded-lg bg-rose-600/95 text-white text-[10px] font-black flex items-center space-x-1 shadow-xs backdrop-blur-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                        <span>🔥 ১টি স্লট বাকি!</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-lg bg-slate-900/85 text-emerald-300 text-[10px] font-bold flex items-center space-x-1 shadow-xs backdrop-blur-xs">
                                        <span>⚡ {{ $needed }}টি স্লট বাকি</span>
                                    </span>
                                @endif

                                <div class="flex items-center space-x-1 bg-black/60 backdrop-blur-xs text-white px-2 py-0.5 rounded-lg text-[9px] font-bold">
                                    <span class="text-amber-400">★</span>
                                    <span>{{ number_format($p->rating, 1) }}</span>
                                </div>
                            </div>
                        </a>

                        <!-- Card Body Details -->
                        <div class="p-4 sm:p-5 space-y-3.5">
                            <!-- Product Title -->
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors min-h-[2.4rem]">
                                <a href="{{ route('products.show', $p->slug) }}">
                                    {{ $p->title }}
                                </a>
                            </h3>

                            <!-- 3-Tier Visual Pricing & Savings Card -->
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                                <div class="flex items-baseline justify-between text-[11px]">
                                    <span class="text-slate-400">খুচরা মূল্য: <span class="line-through">৳{{ number_format($p->single_price) }}</span></span>
                                    <span class="text-[10px] font-black text-[#53a318] bg-emerald-100/70 px-2 py-0.5 rounded-md">
                                        সাশ্রয় ৳{{ number_format($saveAmount) }}
                                    </span>
                                </div>
                                <div class="flex items-baseline justify-between pt-0.5">
                                    <div>
                                        <span class="text-[9px] uppercase font-bold text-slate-400 block leading-tight">গ্রুপ পুল মূল্য:</span>
                                        <span class="text-lg font-black text-[#53a318]">৳{{ number_format($p->group_price) }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[9px] uppercase font-bold text-slate-400 block leading-tight">ডেলিভারি:</span>
                                        <span class="text-xs font-bold text-slate-700">আলাদা হোম ডেলিভারি</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Team Fill Progress Bar -->
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-[11px] font-bold">
                                    <span class="text-slate-600">{{ $group->current_members }}/{{ $group->required_members }} সদস্য যুক্ত</span>
                                    <span class="text-[#53a318] font-black">{{ $pct }}% পূর্ণ</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-amber-400 via-emerald-500 to-[#53a318] rounded-full transition-all duration-500" 
                                         style="width: {{ $pct }}%"></div>
                                </div>
                            </div>

                            <!-- Social Proof: Members Avatars Stack + Pulsing Empty Slot + Leader -->
                            <div class="flex items-center justify-between pt-1 border-t border-slate-100 text-[10px]">
                                <div class="flex items-center -space-x-1.5 overflow-hidden">
                                    @foreach($joinedMembers as $mIdx => $m)
                                        <div class="w-6 h-6 rounded-full ring-2 ring-white {{ $mIdx === 0 ? 'bg-slate-900 text-amber-300' : 'bg-slate-700 text-white' }} flex items-center justify-center font-bold text-[9px]"
                                             title="{{ $m->user->name ?? 'Customer' }} {{ $mIdx === 0 ? '(Group Leader)' : '' }}">
                                            @if($mIdx === 0)
                                                👑
                                            @else
                                                {{ strtoupper(substr($m->user->name ?? 'U', 0, 1)) }}
                                            @endif
                                        </div>
                                    @endforeach

                                    <!-- Empty Pulsing Slot Calling the User -->
                                    <div class="w-6 h-6 rounded-full ring-2 ring-white border-2 border-dashed border-rose-500 bg-rose-50 text-rose-600 flex items-center justify-center font-black text-[9px] animate-pulse" 
                                         title="এখানে আপনার স্লট! দ্রুত বুক করুন">
                                        +১
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="text-[9px] text-slate-400 block">টিম লিডার:</span>
                                    <span class="font-bold text-slate-700 truncate block max-w-[100px]">
                                        {{ $group->leader->name ?? 'Verified Buyer' }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Dual Action CTAs: Direct Join Slot & Share Invite -->
                    <div class="p-4 sm:p-5 pt-0 grid grid-cols-2 gap-2">
                        <a href="{{ route('group-buy.show', $group->group_code) }}" 
                           class="py-2.5 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs hover:shadow-md flex items-center justify-center space-x-1 active:scale-95">
                            <span>⚡ স্লটে জয়েন</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>

                        <button type="button" @click="openShare('{{ $group->group_code }}', '{{ addslashes($p->title) }}')" 
                                class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition-colors flex items-center justify-center space-x-1">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            <span>ইনভাইট</span>
                        </button>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-slate-200/90 text-slate-500 space-y-3 shadow-xs">
                    <span class="text-4xl block">👥</span>
                    <h3 class="text-base font-black text-slate-800">বর্তমানে এই ফিল্টারে কোনো সক্রিয় পুল নেই</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">ফিল্টার পরিবর্তন করুন অথবা হোমপেজ থেকে পছন্দের পণ্যটি বাছাই করে নিজেই নতুন একটি গ্রুপ পুল শুরু করুন।</p>
                    <div class="pt-2 flex items-center justify-center space-x-3">
                        <a href="{{ route('group-pools.index') }}" class="py-2.5 px-5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                            সকল পুল দেখুন
                        </a>
                        <a href="{{ route('home') }}" class="py-2.5 px-5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs transition-colors shadow-xs">
                            হোমপেজ ব্রাউজ করুন &rarr;
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-6 flex justify-center">
            {{ $pools->links() }}
        </div>
    </section>


    <!-- ========================================================
         5. 3 SOURCING & PLATFORM ASSURANCE PILLARS
         ======================================================== -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
        <!-- Pillar 1: 100% Refund -->
        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#53a318] flex items-center justify-center text-2xl shrink-0 font-black">
                🛡️
            </div>
            <div class="space-y-1">
                <h4 class="text-sm font-black text-slate-900">১০০% অটো-রিফান্ড গ্যারান্টি</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    নির্ধারিত সময়ে পুল পূর্ণ না হলে কোনো প্রশ্ন ছাড়াই আপনার অ্যাকাউন্টে তাৎক্ষণিক সম্পূর্ণ টাকা স্বয়ংক্রিয়ভাবে বিকাশ/নগদ/ওয়ালেটে ফেরত দেওয়া হবে।
                </p>
            </div>
        </div>

        <!-- Pillar 2: Separate Home Delivery -->
        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0 font-black">
                📦
            </div>
            <div class="space-y-1">
                <h4 class="text-sm font-black text-slate-900">সবার ঠিকানায় আলাদা ডেলিভারি</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    গ্রুপে অন্য মেম্বার কে বা কোথায় থাকে তা দেখার বিষয় নয়; প্রত্যেকের পার্সেল নিজস্ব ঠিকানায় আলাদাভাবে হোম ডেলিভারি সম্পন্ন হবে।
                </p>
            </div>
        </div>

        <!-- Pillar 3: Authentic Factory Sourcing -->
        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow flex items-start space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shrink-0 font-black">
                🏭
            </div>
            <div class="space-y-1">
                <h4 class="text-sm font-black text-slate-900">সরাসরি ফ্যাক্টরি ও মার্চেন্ট রেট</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
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

<!-- Alpine Countdown Component -->
<script>
    document.addEventListener('alpine:init', () => {
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
                        this.timeString = '00:00:00';
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
