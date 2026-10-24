@extends('layouts.admin')

@section('title', $user->name . ' - Customer Details - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.customers.index') }}" class="hover:text-purple-600">Customers</a>
                <span>/</span>
                <span class="text-purple-700 font-mono">{{ $user->name }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Customer Profile & Lifecycle</h1>
             
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.customers.index') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to Customer List</span>
            </a>
        </div>
    </div>

    <!-- Customer Identity Card & Overview -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            
            <!-- Left: Avatar & Personal Info -->
            <div class="flex items-start sm:items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-purple-700 text-white font-black text-2xl flex items-center justify-center shadow-md flex-shrink-0">
                    @if($user->avatar)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-2xl">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="flex items-center space-x-2.5">
                        <h2 class="text-xl font-extrabold text-slate-900">{{ $user->name }}</h2>
                        @if($user->status === 'suspended')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 mr-1.5"></span>
                                Suspended
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5"></span>
                                Active Shopper
                            </span>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mt-1.5">
                        <span class="font-mono text-slate-700 font-semibold">{{ $user->email }}</span>
                        <span>•</span>
                        <span class="font-mono">{{ $user->phone ?? 'No mobile phone registered' }}</span>
                        <span>•</span>
                        <span>Joined {{ $user->created_at->format('M d, Y') }} ({{ $user->created_at->diffForHumans() }})</span>
                    </div>
                    @if($user->address)
                        <div class="text-xs text-slate-600 mt-2 flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $user->address }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Admin Status Switch Button -->
            <div class="flex items-center space-x-3 self-start md:self-center">
                <form action="{{ route('admin.customers.toggle-status', $user) }}" method="POST" onsubmit="return confirm('Confirm status update for {{ $user->name }}?');">
                    @csrf
                    @if($user->status === 'suspended')
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition-all flex items-center space-x-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Restore to Active</span>
                        </button>
                    @else
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md shadow-rose-600/20 transition-all flex items-center space-x-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            <span>Suspend Customer Account</span>
                        </button>
                    @endif
                </form>
            </div>

        </div>

        @if($user->status === 'suspended' && $user->status_reason)
            <div class="mt-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-900 font-medium">
                <strong>Suspension Note:</strong> {{ $user->status_reason }}
            </div>
        @endif
    </div>

    <!-- 4 Lifetime Performance Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        
        <!-- Total Spent -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Lifetime Purchases</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 block font-mono">৳{{ number_format($totalSpent) }}</span>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Excluding cancelled orders</span>
        </div>

        <!-- Total Group Savings -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Unlocked Group Savings</span>
            <span class="text-2xl sm:text-3xl font-black text-[#53a318] mt-1 block font-mono">৳{{ number_format($totalSavings) }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Saved via Team-Buying</span>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Orders Completed</span>
            <span class="text-2xl sm:text-3xl font-black text-indigo-600 mt-1 block">{{ $ordersCount }}</span>
            <span class="text-[11px] text-slate-400 font-medium mt-1 block">Lifetime orders count</span>
        </div>

        <!-- Groups Participated -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Group Buying Sessions</span>
            <span class="text-2xl sm:text-3xl font-black text-purple-600 mt-1 block">{{ $groupsCount }}</span>
            <span class="text-[11px] text-purple-700 font-semibold mt-1 block">Active & Completed Pools</span>
        </div>

    </div>

    <!-- Section 1: Customer's Orders History -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden mb-10">
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Orders History</h3>
                <p class="text-xs text-slate-400">All direct solo and group buying orders placed by this customer.</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                {{ $ordersCount }} Total Orders
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-6">Order #</th>
                        <th class="py-3 px-6">Type</th>
                        <th class="py-3 px-6">Items Preview</th>
                        <th class="py-3 px-6 text-right">Total Amount</th>
                        <th class="py-3 px-6 text-center">Payment</th>
                        <th class="py-3 px-6 text-center">Fulfillment Status</th>
                        <th class="py-3 px-6 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-6 font-mono font-bold text-slate-900">
                                {{ $order->order_number }}
                            </td>
                            <td class="py-3.5 px-6">
                                @if($order->order_type === 'group_buy')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-800 uppercase">
                                        Team Buy
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">
                                        Solo Buy
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6">
                                @if($order->items->isNotEmpty())
                                    <div class="flex items-center space-x-2">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                            @if($order->items->first()->product && $order->items->first()->product->image_url)
                                                <img src="{{ $order->items->first()->product->image_url }}" alt="" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <span class="truncate max-w-[200px] text-slate-800 font-semibold">
                                            {{ $order->items->first()->product->title ?? 'Product' }}
                                            @if($order->items->count() > 1)
                                                <span class="text-slate-400 font-normal">+{{ $order->items->count() - 1 }} more</span>
                                            @endif
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-right font-mono font-bold text-slate-900">
                                ৳{{ number_format($order->total_amount) }}
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'delivered' => 'bg-emerald-100 text-emerald-800',
                                        'cancelled' => 'bg-rose-100 text-rose-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusColors[$order->order_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right text-slate-500 font-mono text-[11px]">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 font-medium">
                                No orders placed yet by this customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentOrders->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $recentOrders->links() }}
            </div>
        @endif
    </div>

    <!-- Section 2: Group Buying Sessions Joined -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Group Buying Participation</h3>
                <p class="text-xs text-slate-400">All team-buying sessions this customer has participated in or initiated.</p>
            </div>
            <span class="text-xs font-bold text-purple-700 bg-purple-50 px-3 py-1 rounded-full">
                {{ $groupsCount }} Group Sessions
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-6">Group Code</th>
                        <th class="py-3 px-6">Product</th>
                        <th class="py-3 px-6 text-center">Customer Role</th>
                        <th class="py-3 px-6 text-center">Slots Progress</th>
                        <th class="py-3 px-6 text-center">Session Status</th>
                        <th class="py-3 px-6 text-right">Joined At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($groupMemberships as $membership)
                        @php $sess = $membership->session; @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-6 font-mono font-bold text-purple-900">
                                @if($sess)
                                    <a href="{{ route('admin.groups') }}" class="hover:underline">
                                        #{{ $sess->group_code }}
                                    </a>
                                @else
                                    #{{ $membership->group_buy_session_id }}
                                @endif
                            </td>
                            <td class="py-3.5 px-6 font-semibold text-slate-800">
                                {{ $sess->product->title ?? 'Product Removed' }}
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                @if($sess && $sess->leader_user_id === $user->id)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-900 uppercase">
                                        Group Leader
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">
                                        Member
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-center font-bold">
                                @if($sess)
                                    <span class="font-mono text-purple-700">{{ $sess->current_buyers_count }}/{{ $sess->required_buyers_count }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                @if($sess)
                                    @if($sess->status === 'completed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                            Completed
                                        </span>
                                    @elseif($sess->status === 'active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-800 uppercase animate-pulse">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 uppercase">
                                            {{ $sess->status }}
                                        </span>
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-right text-slate-500 font-mono text-[11px]">
                                {{ $membership->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                                This customer has not joined any group sessions yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($groupMemberships->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $groupMemberships->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
