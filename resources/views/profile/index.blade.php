@extends('layouts.app')

@section('title', 'My Account & Profile - Cartiva')

@push('styles')
<style>
    /* Classic Design System Variables */
    :root {
        --classic-navy: #0f172a;
        --classic-navy-deep: #0a192f;
        --classic-blue: #1d4ed8;
        --classic-blue-hover: #1e40af;
        --classic-blue-light: #eff6ff;
        --classic-gold: #d97706;
        --classic-gold-light: #fef3c7;
        --classic-border: #e2e8f0;
        --classic-bg: #f1f5f9;
        --classic-card: #ffffff;
    }

    /* Classic Tab Active Styles */
    .classic-tab-active {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25) !important;
        border-color: transparent !important;
    }

    .classic-tab-active svg {
        color: #93c5fd !important;
    }

    .classic-tab-inactive {
        color: #334155;
        background: transparent;
    }

    .classic-tab-inactive:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    /* Classic Primary Buttons */
    .btn-classic-primary {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
    }

    .btn-classic-primary:hover {
        background: linear-gradient(135deg, #1e293b 0%, #1d4ed8 100%);
        box-shadow: 0 4px 14px rgba(29, 78, 216, 0.35);
        transform: translateY(-1px);
    }

    .btn-classic-blue {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 8px rgba(29, 78, 216, 0.25);
    }

    .btn-classic-blue:hover {
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
        box-shadow: 0 4px 14px rgba(29, 78, 216, 0.4);
        transform: translateY(-1px);
    }

    /* Classic Input Styling */
    .classic-input {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        transition: all 0.15s ease-in-out;
    }

    .classic-input:focus {
        border-color: #1d4ed8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.15);
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="bg-[#f1f5f9] min-h-[calc(100vh-140px)] py-6 sm:py-8 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Classic Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-blue-700 transition-colors">Home</a>
            <span class="text-slate-400">/</span>
            <span class="text-slate-900 font-bold">My Account</span>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-xs flex items-center justify-between">
                <div class="flex items-center space-x-2.5 text-xs sm:text-sm font-semibold">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-sm font-bold">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 shadow-xs">
                <div class="flex items-center space-x-2 font-bold text-xs sm:text-sm mb-1 text-rose-950">
                    <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span>Please fix the following:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-800 ml-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main 2-Column Account Grid -->
        <div x-data="{ 
            activeTab: '{{ request('tab', 'profile') }}',
            switchTab(tab) { this.activeTab = tab; }
        }" class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8 items-start">

            <!-- LEFT COLUMN: Classic Navigation Sidebar -->
            <div class="lg:col-span-1 space-y-4">
                
                <!-- 1. Classic VIP Account Profile Card (Rich Navy & Gold Styling) -->
                <div class="relative overflow-hidden rounded-2xl border border-slate-700/30 p-5 shadow-md"
                     style="background: linear-gradient(145deg, #0f172a 0%, #1e293b 60%, #1e3a8a 100%);">
                    
                    <!-- Decorative subtle background circle -->
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-blue-500/10 pointer-events-none"></div>

                    <div class="flex items-center space-x-3.5 relative z-10">
                        <!-- Avatar with Classic Golden Accent Ring -->
                        <div class="relative w-14 h-14 rounded-full overflow-hidden bg-slate-800 border-2 border-amber-400/60 shadow-inner flex-shrink-0 flex items-center justify-center">
                            @if($user->avatar)
                                <img id="header-avatar-preview" src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <span id="header-avatar-initial" class="text-xl font-bold text-amber-300">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-[10px] tracking-wider uppercase font-bold text-emerald-400">Verified Member</span>
                            </div>
                            <h2 class="text-sm sm:text-base font-bold text-white truncate" title="{{ $user->name }}">{{ $user->name }}</h2>
                            <p class="text-[11px] text-slate-300 truncate">{{ $user->phone ?: $user->email }}</p>
                        </div>
                    </div>

                    <!-- Group Savings & Wallet Balance Ribbon (Matching Header Dropdown) -->
                    <div class="mt-4 pt-3 border-t border-slate-700/60 grid grid-cols-2 gap-2 relative z-10 text-center">
                        <div class="border-r border-slate-700/60 pr-2">
                            <span class="text-[9px] uppercase tracking-wider text-slate-400 font-semibold block leading-none">Group Savings</span>
                            <span class="text-xs sm:text-sm font-bold text-emerald-400 block mt-1 leading-tight">
                                ৳{{ number_format($user->total_savings) }} Saved
                            </span>
                        </div>
                        <div class="pl-2">
                            <span class="text-[9px] uppercase tracking-wider text-slate-400 font-semibold block leading-none">Wallet Balance</span>
                            <span class="text-xs sm:text-sm font-bold text-cyan-400 block mt-1 leading-tight">
                                ৳0.00 Credits
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 2. Classic Sidebar Menu Container -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden p-2">
                    
                    <!-- Section: Manage Account -->
                    <div class="px-3 pt-3 pb-1 text-[11px] font-bold tracking-wider text-slate-400 uppercase">
                        Manage My Account
                    </div>

                    <nav class="space-y-1">
                        <!-- Tab 1: Personal Profile -->
                        <button @click="switchTab('profile')" 
                                :class="activeTab === 'profile' ? 'classic-tab-active' : 'classic-tab-inactive'"
                                class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Personal Profile</span>
                        </button>

                        <!-- Tab 2: Address Book -->
                        <button @click="switchTab('address')" 
                                :class="activeTab === 'address' ? 'classic-tab-active' : 'classic-tab-inactive'"
                                class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Address Book</span>
                        </button>

                        <!-- Tab 3: Password & Security -->
                        <button @click="switchTab('security')" 
                                :class="activeTab === 'security' ? 'classic-tab-active' : 'classic-tab-inactive'"
                                class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span>Password & Security</span>
                        </button>
                    </nav>

                    <!-- Section: Orders & Activity -->
                    <div class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider text-slate-400 uppercase border-t border-slate-100 mt-2">
                        My Orders & Activity
                    </div>

                    <nav class="space-y-1">
                        <!-- Tab 4: My Orders -->
                        <button @click="switchTab('orders')" 
                                :class="activeTab === 'orders' ? 'classic-tab-active' : 'classic-tab-inactive'"
                                class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>My Orders ({{ $totalOrdersCount }})</span>
                        </button>

                        <!-- Tab 5: Active Team Pools -->
                        <button @click="switchTab('pools')" 
                                :class="activeTab === 'pools' ? 'classic-tab-active' : 'classic-tab-inactive'"
                                class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Active Team Pools ({{ $activeGroupsCount }})</span>
                        </button>

                    
                    </nav>

                    <!-- Section: Merchant Center (for Sellers / Admin) -->
                    @if($user->isSeller() || $user->isAdmin())
                        <div class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider text-slate-400 uppercase border-t border-slate-100 mt-2">
                            Merchant Center
                        </div>
                        <nav class="space-y-1">
                            <button @click="activeTab = 'merchant'" 
                                    :class="activeTab === 'merchant' ? 'classic-tab-active' : 'classic-tab-inactive'"
                                    class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left cursor-pointer">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span>Storefront Details</span>
                            </button>
                        </nav>
                    @endif

                    <!-- Sign Out Button -->
                    <div class="pt-2 border-t border-slate-100 mt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors cursor-pointer text-left">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>

                </div>

                <!-- 3. Classic Referral Bonus Card -->
                <div class="rounded-2xl p-4 border border-blue-200 shadow-xs"
                     style="background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);">
                    <div class="flex items-center space-x-2 text-blue-900 font-bold text-xs mb-1">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span>Team Pool Referral Bonus</span>
                    </div>
                    <p class="text-[11px] text-slate-600 mb-3 leading-relaxed">
                        Share your circle referral link to unlock higher discount tiers automatically.
                    </p>
                    <button type="button" 
                            onclick="navigator.clipboard.writeText('{{ url('/') }}'); alert('Referral link copied to clipboard!')"
                            class="w-full py-2 px-3 rounded-xl bg-white border border-blue-300 hover:border-blue-500 font-semibold text-blue-900 text-xs transition-colors shadow-2xs cursor-pointer">
                        Copy Invite Link
                    </button>
                </div>

            </div>

            <!-- RIGHT COLUMN: Classic Main Panels -->
            <div class="lg:col-span-3 space-y-6">

                <!-- ========================================== -->
                <!-- TAB 1: PERSONAL PROFILE (Classic Theme)    -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'profile'" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    
                    <!-- Card Header -->
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900">Personal Profile</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Manage your personal identification, contact info, and profile photo.</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-green-600" style="color: #16a34a;">
                            <svg class="w-4 h-4 flex-shrink-0" style="color: #16a34a;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Verified</span>
                        </span>

                    </div>

                    <!-- Classic Executive Overview Row -->
                    <div class="p-6 bg-slate-50/80 border-b border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-2xs">
                            <span class="text-slate-400 block text-[11px] font-semibold uppercase tracking-wider mb-1">Full Name</span>
                            <span class="font-bold text-slate-900 text-sm block truncate">{{ $user->name }}</span>
                        </div>
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-2xs">
                            <span class="text-slate-400 block text-[11px] font-semibold uppercase tracking-wider mb-1">Email Address</span>
                            <span class="font-semibold text-slate-800 text-xs truncate block" title="{{ $user->email }}">{{ $user->email }}</span>
                        </div>
                        <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-2xs">
                            <span class="text-slate-400 block text-[11px] font-semibold uppercase tracking-wider mb-1">Mobile Phone</span>
                            <span class="font-bold text-slate-900 text-sm block">{{ $user->phone ?: 'Not provided yet' }}</span>
                        </div>
                    </div>

                    <!-- Profile Edit Form -->
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="section" value="profile">
                        <input type="hidden" name="address" value="{{ $user->address }}">

                        <!-- Avatar Photo Upload (Fixed Classic Design) -->
                        <div class="flex flex-col sm:flex-row items-center gap-5 p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                            <!-- Avatar Preview with Ring -->
                            <div class="relative w-20 h-20 rounded-full overflow-hidden bg-slate-200 border-2 border-slate-300 shadow-sm flex-shrink-0 flex items-center justify-center">
                                <img id="form-avatar-preview" 
                                     src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0f172a&color=f8fafc&size=128' }}" 
                                     alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </div>

                            <div class="text-center sm:text-left flex-1 space-y-2">
                                <div class="flex flex-wrap items-center gap-3 justify-center sm:justify-start">
                                    <!-- High-contrast Classic Button for Avatar -->
                                    <label for="avatar-file-input" 
                                           class="btn-classic-primary px-4 py-2 rounded-xl font-semibold text-xs transition-all cursor-pointer inline-flex items-center space-x-2">
                                        <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Change Photo</span>
                                    </label>
                                    <input type="file" id="avatar-file-input" name="avatar" accept="image/*" class="hidden" onchange="previewUserAvatar(event)">

                                    
                                </div>
                                <p class="text-[11px] text-slate-500">Supports JPG, PNG or WebP image files up to 4MB.</p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1.5">Mobile Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +880 17XXXXXXXX"
                                       class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-800 mb-1.5">Email Address</label>
                                <div class="relative">
                                    <input type="email" value="{{ $user->email }}" disabled
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100/80 text-xs sm:text-sm font-semibold text-slate-500 cursor-not-allowed">
                                    <span class="absolute right-3.5 top-2.5 text-[11px] font-bold text-green-600 flex items-center gap-1" style="color: #16a34a;">
                                        <svg class="w-3.5 h-3.5" style="color: #16a34a;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Verified
                                    </span>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Account login email cannot be edited directly for security.</span>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end pt-4 border-t border-slate-100">
                            <button type="submit" 
                                    class="btn-classic-primary px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-sm inline-flex items-center space-x-2 cursor-pointer">
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ========================================== -->
                <!-- TAB 2: ADDRESS BOOK                        -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'address'" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    
                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900">Address Book</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Manage your shipping address and doorstep delivery details.</p>
                        </div>
                        @if($user->address)
                           
                        @endif
                    </div>

                    <div class="p-6 space-y-6">
                        @if($user->address)
                            <!-- Current Active Address Preview Card -->
                            <div class="p-4 rounded-xl border border-blue-200 bg-blue-50/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-start space-x-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-bold text-slate-900">{{ $user->name }}</span>
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-slate-900 text-white uppercase tracking-wider">{{ $user->address_tag ?: 'Home' }}</span>
                                        </div>
                                        <p class="text-xs text-slate-700 mt-1 font-medium leading-relaxed">{{ $user->address }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Phone: {{ $user->phone ?: 'Not provided' }}</p>
                                    </div>
                                </div>
                                <span class="text-[11px] font-bold text-blue-700 bg-white px-3 py-1 rounded-lg border border-blue-200 shadow-2xs self-start sm:self-auto">
                                    Primary Delivery
                                </span>
                            </div>
                        @endif

                        <!-- Address Form -->
                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="address">
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="phone" id="hidden-phone" value="{{ $user->phone }}">
                            <input type="hidden" name="address_tag" id="hidden-address-tag" value="{{ old('address_tag', $user->address_tag ?? 'Home') }}">

                            <!-- Address Tag Chips -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-2">Address Type</label>
                                <div class="flex items-center space-x-2">
                                    <button type="button" onclick="setAddressTag('Home')" 
                                            class="address-tag-btn px-4 py-1.5 rounded-xl border text-xs font-bold transition-all cursor-pointer {{ ($user->address_tag ?? 'Home') === 'Home' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200' }}" data-tag="Home">
                                        Home
                                    </button>
                                    <button type="button" onclick="setAddressTag('Work')" 
                                            class="address-tag-btn px-4 py-1.5 rounded-xl border text-xs font-bold transition-all cursor-pointer {{ ($user->address_tag ?? 'Home') === 'Work' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200' }}" data-tag="Work">
                                        Office
                                    </button>
                                    <button type="button" onclick="setAddressTag('Other')" 
                                            class="address-tag-btn px-4 py-1.5 rounded-xl border text-xs font-bold transition-all cursor-pointer {{ ($user->address_tag ?? 'Home') === 'Other' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200' }}" data-tag="Other">
                                        Other
                                    </button>
                                </div>
                            </div>

                            <!-- Structured Road / House Inputs -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1">House / Flat / Holding No.</label>
                                    <input type="text" id="input-house" placeholder="e.g. Flat 3A, House 12" 
                                           class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold"
                                           oninput="updateCombinedAddress()">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1">Road / Street / Block</label>
                                    <input type="text" id="input-road" placeholder="e.g. Road 11, Block C" 
                                           class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold"
                                           oninput="updateCombinedAddress()">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1">Area / Thana / Sector <span class="text-rose-500">*</span></label>
                                    <input type="text" id="input-area" placeholder="e.g. Banani, Gulshan 2, Mirpur 10, Uttara" required
                                           class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold"
                                           oninput="updateCombinedAddress()">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1">District / City <span class="text-rose-500">*</span></label>
                                    <input type="text" id="input-city" placeholder="e.g. Dhaka, Chattogram, Sylhet" required
                                           class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold"
                                           oninput="updateCombinedAddress()">
                                </div>
                            </div>

                            <!-- Landmark -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1">Nearby Landmark / Delivery Instruction (Optional)</label>
                                <input type="text" id="input-landmark" placeholder="e.g. Beside City Bank ATM, Opposite to Central Mosque" 
                                       class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold"
                                       oninput="updateCombinedAddress()">
                            </div>

                            <!-- Full Combined Address Textarea -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-slate-800">Complete Delivery Address <span class="text-rose-500">*</span></label>
                                    <span class="text-[10px] text-slate-400">Auto-assembled or edit directly</span>
                                </div>
                                <textarea id="full-address-textarea" name="address" rows="3" required
                                          placeholder="Enter or verify full delivery address for courier..."
                                          class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold resize-none leading-relaxed">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <!-- Contact Phone Number -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1">Contact Phone Number <span class="text-rose-500">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +880 17XXXXXXXX" required
                                       class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold"
                                       oninput="document.getElementById('hidden-phone').value = this.value">
                            </div>

                            <!-- Save Address Action -->
                            <div class="flex items-center justify-end pt-3 border-t border-slate-100">
                                <button type="submit" 
                                        class="btn-classic-primary px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-sm inline-flex items-center space-x-2 cursor-pointer">
                                    <span>Save Address</span>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 3: PASSWORD & SECURITY                 -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'security'" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">Change Password</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Keep your account secure with a strong password.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.password') }}" class="p-6 space-y-5 max-w-lg">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">Current Password <span class="text-rose-500">*</span></label>
                            <input type="password" name="current_password" required
                                   class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">New Password <span class="text-rose-500">*</span></label>
                            <input type="password" name="password" required
                                   class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold">
                            <span class="text-[11px] text-slate-400 mt-1 block">At least 8 characters with letters and numbers.</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">Confirm New Password <span class="text-rose-500">*</span></label>
                            <input type="password" name="password_confirmation" required
                                   class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold">
                        </div>

                        <div class="pt-3">
                            <button type="submit" 
                                    class="btn-classic-primary px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-sm cursor-pointer">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ========================================== -->
                <!-- TAB 4: MY ORDERS                           -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'orders'" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900">My Orders</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Track shipment progress and past orders.</p>
                        </div>
                        <a href="{{ route('orders.index') }}" class="text-xs font-bold text-blue-700 hover:underline">
                            View All Purchases &rarr;
                        </a>
                    </div>

                    <div class="p-6">
                        @if($orders->isEmpty())
                            <div class="p-10 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <p class="text-sm font-bold text-slate-800">No orders placed yet.</p>
                                <p class="text-xs text-slate-400 mt-1">Explore our latest group buy deals and save big.</p>
                                <a href="{{ route('home') }}" class="mt-4 inline-block btn-classic-primary px-5 py-2 rounded-xl text-xs font-bold">
                                    Start Shopping
                                </a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($orders as $order)
                                    <div class="border border-slate-200 rounded-xl p-4 hover:border-blue-400 transition-colors bg-white shadow-2xs">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                                            <div class="flex items-center space-x-3">
                                                <span class="font-mono font-bold text-slate-900 text-xs">#{{ $order->order_number }}</span>
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $order->order_type === 'group_buy' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-slate-100 text-slate-700' }}">
                                                    {{ $order->order_type === 'group_buy' ? 'Group Circle Buy' : 'Direct Order' }}
                                                </span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-[11px] text-slate-400 font-medium">{{ $order->created_at->format('d M, Y h:i A') }}</span>
                                            </div>
                                        </div>

                                        <div class="pt-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                            <div class="text-xs">
                                                <span class="text-slate-500 font-medium">Order Amount:</span>
                                                <span class="font-bold text-slate-900 text-sm ml-1">৳{{ number_format($order->total_amount, 2) }}</span>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('orders.show', $order) }}" class="px-3.5 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 hover:bg-slate-50 transition-colors">
                                                    Order Details &rarr;
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 5: ACTIVE TEAM POOLS                   -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'pools'" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900">Active Team Pools</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Ongoing group deals you have joined or initiated.</p>
                        </div>
                        <a href="{{ route('home') }}#active-deals" class="text-xs font-bold text-blue-700 hover:underline">
                            Browse All Pools &rarr;
                        </a>
                    </div>

                    <div class="p-6">
                        @if($activeGroups->isEmpty())
                            <div class="p-10 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-sm font-bold text-slate-800">No active group sessions found.</p>
                                <p class="text-xs text-slate-400 mt-1">Join a circle with friends or neighbors to get wholesale price.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($activeGroups as $membership)
                                    @if($membership->session)
                                        <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-blue-400 transition-colors shadow-2xs">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                                    @if($membership->session->product && $membership->session->product->image)
                                                        <img src="{{ $membership->session->product->image }}" alt="" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">No Img</div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-bold text-slate-900 truncate">{{ $membership->session->product->title ?? 'Group Deal' }}</p>
                                                    <span class="text-[10px] font-mono font-bold text-blue-700">{{ $membership->session->group_code }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between text-[11px] pt-2 border-t border-slate-100">
                                                <span class="font-medium text-slate-500">
                                                    {{ $membership->session->members->count() }}/{{ $membership->session->required_members }} joined
                                                </span>
                                                <a href="{{ route('group-buy.show', $membership->session->group_code) }}" class="text-xs font-bold text-blue-700 hover:underline">
                                                    View Circle &rarr;
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 6: MERCHANT HUB (For Sellers & Admins) -->
                <!-- ========================================== -->
                @if($user->isSeller() || $user->isAdmin())
                    <div x-show="activeTab === 'merchant'" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <h2 class="text-base sm:text-lg font-bold text-slate-900">Merchant Storefront Details</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Manage your merchant shop identity and trade category.</p>
                            </div>
                            <a href="{{ route('seller.dashboard') }}" class="btn-classic-primary px-3.5 py-1.5 rounded-xl font-bold text-xs">
                                Open Seller Hub &rarr;
                            </a>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="merchant">
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="phone" value="{{ $user->phone }}">
                            <input type="hidden" name="address" value="{{ $user->address }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">Shop / Store Name</label>
                                    <input type="text" name="shop_name" value="{{ old('shop_name', $user->shop_name) }}" placeholder="e.g. Apex Tech & Lifestyle"
                                           class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">Business Category</label>
                                    <select name="business_category" class="classic-input w-full px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold">
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
                                <button type="submit" class="btn-classic-primary px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-sm cursor-pointer">
                                    Update Store Details
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
let currentAddressTag = '{{ $user->address_tag ?? "Home" }}';

// Address Tag Selector
function setAddressTag(tag) {
    currentAddressTag = tag;
    const tagInput = document.getElementById('hidden-address-tag');
    if (tagInput) tagInput.value = tag;

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

// Synchronize Structured Inputs into Combined Address Textarea
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
        const fullAddrEl = document.getElementById('full-address-textarea');
        if (fullAddrEl) fullAddrEl.value = full;
    }
}

