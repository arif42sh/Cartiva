@extends('layouts.seller')

@section('title', 'Merchant Hub - Cartiva Seller Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">

    <!-- Shared Seller Navigation Header -->
    @include('seller.partials.nav')

    <!-- Notification Alert -->
    @if(session('success'))
        <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-2.5">
                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-xs flex-shrink-0"></span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 font-black text-base">&times;</button>
        </div>
    @endif

    @if($lowStockCount > 0)
        <div x-data="{ dismissed: sessionStorage.getItem('cartiva_dismiss_low_stock') === 'true' }" 
             x-show="!dismissed"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="mb-4 p-3 sm:p-3.5 rounded-xl bg-amber-50/90 border border-amber-200 text-amber-950 text-xs font-bold flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center space-x-2.5">
                <span class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center font-black text-xs flex-shrink-0 shadow-xs">!</span>
                <span class="text-xs sm:text-sm font-semibold text-amber-900">
                    Alert: You have <strong class="text-amber-950 font-black">{{ $lowStockCount }} product(s)</strong> with 5 or fewer items remaining in stock.
                </span>
            </div>
            <div class="flex items-center space-x-2 self-end sm:self-auto flex-shrink-0">
                <a href="{{ route('seller.products') }}?status=low_stock" 
                   class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition-colors shadow-xs text-xs flex items-center space-x-1">
                    <span>Restock Now</span>
                    <span>&rarr;</span>
                </a>
                <button type="button" 
                        @click="dismissed = true; sessionStorage.setItem('cartiva_dismiss_low_stock', 'true')" 
                        title="Dismiss alert for this session"
                        class="w-7 h-7 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 flex items-center justify-center font-black text-base transition-colors cursor-pointer leading-none">
                    &times;
                </button>
            </div>
        </div>
    @endif

    <!-- Key Performance Metrics (Executive High-Contrast KPI Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        
        <!-- Total Revenue -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-sm relative overflow-hidden group hover:shadow-md hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2.5">
                    <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Gross Sales</span>
                    <span class="w-9 h-9 rounded-2xl text-white flex items-center justify-center font-black text-base shadow-sm"
                          style="background: linear-gradient(135deg, #53a318 0%, #10b981 100%);">
                        ৳
                    </span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight truncate" title="৳{{ number_format($totalEarnings, 2) }}">
                    ৳{{ number_format($totalEarnings) }}
                </div>
            </div>
            <div class="flex items-center space-x-1.5 text-[11px] sm:text-xs font-bold text-emerald-700 mt-3 pt-2.5 border-t border-slate-100">
                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="truncate">Solo & completed group revenue</span>
            </div>
        </div>

        <!-- Active Group Sessions -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-sm relative overflow-hidden group hover:shadow-md hover:border-purple-300 transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2.5">
                    <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Active Group Buys</span>
                    <span class="w-9 h-9 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-bold text-base shadow-md shadow-purple-600/30">
                        👥
                    </span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-purple-700 tracking-tight">{{ $activeGroupBuys }}</div>
            </div>
            <div class="flex items-center space-x-1.5 text-[11px] sm:text-xs font-bold text-purple-700 mt-3 pt-2.5 border-t border-slate-100">
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse flex-shrink-0"></span>
                <span class="truncate">Circles pooling buyers right now</span>
            </div>
        </div>

        <!-- Completed Team Campaigns -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-sm relative overflow-hidden group hover:shadow-md hover:border-teal-300 transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2.5">
                    <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Fulfilled Teams</span>
                    <span class="w-9 h-9 rounded-2xl bg-teal-600 text-white flex items-center justify-center font-black text-base shadow-md shadow-teal-600/30">
                        ✓
                    </span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-teal-700 tracking-tight">{{ $completedGroupBuys }}</div>
            </div>
            <div class="flex items-center space-x-1.5 text-[11px] sm:text-xs font-bold text-teal-700 mt-3 pt-2.5 border-t border-slate-100">
                <span class="truncate">Successful completed team deals</span>
            </div>
        </div>

        <!-- Pending Order Dispatch -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-sm relative overflow-hidden group hover:shadow-md hover:border-amber-300 transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2.5">
                    <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Awaiting Dispatch</span>
                    <span class="w-9 h-9 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-bold text-base shadow-md shadow-amber-500/30">
                        📦
                    </span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-amber-600 tracking-tight">{{ $pendingOrdersCount }}</div>
            </div>
            <div class="flex items-center space-x-1.5 text-[11px] sm:text-xs font-bold text-slate-600 mt-3 pt-2.5 border-t border-slate-100">
                <span class="text-indigo-600 font-extrabold">{{ $shippedOrdersCount }} Shipped</span>
                <span>•</span>
                <span class="text-emerald-600 font-extrabold">{{ $deliveredOrdersCount }} Delivered</span>
            </div>
        </div>

    </div>

    <!-- Active Groups Realtime Strip & Quick Operations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Live Group Campaigns (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <div class="flex items-center space-x-2">
                        
                        <h3 class="text-base font-black text-slate-900 tracking-tight">Active Group-Buying Circles</h3>
                    </div>
                    
                </div>
                <a href="{{ route('seller.groups') }}" class="text-xs font-bold text-[#53a318] hover:underline flex items-center space-x-1">
                    <span>View All</span>
                    
                </a>
            </div>

            <div class="space-y-3.5">
                @forelse($activeGroups as $group)
                    <div class="p-4 rounded-2xl border border-slate-200 hover:border-[#53a318]/50 bg-slate-50/60 hover:bg-white transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-2xs">
                        <div class="flex items-center space-x-3.5">
                            <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-13 h-13 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0 shadow-xs">
                            <div>
                                <span class="text-xs font-black text-slate-900 line-clamp-1">{{ $group->product->title }}</span>
                                <div class="flex items-center space-x-2 mt-1 text-[11px] text-slate-500">
                                    <span class="font-mono font-bold text-slate-800 bg-white border border-slate-200 px-2 py-0.5 rounded shadow-2xs">{{ $group->group_code }}</span>
                                    <span>Leader: <strong class="text-slate-900 font-bold">{{ $group->leader->name ?? 'User' }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="text-right sm:min-w-[130px]">
                                <div class="flex items-center justify-end space-x-1 text-xs font-black text-slate-900">
                                    <span class="text-[#53a318]">{{ $group->current_members }}</span>
                                    <span>/</span>
                                    <span>{{ $group->required_members }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Joined</span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="w-28 bg-slate-200 h-2 rounded-full overflow-hidden mt-1.5">
                                    <div class="h-full rounded-full transition-all" 
                                         style="width: {{ $group->progress_percent }}%; background: linear-gradient(90deg, #10b981 0%, #53a318 100%);"></div>
                                </div>
                            </div>

                            <a href="{{ route('seller.groups.show', $group) }}" 
                               class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:border-[#53a318] hover:text-[#53a318] text-slate-800 text-xs font-bold transition-all shadow-2xs whitespace-nowrap">
                                Details 
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <span class="text-3xl block mb-2">⏳</span>
                        <p class="text-xs text-slate-700 font-extrabold">No live group circles right now.</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">When customers start a team buy, they will appear here in real time.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Inventory & Store Shortcuts (1 col) -->
        <div class="rounded-3xl p-6 text-white shadow-xl flex flex-col justify-between border border-slate-700/60"
             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#84cc16]">Quick Operations</span>
                <h3 class="text-lg font-black text-white mt-1">Merchant Action Hub</h3>
                <p class="text-xs text-slate-300 mt-1">Manage pricing tiers, restock items or fulfill customer orders.</p>

                <div class="space-y-3 mt-5">
                    <a href="{{ route('seller.products.create') }}" 
                       class="flex items-center justify-between p-3.5 rounded-2xl transition-all border border-white/10 hover:border-[#53a318]/50 hover:bg-white/10"
                       style="background-color: rgba(255, 255, 255, 0.05);">
                        <div class="flex items-center space-x-3">
                            <span class="w-9 h-9 rounded-xl text-white flex items-center justify-center font-black text-base shadow-sm"
                                  style="background-color: #53a318;">+</span>
                            <div>
                                <span class="text-xs font-extrabold text-white block">List New Product</span>
                                <span class="text-[10px] text-slate-300">With multi-tier group discounts</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('seller.orders') }}?status=processing" 
                       class="flex items-center justify-between p-3.5 rounded-2xl transition-all border border-white/10 hover:border-amber-400/50 hover:bg-white/10"
                       style="background-color: rgba(255, 255, 255, 0.05);">
                        <div class="flex items-center space-x-3">
                            <span class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-black text-sm shadow-sm">🚚</span>
                            <div>
                                <span class="text-xs font-extrabold text-white block">Dispatch Orders</span>
                                <span class="text-[10px] text-slate-300">{{ $pendingOrdersCount }} order(s) waiting for courier info</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('seller.profile') }}" 
                       class="flex items-center justify-between p-3.5 rounded-2xl transition-all border border-white/10 hover:border-purple-400/50 hover:bg-white/10"
                       style="background-color: rgba(255, 255, 255, 0.05);">
                        <div class="flex items-center space-x-3">
                            <span class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center font-black text-sm shadow-sm">🏪</span>
                            <div>
                                <span class="text-xs font-extrabold text-white block">Edit Store Profile</span>
                                <span class="text-[10px] text-slate-300">Banner, logo & business details</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
                <span>Cartiva Merchant v2.0</span>
                <span class="text-[#84cc16] font-bold">24/7 Seller Support</span>
            </div>
        </div>

    </div>

    <!-- Recent Sales Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-black text-slate-900">Recent Customer Purchases</h3>
               
            </div>
            <a href="{{ route('seller.orders') }}" class="text-xs font-bold text-[#53a318] hover:underline flex items-center space-x-1">
                <span>Manage All Orders</span>
             
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] font-black">
                    <tr>
                        <th class="py-3.5 px-6">Product</th>
                        <th class="py-3.5 px-6">Customer</th>
                        <th class="py-3.5 px-6 whitespace-nowrap">Order ID</th>
                        <th class="py-3.5 px-6 whitespace-nowrap">Amount</th>
                        <th class="py-3.5 px-6 whitespace-nowrap">Type</th>
                        <th class="py-3.5 px-6 whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-6 text-right whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($recentSales as $sale)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 flex items-center space-x-3.5">
                                <img src="{{ $sale->product->image_url }}" alt="{{ $sale->product->title }}" class="w-10 h-10 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                                <span class="font-bold text-slate-900 line-clamp-1 max-w-xs">{{ $sale->product->title }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-semibold">{{ $sale->order->user->name ?? $sale->order->shipping_name }}</td>
                            <td class="py-4 px-6 font-mono font-bold text-slate-600 whitespace-nowrap">{{ $sale->order->order_number }}</td>
                            <td class="py-4 px-6 font-black text-slate-900 text-sm whitespace-nowrap">${{ number_format($sale->subtotal, 2) }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold whitespace-nowrap {{ $sale->order->order_type === 'group_buy' ? 'bg-purple-50 text-purple-800 border border-purple-200 shadow-2xs' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                    @if($sale->order->order_type === 'group_buy')
                                        <svg class="w-3 h-3 mr-1 text-purple-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                                        <span>Team Buy</span>
                                    @else
                                        <svg class="w-3 h-3 mr-1 text-slate-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                        <span>Solo Buy</span>
                                    @endif
                                </span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black whitespace-nowrap
                                    {{ $sale->order->order_status === 'processing' ? 'bg-amber-100 text-amber-900 border border-amber-200' : 
                                      ($sale->order->order_status === 'shipped' ? 'bg-indigo-100 text-indigo-900 border border-indigo-200' : 
                                      ($sale->order->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : 'bg-slate-100 text-slate-700 border border-slate-200')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $sale->order->order_status)) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <a href="{{ route('seller.orders.show', $sale->order) }}" 
                                   class="text-[#53a318] hover:text-[#468c13] font-black hover:underline inline-flex items-center space-x-1">
                                    <span>Fulfill</span>
                                    
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-medium">
                                <span class="text-3xl block mb-2">🛒</span>
                                <p class="text-xs font-bold text-slate-600">No sales recorded yet.</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Promote your products to trigger group buys!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

