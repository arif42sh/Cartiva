@extends('layouts.admin')

@section('title', 'Announcements & Notifications - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ createModalOpen: false }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Announcements</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Platform Announcements & Broadcasts</h1>
            <p class="text-xs text-slate-500 mt-1">Publish top-bar promotional tickers, flash campaign alerts, and merchant operational guidelines.</p>
        </div>

        <div>
            <button type="button" @click="createModalOpen = true" 
                    class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-md shadow-purple-700/20 transition-all flex items-center space-x-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Publish New Announcement</span>
            </button>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Announcement Title & Message</th>
                        <th class="py-3.5 px-6">Display Format</th>
                        <th class="py-3.5 px-6">Target Audience</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Published Date</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($announcements as $ann)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 max-w-md">
                                <span class="font-bold text-slate-900 block text-xs">{{ $ann->title }}</span>
                                <span class="text-slate-500 text-[11px] block mt-1 line-clamp-2 leading-relaxed">{{ $ann->message }}</span>
                                @if($ann->action_url)
                                    <a href="{{ $ann->action_url }}" target="_blank" class="text-[10px] text-purple-700 font-bold hover:underline inline-block mt-1">
                                        {{ $ann->action_label ?? 'View Link' }} &rarr;
                                    </a>
                                @endif
                            </td>

                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">
                                    {{ str_replace('_', ' ', $ann->type) }}
                                </span>
                            </td>

                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $ann->target_audience === 'sellers' ? 'bg-teal-50 text-teal-800' : ($ann->target_audience === 'customers' ? 'bg-emerald-50 text-emerald-800' : 'bg-purple-50 text-purple-800') }}">
                                    {{ ucfirst($ann->target_audience) }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.announcements.toggle', $ann) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider cursor-pointer transition-all {{ $ann->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                                        {{ $ann->is_active ? 'Active' : 'Paused' }}
                                    </button>
                                </form>
                            </td>

                            <td class="py-4 px-6 text-right font-mono text-[11px] text-slate-400">
                                {{ $ann->created_at->format('M d, Y') }}
                            </td>

                            <td class="py-4 px-6 text-right">
                                <form action="{{ route('admin.announcements.destroy', $ann) }}" method="POST" onsubmit="return confirm('Delete announcement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition-colors cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">No active announcements published.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($announcements->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>

    <!-- Create Announcement Modal -->
    <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100" @click.outside="createModalOpen = false">
            <h3 class="text-lg font-black text-slate-900 mb-1">Publish Platform Announcement</h3>
            <p class="text-xs text-slate-500 mb-4">Create a banner or alert for customers and sellers.</p>

            <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Headline Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Eid Campaign: Free Shipping on Team Buys!" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Detailed Message *</label>
                    <textarea name="message" rows="3" required placeholder="Announcement details or coupon code..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Display Format</label>
                        <select name="type" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                            <option value="banner_top">Top Header Banner Ticker</option>
                            <option value="broadcast_alert">Dashboard Broadcast Alert</option>
                            <option value="modal_popup">Center Modal Popup</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Target Audience</label>
                        <select name="target_audience" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                            <option value="all">Everyone (All Users)</option>
                            <option value="customers">Customers Only</option>
                            <option value="sellers">Sellers Only</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Button Label (Optional)</label>
                        <input type="text" name="action_label" placeholder="e.g. Shop Now" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Action URL (Optional)</label>
                        <input type="text" name="action_url" placeholder="e.g. /flash-sales" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-2">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold cursor-pointer">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-purple-700 hover:bg-purple-800 text-white text-xs font-bold cursor-pointer">Publish Broadcast</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
