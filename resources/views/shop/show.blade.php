@extends('layouts.app')

@section('title', ($seller->shop_name ?? $seller->name) . ' — Official Merchant Storefront | Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

    <!-- 1. Storefront Header & Hero Banner -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        
        <!-- Top Banner (Custom uploaded or Classic Gradient) -->
        <div class="relative w-full h-44 sm:h-56 md:h-64 bg-gradient-to-r from-slate-950 via-slate-900 to-teal-950 overflow-hidden">
            @if($seller->shop_banner)
                <img src="{{ $seller->shop_banner }}" alt="Store Banner" class="w-full h-full object-cover">
            @else
                <!-- Classic Decorative Mesh -->
                <div class="absolute inset-0 bg-[radial-gradient(#14b8a6_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/3 top-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
            @endif

            <!-- Back to Marketplace button -->
            <a href="{{ route('home') }}" class="absolute top-4 left-4 px-3.5 py-1.5 rounded-xl bg-slate-900/70 hover:bg-slate-900 text-white backdrop-blur-md text-xs font-bold transition-all flex items-center space-x-1.5 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Cartiva Marketplace</span>
            </a>

            @if(auth()->check() && auth()->id() === $seller->id)
                <a href="{{ route('seller.profile') }}" class="absolute top-4 right-4 px-3.5 py-1.5 rounded-xl bg-teal-500 hover:bg-teal-600 text-white font-extrabold text-xs shadow-md transition-all flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Edit Store Branding</span>
                </a>
            @endif
        </div>

        <!-- Store Identity Bar -->
        <div class="p-6 sm:p-8 relative">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 -mt-16 sm:-mt-20">
                
                <!-- Store Logo & Information -->
                <div class="flex flex-col sm:flex-row sm:items-end space-y-4 sm:space-y-0 sm:space-x-5">
                    <!-- Logo -->
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white p-1.5 shadow-xl border border-slate-200/80 flex-shrink-0">
                        <div class="w-full h-full rounded-2xl overflow-hidden bg-gradient-to-tr from-slate-900 to-teal-800 text-white flex items-center justify-center text-3xl font-black">
                            @if($seller->avatar)
                                <img src="{{ $seller->avatar }}" alt="{{ $seller->shop_name ?? $seller->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($seller->shop_name ?? $seller->name, 0, 1)) }}
                            @endif
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2.5">
                            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                {{ $seller->shop_name ?? $seller->name }}
                            </h1>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-teal-100 text-teal-800 border border-teal-200 shadow-2xs">
                                <svg class="w-3.5 h-3.5 mr-1 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Verified Brand
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 font-medium flex items-center space-x-2 flex-wrap">
                            <span class="font-bold text-slate-700">{{ $seller->business_category ?? 'General Merchant' }}</span>
                            <span>•</span>
                            <span>Merchant Member since {{ $seller->created_at->format('M Y') }}</span>
                            @if($seller->address)
                                <span>•</span>
                                <span class="truncate max-w-xs">📍 {{ $seller->address }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Store Action Buttons -->
                <div class="flex items-center space-x-2.5 self-start md:self-end">
                    <button type="button" 
                            onclick="navigator.clipboard.writeText(window.location.href); alert('Official store link copied! Share with buyers.')" 
                            class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        <span>Share Store</span>
                    </button>

                    <a href="mailto:{{ $seller->email }}" class="px-4 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white text-xs font-bold transition-all shadow-md shadow-[#53a318]/20 flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span>Contact Merchant</span>
                    </a>
                </div>

            </div>

            <!-- Merchant Trust Metrics Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-slate-100 text-xs">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Inventory</span>
                    <span class="text-base font-black text-slate-900 mt-0.5 block">{{ $totalProductsCount }} Active Items</span>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Orders Fulfilled</span>
                    <span class="text-base font-black text-indigo-600 mt-0.5 block">{{ $totalSalesCount }}+ Delivered</span>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Buyer Satisfaction</span>
                    <span class="text-base font-black text-emerald-600 mt-0.5 block">★ {{ number_format($avgRating, 1) }} (100% Positive)</span>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Shipping Speed</span>
                    <span class="text-base font-black text-teal-600 mt-0.5 block">⚡ 24h Express Dispatch</span>
                </div>
            </div>

            <!-- Shop Description / About Store -->
            @if($seller->shop_description)
                <div class="mt-5 p-4 rounded-2xl bg-teal-50/60 border border-teal-200/80 text-xs text-slate-700 leading-relaxed">
                    <span class="font-extrabold text-teal-950 block mb-1">About This Merchant:</span>
                    {{ $seller->shop_description }}
                </div>
            @endif

        </div>

    </div>

    <!-- 2. Active Ongoing Group Buy Pools by this Merchant -->
    @if($activeCircles->isNotEmpty())
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-3xl border border-amber-200 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <span class="text-lg">🔥</span>
                    <h3 class="text-base font-black text-amber-950 tracking-tight">
                        Live Ongoing Buying Circles from {{ $seller->shop_name ?? $seller->name }}
                    </h3>
                </div>
                <span class="text-xs text-amber-800 font-bold">Join now to lock wholesale team rates!</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($activeCircles as $circle)
                    <div class="bg-white rounded-2xl p-4 border border-amber-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-2.5 mb-2.5">
                                <img src="{{ $circle->product->image_url }}" alt="{{ $circle->product->title }}" class="w-10 h-10 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                                <div class="min-w-0">
                                    <span class="text-xs font-bold text-slate-900 line-clamp-1">{{ $circle->product->title }}</span>
                                    <span class="font-mono text-[10px] text-teal-700 font-bold">{{ $circle->group_code }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-slate-500 font-medium">{{ $circle->current_members }}/{{ $circle->required_members }} Joined</span>
                                <span class="font-black text-emerald-600">৳{{ number_format($circle->product->group_price) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full" style="width: {{ $circle->progress_percent }}%"></div>
                            </div>
                        </div>

                        <a href="{{ route('group-buy.show', $circle->group_code) }}" class="mt-3 w-full py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold text-center transition-colors">
                            Join Team &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 3. Storefront Catalog & Search Filter -->
    <div class="space-y-6">
        
        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Available Products ({{ $products->total() }})</h3>
                <p class="text-xs text-slate-500 mt-0.5">Explore deals, single purchases, and team buying pools offered by this store.</p>
            </div>

            <form action="{{ route('shop.show', $seller) }}" method="GET" class="flex items-center space-x-2">
                <div class="relative max-w-xs">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search in this store..." 
                           class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500 font-medium">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                @if($categories->isNotEmpty())
                    <select name="category" onchange="this.form.submit()" class="py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                @endif

                @if(request()->hasAny(['q', 'category']))
                    <a href="{{ route('shop.show', $seller) }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-3xl border border-slate-200/90 hover:border-teal-300 p-4 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail Box -->
                        <div class="relative w-full h-44 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 p-3 mb-3 flex items-center justify-center">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[10px] font-black bg-rose-600 text-white shadow-2xs">
                                -{{ $product->discount_percent }}% OFF
                            </span>

                            <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                                {{ $product->group_size_required }} Buyers Team
                            </span>
                        </div>

                        <!-- Title & Category -->
                        <span class="text-[10px] uppercase font-bold text-teal-600 block">{{ $product->category->name ?? 'General' }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="text-xs sm:text-sm font-extrabold text-slate-900 hover:text-teal-600 line-clamp-2 mt-0.5 transition-colors">
                            {{ $product->title }}
                        </a>

                        <!-- Dual Pricing -->
                        <div class="mt-2.5 pt-2 border-t border-slate-100 space-y-1">
                            <div class="flex items-baseline space-x-1.5">
                                <span class="text-xs text-slate-400 font-bold">Team:</span>
                                <span class="text-base font-black text-emerald-600">৳{{ number_format($product->group_price) }}</span>
                                <span class="text-xs text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                            </div>
                            <span class="text-[10px] text-teal-700 font-bold block">
                                Save ৳{{ number_format($product->savings) }} per unit
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('products.show', $product->slug) }}" 
                       class="mt-3.5 w-full py-2 rounded-xl bg-slate-900 hover:bg-teal-600 text-white font-extrabold text-xs text-center transition-all shadow-2xs flex items-center justify-center space-x-1">
                        <span>View Deal & Team Buy</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200/90 p-8">
                    <span class="text-4xl block mb-2">🛍️</span>
                    <h3 class="text-base font-extrabold text-slate-800">No Products Found</h3>
                    <p class="text-xs text-slate-400 mt-1">This merchant currently has no active products matching your search.</p>
                </div>
            @endforelse
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
            {{ $products->links() }}
        </div>

    </div>

</div>
@endsection
