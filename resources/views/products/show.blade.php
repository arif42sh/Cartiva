@extends('layouts.app')

@section('title', $product->title . ' - Team Buy on Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Home</a>
        <span>/</span>
        <a href="{{ route('category.show', $product->category) }}" class="hover:text-emerald-600">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-slate-900 truncate max-w-xs">{{ $product->title }}</span>
    </nav>

    <!-- Product Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- Left: Image Gallery -->
        <div class="lg:col-span-6 space-y-4">
            <div class="aspect-square rounded-3xl bg-slate-100 overflow-hidden border border-slate-200 relative group shadow-sm">
                <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                <div class="absolute top-4 left-4 bg-rose-600 text-white font-extrabold text-xs px-3 py-1.5 rounded-xl shadow-md">
                    Save {{ $product->discount_percent }}% with Team Buy
                </div>
            </div>
        </div>

        <!-- Right: Details & Purchase Options -->
        <div class="lg:col-span-6 space-y-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200">
                    {{ $product->category->name }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 leading-tight">
                    {{ $product->title }}
                </h1>
                
                <div class="flex items-center space-x-3 mt-3 text-xs">
                    <div class="flex items-center text-amber-500 font-bold">
                        <span>★</span>
                        <span class="ml-1 text-slate-800">{{ $product->rating }}</span>
                    </div>
                    <span class="text-slate-300">|</span>
                    <span class="text-slate-600 font-medium">{{ $product->sales_count }} shoppers bought this</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-emerald-600 font-bold">In Stock ({{ $product->stock }} left)</span>
                </div>
            </div>

            <p class="text-sm text-slate-600 leading-relaxed">
                {{ $product->description }}
            </p>

            <!-- Dual Pricing Comparison Card -->
            <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border-2 border-emerald-500/30 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase text-emerald-800 tracking-wider">Team Buy Wholesale Price</span>
                        <div class="flex items-baseline space-x-3 mt-1">
                            <span class="text-3xl font-black text-emerald-700">${{ number_format($product->group_price, 2) }}</span>
                            <span class="text-base text-slate-400 line-through">${{ number_format($product->single_price, 2) }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 rounded-full bg-emerald-600 text-white font-extrabold text-xs shadow-sm">
                            Save ${{ number_format($product->savings, 2) }}
                        </span>
                        <span class="block text-[11px] font-semibold text-emerald-700 mt-1">Requires {{ $product->group_size_required }} Buyers</span>
                    </div>
                </div>

                <div class="text-xs text-emerald-900 bg-white/70 backdrop-blur-xs p-3 rounded-xl border border-emerald-200/60 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Deal active for <strong>{{ $product->group_duration_hours }} hours</strong> once initiated. Instant 100% refund if team slots do not fill up.</span>
                </div>

                <!-- Action Button: Start Group -->
                <form action="{{ route('group-buy.start', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-4 px-6 rounded-xl font-extrabold text-sm bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Start A New Team Buy (${{ number_format($product->group_price, 2) }})</span>
                    </button>
                </form>
            </div>

            <!-- Option B: Buy Solo -->
            <div class="p-4 rounded-xl border border-slate-200 bg-white flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase">Don't want to team up?</span>
                    <div class="text-base font-bold text-slate-800 mt-0.5">
                        Buy Immediately Solo for ${{ number_format($product->single_price, 2) }}
                    </div>
                </div>
                <a href="{{ route('checkout', ['product_id' => $product->id, 'type' => 'single', 'action' => 'buy_single']) }}" 
                   class="py-2.5 px-4 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-900 text-white transition-colors">
                    Buy Solo Now
                </a>
            </div>

            <!-- Seller Info -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between text-xs">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center text-sm">
                        {{ strtoupper(substr($product->seller->name ?? 'S', 0, 1)) }}
                    </div>
                    <div>
                        <span class="font-bold text-slate-800 block">{{ $product->seller->name ?? 'Verified Merchant' }}</span>
                        <span class="text-slate-500">Official Certified Seller • 99% Positive</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Active Teams Seeking Members for THIS Product -->
    @if($activeGroups->isNotEmpty())
        <section class="mt-16 pt-10 border-t border-slate-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        ⚡ Active Open Teams For This Item
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Join an existing team directly to speed up fulfillment!
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activeGroups as $group)
                    @php $sec = max(0, now()->diffInSeconds($group->expires_at, false)); @endphp
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between"
                         x-data="groupCountdown({{ $sec }})" x-init="start()">
                        
                        <div>
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <span class="text-xs font-bold text-slate-700">Started by {{ $group->leader->name }}</span>
                                <span class="text-xs font-mono font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-200" x-text="timeString">
                                    00:00:00
                                </span>
                            </div>

                            <div class="mt-3 flex items-center justify-between text-xs">
                                <span class="text-slate-500">Progress:</span>
                                <span class="font-bold text-emerald-600">{{ $group->current_members }} of {{ $group->required_members }} joined</span>
                            </div>

                            <div class="w-full bg-slate-100 rounded-full h-2 mt-2 overflow-hidden">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ ($group->current_members / $group->required_members) * 100 }}%"></div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center space-x-2">
                            <a href="{{ route('group-buy.show', $group) }}" class="flex-1 py-2 text-center rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                View
                            </a>
                            <form action="{{ route('group-buy.join', $group) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-2 text-center rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition-all">
                                    Join Team
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>

<!-- Alpine Timer Helper -->
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
