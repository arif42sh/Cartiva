@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - Cartiva Seller Fulfillment')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Notification Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-2xs">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('seller.orders') }}" class="hover:text-teal-600">Orders</a>
                <span>/</span>
                <span class="font-mono text-slate-900">{{ $order->order_number }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center space-x-2.5">
                <span>Order #{{ $order->order_number }}</span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-black 
                    {{ $order->order_status === 'processing' ? 'bg-amber-100 text-amber-800' : 
                      ($order->order_status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : 
                      ($order->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700')) }}">
                    {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                </span>
            </h1>
        </div>

        <div class="flex items-center space-x-2">
            <button type="button" onclick="window.print()" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-colors flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print Packing Slip</span>
            </button>
            <a href="{{ route('seller.orders') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                Back to Orders
            </a>
        </div>
    </div>

    <!-- Main Grid: Items & Fulfillment Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Left: Items & Customer Details (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Items Purchased Table Card -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Your Products in This Order</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $sellerItems->count() }} Item(s)</span>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($sellerItems as $item)
                        <div class="p-5 flex items-center justify-between gap-4">
                            <div class="flex items-center space-x-3.5">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->title }}" class="w-14 h-14 rounded-2xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                                <div>
                                    <h4 class="text-xs font-extrabold text-slate-900 line-clamp-1">{{ $item->product->title }}</h4>
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">Category: {{ $item->product->category->name ?? 'General' }}</span>
                                    <div class="text-[11px] text-slate-600 mt-1 font-semibold">
                                        Qty: <strong class="text-slate-900">{{ $item->quantity }}</strong> × ${{ number_format($item->unit_price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <span class="text-xs text-slate-400 block font-semibold">Subtotal</span>
                                <span class="text-sm font-black text-emerald-600">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="font-bold text-slate-700">Total Order Value:</span>
                    <span class="text-base font-black text-slate-900">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Customer & Shipping Information Card -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3 mb-4">
                    Delivery & Customer Information
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Recipient Full Name</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $order->shipping_name }}</span>
                    </div>

                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Contact Phone</span>
                        <a href="tel:{{ $order->shipping_phone }}" class="font-mono font-bold text-teal-600 hover:underline">
                            {{ $order->shipping_phone }}
                        </a>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Delivery Address</span>
                        <p class="font-semibold text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            {{ $order->shipping_address }}
                        </p>
                    </div>

                    @if($order->order_notes)
                        <div class="sm:col-span-2">
                            <span class="text-[10px] uppercase font-bold text-amber-700 block mb-0.5">Customer Delivery Instructions</span>
                            <p class="text-xs text-amber-900 bg-amber-50 p-3 rounded-xl border border-amber-200">
                                "{{ $order->order_notes }}"
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Team Buy Context (if group buy) -->
                @if($order->order_type === 'group_buy' && $order->groupSession)
                    <div class="mt-5 p-4 rounded-2xl bg-teal-50/70 border border-teal-200/80 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-black uppercase text-teal-800 block">Team Buy Association</span>
                            <span class="text-xs font-bold text-teal-950">Circle Code: <strong class="font-mono">{{ $order->groupSession->group_code }}</strong></span>
                        </div>
                        <a href="{{ route('seller.groups.show', $order->groupSession) }}" class="px-3 py-1.5 rounded-xl bg-teal-600 text-white font-bold text-xs hover:bg-teal-700 transition-colors">
                            Inspect Circle &rarr;
                        </a>
                    </div>
                @endif
            </div>

        </div>

        <!-- Right: Fulfillment Status Update (1 col) -->
        <div class="space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                <div class="flex items-center space-x-2 border-b border-slate-100 pb-3 mb-5">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-teal-800 font-black text-xs flex items-center justify-center">📦</span>
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">
                        Dispatch & Fulfillment
                    </h3>
                </div>

                <form action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Order Status <span class="text-rose-500">*</span></label>
                        <select name="order_status" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing (Packaging)</option>
                            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped (In Transit)</option>
                            <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered (Fulfilled)</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Courier Service</label>
                        <input type="text" name="courier_name" value="{{ old('courier_name', $order->courier_name) }}" placeholder="e.g. Steadfast, Pathao, RedX"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Consignment / Tracking Number</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="e.g. TRK-883719"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-md shadow-teal-600/25 transition-all cursor-pointer">
                        Update Fulfillment Info
                    </button>
                </form>

                <!-- Delivery Milestones -->
                <div class="mt-6 pt-5 border-t border-slate-100 space-y-2 text-[11px] text-slate-500 font-medium">
                    <div class="flex items-center justify-between">
                        <span>Order Placed:</span>
                        <strong class="text-slate-700">{{ $order->created_at->format('M d, Y H:i') }}</strong>
                    </div>
                    @if($order->shipped_at)
                        <div class="flex items-center justify-between">
                            <span>Dispatched / Shipped:</span>
                            <strong class="text-indigo-600">{{ $order->shipped_at->format('M d, Y H:i') }}</strong>
                        </div>
                    @endif
                    @if($order->delivered_at)
                        <div class="flex items-center justify-between">
                            <span>Delivered:</span>
                            <strong class="text-emerald-600">{{ $order->delivered_at->format('M d, Y H:i') }}</strong>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span>Payment Method:</span>
                        <strong class="text-slate-800">{{ $order->payment_method }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Payment Status:</span>
                        <span class="px-2 py-0.2 rounded font-black {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
