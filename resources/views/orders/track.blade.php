@extends('layouts.app')

@section('title', 'Track Order – Live Delivery Status | Cartiva')

@section('content')
<div class="bg-gradient-to-b from-slate-50 via-white to-slate-50 min-h-screen py-10 sm:py-14">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Top Header & Search Hero -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
 
            <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                Track Your Order Status
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 font-medium">
                অর্ডার নম্বর (যেমন: <span class="font-mono font-bold text-slate-800">ORD-6GU5BEU1</span>) অথবা ফোন নম্বর দিয়ে আপনার অর্ডারের বর্তমান অবস্থা জানুন।
            </p>

            <!-- Search Bar Form -->
            <form action="{{ route('orders.track') }}" method="GET" class="pt-3">
                <div class="flex items-center p-1.5 bg-white border-2 border-emerald-500/80 rounded-2xl shadow-xl focus-within:ring-4 focus-within:ring-[#53a318]/20 transition-all">
                    <div class="pl-3.5 pr-2 text-slate-400">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ $query }}" 
                           placeholder="Enter Order Number (e.g. ORD-6GU5BEU1) or Phone..."
                           class="w-full text-xs sm:text-sm text-slate-800 placeholder-slate-400 bg-transparent py-2 px-2 font-bold focus:outline-none">
                    <button type="submit" 
                            class="px-5 sm:px-7 py-3 bg-[#53a318] hover:bg-[#468c13] text-white text-xs sm:text-sm font-black rounded-xl transition-all shadow-md shrink-0 flex items-center space-x-2 cursor-pointer active:scale-95">
                        <span>Track</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>

            @if($recentOrders->isNotEmpty())
                <!-- Quick Suggestion Chips for Logged in user -->
                <div class="flex flex-wrap items-center justify-center gap-1.5 pt-2 text-xs">
                    <span class="text-[11px] font-bold text-slate-400">Recent Orders:</span>
                    @foreach($recentOrders as $recent)
                        <a href="{{ route('orders.track', ['q' => $recent->order_number]) }}" 
                           class="px-2.5 py-1 rounded-lg bg-white border border-slate-200/90 hover:border-emerald-500 text-slate-700 hover:text-[#53a318] font-mono font-bold text-[11px] shadow-2xs transition-colors">
                            {{ $recent->order_number }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if($trackedOrder)
            <!-- ==============================================
                 TRACKED ORDER RESULT CARD
                 ============================================== -->
            @php
                // Status Determination
                // order_status can be: pending_group, processing, shipped, delivered, cancelled
                $status = $trackedOrder->order_status;
                $isGroup = ($trackedOrder->order_type === 'group_buy');
                $session = $trackedOrder->groupSession;

                // Steps logic:
                // 1. Placed (Always complete)
                // 2. Team Pool Completed (or Verified for single)
                // 3. Processing & Packing
                // 4. Shipped / In Transit
                // 5. Delivered
                
                $step1 = true;
                $step2 = false;
                $step3 = false;
                $step4 = false;
                $step5 = false;

                if ($isGroup) {
                    if ($status === 'pending_group') {
                        $step2 = 'active'; // In progress
                    } else {
                        $step2 = true; // Completed
                    }
                } else {
                    $step2 = true; // Single orders skip pool waiting
                }

                if (in_array($status, ['processing', 'shipped', 'delivered'])) {
                    $step2 = true;
                    $step3 = ($status === 'processing') ? 'active' : true;
                }

                if (in_array($status, ['shipped', 'delivered'])) {
                    $step3 = true;
                    $step4 = ($status === 'shipped') ? 'active' : true;
                }

                if ($status === 'delivered') {
                    $step4 = true;
                    $step5 = true;
                }
            @endphp

            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
                
                <!-- 1. Order Card Header -->
                <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-white/10 text-emerald-400 border border-white/10">
                                {{ $trackedOrder->order_number }}
                            </span>
                            @if($isGroup)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-teal-500/20 text-teal-300 border border-teal-500/30">
                                    👥 Team Buy Pool
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/10 text-slate-300">
                                    Single Purchase
                                </span>
                            @endif

                            @if($status === 'pending_group')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 animate-pulse">
                                    ⏳ Waiting for Team Quota
                                </span>
                            @elseif($status === 'processing')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    ⚙️ Packaging & Dispatching
                                </span>
                            @elseif($status === 'shipped')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                    🚚 In Transit
                                </span>
                            @elseif($status === 'delivered')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-500/20 text-green-300 border border-green-500/30">
                                    Delivered Successfully
                                </span>
                            @elseif($status === 'cancelled')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                    ❌ Order Cancelled & Refunded
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400">
                            Placed on {{ $trackedOrder->created_at->format('M d, Y • h:i A') }} • Payment: <span class="uppercase text-emerald-400 font-bold">{{ $trackedOrder->payment_method }} ({{ $trackedOrder->payment_status }})</span>
                        </p>
                    </div>

                    <div class="flex items-center space-x-3 shrink-0">
                        @if($session)
                            <a href="{{ route('group-buy.show', $session->group_code) }}" 
                               class="px-4 py-2 rounded-xl bg-teal-500 hover:bg-teal-600 text-white font-extrabold text-xs shadow-xs transition-colors flex items-center space-x-1.5">
                                <span>Team Room</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endif
                        <a href="{{ route('orders.show', $trackedOrder) }}" 
                           class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition-colors">
                            Invoice Details
                        </a>
                    </div>
                </div>

                <!-- 2. Visual Stepper Timeline -->
                <div class="p-6 sm:p-10 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-6">Delivery Progress Timeline</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-6 sm:gap-2 relative">
                        
                        <!-- Step 1: Order Placed -->
                        <div class="flex sm:flex-col items-center sm:text-center space-x-4 sm:space-x-0 relative group">
                            <div class="w-12 h-12 rounded-2xl bg-[#53a318] text-white flex items-center justify-center font-black text-lg shadow-md ring-4 ring-emerald-100 shrink-0">
                                ✓
                            </div>
                            <div class="sm:mt-3">
                                <h4 class="text-xs font-black text-slate-900">Order Placed</h4>
                                <p class="text-[11px] text-slate-500">{{ $trackedOrder->created_at->format('M d, h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Step 2: Pool Quota / Verification -->
                        <div class="flex sm:flex-col items-center sm:text-center space-x-4 sm:space-x-0 relative group">
                            <div class="w-12 h-12 rounded-2xl {{ $step2 === true ? 'bg-[#53a318] text-white ring-4 ring-emerald-100' : ($step2 === 'active' ? 'bg-amber-500 text-white ring-4 ring-amber-100 animate-pulse' : 'bg-slate-200 text-slate-400') }} flex items-center justify-center font-black text-lg shadow-sm shrink-0">
                                @if($step2 === true) ✓ @elseif($step2 === 'active') ⏳ @else 2 @endif
                            </div>
                            <div class="sm:mt-3">
                                <h4 class="text-xs font-black text-slate-900">
                                    {{ $isGroup ? 'Team Pool Filled' : 'Order Verified' }}
                                </h4>
                                <p class="text-[11px] text-slate-500">
                                    @if($isGroup)
                                        @if($session && $session->isCompleted())
                                            Quota 100% Unlocked
                                        @elseif($session)
                                            {{ $session->current_members }}/{{ $session->required_members }} joined
                                        @endif
                                    @else
                                        Instant Approval
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 3: Processing & Packing -->
                        <div class="flex sm:flex-col items-center sm:text-center space-x-4 sm:space-x-0 relative group">
                            <div class="w-12 h-12 rounded-2xl {{ $step3 === true ? 'bg-[#53a318] text-white ring-4 ring-emerald-100' : ($step3 === 'active' ? 'bg-[#53a318] text-white ring-4 ring-emerald-100 animate-pulse' : 'bg-slate-200 text-slate-400') }} flex items-center justify-center font-black text-lg shadow-sm shrink-0">
                                @if($step3 === true) ✓ @elseif($step3 === 'active') ⚙️ @else 3 @endif
                            </div>
                            <div class="sm:mt-3">
                                <h4 class="text-xs font-black text-slate-900">Quality Checked</h4>
                                <p class="text-[11px] text-slate-500">
                                    {{ $step3 ? 'Packed & Sealed' : 'Awaiting QC' }}
                                </p>
                            </div>
                        </div>

                        <!-- Step 4: In Transit / Courier -->
                        <div class="flex sm:flex-col items-center sm:text-center space-x-4 sm:space-x-0 relative group">
                            <div class="w-12 h-12 rounded-2xl {{ $step4 === true ? 'bg-[#53a318] text-white ring-4 ring-emerald-100' : ($step4 === 'active' ? 'bg-blue-600 text-white ring-4 ring-blue-100 animate-pulse' : 'bg-slate-200 text-slate-400') }} flex items-center justify-center font-black text-lg shadow-sm shrink-0">
                                @if($step4 === true) ✓ @elseif($step4 === 'active') 🚚 @else 4 @endif
                            </div>
                            <div class="sm:mt-3">
                                <h4 class="text-xs font-black text-slate-900">In Transit</h4>
                                <p class="text-[11px] text-slate-500">
                                    {{ $trackedOrder->courier_name ?: 'Express Delivery' }}
                                </p>
                            </div>
                        </div>

                        <!-- Step 5: Delivered -->
                        <div class="flex sm:flex-col items-center sm:text-center space-x-4 sm:space-x-0 relative group">
                            <div class="w-12 h-12 rounded-2xl {{ $step5 === true ? 'bg-[#53a318] text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-400' }} flex items-center justify-center font-black text-lg shadow-sm shrink-0">
                                @if($step5 === true) 📦 @else 5 @endif
                            </div>
                            <div class="sm:mt-3">
                                <h4 class="text-xs font-black text-slate-900">Delivered</h4>
                                <p class="text-[11px] text-slate-500">
                                    {{ $trackedOrder->delivered_at ? $trackedOrder->delivered_at->format('M d') : 'Pending Final Delivery' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 3. Package & Shipping Details Grid -->
                <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Products in Order -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                            <span>🛍️</span>
                            <span>Ordered Items ({{ $trackedOrder->items->count() }})</span>
                        </h4>

                        <div class="space-y-3">
                            @foreach($trackedOrder->items as $item)
                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3">
                                    <div class="flex items-center space-x-3 min-w-0">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->title }}" 
                                             class="w-12 h-12 rounded-xl object-cover bg-white border border-slate-200 shrink-0">
                                        <div class="min-w-0">
                                            <h5 class="text-xs font-bold text-slate-900 truncate">{{ $item->product->title }}</h5>
                                            <p class="text-[11px] text-slate-500 mt-0.5">
                                                Qty: <span class="font-bold text-slate-800">{{ $item->quantity }}</span> • ৳{{ number_format($item->unit_price) }} each
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-[#53a318] shrink-0">
                                        ৳{{ number_format($item->subtotal) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-3 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-center justify-between text-xs font-bold">
                            <span class="text-emerald-900 font-extrabold">Total Paid Amount:</span>
                            <span class="text-base font-black text-[#53a318]">৳{{ number_format($trackedOrder->total_amount) }}</span>
                        </div>
                    </div>

                    <!-- Shipping Address & Courier Info -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                            <span>📍</span>
                            <span>Destination & Courier Info</span>
                        </h4>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 text-xs">
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase block">Recipient</span>
                                <p class="font-bold text-slate-800 mt-0.5">{{ $trackedOrder->shipping_name }}</p>
                                <p class="text-slate-600 font-mono">{{ $trackedOrder->shipping_phone }}</p>
                            </div>

                            <div class="pt-2 border-t border-slate-200/60">
                                <span class="text-[10px] text-slate-400 font-bold uppercase block">Shipping Address</span>
                                <p class="font-medium text-slate-700 mt-0.5 leading-snug">{{ $trackedOrder->shipping_address }}</p>
                            </div>

                            <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase block">Courier Service</span>
                                    <span class="font-bold text-slate-800">{{ $trackedOrder->courier_name ?: 'Cartiva Express Network' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase block">Est. Delivery</span>
                                    <span class="font-bold text-emerald-700">2-3 Business Days</span>
                                </div>
                            </div>
                        </div>

                        <!-- Assurance Strip -->
                        <div class="p-3 rounded-2xl bg-blue-50/70 border border-blue-100 flex items-center space-x-2.5 text-xs text-blue-900 font-medium">
                            <span class="text-base shrink-0">🛡️</span>
                            <span>১০০% ফ্রি এক্সপ্রেস কুরিয়ার ডেলিভারি এবং কোয়ালিটি নিশ্চয়তা সম্পন্ন।</span>
                        </div>
                    </div>

                </div>

            </div>

        @elseif($searched)
            <!-- NOT FOUND STATE -->
            <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center max-w-md mx-auto shadow-sm space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mx-auto text-2xl">
                    🔍
                </div>
                <h3 class="text-base font-bold text-slate-900">অর্ডারটি পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    '<span class="font-mono font-bold text-slate-700">{{ $query }}</span>' নম্বরে কোনো অর্ডার খুঁজে পাওয়া যায়নি। অনুগ্রহ করে সঠিক অর্ডার কোড বা ফোন নম্বর দিয়ে পুনরায় চেষ্টা করুন।
                </p>
                <div class="pt-2">
                    <a href="{{ route('orders.track') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl inline-block transition-colors">
                        Clear Search
                    </a>
                </div>
            </div>
        @else
            <!-- EMPTY / INTRO GUIDE STATE -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-4">
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-2">
                    <span class="w-10 h-10 rounded-2xl bg-emerald-50 text-[#53a318] flex items-center justify-center text-lg font-black mb-3">
                        ⚡
                    </span>
                    <h4 class="text-sm font-bold text-slate-900">রিয়েল-টাইম ট্র্যাকিং</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">অর্ডার তৈরি হওয়া থেকে শুরু করে কুরিয়ার ডেলিভারি পর্যন্ত প্রতি মুহূর্তের লাইভ আপডেট দেখুন।</p>
                </div>
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-2">
                    <span class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg font-black mb-3">
                        👥
                    </span>
                    <h4 class="text-sm font-bold text-slate-900">টিম পুল প্রগ্রেস</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">গ্রুপ পুলে আর কতজন মেম্বার বাকি আছে এবং কাউন্টডাউন টাইমার সরাসরি পর্যবেক্ষণ করুন।</p>
                </div>
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-2">
                    <span class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-black mb-3">
                        🛡️
                    </span>
                    <h4 class="text-sm font-bold text-slate-900">১০০% অটো-রিফান্ড সুরক্ষা</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">নির্ধারিত সময়ে টিম পূরণ না হলে তাৎক্ষণিকভাবে ১০০% রিফান্ড অ্যাকাউন্টে যুক্ত হবে।</p>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
