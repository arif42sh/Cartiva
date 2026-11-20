@extends('layouts.seller')

@section('title', 'Group Circle #' . $session->group_code . ' - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('seller.groups') }}" class="hover:text-teal-600">Group Sessions</a>
                <span>/</span>
                <span class="font-mono text-slate-900">{{ $session->group_code }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center space-x-2.5">
                <span>Circle: {{ $session->group_code }}</span>
                @if($session->status === 'completed')
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">Completed & Dispatched</span>
                @elseif($session->status === 'expired' || ($session->status === 'active' && $session->expires_at->isPast()))
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-100 text-rose-800">Expired</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-amber-100 text-amber-800">Active</span>
                @endif
            </h1>
        </div>

        <div class="flex items-center space-x-2">
            <button type="button" 
                    onclick="navigator.clipboard.writeText('{{ route('group-buy.show', $session->group_code) }}'); alert('Direct Group-Buy invitation link copied!')" 
                    class="px-3.5 py-2 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 hover:bg-teal-100 text-xs font-bold transition-colors flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                <span>Share Group Link</span>
            </button>
            <a href="{{ route('seller.groups') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                Back to Sessions
            </a>
        </div>
    </div>

    <!-- Product & Session Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Product Card (2 cols) -->
        <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs flex flex-col sm:flex-row gap-5 items-start">
            <img src="{{ $session->product->image_url }}" alt="{{ $session->product->title }}" class="w-28 h-28 rounded-2xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
            
            <div class="flex-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-teal-600">{{ $session->product->category->name ?? 'Category' }}</span>
                <h3 class="text-base font-extrabold text-slate-900 mt-0.5 leading-snug">{{ $session->product->title }}</h3>
                
                <div class="flex items-center space-x-3 mt-2.5">
                    <div>
                        <span class="text-[10px] text-slate-400 block font-semibold">Solo Price</span>
                        <span class="text-xs font-bold text-slate-700">৳{{ number_format($session->product->single_price) }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-emerald-700 block font-bold">Team Discount Price</span>
                        <span class="text-sm font-black text-emerald-600">৳{{ number_format($session->product->group_price) }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block font-semibold">Total Savings</span>
                        <span class="text-xs font-black text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md">
                            ৳{{ number_format($session->product->savings) }} / buyer
                        </span>
                    </div>
                </div>

                @php
                    $groupTiers = $session->all_tiers;
                    $achievedTier = $session->current_achieved_tier;
                @endphp
                @if(!empty($groupTiers) && count($groupTiers) > 1)
                    <div class="mt-3 p-3 rounded-2xl bg-purple-50/80 border border-purple-200/90 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-extrabold text-purple-950 flex items-center space-x-1.5">
                                <span>🎯</span>
                                <span>Tiered Milestones:</span>
                            </span>
                            @if($achievedTier)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-600 text-white">
                                    Unlocked: {{ $achievedTier['min_members'] }}+ Buyers (-{{ $achievedTier['discount_percent'] }}%)
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900">
                                    Min {{ $session->effective_min_quota }} Buyers to Ship
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-1.5">
                            @foreach($groupTiers as $gt)
                                @php
                                    $isReached = $session->current_members >= $gt['min_members'];
                                @endphp
                                <span class="px-2 py-1 rounded-lg text-[10px] font-bold {{ $isReached ? 'bg-purple-600 text-white shadow-2xs' : 'bg-white border border-purple-200 text-purple-800' }}">
                                    {{ $gt['min_members'] }}+ Buyers: -{{ $gt['discount_percent'] }}% (৳{{ number_format($gt['price']) }}) {{ $isReached ? '✓' : '' }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center space-x-4 text-xs text-slate-500 font-medium">
                    <span>Stock: <strong class="text-slate-800">{{ $session->product->stock }}</strong> units</span>
                    <span>•</span>
                    <a href="{{ route('products.show', $session->product) }}" target="_blank" class="text-teal-600 hover:text-teal-800 font-bold underline">
                        View Product Page &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Session Status Metric (1 col) -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 text-white shadow-md flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-teal-400">Campaign Timing</span>
                <h4 class="text-sm font-bold text-slate-200 mt-1">Circle Expiration Countdown</h4>
                
                <div class="mt-4 p-3.5 rounded-2xl bg-white/10 border border-white/10 text-center">
                    @if($session->status === 'completed')
                        <div class="text-lg font-black text-emerald-400">SUCCESSFUL</div>
                        <span class="text-[10px] text-slate-300">All required buyer slots filled!</span>
                    @elseif($session->status === 'expired' || ($session->status === 'active' && $session->expires_at->isPast()))
                        <div class="text-lg font-black text-rose-400">CAMPAIGN EXPIRED</div>
                        <span class="text-[10px] text-slate-300">Expired {{ $session->expires_at->diffForHumans() }}</span>
                    @else
                        <div class="text-xl font-black text-amber-300 font-mono">
                            {{ $session->expires_at->diffForHumans(['parts' => 2]) }}
                        </div>
                        <span class="text-[10px] text-slate-300">Remaining to recruit buyers</span>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-white/10 text-xs text-slate-300 flex items-center justify-between">
                <span>Created At:</span>
                <span class="font-bold text-white">{{ $session->created_at->format('M d, Y H:i') }}</span>
            </div>
        </div>

    </div>

    <!-- ⚡ One-Click Seller Group Extension Panel -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-2xl p-6 text-white shadow-lg border border-emerald-500/30">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 border-b border-white/10 pb-4 mb-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 mb-1">
                    ⚡ Seller Live Control
                </span>
                <h3 class="text-base font-black text-white">One-Click Group Extension (সময় ও কোটা বাড়ানো)</h3>
                <p class="text-xs text-slate-300 mt-0.5">রানিং গ্রুপের সময় শেষ হওয়ার আগে সময় বাড়িয়ে দিন অথবা অতিরিক্ত ক্রেতা যুক্ত করতে কোটা সম্প্রসারণ করুন।</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-mono bg-white/10 px-3 py-1.5 rounded-xl border border-white/10 text-emerald-300">
                    Target: <strong>{{ $session->required_members }}</strong> | Joined: <strong>{{ $session->current_members }}</strong>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- 1. Extend Duration (Time) -->
            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-200 flex items-center gap-1.5">
                        <span>⏱️</span>
                        <span>Extend Campaign Time (সময় যোগ করুন)</span>
                    </span>
                    <span class="text-[10px] text-slate-400">Current: {{ $session->expires_at ? $session->expires_at->diffForHumans() : 'N/A' }}</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <form action="{{ route('seller.groups.extend', $session) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="add_hours" value="12">
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-emerald-600 text-white font-extrabold text-xs transition-all border border-white/10 cursor-pointer">
                            +12 Hours
                        </button>
                    </form>
                    <form action="{{ route('seller.groups.extend', $session) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="add_hours" value="24">
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs transition-all shadow-xs cursor-pointer">
                            +24 Hours (1 Day)
                        </button>
                    </form>
                    <form action="{{ route('seller.groups.extend', $session) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="add_hours" value="48">
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-emerald-600 text-white font-extrabold text-xs transition-all border border-white/10 cursor-pointer">
                            +48 Hours (2 Days)
                        </button>
                    </form>
                </div>
            </div>

            <!-- 2. Expand Buyer Slots (Members) -->
            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-200 flex items-center gap-1.5">
                        <span>👥</span>
                        <span>Expand Member Slots (স্লট বৃদ্ধি করুন)</span>
                    </span>
                    <span class="text-[10px] text-slate-400">Current: {{ $session->required_members }} slots</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <form action="{{ route('seller.groups.extend', $session) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="add_slots" value="5">
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-teal-600 text-white font-extrabold text-xs transition-all border border-white/10 cursor-pointer">
                            +5 Slots
                        </button>
                    </form>
                    <form action="{{ route('seller.groups.extend', $session) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="add_slots" value="10">
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-extrabold text-xs transition-all shadow-xs cursor-pointer">
                            +10 Slots (Mega Pool)
                        </button>
                    </form>
                    <form action="{{ route('seller.groups.extend', $session) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="add_slots" value="20">
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-teal-600 text-white font-extrabold text-xs transition-all border border-white/10 cursor-pointer">
                            +20 Slots
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @php
        $validMembers = $session->members->where('user_id', '!=', $session->product->seller_id ?? 0);
    @endphp

    <!-- Participating Buyers Roster (xi) -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Participating Buyers ({{ $validMembers->count() }})</h3>
                <p class="text-xs text-slate-500 mt-0.5">Customer members who have authorized payment and joined this group circle.</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-teal-50 text-teal-800 border border-teal-200">
                {{ $validMembers->count() }} / {{ $session->required_members }} Slots Filled
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Buyer</th>
                        <th class="py-3.5 px-6">Role</th>
                        <th class="py-3.5 px-6">Joined Time</th>
                        <th class="py-3.5 px-6">Associated Order</th>
                        <th class="py-3.5 px-6">Delivery Address</th>
                        <th class="py-3.5 px-6 text-right">Order Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($validMembers as $member)
                        @php
                            $user = $member->user;
                            $order = $session->orders->where('user_id', $member->user_id)->first();
                            $isLeader = $session->leader_user_id === $member->user_id;
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            
                            <!-- Buyer Details -->
                            <td class="py-4 px-6 flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-teal-600 text-white flex items-center justify-center font-bold text-xs ring-1 ring-slate-200 flex-shrink-0">
                                    @if($user && $user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($user->name ?? 'Buyer', 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <span class="font-extrabold text-slate-900 block">{{ $user->name ?? 'Customer' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $user->email ?? 'N/A' }}</span>
                                </div>
                            </td>

                            <!-- Role -->
                            <td class="py-4 px-6">
                                @if($isLeader)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-amber-100 text-amber-800">
                                        👑 Group Leader
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700">
                                        Team Member
                                    </span>
                                @endif
                            </td>

                            <!-- Joined Time -->
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ $member->created_at->format('M d, H:i A') }}
                                <span class="text-[10px] text-slate-400 block">({{ $member->created_at->diffForHumans() }})</span>
                            </td>

                            <!-- Order -->
                            <td class="py-4 px-6">
                                @if($order)
                                    <a href="{{ route('seller.orders.show', $order) }}" class="font-mono font-bold text-teal-600 hover:text-teal-800 hover:underline">
                                        {{ $order->order_number }}
                                    </a>
                                @else
                                    <span class="text-slate-400">Order Pending</span>
                                @endif
                            </td>

                            <!-- Shipping -->
                            <td class="py-4 px-6 max-w-xs text-slate-600 truncate">
                                @if($order)
                                    <span>{{ $order->shipping_name }}, {{ $order->shipping_address }}</span>
                                @else
                                    <span class="text-slate-400">N/A</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6 text-right">
                                @if($order)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black 
                                        {{ $order->order_status === 'processing' ? 'bg-amber-100 text-amber-800' : 
                                          ($order->order_status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : 
                                          ($order->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-400">Unprocessed</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="max-w-sm mx-auto space-y-1.5">
                                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <p class="font-bold text-slate-700 text-xs">No Customer Buyers Joined Yet</p>
                                    <p class="text-[11px] text-slate-400">Share your direct group-buy campaign link with shoppers or wait for organic customer orders.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
