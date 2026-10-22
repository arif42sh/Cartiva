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
        activeTab: 'specs',
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
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-5 sm:p-7 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Compact Photo Showcase + Thumbnails (5 Cols) -->
        <div class="lg:col-span-5 space-y-4">
            
            <!-- Compact Main Image Box (Max height 360px - NOT full screen!) -->
            <div class="relative w-full h-[320px] sm:h-[360px] rounded-2xl overflow-hidden bg-slate-50 border border-slate-200/90 flex items-center justify-center p-4">
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
                            class="w-16 h-16 rounded-xl overflow-hidden bg-slate-50 border p-1 transition-all shrink-0 cursor-pointer">
                        <img src="{{ $img }}" alt="Preview {{ $idx + 1 }}" class="w-full h-full object-contain">
                    </button>
                @endforeach
            </div>

            <!-- Micro Trust Bar -->
            <div class="grid grid-cols-2 gap-2 pt-1 text-[11px] text-slate-600 font-medium">
                <div class="flex items-center space-x-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-emerald-600 font-bold text-sm">✓</span>
                    <span>100% Genuine Brand</span>
                </div>
                <div class="flex items-center space-x-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-emerald-600 font-bold text-sm">✓</span>
                    <span>Direct Dispatch Warranty</span>
                </div>
            </div>

        </div>


        <!-- Right: Details, Quantity & Dual Purchase Box (7 Cols) -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Category, Title & Metrics -->
            <div class="space-y-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#53a318] bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200/80 inline-block">
                    {{ $cleanCat }}
                </span>

                <h1 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug tracking-tight">
                    {{ $product->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-3 pt-0.5 text-xs">
                    <div class="flex items-center text-amber-500 font-bold bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/60">
                        <span>★</span>
                        <span class="ml-1 text-slate-900">{{ number_format($product->rating, 1) }}</span>
                    </div>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-600 font-semibold">{{ $product->sales_count }}+ orders fulfilled</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-emerald-700 font-bold flex items-center space-x-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>In Stock ({{ $product->stock }} units ready)</span>
                    </span>
                </div>
            </div>

            <!-- Short Highlight Description -->
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal p-3 rounded-2xl bg-slate-50 border border-slate-200/80">
                {{ $product->description }}
            </p>

            <!-- Quantity Selector (Applies to both Solo & Team purchases) -->
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-bold text-slate-900 block">Quantity</span>
                    
                </div>

                <div class="flex items-center space-x-2">
                    <button type="button" @click="dec()" 
                            class="w-9 h-9 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-black text-sm flex items-center justify-center transition-colors shadow-2xs cursor-pointer active:scale-95">
                        -
                    </button>
                    <input type="number" min="1" :max="maxQty" x-model.number="qty" 
                           class="w-14 h-9 text-center font-black text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-[#53a318]">
                    <button type="button" @click="inc()" 
                            class="w-9 h-9 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-black text-sm flex items-center justify-center transition-colors shadow-2xs cursor-pointer active:scale-95">
                        +
                    </button>
                    <span class="text-[11px] text-slate-500 pl-1">unit<span x-show="qty > 1">s</span></span>
                </div>
            </div>

            <!-- Dual Purchase Box (Interactive Price Calculation) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                
                <!-- Option A: Group Buy (Recommended) -->
                <div class="relative bg-emerald-50/70 rounded-3xl border-2 border-[#53a318] p-5 shadow-xs flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-emerald-800 bg-white/90 px-2 py-0.5 rounded-md border border-emerald-200">
                                <span x-show="!isSelfGroup">{{ $product->group_size_required }} Buyers Pool</span>
                                <span x-show="isSelfGroup" class="text-emerald-700 font-extrabold">Instant Group Unlocked</span>
                            </span>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-500 block">Team Pool Price</span>
                            <div class="flex items-baseline space-x-2 mt-0.5">
                                <span class="text-xl sm:text-2xl font-black text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                <span class="text-xs text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 block mt-1">
                                Save ৳{{ number_format($savePerUnit) }} per unit
                            </span>
                        </div>

                        <!-- Slots remaining preview -->
                    
                    </div>

                    <!-- Total Subtotal for Qty -->
                    <div class="pt-2 border-t border-emerald-200/80">
                        <div class="flex items-center justify-between text-xs mb-3">
                            <span class="text-slate-600 font-semibold">Total (<span x-text="qty"></span> <span x-text="qty > 1 ? 'units' : 'unit'"></span>):</span>
                            <span class="text-sm font-black text-emerald-800">৳<span x-text="Number(qty * groupUnitPrice).toLocaleString()"></span></span>
                        </div>

                        <form action="{{ route('group-buy.start', $product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" :value="qty">
                            <button type="submit" 
                                    class="w-full py-3 px-4 rounded-xl font-black text-xs sm:text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2 active:scale-[0.99] cursor-pointer">
                                <span x-show="!isSelfGroup">Group Buy</span>
                                <span x-show="isSelfGroup">Instant Group Buy</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Option B: Solo Instant Buy (Method 2: Dynamic Bulk Tier) -->
                <div class="relative bg-white rounded-3xl border border-slate-200 p-5 shadow-2xs flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md"
                                  :class="qty >= 3 ? 'bg-emerald-100 text-emerald-800' : (qty === 2 ? 'bg-amber-100 text-amber-900' : 'bg-slate-100 text-slate-600')">
                                <span x-show="qty === 1">খুচরা মূল্য</span>
                                <span x-show="qty === 2">মিনি বাল্ক রেট</span>
                                <span x-show="qty >= 3">হোলসেল রেট</span>
                            </span>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-500 block">Unit Price</span>
                            <div class="flex items-baseline space-x-2 mt-0.5">
                                <span class="text-xl sm:text-2xl font-black text-slate-900">৳<span x-text="Number(currentSingleUnitPrice).toLocaleString()"></span></span>
                                <template x-if="qty > 1">
                                    <span class="text-xs text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                                </template>
                            </div>
                        </div>


                    </div>

                    <!-- Total Subtotal for Qty -->
                    <div class="pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs mb-3">
                            <span class="text-slate-600 font-semibold">Total (<span x-text="qty"></span> <span x-text="qty > 1 ? 'units' : 'unit'"></span>):</span>
                            <span class="text-sm font-black text-slate-900">৳<span x-text="Number(qty * currentSingleUnitPrice).toLocaleString()"></span></span>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button type="button"
                                    @click="window.addToCart({ id: {{ $product->id }}, title: '{{ addslashes($product->title) }}', price: currentSingleUnitPrice, image: '{{ $product->image_url }}', slug: '{{ $product->slug }}' })"
                                    class="w-full py-3 px-3 rounded-xl font-bold text-xs bg-emerald-50 hover:bg-emerald-100 text-[#53a318] border border-emerald-200/90 transition-all flex items-center justify-center space-x-1.5 active:scale-[0.99] cursor-pointer shadow-2xs">
                                <svg class="w-4 h-4 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <span>Add to Cart</span>
                            </button>
                            <a :href="'{{ route('checkout', ['product_id' => $product->id, 'type' => 'single', 'action' => 'buy_single']) }}' + '&quantity=' + qty" 
                               class="w-full py-3 px-3 rounded-xl font-bold text-xs bg-[#53a318] hover:bg-[#468c13] text-white shadow-xs transition-all flex items-center justify-center space-x-1.5 active:scale-[0.99] text-center">
                                <span>Buy Now</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

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
                                    {{ strtoupper(substr($group->leader->name ?? 'L', 0, 1)) }}
                                </div>
                                <div class="min-w-0 space-y-0.5">
                                    <span class="text-xs font-bold text-slate-900 truncate block">{{ $group->leader->name ?? 'Anonymous Buyer' }}'s Team</span>
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
                <span class="text-2xl block">👥</span>
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-800">Be the First to Start a Team for this Deal</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">
                        Click "Start Team Buy" above to unlock ৳{{ number_format($product->group_price) }}! Invite 1 friend or wait for another customer to join.
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
                <span class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-800 flex items-center justify-center text-sm font-bold">🚚</span>
                <h4 class="text-xs font-bold text-slate-900">Nationwide Shipping</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Dhaka 2–3 days (৳60). Outside Dhaka 3–5 days (৳120).
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-bold">🛡️</span>
                <h4 class="text-xs font-bold text-slate-900">Pre-paid Protection</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    100% automated refund if group pool fails to fill before timer.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-sm font-bold">✨</span>
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
                Customer Reviews ({{ $product->sales_count }})
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
                    <li>Group buy discounts require all {{ $product->group_size_required }} member slots to be filled before the session countdown timer expires.</li>
                    <li>If a group does not fill within the allocated time, Cartiva automatically triggers a 100% full refund back to the buyer's original payment method with zero cancellation fees.</li>
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

        <!-- Tab 3: Customer Reviews -->
        <div x-show="activeTab === 'reviews'" x-cloak class="p-6 space-y-4">
            <div class="flex items-center space-x-4 border-b border-slate-100 pb-4">
                <div class="text-center">
                    <span class="text-3xl font-black text-slate-900 block">{{ number_format($product->rating, 1) }}</span>
                    <span class="text-amber-500 text-xs">★★★★★</span>
                </div>
                <div class="text-xs text-slate-500">
                    <p class="font-bold text-slate-800">Based on {{ $product->sales_count * 2 + 15 }} verified customer purchases</p>
                    <p class="text-[11px]">98% of buyers recommend this product.</p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800">Zubair A. <span class="text-[10px] text-emerald-600 font-semibold">• Verified Buyer</span></span>
                        <span class="text-amber-500 text-[11px]">★★★★★</span>
                    </div>
                    <p class="text-slate-600 text-[11px]">
                        Saved over ৳{{ number_format($savePerUnit) }} by joining a group! Delivery was fast and product is 100% authentic.
                    </p>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800">Tasmia R. <span class="text-[10px] text-emerald-600 font-semibold">• Verified Buyer</span></span>
                        <span class="text-amber-500 text-[11px]">★★★★★</span>
                    </div>
                    <p class="text-slate-600 text-[11px]">
                        Original packaging with manufacturer warranty. Best value deal on Cartiva.
                    </p>
                </div>
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
