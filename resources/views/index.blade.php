@extends('layouts.app')

@section('title', 'Cartiva - Group Buying & Team Deals Platform')

@section('content')

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-b from-emerald-950 via-slate-900 to-slate-950 text-white py-16 sm:py-24">
        <!-- Glow Orbs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span>Next-Gen Social Team Buying Platform</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                        Team Up With Friends.<br>
                        <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">
                            Unlock Wholesale Deals.
                        </span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Why pay full retail? Start or join a Team Buy session, invite a partner, and save up to <strong>50%</strong>. If your team does not fill before the countdown ends, you get an instant 100% refund.
                    </p>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#live-groups" class="px-6 py-3.5 text-sm font-bold rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white shadow-lg shadow-emerald-500/25 hover:shadow-xl transition-all flex items-center space-x-2">
                            <span>Explore Live Groups</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        <a href="#products-grid" class="px-6 py-3.5 text-sm font-bold rounded-xl bg-slate-800/80 hover:bg-slate-700/80 text-slate-200 border border-slate-700 transition-all">
                            Browse All Products
                        </a>
                    </div>

                    <!-- Trust Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-6 border-t border-slate-800/80 text-center lg:text-left">
                        <div>
                            <div class="text-2xl font-black text-emerald-400">45% OFF</div>
                            <div class="text-xs text-slate-400 font-medium">Avg. Team Savings</div>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-white">24-48h</div>
                            <div class="text-xs text-slate-400 font-medium">Live Deal Timers</div>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-cyan-400">100%</div>
                            <div class="text-xs text-slate-400 font-medium">Guaranteed Refund</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Graphic Card -->
                <div class="lg:col-span-5">
                    <div class="relative bg-slate-900/90 rounded-2xl border border-slate-700/80 p-6 shadow-2xl backdrop-blur-xl">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Featured Team Deal</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                1 Slot Remaining
                            </span>
                        </div>

                        @if($trendingDeals->isNotEmpty())
                            @php $topDeal = $trendingDeals->first(); @endphp
                            <div class="mt-4 space-y-4">
                                <div class="relative rounded-xl overflow-hidden aspect-video bg-slate-800">
                                    <img src="{{ $topDeal->image_url }}" alt="{{ $topDeal->title }}" class="w-full h-full object-cover">
                                    <div class="absolute top-2 left-2 px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-extrabold text-xs shadow-md">
                                        Save ${{ number_format($topDeal->savings, 2) }}
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-white line-clamp-1">{{ $topDeal->title }}</h3>
                                    <div class="flex items-baseline space-x-3 mt-1">
                                        <span class="text-2xl font-black text-emerald-400">${{ number_format($topDeal->group_price, 2) }}</span>
                                        <span class="text-sm text-slate-400 line-through">${{ number_format($topDeal->single_price, 2) }}</span>
                                        <span class="text-xs font-bold text-emerald-500 bg-emerald-950 px-2 py-0.5 rounded">
                                            -{{ $topDeal->discount_percent }}% Team Price
                                        </span>
                                    </div>
                                </div>

                                <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/50 flex items-center justify-between text-xs">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex -space-x-2 overflow-hidden">
                                            <div class="inline-block h-7 w-7 rounded-full ring-2 ring-slate-900 bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">AR</div>
                                            <div class="inline-block h-7 w-7 rounded-full ring-2 ring-slate-900 bg-slate-700 text-slate-300 font-bold text-[10px] flex items-center justify-center animate-pulse">?</div>
                                        </div>
                                        <span class="text-slate-300 font-medium">Waiting for 1 more buyer</span>
                                    </div>
                                    <span class="text-amber-400 font-mono font-bold">14:32:10 Left</span>
                                </div>

                                <a href="{{ route('products.show', $topDeal) }}" class="block w-full text-center py-3 px-4 rounded-xl font-bold text-sm bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white shadow-lg transition-all">
                                    Join This Deal Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Active Live Group Buys Section -->
    <section id="live-groups" class="py-14 bg-gradient-to-b from-slate-950 to-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8">
                <div>
                    <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-amber-400 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                        <span>Expiring Soon</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                        🔥 Active Live Teams Ticking Down
                    </h2>
                    <p class="text-sm text-slate-400 mt-1">
                        Jump into existing buyer groups to lock in maximum discounts before the timer runs out!
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 text-xs font-semibold text-slate-400">
                    Auto-refreshed via Alpine.js
                </div>
            </div>

            @if($activeGroups->isEmpty())
                <div class="bg-slate-800/40 border border-slate-700/60 rounded-2xl p-8 text-center text-slate-400">
                    <p class="text-base font-semibold">No active open teams at this very second.</p>
                    <p class="text-xs text-slate-500 mt-1">Be the pioneer! Choose any product below and start your own Team Buy!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeGroups as $group)
                        @php
                            $seconds = max(0, now()->diffInSeconds($group->expires_at, false));
                        @endphp
                        <div class="bg-slate-900/90 rounded-2xl border border-slate-800 hover:border-emerald-500/50 transition-all p-5 shadow-lg flex flex-col justify-between"
                             x-data="groupCountdown({{ $seconds }})" x-init="start()">
                            
                            <div>
                                <!-- Top Bar with Live Timer -->
                                <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                    <span class="px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/30 text-[11px] font-mono font-bold">
                                        {{ $group->group_code }}
                                    </span>

                                    <!-- Alpine Live Countdown Timer -->
                                    <div class="flex items-center space-x-1 font-mono text-xs font-bold text-amber-400 bg-amber-400/10 border border-amber-400/20 px-2.5 py-1 rounded-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span x-text="timeString">Calculating...</span>
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="flex space-x-4 mt-4">
                                    <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-20 h-20 rounded-xl object-cover bg-slate-800 flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('products.show', $group->product) }}" class="text-sm font-bold text-white hover:text-emerald-400 line-clamp-2 transition-colors">
                                            {{ $group->product->title }}
                                        </a>
                                        <div class="mt-2 flex items-baseline space-x-2">
                                            <span class="text-lg font-black text-emerald-400">${{ number_format($group->product->group_price, 2) }}</span>
                                            <span class="text-xs text-slate-400 line-through">${{ number_format($group->product->single_price, 2) }}</span>
                                            <span class="text-[10px] font-bold text-emerald-400 bg-emerald-950 px-1.5 py-0.5 rounded">
                                                -{{ $group->product->discount_percent }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Member Slots Progress -->
                                <div class="mt-5 p-3 rounded-xl bg-slate-800/50 border border-slate-700/60">
                                    <div class="flex items-center justify-between text-xs mb-2">
                                        <span class="text-slate-300 font-medium">Team Progress</span>
                                        <span class="font-bold text-emerald-400">{{ $group->current_members }} of {{ $group->required_members }} joined</span>
                                    </div>

                                    <!-- Slot Avatars -->
                                    <div class="flex items-center space-x-2">
                                        @foreach($group->members as $member)
                                            <div class="relative group" title="{{ $member->user->name }}">
                                                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center ring-2 ring-emerald-500 shadow-sm">
                                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                </div>
                                                @if($member->is_leader)
                                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-amber-400 rounded-full border border-slate-900" title="Team Leader"></span>
                                                @endif
                                            </div>
                                        @endforeach

                                        @for($i = 0; $i < $group->remainingSlots(); $i++)
                                            <div class="w-8 h-8 rounded-full border-2 border-dashed border-slate-600 bg-slate-800/80 text-slate-400 font-bold text-xs flex items-center justify-center animate-pulse" title="Open Slot">
                                                +1
                                            </div>
                                        @endfor

                                        <span class="text-[11px] font-semibold text-amber-300 pl-2">
                                            Only {{ $group->remainingSlots() }} slot{{ $group->remainingSlots() > 1 ? 's' : '' }} left!
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-5 pt-3 border-t border-slate-800/80 flex items-center space-x-3">
                                <a href="{{ route('group-buy.show', $group) }}" class="flex-1 text-center py-2.5 px-3 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 transition-colors">
                                    View Room
                                </a>
                                <form action="{{ route('group-buy.join', $group) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full text-center py-2.5 px-3 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-md shadow-emerald-600/30 transition-all">
                                        Join & Save
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Main Products Catalog Section -->
    <section id="products-grid" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filter Pills -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-4 mb-8 scrollbar-none">
            <a href="{{ route('home') }}" 
               class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap {{ !request('category') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                All Categories
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat) }}" 
                   class="px-4 py-2 rounded-full text-xs font-bold transition-all whitespace-nowrap flex items-center space-x-1.5 {{ (isset($category) && $category->id === $cat->id) || request('category') === $cat->slug ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                    <span>{{ $cat->icon ?? '🏷️' }}</span>
                    <span>{{ $cat->name }}</span>
                    <span class="text-[10px] opacity-75">({{ $cat->products_count }})</span>
                </a>
            @endforeach
        </div>

        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ isset($category) ? $category->name : 'All Curated Products' }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Select any product to buy instantly solo or initiate a Team Buy with friends.
                </p>
            </div>
            <div class="mt-2 sm:mt-0 text-xs font-semibold text-slate-500">
                Showing {{ $products->count() }} of {{ $products->total() }} items
            </div>
        </div>

        <!-- Product Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    
                    <div>
                        <!-- Product Image Container -->
                        <div class="relative aspect-square bg-slate-100 overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Discount Badge -->
                            <div class="absolute top-3 left-3 bg-rose-600 text-white text-[11px] font-black px-2.5 py-1 rounded-lg shadow-md">
                                -{{ $product->discount_percent }}% OFF
                            </div>

                            <!-- Team Size Badge -->
                            <div class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-1 rounded-md flex items-center space-x-1">
                                <span>👥 {{ $product->group_size_required }}-Person Deal</span>
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="p-5">
                            <span class="text-[11px] font-semibold text-emerald-600 uppercase tracking-wider block mb-1">
                                {{ $product->category->name ?? 'Gear' }}
                            </span>

                            <h3 class="text-sm font-bold text-slate-900 line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors">
                                <a href="{{ route('products.show', $product) }}">
                                    {{ $product->title }}
                                </a>
                            </h3>

                            <div class="flex items-center space-x-1 mt-2 text-amber-500 text-xs">
                                <span>★</span>
                                <span class="font-bold text-slate-800">{{ $product->rating }}</span>
                                <span class="text-slate-400">({{ $product->sales_count }} sales)</span>
                            </div>

                            <!-- Dual Pricing Card -->
                            <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Solo Price</span>
                                        <span class="text-sm font-bold text-slate-600">${{ number_format($product->single_price, 2) }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] uppercase font-bold text-emerald-600 block">Team Price</span>
                                        <span class="text-lg font-black text-emerald-600">${{ number_format($product->group_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="p-5 pt-0">
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Buy Solo -->
                            <a href="{{ route('checkout', ['product_id' => $product->id, 'type' => 'single', 'action' => 'buy_single']) }}" 
                               class="text-center py-2.5 px-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                Buy Solo
                            </a>

                            <!-- Start / Join Group -->
                            <a href="{{ route('products.show', $product) }}" 
                               class="text-center py-2.5 px-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-600/20 transition-all">
                                Team Buy
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-500">
                    <p class="text-base font-semibold">No products found matching your search criteria.</p>
                    <a href="{{ route('home') }}" class="mt-3 inline-block text-xs font-bold text-emerald-600 hover:underline">
                        Reset filters
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    </section>

    <!-- How It Works Educational Banner -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Simple & Risk-Free</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-1">How Cartiva Team Buying Works</h2>
                <p class="text-xs text-slate-500 mt-2">Get brand-name products at bulk prices with zero friction.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 font-black text-lg flex items-center justify-center mx-auto shadow-inner">
                        1
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Choose Your Deal</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pick any product you love and select the discounted "Team Buy" price to initiate a group or join an existing open group.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 font-black text-lg flex items-center justify-center mx-auto shadow-inner">
                        2
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Share or Auto-Match</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Share your group link with a colleague or let other shoppers on Cartiva fill the empty slot before the countdown timer hits zero.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 font-black text-lg flex items-center justify-center mx-auto shadow-inner">
                        3
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Guaranteed Fulfillment</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        When the team is complete, orders are shipped right away! If slots aren't filled in time, you get a 100% immediate automatic refund.
                    </p>
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
                            this.timeString = 'Expired';
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
