@extends('layouts.app')

@section('title', 'Cartiva — Group Buying Platform | Buy Together, Pay Less')

@section('content')

<!-- Global Container for Group Buying Platform with Dynamic Theme -->
<div class="max-w-[1600px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-6 space-y-16"
     x-data="{
        shareModalOpen: false,
        shareGroupCode: '{{ $spotlightGroup ? $spotlightGroup->group_code : 'GRP-BAUST05' }}',
        shareGroupTitle: '{{ $spotlightGroup ? addslashes($spotlightGroup->product->title) : 'BAUST Winter Fleece Hoodie' }}',
        rulesModalOpen: false,
        copiedToast: false,
        activeFilterTab: 'fastest',
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
         Theme: Dark Command Center with Glowing Blue & Emerald Orbs
         ======================================================== -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-[#0a1a2e] to-[#071f0c] border border-slate-800 shadow-2xl text-white p-6 sm:p-10 lg:p-14">
        
        <!-- Ambient Radial Glows (Cartiva Royal Blue & Emerald) -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#53a318]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            
            <!-- Left Column: Bold Value Proposition -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Live Event Badge -->
                <div class="inline-flex items-center space-x-2.5 px-3.5 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-cyan-300 text-[11px] font-black uppercase tracking-wider shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-[#84cc16] animate-ping"></span>
                    <span>GROUP COMMERCE REVOLUTION • BUY TOGETHER & SAVE</span>
                </div>

                <!-- Bold Headline with Gradient Text -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.15]">
                    "একা কিনলে সাধারণ দাম,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#84cc16] via-emerald-400 to-cyan-300">
                        দল বাঁধলে পাইকারি দাম!"
                    </span>
                </h1>

                <!-- Explanatory Subtext -->
                <p class="text-sm sm:text-base text-slate-300 max-w-xl font-medium leading-relaxed">
                    অনলাইনে খুচরা মূল্যে অতিরিক্ত টাকা দেওয়ার দিন শেষ! আপনার সহপাঠী বা বন্ধুদের সাথে দল গঠন করে আনলক করুন সরাসরি কারখানা ও পাইকারি রেট। নির্দিষ্ট সময়ের মধ্যে গ্রুপ পূরণ না হলে পাবেন <strong class="text-white underline decoration-[#84cc16] underline-offset-4 font-bold">১০০% স্বয়ংক্রিয় রিফান্ড</strong>।
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="#urgent-pools" class="px-6 py-3.5 rounded-2xl text-xs sm:text-sm font-black bg-[#53a318] hover:bg-[#468c13] text-white shadow-xl shadow-green-950/50 hover:scale-105 active:scale-95 transition-all flex items-center space-x-2">
                        <span>⚡ Join Active Pool Now</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    
                    <a href="#active-deals" class="px-5 py-3.5 rounded-2xl text-xs sm:text-sm font-bold bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/10 transition-all hover:scale-105">
                        Explore Buying Pools &rarr;
                    </a>

                    <!-- Voucher Token -->
                    <div class="flex items-center space-x-2 px-3 py-2 rounded-xl bg-black/50 border border-white/10 text-xs font-mono shadow-inner">
                        <span class="text-amber-300 font-bold">VOUCHER:</span>
                        <span class="bg-amber-400 text-slate-950 font-black px-2 py-0.5 rounded text-[11px]">CARTIVA20</span>
                    </div>
                </div>

                <!-- Trust Micro-Pills (Glass Style) -->
                <div class="grid grid-cols-3 gap-3 pt-4 border-t border-white/10 text-xs">
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">মোট সাশ্রয়</span>
                        <span class="text-base sm:text-lg font-black text-[#84cc16]">৳{{ number_format($stats['total_saved'] ?? 2850000) }}+</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">সফল গ্রুপ বাই</span>
                        <span class="text-base sm:text-lg font-black text-amber-300">{{ number_format($stats['completed_groups'] ?? 1450) }}+</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">নিরাপত্তা</span>
                        <span class="text-base sm:text-lg font-black text-emerald-400">১০০% রিফান্ড</span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Live Spotlight Deal (Featured Running Pool) -->
            <div class="lg:col-span-5">
                @if($spotlightGroup)
                    <div class="relative bg-slate-900/90 backdrop-blur-xl rounded-3xl border-2 border-emerald-500/40 ring-4 ring-emerald-500/10 shadow-2xl shadow-emerald-950/60 p-6 sm:p-7 space-y-5"
                         x-data="groupCountdown({{ max(0, $spotlightGroup->expires_at->diffInSeconds(now())) }})"
                         x-init="start()">
                        
                        <!-- Top Header with Glowing Neon Pulse -->
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500 animate-pulse"></span>
                                <span class="text-[11px] font-black uppercase tracking-wider text-rose-400">
                                    LIVE SPOTLIGHT DEAL • TRENDING POOL
                                </span>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-500/20 text-[#84cc16] font-mono text-xs font-black border border-emerald-500/30">
                                {{ $spotlightGroup->group_code }}
                            </span>
                        </div>

                        <!-- Product Thumbnail & Info -->
                        <div class="flex items-center space-x-4">
                            <div class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden bg-slate-800 flex-shrink-0 border border-slate-700 shadow-md">
                                <img src="{{ $spotlightGroup->product->image_url }}" alt="{{ $spotlightGroup->product->title }}" class="w-full h-full object-cover">
                                <span class="absolute top-1 left-1 px-1.5 py-0.5 rounded text-[9px] font-black bg-rose-600 text-white shadow-xs">
                                    -{{ round((($spotlightGroup->product->single_price - $spotlightGroup->product->group_price)/$spotlightGroup->product->single_price)*100) }}%
                                </span>
                            </div>
                            <div class="flex-1 min-w-0 space-y-1">
                                <span class="text-[10px] font-black uppercase tracking-wider text-cyan-300 block truncate">
                                    {{ $spotlightGroup->product->category->name ?? 'Campus Special' }}
                                </span>
                                <h3 class="text-sm sm:text-base font-black text-white line-clamp-2 leading-snug">
                                    {{ $spotlightGroup->product->title }}
                                </h3>
                                <p class="text-[11px] text-slate-400">
                                    বিক্রেতা: <span class="text-slate-200 font-bold">{{ $spotlightGroup->product->seller->name ?? 'Verified Merchant' }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Pricing Visual: Regular vs Current Pool Price -->
                        <div class="p-4 rounded-2xl bg-black/50 border border-slate-800 space-y-2">
                            <div class="flex items-baseline justify-between">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Regular Single Price:</span>
                                    <span class="text-sm line-through text-slate-500 font-bold">৳{{ number_format($spotlightGroup->product->single_price) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-[#84cc16] uppercase tracking-wider block">Current Pool Price:</span>
                                    <span class="text-2xl sm:text-3xl font-black text-[#84cc16]">৳{{ number_format($spotlightGroup->product->group_price) }}</span>
                                </div>
                            </div>
                            <div class="text-[11px] text-amber-300 font-bold bg-amber-500/10 px-2.5 py-1.5 rounded-lg flex items-center justify-between border border-amber-500/20">
                                <span>সাশ্রয়: ৳{{ number_format($spotlightGroup->product->single_price - $spotlightGroup->product->group_price) }} (২৫% OFF)</span>
                                <span class="font-mono text-cyan-300 font-black">⏱ <span x-text="timeString"></span> বাকি</span>
                            </div>
                        </div>

                        <!-- Animated Progress Bar -->
                        @php
                            $fillPct = min(100, round(($spotlightGroup->current_members / $spotlightGroup->required_members) * 100));
                            $remaining = max(1, $spotlightGroup->required_members - $spotlightGroup->current_members);
                        @endphp
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-slate-300 flex items-center space-x-1.5">
                                    <span>👥 Pool Progress:</span>
                                    <span class="text-[#84cc16] font-black">{{ $spotlightGroup->current_members }}/{{ $spotlightGroup->required_members }} buyers joined</span>
                                </span>
                                <span class="text-amber-400 font-black">{{ $fillPct }}% Filled</span>
                            </div>
                            
                            <!-- Dynamic Bar with Animated Glow -->
                            <div class="w-full h-3 rounded-full bg-slate-800 overflow-hidden p-0.5 border border-slate-700">
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 via-[#53a318] to-cyan-400 shadow-md transition-all duration-500 animate-pulse"
                                     style="width: {{ $fillPct }}%;"></div>
                            </div>

                            <p class="text-[11px] text-amber-300 font-semibold">
                                🔥 আর মাত্র <strong class="text-white font-black underline">{{ $remaining }} জন</strong> সদস্য হলেই পাইকারি রেট ১০০% নিশ্চিত!
                            </p>
                        </div>

                        <!-- Member Avatars Social Proof -->
                        <div class="flex items-center justify-between pt-1 border-t border-slate-800 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="flex -space-x-2 overflow-hidden">
                                    <div class="inline-block h-7 w-7 rounded-full ring-2 ring-slate-900 bg-amber-500 text-slate-950 font-black text-[10px] flex items-center justify-center shadow-xs">AS</div>
                                    <div class="inline-block h-7 w-7 rounded-full ring-2 ring-slate-900 bg-emerald-500 text-white font-black text-[10px] flex items-center justify-center shadow-xs">FH</div>
                                    <div class="inline-block h-7 w-7 rounded-full ring-2 ring-slate-900 bg-cyan-500 text-slate-950 font-black text-[10px] flex items-center justify-center shadow-xs">TR</div>
                                    <div class="inline-block h-7 w-7 rounded-full ring-2 ring-slate-900 bg-purple-500 text-white font-black text-[10px] flex items-center justify-center shadow-xs">+1</div>
                                </div>
                                <span class="text-[11px] text-slate-400">৪ জন সদস্য সক্রিয় আছেন</span>
                            </div>

                            <button type="button" @click="openShare('{{ $spotlightGroup->group_code }}', '{{ addslashes($spotlightGroup->product->title) }}')" 
                                    class="text-xs text-slate-300 hover:text-white font-bold flex items-center space-x-1 transition-colors">
                                <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                <span>Share Link</span>
                            </button>
                        </div>

                        <!-- Action Buttons: Join Pool & Start Pool -->
                        <div class="grid grid-cols-2 gap-2.5 pt-2">
                            <a href="{{ route('group-buy.show', $spotlightGroup->group_code) }}" 
                               class="py-3 px-4 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-center text-xs transition-all shadow-lg shadow-green-950/50 hover:scale-[1.02] flex items-center justify-center space-x-1.5">
                                <span>Join Pool Now</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>

                            <a href="{{ route('products.show', $spotlightGroup->product) }}" 
                               class="py-3 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-center text-xs transition-all border border-slate-700 hover:scale-[1.02]">
                                Start New Pool
                            </a>
                        </div>

                    </div>
                @else
                    <!-- Fallback Spotlight Card -->
                    <div class="bg-slate-900 rounded-3xl p-8 border border-slate-800 text-center space-y-4">
                        <span class="text-4xl block">⚡</span>
                        <h3 class="text-lg font-black text-white">Create the First Group Today!</h3>
                        <p class="text-xs text-slate-400">ক্যাটালগ থেকে যেকোনো পণ্য পছন্দ করে নতুন পুল চালু করুন এবং বন্ধুদের ইনভাইট করুন।</p>
                        <a href="#active-deals" class="inline-block py-2.5 px-6 rounded-xl bg-[#53a318] text-white font-bold text-xs">Browse Products</a>
                    </div>
                @endif
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
         4. "ENDING SOON / RUSH HOUR" POOLS (HIGH URGENCY ZONE)
         Theme: Amber/Coral Urgency Borders & Monospace Countdown
         ======================================================== -->
    <section id="urgent-pools" class="space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-200/80 pb-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                    <span class="text-[11px] font-black uppercase tracking-wider text-rose-600">HIGH CONVERSION URGENCY ZONE</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">
                    ⚡ Ending Soon / Rush Hour Pools
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    যে গ্রুপগুলোর সময় শেষ হতে মাত্র কয়েক ঘণ্টা বাকি — আর অল্প কয়েকজন হলেই সর্বোচ্চ ডিসকাউন্ট নিশ্চিত!
                </p>
            </div>
            <a href="#active-deals" class="text-xs font-bold text-[#53a318] hover:underline flex items-center space-x-1">
                <span>View All Active Pools &rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($urgentGroups as $group)
                @php
                    $discountPct = round((($group->product->single_price - $group->product->group_price) / $group->product->single_price) * 100);
                    $needed = max(1, $group->required_members - $group->current_members);
                    $pct = min(100, round(($group->current_members / $group->required_members) * 100));
                @endphp
                <div class="bg-white rounded-3xl border-2 border-amber-300/80 shadow-md hover:shadow-2xl hover:border-amber-400 hover:-translate-y-1.5 transition-all duration-300 p-5 flex flex-col justify-between space-y-4 relative"
                     x-data="groupCountdown({{ max(0, $group->expires_at->diffInSeconds(now())) }})"
                     x-init="start()">
                    
                    <!-- Top Urgency Pill -->
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 text-[10px] font-black uppercase tracking-wider flex items-center space-x-1">
                            <span>⏱ ENDING SOON</span>
                        </span>
                        <span class="font-mono text-xs font-black text-rose-600 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-200/60" x-text="timeString"></span>
                    </div>

                    <!-- Product Image & Badge -->
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-100 group">
                        <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                        <span class="absolute top-2 left-2 px-2.5 py-1 rounded-xl text-[10px] font-black bg-rose-600 text-white shadow-xs">
                            -{{ $discountPct }}% OFF
                        </span>
                        <span class="absolute bottom-2 right-2 px-2.5 py-0.5 rounded-lg text-[10px] font-mono font-bold bg-slate-900/85 text-white backdrop-blur-xs">
                            {{ $group->group_code }}
                        </span>
                    </div>

                    <!-- Title & Pricing -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">
                            {{ $group->product->category->name ?? 'General' }}
                        </span>
                        <h4 class="text-xs sm:text-sm font-black text-slate-900 line-clamp-2 leading-snug">
                            {{ $group->product->title }}
                        </h4>
                        
                        <div class="flex items-baseline space-x-2 pt-1">
                            <span class="text-base sm:text-lg font-black text-[#53a318]">৳{{ number_format($group->product->group_price) }}</span>
                            <span class="text-xs text-slate-400 line-through">৳{{ number_format($group->product->single_price) }}</span>
                        </div>
                    </div>

                    <!-- Threshold Warning Alert Box -->
                    <div class="p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-[11px] font-bold shadow-2xs">
                        ⚠️ আর মাত্র <strong class="text-rose-600 font-black">{{ $needed }} জন</strong> হলেই {{ $discountPct }}% ছাড় আনলক হবে!
                    </div>

                    <!-- Progress Bar -->
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="text-slate-600">{{ $group->current_members }}/{{ $group->required_members }} জন সদস্য</span>
                            <span class="text-emerald-700">{{ $pct }}% Filled</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>

                    <!-- Dual Action Buttons -->
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a href="{{ route('group-buy.show', $group->group_code) }}" 
                           class="py-2.5 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs flex items-center justify-center space-x-1">
                            <span>Join Pool</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>

                        <button type="button" @click="openShare('{{ $group->group_code }}', '{{ addslashes($group->product->title) }}')" 
                                class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition-colors">
                            Share Link
                        </button>
                    </div>

                </div>
            @empty
                <div class="col-span-full p-8 text-center bg-white rounded-3xl border border-slate-200 text-slate-500">
                    বর্তমানে কোনো আর্জেন্ট পুল নেই। নিচে একটি নতুন গ্রুপ শুরু করুন!
                </div>
            @endforelse
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
                <button type="button" @click="activeFilterTab = 'fastest'" 
                        :class="activeFilterTab === 'fastest' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0">
                    <span>⚡ Fastest Filling</span>
                </button>
                <button type="button" @click="activeFilterTab = 'max_discount'" 
                        :class="activeFilterTab === 'max_discount' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0">
                    <span>🔥 Maximum Discount</span>
                </button>
                <button type="button" @click="activeFilterTab = 'campus'" 
                        :class="activeFilterTab === 'campus' ? 'bg-[#53a318] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl transition-all flex items-center space-x-1.5 flex-shrink-0">
                    <span>🎓 Campus Specials</span>
                </button>
            </div>
        </div>

        <!-- The Rich Product / Buying Pool Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                @php
                    $discountPct = round((($product->single_price - $product->group_price) / $product->single_price) * 100);
                    $nextTierPrice = round($product->group_price * 0.90);
                    $simulatedFilled = min(92, max(45, round((($product->sales_count * 7) % 50 + 25))));
                    $simulatedBuyers = max(2, round(($product->sales_count % 15) + 3));
                    $targetBuyers = $simulatedBuyers + rand(1, 4);
                @endphp
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    
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
            @endforeach
        </div>

        <!-- Catalog Pagination -->
        <div class="pt-4 flex justify-center">
            {{ $products->links() }}
        </div>

    </section>


    <!-- ========================================================
         6. CATEGORY EXPLORER & QUICK FILTER TABS
         Theme: Modern Icon Cards with Rounded Containers
         ======================================================== -->
    <section id="category-explorer" class="space-y-6">
        
        <div class="text-center max-w-xl mx-auto space-y-1">
            <span class="text-[11px] font-black uppercase tracking-wider text-[#53a318]">BROWSE DEPARTMENTS</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                ক্যাটাগরি এক্সপ্লোরার (Category Explorer)
            </h2>
            <p class="text-xs text-slate-500">আপনার পছন্দের বিভাগে সহজে গ্রুপ বাই ডিল খুঁজুন</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('home') }}?category={{ $cat->slug }}" 
                   class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-2xs hover:shadow-lg hover:border-[#53a318] hover:-translate-y-1 transition-all text-center space-y-2 group">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-slate-50 group-hover:bg-green-50 flex items-center justify-center text-2xl transition-all group-hover:scale-110 shadow-2xs">
                        {{ $cat->icon ?? '📦' }}
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-800 group-hover:text-[#53a318] transition-colors truncate">
                            {{ $cat->name }}
                        </h4>
                        <span class="text-[10px] text-slate-400 font-bold">
                            {{ $cat->products_count ?? 12 }}+ Deals
                        </span>
                    </div>
                </a>
            @endforeach
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
                    যাচাইকৃত ট্রেড লাইসেন্স বা স্টুডেন্ট স্টার্টআপ এপ্রুভাল প্রয়োজন।
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
