@extends('layouts.app')

@section('title', 'Merchant Orders - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <a href="{{ route('seller.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-teal-600 flex items-center space-x-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span>Back to Merchant Hub</span>
        </a>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Customer Orders for Your Products</h1>
        <p class="text-xs text-slate-500 mt-1">Review orders placed across both solo and completed team-buying sessions.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-6">Product</th>
                        <th class="py-3 px-6">Order ID</th>
                        <th class="py-3 px-6">Customer</th>
                        <th class="py-3 px-6">Delivery Address</th>
                        <th class="py-3 px-6">Quantity</th>
                        <th class="py-3 px-6">Subtotal</th>
                        <th class="py-3 px-6">Order Type</th>
                        <th class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orderItems as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 flex items-center space-x-3">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->title }}" class="w-10 h-10 rounded-lg object-cover bg-slate-100">
                                <span class="font-bold text-slate-900 line-clamp-1 max-w-xs">{{ $item->product->title }}</span>
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-500">{{ $item->order->order_number }}</td>
                            <td class="py-4 px-6 text-slate-800 font-semibold">{{ $item->order->shipping_name }}</td>
                            <td class="py-4 px-6 text-slate-500 max-w-xs truncate">{{ $item->order->shipping_address }}</td>
                            <td class="py-4 px-6 text-slate-700 font-bold">{{ $item->quantity }}</td>
                            <td class="py-4 px-6 font-bold text-emerald-600">${{ number_format($item->subtotal, 2) }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->order->order_type === 'group_buy' ? 'bg-teal-100 text-teal-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $item->order->order_type === 'group_buy' ? 'Team Buy' : 'Solo' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->order->order_status === 'processing' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->order->order_status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400 font-medium">No customer orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $orderItems->links() }}
        </div>
    </div>

</div>
@endsection
