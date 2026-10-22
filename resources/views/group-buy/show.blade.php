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
                        <span> Wholesale Team Price Successfully Unlocked!</span>
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
                                    আপনি এই গ্রুপে যুক্ত আছেন (পেমেন্ট সম্পন্ন)
                                </span>
                                <p class="text-[11px] text-emerald-700">
                                    বাকি স্লট পূরণ করতে নিচের লিংকটি বন্ধুদের সাথে শেয়ার করুন।
                                </p>
                            </div>

                            @if($session->remainingSlots() > 0)
                                <form action="{{ route('group-buy.join', $session) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full py-2.5 px-4 rounded-xl font-bold text-xs bg-slate-900 hover:bg-slate-800 text-white transition-all flex items-center justify-center space-x-1.5 cursor-pointer shadow-xs">
                                        <span>আরও ১টি স্লট নিজে কিনুন (৳{{ number_format($session->product->group_price) }})</span>
                                    </button>
                                </form>
                            @endif

                            @if($canLeaderDismiss)
                                <div class="pt-1">
                                    <form action="{{ route('group-buy.dismiss', $session) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে আপনি এই গ্রুপটি বাতিল করতে চান? আপনার অর্ডারটি বাতিল হবে এবং সংরক্ষিত স্টক ফেরত যাবে।')">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full py-2.5 px-4 rounded-xl font-bold text-xs bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-all flex items-center justify-center space-x-1.5 cursor-pointer">
                                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            <span>গ্রুপ বাতিল করুন (Dismiss Group)</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <form action="{{ route('group-buy.join', $session) }}" method="POST" class="space-y-2">
                                @csrf
                                @if($session->remainingSlots() > 1)
                                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 px-1 bg-slate-50 p-2 rounded-xl border border-slate-200/80">
                                        <span>পরিমাণ (সর্বোচ্চ {{ $session->remainingSlots() }}টি):</span>
                                        <select name="quantity" class="bg-white border border-slate-300 rounded-lg px-2.5 py-1 text-xs font-bold focus:ring-1 focus:ring-emerald-500">
                                            @for($q = 1; $q <= min(5, $session->remainingSlots()); $q++)
                                                <option value="{{ $q }}">{{ $q }}টি (৳{{ number_format($session->product->group_price * $q) }})</option>
                                            @endfor
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="quantity" value="1">
                                @endif
                                <button type="submit" 
                                        class="w-full py-3.5 px-5 rounded-2xl font-black text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2 active:scale-[0.99] cursor-pointer">
                                    <span>গ্রুপে যোগ দিন ও অর্ডার করুন</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </form>
                        @endif

                        <!-- Classic & Professional Share Section -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3.5">
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-lg bg-emerald-100 text-[#53a318] flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-[#53a318]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-slate-800">ইনভাইট ও টিম শেয়ার করুন:</span>
                                </div>
                                <span class="text-[10px] font-bold text-[#53a318] bg-emerald-100/80 px-2 py-0.5 rounded-md">
                                    ১০০% সেফ রিফান্ড
                                </span>
                            </div>

                            <!-- Circular Brand Icons (Horizontal Row with Official Colors) -->
                            <div class="flex items-center justify-around gap-2 pt-1" style="display: flex !important; flex-direction: row !important; justify-content: space-around !important; align-items: flex-start !important; width: 100% !important;">
                                <!-- WhatsApp -->
                                <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('আমার সাথে কার্টিভায় গ্রুপ পুলে যোগ দিয়ে পাইকারি রেট আনলক করুন!\nপণ্য: {{ addslashes($session->product->title) }}\nরুম কোড: {{ $session->group_code }}\nলিংক: ' + shareUrl)"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;"
                                   class="group">
                                    <div style="width: 48px !important; height: 48px !important; min-width: 48px !important; min-height: 48px !important; border-radius: 50% !important; background-color: #25D366 !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4) !important; transition: transform 0.2s ease;"
                                         onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <svg style="width: 24px !important; height: 24px !important; fill: #ffffff !important; color: #ffffff !important;" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0012.053 3c-4.968 0-9.01 4.042-9.01 9.013 0 1.587.413 3.134 1.198 4.492L3 21l4.637-1.217a8.983 8.983 0 004.416 1.154h.004c4.968 0 9.01-4.042 9.01-9.013 0-2.408-.937-4.673-2.664-6.286zm-6.35 13.733h-.003a7.48 7.48 0 01-3.811-1.042l-.273-.162-2.832.743.756-2.761-.178-.283a7.48 7.48 0 01-1.147-3.992c0-4.14 3.369-7.509 7.513-7.509 2.006 0 3.892.782 5.309 2.2a7.452 7.452 0 012.198 5.308c0 4.14-3.369 7.509-7.532 7.509zm4.126-5.635c-.226-.113-1.339-.661-1.547-.737-.207-.075-.358-.113-.509.113-.15.226-.583.737-.715.888-.132.151-.264.17-.49.057-.226-.114-.954-.352-1.817-1.121-.671-.598-1.125-1.337-1.257-1.564-.132-.226-.014-.349.099-.461.102-.102.226-.264.339-.396.113-.132.151-.226.226-.377.075-.151.038-.283-.019-.396-.057-.113-.509-1.226-.698-1.678-.184-.442-.372-.382-.509-.389-.132-.007-.283-.008-.433-.008-.151 0-.396.057-.603.283-.207.226-.792.774-.792 1.887 0 1.113.811 2.188.924 2.339.113.151 1.597 2.438 3.87 3.418.541.233.963.372 1.293.477.544.173 1.039.148 1.431.09.437-.065 1.339-.547 1.528-1.075.188-.528.188-.981.132-1.075-.057-.094-.208-.151-.434-.264z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 700 !important; color: #1e293b !important; margin-top: 5px !important; display: block !important;">WhatsApp</span>
                                </a>

                                <!-- Messenger -->
                                <a :href="'fb-messenger://share/?link=' + encodeURIComponent(shareUrl)"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;"
                                   class="group">
                                    <div style="width: 48px !important; height: 48px !important; min-width: 48px !important; min-height: 48px !important; border-radius: 50% !important; background: linear-gradient(135deg, #00B2FE 0%, #006AFF 50%, #9900FF 100%) !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 4px 14px rgba(0, 106, 255, 0.4) !important; transition: transform 0.2s ease;"
                                         onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <svg style="width: 24px !important; height: 24px !important; fill: #ffffff !important; color: #ffffff !important;" viewBox="0 0 24 24">
                                            <path d="M12 2C6.477 2 2 6.145 2 11.258c0 2.914 1.455 5.518 3.735 7.205V22l3.413-1.874c.905.251 1.864.387 2.852.387 5.523 0 10-4.145 10-9.255C22 6.145 17.523 2 12 2zm1.066 12.443l-2.73-2.912-5.328 2.912 5.86-6.223 2.798 2.912 5.26-2.912-5.86 6.223z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 700 !important; color: #1e293b !important; margin-top: 5px !important; display: block !important;">Messenger</span>
                                </a>

                                <!-- Facebook -->
                                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shareUrl)"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;"
                                   class="group">
                                    <div style="width: 48px !important; height: 48px !important; min-width: 48px !important; min-height: 48px !important; border-radius: 50% !important; background-color: #1877F2 !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 4px 14px rgba(24, 119, 242, 0.4) !important; transition: transform 0.2s ease;"
                                         onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <svg style="width: 24px !important; height: 24px !important; fill: #ffffff !important; color: #ffffff !important;" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 700 !important; color: #1e293b !important; margin-top: 5px !important; display: block !important;">Facebook</span>
                                </a>

                                <!-- Telegram -->
                                <a :href="'https://t.me/share/url?url=' + encodeURIComponent(shareUrl) + '&text=' + encodeURIComponent('আমার সাথে কার্টিভায় গ্রুপ পুলে যোগ দিয়ে পাইকারি রেট আনলক করুন! রুম কোড: {{ $session->group_code }}')"
                                   target="_blank"
                                   style="display: flex !important; flex-direction: column !important; align-items: center !important; text-decoration: none !important; cursor: pointer !important; flex: 1 !important; text-align: center !important;"
                                   class="group">
                                    <div style="width: 48px !important; height: 48px !important; min-width: 48px !important; min-height: 48px !important; border-radius: 50% !important; background-color: #24A1DE !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 4px 14px rgba(36, 161, 222, 0.4) !important; transition: transform 0.2s ease;"
                                         onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <svg style="width: 24px !important; height: 24px !important; fill: #ffffff !important; color: #ffffff !important;" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.19-.08-.05-.19-.02-.27 0-.12.03-1.99 1.27-5.63 3.72-.53.36-1.02.54-1.45.53-.48-.01-1.4-.27-2.09-.49-.84-.27-1.51-.42-1.45-.89.03-.25.38-.51 1.07-.78 4.19-1.82 6.99-3.03 8.39-3.62 3.99-1.68 4.82-1.97 5.37-1.98.12 0 .39.03.56.17.14.12.18.28.2.4.01.09.02.26.01.4z"/>
                                        </svg>
                                    </div>
                                    <span style="font-size: 10px !important; font-weight: 700 !important; color: #1e293b !important; margin-top: 5px !important; display: block !important;">Telegram</span>
                                </a>
                            </div>

                            <!-- Direct Link Copy Input -->
                            <div class="flex items-center p-1 rounded-xl bg-white border border-slate-200 focus-within:border-[#53a318] focus-within:ring-2 focus-within:ring-[#53a318]/20 transition-all">
                                <div class="pl-2.5 pr-1.5 text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                                <input type="text" readonly :value="shareUrl" class="w-full text-xs font-mono font-medium text-slate-700 bg-transparent py-1.5 pr-2 focus:outline-none select-all truncate">
                                <button type="button" @click="copyLink()"
                                        class="px-3.5 py-1.5 bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs rounded-lg transition-all shrink-0 flex items-center space-x-1 cursor-pointer active:scale-95 shadow-2xs">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <span x-text="copied ? 'কপি হয়েছে' : 'কপি'"></span>
                                </button>
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
