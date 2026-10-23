@extends('layouts.app')

@section('title', 'Merchant Store Profile & Settings - Cartiva')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{ 
         avatarPreview: '{{ $user->avatar }}', 
         bannerPreview: '{{ $user->shop_banner }}' 
     }">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Notification Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-2xs">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Merchant Profile & Storefront Branding</h1>
        <p class="text-xs text-slate-500 mt-0.5">Customize your official shop identity, upload branded store logos, and update dispatch addresses.</p>
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

    <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-10 shadow-xs">
        
        <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. Storefront Branding -->
            <div class="space-y-5">
                <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-teal-800 font-black text-xs flex items-center justify-center">1</span>
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">
                        Brand Identity & Visuals
                    </h3>
                </div>

                <!-- Shop Banner Preview & Upload -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-xs font-bold text-slate-800 mb-1.5">Shop Header Banner (1200x300 recommended)</label>
                    
                    <template x-if="bannerPreview">
                        <div class="mb-3 w-full h-32 rounded-xl overflow-hidden bg-slate-200 border border-slate-300">
                            <img :src="bannerPreview" alt="Shop Banner" class="w-full h-full object-cover">
                        </div>
                    </template>

                    <input type="file" name="banner_file" accept="image/*" 
                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => bannerPreview = e.target.result; reader.readAsDataURL(file); }"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-600 file:text-white hover:file:bg-teal-700 file:cursor-pointer">
                    <span class="text-[10px] text-slate-400 mt-1 block">Displayed at the top of your public storefront</span>
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
                        <input type="text" name="shop_name" value="{{ old('shop_name', $user->shop_name ?? $user->name) }}" required
                               class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Primary Business Category</label>
                        <select name="business_category" class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" {{ old('business_category', $user->business_category) == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                            <option value="General Merchandise" {{ old('business_category', $user->business_category) == 'General Merchandise' ? 'selected' : '' }}>General Merchandise</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Contact Person Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Storefront Description & Warranty Policy</label>
                    <textarea name="shop_description" rows="3" placeholder="Tell buyers about your authenticity guarantee, dispatch times, customer return policy, and years of operation..."
                              class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">{{ old('shop_description', $user->shop_description) }}</textarea>
                </div>
            </div>

            <!-- 2. Logistics & Warehouse Contact -->
            <div class="space-y-5">
                <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-800 font-black text-xs flex items-center justify-center">2</span>
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">
                        Dispatch Logistics & Official Address
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Official Business Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 1800 000000"
                               class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
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
                              class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">{{ old('address', $user->address) }}</textarea>
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Used for courier pickup and return shipments</span>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-md shadow-teal-600/25 transition-all cursor-pointer">
                    Save Profile & Update Storefront &rarr;
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
