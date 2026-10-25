@extends('layouts.app')

@section('title', $product->title . ' — Cartiva')

@section('content')
@php
    $cleanCat = trim(str_replace(['Smart', 'Tech', '🔥', '⚡', '🎧', '⚡ '], '', $product->category->name ?? 'General'));
    if (empty($cleanCat)) $cleanCat = $product->category->name ?? 'Electronics';
    $savePerUnit = max(0, $product->single_price - $product->group_price);
    $galleryList = is_array($product->gallery) && count($product->gallery) > 0 
        ? array_merge([$product->image_url], $product->gallery)
        : [$product->image_url];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8"
     x-data="{
        qty: 1,
        maxQty: {{ max(1, $product->stock) }},
        activeTab: window.location.hash === '#customer-reviews' ? 'reviews' : 'specs',
        activeImg: '{{ $product->image_url }}',
        groupUnitPrice: {{ (float) $product->group_price }},
        baseSinglePrice: {{ (float) $product->single_price }},
        groupSizeRequired: {{ (int) $product->group_size_required }},
        savePerUnit: {{ (float) $savePerUnit }},
        get currentSingleUnitPrice() {
            if (this.qty >= 3) {
                return this.groupUnitPrice;
            } else if (this.qty === 2) {
                const diff = this.baseSinglePrice - this.groupUnitPrice;
                return Math.round((this.baseSinglePrice - (diff * 0.8)) / 10) * 10;
            }
            return this.baseSinglePrice;
        },
        get soloSavingsPerUnit() {
            return Math.max(0, this.baseSinglePrice - this.currentSingleUnitPrice);
        },
        get isSelfGroup() {
            return this.qty >= this.groupSizeRequired;
        },
        inc() { if (this.qty < this.maxQty) this.qty++; },
        dec() { if (this.qty > 1) this.qty--; }
     }">

    <!-- ========================================================
         1. TOP NAVIGATION / BREADCRUMB
         ======================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200/80 pb-4">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center space-x-2 text-xs font-bold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3.5 py-2 rounded-xl shadow-2xs hover:shadow-xs transition-all group shrink-0 self-start">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Store</span>
        </a>

        <nav class="flex items-center space-x-1.5 text-xs text-slate-500 overflow-x-auto no-scrollbar">
            <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Home</a>
            <span>/</span>
            @if($product->category)
                <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-slate-900 transition-colors">{{ $product->category->name }}</a>
                <span>/</span>
            @endif
            <span class="text-slate-900 font-semibold truncate max-w-[260px] sm:max-w-md">{{ $product->title }}</span>
        </nav>
    </div>


    <!-- ========================================================
         2. MAIN PRODUCT HERO CARD (ABOVE THE FOLD)
         ======================================================== -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-5 sm:p-7 grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">
        
        <!-- Left: Compact Photo Showcase + Thumbnails (5 Cols) -->
        <div class="lg:col-span-5 space-y-3.5">
            
            <!-- Compact Main Image Box -->
            <div class="relative w-full h-[320px] sm:h-[350px] rounded-2xl overflow-hidden bg-slate-50 border border-slate-200/90 flex items-center justify-center p-4">
                <img :src="activeImg" alt="{{ $product->title }}" 
                     class="w-full h-full object-contain transition-all duration-300">
                
                <!-- Discount Pill -->
                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-xs font-black bg-rose-600 text-white shadow-2xs tracking-tight">
                    -{{ $product->discount_percent }}% OFF
                </span>

                <!-- Team Pool Badge -->
                <span class="absolute bottom-3 left-3 px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-slate-900/85 text-white backdrop-blur-xs shadow-2xs">
                    {{ $product->group_size_required }} Buyers Team Tier
                </span>
            </div>

            <!-- Thumbnail Gallery -->
            <div class="flex items-center space-x-2.5 overflow-x-auto pb-1">
                @foreach($galleryList as $idx => $img)
                    <button type="button" @click="activeImg = '{{ $img }}'"
                            :class="activeImg === '{{ $img }}' ? 'border-[#53a318] ring-2 ring-[#53a318]/20' : 'border-slate-200 hover:border-slate-300'"
                            class="w-14 h-14 rounded-xl overflow-hidden bg-slate-50 border p-1 transition-all shrink-0 cursor-pointer">
                        <img src="{{ $img }}" alt="Preview {{ $idx + 1 }}" class="w-full h-full object-contain">
                    </button>
                @endforeach
            </div>

            <!-- Micro Trust Bar -->
            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600 font-medium">
                <div class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-emerald-600 font-bold text-sm">✓</span>
                    <span>100% Genuine Brand</span>
                </div>
                <div class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-emerald-600 font-bold text-sm">✓</span>
                    <span>Direct Dispatch Warranty</span>
                </div>
            </div>

        </div>


        <!-- Right: Details, Quantity & Dual Purchase Box (7 Cols) -->
        <div class="lg:col-span-7 space-y-3.5">
            
            <!-- Category, Title & Metrics -->
            <div class="space-y-1.5">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#53a318] bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200/80 inline-block">
                    {{ $cleanCat }}
                </span>

                <h1 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug tracking-tight">
                    {{ $product->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-3 pt-0.5 text-xs">
                    <button type="button" @click="activeTab = 'reviews'; document.getElementById('customer-reviews')?.scrollIntoView({ behavior: 'smooth' })" 
                            class="flex items-center text-amber-500 font-bold bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/60 hover:bg-amber-100 transition-colors cursor-pointer">
                        <span>★</span>
                        <span class="ml-1 text-slate-900">{{ number_format($product->rating, 1) }}</span>
                        <span class="ml-1 text-[11px] text-slate-500 font-medium">({{ $product->reviews->count() }} {{ Str::plural('review', $product->reviews->count()) }})</span>
                    </button>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-600 font-semibold">{{ $product->sales_count }}+ orders fulfilled</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-emerald-700 font-bold flex items-center space-x-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>In Stock ({{ $product->stock }} units ready)</span>
                    </span>
                </div>
            </div>

            <!-- Short Highlight Description (Clean & compact) -->
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                {{ $product->description }}
            </p>

            <!-- Quantity Selector (Sleek & Space-Efficient) -->
            <div class="flex items-center justify-between py-2 px-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-slate-900">Quantity</span>
                    <span class="text-[11px] text-slate-400">({{ $product->stock }} available)</span>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="button" @click="dec()" 
                            class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-black text-xs flex items-center justify-center transition-colors shadow-2xs cursor-pointer active:scale-95">
                        -
                    </button>
                    <input type="number" min="1" :max="maxQty" x-model.number="qty" 
                           class="w-12 h-8 text-center font-black text-xs text-slate-900 bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#53a318]">
                    <button type="button" @click="inc()" 
                            class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-black text-xs flex items-center justify-center transition-colors shadow-2xs cursor-pointer active:scale-95">
                        +
                    </button>
                    <span class="text-[11px] text-slate-500 pl-0.5">unit<span x-show="qty > 1">s</span></span>
                </div>
            </div>

            <!-- Merchant Attribution Card -->
            @if($product->seller)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-200/90 text-xs">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-xs shadow-2xs overflow-hidden flex-shrink-0">
                            @if($product->seller->avatar)
                                <img src="{{ $product->seller->avatar }}" alt="{{ $product->seller->shop_name ?? $product->seller->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($product->seller->shop_name ?? $product->seller->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-slate-400 text-[10px] uppercase font-bold">Sold by:</span>
                                <a href="{{ route('shop.show', $product->seller) }}" class="font-extrabold text-slate-900 hover:text-teal-600 transition-colors">
                                    {{ $product->seller->shop_name ?? $product->seller->name }}
                                </a>
                                <span class="text-[9px] bg-teal-100 text-teal-800 font-extrabold px-1.5 py-0.2 rounded-full">✓ Verified</span>
                            </div>
                            <span class="text-[10px] text-slate-500">{{ $product->seller->business_category ?? 'General Merchant' }} • ★ 4.9 Rating</span>
                        </div>
                    </div>

                    <a href="{{ route('shop.show', $product->seller) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-teal-500 text-slate-800 hover:text-teal-700 text-xs font-bold transition-all shadow-2xs flex items-center space-x-1">
                        <span>Visit Store</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            @endif

            <!-- Dual Purchase Box or Merchant Self-View Mode -->
            @if(auth()->check() && auth()->id() === $product->seller_id)
                <!-- Seller Own-Product Notice & Quick Control -->
                <div class="p-5 rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-teal-950 text-white shadow-md border border-teal-500/30">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center space-x-3.5">
                            <div class="w-11 h-11 rounded-2xl bg-teal-500/20 text-teal-400 border border-teal-500/30 flex items-center justify-center font-bold text-xl flex-shrink-0">
                                🏪
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-black uppercase text-teal-400 tracking-wider">Merchant Preview Mode</span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-teal-400 text-slate-950">Your Listing</span>
                                </div>
                                <p class="text-xs text-slate-300 mt-1">
                                    You are viewing this product in Customer Preview Mode. Under global anti-fraud policies, sellers cannot purchase their own inventory.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 flex-shrink-0">
                            <a href="{{ route('seller.products.edit', $product) }}" 
                               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white font-extrabold text-xs shadow-md transition-all flex items-center space-x-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span>Edit Pricing & Stock</span>
                            </a>
                            <a href="{{ route('seller.dashboard') }}" 
                               class="px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white font-bold text-xs transition-colors">
                                Dashboard &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Normal Customer Dual Purchase Box -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-0.5">
                    
                    <!-- Option A: Group Buy -->
                    <div class="relative bg-emerald-50/70 rounded-2xl border-2 border-[#53a318] p-3.5 sm:p-4 shadow-xs flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-emerald-800 bg-white/90 px-2 py-0.5 rounded-md border border-emerald-200">
                                    <span x-show="!isSelfGroup">{{ $product->group_size_required }} Buyers Pool</span>
                                    <span x-show="isSelfGroup" class="text-emerald-700 font-extrabold">Instant Group Unlocked</span>
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Team Deal</span>
                            </div>

                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-500 block">Team Pool Price</span>
                                <div class="flex items-baseline space-x-2 mt-0.5">
                                    <span class="text-xl sm:text-2xl font-black text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                    <span class="text-xs text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-700 block mt-0.5">
                                    Save ৳{{ number_format($savePerUnit) }} per unit
                                </span>
                            </div>
                        </div>

                        <!-- Total Subtotal for Qty & Action -->
                        <div class="pt-2.5 mt-3 border-t border-emerald-200/80 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-600 font-semibold">Total (<span x-text="qty"></span> <span x-text="qty > 1 ? 'units' : 'unit'"></span>):</span>
                                <span class="text-sm font-black text-emerald-800">৳<span x-text="Number(qty * groupUnitPrice).toLocaleString()"></span></span>
                            </div>

                            <form action="{{ route('group-buy.start', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" :value="qty">
                                <button type="submit" 
                                        class="w-full py-2.5 px-3 rounded-xl font-bold text-xs sm:text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-xs hover:shadow transition-all flex items-center justify-center space-x-1.5 active:scale-[0.99] cursor-pointer">
                                    <span x-show="!isSelfGroup">Group Buy</span>
                                    <span x-show="isSelfGroup">Instant Group Buy</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Option B: Solo Instant Buy -->
                    <div class="relative bg-white rounded-2xl border border-slate-200 p-3.5 sm:p-4 shadow-2xs flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md"
                                      :class="qty >= 3 ? 'bg-emerald-100 text-emerald-800' : (qty === 2 ? 'bg-amber-100 text-amber-900' : 'bg-slate-100 text-slate-600')">
                                    <span x-show="qty === 1">Single Unit Price</span>
                                    <span x-show="qty === 2">Mini Bulk Rate</span>
                                    <span x-show="qty >= 3">Wholesale Rate</span>
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Direct Buy</span>
                            </div>

                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-500 block">Unit Price</span>
                                <div class="flex items-baseline space-x-2 mt-0.5">
                                    <span class="text-xl sm:text-2xl font-black text-slate-900">৳<span x-text="Number(currentSingleUnitPrice).toLocaleString()"></span></span>
                                    <template x-if="qty > 1">
                                        <span class="text-xs text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                                    </template>
                                </div>
                                <div class="mt-0.5">
                                    <template x-if="qty > 1">
                                        <span class="text-[10px] font-bold text-emerald-700 block">Save ৳<span x-text="Number(soloSavingsPerUnit).toLocaleString()"></span> per unit</span>
                                    </template>
                                    <template x-if="qty === 1">
                                        <span class="text-[10px] text-slate-400 font-medium block">Buy 2+ for bulk discount</span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Total Subtotal for Qty & Action -->
                        <div class="pt-2.5 mt-3 border-t border-slate-100 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-600 font-semibold">Total (<span x-text="qty"></span> <span x-text="qty > 1 ? 'units' : 'unit'"></span>):</span>
                                <span class="text-sm font-black text-slate-900">৳<span x-text="Number(qty * currentSingleUnitPrice).toLocaleString()"></span></span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button type="button"
                                        @click="window.addToCart({ id: {{ $product->id }}, title: '{{ addslashes($product->title) }}', price: currentSingleUnitPrice, image: '{{ $product->image_url }}', slug: '{{ $product->slug }}' })"
                                        class="w-full py-2.5 px-2 rounded-xl font-bold text-xs bg-emerald-50 hover:bg-emerald-100 text-[#53a318] border border-emerald-200/90 transition-all flex items-center justify-center space-x-1 active:scale-[0.99] cursor-pointer shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span>Add to Cart</span>
                                </button>
                                <a :href="'{{ route('checkout', ['product_id' => $product->id, 'type' => 'single', 'action' => 'buy_single']) }}' + '&quantity=' + qty" 
                                   class="w-full py-2.5 px-2 rounded-xl font-bold text-xs bg-[#53a318] hover:bg-[#468c13] text-white shadow-2xs hover:shadow transition-all flex items-center justify-center space-x-1 active:scale-[0.99] text-center">
                                    <span>Buy Now</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tiered Milestone Discount Roadmap -->
                @php
                    $tiersList = $product->formatted_tiers;
                @endphp
                @if(count($tiersList) > 1)
                    <div class="p-3.5 sm:p-4 rounded-2xl bg-gradient-to-br from-purple-50/80 via-white to-indigo-50/60 border border-purple-200/90 shadow-2xs space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-6 h-6 rounded-lg bg-purple-600 text-white font-black text-xs flex items-center justify-center">👥</span>
                                <span class="text-xs font-black text-purple-950 uppercase tracking-wide">ধাপভিত্তিক ডিসকাউন্ট অফার (Dynamic Tiers)</span>
                            </div>
                            <span class="text-[10px] font-bold text-purple-800 bg-purple-100 px-2 py-0.5 rounded-full">
                                বাতিল হওয়ার ভয় নেই
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-{{ min(4, count($tiersList)) }} gap-2 pt-1">
                            @foreach($tiersList as $t)
                                <div class="p-2.5 rounded-xl bg-white border {{ $t['is_target'] ? 'border-[#53a318] ring-2 ring-[#53a318]/20 bg-emerald-50/30' : 'border-purple-200/80' }} shadow-2xs flex flex-col justify-between text-center space-y-1">
                                    <div class="flex items-center justify-center space-x-1">
                                        <span class="text-xs font-black text-slate-800">{{ $t['min_members'] }}+ জন</span>
                                        @if($t['is_target'])
                                            <span class="text-[9px] font-black uppercase px-1 rounded bg-[#53a318] text-white">Target</span>
                                        @endif
                                    </div>
                                    <div class="text-xs font-black text-purple-900">
                                        -{{ $t['discount_percent'] }}% ছাড়
                                    </div>
                                    <div class="text-[11px] font-extrabold text-[#53a318]">
                                        ৳{{ number_format($t['price']) }}
                                    </div>
                                    <span class="text-[9px] text-slate-400">সাশ্রয় ৳{{ number_format($t['savings']) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-[11px] text-purple-950/90 leading-relaxed bg-purple-100/50 p-2 rounded-xl border border-purple-200/60">
                            🛡️ <strong>নিরাপদ শিপিং:</strong> সময় শেষ হলেও অন্তত <strong>{{ $tiersList[0]['min_members'] }} জন</strong> হলেই গ্রুপ বাতিল হবে না; অর্জিত ধাপ অনুযায়ী ডিসকাউন্টে সরাসরি ডেলিভারি হবে!
                        </p>
                    </div>
                @endif
            @endif

        </div>

    </div>


    <!-- ========================================================
         3. RUNNING TEAMS SECTION (ACTIVE ONGOING GROUPS)
         ======================================================== -->
    <div class="p-5 sm:p-7 rounded-3xl bg-white border border-slate-200/90 shadow-2xs space-y-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <div class="flex items-center space-x-2">
                    
                    <h2 class="text-base font-black text-slate-900 tracking-tight">
                        Active Running Teams for this Product
                    </h2>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if($activeGroups->isNotEmpty())
                        Join an existing team directly to complete the pool faster and secure the wholesale rate!
                    @else
                        No running teams currently for this item. You can start the first team and invite friends!
                    @endif
                </p>
            </div>

            @if($activeGroups->isNotEmpty())
                <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-black self-start sm:self-auto">
                    {{ $activeGroups->count() }} Open Team{{ $activeGroups->count() > 1 ? 's' : '' }}
                </span>
            @endif
        </div>

        @if($activeGroups->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                @foreach($activeGroups as $group)
                    @php
                        $sec = max(0, (int) now()->diffInSeconds($group->expires_at, false));
                        $needed = max(1, $group->required_members - $group->current_members);
                        $pct = min(100, round(($group->current_members / $group->required_members) * 100));
                    @endphp
                    <div class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/40 border border-slate-200 hover:border-emerald-300 transition-all flex flex-col justify-between space-y-3"
                         x-data="groupCountdown({{ $sec }})" x-init="start()">
                        
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center space-x-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white font-black flex items-center justify-center text-sm shadow-xs shrink-0">
                                    {{ strtoupper(substr($group->leader->name ?? ($group->current_members > 0 ? 'Buyer' : 'Team'), 0, 1)) }}
                                </div>
                                <div class="min-w-0 space-y-0.5">
                                    <span class="text-xs font-bold text-slate-900 truncate block">
                                        @if($group->leader)
                                            {{ $group->leader->name }}'s Team
                                        @elseif($group->current_members > 0)
                                            Customer Team
                                        @else
                                            Open Sponsored Pool
                                        @endif
                                    </span>
                                    <span class="font-mono text-[10px] font-bold text-slate-500 bg-white px-1.5 py-0.2 rounded border border-slate-200">{{ $group->group_code }}</span>
                                </div>
                            </div>

                            <!-- Live Countdown -->
                            <div class="text-right shrink-0">
                                <span class="text-[9px] uppercase font-bold text-slate-400 block">Time Left</span>
                                <span class="font-mono font-bold text-xs text-rose-600" x-text="timeString"></span>
                            </div>
                        </div>

                        <!-- Progress Bar & Status -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-[11px] font-semibold">
                                <span class="text-slate-600">{{ $group->current_members }}/{{ $group->required_members }} joined</span>
                                <span class="text-rose-600 font-bold">{{ $needed }} slot{{ $needed > 1 ? 's' : '' }} needed</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-200 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2 pt-1">
                            <a href="{{ route('group-buy.show', $group->group_code) }}" 
                               class="py-2 px-3 rounded-xl text-xs font-bold bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 transition-colors">
                                View Room
                            </a>
                            <form action="{{ route('group-buy.join', $group) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" :value="qty">
                                <button type="submit" 
                                        class="w-full py-2 px-4 rounded-xl text-xs font-black bg-[#53a318] hover:bg-[#468c13] text-white shadow-2xs hover:shadow-xs transition-all flex items-center justify-center space-x-1 cursor-pointer">
                                    <span>Join Team (৳<span x-text="Number(qty * groupUnitPrice).toLocaleString()"></span>)</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <!-- Friendly prompt when no active teams -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-center space-y-3">
                <div class="w-10 h-10 rounded-xl bg-slate-200/80 text-slate-600 flex items-center justify-center mx-auto">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-800">Be the First to Start a Team for this Deal</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">
                        Click "Group Buy" above to unlock ৳{{ number_format($product->group_price) }}! Invite 1 friend or wait for another customer to join.
                    </p>
                </div>
            </div>
        @endif

    </div>


    <!-- ========================================================
         4. SELLER & NATIONWIDE LOGISTICS INFO
         ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
        
        <!-- Seller Profile Card (5 Cols) -->
        <div class="md:col-span-5 p-5 rounded-3xl bg-white border border-slate-200/90 shadow-2xs flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Verified Merchant</span>
                <div class="flex items-center space-x-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white font-black flex items-center justify-center text-base shadow-xs shrink-0">
                        {{ strtoupper(substr($product->seller->name ?? 'C', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">{{ $product->seller->name ?? 'Cartiva Verified Merchant' }}</h3>
                        <span class="text-[11px] text-emerald-600 font-bold flex items-center space-x-1">
                            <span>✓ Official Partner</span>
                            <span>•</span>
                            <span>Top Rated</span>
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2 text-xs">
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] text-slate-400 block">Fulfillment Rate</span>
                        <span class="font-black text-slate-800">99.4%</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] text-slate-400 block">Chat Response</span>
                        <span class="font-black text-slate-800">&lt; 15 mins</span>
                    </div>
                </div>
            </div>

            <span class="text-[11px] text-slate-400 block">
                Products certified direct from authorized importer or brand distributor.
            </span>
        </div>

        <!-- Logistics, Warranty & Terms (7 Cols) -->
        <div class="md:col-span-7 p-5 rounded-3xl bg-white border border-slate-200/90 shadow-2xs grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                <div class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-800 flex items-center justify-center">
                    <svg class="w-4 h-4 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </div>
                <h4 class="text-xs font-bold text-slate-900">Nationwide Shipping</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Dhaka 2–3 days (৳60). Outside Dhaka 3–5 days (৳120).
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h4 class="text-xs font-bold text-slate-900">Pre-paid Protection</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    100% automated refund if group pool fails to fill before timer.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <h4 class="text-xs font-bold text-slate-900">Official Warranty</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    7-day replacement warranty for manufacturing defects.
                </p>
            </div>

        </div>

    </div>


    <!-- ========================================================
         5. TABBED SPECIFICATIONS & POLICY DETAILS
         ======================================================== -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-2xs overflow-hidden">
        
        <!-- Tab Navigation -->
        <div class="flex items-center space-x-2 border-b border-slate-200 px-5 pt-3 overflow-x-auto no-scrollbar">
            <button type="button" @click="activeTab = 'specs'"
                    :class="activeTab === 'specs' ? 'border-[#53a318] text-[#53a318] font-black' : 'border-transparent text-slate-500 hover:text-slate-800 font-bold'"
                    class="py-3 px-4 border-b-2 text-xs transition-colors cursor-pointer shrink-0">
                Specifications & Highlights
            </button>
            <button type="button" @click="activeTab = 'terms'"
                    :class="activeTab === 'terms' ? 'border-[#53a318] text-[#53a318] font-black' : 'border-transparent text-slate-500 hover:text-slate-800 font-bold'"
                    class="py-3 px-4 border-b-2 text-xs transition-colors cursor-pointer shrink-0">
                Terms & Return Policy
            </button>
            <button type="button" @click="activeTab = 'reviews'"
                    :class="activeTab === 'reviews' ? 'border-[#53a318] text-[#53a318] font-black' : 'border-transparent text-slate-500 hover:text-slate-800 font-bold'"
                    class="py-3 px-4 border-b-2 text-xs transition-colors cursor-pointer shrink-0">
                Customer Reviews ({{ $product->reviews->count() }})
            </button>
        </div>

        <!-- Tab 1: Specifications -->
        <div x-show="activeTab === 'specs'" class="p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex justify-between">
                    <span class="text-slate-500 font-medium">Category</span>
                    <span class="text-slate-900 font-bold">{{ $cleanCat }}</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex justify-between">
                    <span class="text-slate-500 font-medium">Stock Availability</span>
                    <span class="text-emerald-700 font-bold">{{ $product->stock }} Units In Stock</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex justify-between">
                    <span class="text-slate-500 font-medium">Team Size Required</span>
                    <span class="text-slate-900 font-bold">{{ $product->group_size_required }} Buyers</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex justify-between">
                    <span class="text-slate-500 font-medium">Group Window Duration</span>
                    <span class="text-slate-900 font-bold">{{ $product->group_duration_hours }} Hours Countdown</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex justify-between">
                    <span class="text-slate-500 font-medium">Warranty</span>
                    <span class="text-slate-900 font-bold">Official Brand / Importer Warranty</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex justify-between">
                    <span class="text-slate-500 font-medium">Payment Mode</span>
                    <span class="text-slate-900 font-bold">100% Pre-paid Digital (bKash / Nagad / Card)</span>
                </div>
            </div>

            <div class="space-y-2 pt-2 border-t border-slate-100">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Product Description</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>
        </div>

        <!-- Tab 2: Terms & Return Policy -->
        <div x-show="activeTab === 'terms'" x-cloak class="p-6 space-y-4 text-xs text-slate-600 leading-relaxed">
            <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-2">
                <h4 class="font-bold text-amber-950 flex items-center space-x-1.5">
                    <span>⚡ Group Buy Terms & Rules</span>
                </h4>
                <ul class="list-disc list-inside space-y-1 text-amber-900 text-[11px]">
                    <li>Group buy discounts target {{ $product->group_size_required }} member slots to unlock full group rates.</li>
                    @if($product->min_quota_to_ship && $product->min_quota_to_ship < $product->group_size_required)
                        <li class="font-bold text-emerald-800">🛡️ Soft Threshold Guarantee: সময় শেষ হলেও যদি অন্তত {{ $product->min_quota_to_ship }} জন ক্রেতা থাকে, তবে অর্ডার বাতিল বা রিফান্ড হবে না; সবার অর্ডার ডিসকাউন্টে সরাসরি ডেলিভারি হবে! কেবল {{ $product->min_quota_to_ship }} জনের কম হলে ১০০% অটো-রিফান্ড হবে।</li>
                    @else
                        <li>If a group does not fill within the allocated time, Cartiva automatically triggers a 100% full refund back to the buyer's original payment method with zero cancellation fees.</li>
                    @endif
                    <li>Once a team reaches {{ $product->group_size_required }} members, orders are locked and moved directly to dispatch processing.</li>
                </ul>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <h4 class="font-bold text-slate-900">7-Day Return & Replacement Policy</h4>
                <p class="text-[11px] text-slate-500">
                    If the product arrives damaged, defective, or does not match the specifications, you may request a replacement within 7 days of delivery. The item must be in original packaging with all included accessories.
                </p>
            </div>
        </div>

        <!-- Tab 3: Customer Reviews (View & Submit) -->
        <div x-show="activeTab === 'reviews'" x-cloak class="p-6 space-y-6" id="customer-reviews">
            
            @if(session('success'))
                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Overall Rating Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="flex items-center space-x-4">
                    <div class="text-center px-2">
                        <span class="text-3xl font-black text-slate-900 block leading-tight">{{ number_format($product->rating, 1) }}</span>
                        <div class="flex items-center justify-center text-amber-500 text-sm mt-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <span>{{ $i <= round($product->rating) ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                    </div>
                    <div class="text-xs text-slate-500 border-l border-slate-200 pl-4">
                        <p class="font-bold text-slate-800 text-sm">
                            {{ $product->reviews->count() }} Verified Customer {{ Str::plural('Review', $product->reviews->count()) }}
                        </p>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            Real ratings and buyer feedback from verified Cartiva orders.
                        </p>
                    </div>
                </div>

                @auth
                    <a href="#review-form" 
                       class="inline-flex items-center justify-center space-x-1.5 py-2 px-4 rounded-xl text-xs font-bold bg-[#53a318] hover:bg-[#468c13] text-white shadow-2xs hover:shadow transition-all self-start sm:self-auto cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        <span>{{ $userReview ? 'Edit Your Review' : 'Write a Review' }}</span>
                    </a>
                @endauth
            </div>

            <!-- Customer Review Submission Form -->
            <div id="review-form" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-3.5">
                @auth
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                                {{ $userReview ? 'Update Your Review' : 'Write a Review' }}
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">Share your feedback about product quality, pricing, and fulfillment.</p>
                        </div>
                        @if($userReview)
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                Your Existing Review
                            </span>
                        @endif
                    </div>

                    <form action="{{ route('products.reviews.store', $product) }}" method="POST" 
                          x-data="{ starRating: {{ $userReview->rating ?? 5 }}, hoverRating: 0 }" 
                          class="space-y-3 pt-1">
                        @csrf
                        <input type="hidden" name="rating" :value="starRating">

                        <!-- Interactive Star Selector -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Your Rating:</label>
                            <div class="flex items-center space-x-1">
                                <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                    <button type="button" 
                                            @click="starRating = star" 
                                            @mouseenter="hoverRating = star" 
                                            @mouseleave="hoverRating = 0"
                                            class="p-0.5 focus:outline-none transition-transform hover:scale-110 cursor-pointer">
                                        <svg class="w-6 h-6 transition-colors" 
                                             :class="(hoverRating ? hoverRating >= star : starRating >= star) ? 'text-amber-400 fill-amber-400' : 'text-slate-300 fill-slate-100'"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </button>
                                </template>
                                <span class="text-xs font-bold text-slate-600 pl-2" 
                                      x-text="{1: '1 Star — Poor', 2: '2 Stars — Fair', 3: '3 Stars — Good', 4: '4 Stars — Very Good', 5: '5 Stars — Excellent'}[hoverRating || starRating]"></span>
                            </div>
                        </div>

                        <!-- Review Text Area -->
                        <div>
                            <label for="review-comment" class="block text-xs font-bold text-slate-700 mb-1">Your Review:</label>
                            <textarea id="review-comment" name="comment" rows="3" required
                                      class="w-full p-3 rounded-xl border border-slate-200 bg-white text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#53a318] focus:ring-1 focus:ring-[#53a318]"
                                      placeholder="Write your review here... How was the product quality, delivery, and value?">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                            @error('comment')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" 
                                    class="py-2.5 px-5 rounded-xl font-bold text-xs bg-[#53a318] hover:bg-[#468c13] text-white shadow-2xs hover:shadow transition-all cursor-pointer flex items-center space-x-1.5">
                                <span>{{ $userReview ? 'Update Review' : 'Submit Review' }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">Want to share your review?</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">Please sign in to write a review and help other shoppers.</p>
                        </div>
                        <a href="{{ route('login') }}" 
                           class="py-2 px-4 rounded-xl text-xs font-bold bg-[#53a318] hover:bg-[#468c13] text-white transition-all text-center shrink-0">
                            Log in to Review
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Existing Customer Reviews Feed -->
            <div class="space-y-3 pt-1">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                    Customer Feedback ({{ $product->reviews->count() }})
                </h4>

                @forelse($product->reviews as $rev)
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-2xs space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($rev->user->name ?? 'C', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-xs font-bold text-slate-900">{{ $rev->user->name ?? 'Verified Customer' }}</span>
                                        <span class="text-[10px] text-emerald-600 font-semibold">• Verified Buyer</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 block">{{ $rev->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-amber-500 text-xs">
                                @for($s = 1; $s <= 5; $s++)
                                    <span>{{ $s <= $rev->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed pl-10">
                            {{ $rev->comment }}
                        </p>
                    </div>
                @empty
                    <div class="p-6 rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-center space-y-1">
                        <p class="text-xs font-bold text-slate-700">No customer reviews yet</p>
                        <p class="text-[11px] text-slate-500">Be the first to share your thoughts about this product!</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>


    <!-- ========================================================
         6. RELATED DEALS IN THIS CATEGORY
         ======================================================== -->
    @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
        <div class="space-y-4 pt-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                        More Hot Deals in {{ $cleanCat }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Explore related team discounts with instant savings</p>
                </div>
                <a href="{{ route('category.show', $product->category->slug) }}" 
                   class="text-xs font-bold text-[#53a318] hover:underline flex items-center space-x-1">
                    <span>View Category</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($relatedProducts as $rel)
                    <div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-3 group">
                        <a href="{{ route('products.show', $rel->slug) }}" class="block relative aspect-square rounded-xl overflow-hidden bg-slate-50">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[10px] font-black bg-rose-600 text-white shadow-xs">
                                -{{ $rel->discount_percent }}%
                            </span>
                        </a>

                        <div class="space-y-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 truncate group-hover:text-[#53a318] transition-colors">
                                <a href="{{ route('products.show', $rel->slug) }}">{{ $rel->title }}</a>
                            </h4>
                            <div class="flex items-baseline space-x-1.5">
                                <span class="text-sm font-black text-[#53a318]">৳{{ number_format($rel->group_price) }}</span>
                                <span class="text-[10px] text-slate-400 line-through">৳{{ number_format($rel->single_price) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('products.show', $rel->slug) }}" 
                           class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-[#53a318] text-white font-bold text-xs text-center transition-colors flex items-center justify-center space-x-1">
                            <span>View Deal & Join</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<!-- Real-time Countdown helper for active groups list -->
<script>
    function groupCountdown(initialSeconds) {
        return {
            secondsLeft: Math.max(0, Math.floor(Number(initialSeconds) || 0)),
            timeString: '00:00:00',
            timer: null,

            start() {
                this.updateDisplay();
                if (this.secondsLeft > 0) {
                    this.timer = setInterval(() => {
                        if (this.secondsLeft > 0) {
                            this.secondsLeft--;
                            this.updateDisplay();
                        } else {
                            clearInterval(this.timer);
                            this.timeString = 'Expired';
                        }
                    }, 1000);
                }
            },

            updateDisplay() {
                const total = Math.max(0, Math.floor(this.secondsLeft));
                if (total <= 0) {
                    this.timeString = '00:00:00';
                    return;
                }
                const h = Math.floor(total / 3600);
                const m = Math.floor((total % 3600) / 60);
                const s = Math.floor(total % 60);
                this.timeString = [
                    h.toString().padStart(2, '0'),
                    m.toString().padStart(2, '0'),
                    s.toString().padStart(2, '0')
                ].join(':');
            }
        };
    }
</script>
@endsection
