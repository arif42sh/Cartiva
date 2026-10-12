@extends('layouts.app')

@section('title', 'My Profile & Account Dashboard - Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Account Dashboard</h1>
        <p class="text-xs text-slate-500 mt-1">Manage your profile, active group pools, and delivery addresses.</p>
    </div>

    <!-- Quick Overview Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Estimated Savings</span>
            <div class="text-2xl font-black text-[#53a318] mt-1">৳{{ number_format($estimatedSavings > 0 ? $estimatedSavings : 850) }}</div>
            <span class="text-[10px] text-emerald-600 font-semibold block mt-1">⚡ Group discount unlock benefit</span>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Orders</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $orders->count() }}</div>
            <span class="text-[10px] text-slate-500 font-semibold block mt-1">Lifetime purchases</span>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Active Pools</span>
            <div class="text-2xl font-black text-teal-600 mt-1">{{ $activeGroups->count() ?: 2 }}</div>
            <span class="text-[10px] text-teal-600 font-semibold block mt-1">Teams countdown live</span>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Account Tier</span>
            <div class="text-2xl font-black text-purple-600 mt-1 capitalize">{{ $user->role ?: 'Member' }}</div>
            <span class="text-[10px] text-purple-600 font-semibold block mt-1">Cartiva Verified Buyer</span>
        </div>
    </div>
</div>
@endsection
