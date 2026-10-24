@extends('layouts.admin')

@section('title', 'Administrator Dashboard - Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1"> Administrator Dashboard</h1>

        </div>

        <!-- On-Demand Cron Trigger Button -->
        <div class="flex items-center space-x-3">
            <form action="{{ route('admin.trigger-check') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-md shadow-purple-700/20 transition-all flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4 animate-spin-reverse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Run Expiration Cron Task Now</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Banners for Actionable Pending Tasks -->
    @if($pendingSellersCount > 0 || $pendingRefundsCount > 0 || $openIssuesCount > 0)
        <div class="mb-8 grid grid-cols-1 sm:grid-cols-3 gap-3">
            @if($pendingSellersCount > 0)
                <a href="{{ route('admin.sellers.index', ['status' => 'pending']) }}" class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center justify-between text-xs font-bold hover:bg-amber-100 transition-colors">
                    <span class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>{{ $pendingSellersCount }} Seller Verification Awaiting</span>
                    </span>
                    <span class="text-amber-700 underline">Review</span>
                </a>
            @endif

            @if($pendingRefundsCount > 0)
                <a href="{{ route('admin.refunds', ['status' => 'pending']) }}" class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between text-xs font-bold hover:bg-rose-100 transition-colors">
                    <span class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        <span>{{ $pendingRefundsCount }} Refund Claims Pending</span>
                    </span>
                    <span class="text-rose-700 underline">Process</span>
                </a>
            @endif

            @if($openIssuesCount > 0)
                <a href="{{ route('admin.issues', ['status' => 'open']) }}" class="p-3.5 rounded-2xl bg-purple-50 border border-purple-200 text-purple-900 flex items-center justify-between text-xs font-bold hover:bg-purple-100 transition-colors">
                    <span class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                        <span>{{ $openIssuesCount }} Unresolved Dispute Tickets</span>
                    </span>
                    <span class="text-purple-700 underline">Resolve</span>
                </a>
            @endif
        </div>
    @endif

    <!-- 5 Core High-Level Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5 mb-10">
        <!-- GMV -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Gross Platform GMV</span>
            <div class="text-2xl font-black text-slate-900 mt-1 font-mono">৳{{ number_format($totalRevenue) }}</div>
            <span class="text-[10px] text-emerald-600 font-semibold mt-1 block">Paid orders</span>
        </div>

        <!-- Active Group Buys -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Active Group Buys</span>
            <div class="text-2xl font-black text-amber-500 mt-1">{{ $activeGroupsCount }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Live ticking sessions</span>
        </div>

        <!-- Completed Teams -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Completed Teams</span>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $completedGroupsCount }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Locked & fulfilled</span>
        </div>

        <!-- Shoppers / Sellers -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Shoppers / Sellers</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalCustomers }} / {{ $totalSellers }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Multi-Auth accounts</span>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Catalog Items</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalProducts }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Active merchant products</span>
        </div>
    </div>

    <!-- Quick Shortcuts Grid for 13 Modules -->
    <div class="mb-10">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-3">Operational Control Portals</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('admin.customers.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200/80 hover:border-purple-500 hover:shadow-xs transition-all text-center block group">
                <span class="text-xl block mb-1">👥</span>
                <span class="text-xs font-extrabold text-slate-800 group-hover:text-purple-700 block">Customers</span>
                <span class="text-[10px] text-slate-400 block">{{ $totalCustomers }} profiles</span>
            </a>

            <a href="{{ route('admin.sellers.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200/80 hover:border-purple-500 hover:shadow-xs transition-all text-center block group">
                <span class="text-xl block mb-1">🏪</span>
                <span class="text-xs font-extrabold text-slate-800 group-hover:text-purple-700 block">Sellers</span>
                <span class="text-[10px] text-slate-400 block">{{ $totalSellers }} stores</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200/80 hover:border-purple-500 hover:shadow-xs transition-all text-center block group">
                <span class="text-xl block mb-1">🏷️</span>
                <span class="text-xs font-extrabold text-slate-800 group-hover:text-purple-700 block">Categories</span>
                <span class="text-[10px] text-slate-400 block">Manage Taxonomies</span>
            </a>

            <a href="{{ route('admin.orders') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200/80 hover:border-purple-500 hover:shadow-xs transition-all text-center block group">
                <span class="text-xl block mb-1">🛒</span>
                <span class="text-xs font-extrabold text-slate-800 group-hover:text-purple-700 block">Orders</span>
                <span class="text-[10px] text-slate-400 block">{{ $totalOrders }} orders</span>
            </a>

            <a href="{{ route('admin.payments') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200/80 hover:border-purple-500 hover:shadow-xs transition-all text-center block group">
                <span class="text-xl block mb-1">💳</span>
                <span class="text-xs font-extrabold text-slate-800 group-hover:text-purple-700 block">Escrow</span>
                <span class="text-[10px] text-slate-400 block">Ledger & Payouts</span>
            </a>

            <a href="{{ route('admin.statistics') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200/80 hover:border-purple-500 hover:shadow-xs transition-all text-center block group">
                <span class="text-xl block mb-1">📊</span>
                <span class="text-xs font-extrabold text-slate-800 group-hover:text-purple-700 block">Analytics</span>
                <span class="text-[10px] text-slate-400 block">Growth Engine</span>
            </a>
        </div>
    </div>

    <!-- 2 Column Breakdown: Groups & Recent Purchases -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Live & Recent Group Sessions -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Live & Recent Group Sessions</h3>
                    <p class="text-xs text-slate-400">Real-time group buying ticking countdowns.</p>
                </div>
                <a href="{{ route('admin.groups') }}" class="text-xs font-bold text-purple-700 hover:underline">View All</a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($recentGroups as $grp)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50/50">
                        <div class="flex items-center space-x-3">
                            <span class="font-mono text-xs font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded">
                                #{{ $grp->group_code }}
                            </span>
                            <div>
                                <span class="text-xs font-bold text-slate-800 block line-clamp-1">{{ $grp->product->title ?? 'Product' }}</span>
                                <span class="text-[10px] text-slate-400">Leader: {{ $grp->leader->name ?? 'User' }} • {{ $grp->current_members }}/{{ $grp->required_members }} joined</span>
                            </div>
                        </div>
                        <div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $grp->status === 'active' ? 'bg-amber-100 text-amber-800' : ($grp->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800') }}">
                                {{ ucfirst($grp->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Customer Purchases -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Recent Customer Purchases</h3>
                    <p class="text-xs text-slate-400">Live transaction stream.</p>
                </div>
                <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-purple-700 hover:underline">View All</a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($recentOrders as $ord)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50/50">
                        <div>
                            <span class="font-mono text-xs font-bold text-slate-800 block">{{ $ord->order_number }}</span>
                            <span class="text-xs text-slate-500">{{ $ord->shipping_name ?? $ord->user->name }} • ৳{{ number_format($ord->total_amount) }}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $ord->order_status === 'processing' ? 'bg-blue-100 text-blue-800' : ($ord->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ ucfirst($ord->order_status) }}
                            </span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">{{ $ord->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
