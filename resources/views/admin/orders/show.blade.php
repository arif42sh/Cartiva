@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number . ' - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.orders') }}" class="hover:text-purple-600">Orders </a>
                <span>/</span>
                <span class="text-purple-700 font-mono">#{{ $order->order_number }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Order Lifecycle & Invoice Details</h1>
            <p class="text-xs text-slate-500 mt-1">Universal order audit, items list, escrow funds protection, and courier tracking updates.</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.orders') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to All Orders</span>
            </a>
        </div>
    </div>

    <!-- Status Overview Bar -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3">
                <span class="font-mono text-xl font-black text-slate-900">#{{ $order->order_number }}</span>
                @if($order->order_type === 'group_buy')
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-800 uppercase">
                        Team Buy Order
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">
                        Solo Buy Order
                    </span>
                @endif
            </div>
            <div class="text-xs text-slate-500 mt-1">
                Placed on {{ $order->created_at->format('M d, Y h:i A') }} ({{ $order->created_at->diffForHumans() }})
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="text-right">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Payment Method</span>
                <span class="text-xs font-extrabold text-slate-800">{{ strtoupper($order->payment_method) }} ({{ ucfirst($order->payment_status) }})</span>
            </div>
            <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
            <div class="text-right">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Escrow Status</span>
                <span class="text-xs font-black {{ $order->escrow_status === 'released' ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ strtoupper($order->escrow_status ?? 'held') }}
                </span>
            </div>
        </div>
    </div>

    <!-- 2 Column: Left = Items & Logistics, Right = Admin Status Control -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Items & Customer Info (2 cols) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Items Table -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-extrabold text-slate-900">Purchased Items</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center space-x-3.5">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                                    @if($item->product && $item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block text-xs">{{ $item->product->title ?? 'Product Removed' }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium">Merchant: {{ $item->product->seller->shop_name ?? 'Cartiva Direct' }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-slate-500 block">৳{{ number_format($item->unit_price) }} &times; {{ $item->quantity }}</span>
                                <span class="text-sm font-black text-slate-900 font-mono block">৳{{ number_format($item->subtotal) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-sm">
                    <span class="font-extrabold text-slate-900">Total Invoice Amount:</span>
                    <span class="text-xl font-black text-purple-900 font-mono">৳{{ number_format($order->total_amount) }}</span>
                </div>
            </div>

            <!-- Customer & Shipping Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-4">Customer & Delivery Address</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block font-semibold">Recipient Name:</span>
                        <span class="text-slate-900 font-bold text-sm block mt-0.5">{{ $order->shipping_name ?? $order->user->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-semibold">Contact Mobile Phone:</span>
                        <span class="text-slate-900 font-mono font-bold block mt-0.5">{{ $order->shipping_phone ?? $order->user->phone ?? '—' }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 block font-semibold">Shipping Destination:</span>
                        <span class="text-slate-800 font-medium block mt-0.5">{{ $order->shipping_address ?? 'Standard address on file' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Admin Status Lifecycle Control (1 col) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <h3 class="text-xs font-black uppercase tracking-wider text-purple-700 mb-3">Admin Fulfillment Control</h3>
                <p class="text-xs text-slate-500 mb-5">Override delivery status, update courier tracking number, or release funds.</p>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Order Status</label>
                        <select name="order_status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing (Packaging)</option>
                            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped (In Transit)</option>
                            <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered (Fulfilled)</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Courier Partner</label>
                        <input type="text" name="courier_name" value="{{ $order->courier_name }}" placeholder="e.g. Steadfast Courier / RedX" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Consignment / Tracking #</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="e.g. SF-998822" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden font-mono">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                        Update Fulfillment Details
                    </button>
                </form>

                @if($order->escrow_status !== 'released' && $order->order_status === 'delivered')
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <form action="{{ route('admin.orders.release-escrow', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                                Release Escrow Payout to Merchant
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
