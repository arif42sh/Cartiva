@extends('layouts.admin')

@section('title', 'Manage Orders - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Orders</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Platform Order Management</h1>
            <p class="text-xs text-slate-500 mt-1">Universal order directory across all buyers and merchants, escrow lifecycle, and fulfillment statuses.</p>
        </div>
    </div>

    <!-- 4 Summary Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Orders</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block">{{ $totalOrdersCount }}</span>
                <span class="text-[11px] text-purple-700 font-semibold mt-1 block">Lifetime volume</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-xl">
                🛒
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Processing Packaging</span>
                <span class="text-2xl sm:text-3xl font-black text-blue-600 mt-0.5 block">{{ $processingCount }}</span>
                <span class="text-[11px] text-blue-700 font-semibold mt-1 block">Being packed by sellers</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl">
                📦
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">In Courier Transit</span>
                <span class="text-2xl sm:text-3xl font-black text-amber-500 mt-0.5 block">{{ $shippedCount }}</span>
                <span class="text-[11px] text-amber-600 font-semibold mt-1 block">Dispatched with tracking</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-xl">
                🚚
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Delivered & Fulfilled</span>
                <span class="text-2xl sm:text-3xl font-black text-emerald-600 mt-0.5 block">{{ $deliveredCount }}</span>
                <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">Payouts settled</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl">
                ✓
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mb-6 shadow-xs">
        <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <div class="flex-1 relative">
                <input type="text" name="q" value="{{ request('q') }}" 
                       placeholder="Search order number (#ORD-...), customer name, or phone..." 
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-purple-600 focus:bg-white transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <select name="order_status" class="px-3 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-hidden focus:ring-2 focus:ring-purple-600">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('order_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('order_status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('order_status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('order_status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('order_status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <select name="order_type" class="px-3 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-hidden focus:ring-2 focus:ring-purple-600">
                    <option value="">All Types</option>
                    <option value="group_buy" {{ request('order_type') === 'group_buy' ? 'selected' : '' }}>Team Buy Orders</option>
                    <option value="solo" {{ request('order_type') === 'solo' ? 'selected' : '' }}>Solo Buy Orders</option>
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                    Filter
                </button>

                @if(request()->hasAny(['q', 'order_status', 'order_type']))
                    <a href="{{ route('admin.orders') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Order Number</th>
                        <th class="py-3.5 px-6">Customer Details</th>
                        <th class="py-3.5 px-6">Type</th>
                        <th class="py-3.5 px-6 text-right">Amount</th>
                        <th class="py-3.5 px-6 text-center">Escrow Status</th>
                        <th class="py-3.5 px-6 text-center">Delivery Status</th>
                        <th class="py-3.5 px-6 text-right">Date</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-purple-900">
                                <a href="{{ route('admin.orders.show', $ord) }}" class="hover:underline">
                                    {{ $ord->order_number }}
                                </a>
                            </td>

                            <td class="py-4 px-6">
                                <div class="space-y-0.5">
                                    <span class="font-bold text-slate-900 block">{{ $ord->shipping_name ?? $ord->user->name ?? 'Shopper' }}</span>
                                    <span class="text-slate-400 font-mono text-[11px] block">{{ $ord->shipping_phone ?? $ord->user->phone ?? '—' }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                @if($ord->order_type === 'group_buy')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-800 uppercase">
                                        Team Buy
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">
                                        Solo Buy
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right font-mono font-bold text-slate-900">
                                ৳{{ number_format($ord->total_amount) }}
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($ord->escrow_status === 'released')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                        Released
                                    </span>
                                @elseif($ord->escrow_status === 'refunded')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase">
                                        Refunded
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase">
                                        Held in Escrow
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                @php
                                    $statusBadges = [
                                        'pending' => 'bg-amber-100 text-amber-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'delivered' => 'bg-emerald-100 text-emerald-800',
                                        'cancelled' => 'bg-rose-100 text-rose-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusBadges[$ord->order_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $ord->order_status }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right font-mono text-[11px] text-slate-400">
                                {{ $ord->created_at->format('M d, Y') }}
                            </td>

                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $ord) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-purple-100 text-slate-700 hover:text-purple-800 font-bold text-[11px] transition-colors">
                                    Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">No orders found matching criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
