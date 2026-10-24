@extends('layouts.admin')

@section('title', 'Reported Issues & Disputes - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Disputes & Issues</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Customer Grievances & Vendor Disputes</h1>
            <p class="text-xs text-slate-500 mt-1">Investigate customer reports against merchants, courier delivery delays, and fraudulent COD orders.</p>
        </div>
    </div>

    <!-- 3 Summary Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">🔴 Open Complaints</span>
            <span class="text-2xl sm:text-3xl font-black text-rose-600 mt-0.5 block">{{ $openCount }}</span>
            <span class="text-[11px] text-rose-700 font-semibold mt-1 block">Awaiting admin review</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">🟡 Under Investigation</span>
            <span class="text-2xl sm:text-3xl font-black text-amber-500 mt-0.5 block">{{ $investigatingCount }}</span>
            <span class="text-[11px] text-amber-700 font-semibold mt-1 block">Evidence being checked</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">🟢 Resolved Tickets</span>
            <span class="text-2xl sm:text-3xl font-black text-emerald-600 mt-0.5 block">{{ $resolvedCount }}</span>
            <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">Settled successfully</span>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="flex items-center space-x-2 mb-6 text-xs font-bold">
        <a href="{{ route('admin.issues') }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ !request('status') ? 'bg-purple-700 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">All Tickets</a>
        <a href="{{ route('admin.issues', ['status' => 'open']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'open' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Open ({{ $openCount }})</a>
        <a href="{{ route('admin.issues', ['status' => 'investigating']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'investigating' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Investigating</a>
        <a href="{{ route('admin.issues', ['status' => 'resolved']) }}" class="px-3.5 py-1.5 rounded-xl transition-all {{ request('status') === 'resolved' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Resolved</a>
    </div>

    <!-- Issues Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Ticket #</th>
                        <th class="py-3.5 px-6">Subject & Nature</th>
                        <th class="py-3.5 px-6">Complainant</th>
                        <th class="py-3.5 px-6">Involved Merchant</th>
                        <th class="py-3.5 px-6 text-center">Priority</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Date</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($issues as $issue)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-purple-700">
                                #{{ $issue->ticket_number }}
                            </td>

                            <td class="py-4 px-6 max-w-xs">
                                <a href="{{ route('admin.issues.show', $issue) }}" class="font-bold text-slate-900 hover:text-purple-700 transition-colors block text-xs line-clamp-1">
                                    {{ $issue->subject }}
                                </a>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold block mt-0.5">
                                    {{ str_replace('_', ' ', $issue->issue_type) }}
                                </span>
                            </td>

                            <td class="py-4 px-6 font-medium text-slate-800">
                                {{ $issue->user->name ?? 'User' }}
                            </td>

                            <td class="py-4 px-6 text-teal-800 font-bold">
                                {{ $issue->seller->shop_name ?? $issue->seller->name ?? 'Platform Direct' }}
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($issue->priority === 'urgent')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase animate-pulse">Urgent</span>
                                @elseif($issue->priority === 'high')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">High</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-700 uppercase">{{ $issue->priority }}</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($issue->status === 'open')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase">
                                        Open
                                    </span>
                                @elseif($issue->status === 'investigating')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase">
                                        Investigating
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                        Resolved
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right font-mono text-[11px] text-slate-400">
                                {{ $issue->created_at->format('M d, Y') }}
                            </td>

                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.issues.show', $issue) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-purple-100 text-slate-700 hover:text-purple-800 font-bold text-[11px] transition-colors">
                                    Resolve
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">No reported disputes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($issues->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $issues->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
