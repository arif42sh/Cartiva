@extends('layouts.admin')

@section('title', 'System Audit Trail & Scheduler Monitor - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Audit Logs</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">System Activities & Audit Trail</h1>
            <p class="text-xs text-slate-500 mt-1">Audit log of all platform security operations, vendor state changes, and automated cron scheduler executions.</p>
        </div>

        <div>
            <form action="{{ route('admin.trigger-check') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-md shadow-purple-700/20 transition-all flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4 animate-spin-reverse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Execute Cron Scheduler Now</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 3 System Diagnostic Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Audit Log Entries</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 block">{{ $totalLogsCount }}</span>
            <span class="text-[11px] text-purple-700 font-semibold mt-1 block">Immutable events logged</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Scheduler Cron Engine</span>
            <span class="text-2xl sm:text-3xl font-black text-emerald-600 mt-0.5 block">Every Minute</span>
            <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">cartiva:check-group-expirations</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Server Health & Runtime</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-800 mt-0.5 block font-mono text-xl sm:text-2xl">PHP {{ PHP_VERSION }}</span>
            <span class="text-[11px] text-slate-400 font-medium mt-1 block">Laravel 12 • MySQL Active</span>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Platform Event Audit Log</h3>
                <p class="text-xs text-slate-400">Chronological trail of administrative actions and cron execution.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Timestamp</th>
                        <th class="py-3.5 px-6">Event Action</th>
                        <th class="py-3.5 px-6">Description</th>
                        <th class="py-3.5 px-6">Actor / User</th>
                        <th class="py-3.5 px-6">Target Entity</th>
                        <th class="py-3.5 px-6 text-right">Client IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 font-mono text-[11px] text-slate-400 whitespace-nowrap">
                                {{ $log->created_at->format('M d, Y h:i:s A') }}
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-slate-100 text-slate-700">
                                    {{ $log->action }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-slate-800 font-medium">
                                {{ $log->description }}
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="font-bold text-slate-900 block text-xs">
                                    {{ $log->user->name ?? 'System Worker' }}
                                </span>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap font-mono text-[11px] text-slate-500">
                                {{ $log->entity_type ? "{$log->entity_type} #{$log->entity_id}" : '—' }}
                            </td>

                            <td class="py-4 px-6 text-right font-mono text-[11px] text-slate-400 whitespace-nowrap">
                                {{ $log->ip_address ?? '127.0.0.1' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">No activity logged yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
