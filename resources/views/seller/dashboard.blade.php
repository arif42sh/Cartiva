@extends('layouts.app')

@section('title', 'Merchant Hub - Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Merchant Portal</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">Seller Performance Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1">Manage your team-buying products and monitor incoming orders.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('seller.products.create') }}" class="px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md shadow-teal-600/20 transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>List New Product</span>
            </a>
            <a href="{{ route('seller.products') }}" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition-colors">
                Manage Inventory
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Revenue</span>
            <div class="text-3xl font-black text-slate-900 mt-2">${{ number_format($totalEarnings, 2) }}</div>
            <span class="text-[11px] text-teal-600 font-semibold mt-1 block">From confirmed group & solo orders</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Group Buys</span>
            <div class="text-3xl font-black text-amber-500 mt-2">{{ $activeGroupBuys }}</div>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Live sessions currently filling slots</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Completed Teams</span>
            <div class="text-3xl font-black text-emerald-600 mt-2">{{ $completedGroupBuys }}</div>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Successfully fulfilled team buys</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Products Listed</span>
            <div class="text-3xl font-black text-slate-900 mt-2">{{ $myProductsCount }}</div>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Items active in marketplace</span>
        </div>

    </div>

    <!-- Recent Sales Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Recent Customer Purchases</h3>
            <a href="{{ route('seller.orders') }}" class="text-xs font-bold text-teal-600 hover:underline">
                View All Orders &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-6">Product</th>
                        <th class="py-3 px-6">Customer</th>
                        <th class="py-3 px-6">Order ID</th>
                        <th class="py-3 px-6">Amount</th>
                        <th class="py-3 px-6">Type</th>
                        <th class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSales as $sale)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $sale->product->title }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $sale->order->user->name ?? 'Guest' }}</td>
                            <td class="py-4 px-6 font-mono text-slate-500">{{ $sale->order->order_number }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900">${{ number_format($sale->subtotal, 2) }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sale->order->order_type === 'group_buy' ? 'bg-teal-100 text-teal-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $sale->order->order_type === 'group_buy' ? 'Team Buy' : 'Solo' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sale->order->order_status === 'processing' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $sale->order->order_status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">No sales recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
