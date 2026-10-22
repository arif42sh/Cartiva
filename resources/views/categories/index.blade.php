@extends('layouts.app')

@section('title', 'ক্যাটাগরি সমূহ ও প্রোডাক্ট ক্যাটালগ | Cartiva')

@push('styles')
<style>
    .cat-strip-pill {
        transition: all 0.15s ease-in-out;
        white-space: nowrap;
    }
    .cat-strip-pill.is-active {
        background-color: #53a318 !important;
        color: #ffffff !important;
        border-color: #53a318 !important;
        box-shadow: 0 1px 3px rgba(83, 163, 24, 0.25) !important;
    }
    .buying-mode-btn.is-active {
        background-color: #53a318 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }
</style>
@endpush

@section('content')
<div class="max-w-[1600px] w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-5 space-y-6">

    <!-- ========================================================
         1. BREADCRUMBS
         ======================================================== -->
    <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-[#53a318] transition-colors flex items-center space-x-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Home</span>
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-900 font-bold">Categories</span>
        @if($selectedCategoryModel)
            <span class="text-slate-300">/</span>
            <span class="text-[#53a318] font-bold">{{ $selectedCategoryModel->name }}</span>
        @endif
    </nav>



    <!-- ========================================================
         3. TOP CATEGORY FILTER STRIP (16 CLEAN TEXT PILLS)
         ======================================================== -->
    @php
        $categoryPills = [
            ['name' => 'All Products', 'slug' => 'all'],
            ['name' => 'Computer & Laptop', 'slug' => 'computers-accessories'],
            ['name' => 'Mobile & Accessories', 'slug' => 'mobile-accessories'],
            ['name' => 'Electronics & Audio', 'slug' => 'tech-accessories'],
            ['name' => 'Fashion & Wearables', 'slug' => 'fashion-wearables'],
            ['name' => 'Kitchen Appliances', 'slug' => 'kitchen-appliances'],
            ['name' => 'Grocery & Food', 'slug' => 'dry-food-fmcg'],
            ['name' => 'Home & Lifestyle', 'slug' => 'home-lifestyle'],
            ['name' => 'Winter & Lifestyle', 'slug' => 'winter-specials'],
            ['name' => 'Smartwatch & Gadgets', 'slug' => 'wearables-watches'],
            ['name' => 'Gaming Gear', 'slug' => 'computing-gaming'],
            ['name' => 'Beauty & Care', 'slug' => 'beauty-personal-care'],
            ['name' => 'Sports & Fitness', 'slug' => 'sports-fitness'],
            ['name' => 'Books & Stationery', 'slug' => 'books-stationery'],
            ['name' => 'Baby & Kids', 'slug' => 'baby-kids'],
            ['name' => 'Bag & Travel', 'slug' => 'fashion-bags'],
        ];
    @endphp

    <section class="bg-white rounded-xl border border-slate-200/90 p-3 shadow-2xs space-y-2">
        <div class="flex items-center justify-between text-xs font-bold text-slate-700 pb-1">
            <span>Select Category:</span>
            @if($selectedCategorySlug !== 'all' || $buyingMode !== 'all' || $pricePreset || $minDiscount || $searchQ)
                <a href="{{ route('categories.index') }}" class="text-rose-600 hover:text-rose-700 text-[11px] font-bold">
                    ✕ Clear All Filters
                </a>
            @endif
        </div>

        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-thin scrollbar-thumb-slate-200">
            @foreach($categoryPills as $pill)
                @php
                    $isPillActive = ($selectedCategorySlug === $pill['slug']);
                @endphp
                <a href="{{ route('categories.index', array_merge(request()->except(['category', 'page']), ['category' => $pill['slug']])) }}"
                   class="cat-strip-pill px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all cursor-pointer {{ $isPillActive ? 'is-active' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200' }}">
                    {{ $pill['name'] }}
                </a>
            @endforeach
        </div>
    </section>


    <!-- ========================================================
         4. BUYING PREFERENCE FILTER STRIP (পরামর্শ ১)
         ======================================================== -->
    <section class="bg-white rounded-xl border border-slate-200/90 p-2.5 shadow-2xs flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center space-x-2">
            <span class="text-xs font-bold text-slate-600">Buying Preference:</span>
            <div class="inline-flex rounded-lg bg-slate-100 p-0.5 border border-slate-200 text-xs">
                <!-- All Deals -->
                <a href="{{ route('categories.index', array_merge(request()->except(['buying_mode', 'page']), ['buying_mode' => 'all'])) }}"
                   class="buying-mode-btn px-3 py-1 rounded-md transition-colors {{ $buyingMode === 'all' ? 'is-active' : 'text-slate-700 hover:text-slate-900' }}">
                    All Deals
                </a>

                <!-- Direct / Bulk Buy -->
                <a href="{{ route('categories.index', array_merge(request()->except(['buying_mode', 'page']), ['buying_mode' => 'direct'])) }}"
                   class="buying-mode-btn px-3 py-1 rounded-md transition-colors {{ $buyingMode === 'direct' ? 'is-active' : 'text-slate-700 hover:text-slate-900' }}">
                    Direct / Bulk Buy
                </a>

                <!-- Active Group Deals -->
                <a href="{{ route('categories.index', array_merge(request()->except(['buying_mode', 'page']), ['buying_mode' => 'group'])) }}"
                   class="buying-mode-btn px-3 py-1 rounded-md transition-colors {{ $buyingMode === 'group' ? 'is-active' : 'text-slate-700 hover:text-slate-900' }}">
                    Active Group Deals 
                </a>
            </div>
        </div>

        <!-- Result Count & Sort Selector -->
        <div class="flex items-center space-x-3 text-xs">
          
            
            <form action="{{ route('categories.index') }}" method="GET" class="flex items-center space-x-1.5">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('buying_mode')) <input type="hidden" name="buying_mode" value="{{ request('buying_mode') }}"> @endif
                @if(request('price')) <input type="hidden" name="price" value="{{ request('price') }}"> @endif
                @if(request('min_discount')) <input type="hidden" name="min_discount" value="{{ request('min_discount') }}"> @endif

                <label for="sort-select" class="text-slate-500 font-medium">Sort:</label>
                <select id="sort-select" name="sort" onchange="this.form.submit()" 
                        class="px-2.5 py-1 text-xs bg-slate-50 border border-slate-200 rounded-lg font-bold text-slate-700 focus:outline-none">
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest</option>
                    <option value="discount" {{ $sort === 'discount' ? 'selected' : '' }}>Max Discount</option>
                    <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </div>
    </section>


    <!-- ========================================================
         5. MAIN CONTENT: HOT DEALS STYLE SIDEBAR + 5-COLUMN GRID
         ======================================================== -->
    <div class="flex flex-col lg:flex-row items-start gap-4">
        
        <!-- ====================================================
             A. COMPACT FILTER SIDEBAR (HOT DEALS STYLE)
             ==================================================== -->
        <aside class="w-full lg:w-56 shrink-0 bg-white rounded-xl border border-slate-200/90 p-3.5 shadow-2xs space-y-4">
            
            <!-- Search Inside Categories -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Product Search</label>
                <form action="{{ route('categories.index') }}" method="GET" class="relative">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('buying_mode')) <input type="hidden" name="buying_mode" value="{{ request('buying_mode') }}"> @endif
                    <input type="text" name="q" value="{{ $searchQ }}" placeholder="Search..." 
                           class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:bg-white focus:ring-1 focus:ring-[#53a318]">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>
            </div>

            <hr class="border-slate-100">

            <!-- Price Range Filter (Hot Deals Style) -->
            <div class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-800">Price:</span>
                <div class="flex flex-col space-y-1 text-xs">
                    @php
                        $priceOptions = [
                            ['label' => 'All Price', 'val' => ''],
                            ['label' => 'Under ৳1,000', 'val' => 'under_1000'],
                            ['label' => '৳1,000 – ৳3,000', 'val' => '1000_3000'],
                            ['label' => '৳3,000 – ৳7,000', 'val' => '3000_7000'],
                            ['label' => '৳7,000+', 'val' => 'above_7000'],
                        ];
                    @endphp
                    @foreach($priceOptions as $pOpt)
                        <a href="{{ route('categories.index', array_merge(request()->except(['price', 'page']), ['price' => $pOpt['val']])) }}" 
                           class="flex items-center space-x-2 py-1 px-1.5 rounded-md hover:bg-slate-50 transition-colors {{ ($pricePreset == $pOpt['val'] || (!$pricePreset && $pOpt['val'] === '')) ? 'text-[#53a318] font-bold' : 'text-slate-600' }}">
                            <span class="w-3 h-3 rounded-full border flex items-center justify-center {{ ($pricePreset == $pOpt['val'] || (!$pricePreset && $pOpt['val'] === '')) ? 'border-[#53a318] bg-[#53a318]' : 'border-slate-300' }}">
                                @if(($pricePreset == $pOpt['val'] || (!$pricePreset && $pOpt['val'] === '')))
                                    <span class="w-1 h-1 rounded-full bg-white"></span>
                                @endif
                            </span>
                            <span>{{ $pOpt['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Discount Filter (Hot Deals Style) -->
            <div class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-800">Min Discount:</span>
                <div class="flex flex-col space-y-1 text-xs">
                    @php
                        $discOptions = [
                            ['label' => 'All Discount', 'val' => ''],
                            ['label' => '20% or more', 'val' => '20'],
                            ['label' => '30% or more', 'val' => '30'],
                            ['label' => '40% or more', 'val' => '40'],
                        ];
                    @endphp
                    @foreach($discOptions as $dOpt)
                        <a href="{{ route('categories.index', array_merge(request()->except(['min_discount', 'page']), ['min_discount' => $dOpt['val']])) }}" 
                           class="flex items-center space-x-2 py-1 px-1.5 rounded-md hover:bg-slate-50 transition-colors {{ ($minDiscount == $dOpt['val'] || (!$minDiscount && $dOpt['val'] === '')) ? 'text-[#53a318] font-bold' : 'text-slate-600' }}">
                            <span class="w-3 h-3 rounded-full border flex items-center justify-center {{ ($minDiscount == $dOpt['val'] || (!$minDiscount && $dOpt['val'] === '')) ? 'border-[#53a318] bg-[#53a318]' : 'border-slate-300' }}">
                                @if(($minDiscount == $dOpt['val'] || (!$minDiscount && $dOpt['val'] === '')))
                                    <span class="w-1 h-1 rounded-full bg-white"></span>
                                @endif
                            </span>
                            <span>{{ $dOpt['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Category List in Sidebar -->
            <div class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-800">All Categories:</span>
                <div class="max-h-56 overflow-y-auto space-y-1 text-xs pr-1 scrollbar-thin scrollbar-thumb-slate-200">
                    <a href="{{ route('categories.index', array_merge(request()->except(['category', 'page']), ['category' => 'all'])) }}"
                       class="flex items-center justify-between py-1 px-1.5 rounded hover:bg-slate-50 {{ $selectedCategorySlug === 'all' ? 'text-[#53a318] font-bold' : 'text-slate-600' }}">
                        <span>All Products</span>
                        <span class="text-[10px] text-slate-400">({{ $totalProductsCount }})</span>
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('categories.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                           class="flex items-center justify-between py-1 px-1.5 rounded hover:bg-slate-50 {{ $selectedCategorySlug === $cat->slug ? 'text-[#53a318] font-bold' : 'text-slate-600' }}">
                            <span class="truncate pr-1">{{ $cat->name }}</span>
                            @if($cat->products_count > 0)
                                <span class="text-[10px] text-slate-400 shrink-0">({{ $cat->products_count }})</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

        </aside>


        <!-- ====================================================
             B. ROW-WISE 5-COLUMN PRODUCT GRID (COMPACT BOXES)
             ==================================================== -->
        <main class="flex-1 min-w-0">
            @if($products->count() > 0)
                <!-- 5 Columns Grid on large/xl, 4 on desktop, 3 on tablet, 2 on mobile -->
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2.5 sm:gap-3">
                    @foreach($products as $product)
                        @php
                            $singleP = $product->single_price;
                            $groupP = $product->group_price;
                            $saveP = $singleP - $groupP;
                            $discountPct = $singleP > 0 ? round(($saveP / $singleP) * 100) : 0;
                            // Check for active group session
                            $activePool = $product->activeGroupSessions->where('status', 'active')->first();
                        @endphp

                        <div class="group bg-white rounded-xl border border-slate-200/90 hover:border-emerald-400 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                            
                            <!-- Product Image Area -->
                            <div class="relative w-full aspect-square bg-slate-50 overflow-hidden">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" 
                                         alt="{{ $product->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                                         loading="lazy">
                                </a>

                                <!-- Discount Badge -->
                                @if($discountPct > 0)
                                    <span class="absolute top-2 left-2 bg-rose-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-2xs">
                                        {{ $discountPct }}% OFF
                                    </span>
                                @endif

                                <!-- Category Label -->
                                @if($product->category)
                                    <span class="absolute top-2 right-2 bg-white/90 backdrop-blur-xs text-slate-700 text-[9px] font-semibold px-1.5 py-0.5 rounded border border-slate-200/70 truncate max-w-[100px]">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- Product Information -->
                            <div class="p-2.5 sm:p-3 flex-1 flex flex-col justify-between space-y-2">
                                <div>
                                    <!-- Title -->
                                    <h3 class="text-xs font-semibold text-slate-800 line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            {{ $product->title }}
                                        </a>
                                    </h3>

                                    <!-- Running Pool Indicator (Only when actually running) -->
                                    @if($activePool && $activePool->current_members < $activePool->required_members)
                                        <div class="mt-1.5 flex items-center space-x-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded w-max">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>গ্রুপ রানিং: {{ $activePool->current_members }}/{{ $activePool->required_members }} জন</span>
                                        </div>
                                    @endif

                                    <!-- Dual Price Display -->
                                    <div class="mt-2 flex items-baseline space-x-1.5">
                                        <span class="text-sm font-black text-[#53a318]">
                                            ৳{{ number_format($groupP, 0) }}
                                        </span>
                                        <span class="text-[11px] text-slate-400 line-through">
                                            ৳{{ number_format($singleP, 0) }}
                                        </span>
                                    </div>

                                    @if($saveP > 0)
                                        <div class="text-[10px] text-emerald-700 font-semibold mt-0.5">
                                            সাশ্রয়: ৳{{ number_format($saveP, 0) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons: "ডিল দেখুন" & "Add to Cart" -->
                                <div class="pt-1.5 border-t border-slate-100 flex items-center gap-1.5">
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="flex-1 inline-flex items-center justify-center py-1.5 px-2 rounded-lg bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs transition-colors shadow-2xs">
                                        <span>ডিল দেখুন</span>
                                    </a>
                                    <button type="button" 
                                            @click="window.addToCart({ id: {{ $product->id }}, title: '{{ addslashes($product->title) }}', price: {{ $product->group_price }}, image: '{{ $product->image_url }}', slug: '{{ $product->slug }}' })"
                                            title="কার্টে যোগ করুন (Add to Cart)"
                                            class="w-8 h-7.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white flex items-center justify-center transition-colors cursor-pointer shadow-2xs shrink-0">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="p-10 text-center bg-white rounded-xl border border-slate-200/90 space-y-3">
                    <h3 class="text-sm font-bold text-slate-800">কোনো প্রোডাক্ট পাওয়া যায়নি</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        আপনার নির্বাচিত ফিল্টারে কোনো পণ্য পাওয়া যায়নি। ফিল্টার রিসেট করে আবার চেষ্টা করুন।
                    </p>
                    <div class="pt-1">
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-[#53a318] text-white text-xs font-bold">
                            সকল প্রোডাক্ট দেখুন
                        </a>
                    </div>
                </div>
            @endif
        </main>

    </div>

</div>
@endsection
