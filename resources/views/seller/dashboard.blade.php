@extends('layouts.seller')

@section('title', 'Merchant Hub - Cartiva Seller Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5 space-y-5">

    <!-- Shared Seller Navigation Header -->
    @include('seller.partials.nav')

    <!-- Notification Alert -->
    @if(session('success'))
        <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-[#53a318] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 font-bold text-base">&times;</button>
        </div>
    @endif

    @if($lowStockCount > 0)
        <div x-data="{ dismissed: sessionStorage.getItem('cartiva_dismiss_low_stock') === 'true' }" 
             x-show="!dismissed"
             class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-950 text-xs font-medium flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span>
                    Stock Notice: You have <strong class="text-amber-950 font-bold">{{ $lowStockCount }} product(s)</strong> with 5 or fewer items remaining in inventory.
                </span>
            </div>
            <div class="flex items-center space-x-2 self-end sm:self-auto flex-shrink-0">
                <a href="{{ route('seller.products') }}?status=low_stock" 
                   class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg transition-colors text-xs inline-flex items-center space-x-1 shadow-2xs">
                    <span>Restock Now</span>
                    <span>&rarr;</span>
                </a>
                <button type="button" 
                        @click="dismissed = true; sessionStorage.setItem('cartiva_dismiss_low_stock', 'true')" 
                        class="w-6 h-6 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-900 flex items-center justify-center font-bold text-sm transition-colors cursor-pointer leading-none">
                    &times;
                </button>
            </div>
        </div>
    @endif

    <!-- Key Performance Metrics (Executive Classic KPI Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Gross Sales -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Gross Sales</span>
                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-50 text-[#53a318] border border-emerald-200">
                    +12.4%
                </span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight" title="৳{{ number_format($totalEarnings, 2) }}">
                    ৳{{ number_format($totalEarnings) }}
                </div>
                <p class="text-xs text-slate-500 mt-1">Solo & completed group revenue</p>
            </div>
        </div>

        <!-- 2. Active Group Buys -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Active Group Buys</span>
                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Live Pools
                </span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    {{ $activeGroupBuys }} <span class="text-sm font-semibold text-slate-500">Circles</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Buyers actively joining circles</p>
            </div>
        </div>

        <!-- 3. Fulfilled Teams -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Fulfilled Teams</span>
                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Unlocked
                </span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    {{ $completedGroupBuys }} <span class="text-sm font-semibold text-slate-500">Completed</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Successful volume wholesale orders</p>
            </div>
        </div>

        <!-- 4. Pending Dispatch -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Awaiting Dispatch</span>
                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                    Action Needed
                </span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    {{ $pendingOrdersCount }} <span class="text-sm font-semibold text-slate-500">Orders</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    <span class="font-semibold text-slate-700">{{ $shippedOrdersCount }} Shipped</span> • <span class="font-semibold text-slate-700">{{ $deliveredOrdersCount }} Delivered</span>
                </p>
            </div>
        </div>

    </div>

    <!-- Active Groups & Quick Actions Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Live Group Campaigns (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900">Active Group-Buying Circles</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Live pooling sessions requiring member quorum</p>
                </div>
                <a href="{{ route('seller.groups') }}" class="text-xs font-bold text-[#53a318] hover:underline inline-flex items-center space-x-1">
                    <span>View All Groups</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($activeGroups as $group)
                    <div class="p-3.5 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50/50 hover:bg-white transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3.5">
                        <div class="flex items-center space-x-3 min-w-0">
                            <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-12 h-12 rounded-lg object-contain bg-white border border-slate-200 flex-shrink-0 p-1">
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-slate-900 truncate block">{{ $group->product->title }}</span>
                                <div class="flex items-center space-x-2 mt-1 text-[11px] text-slate-500">
                                    <span class="font-mono font-semibold text-slate-700 bg-white border border-slate-200 px-1.5 py-0.2 rounded">{{ $group->group_code }}</span>
                                    <span>Leader: <strong class="text-slate-800 font-semibold">{{ $group->leader->name ?? 'Open Pool' }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 shrink-0">
                            <div class="text-right sm:min-w-[120px]">
                                <div class="flex items-center justify-end space-x-1 text-xs font-bold text-slate-900">
                                    <span class="text-[#53a318]">{{ $group->current_members }}</span>
                                    <span class="text-slate-400">/</span>
                                    <span>{{ $group->required_members }}</span>
                                    <span class="text-[10px] text-slate-500 font-normal">joined</span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="w-28 bg-slate-200 h-1.5 rounded-full overflow-hidden mt-1.5">
                                    <div class="h-full bg-[#53a318] rounded-full transition-all" 
                                         style="width: {{ $group->progress_percent }}%;"></div>
                                </div>
                            </div>

                            <a href="{{ route('seller.groups.show', $group) }}" 
                               class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:border-[#53a318] hover:text-[#53a318] text-slate-700 text-xs font-semibold transition-colors shadow-2xs">
                                Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-slate-700 font-bold">No live group circles right now.</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">When customers start or join team buys, they appear here.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Merchant Operations (1 Col, Classic Light Card) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-xs flex flex-col justify-between space-y-4">
            <div>
                <div class="pb-3 border-b border-slate-100">
                    <h2 class="text-sm sm:text-base font-bold text-slate-900">Merchant Operations</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Essential shortcuts to manage your store</p>
                </div>

                <div class="space-y-2.5 mt-4">
                    <!-- 1. Add Product -->
                    <a href="{{ route('seller.products.create') }}" 
                       class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#53a318] border border-emerald-200 flex items-center justify-center font-bold text-sm shrink-0">
                                +
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-900 block group-hover:text-[#53a318] transition-colors">List New Product</span>
                                <span class="text-[11px] text-slate-500">Configure wholesale price tiers</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <!-- 2. Dispatch Orders -->
                    <a href="{{ route('seller.orders') }}?status=processing" 
                       class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center font-bold text-xs shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-900 block group-hover:text-[#53a318] transition-colors">Dispatch Orders</span>
                                <span class="text-[11px] text-slate-500">{{ $pendingOrdersCount }} order(s) pending courier</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <!-- 3. Store Profile -->
                    <a href="{{ route('seller.profile') }}" 
                       class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center font-bold text-xs shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-900 block group-hover:text-[#53a318] transition-colors">Store Settings</span>
                                <span class="text-[11px] text-slate-500">Logo, banner, and warehouse</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                <span>Merchant Hub v2.0</span>
                <span class="text-[#53a318] font-semibold">Live Operational</span>
            </div>
        </div>

    </div>

    <!-- Recent Sales Table (Clean Enterprise B2B Table) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900">Recent Customer Purchases</h2>
                <p class="text-xs text-slate-500 mt-0.5">Real-time solo and group purchase activity</p>
            </div>
            <a href="{{ route('seller.orders') }}" class="text-xs font-bold text-[#53a318] hover:underline inline-flex items-center space-x-1">
                <span>Manage All Orders</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase tracking-wider text-[11px] font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-5">Product</th>
                        <th class="py-3 px-5">Customer</th>
                        <th class="py-3 px-5 whitespace-nowrap">Order ID</th>
                        <th class="py-3 px-5 whitespace-nowrap">Amount</th>
                        <th class="py-3 px-5 whitespace-nowrap">Type</th>
                        <th class="py-3 px-5 whitespace-nowrap">Status</th>
                        <th class="py-3 px-5 text-right whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($recentSales as $sale)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-5 flex items-center space-x-3">
                                <img src="{{ $sale->product->image_url }}" alt="{{ $sale->product->title }}" class="w-9 h-9 rounded-lg object-contain bg-white border border-slate-200 flex-shrink-0 p-0.5">
                                <span class="font-bold text-slate-900 line-clamp-1 max-w-xs">{{ $sale->product->title }}</span>
                            </td>
                            <td class="py-3.5 px-5 text-slate-700 font-medium">{{ $sale->order->user->name ?? $sale->order->shipping_name }}</td>
                            <td class="py-3.5 px-5 font-mono font-semibold text-slate-600 whitespace-nowrap">{{ $sale->order->order_number }}</td>
                            <td class="py-3.5 px-5 font-bold text-slate-900 whitespace-nowrap">৳{{ number_format($sale->subtotal) }}</td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold whitespace-nowrap {{ $sale->order->order_type === 'group_buy' ? 'bg-purple-50 text-purple-800 border border-purple-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                    @if($sale->order->order_type === 'group_buy')
                                        Group Deal
                                    @else
                                        Solo Buy
                                    @endif
                                </span>
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold whitespace-nowrap
                                    {{ $sale->order->order_status === 'processing' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 
                                      ($sale->order->order_status === 'shipped' ? 'bg-blue-50 text-blue-800 border border-blue-200' : 
                                      ($sale->order->order_status === 'delivered' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-700 border border-slate-200')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $sale->order->order_status)) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <a href="{{ route('seller.orders.show', $sale->order) }}" 
                                   class="text-[#53a318] hover:text-[#468c13] font-bold hover:underline inline-flex items-center space-x-1">
                                    <span>Fulfill</span>
                                    <span>&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400">
                                <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <p class="text-xs font-semibold text-slate-600">No sales recorded yet.</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">When customers purchase items or complete group deals, they appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
