@extends('layouts.app')

@section('title', 'Merchant Hub - Cartiva Seller Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Shared Seller Navigation Header -->
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

    @if($lowStockCount > 0)
        <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold flex items-center justify-between shadow-2xs">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Inventory Warning: You have {{ $lowStockCount }} product(s) with 5 or fewer items remaining in stock.</span>
            </div>
            <a href="{{ route('seller.products') }}?status=low_stock" class="px-3 py-1 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                Restock Now &rarr;
            </a>
        </div>
    @endif

    <!-- Key Performance Metrics (KPI Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <!-- Total Revenue -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden group hover:border-teal-300 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Gross Sales</span>
                <span class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                    $
                </span>
            </div>
            <div class="text-3xl font-black text-slate-900 tracking-tight">${{ number_format($totalEarnings, 2) }}</div>
            <p class="text-[11px] text-teal-600 font-semibold mt-1">Confirmed solo & completed group orders</p>
        </div>

        <!-- Active Group Sessions -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden group hover:border-amber-300 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Group Buys</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    👥
                </span>
            </div>
            <div class="text-3xl font-black text-amber-500 tracking-tight">{{ $activeGroupBuys }}</div>
            <p class="text-[11px] text-slate-500 font-medium mt-1">Circles filling slots right now</p>
        </div>

        <!-- Completed Team Campaigns -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Fulfilled Teams</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    ✓
                </span>
            </div>
            <div class="text-3xl font-black text-emerald-600 tracking-tight">{{ $completedGroupBuys }}</div>
            <p class="text-[11px] text-slate-500 font-medium mt-1">Successful team deals completed</p>
        </div>

        <!-- Pending Order Dispatch -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden group hover:border-indigo-300 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Awaiting Dispatch</span>
                <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    📦
                </span>
            </div>
            <div class="text-3xl font-black text-indigo-600 tracking-tight">{{ $pendingOrdersCount }}</div>
            <p class="text-[11px] text-slate-500 font-medium mt-1">{{ $shippedOrdersCount }} Shipped • {{ $deliveredOrdersCount }} Delivered</p>
        </div>

    </div>

    <!-- Active Groups Realtime Strip & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Live Group Campaigns (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Active Group-Buying Circles</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Live customer circles currently pooling buyers for your products</p>
                </div>
                <a href="{{ route('seller.groups') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">
                    View All &rarr;
                </a>
            </div>

            <div class="space-y-3.5">
                @forelse($activeGroups as $group)
                    <div class="p-3.5 rounded-2xl border border-slate-100 hover:border-teal-200 bg-slate-50/50 hover:bg-white transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                            <div>
                                <span class="text-xs font-black text-slate-900 line-clamp-1">{{ $group->product->title }}</span>
                                <div class="flex items-center space-x-2 mt-0.5 text-[11px] text-slate-500">
                                    <span class="font-mono font-bold text-teal-700 bg-teal-50 px-1.5 py-0.2 rounded">{{ $group->group_code }}</span>
                                    <span>Leader: <strong class="text-slate-800">{{ $group->leader->name ?? 'User' }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="text-right sm:min-w-[120px]">
                                <div class="flex items-center justify-end space-x-1 text-xs font-extrabold text-slate-800">
                                    <span>{{ $group->current_members_count }} / {{ $group->required_members_count }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Joined</span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="w-24 bg-slate-200 h-1.5 rounded-full overflow-hidden mt-1.5">
                                    <div class="bg-teal-500 h-full rounded-full" style="width: {{ min(100, round(($group->current_members_count / $group->required_members_count) * 100)) }}%"></div>
                                </div>
                            </div>

                            <a href="{{ route('seller.groups.show', $group) }}" 
                               class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 text-xs font-bold transition-colors whitespace-nowrap">
                                Details &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <span class="text-2xl block mb-1">⏳</span>
                        <p class="text-xs text-slate-500 font-bold">No live group circles right now.</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">When customers start a team buy, they will appear here in real time.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Inventory & Store Shortcuts (1 col) -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-md flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-teal-400">Quick Operations</span>
                <h3 class="text-lg font-black text-white mt-1">Merchant Action Hub</h3>
                <p class="text-xs text-slate-300 mt-1">Manage pricing tiers, restock items, or fulfill customer orders.</p>

                <div class="space-y-2.5 mt-5">
                    <a href="{{ route('seller.products.create') }}" class="flex items-center justify-between p-3 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/10 transition-colors">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-xl bg-teal-400 text-slate-950 flex items-center justify-center font-black text-sm">+</span>
                            <div>
                                <span class="text-xs font-bold text-white block">List New Product</span>
                                <span class="text-[10px] text-slate-300">With multi-tier group discounts</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('seller.orders') }}?status=processing" class="flex items-center justify-between p-3 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/10 transition-colors">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-black text-xs">🚚</span>
                            <div>
                                <span class="text-xs font-bold text-white block">Dispatch Orders</span>
                                <span class="text-[10px] text-slate-300">{{ $pendingOrdersCount }} orders waiting for courier info</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('seller.profile') }}" class="flex items-center justify-between p-3 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/10 transition-colors">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-xl bg-purple-400 text-slate-950 flex items-center justify-center font-black text-xs">🏪</span>
                            <div>
                                <span class="text-xs font-bold text-white block">Edit Store Profile</span>
                                <span class="text-[10px] text-slate-300">Banner, logo & business details</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
                <span>Cartiva Merchant v2.0</span>
                <span class="text-teal-300 font-bold">24/7 Seller Support</span>
            </div>
        </div>

    </div>

    <!-- Recent Sales Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Recent Customer Purchases</h3>
                <p class="text-xs text-slate-500 mt-0.5">Orders received across both single purchases and completed team buys</p>
            </div>
            <a href="{{ route('seller.orders') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 flex items-center space-x-1">
                <span>Manage All Orders</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Product</th>
                        <th class="py-3.5 px-6">Customer</th>
                        <th class="py-3.5 px-6">Order ID</th>
                        <th class="py-3.5 px-6">Amount</th>
                        <th class="py-3.5 px-6">Type</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSales as $sale)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 flex items-center space-x-3">
                                <img src="{{ $sale->product->image_url }}" alt="{{ $sale->product->title }}" class="w-9 h-9 rounded-lg object-cover bg-slate-100 flex-shrink-0">
                                <span class="font-bold text-slate-800 line-clamp-1 max-w-xs">{{ $sale->product->title }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-semibold">{{ $sale->order->user->name ?? $sale->order->shipping_name }}</td>
                            <td class="py-4 px-6 font-mono text-slate-500">{{ $sale->order->order_number }}</td>
                            <td class="py-4 px-6 font-black text-slate-900">${{ number_format($sale->subtotal, 2) }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $sale->order->order_type === 'group_buy' ? 'bg-teal-100 text-teal-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $sale->order->order_type === 'group_buy' ? 'Team Buy' : 'Solo' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black 
                                    {{ $sale->order->order_status === 'processing' ? 'bg-amber-100 text-amber-800' : 
                                      ($sale->order->order_status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : 
                                      ($sale->order->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $sale->order->order_status)) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('seller.orders.show', $sale->order) }}" class="text-teal-600 hover:text-teal-800 font-bold hover:underline">
                                    Fulfill &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400 font-medium">
                                <span class="text-2xl block mb-1">🛒</span>
                                No sales recorded yet. Promote your products to trigger group buys!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
