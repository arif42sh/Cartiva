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

    <!-- ========================================================
         2. HIGH-CONVERSION HERO SECTION (VALUE PROP + SPOTLIGHT DEAL)
         Theme: Dark Command Center with Glowing Blue & Emerald Orbs (Compact Viewport Fit)
         ======================================================== -->
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-950 via-[#0a1a2e] to-[#071f0c] border border-slate-800 shadow-xl text-white p-5 sm:p-7 lg:p-8">
        
        <!-- Ambient Radial Glows -->
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-[#53a318]/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
            
            <!-- Left Column: Bold Value Proposition -->
            <div class="lg:col-span-7 space-y-3.5 sm:space-y-4">
                
                <!-- Live Event Badge -->
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-cyan-300 text-[10px] font-black uppercase tracking-wider shadow-inner">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#84cc16] animate-ping"></span>
                    <span>GROUP COMMERCE REVOLUTION • BUY TOGETHER & SAVE</span>
                </div>

                <!-- Balanced Headline with Gradient Text -->
                <h1 class="text-2xl sm:text-3xl lg:text-[34px] xl:text-4xl font-extrabold tracking-tight leading-snug">
                    "একা কিনলে সাধারণ দাম,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#84cc16] via-emerald-400 to-cyan-300">
                        দল বাঁধলে পাইকারি দাম!"
                    </span>
                </h1>

                <!-- Explanatory Subtext -->
                <p class="text-xs sm:text-sm text-slate-300 max-w-lg font-normal leading-relaxed line-clamp-2 sm:line-clamp-none">
                    অনলাইনে খুচরা মূল্যে অতিরিক্ত টাকা দেওয়ার দিন শেষ! বন্ধুদের সাথে দল গঠন করে আনলক করুন সরাসরি কারখানা ও পাইকারি রেট। নির্দিষ্ট সময়ের মধ্যে গ্রুপ পূরণ না হলে পাবেন <strong class="text-white underline decoration-[#84cc16] underline-offset-2 font-bold">১০০% রিফান্ড</strong>।
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-wrap items-center gap-2.5 pt-1">
                    <a href="#urgent-pools" class="px-5 py-2.5 rounded-xl text-xs font-black bg-[#53a318] hover:bg-[#468c13] text-white shadow-lg shadow-green-950/40 hover:scale-[1.02] active:scale-95 transition-all flex items-center space-x-2">
                        <span>⚡ Join Active Pool Now</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    
                    <a href="#active-deals" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/10 transition-all hover:scale-[1.02]">
                        Explore Pools &rarr;
                    </a>

                    <!-- Voucher Token -->
                    <div class="flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg bg-black/50 border border-white/10 text-xs font-mono shadow-inner">
                        <span class="text-amber-300 font-bold text-[11px]">CODE:</span>
                        <span class="bg-amber-400 text-slate-950 font-black px-1.5 py-0.2 rounded text-[10px]">CARTIVA20</span>
                    </div>
                </div>

                <!-- Trust Micro-Pills (Compact) -->
                <div class="grid grid-cols-3 gap-2.5 pt-2 border-t border-white/10 text-xs">
                    <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <span class="text-slate-400 block text-[9px] uppercase font-bold tracking-wider">মোট সাশ্রয়</span>
                        <span class="text-sm sm:text-base font-black text-[#84cc16]">৳{{ number_format($stats['total_saved'] ?? 2850000) }}+</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <span class="text-slate-400 block text-[9px] uppercase font-bold tracking-wider">সফল ডিল</span>
                        <span class="text-sm sm:text-base font-black text-amber-300">{{ number_format($stats['completed_groups'] ?? 1450) }}+</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <span class="text-slate-400 block text-[9px] uppercase font-bold tracking-wider">নিরাপত্তা</span>
                        <span class="text-sm sm:text-base font-black text-emerald-400">১০০% রিফান্ড</span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Live Spotlight Deal (Featured Running Pool) -->
            <div class="lg:col-span-5">
                @if($spotlightGroup)
                    <div class="relative bg-slate-900/90 backdrop-blur-xl rounded-2xl border-2 border-emerald-500/40 ring-2 ring-emerald-500/10 shadow-xl shadow-emerald-950/60 p-4 sm:p-5 space-y-3.5"
                         x-data="groupCountdown({{ max(0, (int) now()->diffInSeconds($spotlightGroup->expires_at, false)) }})"
                         x-init="start()">
                        
                        <!-- Top Header with Glowing Neon Pulse -->
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2.5">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                                <span class="text-[10px] font-black uppercase tracking-wider text-rose-400">
                                    LIVE SPOTLIGHT DEAL • TRENDING
                                </span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-[#84cc16] font-mono text-[11px] font-black border border-emerald-500/30">
                                {{ $spotlightGroup->group_code }}
                            </span>
                        </div>

                        <!-- Product Thumbnail & Info -->
                        <div class="flex items-center space-x-3.5">
                            <div class="relative w-20 h-20 sm:w-22 sm:h-22 rounded-xl overflow-hidden bg-slate-800 flex-shrink-0 border border-slate-700 shadow-md">
                                <img src="{{ $spotlightGroup->product->image_url }}" alt="{{ $spotlightGroup->product->title }}" class="w-full h-full object-cover">
                                <span class="absolute top-1 left-1 px-1.5 py-0.5 rounded text-[9px] font-black bg-rose-600 text-white shadow-xs">
                                    -{{ round((($spotlightGroup->product->single_price - $spotlightGroup->product->group_price)/$spotlightGroup->product->single_price)*100) }}%
                                </span>
                            </div>
                            <div class="flex-1 min-w-0 space-y-0.5">
                                <span class="text-[9px] font-black uppercase tracking-wider text-cyan-300 block truncate">
                                    {{ $spotlightGroup->product->category->name ?? 'Winter Specials' }}
                                </span>
                                <h3 class="text-xs sm:text-sm font-black text-white line-clamp-2 leading-snug">
                                    {{ $spotlightGroup->product->title }}
                                </h3>
                                <p class="text-[10px] text-slate-400">
                                    বিক্রেতা: <span class="text-slate-200 font-bold">{{ $spotlightGroup->product->seller->name ?? 'Verified Merchant' }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Pricing Visual: Regular vs Current Pool Price -->
                        <div class="p-3 rounded-xl bg-black/50 border border-slate-800 space-y-1.5">
                            <div class="flex items-baseline justify-between">
                                <div>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Regular Price:</span>
                                    <span class="text-xs line-through text-slate-500 font-bold">৳{{ number_format($spotlightGroup->product->single_price) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-bold text-[#84cc16] uppercase tracking-wider block">Group Pool Price:</span>
                                    <span class="text-xl sm:text-2xl font-black text-[#84cc16]">৳{{ number_format($spotlightGroup->product->group_price) }}</span>
                                </div>
                            </div>
                            <div class="text-[10px] text-amber-300 font-bold bg-amber-500/10 px-2 py-1 rounded-md flex items-center justify-between border border-amber-500/20">
                                <span>সাশ্রয়: ৳{{ number_format($spotlightGroup->product->single_price - $spotlightGroup->product->group_price) }} (২৫% OFF)</span>
                                <span class="font-mono text-cyan-300 font-black">⏱ <span x-text="timeString"></span> বাকি</span>
                            </div>
                        </div>

                        <!-- Animated Progress Bar -->
                        @php
                            $fillPct = min(100, round(($spotlightGroup->current_members / $spotlightGroup->required_members) * 100));
                            $remaining = max(1, $spotlightGroup->required_members - $spotlightGroup->current_members);
                        @endphp
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-[11px] font-bold">
                                <span class="text-slate-300 flex items-center space-x-1.5">
                                    <span>👥 Pool Progress:</span>
                                    <span class="text-[#84cc16] font-black">{{ $spotlightGroup->current_members }}/{{ $spotlightGroup->required_members }} joined</span>
                                </span>
                                <span class="text-amber-400 font-black">{{ $fillPct }}% Filled</span>
                            </div>
                            
                            <!-- Dynamic Bar with Animated Glow -->
                            <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden p-0.5 border border-slate-700">
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 via-[#53a318] to-cyan-400 shadow-md transition-all duration-500 animate-pulse"
                                     style="width: {{ $fillPct }}%;"></div>
                            </div>

                            <p class="text-[10px] text-amber-300 font-semibold">
                                🔥 Only <strong class="text-white font-black underline">{{ $remaining }} more buyer{{ $remaining > 1 ? 's' : '' }}</strong> needed to lock in wholesale price!
                            </p>
                        </div>

                        <!-- Action Buttons: View Deal & Start Pool -->
                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <a href="{{ route('products.show', $spotlightGroup->product->slug) }}" 
                               class="py-2.5 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-center text-xs transition-all shadow-md shadow-green-950/50 hover:scale-[1.02] flex items-center justify-center space-x-1">
                                <span>View Deal & Join</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>

                            <a href="{{ route('products.show', $spotlightGroup->product->slug) }}" 
                               class="py-2.5 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-center text-xs transition-all border border-slate-700 hover:scale-[1.02]">
                                Start New Team
                            </a>
                        </div>

                    </div>
                @else
                    <!-- Fallback Spotlight Card -->
                    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 text-center space-y-3">
                        <span class="text-3xl block">⚡</span>
                        <h3 class="text-base font-black text-white">Start the First Team Buy Today!</h3>
                        <p class="text-xs text-slate-400">Choose any product from the catalog, start a team pool, and invite friends to save big.</p>
                        <a href="#active-deals" class="inline-block py-2 px-5 rounded-xl bg-[#53a318] text-white font-bold text-xs">Browse Products</a>
                    </div>
                @endif
            </div>

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
    <section class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-4 sm:p-5 space-y-4">
        
        <!-- Header Row -->
        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div class="flex items-center space-x-2.5">
                <span class="w-2.5 h-5 rounded-full bg-[#53a318]"></span>
                <h2 class="text-sm sm:text-base font-black text-slate-900 tracking-tight">
                    Top Categories
                </h2>
                @if($currentCat)
                    <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[#53a318] text-[11px] font-bold">
                        <span>Active: {{ ucwords(str_replace('-', ' ', $currentCat)) }}</span>
                        <a href="{{ route('home') }}#active-deals" class="hover:text-emerald-950 font-black ml-0.5" title="Clear category filter">&times;</a>
                    </div>
                @endif
            </div>
            
            <div class="flex items-center space-x-3 text-xs">
                @if($currentCat)
                    <a href="{{ route('home') }}#active-deals" class="font-bold text-slate-500 hover:text-rose-600 transition-colors">
                        ✕ Clear Filter
                    </a>
                @endif
                <a href="{{ route('home') }}" class="group font-bold text-[#53a318] hover:text-[#468c13] flex items-center space-x-1 transition-colors">
                    <span>See all categories</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- 10-Column Balanced Full-Width Grid (Big Icons • Full English Names • Zero Cutoffs • Active Highlighting) -->
        <div class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-2 sm:gap-2.5 w-full">
            @foreach($topNavCategories as $item)
                @php
                    $isItemActive = ($currentCat === $item['slug']) 
                        || ($item['slug'] === 'smart-tech-audio' && $currentCat === 'tech-accessories')
                        || ($item['slug'] === 'home-living' && $currentCat === 'home-lifestyle');
                @endphp
                <a href="{{ route('category.show', $item['slug']) }}" 
                   class="flex flex-col items-center justify-center p-2.5 sm:p-3 rounded-2xl {{ $isItemActive ? 'bg-emerald-50/70 border-2 border-[#53a318] ring-2 ring-[#53a318]/20 shadow-sm' : 'bg-white hover:bg-slate-50/80 border border-slate-200/80 hover:border-[#53a318]' }} shadow-2xs hover:shadow-md hover:-translate-y-1 transition-all duration-200 group text-center cursor-pointer relative">
                    
                    @if($isItemActive)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#53a318]"></span>
                    @endif

                    <!-- Big Icon Box -->
                    <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl {{ $item['bg'] }} border {{ $item['border'] }} flex items-center justify-center transition-all group-hover:scale-110 shadow-2xs">
                        {!! $item['svg'] !!}
                    </div>
                    
                    <!-- English Title (Fully Visible • Zero Truncation) -->
                    <span class="text-[11px] sm:text-xs font-bold {{ $isItemActive ? 'text-[#53a318]' : 'text-slate-800' }} group-hover:text-[#53a318] transition-colors mt-2.5 text-center leading-tight whitespace-nowrap">
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
                            <span>🔥 হট ডিল — শেষ মুহূর্তের টিম</span>
                            <span class="text-xs font-bold text-slate-400 font-sans hidden sm:inline">(Ending Soon & Almost Full)</span>
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-700 border border-rose-200/80 shadow-2xs">
                            ⚡ টিম প্রায় পূর্ণ
                        </span>
                    </div>
                    <p class="text-xs text-slate-500">
                        সময় ও স্লট শেষ হওয়ার আগেই শেষ সদস্য হিসেবে যোগ দিয়ে সর্বোচ্চ পাইকারি ছাড় নিশ্চিত করুন
                    </p>
                </div>
            </div>

            <!-- Carousel Controls: Auto-slide Indicator & Manual Arrows -->
            <div class="flex items-center space-x-2 shrink-0">
                <!-- Auto-Scroll Status / Toggle Button -->
                <button type="button" @click="toggleAutoPlay()" 
                        :class="autoPlay ? 'bg-emerald-50 text-[#53a318] border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200'"
                        class="hidden md:inline-flex items-center space-x-1.5 text-[11px] font-bold px-3 py-1.5 rounded-xl border transition-all cursor-pointer shadow-2xs"
                        :title="autoPlay ? 'Click to pause automatic sliding' : 'Click to resume automatic sliding'">
                    <span class="w-2 h-2 rounded-full" :class="autoPlay ? 'bg-[#53a318] animate-ping' : 'bg-slate-400'"></span>
                    <span x-text="autoPlay ? 'Auto-Slide On' : 'Paused'"></span>
                </button>

                <!-- See All Hot Deals Link -->
                <a href="{{ route('hot-deals.index') }}" 
                   class="inline-flex items-center space-x-1.5 text-xs font-bold text-[#53a318] hover:text-[#418212] px-3.5 py-2 rounded-xl border border-slate-200 hover:border-[#53a318] bg-white transition-all shadow-2xs group">
                    <span>সবগুলো ডিল</span>
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
                                    <span>🔥 ১টি স্লট বাকি!</span>
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-lg bg-amber-500 text-white text-[10px] font-black flex items-center space-x-1 shadow-2xs">
                                    <span>⚡ {{ $needed }}টি স্লট বাকি</span>
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
                                স্টক সীমিত
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
                            <span>⚡ স্লটে জয়েন করুন</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </section>
    @endif


    <!-- ========================================================
         2.6 DUAL FLASH DEAL CAMPAIGN BANNERS (HIGH CONVERSION SOCIAL COMMERCE)
         ======================================================== -->
    <div id="flash-deals" class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 scroll-mt-24">
        
        <!-- Promo Banner 1: Smart Audio & Wireless ANC Gear -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-[#07192e] border border-blue-900/40 p-6 sm:p-7 text-white shadow-xl group hover:shadow-2xl hover:border-blue-700/50 transition-all duration-300">
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-cyan-500/15 rounded-full blur-2xl pointer-events-none group-hover:bg-cyan-500/25 transition-all"></div>
            
            <div class="relative z-10 flex flex-col justify-between h-full space-y-4">
                <div class="space-y-2">
                    <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-cyan-300 text-[10px] font-black uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-ping"></span>
                        <span>🔥 TRENDING AUDIO POOL • SAVE UP TO 42%</span>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                        Studio ANC Audio & Wireless Earbuds
                    </h3>

                    <p class="text-xs text-slate-300 leading-relaxed max-w-md">
                        একসাথে ৩ জন সদস্য মিললেই ফ্ল্যাগশিপ সাউন্ড গ্যাজেটে আনলক হয় সরাসরি পাইকারি কারখানা রেট।
                    </p>

                    <!-- Feature Pills -->
                    <div class="flex flex-wrap items-center gap-2 pt-1 text-[10px] font-bold text-slate-300">
                        <span class="px-2 py-0.5 rounded-md bg-white/10 border border-white/10">35dB Active ANC</span>
                        <span class="px-2 py-0.5 rounded-md bg-white/10 border border-white/10">60H Playback</span>
                        <span class="px-2 py-0.5 rounded-md bg-white/10 border border-white/10 text-emerald-300">✓ 1-Year Warranty</span>
                    </div>
                </div>

                <!-- Price + CTA -->
                <div class="flex items-center justify-between pt-2 border-t border-white/10">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Team Price From</span>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-xl font-black text-cyan-300">৳১,৮৯০</span>
                            <span class="text-xs text-slate-400 line-through">৳৩,২৫০</span>
                        </div>
                    </div>
                    <a href="{{ route('category.show', 'smart-tech-audio') }}" 
                       class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-black text-xs shadow-md shadow-blue-950/60 hover:scale-105 active:scale-95 transition-all flex items-center space-x-1.5">
                        <span>Join Audio Pool</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Promo Banner 2: Winter Fleece & Cozy Living Drop -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-[#0a2012] to-slate-900 border border-emerald-900/40 p-6 sm:p-7 text-white shadow-xl group hover:shadow-2xl hover:border-emerald-700/50 transition-all duration-300">
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-[#53a318]/15 rounded-full blur-2xl pointer-events-none group-hover:bg-[#53a318]/25 transition-all"></div>
            
            <div class="relative z-10 flex flex-col justify-between h-full space-y-4">
                <div class="space-y-2">
                    <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[10px] font-black uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#84cc16] animate-ping"></span>
                        <span>❄️ WINTER SPECIAL DROP • DIRECT WHOLESALE TIER</span>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                        Heavyweight Fleece Hoodies & Home Gear
                    </h3>

                    <p class="text-xs text-slate-300 leading-relaxed max-w-md">
                        সরাসরি নিটিং কারখানা থেকে প্রিমিয়াম অর্গানিক ফ্লিস এবং ডেইলি হোম অ্যাপ্লায়েন্স অফার।
                    </p>

                    <!-- Feature Pills -->
                    <div class="flex flex-wrap items-center gap-2 pt-1 text-[10px] font-bold text-slate-300">
                        <span class="px-2 py-0.5 rounded-md bg-white/10 border border-white/10">340+ GSM Organic Fleece</span>
                        <span class="px-2 py-0.5 rounded-md bg-white/10 border border-white/10">Zero Shrinkage</span>
                        <span class="px-2 py-0.5 rounded-md bg-white/10 border border-white/10 text-emerald-300">✓ 100% Refundable</span>
                    </div>
                </div>

                <!-- Price + CTA -->
                <div class="flex items-center justify-between pt-2 border-t border-white/10">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Team Price From</span>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-xl font-black text-[#84cc16]">৳৮৫০</span>
                            <span class="text-xs text-slate-400 line-through">৳১,৪৫০</span>
                        </div>
                    </div>
                    <a href="{{ route('category.show', 'winter-specials') }}" 
                       class="px-4 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs shadow-md shadow-green-950/60 hover:scale-105 active:scale-95 transition-all flex items-center space-x-1.5">
                        <span>Explore Winter Pools</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>


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
            <p class="text-[11px] text-slate-500 sm:text-right">
                ১০০% জেনুইন প্রোডাক্টস • সরাসরি অথোরাইজড ডিস্ট্রিবিউটর ও ফ্যাক্টরি হাব
            </p>
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
         3. "HOW IT WORKS" (VISUAL 4-STEP ONBOARDING GUIDE)
         Theme: Clean Elevated Cards with Gradient Icons
         ======================================================== -->
    <section id="how-it-works" class="space-y-6">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-[11px] font-black uppercase tracking-widest text-[#53a318] bg-green-100 px-3 py-1 rounded-full inline-block">
                SIMPLE 4-STEP ONBOARDING
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                গ্রুপ বায় কিভাবে কাজ করে? (How Group Buying Works)
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                একসাথে কেনাকাটা করে পাইকারি মূল্য আনলক করার সহজ ও নিরাপদ ধাপসমূহ
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
            
            <!-- Step 1 -->
            <div class="relative bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-100 to-green-100 text-[#53a318] flex items-center justify-center text-2xl font-black group-hover:scale-110 transition-transform shadow-xs">
                    🏷️
                </div>
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-[#53a318] uppercase tracking-wider block">STEP 01</span>
                    <h3 class="text-base font-black text-slate-900">Choose a Deal</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        ক্যাটালগ থেকে বাল্ক টিয়ার অফার ও পছন্দের পণ্যটি বাছাই করুন। একলা কেনার চেয়ে টিম প্রাইস অনেক কম।
                    </p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="relative bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 text-amber-700 flex items-center justify-center text-2xl font-black group-hover:scale-110 transition-transform shadow-xs">
                    👥
                </div>
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-amber-700 uppercase tracking-wider block">STEP 02</span>
                    <h3 class="text-base font-black text-slate-900">Form or Join a Group</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        চলমান কোনো ওপেন পুলে যোগ দিয়ে স্লট বুক করুন অথবা নিজে নতুন গ্রুপ খুলে আপনার বন্ধুদের জন্য রুম তৈরি করুন।
                    </p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="relative bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-100 to-blue-100 text-cyan-700 flex items-center justify-center text-2xl font-black group-hover:scale-110 transition-transform shadow-xs">
                    📲
                </div>
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-cyan-700 uppercase tracking-wider block">STEP 03</span>
                    <h3 class="text-base font-black text-slate-900">Share & Invite</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        হোয়াটসঅ্যাপ, মেসেঞ্জার বা বন্ধুদের সাথে গ্রুপ কোড শেয়ার করুন যাতে সময় শেষ হওয়ার আগেই লক্ষ্য পূরণ হয়।
                    </p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="relative bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-100 to-indigo-100 text-purple-700 flex items-center justify-center text-2xl font-black group-hover:scale-110 transition-transform shadow-xs">
                    📦
                </div>
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-purple-700 uppercase tracking-wider block">STEP 04</span>
                    <h3 class="text-base font-black text-slate-900">Unlock & Ship</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        টার্গেট মেম্বার পূর্ণ হলেই সরাসরি পাইকারি রেটে সবার ঠিকানায় ডেলিভারি শুরু হবে। ব্যর্থ হলে ১০০% অটো-রিফান্ড!
                    </p>
                </div>
            </div>

        </div>
    </section>





    <!-- ========================================================
         5. LIVE ACTIVE BUYING DEALS GRID (CORE SECTION)
         Theme: 3-Tier Visual Pricing & Social-Proof Cards
         ======================================================== -->
    <section id="active-deals" class="space-y-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-200/80 pb-4">
            <div>
                <span class="text-[11px] font-black uppercase tracking-wider text-[#53a318]">CORE MARKETPLACE</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-0.5">
                    🛍️ Live Active Buying Deals Grid
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    মাল্টি-টিয়ার ডিসকাউন্ট, লাইভ প্রোগ্রেস বার এবং সোশ্যাল শেয়ারসহ সক্রিয় পণ্য তালিকা
                </p>
            </div>
            
            <!-- Quick Filter Bar -->
            <div class="flex items-center space-x-2 text-xs font-bold overflow-x-auto no-scrollbar">
                <button type="button" @click="activeFilterTab = 'all'" 
                        :class="activeFilterTab === 'all' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0">
                    <span>🌟 All Deals</span>
                </button>
                <button type="button" @click="activeFilterTab = 'fastest'" 
                        :class="activeFilterTab === 'fastest' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0">
                    <span>⚡ Fastest Filling</span>
                </button>
                <button type="button" @click="activeFilterTab = 'max_discount'" 
                        :class="activeFilterTab === 'max_discount' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0">
                    <span>🔥 Maximum Discount</span>
                </button>
                <button type="button" @click="activeFilterTab = 'winter'" 
                        :class="activeFilterTab === 'winter' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0">
                    <span>🧥 Winter Specials</span>
                </button>
            </div>
        </div>

        @if(request('category'))
            @php
                $activeCatItem = collect($topNavCategories)->firstWhere('slug', request('category'));
                $activeCatLabel = $activeCatItem ? $activeCatItem['name'] : ucwords(str_replace('-', ' ', request('category')));
            @endphp
            <div class="p-3.5 sm:p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 flex flex-wrap items-center justify-between gap-3 shadow-2xs">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-[#53a318] text-white flex items-center justify-center font-black text-xs shadow-2xs">
                        🏷️
                    </span>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-black text-slate-900">Filtered by: <span class="text-[#53a318]">{{ $activeCatLabel }}</span></span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-[#53a318]">Active Filter</span>
                        </div>
                        <span class="text-[11px] text-slate-500 block">Showing {{ $products->total() }} matching group buy {{ Str::plural('deal', $products->total()) }}</span>
                    </div>
                </div>

                <a href="{{ route('home') }}#active-deals" 
                   class="px-3.5 py-1.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 hover:text-rose-600 border border-slate-200 hover:border-rose-300 font-bold text-xs transition-colors shadow-2xs flex items-center space-x-1.5">
                    <span>✕ Clear Category Filter</span>
                </a>
            </div>
        @endif

        <!-- The Rich Product / Buying Pool Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                @php
                    $discountPct = round((($product->single_price - $product->group_price) / $product->single_price) * 100);
                    $nextTierPrice = round($product->group_price * 0.90);
                    $simulatedFilled = min(92, max(45, round((($product->sales_count * 7) % 50 + 25))));
                    $simulatedBuyers = max(2, round(($product->sales_count % 15) + 3));
                    $targetBuyers = $simulatedBuyers + rand(1, 4);
                    $isFastest = $simulatedFilled >= 60;
                    $isMaxDiscount = $discountPct >= 20;
                    $isWinter = ($product->category && str_contains($product->category->slug, 'winter')) || str_contains(strtolower($product->title), 'winter') || str_contains(strtolower($product->title), 'fleece');
                @endphp
                <div x-show="activeFilterTab === 'all' || (activeFilterTab === 'fastest' && {{ $isFastest ? 'true' : 'false' }}) || (activeFilterTab === 'max_discount' && {{ $isMaxDiscount ? 'true' : 'false' }}) || (activeFilterTab === 'winter' && {{ $isWinter ? 'true' : 'false' }})"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl border border-slate-200/90 shadow-xs hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    
                    <div>
                        <!-- Product Image & Badges -->
                        <div class="relative w-full aspect-square bg-slate-100 overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                            
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-xl text-[10px] font-black bg-white/95 text-slate-800 backdrop-blur-md shadow-xs">
                                {{ $product->category->name ?? 'General' }}
                            </span>

                            <!-- Discount Tag -->
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-xl text-[10px] font-black bg-[#53a318] text-white shadow-xs">
                                -{{ $discountPct }}% OFF
                            </span>

                            <!-- Rating overlay -->
                            <div class="absolute bottom-2.5 left-3 flex items-center space-x-1 bg-black/60 backdrop-blur-xs text-white px-2.5 py-1 rounded-lg text-[10px] font-bold">
                                <span class="text-amber-400">★</span>
                                <span>{{ number_format($product->rating, 1) }}</span>
                                <span class="text-slate-300">({{ $product->sales_count }})</span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 space-y-3.5">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors">
                                {{ $product->title }}
                            </h3>

                            <!-- Tier Pricing Visual Card -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                                <div class="flex items-baseline justify-between text-[11px]">
                                    <span class="text-slate-400">Regular: <span class="line-through">৳{{ number_format($product->single_price) }}</span></span>
                                    <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-1.5 py-0.2 rounded">Save ৳{{ number_format($product->single_price - $product->group_price) }}</span>
                                </div>
                                <div class="flex items-baseline justify-between">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Current Unlocked:</span>
                                        <span class="text-lg font-black text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[9px] uppercase font-bold text-amber-700 block">Next Target:</span>
                                        <span class="text-xs font-black text-amber-600">৳{{ number_format($nextTierPrice) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Progress Bar -->
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-[11px] font-bold">
                                    <span class="text-slate-600">Progress ({{ $simulatedBuyers }}/{{ $targetBuyers }} buyers)</span>
                                    <span class="text-[#53a318] font-black">{{ $simulatedFilled }}%</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-emerald-500 to-[#53a318] rounded-full" style="width: {{ $simulatedFilled }}%"></div>
                                </div>
                            </div>

                            <!-- Member Avatars Social Proof -->
                            <div class="flex items-center space-x-2 pt-1">
                                <div class="flex -space-x-1.5 overflow-hidden">
                                    <div class="inline-block h-5 w-5 rounded-full ring-2 ring-white bg-slate-800 text-white font-bold text-[8px] flex items-center justify-center">A</div>
                                    <div class="inline-block h-5 w-5 rounded-full ring-2 ring-white bg-green-600 text-white font-bold text-[8px] flex items-center justify-center">S</div>
                                    <div class="inline-block h-5 w-5 rounded-full ring-2 ring-white bg-amber-500 text-white font-bold text-[8px] flex items-center justify-center">M</div>
                                </div>
                                <span class="text-[10px] text-slate-500 font-semibold">+{{ $simulatedBuyers }} buyers active</span>
                            </div>

                        </div>
                    </div>

                    <!-- Dual Action Buttons: Join Group & Share / Copy Link -->
                    <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                        <a href="{{ route('products.show', $product) }}" 
                           class="py-2.5 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs flex items-center justify-center space-x-1">
                            <span>Join Group</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>

                        <button type="button" @click="openShare('GRP-PROD{{ $product->id }}', '{{ addslashes($product->title) }}')" 
                                class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition-colors">
                            Share Link
                        </button>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-slate-200/90 text-slate-500 space-y-3 shadow-xs">
                    <span class="text-4xl block">🔍</span>
                    <h3 class="text-base font-black text-slate-800">No active products found in this category</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">বর্তমানে এই বিভাগে কোনো সক্রিয় পুল নেই। অন্যান্য ক্যাটাগরি ব্রাউজ করুন অথবা সরাসরি সকল পণ্য দেখুন।</p>
                    <a href="{{ route('home') }}#active-deals" class="inline-block py-2.5 px-6 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs transition-colors shadow-xs">
                        View All Active Deals &rarr;
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Catalog Pagination -->
        <div class="pt-4 flex justify-center">
            {{ $products->links() }}
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
                <a href="{{ route('register') }}" 
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
         Theme: 3 Elevated Protection Pillars
         ======================================================== -->
    <section id="trust-policy" class="space-y-6">
        
        <div class="text-center max-w-xl mx-auto space-y-1">
            <span class="text-[11px] font-black uppercase tracking-wider text-[#53a318]">CUSTOMER PROTECTION</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                সুরক্ষা ও বিশ্বাসযোগ্যতা (Trust & Safety Badges)
            </h2>
            <p class="text-xs text-slate-500">
                গ্রুপ বাই প্ল্যাটফর্মে আপনার প্রতিটি লেনদেন ও অংশগ্রহণ সম্পূর্ণ ঝুঁকিমুক্ত
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Pillar 1: 100% Auto-Refund Guarantee -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-green-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-3 relative overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-green-100 text-[#53a318] flex items-center justify-center text-2xl font-black">
                    🛡️
                </div>
                <h3 class="text-base font-black text-slate-900">
                    100% Auto-Refund Guarantee
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    টার্গেট পূরণ না হলে কি হবে? নির্ধারিত সময়ের মধ্যে গ্রুপ মেম্বার পূরণ না হলে আপনার প্রিপেইড পেমেন্ট সম্পূর্ণ স্বয়ংক্রিয়ভাবে ১০০% রিফান্ড হয়ে যাবে। কোনো পেনাল্টি বা ফি ছাড়াই।
                </p>
                <div class="pt-2">
                    <button type="button" @click="rulesModalOpen = true" class="text-xs font-bold text-[#53a318] hover:underline">
                        Read Refund Rules &rarr;
                    </button>
                </div>
            </div>

            <!-- Pillar 2: Secure Checkout -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-3 relative overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-2xl font-black">
                    🔒
                </div>
                <h3 class="text-base font-black text-slate-900">
                    Secure Simulated & Gateway Checkout
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    এসক্রো-সুরক্ষিত পেমেন্ট প্রসেসিং। bKash, Nagad, কার্ড ও ক্যাশ অন ডেলিভারি সাপোর্ট। আপনার অর্থ অর্ডার চূড়ান্ত ডেলিভারি পর্যন্ত প্ল্যাটফর্ম এসক্রোতে সংরক্ষিত থাকে।
                </p>
                <div class="pt-2">
                    <span class="text-[11px] font-mono font-bold text-slate-500">256-Bit SSL Secured</span>
                </div>
            </div>

            <!-- Pillar 3: Verified Sellers -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 space-y-3 relative overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl font-black">
                    ✅
                </div>
                <h3 class="text-base font-black text-slate-900">
                    Verified Sellers & Genuine Products
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    কার্টিভার প্রতিটি বিক্রেতা ও তাদের পণ্য প্ল্যাটফর্ম অ্যাডমিন দ্বারা গুণগত মান পরীক্ষায় ভেরিফাইড। কোনো ত্রুটিপূর্ণ পণ্য পেলে ৪৮ ঘণ্টার রিপ্লেসমেন্ট সুবিধা।
                </p>
                <div class="pt-2">
                    <span class="text-[11px] font-mono font-bold text-slate-500">Admin Quality Checked</span>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================
         POPUP MODALS: SHARE MODAL & RULES MODAL
         ======================================================== -->
    
    <!-- Share / Copy Link Viral Modal -->
    <div x-show="shareModalOpen" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
        <div @click.outside="shareModalOpen = false" 
             class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5">
            
            <div class="flex items-center justify-between border-b pb-3">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">🚀</span>
                    <h3 class="text-base font-black text-slate-900">Invite Friends & Unlock Deal</h3>
                </div>
                <button @click="shareModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-2xl leading-none">&times;</button>
            </div>

            <div class="space-y-4">
                <p class="text-xs text-slate-600" x-text="'Share &quot;' + shareGroupTitle + '&quot; with friends to reach group milestone faster!'"></p>

                <!-- Group Code Display -->
                <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-center space-y-1">
                    <span class="text-[10px] uppercase font-bold text-amber-700 block tracking-wider">Group Access Code:</span>
                    <span class="text-2xl font-mono font-black text-amber-900 block" x-text="shareGroupCode"></span>
                </div>

                <!-- One Click Copy Link Button -->
                <button type="button" @click="copyShareLink(shareGroupCode)" 
                        class="w-full py-3 bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs rounded-xl shadow-md transition-colors flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span>Copy Invitation Link</span>
                </button>

                <!-- Direct Social Shortcuts -->
                <div class="pt-2 space-y-2">
                    <span class="text-[10px] font-black uppercase text-slate-400 block tracking-wider">Direct Social Share:</span>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('Hey! Join my Cartiva Group Buy circle to unlock huge volume discount: ' + window.location.origin + '/group-buy/' + shareGroupCode)" 
                           target="_blank" 
                           class="py-2.5 px-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-center flex items-center justify-center space-x-1.5 transition-colors">
                            <span>WhatsApp</span>
                        </a>
                        <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.origin + '/group-buy/' + shareGroupCode)" 
                           target="_blank" 
                           class="py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-center flex items-center justify-center space-x-1.5 transition-colors">
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>
            </div>

            <button type="button" @click="shareModalOpen = false" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition-colors">
                Done
            </button>
        </div>
    </div>


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
