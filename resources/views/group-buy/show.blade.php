@extends('layouts.app')

@section('title', 'Team Buy #' . $session->group_code . ' — Cartiva')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 space-y-4"
     x-data="groupRoom({{ (int) $secondsRemaining }}, '{{ url('/group-buy/' . $session->group_code) }}')">

    <!-- Top Navigation Bar -->
    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('products.show', $session->product->slug) }}" 
           class="inline-flex items-center space-x-2 text-xs font-bold text-slate-700 hover:text-[#53a318] bg-white border border-slate-200 hover:border-[#53a318] px-3.5 py-2 rounded-xl shadow-2xs hover:shadow-xs transition-all group">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#53a318] group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Product Details</span>
        </a>

        <div class="flex items-center space-x-2">
            <span class="font-mono text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200">
                Team: {{ $session->group_code }}
            </span>
            @if($isCompleted)
                <span class="text-xs font-black px-2.5 py-1 rounded-xl bg-emerald-100 text-emerald-800 border border-emerald-200">
                    Deal Unlocked ✓
                </span>
            @elseif($isExpired)
                <span class="text-xs font-black px-2.5 py-1 rounded-xl bg-rose-100 text-rose-800 border border-rose-200">
                    Expired
                </span>
            @else
                <span class="text-xs font-black px-2.5 py-1 rounded-xl bg-amber-100 text-amber-900 border border-amber-200 flex items-center space-x-1">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                    <span>Active Team</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Main Team Room Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-lg overflow-hidden">
        
        <!-- Compact Status Header -->
        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 text-white px-5 sm:px-7 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-800">
            <div>
                <span class="text-[10px] font-mono font-bold tracking-wider uppercase text-emerald-400 block">
                    Group Purchase Pool
                </span>
                <h1 class="text-base sm:text-lg font-black text-white flex items-center space-x-2">
                    @if($isCompleted)
                        <span>🎉 Wholesale Team Price Successfully Unlocked!</span>
                    @elseif($isExpired)
                        <span>⏳ Group Pool Expired</span>
                    @else
                        <span>Unlock ৳{{ number_format($session->product->group_price) }} Wholesale Price</span>
                    @endif
                </h1>
                <p class="text-xs text-slate-300 mt-0.5">
                    @if($isCompleted)
                        All required members joined! Orders are locked in and moved to processing.
                    @elseif($isExpired)
                        This session timed out before filling. 100% automatic refund issued.
                    @else
                        Only <strong class="text-amber-300">{{ $session->remainingSlots() }} more buyer{{ $session->remainingSlots() > 1 ? 's' : '' }}</strong> needed to lock in discount!
                    @endif
                </p>
            </div>

            <!-- Sleek Inline Live Countdown Timer -->
            @if(!$isCompleted && !$isExpired)
                <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-md px-3.5 py-2 rounded-2xl border border-white/15 shrink-0 self-start sm:self-center">
                    <span class="text-[10px] font-black uppercase text-amber-300 tracking-wider flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 text-amber-400 animate-spin" style="animation-duration: 4s;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Ends in:</span>
                    </span>
                    <div class="flex items-center space-x-1 font-mono font-black text-sm text-white">
                        <span class="bg-slate-900/90 px-2 py-0.5 rounded-lg border border-white/10" x-text="hours">00</span>
                        <span class="text-amber-400">:</span>
                        <span class="bg-slate-900/90 px-2 py-0.5 rounded-lg border border-white/10" x-text="minutes">00</span>
                        <span class="text-amber-400">:</span>
                        <span class="bg-slate-900/90 px-2 py-0.5 rounded-lg border border-white/10" x-text="seconds">00</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- 2-Column Compact Body -->
        <div class="p-5 sm:p-7 grid grid-cols-1 md:grid-cols-12 gap-6 items-start">

            <!-- Left Column: Product Snapshot (5 Cols) -->
            <div class="md:col-span-5 space-y-4">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-3">
                    <div class="relative aspect-square rounded-xl overflow-hidden bg-white shadow-2xs">
                        <img src="{{ $session->product->image_url }}" alt="{{ $session->product->title }}" class="w-full h-full object-cover">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[10px] font-black bg-rose-600 text-white shadow-xs">
                            Save ৳{{ number_format($session->product->savings) }}
                        </span>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Target Item</span>
                        <h2 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug line-clamp-2">
                            {{ $session->product->title }}
                        </h2>
                    </div>

                    <!-- Pricing Box -->
                    <div class="pt-2 border-t border-slate-200/70 flex items-baseline justify-between">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-slate-400 block">Team Price</span>
                            <span class="text-xl font-black text-[#53a318]">৳{{ number_format($session->product->group_price) }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] uppercase font-bold text-slate-400 block">Regular Solo</span>
                            <span class="text-xs text-slate-400 line-through">৳{{ number_format($session->product->single_price) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('products.show', $session->product->slug) }}" 
                       class="block text-center text-xs font-bold text-[#53a318] hover:text-[#468c13] hover:underline pt-1">
                        View full specs & photos &rarr;
                    </a>
                </div>
            </div>

            <!-- Right Column: Team Progress & Actions (7 Cols) -->
            <div class="md:col-span-7 space-y-5">

                <!-- Member Progress Tracker -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                        <span>Team Formation Progress</span>
                        <span class="text-emerald-700 font-black">
                            {{ $session->current_members }} of {{ $session->required_members }} Members Locked
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-400 to-[#53a318] h-2 rounded-full transition-all duration-500"
                             style="width: {{ ($session->current_members / $session->required_members) * 100 }}%"></div>
                    </div>

                    <!-- Compact Member Avatars Row -->
                    <div class="grid grid-cols-2 sm:grid-cols-{{ min(4, $session->required_members) }} gap-2.5 pt-1">
                        @foreach($session->members as $member)
                            <div class="p-3 rounded-xl bg-white border border-emerald-500/40 shadow-2xs flex flex-col items-center text-center space-y-1">
                                <div class="relative">
                                    <div class="w-9 h-9 rounded-xl bg-slate-900 text-white font-black text-xs flex items-center justify-center shadow-xs">
                                        {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                    </div>
                                    @if($member->is_leader)
                                        <span class="absolute -top-1 -right-1 px-1 py-0.1 rounded bg-amber-400 text-slate-900 text-[8px] font-black uppercase">
                                            Leader
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[11px] font-bold text-slate-800 truncate max-w-[90px] block">{{ $member->user->name }}</span>
                                <span class="text-[9px] text-emerald-600 font-bold">Joined ✓</span>
                            </div>
                        @endforeach

                        @for($i = 0; $i < $session->remainingSlots(); $i++)
                            <div class="p-3 rounded-xl bg-amber-50/50 border border-dashed border-amber-300 flex flex-col items-center text-center space-y-1">
                                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 font-black text-xs flex items-center justify-center animate-pulse">
                                    ?
                                </div>
                                <span class="text-[11px] font-bold text-amber-800 block">Open Slot</span>
                                <span class="text-[9px] text-amber-600 font-medium">Waiting</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Primary CTA Join Form or Member Status -->
                @if(!$isCompleted && !$isExpired)
                    <div class="space-y-3">
                        @if($userAlreadyJoined)
                            <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-1">
                                <span class="text-xs font-black text-emerald-800 block">
                                    ✅ You are in this team!
                                </span>
                                <p class="text-[11px] text-emerald-700">
                                    Share the link below with friends to fill remaining slots faster.
                                </p>
                            </div>
                        @else
                            <form action="{{ route('group-buy.join', $session) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full py-3.5 px-5 rounded-2xl font-black text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2 active:scale-[0.99] cursor-pointer">
                                    <span>Join Team & Pay ৳{{ number_format($session->product->group_price) }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </form>
                        @endif

                        <!-- Compact Share Strip -->
                        <div class="p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-100 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-emerald-950">Invite Buyers to Fill Team:</span>
                                <button @click="copyLink()" class="text-xs font-bold text-[#53a318] hover:underline flex items-center space-x-1 cursor-pointer">
                                    <span x-text="copied ? 'Link Copied! ✓' : 'Copy Share Link 📋'"></span>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 pt-0.5">
                                <a :href="'https://wa.me/?text=' + encodeURIComponent('Join our Cartiva group buy and save up to 45%! ' + shareUrl)" 
                                   target="_blank" 
                                   class="py-2 px-3 rounded-xl bg-emerald-100 hover:bg-emerald-200 text-emerald-800 text-xs font-bold text-center transition-colors flex items-center justify-center space-x-1.5">
                                    <span>WhatsApp Share</span>
                                </a>
                                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shareUrl)" 
                                   target="_blank" 
                                   class="py-2 px-3 rounded-xl bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-bold text-center transition-colors flex items-center justify-center space-x-1.5">
                                    <span>Facebook Share</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Buyer Protection Guarantees -->
                <div class="grid grid-cols-3 gap-2 pt-1 text-[11px] text-slate-500 font-medium">
                    <div class="flex items-center space-x-1">
                        <span class="text-emerald-600 font-bold">✓</span>
                        <span>100% Refundable</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="text-emerald-600 font-bold">✓</span>
                        <span>Genuine Product</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="text-emerald-600 font-bold">✓</span>
                        <span>Direct Dispatch</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Alpine Group Room Script -->
<script>
    function groupRoom(initialSec, url) {
        return {
            secondsLeft: Math.max(0, Math.floor(Number(initialSec) || 0)),
            hours: '00',
            minutes: '00',
            seconds: '00',
            shareUrl: url,
            copied: false,
            timer: null,

            init() {
                this.updateClock();
                if (this.secondsLeft > 0) {
                    this.timer = setInterval(() => {
                        if (this.secondsLeft > 0) {
                            this.secondsLeft--;
                            this.updateClock();
                        } else {
                            clearInterval(this.timer);
                            window.location.reload();
                        }
                    }, 1000);
                }
            },

            updateClock() {
                const totalSec = Math.max(0, Math.floor(Number(this.secondsLeft) || 0));
                if (totalSec <= 0) {
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    return;
                }
                const h = Math.floor(totalSec / 3600);
                const m = Math.floor((totalSec % 3600) / 60);
                const s = Math.floor(totalSec % 60);
                this.hours = h.toString().padStart(2, '0');
                this.minutes = m.toString().padStart(2, '0');
                this.seconds = s.toString().padStart(2, '0');
            },

            copyLink() {
                navigator.clipboard.writeText(this.shareUrl).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2500);
                });
            }
        };
    }
</script>
@endsection
