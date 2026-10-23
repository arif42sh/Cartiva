@extends('layouts.seller')

@section('title', 'Sales Analytics & Reports - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Sales Analytics & Campaign Performance</h1>
        <p class="text-xs text-slate-500 mt-0.5">High-density revenue metrics, viral team-buy success rates, and top revenue drivers.</p>
    </div>

    <!-- Top Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <div class="bg-white rounded-3xl border border-slate-200 p-5.5 shadow-sm">
            <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Gross Sales Revenue</span>
            <div class="text-3xl font-black text-slate-900 tracking-tight mt-1.5">${{ number_format($totalRevenue, 2) }}</div>
            <span class="text-[11px] font-bold text-[#53a318] mt-1 block">From confirmed & shipped orders</span>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-5.5 shadow-sm">
            <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Total Units Dispatched</span>
            <div class="text-3xl font-black text-indigo-600 tracking-tight mt-1.5">{{ number_format($totalUnitsSold) }} Units</div>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Across all product lines</span>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-5.5 shadow-sm">
            <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Group Success Rate</span>
            <div class="text-3xl font-black text-emerald-600 tracking-tight mt-1.5">{{ $completionRate }}%</div>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">{{ $successfulSessions }} of {{ $totalSessions }} circles unlocked</span>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-5.5 shadow-sm">
            <span class="text-[11px] font-black text-slate-500 uppercase tracking-wider">Active Campaigns</span>
            <div class="text-3xl font-black text-amber-500 tracking-tight mt-1.5">{{ $totalSessions - $successfulSessions }}</div>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Circles currently active/expired</span>
        </div>

    </div>

    <!-- Revenue Split: Group Buy vs Solo Buying -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Revenue Breakdown Card (1 col) -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-3 mb-4">
                    Sales Channel Split
                </h3>

                <div class="space-y-4">
                    <!-- Group Buy Share -->
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold mb-1">
                            <span class="text-purple-900 flex items-center space-x-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                                <span>Team Buy Revenue</span>
                            </span>
                            <span class="text-purple-700 font-black">${{ number_format($groupRevenue, 2) }}</span>
                        </div>
                        @php
                            $groupPct = $totalRevenue > 0 ? round(($groupRevenue / $totalRevenue) * 100) : 0;
                        @endphp
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-purple-600 h-full rounded-full transition-all" style="width: {{ $groupPct }}%"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $groupPct }}% of total marketplace sales</span>
                    </div>

                    <!-- Solo Buy Share -->
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800 flex items-center space-x-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                                <span>Solo Direct Buy Revenue</span>
                            </span>
                            <span class="text-slate-700 font-black">${{ number_format($soloRevenue, 2) }}</span>
                        </div>
                        @php
                            $soloPct = $totalRevenue > 0 ? round(($soloRevenue / $totalRevenue) * 100) : 0;
                        @endphp
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-slate-400 h-full rounded-full transition-all" style="width: {{ $soloPct }}%"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $soloPct }}% of total marketplace sales</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-950 font-medium">
                💡 <strong>Merchant Insight:</strong> Products with 20%+ group discounts typically achieve 3.4x faster checkout velocity than solo listings.
            </div>
        </div>

        <!-- Top Selling Products Leaderboard (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">
                    Top 5 Revenue Drivers
                </h3>
                <span class="text-xs text-slate-400 font-medium">Ranked by gross customer payments</span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($topProducts as $idx => $prod)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center space-x-3.5">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 font-black text-xs flex items-center justify-center flex-shrink-0">
                                #{{ $idx + 1 }}
                            </span>
                            <img src="{{ $prod->image_url }}" alt="{{ $prod->title }}" class="w-11 h-11 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                            <div>
                                <h4 class="text-xs font-extrabold text-slate-900 line-clamp-1">{{ $prod->title }}</h4>
                                <div class="flex items-center space-x-2 text-[11px] text-slate-500 mt-0.5">
                                    <span>Solo: ${{ number_format($prod->single_price, 2) }}</span>
                                    <span>•</span>
                                    <span class="text-emerald-600 font-bold">Group: ${{ number_format($prod->group_price, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="text-sm font-black text-slate-900 block">${{ number_format($prod->gross_sales ?? 0, 2) }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold">{{ $prod->total_orders ?? 0 }} Orders</span>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400">
                        <span class="text-2xl block mb-1">📊</span>
                        No product sales records yet to rank.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
