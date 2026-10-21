@extends('layouts.app')

@php
    $slug = $category->slug;
    $meta = $categoryMeta[$slug] ?? [
        'title' => $category->name,
        'icon' => $category->icon ?? '📦',
        'desc' => 'Explore premium wholesale group buying deals in ' . $category->name . '. Buy together with friends and pay less!'
    ];
    $displayTitle = $meta['title'];
    $displayDesc = $meta['desc'];
    $displayIcon = $meta['icon'];
@endphp

@section('title', $displayTitle . ' — Group Buying Catalog | Cartiva')

@section('content')
<div class="max-w-[1600px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-5 sm:py-7 space-y-8"
     x-data="{
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
         1. BREADCRUMBS NAVIGATION
         ======================================================== -->
    <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-[#53a318] transition-colors flex items-center space-x-1">
            <span>Home</span>
        </a>
        <span>/</span>
        <a href="{{ route('home') }}" class="hover:text-[#53a318] transition-colors">Categories</a>
        <span>/</span>
        <span class="text-slate-900 font-bold">{{ $displayTitle }}</span>
    </nav>


    <!-- ========================================================
         2. CATEGORY HERO HEADER BANNER
         ======================================================== -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-[#0a1a2e] to-[#071f0c] border border-slate-800 text-white p-6 sm:p-8 lg:p-10 shadow-xl">
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-[#53a318]/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-3 max-w-2xl">
                
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-[#84cc16] text-[11px] font-black uppercase tracking-wider">
                    <span>{{ $displayIcon }}</span>
                    <span>OFFICIAL SOURCING CATALOG</span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
                    {{ $displayTitle }}
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                    {{ $displayDesc }}
                </p>

                <!-- Assurance Pills -->
                <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-emerald-300 font-bold">
                        🛡️ 100% Genuine Products
                    </span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-cyan-300 font-bold">
                        ⚡ Direct Importer / Wholesale Pool
                    </span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-amber-300 font-bold">
                        🔒 100% Refund Guarantee
                    </span>
                </div>

            </div>

            <!-- Stats Box -->
            <div class="flex md:flex-col items-center justify-around md:justify-center p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md gap-4 text-center min-w-[200px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-[#84cc16] block">
                        {{ $products->total() }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                        Available Products
                    </span>
                </div>
                <div class="hidden md:block w-full border-t border-white/10"></div>
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-amber-300 block">
                        -45%
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                        Max Wholesale Save
                    </span>
                </div>
            </div>

        </div>
    </section>


    <!-- ========================================================
         3. QUICK CATEGORY SWITCHER (OTHER TOP DEPARTMENTS)
         ======================================================== -->
    <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-1">
        <span class="text-xs font-black text-slate-400 uppercase tracking-wider flex-shrink-0 mr-1">Other:</span>
        @php
            $quickCats = [
                ['slug' => 'computers-accessories', 'name' => 'Laptops & PC', 'icon' => '💻'],
                ['slug' => 'smart-tech-audio', 'name' => 'Audio & Sound', 'icon' => '🎧'],
                ['slug' => 'mobile-accessories', 'name' => 'Mobiles & Tabs', 'icon' => '📱'],
                ['slug' => 'wearables-watches', 'name' => 'Smartwatches', 'icon' => '⌚'],
                ['slug' => 'computing-gaming', 'name' => 'Gaming Gear', 'icon' => '🎮'],
                ['slug' => 'winter-specials', 'name' => 'Winter Apparel', 'icon' => '🧥'],
                ['slug' => 'kitchen-appliances', 'name' => 'Kitchen Gear', 'icon' => '🍳'],
                ['slug' => 'home-living', 'name' => 'Home & Living', 'icon' => '🏠'],
                ['slug' => 'dry-food-fmcg', 'name' => 'Grocery & Food', 'icon' => '🥑'],
                ['slug' => 'fashion-bags', 'name' => 'Bags & Travel', 'icon' => '🎒'],
            ];
        @endphp
        @foreach($quickCats as $qc)
            <a href="{{ route('category.show', $qc['slug']) }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1.5 flex-shrink-0 {{ $category->slug === $qc['slug'] ? 'bg-[#53a318] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' }}">
                <span>{{ $qc['icon'] }}</span>
                <span>{{ $qc['name'] }}</span>
            </a>
        @endforeach
    </div>


    <!-- ========================================================
         4. RUNNING GROUP BUYING POOLS IN THIS CATEGORY (IF ANY)
         ======================================================== -->
    @if($activeGroups->isNotEmpty())
        <section class="space-y-4 bg-amber-50/60 rounded-3xl p-5 sm:p-6 border border-amber-200/80">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                    <h2 class="text-sm sm:text-base font-black text-amber-950 tracking-tight">
                        ⚡ Active Running Pools in {{ $displayTitle }}
                    </h2>
                </div>
                <span class="text-xs font-bold text-amber-800">
                    Join with open slot before time expires
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($activeGroups as $group)
                    @php
                        $needed = max(1, $group->required_members - $group->current_members);
                        $pct = min(100, round(($group->current_members / $group->required_members) * 100));
                        $discountPct = round((($group->product->single_price - $group->product->group_price) / $group->product->single_price) * 100);
                    @endphp
                    <div class="bg-white rounded-2xl p-4 border border-amber-200 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between space-y-3">
                        <div class="flex items-start space-x-3">
                            <a href="{{ route('products.show', $group->product->slug) }}" class="block shrink-0">
                                <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-14 h-14 rounded-xl object-cover bg-slate-100 hover:opacity-90 transition-opacity">
                            </a>
                            <div class="min-w-0 flex-1">
                                <span class="text-[9px] font-mono font-black text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded">
                                    {{ $group->group_code }}
                                </span>
                                <h4 class="text-xs font-bold text-slate-900 truncate mt-1 hover:text-[#53a318] transition-colors">
                                    <a href="{{ route('products.show', $group->product->slug) }}">
                                        {{ $group->product->title }}
                                    </a>
                                </h4>
                                <div class="flex items-baseline space-x-1.5 mt-0.5">
                                    <span class="text-xs font-black text-[#53a318]">৳{{ number_format($group->product->group_price) }}</span>
                                    <span class="text-[10px] text-slate-400 line-through">৳{{ number_format($group->product->single_price) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-[10px] font-bold">
                                <span class="text-slate-500">{{ $group->current_members }}/{{ $group->required_members }} joined</span>
                                <span class="text-rose-600">Need {{ $needed }} more</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                        <a href="{{ route('products.show', $group->product->slug) }}" 
                           class="w-full py-2 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-2xs flex items-center justify-center space-x-1">
                            <span>View Deal & Join</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif


    <!-- ========================================================
         5. SORTING & PRODUCT LISTING HEADER
         ======================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
                All Products in {{ $displayTitle }}
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} items
            </p>
        </div>

        <!-- Sorting Pills -->
        <div class="flex items-center space-x-1.5 text-xs font-bold overflow-x-auto no-scrollbar">
            <span class="text-slate-400 text-[11px] uppercase mr-1">Sort:</span>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'latest' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Latest
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'popular' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                ⚡ Most Popular
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'discount']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'discount' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                🔥 Max Discount
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'price_low' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                ৳ Low to High
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'price_high' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                ৳ High to Low
            </a>
        </div>
    </div>


    <!-- ========================================================
         6. CORE PRODUCT GRID
         ======================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
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
                            {{ $displayTitle }}
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

                <!-- Dual Action Buttons: Join Group (Left) & Share Invite (Right) - Strictly Horizontal -->
                <div class="p-5 pt-0 flex items-center gap-2" style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 8px !important; width: 100% !important;">
                    <a href="{{ route('products.show', $product) }}" 
                       style="flex: 1 !important; display: flex !important; align-items: center !important; justify-content: center !important;"
                       class="py-2.5 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs flex items-center justify-center space-x-1 active:scale-95">
                        <span>Join Group</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>

                    <button type="button" @click="openShare('GRP-PROD{{ $product->id }}', '{{ addslashes($product->title) }}')" 
                            title="Share Invite"
                            style="width: 42px !important; height: 38px !important; min-width: 42px !important; flex-shrink: 0 !important; display: flex !important; align-items: center !important; justify-content: center !important;"
                            class="rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer border border-slate-200/80">
                        <svg style="width: 16px !important; height: 16px !important;" class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-slate-200/90 text-slate-500 space-y-3 shadow-xs">
                <span class="text-4xl block">{{ $displayIcon }}</span>
                <h3 class="text-base font-black text-slate-800">No active products found in {{ $displayTitle }}</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">এই বিভাগে বর্তমানে কোনো সক্রিয় প্রোডাক্ট তালিকাভুক্ত নেই। অন্যান্য ক্যাটাগরি ব্রাউজ করুন অথবা সরাসরি সকল পণ্য দেখুন।</p>
                <a href="{{ route('home') }}" class="inline-block py-2.5 px-6 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs transition-colors shadow-xs">
                    Browse All Products &rarr;
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4 flex justify-center">
        {{ $products->links() }}
    </div>


    <!-- ========================================================
         7. SHARE MODAL (PROFESSIONAL CIRCULAR BRANDED)
         ======================================================== -->
    @include('partials.share-modal')

</div>
@endsection
