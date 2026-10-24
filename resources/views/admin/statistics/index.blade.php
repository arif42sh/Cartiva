@extends('layouts.admin')

@section('title', 'Platform Analytics & Growth Statistics - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Statistics</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Executive Analytics & Growth Engine</h1>
            <p class="text-xs text-slate-500 mt-1">Deep insights into group buying viral coefficient, total buyer savings, GMV growth, and top-tier stores.</p>
        </div>
    </div>

    <!-- 4 High-Level KPI Cards (SRS 4.4.xi) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        <!-- GMV -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Gross Merchandise Value (GMV)</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block font-mono">৳{{ number_format($totalGMV) }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Paid platform sales</span>
        </div>

        <!-- Group Success Rate -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Group Buying Success Rate</span>
            <span class="text-2xl sm:text-3xl font-black text-purple-700 mt-0.5 block">{{ $groupSuccessRate }}%</span>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">{{ $completedGroups }} of {{ $totalGroups }} pools completed</span>
        </div>

        <!-- Total Customer Savings -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Customer Group Savings</span>
            <span class="text-2xl sm:text-3xl font-black text-[#53a318] mt-0.5 block font-mono">৳{{ number_format($totalCustomerSavings) }}</span>
            <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">Saved by shoppers via team deals</span>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Orders Executed</span>
            <span class="text-2xl sm:text-3xl font-black text-indigo-600 mt-0.5 block">{{ number_format($totalOrders) }}</span>
            <span class="text-[11px] text-indigo-700 font-semibold mt-1 block">Solo + Team checkouts</span>
        </div>
    </div>

    <!-- 2 Column Breakdown Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Top Selling Products -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Best Selling Products</h3>
                    <p class="text-xs text-slate-400">Items generating the highest team-buy transactions.</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($topProducts as $prod)
                    <div class="p-4.5 flex items-center justify-between hover:bg-slate-50/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                                <img src="{{ $prod->image_url }}" alt="" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block text-xs line-clamp-1">{{ $prod->title }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">★ {{ $prod->rating }} • ৳{{ number_format($prod->group_price) }} team price</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-black text-purple-700 block">{{ $prod->sales_count }} sold</span>
                            <span class="text-[10px] text-slate-400 block font-mono">{{ $prod->stock }} in stock</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">No products sold yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Top Performing Stores -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Top Performing Merchants</h3>
                    <p class="text-xs text-slate-400">Stores with largest catalog and highest compliance.</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($topSellers as $seller)
                    <div class="p-4.5 flex items-center justify-between hover:bg-slate-50/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-teal-800 text-white font-black text-sm flex items-center justify-center flex-shrink-0">
                                {{ strtoupper(substr($seller->shop_name ?? $seller->name, 0, 1)) }}
                            </div>
                            <div>
                                <a href="{{ route('admin.sellers.show', $seller) }}" class="font-bold text-slate-900 hover:text-purple-700 block text-xs">
                                    {{ $seller->shop_name ?? $seller->name }}
                                </a>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $seller->business_category ?? 'General Retail' }} • {{ $seller->products_count }} products</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $seller->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $seller->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">No merchants found.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
