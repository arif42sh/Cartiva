@extends('layouts.app')

@section('title', 'Group-Buy Sessions & Circles - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Header & Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Group-Buying Sessions & Circles</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitor active customer pools, check remaining slots, and inspect participating buyers.</p>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex items-center space-x-1.5 p-1 bg-white rounded-2xl border border-slate-200/90 shadow-2xs text-xs font-bold">
            <a href="{{ route('seller.groups') }}" 
               class="px-3 py-1.5 rounded-xl transition-all {{ !request('status') ? 'bg-teal-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                All ({{ $activeCount + $completedCount + $expiredCount }})
            </a>
            <a href="{{ route('seller.groups') }}?status=active" 
               class="px-3 py-1.5 rounded-xl transition-all {{ request('status') === 'active' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('seller.groups') }}?status=completed" 
               class="px-3 py-1.5 rounded-xl transition-all {{ request('status') === 'completed' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Completed ({{ $completedCount }})
            </a>
            <a href="{{ route('seller.groups') }}?status=expired" 
               class="px-3 py-1.5 rounded-xl transition-all {{ request('status') === 'expired' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Expired ({{ $expiredCount }})
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs mb-6">
        <form action="{{ route('seller.groups') }}" method="GET" class="flex items-center gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by group code (e.g. GRP-...) or product title..." 
                       class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500 transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition-colors">
                Search
            </button>
            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('seller.groups') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Group Sessions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($groups as $group)
            @php
                $isExpired = $group->status === 'expired' || ($group->status === 'active' && $group->expires_at->isPast());
                $isCompleted = $group->status === 'completed';
                $pct = $group->progress_percent;
            @endphp
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-5 flex flex-col justify-between hover:border-teal-300 transition-all group">
                
                <div>
                    <!-- Top Status Strip -->
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="font-mono font-bold text-xs px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700">
                            {{ $group->group_code }}
                        </span>
                        
                        @if($isCompleted)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 flex items-center space-x-1">
                                <span>✓</span>
                                <span>Completed & Unlocked</span>
                            </span>
                        @elseif($isExpired)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800">
                                Expired
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 flex items-center space-x-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Active Pooling</span>
                            </span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="flex items-start space-x-3 mb-4">
                        <img src="{{ $group->product->image_url }}" alt="{{ $group->product->title }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-black text-slate-900 line-clamp-2">{{ $group->product->title }}</h4>
                            <div class="flex items-center space-x-2 mt-1 text-[11px]">
                                <span class="text-slate-400 line-through">${{ number_format($group->product->single_price, 2) }}</span>
                                <span class="font-black text-emerald-600">${{ number_format($group->product->group_price, 2) }}</span>
                                <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1 py-0.2 rounded">-{{ $group->product->discount_percent }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Member Progress Bar -->
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 mb-4">
                        <div class="flex items-center justify-between text-xs font-extrabold mb-1.5">
                            <span class="text-slate-600">Joined Buyers:</span>
                            <span class="text-slate-900">{{ $group->current_members }} of {{ $group->required_members }} Slots</span>
                        </div>
                        <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $isCompleted ? 'bg-emerald-500' : ($isExpired ? 'bg-rose-400' : 'bg-amber-500') }}" 
                                 style="width: {{ $pct }}%"></div>
                        </div>

                        <!-- Participating Buyers Avatar Roster -->
                        <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-slate-200/60">
                            <div class="flex -space-x-1.5 overflow-hidden">
                                @foreach($group->members->take(5) as $member)
                                    <div class="w-6 h-6 rounded-full ring-2 ring-white overflow-hidden bg-teal-500 text-white flex items-center justify-center text-[9px] font-black" title="{{ $member->user->name ?? 'Buyer' }}">
                                        @if($member->user && $member->user->avatar)
                                            <img src="{{ $member->user->avatar }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($member->user->name ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <span class="text-[10px] text-slate-500 font-semibold">
                                Leader: <strong>{{ $group->leader->name ?? 'Customer' }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Expiration Countdown or Result -->
                    <div class="text-[11px] text-slate-500 flex items-center justify-between mb-4">
                        <span>Time Remaining:</span>
                        @if($isCompleted)
                            <span class="font-bold text-emerald-600">Successfully Fulfilled!</span>
                        @elseif($isExpired)
                            <span class="font-bold text-rose-500">Ended {{ $group->expires_at->diffForHumans() }}</span>
                        @else
                            <span class="font-mono font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">
                                ⏳ {{ $group->expires_at->diffForHumans(['parts' => 2]) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('seller.groups.show', $group) }}" 
                   class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-teal-600 text-white font-extrabold text-xs text-center transition-all flex items-center justify-center space-x-1.5 shadow-2xs">
                    <span>Inspect Circle & Buyers</span>
                    <span>&rarr;</span>
                </a>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200/90 p-8">
                <span class="text-4xl block mb-2">👥</span>
                <h3 class="text-base font-extrabold text-slate-800">No Group Buying Sessions Found</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">When buyers initiate team purchasing circles for your products, you will see their progress and participants here.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
        {{ $groups->links() }}
    </div>

</div>
@endsection
