@extends('layouts.app')

@section('title', 'Order History & Purchases – Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Purchase & Order History</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">আপনার সকল টিম বাই পুল এবং সিঙ্গেল কেনাকাটার পূর্ণাঙ্গ তালিকা ও স্ট্যাটাস।</p>
        </div>
        <div class="flex items-center space-x-2.5 shrink-0">
            <a href="{{ route('orders.track') }}" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-emerald-300 font-bold text-xs shadow-xs transition-colors flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Live Tracker</span>
            </a>
            <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs shadow-xs transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>

    <!-- Tabs Navigation Bar -->
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-3 mb-6">
        <div class="flex items-center space-x-1.5 sm:space-x-2 text-xs font-bold">
            <!-- All Orders Tab -->
            <a href="{{ route('orders.index', ['tab' => 'all']) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-2 {{ $tab === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span>All Purchases</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $tab === 'all' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $totalCount }}
                </span>
            </a>

            <!-- Active Team Pools Tab -->
            <a href="{{ route('orders.index', ['tab' => 'groups']) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-2 {{ $tab === 'groups' ? 'bg-[#53a318] text-white shadow-xs' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                <span>👥 Team Pools</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $tab === 'groups' ? 'bg-white/20 text-white' : 'bg-emerald-200 text-emerald-900' }}">
                    {{ $groupsCount }}
                </span>
            </a>

            <!-- Delivered Orders Tab -->
            <a href="{{ route('orders.index', ['tab' => 'delivered']) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-2 {{ $tab === 'delivered' ? 'bg-blue-600 text-white shadow-xs' : 'bg-blue-50 text-blue-800 hover:bg-blue-100' }}">
                <span>📦 Delivered</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $tab === 'delivered' ? 'bg-white/20 text-white' : 'bg-blue-200 text-blue-900' }}">
                    {{ $deliveredCount }}
                </span>
            </a>
        </div>

        <a href="{{ route('orders.track') }}" class="text-xs font-bold text-[#53a318] hover:underline flex items-center space-x-1">
            <span>কুরিয়ার ট্র্যাকিং পেজ</span>
            <span>&rarr;</span>
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-xs space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-2 text-2xl">
                🛍️
            </div>
            <h3 class="text-base font-bold text-slate-900">
                @if($tab === 'groups')
                    কোনো টিম বাই অর্ডার নেই
                @elseif($tab === 'delivered')
                    কোনো ডেলিভার্ড অর্ডার নেই
                @else
                    এখনও কোনো অর্ডার করেননি
                @endif
            </h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                বন্ধুদের সাথে গ্রুপ টিম তৈরি করে আকর্ষণীয় পাইকারি রেটে সেরা প্রডাক্ট কিনুন।
            </p>
            <div class="pt-2">
                <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white text-xs font-bold shadow-md transition-colors inline-block">
                    Browse Trending Deals
                </a>
            </div>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-emerald-300 transition-colors">
                    
                    <div class="space-y-3 flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-900 px-2 py-0.5 rounded bg-slate-100 border border-slate-200">
                                {{ $order->order_number }}
                            </span>
                            <span class="text-xs text-slate-400">•</span>
                            <span class="text-xs text-slate-500">{{ $order->created_at->format('M d, Y • h:i A') }}</span>
                            
                            <!-- Type Badge -->
                            @if($order->order_type === 'group_buy')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-teal-100 text-teal-800 border border-teal-200">
                                    👥 Team Buy
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    Single Buy
                                </span>
                            @endif

                            <!-- Status Badge -->
                            @if($order->order_status === 'pending_group')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 animate-pulse border border-amber-200">
                                    ⏳ Waiting for Team Quota
                                </span>
                            @elseif($order->order_status === 'processing')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    ⚙️ Processing & Packing
                                </span>
                            @elseif($order->order_status === 'shipped')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                    🚚 In Transit
                                </span>
                            @elseif($order->order_status === 'delivered')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">
                                    ✅ Delivered
                                </span>
                            @elseif($order->order_status === 'refunded' || $order->order_status === 'cancelled')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    💰 Refunded
                                </span>
                            @endif
                        </div>

                        <!-- Items info -->
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->title }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200 shrink-0">
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-slate-800 line-clamp-1">{{ $item->product->title }}</h4>
                                        <span class="text-[11px] text-slate-500">Qty: <strong class="text-slate-700">{{ $item->quantity }}</strong> • ৳{{ number_format($item->unit_price) }} each</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($order->groupSession && $order->order_status === 'pending_group')
                            <div class="pt-1">
                                <div class="flex items-center justify-between text-[11px] font-bold mb-1">
                                    <span class="text-amber-800">Team Progress: {{ $order->groupSession->current_members }}/{{ $order->groupSession->required_members }} joined</span>
                                    <span class="text-amber-700 font-mono">{{ max(0, $order->groupSession->remainingSlots()) }} slots remaining</span>
                                </div>
                                <div class="w-full h-1.5 bg-amber-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-500 rounded-full transition-all" style="width: {{ $order->groupSession->progress_percent }}%;"></div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Price and Actions -->
                    <div class="flex items-center justify-between md:flex-col md:items-end gap-3 pt-3 md:pt-0 border-t md:border-t-0 border-slate-100 shrink-0">
                        <div class="text-left md:text-right">
                            <span class="text-[10px] text-slate-400 block uppercase font-bold">Total Paid</span>
                            <span class="text-lg font-black text-[#53a318]">৳{{ number_format($order->total_amount) }}</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Live Tracker Link -->
                            <a href="{{ route('orders.track', ['q' => $order->order_number]) }}" 
                               class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors flex items-center space-x-1"
                               title="Live Order Timeline">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <span>Track</span>
                            </a>

                            @if($order->groupSession)
                                <a href="{{ route('group-buy.show', $order->groupSession->group_code) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition-colors">
                                    Team Room
                                </a>
                            @endif
                            
                            <a href="{{ route('orders.show', $order) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white hover:bg-slate-800 transition-colors">
                                Details
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
