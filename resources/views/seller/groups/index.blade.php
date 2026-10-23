@extends('layouts.seller')

@section('title', 'Group-Buy Sessions & Circles - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="{
        launchModal: false,
        selectedProductId: '',
        selectedProduct: null,
        products: {{ Js::from($sellerProducts ?? []) }},
        onProductChange(id) {
            this.selectedProduct = this.products.find(p => p.id == id) || null;
        }
     }">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Flash Notification -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-2">
                <span class="text-base">🎉</span>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-black text-sm">&times;</button>
        </div>
    @endif

    <!-- Header & Action Row -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center space-x-2">
                <span>Group-Buying Sessions & Circles</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitor active customer pools, check remaining slots, and inspect participating buyers.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Launch Campaign Pool CTA Button -->
            <button type="button" 
                    @click="launchModal = true; if (products.length > 0 && !selectedProductId) { selectedProductId = products[0].id; onProductChange(selectedProductId); }"
                    class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-2xl bg-slate-900 hover:bg-[#53a318] text-white font-extrabold text-xs shadow-sm hover:shadow-md transition-all cursor-pointer">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Launch Campaign Pool</span>
            </button>

            <!-- Status Filter Tabs -->
            <div class="flex items-center space-x-1 p-1 bg-white rounded-2xl border border-slate-200 shadow-xs text-xs font-bold overflow-x-auto">
                <a href="{{ route('seller.groups') }}" 
                   class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ !request('status') ? 'text-white font-black shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}"
                   @if(!request('status')) style="background-color: #53a318; box-shadow: 0 2px 8px rgba(83, 163, 24, 0.35);" @endif>
                    All ({{ $activeCount + $completedCount + $expiredCount }})
                </a>
                <a href="{{ route('seller.groups') }}?status=active" 
                   class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'active' ? 'bg-amber-500 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                    Active ({{ $activeCount }})
                </a>
                <a href="{{ route('seller.groups') }}?status=completed" 
                   class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'completed' ? 'bg-emerald-600 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                    Completed ({{ $completedCount }})
                </a>
                <a href="{{ route('seller.groups') }}?status=expired" 
                   class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'expired' ? 'bg-rose-600 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                    Expired ({{ $expiredCount }})
                </a>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs mb-6">
        <form action="{{ route('seller.groups') }}" method="GET" class="flex items-center gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by group code (e.g. GRP-...) or product title..." 
                       class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500 transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition-colors">
                Search
            </button>
            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('seller.groups') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Group Sessions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($groups as $group)
            @php
                $isExpired = $group->status === 'expired' || ($group->status === 'active' && $group->expires_at->isPast());
                $isCompleted = $group->status === 'completed';
                $pct = $group->progress_percent;
            @endphp
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-5 flex flex-col justify-between hover:border-teal-300 transition-all group">
                
                <div>
                    <!-- Top Status Strip -->
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="font-mono font-bold text-xs px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700">
                            {{ $group->group_code }}
                        </span>
                        
                        @if($isCompleted)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 flex items-center space-x-1">
                                <span>✓</span>
                                <span>Completed & Unlocked</span>
                            </span>
                        @elseif($isExpired)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800">
                                Expired
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 flex items-center space-x-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Active Pooling</span>
                            </span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="flex items-start space-x-3 mb-4">
                        <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-black text-slate-900 line-clamp-2">{{ $group->product->title }}</h4>
                            <div class="flex items-center space-x-2 mt-1 text-[11px]">
                                <span class="text-slate-400 line-through">${{ number_format($group->product->single_price, 2) }}</span>
                                <span class="font-black text-emerald-600">${{ number_format($group->product->group_price, 2) }}</span>
                                <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1 py-0.2 rounded">-{{ $group->product->discount_percent }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Member Progress Bar -->
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 mb-4">
                        <div class="flex items-center justify-between text-xs font-extrabold mb-1.5">
                            <span class="text-slate-600">Joined Buyers:</span>
                            <span class="text-slate-900">{{ $group->current_members }} of {{ $group->required_members }} Slots</span>
                        </div>
                        <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $isCompleted ? 'bg-emerald-500' : ($isExpired ? 'bg-rose-400' : 'bg-amber-500') }}" 
                                 style="width: {{ $pct }}%"></div>
                        </div>

                        <!-- Participating Buyers Avatar Roster -->
                        <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-slate-200/60">
                            <div class="flex -space-x-1.5 overflow-hidden">
                                @foreach($group->members->take(5) as $member)
                                    <div class="w-6 h-6 rounded-full ring-2 ring-white overflow-hidden bg-teal-500 text-white flex items-center justify-center text-[9px] font-black" title="{{ $member->user->name ?? 'Buyer' }}">
                                        @if($member->user && $member->user->avatar)
                                            <img src="{{ $member->user->avatar }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($member->user->name ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <span class="text-[10px] text-slate-500 font-semibold">
                                Leader: <strong>{{ $group->leader->name ?? 'Customer' }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Expiration Countdown or Result -->
                    <div class="text-[11px] text-slate-500 flex items-center justify-between mb-4">
                        <span>Time Remaining:</span>
                        @if($isCompleted)
                            <span class="font-bold text-emerald-600">Successfully Fulfilled!</span>
                        @elseif($isExpired)
                            <span class="font-bold text-rose-500">Ended {{ $group->expires_at->diffForHumans() }}</span>
                        @else
                            <span class="font-mono font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">
                                ⏳ {{ $group->expires_at->diffForHumans(['parts' => 2]) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($isExpired && !$isCompleted)
                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <a href="{{ route('seller.groups.show', $group) }}" 
                           class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-extrabold text-xs text-center transition-all flex items-center justify-center space-x-1">
                            <span>Inspect</span>
                        </a>
                        <form action="{{ route('seller.groups.relaunch', $group) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Relaunch this circle with a fresh timer?')"
                                    class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs text-center transition-all flex items-center justify-center space-x-1 shadow-xs cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span>Relaunch</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('seller.groups.show', $group) }}" 
                       class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white font-extrabold text-xs text-center transition-all flex items-center justify-center space-x-1.5 shadow-2xs mt-auto">
                        <span>Inspect Circle & Buyers</span>
                        <span>&rarr;</span>
                    </a>
                @endif

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200/90 p-8">
                <span class="text-4xl block mb-2">👥</span>
                <h3 class="text-base font-extrabold text-slate-800">No Group Buying Sessions Found</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">When buyers initiate team purchasing circles for your products, you will see their progress and participants here.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
        {{ $groups->links() }}
    </div>

    <!-- Launch Campaign Pool Modal -->
    <div x-show="launchModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" 
             @click="launchModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100"
                 @click.away="launchModal = false">
                
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 px-6 py-5 text-white flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black tracking-tight" id="modal-title">Launch Campaign Pool</h3>
                            <p class="text-xs text-slate-300 font-medium">Start a new group-buying circle for an active product</p>
                        </div>
                    </div>
                    <button type="button" @click="launchModal = false" class="text-slate-400 hover:text-white transition-colors text-xl font-bold cursor-pointer">
                        &times;
                    </button>
                </div>

                <!-- Form -->
                <form action="{{ route('seller.groups.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <!-- Product Select -->
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">
                            Select Product <span class="text-rose-500">*</span>
                        </label>
                        <select name="product_id" required 
                                x-model="selectedProductId" 
                                @change="onProductChange($event.target.value)"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                            <option value="">-- Choose an active product --</option>
                            @foreach($sellerProducts as $sp)
                                <option value="{{ $sp->id }}">{{ $sp->title }} (${{ number_format($sp->group_price, 2) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Selected Product Quick Preview Card -->
                    <template x-if="selectedProduct">
                        <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 flex items-center space-x-3">
                            <img :src="selectedProduct.image_url" :alt="selectedProduct.title" class="w-12 h-12 rounded-xl object-cover border border-emerald-200 bg-white flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-black text-slate-900 truncate" x-text="selectedProduct.title"></h4>
                                <div class="flex items-center space-x-2 mt-0.5 text-xs">
                                    <span class="text-slate-400 line-through text-[11px]" x-text="'$' + parseFloat(selectedProduct.single_price).toFixed(2)"></span>
                                    <span class="font-black text-emerald-700" x-text="'Group Price: $' + parseFloat(selectedProduct.group_price).toFixed(2)"></span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Required Members & Duration -->
                    <div class="grid grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">
                                Required Buyers
                            </label>
                            <input type="number" name="required_members" min="2" max="100" 
                                   :placeholder="selectedProduct ? selectedProduct.group_size_required : '2'"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                            <span class="text-[10px] text-slate-400 mt-1 block">Default from product specs</span>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">
                                Duration (Hours)
                            </label>
                            <input type="number" name="duration_hours" min="1" max="720" 
                                   :placeholder="selectedProduct ? selectedProduct.group_duration_hours : '48'"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                            <span class="text-[10px] text-slate-400 mt-1 block">Countdown clock length</span>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2.5">
                        <button type="button" @click="launchModal = false"
                                class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold text-xs transition-colors cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c14] text-white font-black text-xs shadow-md transition-all flex items-center space-x-1.5 cursor-pointer">
                            <span>🚀 Launch Group Campaign</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection
