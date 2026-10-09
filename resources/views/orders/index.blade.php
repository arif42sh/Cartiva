@extends('layouts.app')

@section('title', 'My Orders - Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Order History</h1>
            <p class="text-xs text-slate-500 mt-1">Track the status of your solo and team buy purchases.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">No Orders Placed Yet</h3>
            <p class="text-xs text-slate-500 mt-1 mb-6">Explore our latest team deals and grab your first big discount today!</p>
            <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-md hover:bg-emerald-700 transition-colors">
                Browse Deals
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-emerald-300 transition-colors">
                    
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-800">{{ $order->order_number }}</span>
                            <span class="text-xs text-slate-400">•</span>
                            <span class="text-xs text-slate-500">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                            
                            <!-- Type Badge -->
                            @if($order->order_type === 'group_buy')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-teal-100 text-teal-800">
                                    👥 Team Buy
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    Single Buy
                                </span>
                            @endif

                            <!-- Status Badge -->
                            @if($order->order_status === 'pending_group')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 animate-pulse">
                                    ⏳ Waiting for Team Members
                                </span>
                            @elseif($order->order_status === 'processing')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    ⚙️ Processing
                                </span>
                            @elseif($order->order_status === 'delivered')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                    📦 Delivered
                                </span>
                            @elseif($order->order_status === 'refunded')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                    💰 Refunded
                                </span>
                            @endif
                        </div>

                        <!-- Items info -->
                        <div class="flex items-center space-x-3">
                            @foreach($order->items as $item)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->title }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 line-clamp-1">{{ $item->product->title }}</h4>
                                    <span class="text-[11px] text-slate-500">Qty: {{ $item->quantity }} • ${{ number_format($item->unit_price, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between md:flex-col md:items-end gap-3 pt-4 md:pt-0 border-t md:border-t-0 border-slate-100">
                        <div class="text-right">
                            <span class="text-[10px] text-slate-400 block uppercase font-bold">Total Paid</span>
                            <span class="text-lg font-black text-slate-900">${{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            @if($order->groupSession)
                                <a href="{{ route('group-buy.show', $order->groupSession) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors">
                                    Team Room
                                </a>
                            @endif
                            <a href="{{ route('orders.show', $order) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white hover:bg-slate-800 transition-colors">
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
