@extends('layouts.admin')

@section('title', 'Group Buying Sessions Monitor - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Group Sessions</span>
            </div>
           
        </div>

        <div>
            <form action="{{ route('admin.trigger-check') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-md shadow-purple-700/20 transition-all flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4 animate-spin-reverse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Run Expiration Cron Task</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 3 Metric Cards (SRS 4.4.vi) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <!-- Active Groups (🟢) -->
        <a href="{{ route('admin.groups', ['status' => 'active']) }}" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:border-amber-400 transition-all block">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">🟢 Active Live Pools</span>
            <div class="text-2xl sm:text-3xl font-black text-amber-500 mt-0.5">{{ $activeCount }}</div>
            <span class="text-[11px] text-amber-600 font-semibold mt-1 block">Ticking 24h timer / Slots open</span>
        </a>

        <!-- Completed Groups (🔵) -->
        <a href="{{ route('admin.groups', ['status' => 'completed']) }}" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:border-emerald-400 transition-all block">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">🔵 Completed Team Deals</span>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-0.5">{{ $completedCount }}</div>
            <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">Target reached / Discount unlocked</span>
        </a>

        <!-- Expired/Failed Groups (🔴) -->
        <a href="{{ route('admin.groups', ['status' => 'expired']) }}" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:border-rose-400 transition-all block">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">🔴 Expired / Failed Pools</span>
            <div class="text-2xl sm:text-3xl font-black text-rose-600 mt-0.5">{{ $expiredCount }}</div>
            <span class="text-[11px] text-rose-700 font-semibold mt-1 block">Unfilled in 24h / Eligible for refund</span>
        </a>
    </div>

    <!-- Status Filter Pills -->
    <div class="flex items-center space-x-2 mb-6 text-xs font-bold">
        <a href="{{ route('admin.groups') }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ !request('status') ? 'bg-purple-700 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">All Sessions</a>
        <a href="{{ route('admin.groups', ['status' => 'active']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'active' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Active ({{ $activeCount }})</a>
        <a href="{{ route('admin.groups', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'completed' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Completed ({{ $completedCount }})</a>
        <a href="{{ route('admin.groups', ['status' => 'expired']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'expired' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Expired ({{ $expiredCount }})</a>
    </div>

    <!-- Group Sessions Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Group Code</th>
                        <th class="py-3.5 px-6">Product</th>
                        <th class="py-3.5 px-6">Team Leader</th>
                        <th class="py-3.5 px-6 text-center">Progress Slots</th>
                        <th class="py-3.5 px-6 text-center">Session Status</th>
                        <th class="py-3.5 px-6 text-right">Time Remaining / Expired</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($groups as $grp)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-purple-700">
                                #{{ $grp->group_code }}
                            </td>

                            <td class="py-4 px-6 font-semibold text-slate-800">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                        <img src="{{ $grp->product->image_url }}" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <span class="line-clamp-1 max-w-xs">{{ $grp->product->title }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-slate-700 font-medium">
                                {{ $grp->leader->name }}
                            </td>

                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-mono font-black {{ $grp->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $grp->current_members }} / {{ $grp->required_members }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($grp->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase tracking-wider animate-pulse">
                                        🟢 Active Live
                                    </span>
                                @elseif($grp->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                        🔵 Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase tracking-wider">
                                        🔴 Expired
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right font-mono text-[11px] text-slate-500">
                                @if($grp->status === 'active')
                                    <span class="text-amber-600 font-bold">{{ $grp->expires_at->diffForHumans(['parts' => 2]) }}</span>
                                @else
                                    {{ $grp->expires_at->format('M d, Y h:i A') }}
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('group-buy.show', $grp->group_code) }}" target="_blank" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-purple-100 text-slate-700 hover:text-purple-800 font-bold text-[11px] transition-colors">
                                        Room
                                    </a>

                                    @if($grp->status === 'expired')
                                        <form action="{{ route('admin.groups.relaunch', $grp) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[11px] transition-colors cursor-pointer" title="Relaunch for 24h">
                                                Relaunch
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">No group buy sessions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($groups->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $groups->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
