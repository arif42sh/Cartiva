@extends('layouts.app')

@section('title', 'My Account & Delivery Address - Cartiva')

@push('styles')
<!-- Leaflet CSS for Foodpanda-style Interactive Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .leaflet-control-attribution {
        font-size: 9px !important;
        opacity: 0.65;
    }
    .pin-bounce {
        animation: dropPin 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes dropPin {
        0% { transform: translateY(-16px) scale(1.1); }
        100% { transform: translateY(0) scale(1); }
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    <!-- Form Validation Errors (if any) -->
    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
            <div class="flex items-center space-x-2 font-bold text-xs sm:text-sm mb-1 text-rose-900">
                <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Please fix the following:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 ml-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Overview Card (Clean Enterprise Design) -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            
            <!-- User Info & Avatar -->
            <div class="flex items-center space-x-5">
                <div class="relative flex-shrink-0">
                    <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700 font-bold text-2xl shadow-xs">
                        @if($user->avatar)
                            <img id="header-avatar-preview" src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span id="header-avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">{{ $user->name }}</h1>
                        
                        @if($user->isAdmin())
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                <svg class="w-3 h-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Administrator
                            </span>
                        @elseif($user->isSeller())
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                                <svg class="w-3 h-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Merchant Partner
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Verified Account
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 mt-1.5">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $user->email }}
                        </span>
                        @if($user->phone)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $user->phone }}
                            </span>
                        @endif
                        <span class="text-slate-400">Member since {{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="flex items-center gap-4 sm:gap-6 border-t md:border-t-0 md:border-l border-slate-200 pt-4 md:pt-0 md:pl-6">
                <div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Total Savings</span>
                    <span class="text-lg font-bold text-[#53a318]">৳{{ number_format($estimatedSavings > 0 ? $estimatedSavings : 1450) }}</span>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Total Orders</span>
                    <span class="text-lg font-bold text-slate-800">{{ $orders->count() }}</span>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Active Pools</span>
                    <span class="text-lg font-bold text-slate-800">{{ $activeGroups->count() ?: 2 }}</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Main Tabs & Body -->
    <div x-data="{ activeTab: 'address' }" class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left Sidebar Navigation -->
        <div class="lg:col-span-1 space-y-2">
            <div class="bg-white rounded-2xl p-2.5 border border-slate-200 shadow-xs space-y-1">
                
                <button @click="activeTab = 'address'; setTimeout(() => { if (window.deliveryMap) window.deliveryMap.invalidateSize(); }, 200)" 
                        :class="activeTab === 'address' ? 'bg-[#53a318] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-50'"
                        class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Delivery Address & Map</span>
                </button>

                <button @click="activeTab = 'profile'" 
                        :class="activeTab === 'profile' ? 'bg-[#53a318] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-50'"
                        class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Profile Photo & Info</span>
                </button>

                @if($user->isSeller() || $user->isAdmin())
                    <button @click="activeTab = 'merchant'" 
                            :class="activeTab === 'merchant' ? 'bg-[#53a318] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-50'"
                            class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Merchant Store Details</span>
                    </button>
                @endif

                <button @click="activeTab = 'security'" 
                        :class="activeTab === 'security' ? 'bg-[#53a318] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-50'"
                        class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Password & Security</span>
                </button>

                <button @click="activeTab = 'orders'" 
                        :class="activeTab === 'orders' ? 'bg-[#53a318] text-white shadow-xs' : 'text-slate-700 hover:bg-slate-50'"
                        class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span>My Orders & Pools</span>
                </button>

            </div>

            <!-- Referral Card (Clean) -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs text-xs text-slate-600">
                <span class="font-bold text-slate-900 block mb-1">Referral Program</span>
                <p class="text-[11px] text-slate-500 mb-3 leading-relaxed">
                    Share your invite link with friends. Unlock higher group tier discounts automatically.
                </p>
                <button type="button" 
                        onclick="navigator.clipboard.writeText('{{ url('/') }}'); alert('Referral link copied to clipboard!')"
                        class="w-full py-2 px-3 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 hover:bg-slate-100 font-semibold text-slate-700 text-xs transition-colors cursor-pointer">
                    Copy Invite Link
                </button>
            </div>
        </div>

        <!-- Right Content Panels -->
        <div class="lg:col-span-3">

            <!-- TAB 1: FOODPANDA-STYLE INTERACTIVE MAP & DELIVERY ADDRESS -->
            <div x-show="activeTab === 'address'" class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                
                <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-slate-900">Delivery Address & Location Map</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Move the map or search to pinpoint your exact delivery doorstep.</p>
                    </div>

                    <!-- Locate Me GPS Button -->
                    <button type="button" id="locate-me-btn" onclick="locateUserPosition()" 
                            class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs shadow-xs transition-colors cursor-pointer self-start sm:self-auto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Use My Current Location</span>
                    </button>
                </div>

                <!-- Foodpanda Map Container with Floating Real-Time Autocomplete Search & Center Pin -->
                <div class="relative w-full h-[360px] sm:h-[420px] rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-inner">
                    
                    <!-- 1. Real-time Autocomplete Place Search Bar (Floating on top of Map) -->
                    <div class="absolute top-3 left-3 right-3 z-[1000] max-w-lg mx-auto">
                        <div class="relative">
                            <input type="text" id="map-search-input" 
                                   placeholder="Search road, area, sector or landmark (e.g. Uttara Sector 7, Dhanmondi 27)..." 
                                   autocomplete="off"
                                   class="w-full pl-9 pr-9 py-2.5 rounded-xl bg-white/95 backdrop-blur-md border border-slate-200 text-xs font-semibold text-slate-900 shadow-lg focus:outline-none focus:ring-2 focus:ring-[#53a318]"
                                   oninput="handleSearchInput(event)">
                            
                            <!-- Search Icon -->
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            
                            <!-- Clear / Loader Icon -->
                            <div id="search-spinner" class="hidden absolute right-3 top-3">
                                <svg class="animate-spin h-4 w-4 text-[#53a318]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Real-time Autocomplete Suggestions Dropdown -->
                        <div id="search-suggestions-dropdown" 
                             class="hidden mt-1 bg-white rounded-xl shadow-2xl border border-slate-200/90 divide-y divide-slate-100 max-h-60 overflow-y-auto z-[1001]">
                        </div>
                    </div>

                    <!-- 2. Leaflet Map Canvas -->
                    <div id="delivery-map" class="w-full h-full z-0"></div>

                    <!-- 3. Foodpanda Center Pin Overlay (Fixed at map center with hover shadow) -->
                    <div id="center-pin-container" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-full pointer-events-none z-[800] transition-transform duration-150 ease-out">
                        <div class="relative flex flex-col items-center">
                            <!-- Pin Icon -->
                            <div id="center-pin-icon" class="transition-transform duration-150 ease-out origin-bottom">
                                <svg width="34" height="44" viewBox="0 0 24 32" fill="none" class="filter drop-shadow-md">
                                    <path d="M12 0C5.37 0 0 5.37 0 12C0 21 12 32 12 32C12 32 24 21 24 12C24 5.37 18.63 0 12 0Z" fill="#e11d48"/>
                                    <circle cx="12" cy="12" r="5" fill="#ffffff"/>
                                </svg>
                            </div>
                            <!-- Shadow under Pin -->
                            <div id="center-pin-shadow" class="w-4 h-1.5 bg-black/35 rounded-full blur-[1px] -mt-1 transition-all duration-150"></div>
                        </div>
                    </div>

                    <!-- 4. Recenter to GPS Location Float Button (Bottom Right) -->
                    <button type="button" onclick="locateUserPosition()" 
                            title="Recenter to GPS location"
                            class="absolute bottom-16 sm:bottom-14 right-3 z-[900] w-9 h-9 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 shadow-md flex items-center justify-center transition-transform hover:scale-105 cursor-pointer">
                        <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </button>

                    <!-- 5. Foodpanda Floating Live Location Card (Bottom of Map) -->
                    <div class="absolute bottom-2 left-2 right-2 sm:left-3 sm:right-3 z-[900] pointer-events-auto">
                        <div class="bg-white/95 backdrop-blur-md border border-slate-200/90 rounded-xl p-3 shadow-lg flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                            <div class="flex items-start space-x-2.5 min-w-0">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100 flex-shrink-0 mt-1 animate-pulse"></span>
                                <div class="min-w-0">
                                    <h4 id="detected-title" class="text-xs font-bold text-slate-900 truncate">Detecting location...</h4>
                                    <p id="detected-subtitle" class="text-[11px] text-slate-500 truncate mt-0.5">Move the map to set exact building position</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 flex-shrink-0 self-end sm:self-auto">
                                <span id="coords-display" class="font-mono text-[10px] text-slate-400 hidden sm:inline">23.8103, 90.4125</span>
                                <button type="button" onclick="focusOnDetails()" 
                                        class="px-3 py-1.5 rounded-lg bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-[11px] shadow-xs transition-colors cursor-pointer">
                                    Confirm Pin Location
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Address Input Form -->
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4 pt-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="address">
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="phone" id="hidden-phone" value="{{ $user->phone }}">

                    <!-- Address Type Chips (Foodpanda Style) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Save Location As</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="setAddressTag('Home')" 
                                    class="address-tag-btn px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:border-[#53a318] transition-colors" data-tag="Home">
                                Home
                            </button>
                            <button type="button" onclick="setAddressTag('Work')" 
                                    class="address-tag-btn px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:border-[#53a318] transition-colors" data-tag="Work">
                                Work / Office
                            </button>
                            <button type="button" onclick="setAddressTag('Other')" 
                                    class="address-tag-btn px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:border-[#53a318] transition-colors" data-tag="Other">
                                Other
                            </button>
                        </div>
                    </div>

                    <!-- Detailed Street & House Breakdown -->
                    <div id="address-details-section" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Floor / Flat / House No.</label>
                            <input type="text" id="input-house" placeholder="e.g. Flat 4B, House 24, Floor 4" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none"
                                   oninput="updateCombinedAddress()">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Road / Street Name</label>
                            <input type="text" id="input-road" placeholder="e.g. Road 11, Block D" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none"
                                   oninput="updateCombinedAddress()">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Area / Sector / Thana</label>
                            <input type="text" id="input-area" placeholder="e.g. Banani, Uttara Sector 7, Mirpur 10" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none"
                                   oninput="updateCombinedAddress()">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">City / District</label>
                            <input type="text" id="input-city" placeholder="e.g. Dhaka" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none"
                                   oninput="updateCombinedAddress()">
                        </div>
                    </div>

                    <!-- Landmark / Delivery Directions -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nearby Landmark / Delivery Instruction (Optional)</label>
                        <input type="text" id="input-landmark" placeholder="e.g. Opposite to Central Mosque, Behind City Bank ATM" 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none"
                               oninput="updateCombinedAddress()">
                    </div>

                    <!-- Full Combined Address Textarea -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold text-slate-700">Complete Delivery Address</label>
                            <span class="text-[11px] text-slate-400">Auto-assembled from map and inputs</span>
                        </div>
                        <textarea id="full-address-textarea" name="address" rows="3" required
                                  placeholder="Complete address will be auto-generated as you move the map pin or type above..."
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none resize-none leading-relaxed">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <!-- Delivery Contact Phone -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Contact Phone Number (For Courier Rider)</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 017XXXXXXXX"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none"
                               oninput="document.getElementById('hidden-phone').value = this.value">
                    </div>

                    <!-- Save Address Button -->
                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs sm:text-sm shadow-xs transition-colors cursor-pointer flex items-center space-x-1.5">
                            <span>Save Delivery Address</span>
                            <span>&rarr;</span>
                        </button>
                    </div>

                </form>
            </div>

            <!-- TAB 2: PROFILE PHOTO & PERSONAL INFO -->
            <div x-show="activeTab === 'profile'" class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">Personal Information & Photo</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Update your display name and profile picture.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="profile">
                    <input type="hidden" name="address" value="{{ $user->address }}">

                    <!-- Avatar Uploader -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-200 border border-slate-300 flex items-center justify-center text-slate-600 font-bold text-xl flex-shrink-0">
                            <img id="form-avatar-preview" 
                                 src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f1f5f9&color=475569&size=128' }}" 
                                 alt="Avatar" class="w-full h-full object-cover">
                        </div>

                        <div class="space-y-2 text-center sm:text-left flex-1">
                            <div class="flex flex-wrap items-center gap-3 justify-center sm:justify-start">
                                <label for="avatar-file-input" 
                                       class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition-colors cursor-pointer inline-flex items-center space-x-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Upload Photo</span>
                                </label>
                                <input type="file" id="avatar-file-input" name="avatar" accept="image/*" class="hidden" onchange="previewUserAvatar(event)">

                                @if($user->avatar)
                                    <label class="inline-flex items-center space-x-1.5 text-xs text-rose-600 font-semibold cursor-pointer">
                                        <input type="checkbox" name="remove_avatar" value="1" class="rounded text-rose-600 focus:ring-rose-500">
                                        <span>Remove current photo</span>
                                    </label>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-500">Supports JPG, PNG or WebP (Max 4MB).</p>
                        </div>
                    </div>

                    <!-- Personal Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-xs sm:text-sm font-medium text-slate-500 cursor-not-allowed">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 017XXXXXXXX"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs sm:text-sm shadow-xs transition-colors cursor-pointer">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>

            <!-- TAB 3: MERCHANT INFO -->
            @if($user->isSeller() || $user->isAdmin())
            <div x-show="activeTab === 'merchant'" class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-slate-900">Merchant Storefront Details</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Manage your shop name and business category.</p>
                    </div>
                    <a href="{{ route('seller.dashboard') }}" class="px-3.5 py-1.5 rounded-xl border border-slate-200 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors">
                        Open Seller Hub &rarr;
                    </a>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="merchant">
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">
                    <input type="hidden" name="address" value="{{ $user->address }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Shop / Brand Name</label>
                            <input type="text" name="shop_name" value="{{ old('shop_name', $user->shop_name) }}" placeholder="e.g. Apex Tech & Lifestyle Hub"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Primary Business Category</label>
                            <select name="business_category" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-[#53a318] focus:outline-none">
                                <option value="">Select Category...</option>
                                <option value="smart-tech-audio" {{ old('business_category', $user->business_category) == 'smart-tech-audio' ? 'selected' : '' }}>Audio & Smart Tech</option>
                                <option value="winter-specials" {{ old('business_category', $user->business_category) == 'winter-specials' ? 'selected' : '' }}>Winter Apparel & Fashion</option>
                                <option value="wearables-watches" {{ old('business_category', $user->business_category) == 'wearables-watches' ? 'selected' : '' }}>Wearables & Gadgets</option>
                                <option value="dry-food-fmcg" {{ old('business_category', $user->business_category) == 'dry-food-fmcg' ? 'selected' : '' }}>Food & Grocery Wholesale</option>
                                <option value="kitchen-appliances" {{ old('business_category', $user->business_category) == 'kitchen-appliances' ? 'selected' : '' }}>Kitchen & Home Living</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors cursor-pointer">
                            Update Store Details
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- TAB 4: PASSWORD & SECURITY -->
            <div x-show="activeTab === 'security'" class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">Password & Security</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Ensure your account is using a strong password.</p>
                </div>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-4 max-w-md">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-slate-900 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">New Password</label>
                        <input type="password" name="password" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-slate-900 focus:outline-none">
                        <span class="text-[11px] text-slate-400 mt-1 block">Minimum 8 characters.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:ring-2 focus:ring-slate-900 focus:outline-none">
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors cursor-pointer">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 5: ORDERS & ACTIVE POOLS -->
            <div x-show="activeTab === 'orders'" class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                        <h3 class="text-base font-bold text-slate-900">Active Group Buy Circles</h3>
                        <a href="{{ route('home') }}#active-deals" class="text-xs font-semibold text-[#53a318] hover:underline">
                            Browse Deals &rarr;
                        </a>
                    </div>

                    @if($activeGroups->isEmpty())
                        <div class="p-6 rounded-xl bg-slate-50 border border-slate-100 text-center text-xs text-slate-500">
                            No ongoing group sessions at the moment.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($activeGroups as $membership)
                                @if($membership->session)
                                <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-2xs">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                            @if($membership->session->product && $membership->session->product->image)
                                                <img src="{{ $membership->session->product->image }}" alt="" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-slate-900 truncate">{{ $membership->session->product->title ?? 'Group Deal' }}</p>
                                            <span class="text-[10px] font-mono font-bold text-[#53a318]">{{ $membership->session->group_code }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between text-[11px] pt-2 border-t border-slate-100">
                                        <span class="font-medium text-slate-500">{{ $membership->session->members->count() }}/{{ $membership->session->required_members }} joined</span>
                                        <a href="{{ route('group-buy.show', $membership->session->group_code) }}" class="text-xs font-bold text-[#53a318] hover:underline">View Circle &rarr;</a>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                        <h3 class="text-base font-bold text-slate-900">Recent Purchases</h3>
                        <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-[#53a318] hover:underline">
                            View All &rarr;
                        </a>
                    </div>

                    @if($orders->isEmpty())
                        <div class="p-6 rounded-xl bg-slate-50 border border-slate-100 text-center text-xs text-slate-500">
                            No orders placed yet.
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($orders as $order)
                                <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono font-bold text-slate-800">{{ $order->order_number }}</span>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $order->order_type === 'group_buy' ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $order->order_type === 'group_buy' ? 'Group Buy' : 'Single Buy' }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="font-bold text-slate-900">৳{{ number_format($order->total_amount, 2) }}</span>
                                        <a href="{{ route('orders.show', $order) }}" class="px-3 py-1 rounded-lg border border-slate-200 hover:border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition-colors">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>

</div>

@push('scripts')
<!-- Leaflet JS for Foodpanda Map -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
let deliveryMap = null;
let currentAddressTag = 'Home';
let searchDebounceTimer = null;
let isProgrammaticMove = false;

// Default Center: Dhaka coordinates
let defaultLat = 23.8103;
let defaultLng = 90.4125;

function initMap() {
    const mapElement = document.getElementById('delivery-map');
    if (!mapElement) return;

    if (deliveryMap) {
        setTimeout(() => { deliveryMap.invalidateSize(); }, 200);
        return;
    }

    deliveryMap = L.map('delivery-map', {
        center: [defaultLat, defaultLng],
        zoom: 15,
        zoomControl: false // custom position
    });

    // Zoom control at top-right
    L.control.zoom({ position: 'topright' }).addTo(deliveryMap);

    // High quality OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(deliveryMap);

    const pinIcon = document.getElementById('center-pin-icon');
    const pinShadow = document.getElementById('center-pin-shadow');

    // Foodpanda-Style Pin Elevation Animation when moving map
    deliveryMap.on('movestart', function () {
        if (pinIcon) {
            pinIcon.style.transform = 'translateY(-12px) scale(1.08)';
        }
        if (pinShadow) {
            pinShadow.style.transform = 'scale(0.6)';
            pinShadow.style.opacity = '0.25';
        }
    });

    // When map finishes panning or zooming, drop pin and reverse geocode
    deliveryMap.on('moveend', function () {
        if (pinIcon) {
            pinIcon.style.transform = 'translateY(0) scale(1)';
            pinIcon.classList.add('pin-bounce');
            setTimeout(() => pinIcon.classList.remove('pin-bounce'), 350);
        }
        if (pinShadow) {
            pinShadow.style.transform = 'scale(1)';
            pinShadow.style.opacity = '0.35';
        }

        const center = deliveryMap.getCenter();
        updateCoordsUI(center.lat, center.lng);

        if (!isProgrammaticMove) {
            reverseGeocode(center.lat, center.lng);
        }
        isProgrammaticMove = false;
    });

    // Clicking anywhere on map smoothly recenters to that exact clicked point
    deliveryMap.on('click', function (e) {
        deliveryMap.panTo(e.latlng, { animate: true, duration: 0.6 });
    });

    // Check if user already has an address, otherwise initialize geocode on default center
    const existingAddress = document.getElementById('full-address-textarea').value.trim();
    if (!existingAddress) {
        reverseGeocode(defaultLat, defaultLng);
    } else {
        // Try searching the existing address to center map
        geocodeAndCenter(existingAddress);
    }
}

function updateCoordsUI(lat, lng) {
    const coordsEl = document.getElementById('coords-display');
    if (coordsEl) {
        coordsEl.textContent = lat.toFixed(4) + ', ' + lng.toFixed(4);
    }
}

// 1. REAL-TIME AUTOCOMPLETE SEARCH (Photon + Nominatim fallback)
function handleSearchInput(e) {
    const query = e.target.value.trim();
    const dropdown = document.getElementById('search-suggestions-dropdown');
    const spinner = document.getElementById('search-spinner');

    clearTimeout(searchDebounceTimer);

    if (query.length < 2) {
        if (dropdown) {
            dropdown.classList.add('hidden');
            dropdown.innerHTML = '';
        }
        if (spinner) spinner.classList.add('hidden');
        return;
    }

    if (spinner) spinner.classList.remove('hidden');

    searchDebounceTimer = setTimeout(() => {
        // Fast Photon API prioritizing Bangladesh
        const url = `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&lat=23.8103&lon=90.4125&limit=6`;
        
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (spinner) spinner.classList.add('hidden');
                if (data && data.features && data.features.length > 0) {
                    renderSearchSuggestions(data.features);
                } else {
                    // Fallback to Nominatim search
                    fallbackNominatimSearch(query);
                }
            })
            .catch(() => {
                fallbackNominatimSearch(query);
            });
    }, 280);
}

function fallbackNominatimSearch(query) {
    const spinner = document.getElementById('search-spinner');
    fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(query)}&countrycodes=bd&limit=5&accept-language=en`)
        .then(res => res.json())
        .then(data => {
            if (spinner) spinner.classList.add('hidden');
            if (data && data.length > 0) {
                renderNominatimSuggestions(data);
            } else {
                showNoResults();
            }
        })
        .catch(() => {
            if (spinner) spinner.classList.add('hidden');
            showNoResults();
        });
}

function renderSearchSuggestions(features) {
    const dropdown = document.getElementById('search-suggestions-dropdown');
    if (!dropdown) return;

    dropdown.innerHTML = '';
    features.forEach(f => {
        const props = f.properties;
        const coords = f.geometry.coordinates; // [lng, lat]
        const lat = coords[1];
        const lng = coords[0];

        const title = props.name || props.street || props.locality || props.district || 'Location';
        const subtitle = [props.street, props.locality, props.district, props.city || props.state, props.country]
            .filter(Boolean)
            .filter((v, i, arr) => arr.indexOf(v) === i)
            .join(', ');

        const item = document.createElement('div');
        item.className = 'p-3 hover:bg-slate-50 cursor-pointer transition-colors flex items-start space-x-2.5';
        item.innerHTML = `
            <svg class="w-4 h-4 text-[#53a318] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">${title}</p>
                <p class="text-[10px] text-slate-500 truncate">${subtitle}</p>
            </div>
        `;

        item.onclick = function () {
            selectLocationFromSearch(lat, lng, title, subtitle, props);
        };

        dropdown.appendChild(item);
    });

    dropdown.classList.remove('hidden');
}

function renderNominatimSuggestions(items) {
    const dropdown = document.getElementById('search-suggestions-dropdown');
    if (!dropdown) return;

    dropdown.innerHTML = '';
    items.forEach(item => {
        const lat = parseFloat(item.lat);
        const lng = parseFloat(item.lon);
        const title = item.name || item.display_name.split(',')[0];
        const subtitle = item.display_name;

        const row = document.createElement('div');
        row.className = 'p-3 hover:bg-slate-50 cursor-pointer transition-colors flex items-start space-x-2.5';
        row.innerHTML = `
            <svg class="w-4 h-4 text-[#53a318] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">${title}</p>
                <p class="text-[10px] text-slate-500 truncate">${subtitle}</p>
            </div>
        `;

        row.onclick = function () {
            selectLocationFromSearch(lat, lng, title, subtitle, {});
        };

        dropdown.appendChild(row);
    });

    dropdown.classList.remove('hidden');
}

function showNoResults() {
    const dropdown = document.getElementById('search-suggestions-dropdown');
    if (!dropdown) return;
    dropdown.innerHTML = '<div class="p-3 text-xs text-slate-500 text-center font-medium">No locations found. Try road or sector name.</div>';
    dropdown.classList.remove('hidden');
}

function selectLocationFromSearch(lat, lng, title, subtitle, props) {
    const dropdown = document.getElementById('search-suggestions-dropdown');
    if (dropdown) dropdown.classList.add('hidden');

    const searchInput = document.getElementById('map-search-input');
    if (searchInput) searchInput.value = title;

    if (deliveryMap) {
        isProgrammaticMove = true;
        deliveryMap.flyTo([lat, lng], 17, { duration: 1.2 });
    }

    // Populate road/area directly if provided by Photon
    if (props && Object.keys(props).length > 0) {
        if (document.getElementById('input-house') && props.housenumber) document.getElementById('input-house').value = props.housenumber;
        if (document.getElementById('input-road') && props.street) document.getElementById('input-road').value = props.street;
        if (document.getElementById('input-area') && (props.locality || props.district)) document.getElementById('input-area').value = props.locality || props.district;
        if (document.getElementById('input-city') && (props.city || props.state)) document.getElementById('input-city').value = props.city || props.state;
    }

    updateDetectedBanner(title, subtitle);
    reverseGeocode(lat, lng);
}

// 2. REVERSE GEOCODING (Converts pin lat/lng into exact Building, Road, Area, City)
function reverseGeocode(lat, lng) {
    updateDetectedBanner('Fetching exact address...', lat.toFixed(4) + ', ' + lng.toFixed(4));

    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=en`)
        .then(res => res.json())
        .then(data => {
            if (data && data.address) {
                const addr = data.address;

                const house = addr.house_number || addr.building || '';
                const road = addr.road || addr.residential || addr.street || addr.footway || addr.path || '';
                const area = addr.neighbourhood || addr.suburb || addr.quarter || addr.city_district || addr.hamlet || addr.village || '';
                const city = addr.city || addr.town || addr.municipality || addr.state_district || addr.state || 'Dhaka';

                if (document.getElementById('input-road') && road) document.getElementById('input-road').value = road;
                if (document.getElementById('input-area') && area) document.getElementById('input-area').value = area;
                if (document.getElementById('input-city') && city) document.getElementById('input-city').value = city;
                if (document.getElementById('input-house') && house) document.getElementById('input-house').value = house;

                const primaryTitle = [house, road].filter(Boolean).join(', ') || area || city || 'Selected Pin Location';
                const secondarySubtitle = data.display_name || [area, city, addr.country].filter(Boolean).join(', ');

                updateDetectedBanner(primaryTitle, secondarySubtitle);
                updateCombinedAddress();
            }
        })
        .catch(() => {
            // Photon reverse fallback
            fetch(`https://photon.komoot.io/reverse?lat=${lat}&lon=${lng}`)
                .then(r => r.json())
                .then(fallbackData => {
                    if (fallbackData && fallbackData.features && fallbackData.features.length > 0) {
                        const p = fallbackData.features[0].properties;
                        if (document.getElementById('input-road') && p.street) document.getElementById('input-road').value = p.street;
                        if (document.getElementById('input-area') && (p.locality || p.district)) document.getElementById('input-area').value = p.locality || p.district;
                        if (document.getElementById('input-city') && (p.city || p.state)) document.getElementById('input-city').value = p.city || p.state;
                        
                        const title = p.name || p.street || 'Selected Pin Location';
                        const subtitle = [p.locality, p.district, p.city, p.country].filter(Boolean).join(', ');
                        updateDetectedBanner(title, subtitle);
                        updateCombinedAddress();
                    }
                })
                .catch(() => {
                    updateDetectedBanner('Location Pin Pointed', lat.toFixed(4) + ', ' + lng.toFixed(4));
                });
        });
}

function updateDetectedBanner(title, subtitle) {
    const t = document.getElementById('detected-title');
    const s = document.getElementById('detected-subtitle');
    if (t) t.textContent = title;
    if (s) s.textContent = subtitle;
}

// 3. LOCATE USER VIA HIGH ACCURACY GPS
function locateUserPosition() {
    const locateBtn = document.getElementById('locate-me-btn');
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser.');
        return;
    }

    if (locateBtn) {
        locateBtn.innerHTML = `
            <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <span>Finding exact GPS...</span>
        `;
        locateBtn.disabled = true;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            if (deliveryMap) {
                isProgrammaticMove = true;
                deliveryMap.flyTo([lat, lng], 17, { duration: 1.5 });
            }

            reverseGeocode(lat, lng);

            if (locateBtn) {
                locateBtn.innerHTML = `
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Exact Location Locked</span>
                `;
                setTimeout(() => {
                    locateBtn.innerHTML = `
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Use My Current Location</span>
                    `;
                    locateBtn.disabled = false;
                }, 3000);
            }
        },
        function (error) {
            let msg = 'Unable to retrieve location.';
            if (error.code === 1) msg = 'Location permission denied. Please allow GPS access in your browser settings.';
            alert(msg);
            if (locateBtn) {
                locateBtn.innerHTML = '<span>Use My Current Location</span>';
                locateBtn.disabled = false;
            }
        },
        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
    );
}

