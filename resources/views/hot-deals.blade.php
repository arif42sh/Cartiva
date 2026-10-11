@extends('layouts.app')

@section('title', 'Hot Deals & Almost Filled Pools — Cartiva')

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
         1. TOP NAVIGATION / BACK BUTTON
         ======================================================== -->
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center space-x-2 text-xs font-bold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3.5 py-2 rounded-xl shadow-2xs hover:shadow-xs transition-all group">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Homepage</span>
        </a>

        <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-[#53a318] transition-colors">Home</a>
            <span>/</span>
            <span class="text-slate-800 font-bold">Hot Deals Catalog</span>
        </nav>
    </div>


    <!-- ========================================================
         2. CLEAN HEADER BANNER (NO ROBOTIC COPY)
         ======================================================== -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-[#0f172a] to-[#071f0c] border border-slate-800 text-white p-6 sm:p-8 lg:p-10 shadow-xl">
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-rose-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-[#53a318]/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-500/20 border border-rose-400/30 text-rose-300 text-[11px] font-black uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400 animate-ping"></span>
                    <span>CLOSING FAST • MIXED CATALOG</span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
                    Hot Deals — Almost Filled Pools
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                    Join active group buy pools and unlock wholesale pricing together with other buyers. Secure your slot before the timer runs out!
                </p>

                <!-- Assurance Micro-pills -->
                <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-emerald-300 font-bold">
                        🛡️ 100% Genuine Products
                    </span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-cyan-300 font-bold">
                        ⚡ Direct Importer / Wholesale Tier
                    </span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 text-amber-300 font-bold">
                        🔒 100% Instant Refund if Unfilled
                    </span>
                </div>
            </div>

            <!-- Stats Box -->
            <div class="flex md:flex-col items-center justify-around md:justify-center p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md gap-4 text-center min-w-[200px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-rose-400 block">
                        {{ $hotGroups->total() }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                        Active Hot Pools
                    </span>
                </div>
                <div class="hidden md:block w-full border-t border-white/10"></div>
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-[#84cc16] block">
                        -45%
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                        Max Pool Discount
                    </span>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================
         3. CONTROLS: FILTER & SORT BAR
         ======================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
        
        <!-- Filters -->
        <div class="flex items-center space-x-1.5 text-xs font-bold overflow-x-auto no-scrollbar">
            <span class="text-slate-400 text-[11px] uppercase mr-1">Filter:</span>
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" 
               class="px-3.5 py-1.5 rounded-xl transition-all {{ $filter === 'all' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All Active Pools
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filter' => '1_slot']) }}" 
               class="px-3.5 py-1.5 rounded-xl transition-all {{ $filter === '1_slot' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                🔥 1 Slot Left
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'ending_today']) }}" 
               class="px-3.5 py-1.5 rounded-xl transition-all {{ $filter === 'ending_today' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                ⏱ Ending in 12h
            </a>
        </div>

        <!-- Sortings -->
        <div class="flex items-center space-x-1.5 text-xs font-bold overflow-x-auto no-scrollbar">
            <span class="text-slate-400 text-[11px] uppercase mr-1">Sort:</span>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'urgency']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'urgency' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Most Filled First
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'discount']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'discount' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Highest Discount
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ $sort === 'price_low' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Price: Low to High
            </a>
        </div>

    </div>


    <!-- ========================================================
         4. MIXED HOT DEALS GRID (ALL CATEGORIES MIXED)
         ======================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($hotGroups as $group)
            @php
                $product = $group->product;
                $discountPct = round((($product->single_price - $product->group_price) / $product->single_price) * 100);
                $needed = max(1, $group->required_members - $group->current_members);
                $pct = min(100, round(($group->current_members / $group->required_members) * 100));
                $rawCat = $product->category->name ?? 'General';
                $cleanCat = preg_match('/\((.*?)\)/', $rawCat, $m) ? $m[1] : $rawCat;
                $remainingSecs = max(0, (int) now()->diffInSeconds($group->expires_at, false));
            @endphp
            <div class="bg-white rounded-3xl border-2 {{ $needed === 1 ? 'border-amber-300' : 'border-slate-200/90' }} shadow-xs hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden group relative"
                 x-data="groupCountdown({{ $remainingSecs }})"
                 x-init="start()">
                
                <div>
                    <!-- Product Image & Urgency Badges -->
                    <a href="{{ route('products.show', $product->slug) }}" class="block relative w-full aspect-square bg-slate-100 overflow-hidden group/img">
                        <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover/img:scale-108 transition-transform duration-500">
                        
                        <!-- Top Left: Category Badge -->
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-xl text-[10px] font-black bg-white/95 text-slate-800 backdrop-blur-md shadow-xs">
                            {{ $cleanCat }}
                        </span>

                        <!-- Top Right: Discount -->
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-xl text-[10px] font-black bg-rose-600 text-white shadow-xs">
                            -{{ $discountPct }}% OFF
                        </span>

                        <!-- Countdown Pill on Image -->
                        <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between bg-black/75 backdrop-blur-xs text-white px-2.5 py-1 rounded-xl text-[11px] font-mono font-bold">
                            <span class="text-rose-400">⏱ <span x-text="timeString"></span> remaining</span>
                            <span class="text-amber-300 font-sans font-black text-[10px]">{{ $group->group_code }}</span>
                        </div>
                    </a>

                    <!-- Card Body -->
                    <div class="p-5 space-y-3.5">
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 line-clamp-2 leading-snug group-hover:text-[#53a318] transition-colors">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                        </h3>

                        <!-- Pricing Box -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <div class="flex items-baseline justify-between text-[11px]">
                                <span class="text-slate-400">Regular: <span class="line-through">৳{{ number_format($product->single_price) }}</span></span>
                                <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-1.5 py-0.2 rounded">Save ৳{{ number_format($product->single_price - $product->group_price) }}</span>
                            </div>
                            <div class="flex items-baseline justify-between pt-0.5">
                                <div>
                                    <span class="text-[9px] uppercase font-bold text-slate-400 block">Pool Price:</span>
                                    <span class="text-lg font-black text-[#53a318]">৳{{ number_format($product->group_price) }}</span>
                                </div>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $needed === 1 ? 'bg-rose-100 text-rose-700 font-black' : 'bg-amber-100 text-amber-800' }}">
                                    @if($needed === 1)
                                        🔥 Only 1 slot left!
                                    @else
                                        {{ $needed }} slots needed
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-[11px] font-bold">
                                <span class="text-slate-600">{{ $group->current_members }}/{{ $group->required_members }} buyers joined</span>
                                <span class="text-[#53a318] font-black">{{ $pct }}%</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons: View Deal on Product Page & Share -->
                <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                    <a href="{{ route('products.show', $product->slug) }}" 
                       class="py-2.5 px-3 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-black text-xs text-center transition-all shadow-xs flex items-center justify-center space-x-1">
                        <span>View Deal & Join</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>

                    <button type="button" @click="openShare('{{ $group->group_code }}', '{{ addslashes($product->title) }}')" 
                            class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition-colors">
                        Share Link
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-slate-200 text-slate-500 space-y-3">
                <span class="text-4xl block">⚡</span>
                <h3 class="text-base font-black text-slate-800">No active pools currently match this filter</h3>
                <p class="text-xs text-slate-400">Try changing your filter settings above or explore other active deals from the homepage.</p>
                <a href="{{ route('hot-deals.index') }}" class="inline-block py-2 px-5 rounded-xl bg-[#53a318] text-white font-bold text-xs">
                    View All Active Pools
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4 flex justify-center">
        {{ $hotGroups->links() }}
    </div>


    <!-- ========================================================
         5. SHARE MODAL (ALPINE.JS)
         ======================================================== -->
    <div x-show="shareModalOpen" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4">
        <div @click.outside="shareModalOpen = false" 
             class="bg-white rounded-3xl p-6 sm:p-7 max-w-md w-full shadow-2xl space-y-5 border border-slate-100">
            
            <div class="flex items-center justify-between border-b pb-3">
                <div class="flex items-center space-x-2">
                    <span class="text-xl">📢</span>
                    <h3 class="text-base font-black text-slate-900">Share Group Buy Deal</h3>
                </div>
                <button @click="shareModalOpen = false" class="text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>
            </div>

            <div>
                <p class="text-xs text-slate-600 font-medium" x-text="shareGroupTitle"></p>
                <div class="flex items-center space-x-2 mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="font-mono text-xs font-black text-slate-800 flex-1 truncate" x-text="window.location.origin + '/group-buy/' + shareGroupCode"></span>
                    <button type="button" @click="copyShareLink(shareGroupCode)" 
                            class="px-3.5 py-1.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white text-xs font-black transition-all flex items-center space-x-1 shadow-2xs">
                        <span x-text="copiedToast ? 'Copied!' : 'Copy'">Copy</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                <a :href="'https://wa.me/?text=' + encodeURIComponent('Join our Cartiva group buy and save up to 45%! ' + window.location.origin + '/group-buy/' + shareGroupCode)" 
                   target="_blank" class="py-2.5 px-3 rounded-xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 text-center transition-colors">
                    WhatsApp Share
                </a>
                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.origin + '/group-buy/' + shareGroupCode)" 
                   target="_blank" class="py-2.5 px-3 rounded-xl bg-blue-50 text-blue-800 hover:bg-blue-100 text-center transition-colors">
                    Facebook Share
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
