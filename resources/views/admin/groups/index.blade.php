@extends('layouts.app')

@section('title', 'Manage Group Sessions - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-slate-800">Group Buys</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Platform Group Buy Sessions</h1>
        </div>

        <form action="{{ route('admin.trigger-check') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-xs transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Check & Expire Inactive Teams</span>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-6">Group Code</th>
                        <th class="py-3 px-6">Product</th>
                        <th class="py-3 px-6">Leader</th>
                        <th class="py-3 px-6">Joined / Required</th>
                        <th class="py-3 px-6">Expires At</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($groups as $grp)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 font-mono font-bold text-purple-700">{{ $grp->group_code }}</td>
                            <td class="py-4 px-6 font-semibold text-slate-800 line-clamp-1 max-w-xs">{{ $grp->product->title }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $grp->leader->name }}</td>
                            <td class="py-4 px-6 font-bold text-emerald-600">{{ $grp->current_members }} / {{ $grp->required_members }}</td>
                            <td class="py-4 px-6 text-slate-500 font-mono text-[11px]">{{ $grp->expires_at->format('M d, Y h:i A') }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $grp->status === 'active' ? 'bg-amber-100 text-amber-800' : ($grp->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ ucfirst($grp->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('group-buy.show', $grp) }}" target="_blank" class="text-purple-600 hover:text-purple-800 font-bold">
                                    View Room &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 font-medium">No group sessions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $groups->links() }}
        </div>
    </div>

</div>
@endsection