// 4. FOCUS ON DETAILS
function focusOnDetails() {
    const el = document.getElementById('input-house');
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        el.focus();
    }
}

// 5. ADDRESS TAG SELECTOR
function setAddressTag(tag) {
    currentAddressTag = tag;
    document.querySelectorAll('.address-tag-btn').forEach(btn => {
        if (btn.getAttribute('data-tag') === tag) {
            btn.classList.add('bg-slate-900', 'text-white', 'border-slate-900');
            btn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
        } else {
            btn.classList.remove('bg-slate-900', 'text-white', 'border-slate-900');
            btn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
        }
    });
    updateCombinedAddress();
}

// 6. SYNCHRONIZE COMBINED ADDRESS TEXTAREA
function updateCombinedAddress() {
    const house = document.getElementById('input-house') ? document.getElementById('input-house').value.trim() : '';
    const road = document.getElementById('input-road') ? document.getElementById('input-road').value.trim() : '';
    const area = document.getElementById('input-area') ? document.getElementById('input-area').value.trim() : '';
    const city = document.getElementById('input-city') ? document.getElementById('input-city').value.trim() : '';
    const landmark = document.getElementById('input-landmark') ? document.getElementById('input-landmark').value.trim() : '';

    const parts = [];
    if (house) parts.push(house);
    if (road) parts.push(road);
    if (area) parts.push(area);
    if (city) parts.push(city);
    if (landmark) parts.push(`(${landmark})`);

    let full = parts.join(', ');
    if (currentAddressTag && full) {
        full += ` [${currentAddressTag}]`;
    }

    if (full) {
        document.getElementById('full-address-textarea').value = full;
    }
}

