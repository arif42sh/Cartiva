@extends('layouts.admin')

@section('title', 'Manage Refund Requests - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Refunds</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Refund Claims & Reversal Management</h1>
            <p class="text-xs text-slate-500 mt-1">Review expired group buy claims, defective item returns, and process bKash / Nagad wallet refunds.</p>
        </div>
    </div>

    <!-- 3 Summary Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Refund Claims</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block">{{ $totalRefundsCount }}</span>
            <span class="text-[11px] text-slate-400 font-medium mt-1 block">Group failure & customer returns</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Pending Claims</span>
            <span class="text-2xl sm:text-3xl font-black text-amber-500 mt-0.5 block">{{ $pendingRefundsCount }}</span>
            <span class="text-[11px] text-amber-600 font-semibold mt-1 block">Awaiting payment verification</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Refunded Volume</span>
            <span class="text-2xl sm:text-3xl font-black text-rose-600 mt-0.5 block font-mono">৳{{ number_format($totalRefundedAmount) }}</span>
            <span class="text-[11px] text-rose-700 font-semibold mt-1 block">Returned to shoppers</span>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="flex items-center space-x-2 mb-6 text-xs font-bold">
        <a href="{{ route('admin.refunds') }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ !request('status') ? 'bg-purple-700 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">All Claims</a>
        <a href="{{ route('admin.refunds', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Pending ({{ $pendingRefundsCount }})</a>
        <a href="{{ route('admin.refunds', ['status' => 'approved']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'approved' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Approved</a>
        <a href="{{ route('admin.refunds', ['status' => 'rejected']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'rejected' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Rejected</a>
    </div>

    <!-- Refunds Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Claim ID</th>
                        <th class="py-3.5 px-6">Order #</th>
                        <th class="py-3.5 px-6">Shopper</th>
                        <th class="py-3.5 px-6">Claim Reason & Type</th>
                        <th class="py-3.5 px-6 text-right">Refund Amount</th>
                        <th class="py-3.5 px-6">Payout Destination</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($refunds as $ref)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                #REF-{{ $ref->id }}
                            </td>

                            <td class="py-4 px-6 font-mono font-bold text-purple-700">
                                <a href="{{ route('admin.orders.show', $ref->order) }}" class="hover:underline">
                                    {{ $ref->order->order_number ?? 'Order' }}
                                </a>
                            </td>

                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $ref->user->name ?? 'Shopper' }}
                            </td>

                            <td class="py-4 px-6 max-w-xs">
                                <span class="font-bold text-slate-800 block text-[11px]">{{ ucfirst(str_replace('_', ' ', $ref->type)) }}</span>
                                <span class="text-slate-400 text-[11px] block line-clamp-1">{{ $ref->reason }}</span>
                            </td>

                            <td class="py-4 px-6 text-right font-mono font-black text-rose-600 text-sm">
                                ৳{{ number_format($ref->amount) }}
                            </td>

                            <td class="py-4 px-6">
                                <div class="text-[11px]">
                                    <span class="font-bold text-slate-700 block">{{ $ref->payout_method }}</span>
                                    <span class="text-slate-400 font-mono block">{{ $ref->payout_account ?? 'Original Account' }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($ref->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase animate-pulse">
                                        Pending
                                    </span>
                                @elseif($ref->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase">
                                        Rejected
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                @if($ref->status === 'pending')
                                    <div class="flex items-center justify-end space-x-1.5">
                                        <form action="{{ route('admin.refunds.approve', $ref) }}" method="POST" onsubmit="return confirm('Approve refund of ৳{{ $ref->amount }}?');">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition-colors cursor-pointer">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.refunds.reject', $ref) }}" method="POST" onsubmit="return confirm('Reject this refund request?');">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition-colors cursor-pointer">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-slate-400 font-mono text-[11px]">Completed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">No refund requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($refunds->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $refunds->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
