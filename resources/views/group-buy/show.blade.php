@extends('layouts.app')

@section('title', 'Group Buy #' . $session->group_code . ' — Cartiva')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 space-y-4"
     x-data="groupRoom({{ (int) $secondsRemaining }}, '{{ url('/group-buy/' . $session->group_code) }}')">

    <!-- Top Navigation Bar -->
    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('products.show', $session->product->slug) }}" 
           class="inline-flex items-center space-x-2 text-xs font-bold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3.5 py-2 rounded-xl shadow-2xs hover:shadow-xs transition-all group">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Product Details</span>
        </a>

        <div class="flex items-center space-x-2">
            <span class="font-mono text-xs font-bold text-slate-600 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-2xs">
                Group: {{ $session->group_code }}
            </span>
            @if($isCompleted)
                <span class="text-xs font-bold px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Deal Unlocked ✓
                </span>
            @elseif($isExpired)
                <span class="text-xs font-bold px-2.5 py-1 rounded-xl bg-rose-50 text-rose-800 border border-rose-200">
                    Expired
                </span>
            @else
                <span class="text-xs font-bold px-2.5 py-1 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 flex items-center space-x-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Active Group</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Main Team Room Card (Classic E-Commerce Design) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        
        <!-- Classic Header -->
        <div class="bg-white px-5 sm:px-7 py-4.5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center space-x-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#53a318]">
                        Wholesale Group Deal
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="text-xs text-slate-500 font-medium">Target: {{ $session->required_members }} Members</span>
                </div>
                <h1 class="text-lg sm:text-xl font-bold text-slate-900 leading-snug">
                    @if($isCompleted)
                        <span>Wholesale Deal Successfully Unlocked!</span>
                    @elseif($isExpired)
                        <span>Group Deal Session Expired</span>
                    @else
                        <span>Buy Together at ৳{{ number_format($session->product->group_price) }}</span>
                    @endif
                </h1>
                <p class="text-xs text-slate-500">
                    @if($isCompleted)
                        All {{ $session->required_members }} member slots have been filled. Orders are locked in and processing.
                    @elseif($isExpired)
                        This session timed out before reaching quorum. 100% automatic refund issued.
                    @else
                        Only <strong class="text-slate-900 font-bold">{{ $session->remainingSlots() }} more buyer{{ $session->remainingSlots() > 1 ? 's' : '' }}</strong> needed to secure this wholesale discount.
                    @endif
                </p>
            </div>

            <!-- Classic Countdown Timer -->
            @if(!$isCompleted && !$isExpired)
                <div class="inline-flex items-center space-x-2.5 bg-slate-50 border border-slate-200 px-3.5 py-2 rounded-xl shrink-0 self-start sm:self-center shadow-2xs">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs font-semibold text-slate-600">Ends in:</span>
                    <div class="flex items-center space-x-1 font-mono font-bold text-xs sm:text-sm text-slate-900">
                        <span class="bg-white px-2 py-0.5 rounded border border-slate-200" x-text="hours">00</span>
                        <span class="text-slate-400">:</span>
                        <span class="bg-white px-2 py-0.5 rounded border border-slate-200" x-text="minutes">00</span>
                        <span class="text-slate-400">:</span>
                        <span class="bg-white px-2 py-0.5 rounded border border-slate-200" x-text="seconds">00</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- 2-Column Classic Body -->
        <div class="p-5 sm:p-7 grid grid-cols-1 md:grid-cols-12 gap-6 items-start">

            <!-- Left Column: Product Snapshot (5 Cols) -->
            <div class="md:col-span-5 space-y-4">
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200 space-y-3">
                    <div class="relative aspect-square rounded-xl overflow-hidden bg-white border border-slate-200 shadow-2xs flex items-center justify-center p-2">
                        <img src="{{ $session->product->image_url }}" alt="{{ $session->product->title }}" class="w-full h-full object-contain">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-600 text-white shadow-2xs">
                            Save ৳{{ number_format($session->product->savings) }}
                        </span>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Product</span>
                        <h2 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug line-clamp-2">
                            {{ $session->product->title }}
                        </h2>
                    </div>

                    <!-- Pricing Box -->
                    <div class="pt-2.5 border-t border-slate-200 flex items-baseline justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Group Price</span>
                            <span class="text-xl font-bold text-[#53a318]">৳{{ number_format($session->product->group_price) }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Regular Solo</span>
                            <span class="text-xs text-slate-400 line-through">৳{{ number_format($session->product->single_price) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('products.show', $session->product->slug) }}" 
                       class="inline-flex items-center justify-center w-full text-center text-xs font-bold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] py-2 rounded-xl transition-colors shadow-2xs">
                        <span>View Product Specifications</span>
                        <svg class="w-3.5 h-3.5 ml-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Right Column: Progress, Compact Members & Actions (7 Cols) -->
            <div class="md:col-span-7 space-y-4">

                <!-- Progress & Member Section -->
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200 space-y-3.5">
                    
                    <!-- Progress Bar Header -->
                    <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                        <span>Group Formation Progress</span>
                        <span class="text-[#53a318]">
                            {{ $session->current_members }} of {{ $session->required_members }} Joined
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-[#53a318] h-2 rounded-full transition-all duration-500"
                             style="width: {{ min(100, ($session->current_members / $session->required_members) * 100) }}%"></div>
                    </div>

                    @php
                        $roomMembers = $session->members->where('user_id', '!=', $session->product->seller_id ?? 0);
                    @endphp

                    <!-- Compact Members Row with "View All Members" Button (Space Saver!) -->
                    <div class="p-3 rounded-xl bg-white border border-slate-200 flex items-center justify-between gap-3 shadow-2xs">
                        
                        <!-- Left: Avatar Stack & Summary -->
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <div class="flex -space-x-2 overflow-hidden shrink-0">
                                @forelse($roomMembers->take(4) as $member)
                                    <div class="w-8 h-8 rounded-full ring-2 ring-white overflow-hidden bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center shrink-0 border border-slate-200"
                                         title="{{ $member->user->name ?? 'Buyer' }}">
                                        @if($member->user && $member->user->avatar)
                                            <img src="{{ $member->user->avatar }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($member->user->name ?? 'B', 0, 1)) }}
                                        @endif
                                    </div>
                                @empty
                                    <div class="w-8 h-8 rounded-full ring-2 ring-white bg-slate-100 text-slate-400 flex items-center justify-center text-xs">
                                        -
                                    </div>
                                @endforelse

                                @if($roomMembers->count() > 4)
                                    <div class="w-8 h-8 rounded-full ring-2 ring-white bg-slate-800 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                        +{{ $roomMembers->count() - 4 }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <span class="text-xs font-bold text-slate-900 block truncate">
                                    {{ $roomMembers->count() }} {{ $roomMembers->count() === 1 ? 'member' : 'members' }} in group
                                </span>
                                <span class="text-[11px] text-slate-500 block">
                                    @if($session->remainingSlots() > 0)
                                        {{ $session->remainingSlots() }} slot{{ $session->remainingSlots() > 1 ? 's' : '' }} remaining
                                    @else
                                        All slots filled
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Right: Classic "View All Members" Button to open Modal -->
                        <button type="button" 
                                @click="openMembersModal = true"
                                class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition-colors cursor-pointer shrink-0">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>View All Members</span>
                        </button>

                    </div>

                    <!-- Tier Roadmap (Classic Clean Milestone Styling) -->
                    @php
                        $sessionTiers = $session->all_tiers;
                        $achievedTier = $session->current_achieved_tier;
                        $nextTier = $session->next_tier;
                    @endphp

                    @if(!empty($sessionTiers) && count($sessionTiers) > 1)
                        <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-2.5">
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-1.5 font-bold text-slate-900">
                                    <svg class="w-4 h-4 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span>টিয়ারড ডিসকাউন্ট রোডম্যাপ (Tier Milestones)</span>
                                </div>
                                @if($achievedTier)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $achievedTier['discount_percent'] }}% ছাড় আনলকড ✓
                                    </span>
                                @else
                                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200">
                                        ন্যূনতম {{ $session->effective_min_quota }} জন প্রয়োজন
                                    </span>
                                @endif
                            </div>

                            <!-- Milestone Steps -->
                            <div class="grid grid-cols-2 sm:grid-cols-{{ min(4, count($sessionTiers)) }} gap-2">
                                @foreach($sessionTiers as $t)
                                    @php
                                        $isTierUnlocked = $session->current_members >= $t['min_members'];
                                        $isCurrentActive = $achievedTier && $achievedTier['min_members'] === $t['min_members'];
                                    @endphp
                                    <div class="p-2 rounded-lg text-center space-y-0.5 transition-all {{ $isCurrentActive ? 'bg-emerald-50/60 border-2 border-[#53a318]' : ($isTierUnlocked ? 'bg-white border border-emerald-300' : 'bg-slate-50 border border-slate-200 opacity-75') }}">
                                        <div class="flex items-center justify-center space-x-1">
                                            <span class="text-xs font-bold {{ $isTierUnlocked ? 'text-slate-900' : 'text-slate-500' }}">
                                                {{ $t['min_members'] }}+ জন
                                            </span>
                                            @if($isTierUnlocked)
                                                <span class="text-[#53a318] font-bold text-[10px]">✓</span>
                                            @endif
                                        </div>
                                        <div class="text-xs font-bold {{ $isTierUnlocked ? 'text-[#53a318]' : 'text-slate-600' }}">
                                            -{{ $t['discount_percent'] }}% ছাড়
                                        </div>
                                        <div class="text-[11px] font-extrabold text-slate-800">
                                            ৳{{ number_format($t['price']) }}
                                        </div>
                                        <div class="text-[9px] font-semibold pt-0.5">
                                            @if($isCurrentActive)
                                                <span class="text-[#53a318] bg-emerald-100/70 px-1 py-0.2 rounded text-[8px] uppercase">Active</span>
                                            @elseif($isTierUnlocked)
                                                <span class="text-emerald-700">Unlocked</span>
                                            @else
                                                <span class="text-slate-400">Locked</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Status Notice -->
                            <div class="p-2.5 rounded-lg {{ $session->hasReachedSoftThreshold() ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-amber-50 border border-amber-200 text-amber-900' }} text-xs flex items-start space-x-2">
                                <div class="mt-0.5 shrink-0">
                                    @if($session->hasReachedSoftThreshold())
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    @else
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                </div>
                                <div class="space-y-0.5 text-[11px] leading-relaxed">
                                    @if($session->hasReachedSoftThreshold())
                                        <span class="font-bold block text-emerald-950">
                                            গ্রুপ নিশ্চিত সফল! এই অর্ডার বাতিল বা রিফান্ড হবে না।
                                        </span>
                                        <p class="text-emerald-800">
                                            ইতোমধ্যে <strong>{{ $session->current_members }} জন</strong> যুক্ত হওয়ায় <strong>{{ $achievedTier['discount_percent'] ?? 0 }}% ডিসকাউন্ট</strong> নিশ্চিত হয়েছে।
                                            @if($nextTier)
                                                আর মাত্র <strong class="underline">{{ $nextTier['members_needed'] }} জন</strong> যোগ দিলেই পরবর্তী ধাপে <strong>{{ $nextTier['discount_percent'] }}% ডিসকাউন্ট</strong> আনলক হবে!
                                            @else
                                                সর্বোচ্চ ডিসকাউন্ট সম্পূর্ণ আনলক হয়েছে!
                                            @endif
                                        </p>
                                    @else
                                        <span class="font-bold block text-amber-950">
                                            নিরাপদ শিপিং কোটা: ন্যূনতম {{ $session->effective_min_quota }} জন সদস্য প্রয়োজন!
                                        </span>
                                        <p class="text-amber-800">
                                            আর মাত্র <strong>{{ max(1, $session->effective_min_quota - $session->current_members) }} জন</strong> যুক্ত হলেই গ্রুপটির ডেলিভারি নিশ্চিত হবে এবং বাতিল হওয়ার কোনো ঝুঁকি থাকবে না!
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif($session->effective_min_quota < $session->required_members)
                        <div class="p-2.5 rounded-lg {{ $session->hasReachedSoftThreshold() ? 'bg-emerald-50 border border-emerald-200 text-emerald-800' : 'bg-amber-50 border border-amber-200 text-amber-900' }} text-xs flex items-center justify-between">
                            <span class="font-medium text-[11px]">
                                @if($session->hasReachedSoftThreshold())
                                    নরম লক্ষ্যমাত্রা ({{ $session->effective_min_quota }} জন) অর্জিত! সময় শেষ হলেও এই অর্ডার নিশ্চিত শিপ হবে।
                                @else
                                    নিরাপদ শিপিং কোটা: ন্যূনতম {{ $session->effective_min_quota }} জন হলেই ডেলিভারি নিশ্চিত (বাতিল হবে না)।
                                @endif
                            </span>
                            <span class="font-bold text-[10px] uppercase px-2 py-0.5 rounded {{ $session->hasReachedSoftThreshold() ? 'bg-emerald-200/70 text-emerald-900' : 'bg-amber-200/70 text-amber-900' }}">
                                {{ $session->hasReachedSoftThreshold() ? 'Guaranteed ✓' : 'Soft Quota' }}
                            </span>
                        </div>
                    @endif

                </div>

                <!-- Primary CTA / Actions -->
                @if(!$isCompleted && !$isExpired)
                    <div class="space-y-3">
                        @if($userAlreadyJoined)
                            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-center space-y-1">
                                <span class="text-xs font-bold text-emerald-800 block">
                                    আপনি এই গ্রুপে যুক্ত আছেন (পেমেন্ট সম্পন্ন)
                                </span>
                                <p class="text-[11px] text-emerald-700">
                                    বাকি স্লট পূরণ করতে নিচের লিংকটি বন্ধুদের সাথে শেয়ার করুন।
                                </p>
                            </div>

                            @if($session->remainingSlots() > 0)
                                <form action="{{ route('group-buy.join', $session) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full py-2.5 px-4 rounded-xl font-bold text-xs bg-slate-900 hover:bg-slate-800 text-white transition-all flex items-center justify-center space-x-1.5 cursor-pointer shadow-xs">
                                        <span>আরও ১টি স্লট নিজে কিনুন (৳{{ number_format($session->product->group_price) }})</span>
                                    </button>
                                </form>
                            @endif

                            @if($canLeaderDismiss)
                                <div class="pt-1">
                                    <form action="{{ route('group-buy.dismiss', $session) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে আপনি এই গ্রুপটি বাতিল করতে চান? আপনার অর্ডারটি বাতিল হবে এবং সংরক্ষিত স্টক ফেরত যাবে।')">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full py-2 px-4 rounded-xl font-bold text-xs bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 transition-all flex items-center justify-center space-x-1.5 cursor-pointer">
                                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            <span>গ্রুপ বাতিল করুন (Dismiss Group)</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <form action="{{ route('group-buy.join', $session) }}" method="POST" class="space-y-2.5">
                                @csrf
                                @if($session->remainingSlots() > 1)
                                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 px-3 py-2 bg-slate-50 rounded-xl border border-slate-200">
                                        <span>পরিমাণ (সর্বোচ্চ {{ $session->remainingSlots() }}টি):</span>
                                        <select name="quantity" class="bg-white border border-slate-300 rounded-lg px-2.5 py-1 text-xs font-bold focus:ring-1 focus:ring-[#53a318]">
                                            @for($q = 1; $q <= min(5, $session->remainingSlots()); $q++)
                                                <option value="{{ $q }}">{{ $q }}টি (৳{{ number_format($session->product->group_price * $q) }})</option>
                                            @endfor
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="quantity" value="1">
                                @endif
                                <button type="submit" 
                                        class="w-full py-3 px-5 rounded-xl font-bold text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-xs hover:shadow transition-all flex items-center justify-center space-x-2 active:scale-[0.99] cursor-pointer">
                                    <span>গ্রুপে যোগ দিন ও অর্ডার করুন</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </form>
                        @endif

                        <!-- Classic Share Section -->
                        <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200 space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                    <span class="font-bold text-slate-800">ইনভাইট ও টিম শেয়ার করুন:</span>
                                </div>
                                <span class="text-[10px] font-bold text-[#53a318] bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                    ১০০% সেফ রিফান্ড
                                </span>
                            </div>

                            <!-- Official Social Share Circles -->
                            <div class="flex items-center justify-around gap-2 pt-1" style="display: flex !important; flex-direction: row !important; justify-content: space-around !important; align-items: flex-start !important; width: 100% !important;">
                                <!-- WhatsApp -->
                                <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('আমার সাথে কার্টিভায় গ্রুপ পুলে যোগ দিয়ে পাইকারি রেট আনলক করুন!\nপণ্য: {{ addslashes($session->product->title) }}\nরুম কোড: {{ $session->group_code }}\nলিংক: ' + shareUrl)"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;">
                                    <div style="width: 44px !important; height: 44px !important; min-width: 44px !important; min-height: 44px !important; border-radius: 50% !important; background-color: #25D366 !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 2px 8px rgba(37, 211, 102, 0.35) !important;">
                                        <svg style="width: 22px !important; height: 22px !important; fill: #ffffff !important;" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0012.053 3c-4.968 0-9.01 4.042-9.01 9.013 0 1.587.413 3.134 1.198 4.492L3 21l4.637-1.217a8.983 8.983 0 004.416 1.154h.004c4.968 0 9.01-4.042 9.01-9.013 0-2.408-.937-4.673-2.664-6.286zm-6.35 13.733h-.003a7.48 7.48 0 01-3.811-1.042l-.273-.162-2.832.743.756-2.761-.178-.283a7.48 7.48 0 01-1.147-3.992c0-4.14 3.369-7.509 7.513-7.509 2.006 0 3.892.782 5.309 2.2a7.452 7.452 0 012.198 5.308c0 4.14-3.369 7.509-7.532 7.509zm4.126-5.635c-.226-.113-1.339-.661-1.547-.737-.207-.075-.358-.113-.509.113-.15.226-.583.737-.715.888-.132.151-.264.17-.49.057-.226-.114-.954-.352-1.817-1.121-.671-.598-1.125-1.337-1.257-1.564-.132-.226-.014-.349.099-.461.102-.102.226-.264.339-.396.113-.132.151-.226.226-.377.075-.151.038-.283-.019-.396-.057-.113-.509-1.226-.698-1.678-.184-.442-.372-.382-.509-.389-.132-.007-.283-.008-.433-.008-.151 0-.396.057-.603.283-.207.226-.792.774-.792 1.887 0 1.113.811 2.188.924 2.339.113.151 1.597 2.438 3.87 3.418.541.233.963.372 1.293.477.544.173 1.039.148 1.431.09.437-.065 1.339-.547 1.528-1.075.188-.528.188-.981.132-1.075-.057-.094-.208-.151-.434-.264z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 600 !important; color: #334155 !important; margin-top: 4px !important; display: block !important;">WhatsApp</span>
                                </a>

                                <!-- Messenger -->
                                <a :href="'fb-messenger://share/?link=' + encodeURIComponent(shareUrl)"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;">
                                    <div style="width: 44px !important; height: 44px !important; min-width: 44px !important; min-height: 44px !important; border-radius: 50% !important; background: linear-gradient(135deg, #00B2FE 0%, #006AFF 50%, #9900FF 100%) !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 2px 8px rgba(0, 106, 255, 0.35) !important;">
                                        <svg style="width: 22px !important; height: 22px !important; fill: #ffffff !important;" viewBox="0 0 24 24">
                                            <path d="M12 2C6.477 2 2 6.145 2 11.258c0 2.914 1.455 5.518 3.735 7.205V22l3.413-1.874c.905.251 1.864.387 2.852.387 5.523 0 10-4.145 10-9.255C22 6.145 17.523 2 12 2zm1.066 12.443l-2.73-2.912-5.328 2.912 5.86-6.223 2.798 2.912 5.26-2.912-5.86 6.223z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 600 !important; color: #334155 !important; margin-top: 4px !important; display: block !important;">Messenger</span>
                                </a>

                                <!-- Facebook -->
                                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shareUrl)"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;">
                                    <div style="width: 44px !important; height: 44px !important; min-width: 44px !important; min-height: 44px !important; border-radius: 50% !important; background-color: #1877F2 !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 2px 8px rgba(24, 119, 242, 0.35) !important;">
                                        <svg style="width: 22px !important; height: 22px !important; fill: #ffffff !important;" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 600 !important; color: #334155 !important; margin-top: 4px !important; display: block !important;">Facebook</span>
                                </a>

                                <!-- Telegram -->
                                <a :href="'https://t.me/share/url?url=' + encodeURIComponent(shareUrl) + '&text=' + encodeURIComponent('আমার সাথে কার্টিভায় গ্রুপ পুলে যোগ দিয়ে পাইকারি রেট আনলক করুন! রুম কোড: {{ $session->group_code }}')"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;">
                                    <div style="width: 44px !important; height: 44px !important; min-width: 44px !important; min-height: 44px !important; border-radius: 50% !important; background-color: #24A1DE !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 2px 8px rgba(36, 161, 222, 0.35) !important;">
                                        <svg style="width: 22px !important; height: 22px !important; fill: #ffffff !important;" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.19-.08-.05-.19-.02-.27 0-.12.03-1.99 1.27-5.63 3.72-.53.36-1.02.54-1.45.53-.48-.01-1.4-.27-2.09-.49-.84-.27-1.51-.42-1.45-.89.03-.25.38-.51 1.07-.78 4.19-1.82 6.99-3.03 8.39-3.62 3.99-1.68 4.82-1.97 5.37-1.98.12 0 .39.03.56.17.14.12.18.28.2.4.01.09.02.26.01.4z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 600 !important; color: #334155 !important; margin-top: 4px !important; display: block !important;">Telegram</span>
                                </a>
                            </div>

                            <!-- Direct Link Copy Input -->
                            <div class="flex items-center p-1 rounded-xl bg-white border border-slate-200 focus-within:border-[#53a318] focus-within:ring-1 focus-within:ring-[#53a318] transition-all">
                                <div class="pl-2.5 pr-1.5 text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                                <input type="text" readonly :value="shareUrl" class="w-full text-xs font-mono text-slate-700 bg-transparent py-1.5 pr-2 focus:outline-none select-all truncate">
                                <button type="button" @click="copyLink()"
                                        class="px-3.5 py-1.5 bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs rounded-lg transition-all shrink-0 flex items-center space-x-1 cursor-pointer active:scale-95 shadow-2xs">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <span x-text="copied ? 'কপি হয়েছে' : 'কপি'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Classic Trust Guarantees -->
                <div class="grid grid-cols-3 gap-2 pt-1 text-[11px] text-slate-500 font-medium">
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>100% Refundable</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Genuine Product</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Direct Dispatch</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ========================================================
         POP-UP MODAL: VIEW ALL MEMBERS (Classic Clean UI)
         ======================================================== -->
    <div x-show="openMembersModal" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto"
         @keydown.escape.window="openMembersModal = false"
         role="dialog" 
         aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="openMembersModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="openMembersModal = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

        <!-- Center Container -->
        <div class="min-h-full flex items-center justify-center p-4">
            <div x-show="openMembersModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="openMembersModal = false"
                 class="relative bg-white rounded-2xl shadow-xl border border-slate-200 max-w-md w-full overflow-hidden transform transition-all">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 bg-slate-50/70">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">
                            গ্রুপ মেম্বার তালিকা (Group Members)
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            মোট {{ $session->required_members }} জনের মধ্যে {{ $roomMembers->count() }} জন যুক্ত হয়েছেন
                        </p>
                    </div>
                    <button type="button" 
                            @click="openMembersModal = false"
                            class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body: Joined Members List -->
                <div class="p-5 space-y-4 max-h-[60vh] overflow-y-auto" style="scrollbar-width: thin;">
                    
                    <div class="space-y-2">
                        @forelse($roomMembers as $member)
                            <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                                <div class="flex items-center space-x-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 text-slate-700 font-bold text-sm flex items-center justify-center shrink-0 border border-slate-200">
                                        @if($member->user && $member->user->avatar)
                                            <img src="{{ $member->user->avatar }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($member->user->name ?? 'B', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center space-x-1.5">
                                            <span class="text-xs font-bold text-slate-900 truncate">
                                                {{ $member->user->name ?? 'Buyer' }}
                                            </span>
                                            @if($member->user_id === $session->product->seller_id)
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                    Host
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">
                                            @if($member->joined_at)
                                                Joined {{ $member->joined_at->diffForHumans() }}
                                            @else
                                                Joined recently
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <span class="text-[10px] font-bold text-[#53a318] bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200 shrink-0">
                                    Joined ✓
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 text-center py-4">এখনও কোনো মেম্বার যুক্ত হননি।</p>
                        @endforelse
                    </div>

                    <!-- Remaining Open Slots Note -->
                    @if($session->remainingSlots() > 0)
                        <div class="p-3 rounded-xl bg-amber-50/70 border border-amber-200 flex items-center justify-between text-xs">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-7 h-7 rounded-full bg-amber-200 text-amber-900 flex items-center justify-center font-bold text-xs shrink-0">
                                    +{{ $session->remainingSlots() }}
                                </div>
                                <div>
                                    <span class="font-bold text-amber-950 block">
                                        {{ $session->remainingSlots() }}টি স্লট এখনও খালি আছে
                                    </span>
                                    <span class="text-[11px] text-amber-800">
                                        গ্রুপ পূরণ করতে বন্ধুদের সাথে লিংকটি শেয়ার করুন!
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-center text-xs font-bold text-emerald-800">
                            🎉 সকল {{ $session->required_members }}টি স্লট পূরণ হয়ে গেছে!
                        </div>
                    @endif

                </div>

                <!-- Modal Footer -->
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                    <button type="button" 
                            @click="openMembersModal = false"
                            class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-slate-900 bg-white border border-slate-200 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer shadow-2xs">
                        বন্ধ করুন (Close)
                    </button>

                    @if(!$isCompleted && !$isExpired && !$userAlreadyJoined)
                        <button type="button"
                                @click="openMembersModal = false; document.querySelector('form[action*=\'group-buy.join\']')?.scrollIntoView({ behavior: 'smooth' })"
                                class="px-4 py-2 text-xs font-bold text-white bg-[#53a318] hover:bg-[#468c13] rounded-xl shadow-xs transition-colors cursor-pointer">
                            গ্রুপে যোগ দিন &rarr;
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Alpine Group Room Script -->
<script>
    function groupRoom(initialSec, url) {
        return {
            secondsLeft: Math.max(0, Math.floor(Number(initialSec) || 0)),
            hours: '00',
            minutes: '00',
            seconds: '00',
            shareUrl: url,
            copied: false,
            openMembersModal: false,
            timer: null,

            init() {
                this.updateClock();
                if (this.secondsLeft > 0) {
                    this.timer = setInterval(() => {
                        if (this.secondsLeft > 0) {
                            this.secondsLeft--;
                            this.updateClock();
                        } else {
                            clearInterval(this.timer);
                            window.location.reload();
                        }
                    }, 1000);
                }
            },

            updateClock() {
                const totalSec = Math.max(0, Math.floor(Number(this.secondsLeft) || 0));
                if (totalSec <= 0) {
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    return;
                }
                const h = Math.floor(totalSec / 3600);
                const m = Math.floor((totalSec % 3600) / 60);
                const s = Math.floor(totalSec % 60);
                this.hours = h.toString().padStart(2, '0');
                this.minutes = m.toString().padStart(2, '0');
                this.seconds = s.toString().padStart(2, '0');
            },

            copyLink() {
                navigator.clipboard.writeText(this.shareUrl).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2500);
                });
            }
        };
    }
</script>
@endsection
