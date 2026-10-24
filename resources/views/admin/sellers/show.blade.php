@extends('layouts.admin')

@section('title', ($user->shop_name ?? $user->name) . ' - Merchant Store Profile - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.sellers.index') }}" class="hover:text-purple-600">Sellers</a>
                <span>/</span>
                <span class="text-purple-700 font-mono">{{ $user->shop_name ?? $user->name }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Merchant Verification & Store Profile</h1>
             
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.sellers.index') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to Merchant List</span>
            </a>
            @if($user->shop_slug)
                <a href="{{ route('shop.show', $user->shop_slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 text-xs font-bold transition-all flex items-center space-x-1.5">
                    <span>Preview Storefront</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            @endif
        </div>
    </div>

    <!-- Merchant Store Header Banner & Profile Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden mb-8">
        @if($user->shop_banner)
            <div class="h-32 sm:h-44 w-full bg-slate-800 overflow-hidden relative">
                <img src="{{ $user->banner_url }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            </div>
        @else
            <div class="h-24 w-full bg-gradient-to-r from-teal-800 to-slate-900"></div>
        @endif

        <div class="p-6 sm:p-8 relative">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center space-x-4">
                    <div class="w-16 h-16 rounded-2xl bg-teal-700 border-2 border-white shadow-lg text-white font-black text-2xl flex items-center justify-center flex-shrink-0 -mt-10 sm:-mt-12 bg-white">
                        @if($user->avatar)
                            <img src="{{ $user->avatar_url }}" alt="" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <span class="text-teal-800">{{ strtoupper(substr($user->shop_name ?? $user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center space-x-2.5">
                            <h2 class="text-xl font-extrabold text-slate-900">{{ $user->shop_name ?? $user->name }}</h2>
                            @if($user->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                    Approved & Verified
                                </span>
                            @elseif($user->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase animate-pulse">
                                    Pending Approval
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase">
                                    {{ ucfirst($user->status) }}
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mt-1.5">
                            <span>Owner: <strong class="text-slate-800">{{ $user->name }}</strong></span>
                            <span>•</span>
                            <span class="font-mono text-slate-700">{{ $user->email }}</span>
                            <span>•</span>
                            <span class="font-mono">{{ $user->phone ?? 'No phone' }}</span>
                            <span>•</span>
                            <span>Registered {{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Admin Action Buttons -->
                <div class="flex items-center space-x-2.5 self-start md:self-center">
                    @if($user->status === 'pending')
                        <form action="{{ route('admin.sellers.approve', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all cursor-pointer">
                                Approve Store Now
                            </button>
                        </form>
                        <form action="{{ route('admin.sellers.reject', $user) }}" method="POST" onsubmit="return confirm('Reject application for {{ $user->shop_name }}?');">
                            @csrf
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition-all cursor-pointer">
                                Reject Application
                            </button>
                        </form>
                    @elseif($user->status === 'approved')
                        <form action="{{ route('admin.sellers.toggle-status', $user) }}" method="POST" onsubmit="return confirm('Suspend merchant {{ $user->shop_name }}?');">
                            @csrf
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md transition-all cursor-pointer">
                                Suspend Merchant
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.sellers.toggle-status', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all cursor-pointer">
                                Restore Merchant
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 3 Metrics & Logistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Performance Metrics -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-4">Sales & Performance</h3>
            <div class="space-y-4">
                <div>
                    <span class="text-xs text-slate-500 block">Gross Sales (GMV)</span>
                    <span class="text-2xl font-black text-slate-900 font-mono">৳{{ number_format($grossSales) }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Orders Fulfilled</span>
                    <span class="text-xl font-extrabold text-emerald-600">{{ $ordersFulfilledCount }} delivered</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Live Catalog Products</span>
                    <span class="text-xl font-extrabold text-teal-700">{{ $totalProductsCount }} products</span>
                </div>
            </div>
        </div>

        <!-- Logistics & Shipping -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-4">Warehouse & Dispatch</h3>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block font-semibold">Warehouse Address:</span>
                    <span class="text-slate-800 font-medium">{{ $user->warehouse_address ?? $user->address ?? 'Not specified' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Dispatch Window:</span>
                    <span class="text-slate-800 font-medium">{{ $user->dispatch_time ?? 'Within 24 Hours' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Return Policy:</span>
                    <span class="text-slate-800 font-medium">{{ $user->return_policy ?? '7 Days Easy Return' }}</span>
                </div>
            </div>
        </div>

        <!-- Payout Method & Wallet -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-4">Settlement & Payout</h3>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block font-semibold">Payout Gateway:</span>
                    <span class="text-base font-bold text-slate-900 block mt-0.5">{{ $user->payout_method ?? 'bKash Merchant' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Wallet Account Details:</span>
                    <span class="text-slate-800 font-mono font-bold">{{ $user->payout_details ?? 'Pending Setup' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Commission Split:</span>
                    <span class="text-emerald-700 font-bold">95% Merchant / 5% Cartiva Escrow</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Catalog Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Store Products ({{ $totalProductsCount }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-6">Product</th>
                        <th class="py-3 px-6">Category</th>
                        <th class="py-3 px-6 text-right">Single Price</th>
                        <th class="py-3 px-6 text-right">Group Price</th>
                        <th class="py-3 px-6 text-center">Stock</th>
                        <th class="py-3 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $p)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3.5 px-6 font-bold text-slate-900 flex items-center space-x-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                    <img src="{{ $p->image_url }}" alt="" class="w-full h-full object-cover">
                                </div>
                                <span class="line-clamp-1">{{ $p->title }}</span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-600">{{ $p->category->name ?? 'General' }}</td>
                            <td class="py-3.5 px-6 text-right font-mono text-slate-500">৳{{ number_format($p->single_price) }}</td>
                            <td class="py-3.5 px-6 text-right font-mono font-bold text-[#53a318]">৳{{ number_format($p->group_price) }}</td>
                            <td class="py-3.5 px-6 text-center font-bold {{ $p->stock <= 5 ? 'text-rose-600' : 'text-slate-700' }}">{{ $p->stock }}</td>
                            <td class="py-3.5 px-6 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $p->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $p->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No products uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
