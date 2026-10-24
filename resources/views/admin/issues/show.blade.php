@extends('layouts.admin')

@section('title', 'Ticket #' . $issue->ticket_number . ' - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.issues') }}" class="hover:text-purple-600">Issues</a>
                <span>/</span>
                <span class="text-purple-700 font-mono">#{{ $issue->ticket_number }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Dispute Resolution Workspace</h1>
            <p class="text-xs text-slate-500 mt-1">Direct arbitration between buyers and sellers, order inspection, and official platform ruling.</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.issues') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold shadow-2xs transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to Disputes</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Ticket Details (2 cols) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                    <div>
                        <span class="font-mono text-xs font-black text-purple-700 block">TICKET #{{ $issue->ticket_number }}</span>
                        <h2 class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $issue->subject }}</h2>
                    </div>
                    <div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $issue->status === 'resolved' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $issue->status }}
                        </span>
                    </div>
                </div>

                <!-- Complaint Narrative -->
                <div class="mb-6">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Complaint Description</span>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-slate-800 text-xs leading-relaxed">
                        {{ $issue->description }}
                    </div>
                </div>

                <!-- Admin Response History -->
                @if($issue->admin_response)
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-purple-700 block mb-2">Official Admin Resolution</span>
                        <div class="p-4 rounded-2xl bg-purple-50/70 border border-purple-200/60 text-purple-950 text-xs leading-relaxed font-medium">
                            {{ $issue->admin_response }}
                            @if($issue->resolved_at)
                                <span class="block mt-2 text-[10px] text-purple-600 font-mono">Resolved on {{ $issue->resolved_at->format('M d, Y h:i A') }}</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Linked Order Card (if any) -->
            @if($issue->order)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-3">Linked Order Information</h3>
                    <div class="flex items-center justify-between text-xs">
                        <div>
                            <span class="font-mono font-bold text-slate-900 block">Order #{{ $issue->order->order_number }}</span>
                            <span class="text-slate-400">Total: ৳{{ number_format($issue->order->total_amount) }} • {{ ucfirst($issue->order->order_status) }}</span>
                        </div>
                        <a href="{{ route('admin.orders.show', $issue->order) }}" class="px-3 py-1.5 rounded-xl bg-purple-50 text-purple-700 font-bold hover:bg-purple-100 transition-colors">
                            View Order Details &rarr;
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right: Resolution Form (1 col) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
                <h3 class="text-xs font-black uppercase tracking-wider text-purple-700 mb-2">Take Administrative Action</h3>
                <p class="text-xs text-slate-500 mb-5">Provide platform feedback and update ticket resolution status.</p>

                <form action="{{ route('admin.issues.resolve', $issue) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Update Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-purple-600 focus:outline-hidden">
                            <option value="investigating" {{ $issue->status === 'investigating' ? 'selected' : '' }}>Under Investigation</option>
                            <option value="resolved" {{ $issue->status === 'resolved' ? 'selected' : '' }}>Resolved (Ruling Issued)</option>
                            <option value="closed" {{ $issue->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Administrative Ruling / Response *</label>
                        <textarea name="admin_response" rows="4" required placeholder="Detail the outcome, courier investigation, or seller warning..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-600 focus:outline-hidden">{{ $issue->admin_response }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                        Submit Resolution
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
