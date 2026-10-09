@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' - Cartiva')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 flex items-center space-x-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span>Back to All Orders</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Header -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-mono text-emerald-400 font-bold block">{{ $order->order_number }}</span>
                <h1 class="text-2xl font-black mt-1">Order Details</h1>
                <p class="text-xs text-slate-400 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>

            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                </span>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            
            <!-- Group Buy Notification if applicable -->
            @if($order->groupSession)
                <div class="p-5 rounded-2xl bg-teal-50 border border-teal-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-teal-800 uppercase tracking-wider block">Team Buy Session</span>
                        <p class="text-sm font-semibold text-teal-950 mt-1">
                            Team Code: <strong>{{ $order->groupSession->group_code }}</strong> ({{ $order->groupSession->current_members }} of {{ $order->groupSession->required_members }} joined)
                        </p>
                    </div>
                    <a href="{{ route('group-buy.show', $order->groupSession) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-teal-700 hover:bg-teal-800 text-white shadow-xs">
                        Open Team Room
                    </a>
                </div>
            @endif

            <!-- Items Table -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Purchased Items</h3>
                <div class="divide-y divide-slate-100 border-y border-slate-100">
                    @foreach($order->items as $item)
                        <div class="py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->title }}" class="w-16 h-16 rounded-xl object-cover bg-slate-100">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $item->product->title }}</h4>
                                    <span class="text-xs text-slate-500">Sold by {{ $item->product->seller->name ?? 'Cartiva Merchant' }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-slate-900 block">${{ number_format($item->subtotal, 2) }}</span>
                                <span class="text-xs text-slate-400">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping and Total Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <h4 class="text-xs font-bold uppercase text-slate-500 tracking-wider">Delivery Destination</h4>
                    <p class="text-sm font-bold text-slate-800">{{ $order->shipping_name }}</p>
                    <p class="text-xs text-slate-600 font-mono">{{ $order->shipping_phone }}</p>
                    <p class="text-xs text-slate-600">{{ $order->shipping_address }}</p>
                    @if($order->order_notes)
                        <p class="text-xs text-slate-400 italic mt-2">"{{ $order->order_notes }}"</p>
                    @endif
                </div>

                <div class="space-y-3 p-5 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
                    <h4 class="text-xs font-bold uppercase text-slate-500 tracking-wider">Payment Breakdown</h4>
                    <div class="flex justify-between text-slate-600">
                        <span>Payment Method</span>
                        <span class="font-bold text-slate-800">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Payment Status</span>
                        <span class="font-bold uppercase {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                    <div class="border-t border-slate-200 pt-3 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-slate-900">Total Amount</span>
                        <span class="text-xl font-black text-emerald-600">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
