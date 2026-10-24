@extends('layouts.admin')

@section('title', 'Manage Sellers & Approvals - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Sellers</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Merchant Network & Store Approvals</h1>
            
        </div>
    </div>

    <!-- 4 Summary Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        <!-- Total Sellers -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Merchants</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block">{{ $totalSellersCount }}</span>
                <span class="text-[11px] text-teal-600 font-semibold mt-1 block">Registered Vendors</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Pending Verification</span>
                <span class="text-2xl sm:text-3xl font-black {{ $pendingSellersCount > 0 ? 'text-amber-500 animate-pulse' : 'text-slate-900' }} mt-0.5 block">{{ $pendingSellersCount }}</span>
                <span class="text-[11px] text-amber-600 font-semibold mt-1 block">Awaiting Admin Review</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>

        <!-- Approved Stores -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Active Verified Stores</span>
                <span class="text-2xl sm:text-3xl font-black text-emerald-600 mt-0.5 block">{{ $approvedSellersCount }}</span>
                <span class="text-[11px] text-slate-400 font-medium mt-1 block">Live Marketplace Stores</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Suspended Stores -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Suspended / Inactive</span>
                <span class="text-2xl sm:text-3xl font-black text-rose-600 mt-0.5 block">{{ $suspendedSellersCount }}</span>
                <span class="text-[11px] text-slate-400 font-medium mt-1 block">Restricted Access</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mb-6 shadow-xs">
        <form action="{{ route('admin.sellers.index') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <div class="flex-1 relative">
                <input type="text" name="q" value="{{ request('q') }}" 
                       placeholder="Search store name, merchant owner, category, or email..." 
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-purple-600 focus:bg-white transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <select name="status" class="px-3 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-hidden focus:ring-2 focus:ring-purple-600">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Approvals</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved Stores</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended Stores</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected Applications</option>
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-xs transition-all flex items-center space-x-1.5 cursor-pointer">
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.sellers.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Sellers Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Merchant Store</th>
                        <th class="py-3.5 px-6">Owner & Contact</th>
                        <th class="py-3.5 px-6">Business Category</th>
                        <th class="py-3.5 px-6 text-center">Products</th>
                        <th class="py-3.5 px-6">Payout Method</th>
                        <th class="py-3.5 px-6 text-center">Approval Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sellers as $s)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl bg-teal-700 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-2xs">
                                        @if($s->avatar)
                                            <img src="{{ $s->avatar_url }}" alt="" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            {{ strtoupper(substr($s->shop_name ?? $s->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.sellers.show', $s) }}" class="font-bold text-slate-900 hover:text-purple-700 transition-colors block text-xs">
                                            {{ $s->shop_name ?? $s->name }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 font-mono block">ID: #{{ $s->id }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="space-y-0.5">
                                    <span class="text-slate-800 font-semibold block">{{ $s->name }}</span>
                                    <span class="text-slate-500 font-mono text-[11px] block">{{ $s->email }}</span>
                                    <span class="text-slate-400 font-mono text-[11px] block">{{ $s->phone ?? '—' }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $s->business_category ?? 'General Retail' }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center font-bold text-slate-800">
                                {{ $s->products_count }} items
                            </td>

                            <td class="py-4 px-6">
                                <div class="text-[11px]">
                                    <span class="font-bold text-slate-700 block">{{ $s->payout_method ?? 'bKash' }}</span>
                                    <span class="text-slate-400 font-mono truncate max-w-[140px] block">{{ $s->payout_details ?? 'Not configured' }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($s->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase tracking-wider animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mr-1.5"></span>
                                        Pending Approval
                                    </span>
                                @elseif($s->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5"></span>
                                        Approved Store
                                    </span>
                                @elseif($s->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-slate-200 text-slate-700 uppercase tracking-wider">
                                        Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase tracking-wider">
                                        Suspended
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('admin.sellers.show', $s) }}" 
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-purple-100 text-slate-700 hover:text-purple-800 font-bold text-[11px] transition-colors">
                                        View
                                    </a>

                                    @if($s->status === 'pending')
                                        <form action="{{ route('admin.sellers.approve', $s) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition-colors cursor-pointer">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.sellers.reject', $s) }}" method="POST" onsubmit="return confirm('Reject application for {{ $s->shop_name }}?');">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition-colors cursor-pointer">
                                                Reject
                                            </button>
                                        </form>
                                    @elseif($s->status === 'approved')
                                        <form action="{{ route('admin.sellers.toggle-status', $s) }}" method="POST" onsubmit="return confirm('Suspend merchant {{ $s->shop_name }}?');">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition-colors cursor-pointer">
                                                Suspend
                                            </button>
                                        </form>
                                    @elseif($s->status === 'suspended')
                                        <form action="{{ route('admin.sellers.toggle-status', $s) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[11px] transition-colors cursor-pointer">
                                                Restore
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <span class="font-bold text-slate-600 block text-sm">No merchants found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sellers->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $sellers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
