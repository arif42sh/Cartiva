@extends('layouts.seller')

@section('title', 'Merchant Store Profile & Settings - Cartiva')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{ 
         avatarPreview: '{{ $user->avatar_url }}', 
         bannerPreview: '{{ $user->banner_url }}',
         bannerFileName: '',
         avatarFileName: '',
         removeAvatar: false,
         removeBanner: false,
         shopName: '{{ addslashes($user->shop_name ?? $user->name) }}',
         category: '{{ addslashes($user->business_category ?? 'General Merchandise') }}',
         description: '{{ addslashes($user->shop_description ?? '') }}',
         phone: '{{ addslashes($user->phone ?? '') }}',
         whatsapp: '{{ addslashes($user->whatsapp_number ?? '') }}',
         facebook: '{{ addslashes($user->facebook_page ?? '') }}',
         dispatchTime: '{{ addslashes($user->dispatch_time ?? '⚡ Dispatches within 24 hours') }}',
         address: '{{ addslashes($user->address ?? '') }}',
         warehouseAddress: '{{ addslashes($user->warehouse_address ?? '') }}',
         returnPolicy: '{{ addslashes($user->return_policy ?? '') }}',
         payoutMethod: '{{ addslashes($user->payout_method ?? 'bkash') }}',
         payoutDetails: '{{ addslashes($user->payout_details ?? '') }}',
         activeTab: 'all'
     }">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <!-- Notification Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs animate-in fade-in duration-300">
            <div class="flex items-center space-x-2.5">
                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-xs flex-shrink-0 shadow-xs">✓</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 font-black text-base leading-none p-1">&times;</button>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Profile</h1>
            </div>
          
        </div>
        <div class="flex items-center space-x-2.5 self-start sm:self-auto">
            <a href="{{ route('shop.show', $user->shop_slug) }}" target="_blank"
               class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors flex items-center space-x-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>View Shop</span>
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if (isset($errors) && $errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold shadow-xs">
            <div class="font-bold mb-1.5 flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Please fix the following validation errors:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 ml-1 text-slate-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 2-Column Full Width Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left: Live Storefront Card Preview (1 col, sticky) -->
        <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 sm:p-6 overflow-hidden">

                <!-- Mini Storefront Banner Preview -->
                <div class="w-full h-32 rounded-2xl overflow-hidden bg-slate-900 relative border border-slate-200 group">
                    <template x-if="bannerPreview && !removeBanner">
                        <img :src="bannerPreview" alt="Banner" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!bannerPreview || removeBanner">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-xs font-bold p-4 text-center"
                             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                            <svg class="w-6 h-6 mb-1 text-slate-500 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-[11px]">Store Banner</span>
                        </div>
                    </template>
                </div>

                <!-- Avatar & Titles -->
                <div class="flex items-center space-x-3.5 -mt-7 px-2 relative z-10">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-white p-1 shadow-md border border-slate-200 flex-shrink-0 flex items-center justify-center">
                        <template x-if="avatarPreview && !removeAvatar">
                            <img :src="avatarPreview" alt="Avatar" class="w-full h-full object-cover rounded-xl">
                        </template>
                        <template x-if="!avatarPreview || removeAvatar">
                            <div class="w-full h-full rounded-xl text-white flex items-center justify-center font-black text-xl shadow-xs"
                                 style="background: linear-gradient(135deg, #53a318 0%, #10b981 100%);">
                                <span x-text="(shopName || 'C').charAt(0).toUpperCase()"></span>
                            </div>
                        </template>
                    </div>
                    <div class="pt-6 flex-1 min-w-0">
                        <h3 class="text-sm font-black text-slate-900 truncate" x-text="shopName || 'Store Name'"></h3>
                    </div>
                </div>


                <!-- Description Snippet Preview -->
                <div class="mt-3.5 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 text-xs">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">About Store</span>
                    <p class="line-clamp-3 leading-relaxed text-[11px]" x-text="description || 'Merchant has not provided a description yet.'"></p>
                </div>
                
            </div>


        </div>

        <!-- Right: Settings & Branding Form (2 cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                
                <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    @method('PUT')

                    <!-- Hidden Inputs for Remove Flags -->
                    <input type="hidden" name="remove_avatar" :value="removeAvatar ? '1' : '0'">
                    <input type="hidden" name="remove_banner" :value="removeBanner ? '1' : '0'">

                    <!-- 1. Brand Identity & Visuals -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2.5 border-b border-slate-100 pb-3">
                            <span class="w-7 h-7 rounded-full text-white font-black text-xs flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">1</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                    Brand Details
                                </h3>

                            </div>
                        </div>

                        <!-- Shop Banner Upload & Management -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-slate-800">
                                    Shop Cover Banner <span class="text-slate-400 font-normal">(1200×320 recommended, max 4MB)</span>
                                </label>
                                <template x-if="bannerPreview && !removeBanner">
                                    <button type="button" @click="removeBanner = true" 
                                            class="text-[11px] font-bold text-rose-600 hover:text-rose-800 hover:underline flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <span>Remove Banner</span>
                                    </button>
                                </template>
                                <template x-if="removeBanner">
                                    <span class="text-[11px] font-bold text-amber-600 flex items-center space-x-1">
                                        <span>Marked for removal</span>
                                        <button type="button" @click="removeBanner = false" class="underline text-slate-600 hover:text-slate-900 ml-1">Undo</button>
                                    </span>
                                </template>
                            </div>
                            
                            <!-- Banner Preview Box -->
                            <div class="w-full h-32 sm:h-36 rounded-xl overflow-hidden bg-slate-200 border border-slate-300 relative">
                                <template x-if="bannerPreview && !removeBanner">
                                    <img :src="bannerPreview" alt="Shop Banner" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!bannerPreview || removeBanner">
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-xs font-semibold p-4 text-center bg-slate-900">
                                        <svg class="w-8 h-8 mb-1 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>No banner uploaded yet.</span>
                                    </div>
                                </template>
                            </div>

                            <div class="flex items-center space-x-3">
                                <input type="file" id="banner_file_input" name="banner_file" accept="image/jpeg,image/png,image/webp,image/jpg" class="hidden"
                                       @change="const file = $event.target.files[0]; if (file) { removeBanner = false; bannerFileName = file.name; const reader = new FileReader(); reader.onload = (e) => bannerPreview = e.target.result; reader.readAsDataURL(file); }">
                                <label for="banner_file_input" 
                                       class="px-4 py-2 rounded-xl text-white font-bold text-xs cursor-pointer shadow-xs transition-all hover:brightness-110 active:scale-95 flex items-center space-x-1.5"
                                       style="background-color: #53a318;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    <span>Choose File</span>
                                </label>
                                <span class="text-xs text-slate-700 font-semibold truncate max-w-sm" x-show="bannerFileName" x-text="bannerFileName"></span>
                            </div>
                            <span class="text-[10px] text-slate-400 block">Accepted formats: JPG, PNG, WebP (under 4MB). Fits across laptop & mobile storefront views.</span>
                        </div>

                        <!-- Logo / Avatar & Store Identity Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-start">
                            <!-- Shop Logo Upload -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs font-bold text-slate-700">Logo / Avatar</label>
                                    <template x-if="avatarPreview && !removeAvatar">
                                        <button type="button" @click="removeAvatar = true; avatarFileName = ''" 
                                                class="text-[10px] font-bold text-rose-600 hover:text-rose-800 hover:underline">
                                            Remove
                                        </button>
                                    </template>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0 flex items-center justify-center shadow-xs">
                                        <template x-if="avatarPreview && !removeAvatar">
                                            <img :src="avatarPreview" alt="Logo" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!avatarPreview || removeAvatar">
                                            <div class="w-full h-full text-white flex items-center justify-center font-black text-xl"
                                                 style="background: linear-gradient(135deg, #53a318 0%, #10b981 100%);">
                                                <span x-text="(shopName || 'C').charAt(0).toUpperCase()"></span>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <input type="file" id="avatar_file_input" name="avatar_file" accept="image/jpeg,image/png,image/webp,image/jpg" class="hidden"
                                               @change="const file = $event.target.files[0]; if (file) { removeAvatar = false; avatarFileName = file.name; const reader = new FileReader(); reader.onload = (e) => avatarPreview = e.target.result; reader.readAsDataURL(file); }">
                                        <label for="avatar_file_input" 
                                               class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs cursor-pointer transition-colors shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            <span>Choose File</span>
                                        </label>
                                        <span class="text-[11px] text-slate-700 font-semibold truncate block mt-1" x-show="avatarFileName" x-text="avatarFileName"></span>
                                        <span class="text-[9px] text-slate-400 mt-1 block">Square 400×400 (max 2MB)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Shop Name -->
                            <div class="sm:col-span-2 space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Official Shop / Brand Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="shop_name" x-model="shopName" value="{{ old('shop_name', $user->shop_name ?? $user->name) }}" required
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                              
                            </div>
                        </div>

                        <!-- Category & Contact Person -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Primary Business Category</label>
                                <select name="business_category" x-model="category" class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}" {{ old('business_category', $user->business_category) == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                    <option value="Electronics & Gadgets" {{ old('business_category', $user->business_category) == 'Electronics & Gadgets' ? 'selected' : '' }}>Electronics & Gadgets</option>
                                    <option value="Fashion & Apparel" {{ old('business_category', $user->business_category) == 'Fashion & Apparel' ? 'selected' : '' }}>Fashion & Apparel</option>
                                    <option value="Home & Living" {{ old('business_category', $user->business_category) == 'Home & Living' ? 'selected' : '' }}>Home & Living</option>
                                    <option value="Health & Beauty" {{ old('business_category', $user->business_category) == 'Health & Beauty' ? 'selected' : '' }}>Health & Beauty</option>
                                    <option value="General Merchandise" {{ old('business_category', $user->business_category) == 'General Merchandise' ? 'selected' : '' }}>General Merchandise</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Authorized Contact Person <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                            </div>
                        </div>

                        <!-- Storefront Bio / Description -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-700">Storefront Bio</label>
                                <span class="text-[10px] text-slate-400" x-text="(description ? description.length : 0) + ' / 1500 chars'"></span>
                            </div>
                            <textarea name="shop_description" x-model="description" rows="3" placeholder="Tell buyers about your authenticity guarantee, dispatch times, brand legacy, or warranty coverage..."
                                      class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('shop_description', $user->shop_description) }}</textarea>
                            
                        </div>
                    </div>

                    <!-- 2. Customer Support & Social Channels -->
                    <div class="space-y-6 pt-6 border-t border-slate-100">
                        <div class="flex items-center space-x-2.5 border-b border-slate-100 pb-3">
                            <span class="w-7 h-7 rounded-full bg-slate-800 text-white font-black text-xs flex items-center justify-center shadow-xs">2</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                    Customer Support & Social Direct Channels
                                </h3>

                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Store Helpline / Phone</label>
                                <div class="relative">
                                    <input type="text" name="phone" x-model="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 1800 000000"
                                           class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp Support Number</label>
                                <div class="relative">
                                    <input type="text" name="whatsapp_number" x-model="whatsapp" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" placeholder="+8801700000000"
                                           class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    <span class="absolute left-3 top-2.5 text-emerald-600 font-bold text-xs">WA</span>
                                </div>

                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Official Facebook Page</label>
                            <div class="relative">
                                <input type="url" name="facebook_page" x-model="facebook" value="{{ old('facebook_page', $user->facebook_page) }}" placeholder="https://facebook.com/your-brand-page"
                                       class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <svg class="w-4 h-4 text-blue-600 absolute left-3 top-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.597 0 9 1.582 9 4.615V8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Logistics & Warehousing -->
                    <div class="space-y-6 pt-6 border-t border-slate-100">
                        <div class="flex items-center space-x-2.5 border-b border-slate-100 pb-3">
                            <span class="w-7 h-7 rounded-full bg-slate-800 text-white font-black text-xs flex items-center justify-center shadow-xs">3</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                    Courier Pickup Address
                                </h3>

                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Showroom Address</label>
                                <textarea name="address" x-model="address" rows="2" placeholder="Level 3, Suite 402, Banani Commercial Area, Dhaka..."
                                          class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('address', $user->address) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Warehouse Address</label>
                                <textarea name="warehouse_address" x-model="warehouseAddress" rows="2" placeholder="Warehouse #14, Road 7, Tejgaon Industrial Area, Dhaka 1208..."
                                          class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('warehouse_address', $user->warehouse_address) }}</textarea>
                    
                            </div>
                        </div>
                    </div>

                    <!-- 4. Policies & Guarantees -->
                    <div class="space-y-6 pt-6 border-t border-slate-100">
                        <div class="flex items-center space-x-2.5 border-b border-slate-100 pb-3">
                            <span class="w-7 h-7 rounded-full bg-slate-800 text-white font-black text-xs flex items-center justify-center shadow-xs">4</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                    Policies
                                </h3>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Order Dispatch</label>
                            <input type="text" name="dispatch_time" x-model="dispatchTime" value="{{ old('dispatch_time', $user->dispatch_time ?? '') }}" placeholder="e.g. ⚡ Same-day dispatch for orders before 2 PM"
                                   class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                            
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Return & Warranty Policy</label>
                            <textarea name="return_policy" x-model="returnPolicy" rows="3" placeholder="Explain your return window (e.g. 7-day hassle-free replacement for defective items, unopened box policy, manufacturer warranty terms)..."
                                      class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('return_policy', $user->return_policy) }}</textarea>
                        </div>
                    </div>

                    <!-- 5. Merchant Payout Settings -->
                    <div class="space-y-6 pt-6 border-t border-slate-100">
                        <div class="flex items-center space-x-2.5 border-b border-slate-100 pb-3">
                            <span class="w-7 h-7 rounded-full bg-slate-800 text-white font-black text-xs flex items-center justify-center shadow-xs">5</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                    Merchant Payout
                                </h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="p-3.5 rounded-2xl border cursor-pointer transition-all flex items-center space-x-3"
                                   :class="payoutMethod === 'bkash' ? 'bg-pink-50 border-pink-400 ring-2 ring-pink-400/20' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'">
                                <input type="radio" name="payout_method" value="bkash" x-model="payoutMethod" class="text-pink-600 focus:ring-pink-500">
                                <span class="text-xs font-black text-slate-800">bKash (Merchant / Personal)</span>
                            </label>

                            <label class="p-3.5 rounded-2xl border cursor-pointer transition-all flex items-center space-x-3"
                                   :class="payoutMethod === 'nagad' ? 'bg-orange-50 border-orange-400 ring-2 ring-orange-400/20' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'">
                                <input type="radio" name="payout_method" value="nagad" x-model="payoutMethod" class="text-orange-600 focus:ring-orange-500">
                                <span class="text-xs font-black text-slate-800">Nagad</span>
                            </label>

                            <label class="p-3.5 rounded-2xl border cursor-pointer transition-all flex items-center space-x-3"
                                   :class="payoutMethod === 'bank' ? 'bg-blue-50 border-blue-400 ring-2 ring-blue-400/20' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'">
                                <input type="radio" name="payout_method" value="bank" x-model="payoutMethod" class="text-blue-600 focus:ring-blue-500">
                                <span class="text-xs font-black text-slate-800">Bank Wire / BEFTN</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Payout Account Details
                            </label>
                            <input type="text" name="payout_details" x-model="payoutDetails" value="{{ old('payout_details', $user->payout_details) }}" 
                                   placeholder="For Mobile Wallet: 01700000000 (Personal/Agent). For Bank: Bank Name, Branch, Account Title & A/C Number."
                                   class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end">
                        <button type="submit" 
                                class="px-7 py-2.5 rounded-xl text-white font-bold text-xs transition-all cursor-pointer shadow-md hover:brightness-110 active:scale-95"
                                style="background-color: #53a318;">
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>
@endsection
