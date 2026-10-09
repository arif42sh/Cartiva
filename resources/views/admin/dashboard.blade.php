@extends('layouts.app')

@section('title', 'Admin Overview - Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-purple-600 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-purple-700">Platform Command Center</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">Cartiva Administrator Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1">Multi-Auth oversight, real-time group sessions monitor, and cron automation.</p>
        </div>

        <!-- On-Demand Cron Trigger Button -->
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <form action="{{ route('admin.trigger-check') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-md shadow-purple-700/20 transition-all flex items-center space-x-2">
                    <svg class="w-4 h-4 animate-spin-reverse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Run Expiration Cron Task Now</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Navigation Pills -->
    <div class="flex items-center space-x-2 border-b border-slate-200 pb-4 mb-8 text-xs font-bold">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-purple-100 text-purple-900">Overview</a>
        <a href="{{ route('admin.groups') }}" class="px-4 py-2 rounded-xl hover:bg-slate-100 text-slate-600">All Group Sessions</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-xl hover:bg-slate-100 text-slate-600">User Management</a>
        <a href="{{ route('admin.products') }}" class="px-4 py-2 rounded-xl hover:bg-slate-100 text-slate-600">Platform Catalog</a>
    </div>

    <!-- System Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-10">
        
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Gross Platform GMV</span>
            <div class="text-2xl font-black text-slate-900 mt-1">${{ number_format($totalRevenue, 2) }}</div>
            <span class="text-[10px] text-emerald-600 font-semibold mt-1 block">Paid orders</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Group Buys</span>
            <div class="text-2xl font-black text-amber-500 mt-1">{{ $activeGroupsCount }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Live ticking sessions</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Completed Teams</span>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $completedGroupsCount }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Locked & fulfilled</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Shoppers / Sellers</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalCustomers }} / {{ $totalSellers }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Registered accounts</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Products</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalProducts }}</div>
            <span class="text-[10px] text-slate-400 font-medium mt-1 block">Active catalog items</span>
        </div>

    </div>

    <!-- 2 Column Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Group Buys -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-900">Live & Recent Group Sessions</h3>
                <a href="{{ route('admin.groups') }}" class="text-xs font-bold text-purple-600 hover:underline">View All &rarr;</a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($recentGroups as $grp)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50/50">
                        <div class="flex items-center space-x-3">
                            <span class="font-mono text-xs font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded">
                                {{ $grp->group_code }}
                            </span>
                            <div>
                                <span class="text-xs font-bold text-slate-800 block line-clamp-1">{{ $grp->product->title }}</span>
                                <span class="text-[10px] text-slate-400">Leader: {{ $grp->leader->name }} • {{ $grp->current_members }}/{{ $grp->required_members }} joined</span>
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

        <!-- Recent Orders -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-900">Recent Customer Purchases</h3>
                <span class="text-xs font-semibold text-slate-400">{{ $totalOrders }} total orders</span>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($recentOrders as $ord)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50/50">
                        <div>
                            <span class="font-mono text-xs font-bold text-slate-800">{{ $ord->order_number }}</span>
                            <span class="text-xs text-slate-500 block">{{ $ord->shipping_name }} • ${{ number_format($ord->total_amount, 2) }}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $ord->order_status === 'processing' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $ord->order_status)) }}
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
