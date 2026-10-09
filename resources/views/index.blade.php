@extends('layouts.app')

@section('title', 'Cartiva – একা কিনলে পুরো দাম, একসাথে কিনলে বিরাট ছাড়! | Group Buying Platform')

@section('content')

    <!-- ==========================================
         ২. HERO SECTION (প্ল্যাটফর্ম ভ্যালু ও কল-টু-অ্যাকশন)
         ========================================== -->
    <div class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-emerald-950 to-slate-900 text-white py-14 sm:py-20">
        <!-- Ambient Glow Elements -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Hero Copy -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-black tracking-wide">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                        <span>বাংলাদেশের প্রথম সোশ্যাল টিম বায়িং প্ল্যাটফর্ম</span>
                    </div>

                    <!-- মূল ব্যানার মেসেজ -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                        "একা কিনলে পুরো দাম,<br>
                        <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">
                            একসাথে কিনলে বিরাট ছাড়!"
                        </span>
                    </h1>

                    <!-- সাব-হেডিং -->
                    <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        খুচরা দামে আর অতিরিক্ত টাকা নষ্ট নয়! বন্ধুদের সাথে দল গঠন করুন বা চলমান গ্রুপে ১-ক্লিকে জয়েন করে ভলিউম পাইকারি ডিসকাউন্ট আনলক করুন। গ্রুপ লক্ষ্য পূরণ না হলে ১০০% স্বয়ংক্রিয় রিফান্ড গ্যারান্টি।
                    </p>

                    <!-- প্রাইমারি অ্যাকশন বাটনস (CTA) -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#live-groups" class="px-6 py-3.5 text-xs sm:text-sm font-extrabold rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white shadow-lg shadow-emerald-500/25 hover:shadow-xl transition-all flex items-center space-x-2">
                            <span>Explore Live Groups</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        <a href="#how-it-works" class="px-6 py-3.5 text-xs sm:text-sm font-bold rounded-2xl bg-slate-800/80 hover:bg-slate-700/80 text-slate-200 border border-slate-700 transition-all flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>How It Works</span>
                        </a>
                    </div>

                    <!-- রিয়েল-টাইম প্ল্যাটফর্ম স্ট্যাটস (Social Proof) -->
                    <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-6 border-t border-slate-800 text-center lg:text-left">
                        <div class="p-3 rounded-2xl bg-slate-900/40 border border-slate-800/80">
                            <div class="text-xl sm:text-2xl font-black text-emerald-400">
                                {{ number_format($stats['completed_groups']) }}+
                            </div>
                            <div class="text-[11px] text-slate-400 font-semibold mt-0.5">সফল সমাপ্ত গ্রুপ</div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-900/40 border border-slate-800/80">
                            <div class="text-xl sm:text-2xl font-black text-amber-400">
                                ৳{{ number_format($stats['total_saved']) }}+
                            </div>
                            <div class="text-[11px] text-slate-400 font-semibold mt-0.5">গ্রাহকদের মোট সাশ্রয়</div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-900/40 border border-slate-800/80">
                            <div class="text-xl sm:text-2xl font-black text-cyan-400">
                                {{ $stats['verified_sellers'] }}+
                            </div>
                            <div class="text-[11px] text-slate-400 font-semibold mt-0.5">ভেরিফাইড মার্চেন্ট</div>
                        </div>
                    </div>
                </div>

                <!-- Right Hero Card: Top Live Hot Drop Preview -->
                <div class="lg:col-span-5">
                    <div class="relative bg-slate-900/90 rounded-3xl border border-slate-700/80 p-6 sm:p-7 shadow-2xl backdrop-blur-xl">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                            <span class="text-xs font-black text-amber-400 uppercase tracking-wider flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                                <span>HOTTEST LIVE DROP</span>
                            </span>
                            <span class="px-2.5 py-1 text-[10px] font-black rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                আর মাত্র ১ জন বাকি!
                            </span>
                        </div>

                        @if($activeGroups->isNotEmpty())
                            @php $featuredGroup = $activeGroups->first(); @endphp
                            <div class="mt-4 space-y-4" 
                                 x-data="groupCountdown({{ max(0, now()->diffInSeconds($featuredGroup->expires_at, false)) }})" 
                                 x-init="start()">
                                
                                <div class="relative rounded-2xl overflow-hidden aspect-video bg-slate-800">
                                    <img src="{{ $featuredGroup->product->image_url }}" alt="{{ $featuredGroup->product->title }}" class="w-full h-full object-cover">
                                    <div class="absolute top-3 left-3 px-3 py-1 rounded-xl bg-rose-600 text-white font-black text-xs shadow-md">
                                        -{{ $featuredGroup->product->discount_percent }}% সাশ্রয়
                                    </div>
                                    <div class="absolute bottom-3 right-3 px-3 py-1 rounded-xl bg-slate-950/80 backdrop-blur-xs text-white font-mono text-xs font-black border border-slate-700">
                                        Code: {{ $featuredGroup->group_code }}
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-base font-bold text-white line-clamp-1">{{ $featuredGroup->product->title }}</h3>
                                    <div class="flex items-baseline space-x-3 mt-1.5">
                                        <span class="text-2xl font-black text-emerald-400">৳{{ number_format($featuredGroup->product->group_price) }}</span>
                                        <span class="text-sm text-slate-400 line-through">৳{{ number_format($featuredGroup->product->single_price) }}</span>
                                        <span class="text-xs font-bold text-emerald-400 bg-emerald-950/80 px-2 py-0.5 rounded-md border border-emerald-800">
                                            টিম রেট
                                        </span>
                                    </div>
                                </div>

                                <!-- Live Timer & Slots Indicator -->
                                <div class="p-4 rounded-2xl bg-slate-800/80 border border-slate-700/60 space-y-2.5 text-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-300 font-semibold">মেম্বার প্রগ্রেস:</span>
                                        <span class="text-emerald-400 font-black">{{ $featuredGroup->current_members }}/{{ $featuredGroup->required_members }} জন যুক্ত</span>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-slate-700 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-2.5 rounded-full" 
                                             style="width: {{ ($featuredGroup->current_members / $featuredGroup->required_members) * 100 }}%"></div>
                                    </div>

                                    <div class="flex items-center justify-between pt-1 text-[11px]">
                                        <span class="text-amber-300 font-bold">⏱ শেষ হতে বাকি:</span>
                                        <span class="font-mono font-black text-amber-400" x-text="timeString">00:00:00</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3 pt-1">
                                    <a href="{{ route('group-buy.show', $featuredGroup) }}" class="text-center py-3 px-4 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 transition-colors">
                                        View Room
                                    </a>
                                    <form action="{{ route('group-buy.join', $featuredGroup) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-center py-3 px-4 rounded-xl text-xs font-black bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white shadow-lg transition-all">
                                            Join Now & Save
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- ==========================================
         ৩. "HOW CARTIVA WORKS" (গ্রুপ বায়িং নির্দেশিকা)
         ========================================== -->
    <section id="how-it-works" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-black uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    সহজ ও ঝুঁকিমুক্ত ৩টি ধাপ
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-3 tracking-tight">
                    How Cartiva Group Buying Works
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">
                    ভলিউম ডিসকাউন্ট পাওয়া এখন মাত্র কয়েকটি ক্লিকের ব্যাপার!
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- কার্ড ১: ব্রাউজ ও প্রোডাক্ট নির্বাচন -->
                <div class="p-7 rounded-3xl bg-slate-50 border border-slate-200/80 text-center space-y-4 hover:border-emerald-300 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 font-black text-xl flex items-center justify-center mx-auto shadow-inner group-hover:scale-110 transition-transform">
                        ১
                    </div>
                    <h3 class="text-base font-black text-slate-900">১. ব্রাউজ ও প্রোডাক্ট নির্বাচন</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        পছন্দের প্রোডাক্ট বেছে নিন এবং একক মূল্যের বদলে আকর্ষণীয় <strong>"Team Buy"</strong> ডিসকাউন্টেড প্রাইস নির্বাচন করুন।
                    </p>
                    <span class="inline-block text-[11px] font-bold text-emerald-700 bg-emerald-100/60 px-2.5 py-0.5 rounded-full">
                        বাজারমূল্য থেকে ৩০-৫০% সাশ্রয়
                    </span>
                </div>

                <!-- কার্ড ২: গ্রুপে যোগদান বা তৈরি -->
                <div class="p-7 rounded-3xl bg-slate-50 border border-slate-200/80 text-center space-y-4 hover:border-teal-300 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-700 font-black text-xl flex items-center justify-center mx-auto shadow-inner group-hover:scale-110 transition-transform">
                        ২
                    </div>
                    <h3 class="text-base font-black text-slate-900">২. গ্রুপে যোগদান বা তৈরি</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        ১-ক্লিকে চলতি যেকোনো গ্রুপে যোগ দিন অথবা নিজে নতুন গ্রুপ শুরু করে ইনভাইট লিংক বন্ধুদের বা সোশ্যাল মিডিয়ায় শেয়ার করুন।
                    </p>
                    <span class="inline-block text-[11px] font-bold text-teal-700 bg-teal-100/60 px-2.5 py-0.5 rounded-full">
                        স্বয়ংক্রিয় ক্রেতা ম্যাচিং
                    </span>
                </div>

                <!-- কার্ড ৩: টিয়ার আনলক ও ডেলিভারি -->
                <div class="p-7 rounded-3xl bg-slate-50 border border-slate-200/80 text-center space-y-4 hover:border-indigo-300 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-700 font-black text-xl flex items-center justify-center mx-auto shadow-inner group-hover:scale-110 transition-transform">
                        ৩
                    </div>
                    <h3 class="text-base font-black text-slate-900">৩. টিয়ার আনলক ও ডেলিভারি</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        টার্গেট সদস্য পূর্ণ হওয়ামাত্র কম মূল্যে অর্ডার কনফার্ম হবে এবং আপনার দোরগোড়ায় পৌঁছে যাবে। সময় শেষ হলে ১০০% তাৎক্ষণিক রিফান্ড।
                    </p>
                    <span class="inline-block text-[11px] font-bold text-indigo-700 bg-indigo-100/60 px-2.5 py-0.5 rounded-full">
                        ১০০% রিস্ক-ফ্রি গ্যারান্টি
                    </span>
                </div>

            </div>
        </div>
    </section>


    <!-- ==========================================
         ৪. "ENDING SOON & HOT GROUPS" (লাইভ ড্রপস - হাই-কনভার্সন সেকশন)
         ========================================== -->
    <section id="live-groups" class="py-16 bg-gradient-to-b from-slate-900 to-slate-950 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10">
                <div>
                    <div class="flex items-center space-x-2 text-xs font-black uppercase tracking-wider text-amber-400 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                        <span>লাইভ ড্রপস — আর সামান্য কয়েকজন বাকি</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        🔥 Ending Soon & Hot Groups
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1">
                        যেসব গ্রুপের সময় শেষ হওয়ার পথে কিন্তু ১-২ জন সদস্যের অভাবে সর্বোচ্চ ডিসকাউন্ট আটকে আছে — এখনই জয়েন করুন!
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center space-x-2 text-xs font-bold text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Alpine.js Live Synchronized</span>
                </div>
            </div>

            @if($activeGroups->isEmpty())
                <div class="bg-slate-800/40 border border-slate-700/60 rounded-3xl p-10 text-center text-slate-400">
                    <p class="text-base font-semibold">এই মুহূর্তে কোনো খোলা গ্রুপ নেই।</p>
                    <p class="text-xs text-slate-500 mt-1">নিচের যেকোনো প্রোডাক্ট বেছে নিয়ে আপনিই শুরু করুন প্রথম টিম বাই!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeGroups as $group)
                        @php
                            $sec = max(0, now()->diffInSeconds($group->expires_at, false));
                            $remaining = $group->remainingSlots();
                        @endphp
                        <div class="bg-slate-900 rounded-3xl border border-slate-800 hover:border-emerald-500/60 transition-all p-6 shadow-xl flex flex-col justify-between"
                             x-data="groupCountdown({{ $sec }})" x-init="start()">
                            
                            <div>
                                <!-- Top Bar with Code & Live Ticking Countdown -->
                                <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 font-mono text-[11px] font-bold border border-slate-700">
                                        {{ $group->group_code }}
                                    </span>

                                    <!-- লাইভ কাউন্টডাউন টাইমার -->
                                    <div class="flex items-center space-x-1.5 font-mono text-xs font-black text-amber-400 bg-amber-400/10 border border-amber-400/20 px-3 py-1 rounded-xl">
                                        <svg class="w-3.5 h-3.5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>⏱ বাকি:</span>
                                        <span x-text="timeString">00:00:00</span>
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="flex space-x-4 mt-4">
                                    <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-20 h-20 rounded-2xl object-cover bg-slate-800 flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('products.show', $group->product) }}" class="text-sm font-bold text-white hover:text-emerald-400 line-clamp-2 transition-colors">
                                            {{ $group->product->title }}
                                        </a>
                                        <div class="mt-2 flex items-baseline space-x-2">
                                            <span class="text-lg font-black text-emerald-400">৳{{ number_format($group->product->group_price) }}</span>
                                            <span class="text-xs text-slate-400 line-through">৳{{ number_format($group->product->single_price) }}</span>
                                            <span class="text-[10px] font-black text-rose-400 bg-rose-950 px-1.5 py-0.5 rounded">
                                                -{{ $group->product->discount_percent }}% OFF
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- ভিজ্যুয়াল প্রগ্রেস বার ও মেম্বার কাউন্ট -->
                                <div class="mt-5 p-4 rounded-2xl bg-slate-800/60 border border-slate-700/60 space-y-2.5">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-300 font-medium">মেম্বার প্রগ্রেস:</span>
                                        <span class="font-bold text-emerald-400">
                                            {{ $group->current_members }}/{{ $group->required_members }} জন যুক্ত 
                                            @if($remaining > 0)
                                                <span class="text-amber-300 font-extrabold">(আর মাত্র {{ $remaining }} জন!)</span>
                                            @endif
                                        </span>
                                    </div>

                                    <!-- প্রগ্রেস বার -->
                                    <div class="w-full bg-slate-700 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-300 h-2.5 rounded-full transition-all duration-500" 
                                             style="width: {{ ($group->current_members / $group->required_members) * 100 }}%"></div>
                                    </div>

                                    <!-- Member Avatars and Open Slots -->
                                    <div class="flex items-center space-x-2 pt-1">
                                        @foreach($group->members as $member)
                                            <div class="w-7 h-7 rounded-full bg-emerald-600 text-white font-black text-[10px] flex items-center justify-center ring-2 ring-emerald-500 shadow-sm" title="{{ $member->user->name }}">
                                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                            </div>
                                        @endforeach

                                        @for($i = 0; $i < $remaining; $i++)
                                            <div class="w-7 h-7 rounded-full border border-dashed border-amber-400 bg-amber-400/10 text-amber-300 font-black text-[10px] flex items-center justify-center animate-pulse" title="খালি স্লট">
                                                +১
                                            </div>
                                        @endfor

                                        <span class="text-[10px] text-slate-400 pl-1.5 truncate">
                                            লিডার: {{ $group->leader->name }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- ডিরেক্ট সিটিএ বাটন (Join Group) -->
                            <div class="mt-5 pt-4 border-t border-slate-800 flex items-center space-x-3">
                                <a href="{{ route('group-buy.show', $group) }}" class="flex-1 text-center py-2.5 px-3 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 transition-colors">
                                    View Room
                                </a>
                                <form action="{{ route('group-buy.join', $group) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full text-center py-2.5 px-3 rounded-xl text-xs font-black bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white shadow-md shadow-emerald-500/30 transition-all">
                                        Join Group ⚡
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>


    <!-- ==========================================
         ৫. TRENDING CATEGORIES (ক্যাটাগরি গ্রিড)
         ========================================== -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        কুইক ফিল্টারিং
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2 tracking-tight">
                        Trending Categories
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        আপনার প্রয়োজনীয় ক্যাটাগরি বেছে নিন এবং সরাসরি দলবদ্ধ ক্রয়ের অফারগুলো দেখুন।
                    </p>
                </div>
                <a href="{{ route('home') }}" class="mt-4 sm:mt-0 text-xs font-bold text-emerald-600 hover:underline">
                    সব ক্যাটাগরি দেখুন &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat) }}" 
                       class="p-5 rounded-3xl bg-slate-50 hover:bg-emerald-50/60 border border-slate-200/90 hover:border-emerald-300 hover:shadow-lg transition-all text-center flex flex-col items-center justify-center space-y-2 group">
                        <span class="text-3xl sm:text-4xl group-hover:scale-125 transition-transform duration-300">{{ $cat->icon ?? '🏷️' }}</span>
                        <h4 class="text-xs font-extrabold text-slate-800 group-hover:text-emerald-700 transition-colors line-clamp-1">
                            {{ $cat->name }}
                        </h4>
                        <span class="text-[10px] font-bold text-slate-400 group-hover:text-emerald-600">
                            {{ $cat->products_count }}টি ডিল উপলব্ধ
                        </span>
                    </a>
                @endforeach
            </div>

        </div>
    </section>


    <!-- ==========================================
         ৬. FEATURED CAMPAIGN PRODUCTS (টিয়ার প্রিভিউসহ প্রডাক্ট গ্রিড)
         ========================================== -->
    <section id="featured-campaigns" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-10">
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-teal-600 bg-teal-50 px-3 py-1 rounded-full border border-teal-200">
                    ভলিউম ডিসকাউন্ট শপ
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2 tracking-tight">
                    Featured Campaign Products
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    কার্ডের ভেতরেই টিয়ার ডিসকাউন্ট ও স্টক স্ট্যাটাস দেখে তাৎক্ষণিক সিদ্ধান্ত নিন।
                </p>
            </div>
            <div class="mt-4 sm:mt-0 text-xs font-semibold text-slate-500">
                মোট {{ $products->total() }}টি প্রোডাক্ট
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-3xl border border-slate-200/90 hover:border-emerald-500/60 hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    
                    <div>
                        <!-- Product Image & Overlay Badges -->
                        <div class="relative aspect-square bg-slate-100 overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Discount Badge -->
                            <div class="absolute top-3 left-3 bg-rose-600 text-white text-[11px] font-black px-2.5 py-1 rounded-xl shadow-md">
                                -{{ $product->discount_percent }}% টিম ছাড়
                            </div>

                            <!-- স্টকের সার্বিক অবস্থা -->
                            <div class="absolute top-3 right-3 bg-slate-900/85 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-1 rounded-lg">
                                স্টকে বাকি {{ $product->stock }}টি
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5">
                            
                            <!-- Category & Seller Name -->
                            <div class="flex items-center justify-between text-[11px] text-slate-500 mb-1">
                                <span class="font-extrabold text-emerald-600 uppercase">{{ $product->category->name ?? 'Gear' }}</span>
                                <span class="text-slate-400 truncate max-w-[110px]">{{ $product->seller->name ?? 'Verified Seller' }}</span>
                            </div>

                            <!-- Product Title -->
                            <h3 class="text-sm font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors">
                                <a href="{{ route('products.show', $product) }}">
                                    {{ $product->title }}
                                </a>
                            </h3>

                            <!-- Rating & Sales -->
                            <div class="flex items-center space-x-1 mt-2 text-xs">
                                <span class="text-amber-500">★</span>
                                <span class="font-bold text-slate-800">{{ $product->rating }}</span>
                                <span class="text-slate-400">({{ $product->sales_count }} বিক্রিত)</span>
                            </div>

                            <!-- টিয়ার প্রাইস স্ল্যাবস (Pricing Tier Slabs Preview) -->
                            <div class="mt-4 p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                                <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block">Pricing Tiers (মূল্য স্ল্যাব):</span>
                                
                                <div class="grid grid-cols-3 gap-1 text-center text-[10px]">
                                    <div class="p-1.5 rounded-lg bg-white border border-slate-200">
                                        <span class="block text-slate-400">১-৪ জন</span>
                                        <span class="font-bold text-slate-700">৳{{ number_format($product->single_price) }}</span>
                                    </div>
                                    <div class="p-1.5 rounded-lg bg-emerald-50 border border-emerald-200">
                                        <span class="block text-emerald-600 font-bold">৫-১৯ জন</span>
                                        <span class="font-bold text-emerald-700">৳{{ number_format($product->single_price * 0.9) }}</span>
                                    </div>
                                    <div class="p-1.5 rounded-lg bg-emerald-600 text-white font-bold shadow-xs">
                                        <span class="block text-emerald-100">২০+ জন</span>
                                        <span class="font-black">৳{{ number_format($product->group_price) }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Bottom Actions (View Deal / Buy Solo) -->
                    <div class="p-5 pt-0">
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Buy Solo -->
                            <a href="{{ route('checkout', ['product_id' => $product->id, 'type' => 'single', 'action' => 'buy_single']) }}" 
                               class="text-center py-2.5 px-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors"
                               title="একা কিনতে চাইলে">
                                Buy Solo (৳{{ number_format($product->single_price) }})
                            </a>

                            <!-- View Deal / Pricing Tiers -->
                            <a href="{{ route('products.show', $product) }}" 
                               class="text-center py-2.5 px-2 rounded-xl text-xs font-black bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-600/20 transition-all">
                                View Deal 👥
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-500">
                    <p class="text-base font-semibold">কোনো প্রোডাক্ট পাওয়া যায়নি।</p>
                    <a href="{{ route('home') }}" class="mt-3 inline-block text-xs font-bold text-emerald-600 hover:underline">
                        ফিল্টার রিসেট করুন
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    </section>


    <!-- ==========================================
         ৭. TRUST, SECURITY & GUARANTEE BADGES
         ========================================== -->
    <section id="trust-badges" class="py-16 bg-slate-100/70 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-xs font-black uppercase tracking-wider text-emerald-600">নিরাপত্তা ও শতভাগ স্বচ্ছতা</span>
                <h2 class="text-2xl font-black text-slate-900 mt-1">কেন কার্তিভাতে আপনি ১০০% নিশ্চিন্ত?</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- পয়েন্ট ১: ১০০% রিফান্ড গ্যারান্টি -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900">১০০% রিফান্ড গ্যারান্টি</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            গ্রুপের মেয়াদ শেষ হওয়ার আগে টার্গেট পূরণ না হলে কোনো কর্তন ছাড়াই সম্পূর্ণ টাকা স্বয়ংক্রিয় ফেরত।
                        </p>
                    </div>
                </div>

                <!-- পয়েন্ট ২: নিরাপদ প্রিপেমেন্ট (এসক্রো) -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900">নিরাপদ এসক্রো প্রিপেমেন্ট</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            আপনার অর্থ কার্তিভা এসক্রো অ্যাকাউন্টে সুরক্ষিত থাকে। ডেলিভারি নিশ্চিত হওয়ার পরই মার্চেন্ট ফান্ড পায়।
                        </p>
                    </div>
                </div>

                <!-- পয়েন্ট ৩: অরিজিনাল প্রোডাক্ট -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900">১০০% আসল প্রোডাক্ট</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            শুধুমাত্র ভেরিফাইড মার্চেন্টদের প্রোডাক্ট। কোনো ত্রুটি থাকলে ৪৮ ঘণ্টার ভেতর সরাসরি রিপ্লেসমেন্ট সুবিধা।
                        </p>
                    </div>
                </div>

                <!-- পয়েন্ট ৪: অ্যাক্টিভ ট্র্যাকিং -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900">লাইভ কুরিয়ার ট্র্যাকিং</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Steadfast, Pathao ও RedX পার্টনারদের মাধ্যমে অর্ডার কনফার্মের সাথে সাথেই সরাসরি ট্র্যাকিং কোড।
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Alpine Countdown Helper Script -->
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
