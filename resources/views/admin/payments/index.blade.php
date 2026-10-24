@extends('layouts.admin')

@section('title', 'Monitor Payments & Escrow Ledger - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Payments & Escrow </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Cartiva Escrow & Financial Ledger</h1>
            <p class="text-xs text-slate-500 mt-1">Real-time escrow holding pool, vendor payouts audit, and platform commission tracking.</p>
        </div>
    </div>

    <!-- 4 Financial Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        <!-- Gross Platform Volume -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Gross Platform Volume</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block font-mono">৳{{ number_format($grossVolume) }}</span>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Total customer transactions</span>
        </div>

        <!-- Held in Escrow -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Held in Escrow Pool</span>
            <span class="text-2xl sm:text-3xl font-black text-amber-500 mt-0.5 block font-mono">৳{{ number_format($heldInEscrow) }}</span>
            <span class="text-[11px] text-amber-700 font-semibold mt-1 block">Secured during shipment</span>
        </div>

        <!-- Released to Merchants -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Settled to Merchants</span>
            <span class="text-2xl sm:text-3xl font-black text-emerald-600 mt-0.5 block font-mono">৳{{ number_format($releasedToSellers) }}</span>
            <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">Delivered orders paid out</span>
        </div>

        <!-- Platform Commission -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Platform Net Revenue</span>
            <span class="text-2xl sm:text-3xl font-black text-purple-700 mt-0.5 block font-mono">৳{{ number_format($platformFee) }}</span>
            <span class="text-[11px] text-purple-700 font-semibold mt-1 block">5% Marketplace take-rate</span>
        </div>
    </div>

    <!-- Escrow Ledger Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Live Escrow Transactions Ledger</h3>
                <p class="text-xs text-slate-400">Customer payments protected in escrow until order delivery is verified.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Order #</th>
                        <th class="py-3.5 px-6">Shopper</th>
                        <th class="py-3.5 px-6">Merchant Store</th>
                        <th class="py-3.5 px-6 text-right">Order Amount</th>
                        <th class="py-3.5 px-6">Gateway</th>
                        <th class="py-3.5 px-6 text-center">Escrow Status</th>
                        <th class="py-3.5 px-6 text-center">Delivery Status</th>
                        <th class="py-3.5 px-6 text-right">Escrow Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-purple-900">
                                <a href="{{ route('admin.orders.show', $ord) }}" class="hover:underline">
                                    {{ $ord->order_number }}
                                </a>
                            </td>

                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $ord->shipping_name ?? $ord->user->name ?? 'Customer' }}
                            </td>

                            <td class="py-4 px-6 text-teal-800 font-bold">
                                {{ $ord->items->first()->product->seller->shop_name ?? 'Cartiva Direct' }}
                            </td>

                            <td class="py-4 px-6 text-right font-mono font-black text-slate-900">
                                ৳{{ number_format($ord->total_amount) }}
                            </td>

                            <td class="py-4 px-6 font-bold text-slate-600">
                                {{ strtoupper($ord->payment_method) }}
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($ord->escrow_status === 'released')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                        Released
                                    </span>
                                @elseif($ord->escrow_status === 'refunded')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase">
                                        Refunded
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase">
                                        Held in Pool
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $ord->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($ord->order_status) }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                @if($ord->escrow_status !== 'released' && $ord->escrow_status !== 'refunded')
                                    <form action="{{ route('admin.orders.release-escrow', $ord) }}" method="POST" onsubmit="return confirm('Release funds to merchant wallet?');">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition-colors cursor-pointer">
                                            Release Payout
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-400 font-mono text-[11px]">Settled</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">No payment records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
