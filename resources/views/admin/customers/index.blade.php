@extends('layouts.admin')

@section('title', 'Manage Customers - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Customers</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Customer Management & Insights</h1>
           
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Unified User Directory</span>
            </a>
        </div>
    </div>

    <!-- 4 Key Stat Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        <!-- Total Customers -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Customers</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block">{{ number_format($totalCustomersCount) }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-flex items-center">
                    <span>Registered Shoppers</span>
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <!-- Active Shoppers -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Active Status</span>
                <span class="text-2xl sm:text-3xl font-black text-emerald-600 mt-0.5 block">{{ number_format($activeCustomersCount) }}</span>
                <span class="text-[11px] text-slate-400 font-medium mt-1 block">
                    {{ $suspendedCustomersCount }} Suspended
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Total Orders Placed -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Customer Orders</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block">{{ number_format($totalOrdersCount) }}</span>
                <span class="text-[11px] text-indigo-600 font-semibold mt-1 inline-flex items-center">
                    <span>Solo & Team Buy</span>
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>

        <!-- Total Customer Spend -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Customer Lifetime Spend</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block font-mono">৳{{ number_format($totalCustomerSpend) }}</span>
                <span class="text-[11px] text-slate-500 font-medium mt-1 block">Net customer volume</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 font-bold text-lg">
                ৳
            </div>
        </div>
    </div>

    <!-- Filter and Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mb-6 shadow-xs">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            
            <!-- Search Query Input -->
            <div class="flex-1 relative">
                <input type="text" name="q" value="{{ request('q') }}" 
                       placeholder="Search by customer name, email address, or mobile phone..." 
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-purple-600 focus:bg-white transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <!-- Status Filter -->
                <select name="status" class="px-3 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-hidden focus:ring-2 focus:ring-purple-600">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Customers</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended Customers</option>
                </select>

                <!-- Sorting -->
                <select name="sort" class="px-3 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-hidden focus:ring-2 focus:ring-purple-600">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest Registered</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest Registered</option>
                </select>

                <!-- Submit Filter -->
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-xs transition-all flex items-center space-x-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['q', 'status', 'sort']))
                    <a href="{{ route('admin.customers.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Customer Profile</th>
                        <th class="py-3.5 px-6">Contact & Location</th>
                        <th class="py-3.5 px-6 text-center">Orders Placed</th>
                        <th class="py-3.5 px-6 text-center">Groups Joined</th>
                        <th class="py-3.5 px-6 text-right">Lifetime Spend</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $c)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <!-- Customer Profile -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl bg-purple-700 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-2xs">
                                        @if($c->avatar)
                                            <img src="{{ $c->avatar_url }}" alt="{{ $c->name }}" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            {{ strtoupper(substr($c->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.customers.show', $c) }}" class="font-bold text-slate-900 hover:text-purple-700 transition-colors block text-xs">
                                            {{ $c->name }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 font-mono block">{{ $c->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact & Location -->
                            <td class="py-4 px-6">
                                <div class="space-y-0.5">
                                    <span class="text-slate-700 font-medium font-mono text-[11px] block">{{ $c->phone ?? 'No phone' }}</span>
                                    <span class="text-slate-400 text-[11px] truncate max-w-[180px] block">{{ $c->address ?? 'No address' }}</span>
                                </div>
                            </td>

                            <!-- Orders Placed -->
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">
                                    {{ $c->orders_count }} orders
                                </span>
                            </td>

                            <!-- Groups Joined -->
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700">
                                    {{ $c->group_memberships_count }} groups
                                </span>
                            </td>

                            <!-- Lifetime Spend -->
                            <td class="py-4 px-6 text-right font-mono font-bold text-slate-900">
                                ৳{{ number_format($c->total_spent) }}
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-6 text-center">
                                @if($c->status === 'suspended')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 mr-1.5"></span>
                                        Suspended
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5"></span>
                                        Active
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- View Details Button -->
                                    <a href="{{ route('admin.customers.show', $c) }}" 
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-purple-100 text-slate-700 hover:text-purple-800 font-bold text-[11px] transition-colors"
                                       title="View Full Profile & Order History">
                                        Details
                                    </a>

                                    <!-- Suspend / Activate Toggle -->
                                    <form action="{{ route('admin.customers.toggle-status', $c) }}" method="POST" onsubmit="return confirm('Are you sure you want to change the status of {{ $c->name }}?');">
                                        @csrf
                                        @if($c->status === 'suspended')
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[11px] transition-colors cursor-pointer" title="Restore Account">
                                                Activate
                                            </button>
                                        @else
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition-colors cursor-pointer" title="Suspend Account">
                                                Suspend
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span class="font-bold text-slate-600 block text-sm">No customers matched your criteria</span>
                                <span class="text-xs text-slate-400 mt-1 block">Try clearing the search query or status filter.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
