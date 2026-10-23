@extends('layouts.seller')

@section('title', 'Merchant Store Profile & Settings - Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{ 
         avatarPreview: '{{ $user->avatar }}', 
         bannerPreview: '{{ $user->shop_banner }}',
         shopName: '{{ addslashes($user->shop_name ?? $user->name) }}',
         category: '{{ addslashes($user->business_category ?? 'General Merchandise') }}'
     }">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Notification Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-2.5">
                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-xs flex-shrink-0">✓</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 font-black text-base">&times;</button>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Merchant Profile & Storefront Branding</h1>
            <p class="text-xs text-slate-500 mt-0.5">Customize your official shop identity, upload branded store visuals, and update dispatch addresses.</p>
        </div>
        <a href="{{ route('seller.storefront') }}" 
           class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors flex items-center space-x-1.5 shadow-sm self-start sm:self-auto">
            <svg class="w-4 h-4 text-[#84cc16]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            <span>Preview Storefront</span>
        </a>
    </div>

    <!-- Error Messages -->
    @if (isset($errors) && $errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
            <div class="font-bold mb-1">Please fix the following issues:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 2-Column Full Width Grid (Identical max-w-7xl width) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Live Storefront Card Preview (1 col) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 overflow-hidden">
                <span class="text-[10px] font-black uppercase tracking-wider text-[#53a318] block mb-3">Live Card Preview</span>
                
                <!-- Mini Storefront Banner Preview -->
                <div class="w-full h-28 rounded-2xl overflow-hidden bg-slate-900 relative border border-slate-200">
                    <template x-if="bannerPreview">
                        <img :src="bannerPreview" alt="Banner" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!bannerPreview">
                        <div class="w-full h-full flex items-center justify-center text-slate-500 text-xs font-bold"
                             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                            <span>Default Cartiva Banner</span>
                        </div>
                    </template>
                </div>

                <!-- Avatar & Titles -->
                <div class="flex items-center space-x-3.5 -mt-6 px-2 relative z-10">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-white p-1 shadow-md border border-slate-200 flex items-center justify-center">
                        <template x-if="avatarPreview">
                            <img :src="avatarPreview" alt="Avatar" class="w-full h-full object-cover rounded-xl">
                        </template>
                        <template x-if="!avatarPreview">
                            <div class="w-full h-full rounded-xl text-white flex items-center justify-center font-black text-xl"
                                 style="background: linear-gradient(135deg, #53a318 0%, #10b981 100%);">
                                {{ strtoupper(substr($user->shop_name ?? $user->name, 0, 1)) }}
                            </div>
                        </template>
                    </div>
                    <div class="pt-5 flex-1 min-w-0">
                        <h3 class="text-sm font-black text-slate-900 truncate" x-text="shopName || 'Store Name'"></h3>
                        <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.2 rounded-full border border-emerald-200">
                            ✓ Verified Brand
                        </span>
                    </div>
                </div>

                <!-- Quick Metrics Pill -->
                <div class="mt-5 pt-4 border-t border-slate-100 grid grid-cols-2 gap-2 text-center text-xs">
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] text-slate-400 font-bold block">Live Products</span>
                        <strong class="text-slate-900 font-black text-sm">{{ $user->products()->count() }}</strong>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] text-slate-400 font-bold block">Seller ID</span>
                        <strong class="text-slate-700 font-mono font-bold text-xs">#{{ $user->id }}</strong>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('seller.storefront') }}" 
                       class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition-colors flex items-center justify-center space-x-1.5">
                        <span>Check Storefront Preview</span>
                    </a>
                </div>
            </div>

            <!-- Seller Support Card -->
            <div class="p-5 rounded-3xl border border-slate-200 bg-white shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Merchant Verification</span>
                <p class="text-xs text-slate-600 leading-relaxed">Your store is officially verified on the Cartiva marketplace. Orders are processed with automated escrow protection.</p>
            </div>
        </div>

        <!-- Right: Settings & Branding Form (2 cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                
                <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- 1. Storefront Branding -->
                    <div class="space-y-5">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                            <span class="w-6 h-6 rounded-full text-white font-black text-xs flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">1</span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                Brand Identity & Visuals
                            </h3>
                        </div>

                        <!-- Shop Banner Preview & Upload -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">Shop Header Banner (1200x300 recommended)</label>
                            
                            <template x-if="bannerPreview">
                                <div class="mb-3 w-full h-32 rounded-xl overflow-hidden bg-slate-200 border border-slate-300">
                                    <img :src="bannerPreview" alt="Shop Banner" class="w-full h-full object-cover">
                                </div>
                            </template>

                            <input type="file" name="banner_file" accept="image/*" 
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => bannerPreview = e.target.result; reader.readAsDataURL(file); }"
                                   class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:text-white file:cursor-pointer"
                                   style="--tw-file-bg: #53a318;">
                            <span class="text-[10px] text-slate-400 mt-1 block">Displayed across the top of your public storefront</span>
                        </div>

                        <!-- Logo & Shop Name -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 items-center">
                            <!-- Shop Logo Upload -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Store Logo / Avatar</label>
                                <div class="flex items-center space-x-3">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0 flex items-center justify-center font-bold text-slate-500">
                                        <template x-if="avatarPreview">
                                            <img :src="avatarPreview" alt="Logo" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!avatarPreview">
                                            <span>🏪</span>
                                        </template>
                                    </div>
                                    <input type="file" name="avatar_file" accept="image/*" 
                                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => avatarPreview = e.target.result; reader.readAsDataURL(file); }"
                                           class="text-xs text-slate-500 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300 file:cursor-pointer">
                                </div>
                            </div>

                            <!-- Shop Name -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Official Shop / Brand Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="shop_name" x-model="shopName" value="{{ old('shop_name', $user->shop_name ?? $user->name) }}" required
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Primary Business Category</label>
                                <select name="business_category" x-model="category" class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}" {{ old('business_category', $user->business_category) == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                    <option value="General Merchandise" {{ old('business_category', $user->business_category) == 'General Merchandise' ? 'selected' : '' }}>General Merchandise</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Contact Person Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Storefront Description & Warranty Policy</label>
                            <textarea name="shop_description" rows="3" placeholder="Tell buyers about your authenticity guarantee, dispatch times, customer return policy, and years of operation..."
                                      class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('shop_description', $user->shop_description) }}</textarea>
                        </div>
                    </div>

                    <!-- 2. Logistics & Warehouse Contact -->
                    <div class="space-y-5">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                            <span class="w-6 h-6 rounded-full bg-slate-800 text-white font-black text-xs flex items-center justify-center shadow-xs">2</span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                Dispatch Logistics & Official Address
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Official Business Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 1800 000000"
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Registered Account Email</label>
                                <input type="email" value="{{ $user->email }}" disabled
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-xs font-mono text-slate-500 cursor-not-allowed">
                                <span class="text-[10px] text-slate-400 mt-0.5 block">Managed via account security</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Warehouse / Pickup Address</label>
                            <textarea name="address" rows="2" placeholder="Street, Building, Police Station, District / Postal Code..."
                                      class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('address', $user->address) }}</textarea>
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Used for courier pickup and return shipments</span>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl text-white font-extrabold text-xs transition-all cursor-pointer shadow-lg hover:brightness-110 active:scale-95"
                                style="background-color: #53a318; box-shadow: 0 4px 14px rgba(83, 163, 24, 0.35);">
                            Save Profile & Update Storefront &rarr;
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>
@endsection
