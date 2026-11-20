@extends('layouts.seller')

@section('title', ($seller->shop_name ?? $seller->name) . ' — Live Storefront Preview | Merchant Hub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6"
     x-data="{ viewMode: 'desktop', copied: false }">

    <!-- Unified Merchant Navigation -->
    @include('seller.partials.nav')

    <!-- Interactive Simulation & Control Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs flex flex-col xl:flex-row xl:items-center justify-between gap-3 sm:gap-4">
        
        <!-- Left: Title & Live Simulation Badge -->
        <div class="space-y-1">
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Integrated Storefront Preview</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-[#53a318] border border-emerald-200/80 shadow-2xs shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#53a318] mr-1.5 animate-pulse"></span>
                    Live Simulation
                </span>
            </div>
            <p class="text-xs text-slate-500">
                Explore how shoppers browse your official store page on desktop monitors and mobile smartphones.
            </p>
        </div>

        <!-- Right: Perfectly Sized, Uniform Toolbar Controls (All unified 36px height) -->
        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap shrink-0">
            
            <!-- Segmented Device Switcher (Exact 36px height) -->
            <div class="inline-flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200/80 h-9 shrink-0">
                <button type="button" 
                        @click="viewMode = 'desktop'"
                        :class="viewMode === 'desktop' ? 'bg-[#53a318] text-white shadow-2xs font-extrabold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="h-7 px-3 rounded-lg text-xs transition-all flex items-center space-x-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Desktop</span>
                </button>

                <button type="button" 
                        @click="viewMode = 'mobile'"
                        :class="viewMode === 'mobile' ? 'bg-[#53a318] text-white shadow-2xs font-extrabold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="h-7 px-3 rounded-lg text-xs transition-all flex items-center space-x-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>Mobile (390px)</span>
                </button>
            </div>

            <!-- Subtle Divider -->
            <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

            <!-- Copy Public Storefront URL (Exact 36px height) -->
            <button type="button"
                    @click="navigator.clipboard.writeText('{{ route('shop.show', $seller) }}'); copied = true; setTimeout(() => copied = false, 2500)"
                    class="h-9 px-3 rounded-xl border text-xs font-bold transition-all flex items-center space-x-1.5 cursor-pointer shrink-0 shadow-2xs"
                    :class="copied ? 'bg-emerald-50 border-emerald-300 text-emerald-700 font-extrabold' : 'bg-white hover:bg-slate-50 border-slate-200 text-slate-700'">
                <template x-if="!copied">
                    <span class="flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        <span>Copy Link</span>
                    </span>
                </template>
                <template x-if="copied">
                    <span class="flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Copied!</span>
                    </span>
                </template>
            </button>

            <!-- Edit Branding Shortcut (Exact 36px height) -->
            <a href="{{ route('seller.profile') }}" 
               class="h-9 px-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center space-x-1.5 shadow-2xs shrink-0">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit Branding</span>
            </a>

            <!-- Open in Dedicated Browser Window (Exact 36px height) -->
            <a href="{{ route('shop.show', $seller) }}" target="_blank"
               class="h-9 px-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-colors flex items-center space-x-1.5 shadow-2xs shrink-0"
               title="Open full public store page in a new browser tab">
                <span>Open External View</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>

        </div>

    </div>

    <!-- Preview Stage Canvas -->
    <div class="py-2 flex justify-center transition-all duration-300">
        
        <!-- Adaptive Device Shell -->
        <div :class="viewMode === 'mobile' 
                ? 'w-full max-w-[430px] bg-slate-950 p-4 rounded-[52px] shadow-2xl border-[5px] border-slate-700 ring-1 ring-white/10 transition-all duration-300' 
                : 'w-full bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden transition-all duration-300'">
            
            <!-- Mobile Top Bezel: Dynamic Island & Status Bar -->
            <div x-show="viewMode === 'mobile'" class="pt-0.5 pb-2.5 px-3 text-white select-none">
                <div class="flex items-center justify-between text-[11px] font-bold text-slate-300 mb-1">
                    <span>09:41</span>
                    <!-- Dynamic Island Camera Pill -->
                    <div class="w-24 h-4 bg-black rounded-full flex items-center justify-between px-2.5 shadow-inner">
                        <div class="w-1.5 h-1.5 rounded-full bg-teal-900/80"></div>
                        <div class="w-2 h-2 rounded-full bg-slate-800 ring-1 ring-slate-700"></div>
                    </div>
                    <div class="flex items-center space-x-1.5 text-slate-300">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm6-4a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zm6-3a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                        <span class="text-[9px] font-black">5G</span>
                        <div class="w-4 h-2 rounded-xs border border-slate-300 p-0.5 flex items-center"><div class="w-full h-full bg-slate-300 rounded-2xs"></div></div>
                    </div>
                </div>
            </div>

            <!-- Desktop Browser Chrome Header -->
            <div x-show="viewMode === 'desktop'" class="bg-slate-100/90 px-4 py-2.5 border-b border-slate-200 flex items-center justify-between text-xs select-none">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                </div>
                <div class="flex-1 max-w-lg mx-4">
                    <div class="bg-white rounded-lg px-3 py-1 border border-slate-200 text-slate-600 text-xs flex items-center space-x-2 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        <span class="font-mono text-[11px] truncate text-slate-800">https://cartiva.com/shop/{{ Str::slug($seller->shop_name ?? $seller->name) }}</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2 text-[11px] font-bold text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>100% Secure Checkout</span>
                </div>
            </div>

            <!-- Inner Storefront Canvas -->
            <div :class="viewMode === 'mobile' ? 'bg-[#f8f9fa] rounded-[38px] overflow-y-auto max-h-[760px] p-2.5 sm:p-3 scrollbar-thin' : 'p-5 sm:p-7'">
                @include('seller.storefront.content')
            </div>

            <!-- Mobile Bottom Home Indicator -->
            <div x-show="viewMode === 'mobile'" class="py-2 flex justify-center select-none">
                <div class="w-32 h-1 bg-slate-400 rounded-full"></div>
            </div>

        </div>

    </div>

</div>
@endsection