// Parse existing address into structured inputs on page load
function parseExistingAddress() {
    const full = document.getElementById('full-address-textarea') ? document.getElementById('full-address-textarea').value.trim() : '';
    if (!full) return;

    const tagMatch = full.match(/\[(.*?)\]/);
    if (tagMatch && tagMatch[1]) {
        setAddressTag(tagMatch[1]);
    }

    const landmarkMatch = full.match(/\((.*?)\)/);
    if (landmarkMatch && landmarkMatch[1] && document.getElementById('input-landmark')) {
        document.getElementById('input-landmark').value = landmarkMatch[1];
    }

    const clean = full.replace(/\[.*?\]|\(.*?\)/g, '').trim();
    const parts = clean.split(',').map(s => s.trim()).filter(Boolean);

    if (parts.length >= 1 && document.getElementById('input-house') && !document.getElementById('input-house').value) {
        document.getElementById('input-house').value = parts[0];
    }
    if (parts.length >= 2 && document.getElementById('input-road') && !document.getElementById('input-road').value) {
        document.getElementById('input-road').value = parts[1];
    }
    if (parts.length >= 3 && document.getElementById('input-area') && !document.getElementById('input-area').value) {
        document.getElementById('input-area').value = parts[2];
    }
    if (parts.length >= 4 && document.getElementById('input-city') && !document.getElementById('input-city').value) {
        document.getElementById('input-city').value = parts.slice(3).join(', ');
    }
}

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
    setAddressTag('{{ $user->address_tag ?? "Home" }}');
    parseExistingAddress();
});
</script>
@endpush
@endsection
