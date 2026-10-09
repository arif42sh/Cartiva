@extends('layouts.app')

@section('title', 'Team Buy Room #' . $session->group_code . ' - Cartiva')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
     x-data="groupRoom({{ $secondsRemaining }}, '{{ url('/group-buy/' . $session->group_code) }}')">

    <!-- Team Room Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 text-white p-8 sm:p-10 text-center relative overflow-hidden">
            <div class="relative z-10 space-y-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-bold bg-white/10 backdrop-blur-md border border-white/20 text-emerald-300">
                    Team Code: {{ $session->group_code }}
                </span>

                <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
                    @if($isCompleted)
                        🎉 Team Successfully Completed!
                    @elseif($isExpired)
                        ⏳ Team Deal Expired
                    @else
                        Unlock Wholesale Team Price
                    @endif
                </h1>

                <p class="text-sm text-emerald-100 max-w-lg mx-auto">
                    @if($isCompleted)
                        All required members joined! Orders are locked in at the group discount and moved to processing.
                    @elseif($isExpired)
                        This session timed out before reaching target members. Automatic 100% refund initiated.
                    @else
                        Only <strong>{{ $session->remainingSlots() }} more buyer{{ $session->remainingSlots() > 1 ? 's' : '' }}</strong> needed to lock in <strong>${{ number_format($session->product->group_price, 2) }}</strong>!
                    @endif
                </p>
            </div>
        </div>

        <div class="p-6 sm:p-10 space-y-8">

            <!-- Live Countdown Timer (If active) -->
            @if(!$isCompleted && !$isExpired)
                <div class="p-6 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-center space-y-2">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-amber-700">Time Remaining to Complete Team</span>
                    <div class="flex items-center justify-center space-x-3 font-mono font-black text-3xl sm:text-4xl text-amber-900">
                        <div class="bg-white px-3.5 py-2 rounded-xl shadow-xs border border-amber-200" x-text="hours">00</div>
                        <span class="text-amber-500">:</span>
                        <div class="bg-white px-3.5 py-2 rounded-xl shadow-xs border border-amber-200" x-text="minutes">00</div>
                        <span class="text-amber-500">:</span>
                        <div class="bg-white px-3.5 py-2 rounded-xl shadow-xs border border-amber-200" x-text="seconds">00</div>
                    </div>
                    <p class="text-[11px] text-amber-700 font-medium">Timer updates in real-time. Don't let your savings slip away!</p>
                </div>
            @endif

            <!-- Product Summary Card -->
            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                <img src="{{ $session->product->image_url }}" alt="{{ $session->product->title }}" class="w-24 h-24 rounded-2xl object-cover bg-white shadow-xs">
                <div class="flex-1 text-center sm:text-left">
                    <h3 class="text-base font-bold text-slate-900">{{ $session->product->title }}</h3>
                    <div class="flex items-baseline justify-center sm:justify-start space-x-3 mt-1">
                        <span class="text-2xl font-black text-emerald-600">${{ number_format($session->product->group_price, 2) }}</span>
                        <span class="text-sm text-slate-400 line-through">${{ number_format($session->product->single_price, 2) }}</span>
                        <span class="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                            Save ${{ number_format($session->product->savings, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Member Slots Progress Visualizer -->
            <div class="space-y-4">
                <div class="flex items-center justify-between text-sm font-bold text-slate-800">
                    <span>Team Members</span>
                    <span class="text-emerald-600">{{ $session->current_members }} / {{ $session->required_members }} Filled</span>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-3 rounded-full transition-all duration-500"
                         style="width: {{ ($session->current_members / $session->required_members) * 100 }}%"></div>
                </div>

                <!-- Avatars Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-{{ $session->required_members }} gap-4 pt-2">
                    @foreach($session->members as $member)
                        <div class="p-4 rounded-2xl bg-white border-2 border-emerald-500/40 shadow-xs flex flex-col items-center text-center space-y-2">
                            <div class="relative">
                                <div class="w-14 h-14 rounded-full bg-emerald-600 text-white font-extrabold text-lg flex items-center justify-center shadow-md">
                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                </div>
                                @if($member->is_leader)
                                    <span class="absolute -top-1 -right-1 px-1.5 py-0.5 rounded-full bg-amber-400 text-slate-900 text-[10px] font-black uppercase">
                                        Leader
                                    </span>
                                @endif
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-800 block truncate max-w-[120px]">{{ $member->user->name }}</span>
                                <span class="text-[10px] text-slate-400">Joined</span>
                            </div>
                        </div>
                    @endforeach

                    @for($i = 0; $i < $session->remainingSlots(); $i++)
                        <div class="p-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-300 flex flex-col items-center text-center space-y-2 animate-pulse">
                            <div class="w-14 h-14 rounded-full bg-slate-200 text-slate-400 font-extrabold text-lg flex items-center justify-center">
                                ?
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-400 block">Open Slot</span>
                                <span class="text-[10px] text-amber-600 font-semibold">Waiting for buyer</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Share & Action Section -->
            @if(!$isCompleted && !$isExpired)
                <div class="pt-6 border-t border-slate-100 space-y-6">
                    
                    <!-- Shareable Link Copy Box -->
                    <div class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-2">
                        <label class="block text-xs font-bold text-indigo-900">Invite Friends & Family to Unlock Deal</label>
                        <div class="flex items-center space-x-2">
                            <input type="text" readonly :value="shareUrl" class="flex-1 bg-white border border-indigo-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 font-mono focus:outline-none">
                            <button @click="copyLink()" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition-all flex items-center space-x-1.5 flex-shrink-0">
                                <span x-text="copied ? 'Copied! ✅' : 'Copy Link 📋'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div>
                        @if($userAlreadyJoined)
                            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center text-emerald-800 text-sm font-bold">
                                ✅ You have secured your slot in this team! Share the link above with friends so your order can be confirmed!
                            </div>
                        @else
                            <form action="{{ route('group-buy.join', $session) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-4 px-6 rounded-2xl font-black text-base bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white shadow-xl shadow-emerald-600/30 transition-all flex items-center justify-center space-x-2">
                                    <span>Join This Team & Pay ${{ number_format($session->product->group_price, 2) }}</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @endif

        </div>

    </div>

</div>

<!-- Alpine Group Room Script -->
<script>
    function groupRoom(initialSec, url) {
        return {
            secondsLeft: initialSec,
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
                if (this.secondsLeft <= 0) {
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    return;
                }
                const h = Math.floor(this.secondsLeft / 3600);
                const m = Math.floor((this.secondsLeft % 3600) / 60);
                const s = this.secondsLeft % 60;
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