function geocodeAndCenter(addressStr) {
    if (!addressStr) return;
    const cleanQuery = addressStr.replace(/\[.*?\]|\(.*?\)/g, '').split(',').slice(0, 3).join(' ').trim();
    if (cleanQuery.length > 3) {
        fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(cleanQuery)}&countrycodes=bd&limit=1`)
            .then(r => r.json())
            .then(res => {
                if (res && res.length > 0 && deliveryMap) {
                    const lat = parseFloat(res[0].lat);
                    const lon = parseFloat(res[0].lon);
                    isProgrammaticMove = true;
                    deliveryMap.setView([lat, lon], 16);
                    updateCoordsUI(lat, lon);
                }
            })
            .catch(() => {});
    }
}

// Close search suggestions on click outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('search-suggestions-dropdown');
    const searchInput = document.getElementById('map-search-input');
    if (dropdown && !dropdown.contains(e.target) && e.target !== searchInput) {
        dropdown.classList.add('hidden');
    }
});

// Live Avatar Image Preview
function previewUserAvatar(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const formPreview = document.getElementById('form-avatar-preview');
            if (formPreview) formPreview.src = e.target.result;

            const headerPreview = document.getElementById('header-avatar-preview');
            if (headerPreview) {
                headerPreview.src = e.target.result;
            } else {
                const initial = document.getElementById('header-avatar-initial');
                if (initial && initial.parentElement) {
                    initial.parentElement.innerHTML = '<img id="header-avatar-preview" src="' + e.target.result + '" class="w-full h-full object-cover">';
                }
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setAddressTag('Home');
    initMap();
});
</script>
@endpush
@endsection
