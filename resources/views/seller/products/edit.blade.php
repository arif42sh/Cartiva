@extends('layouts.seller')

@section('title', 'Edit Product - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4" 
     x-data="{
         title: '{{ addslashes(old('title', $product->title)) }}',
         singlePrice: '{{ old('single_price', $product->single_price) }}',
         groupPrice: '{{ old('group_price', $product->group_price) }}',
         tier2Price: '{{ old('tier2_group_price', $product->tier2_group_price) }}',
         tier3Price: '{{ old('tier3_group_price', $product->tier3_group_price) }}',
         groupSize: '{{ old('group_size_required', $product->group_size_required) }}',
         minQuota: '{{ old('min_quota_to_ship', $product->min_quota_to_ship ?? '') }}',
         duration: '{{ old('group_duration_hours', $product->group_duration_hours) }}',
         isFlashSale: {{ old('is_flash_sale', $product->is_flash_sale) ? 'true' : 'false' }},
         isHotDeal: {{ old('is_hot_deal', $product->is_hot_deal) ? 'true' : 'false' }},
         imagePreview: '{{ $product->image_url }}',
         customTiers: {{ json_encode(old('discount_tiers', $product->discount_tiers ?? [
             ['min_members' => 3, 'discount_percent' => 5],
             ['min_members' => 5, 'discount_percent' => 10],
             ['min_members' => 7, 'discount_percent' => 15],
         ])) }},
         addTier() {
             this.customTiers.push({ min_members: '', discount_percent: '' });
         },
         removeTier(index) {
             this.customTiers.splice(index, 1);
         },
         getTierPrice(discountPct) {
             const s = parseFloat(this.singlePrice);
             const d = parseFloat(discountPct);
             if (s > 0 && d > 0 && d < 100) {
                 return (s * (1 - (d / 100))).toFixed(2);
             }
             return '0.00';
         },
         getTierSavings(discountPct) {
             const s = parseFloat(this.singlePrice);
             const d = parseFloat(discountPct);
             if (s > 0 && d > 0 && d < 100) {
                 return (s * (d / 100)).toFixed(2);
             }
             return '0.00';
         },
         get discountPercent() {
             const s = parseFloat(this.singlePrice);
             const g = parseFloat(this.groupPrice);
             if (s > 0 && g > 0 && s > g) {
                 return Math.round(((s - g) / s) * 100);
             }
             return 0;
         },
         get savings() {
             const s = parseFloat(this.singlePrice);
             const g = parseFloat(this.groupPrice);
             if (s > 0 && g > 0 && s > g) {
                 return (s - g).toFixed(2);
             }
             return 0;
         }
     }">

    <!-- Shared Navigation -->
    @include('seller.partials.nav')

    <div class="mb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
        <div>
            <h1 class="text-lg font-black text-slate-900 tracking-tight">Edit Product & Group Deal Parameters</h1>
            <p class="text-[11px] text-slate-500 mt-0.5">Modify pricing tiers, update available inventory units, or refresh product visuals.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.show', $product) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors flex items-center space-x-1.5 shadow-xs">
                <span>View Storefront Page ↗</span>
            </a>
            <a href="{{ route('seller.products') }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                &larr; Back to Products
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if (isset($errors) && $errors->any())
        <div class="mb-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
            <div class="font-bold mb-1">Please fix the following issues:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 2-Column Full-Width Grid (Consistent max-w-7xl) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        
        <!-- Left: Edit Form (2 cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                
                <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- 1. Product Basics -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                            <span class="w-5 h-5 rounded-full text-white font-black text-[11px] flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">1</span>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">
                                Product Information
                            </h3>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Product Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" x-model="title" value="{{ old('title', $product->title) }}" required
                                   class="w-full px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Marketplace Category <span class="text-rose-500">*</span></label>
                                <select name="category_id" required class="w-full px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Available Stock Units <span class="text-rose-500">*</span></label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                                       class="w-full px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <span class="text-[9px] text-slate-500 mt-0.5 block">
                                    Current: <strong>{{ $product->stock }}</strong> | Sold: <strong>{{ $product->sales_count }}</strong> | Total: <strong>{{ $product->stock + $product->sales_count }}</strong>
                                </span>
                            </div>
                        </div>

                        <!-- Product Image Upload + URL Option -->
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">Update Product Image</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 items-start">
                                <div>
                                    <span class="text-[10px] font-semibold text-slate-500 block mb-1">Upload New File</span>
                                    <input type="file" name="image_file" accept="image/*" 
                                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                           class="w-full text-xs text-slate-500 file:mr-2.5 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:text-white file:cursor-pointer"
                                           style="--tw-file-bg: #53a318;">
                                    <span class="text-[9px] text-slate-400 mt-0.5 block">JPG, PNG, WEBP up to 4MB</span>
                                </div>

                                <div>
                                    <span class="text-[10px] font-semibold text-slate-500 block mb-1">Or Replace Web Image URL</span>
                                    <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                                           @input="if ($event.target.value) imagePreview = $event.target.value"
                                           class="w-full px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                </div>
                            </div>

                            <!-- Image Preview -->
                            <template x-if="imagePreview">
                                <div class="mt-2.5 flex items-center space-x-2.5 p-2 bg-white rounded-lg border border-slate-200">
                                    <img :src="imagePreview" alt="Preview" class="w-12 h-12 rounded-lg object-cover bg-slate-100 flex-shrink-0">
                                    <div>
                                        <span class="text-xs font-bold text-emerald-700 block">Current Thumbnail Display</span>
                                        <span class="text-[10px] text-slate-400">Featured across live circles and storefront view.</span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Product Description <span class="text-rose-500">*</span></label>
                            <textarea name="description" rows="2" required class="w-full px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <!-- 2. Group Buy Pricing & Tiers -->
                    <div class="space-y-2.5">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                            <span class="w-5 h-5 rounded-full text-white font-black text-[11px] flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">2</span>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">
                                Pricing & Multi-Tier Discounts
                            </h3>
                        </div>

                        <!-- Primary Dual Pricing -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Solo Direct Buy Price (৳ BDT) <span class="text-rose-500">*</span></label>
                                <input type="number" step="1" name="single_price" x-model="singlePrice" required placeholder="1200"
                                       class="w-full px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-black text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <span class="text-[9px] text-slate-400 mt-0.5 block">Full price for single customer checkout</span>
                            </div>

                            <div class="p-3 rounded-xl bg-emerald-50/60 border border-emerald-200">
                                <label class="block text-xs font-bold text-emerald-950 mb-1">Standard Group-Buy Price (৳ BDT) <span class="text-rose-500">*</span></label>
                                <input type="number" step="1" name="group_price" x-model="groupPrice" required placeholder="990"
                                       class="w-full px-3 py-1.5 rounded-lg bg-white border border-emerald-300 text-xs font-black text-emerald-700 focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <div class="mt-0.5 flex items-center space-x-2 text-[10px]">
                                    <span class="text-emerald-800 font-bold" x-show="discountPercent > 0">
                                        Discount: <strong x-text="discountPercent + '% OFF'"></strong>
                                    </span>
                                    <span class="text-emerald-800 font-bold" x-show="savings > 0">
                                        (Save ৳<span x-text="savings"></span>)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Tiered Discounts (ধাপভিত্তিক গ্রুপ ডিসকাউন্ট অফার) -->
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-gradient-to-br from-purple-50/80 via-white to-indigo-50/60 border border-purple-200/90 shadow-2xs space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-purple-100 pb-2.5">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-black text-purple-950 uppercase tracking-wide">Custom Group Discount Tiers</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-600 text-white">Dynamic Milestones</span>
                                    </div>
                                    <p class="text-[11px] text-purple-900/80 mt-0.5">
                                        ক্রেতার সংখ্যার ওপর ভিত্তি করে কাস্টম ডিসকাউন্ট ধাপ নির্ধারণ করুন। যেমন: ৩ জনে ৫%, ৫ জনে ১০%, ৭ জনে ১৫%।
                                    </p>
                                </div>
                                <button type="button" @click="addTier()"
                                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition-all shadow-2xs self-start sm:self-auto cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    <span>+ Add Tier (ধাপ যোগ করুন)</span>
                                </button>
                            </div>

                            <!-- Tier Rows Container -->
                            <div class="space-y-2.5">
                                <template x-for="(tier, index) in customTiers" :key="index">
                                    <div class="p-3 rounded-xl bg-white border border-purple-150 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 transition-all hover:border-purple-300">
                                        <div class="flex items-center space-x-2 shrink-0">
                                            <span class="w-6 h-6 rounded-lg bg-purple-100 text-purple-800 font-black text-xs flex items-center justify-center" x-text="index + 1"></span>
                                            <span class="text-xs font-bold text-slate-800">Tier Milestone:</span>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 flex-1">
                                            <!-- Min Members -->
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Min Members (জন)</label>
                                                <div class="relative">
                                                    <input type="number" :name="'discount_tiers[' + index + '][min_members]'" x-model="tier.min_members" min="2" :max="groupSize - 1" placeholder="e.g. 3" required
                                                           class="w-full px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                                                    <span class="absolute right-2 top-1.5 text-[10px] font-bold text-slate-400">Buyers</span>
                                                </div>
                                            </div>

                                            <!-- Discount % -->
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Discount %</label>
                                                <div class="relative">
                                                    <input type="number" step="0.5" :name="'discount_tiers[' + index + '][discount_percent]'" x-model="tier.discount_percent" min="1" max="99" placeholder="e.g. 5" required
                                                           class="w-full px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                                                    <span class="absolute right-2 top-1.5 text-[10px] font-bold text-slate-400">%</span>
                                                </div>
                                            </div>

                                            <!-- Live Calculated Price Preview -->
                                            <div class="col-span-2 sm:col-span-1 flex flex-col justify-center bg-purple-50/60 p-1.5 rounded-lg border border-purple-100">
                                                <span class="text-[9px] uppercase font-bold text-purple-700">Effective Unit Price</span>
                                                <div class="flex items-baseline space-x-1.5">
                                                    <span class="text-xs font-black text-purple-900">৳<span x-text="getTierPrice(tier.discount_percent)"></span></span>
                                                    <span class="text-[10px] text-emerald-700 font-bold">(Save ৳<span x-text="getTierSavings(tier.discount_percent)"></span>)</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Remove Tier Button -->
                                        <button type="button" @click="removeTier(index)"
                                                class="p-1.5 rounded-lg hover:bg-rose-50 text-slate-400 hover:text-rose-600 transition-colors self-end sm:self-center cursor-pointer" title="Remove this tier">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>

                                <div x-show="customTiers.length === 0" class="p-3.5 rounded-xl border border-dashed border-purple-200 text-center text-xs text-purple-700">
                                    কোনো কাস্টম ধাপ নেই। উপরের "+ Add Tier" বাটনে ক্লিক করে ইচ্ছামতো মেম্বার ও ডিসকাউন্ট ধাপ যোগ করতে পারেন।
                                </div>
                            </div>

                            <!-- Dynamic explanation badge -->
                            <div class="p-2.5 rounded-xl bg-purple-100/60 border border-purple-200/70 text-[11px] text-purple-950 flex items-start space-x-2">
                                <span class="text-purple-600 font-bold shrink-0">💡</span>
                                <div class="space-y-0.5">
                                    <span class="font-extrabold block">নিরাপদ টিম-বাই গ্যারান্টি (Guaranteed Delivery):</span>
                                    <p class="text-purple-900">
                                        গ্রুপের সময় শেষে যদি মূল টার্গেট (<span x-text="groupSize || 10"></span> জন) পূর্ণ না-ও হয়, কিন্তু অর্জিত ধাপের শর্ত (যেমন ৩, ৫ বা ৭ জন) পূরণ হয়, তবে <strong>গ্রুপ বাতিল হবে না</strong>! ক্রেতারা অর্জিত ধাপ অনুযায়ী ডিসকাউন্ট পাবেন এবং অর্ডার সরাসরি ডেলিভারির জন্য প্রসেসিংয়ে যাবে।
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Member Size & Tiered Quota Rules -->
                    <div class="space-y-2.5 pt-1">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                            <span class="w-5 h-5 rounded-full text-white font-black text-[11px] flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">3</span>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">
                                Member Size
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                            <!-- Field 1: Target Group Size -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1">
                                    Target Group Size <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" name="group_size_required" x-model="groupSize" min="2" max="100" required placeholder="5"
                                       class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] transition-all">
                            </div>

                            <!-- Field 2: Min Quota to Ship -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1 flex items-center justify-between">
                                    <span>Min Quota to Ship</span>
                                    <span class="text-[9px] px-1.5 py-0.2 rounded bg-emerald-100 text-emerald-800 font-bold">Soft Quota</span>
                                </label>
                                <input type="number" name="min_quota_to_ship" x-model="minQuota" min="1" :max="groupSize" placeholder="3"
                                       class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] transition-all">
                            </div>

                            <!-- Field 3: Max Buyers Cap -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1 flex items-center justify-between">
                                    <span>Max Buyers Cap</span>
                                    <span class="text-[10px] text-slate-400 font-normal">ঐচ্ছিক</span>
                                </label>
                                <input type="number" id="editMaxCapInput" name="max_buyers_limit" value="{{ old('max_buyers_limit', $product->max_buyers_limit) }}" :min="groupSize" max="500" placeholder="e.g. 10"
                                       class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] transition-all">
                            </div>

                            <!-- Field 4: Duration Hours -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-1">
                                    Campaign Duration <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" name="group_duration_hours" x-model="duration" min="1" max="168" required placeholder="24"
                                       class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- 4. Promotional Placement & Campaigns -->
                    <div class="space-y-2 pt-1">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                            <span class="w-5 h-5 rounded-full text-white font-black text-[11px] flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">4</span>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">
                                Promotional Campaigns & Placement
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <!-- Option 1: Flash Sale -->
                            <label class="relative flex flex-col p-2.5 rounded-xl border transition-all cursor-pointer select-none"
                                   :class="isFlashSale ? 'border-amber-400 bg-amber-50/40 ring-1 ring-amber-400/20 shadow-xs' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="w-7 h-7 rounded-lg bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center text-xs shadow-xs">
                                            ⚡
                                        </span>
                                        <div>
                                            <span class="text-xs font-bold text-slate-900 block">Enroll in Flash Sales</span>
                                            <span class="text-[10px] text-slate-500 block">Show in Home Flash Sales strip</span>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="is_flash_sale" value="1" x-model="isFlashSale" class="w-4 h-4 text-amber-500 rounded border-slate-300 focus:ring-amber-400 mt-0.5 cursor-pointer">
                                </div>

                                <!-- Requirement badge -->
                                <div class="mt-2 pt-2 border-t border-slate-100 text-[10px]">
                                    <div class="flex items-center justify-between font-bold">
                                        <span class="text-slate-500">Min 20% Discount</span>
                                        <template x-if="discountPercent >= 20">
                                            <span class="text-emerald-700 bg-emerald-100/80 px-1.5 py-0.2 rounded font-black">✓ Qualified (<span x-text="discountPercent"></span>% OFF)</span>
                                        </template>
                                        <template x-if="discountPercent < 20">
                                            <span class="text-amber-700 bg-amber-100/80 px-1.5 py-0.2 rounded font-bold">⚠ <span x-text="discountPercent"></span>% (Need ≥20%)</span>
                                        </template>
                                    </div>
                                </div>
                            </label>

                            <!-- Option 2: Hot Deal Fast Track -->
                            <label class="relative flex flex-col p-2.5 rounded-xl border transition-all cursor-pointer select-none"
                                   :class="isHotDeal ? 'border-rose-400 bg-rose-50/40 ring-1 ring-rose-400/20 shadow-xs' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="w-7 h-7 rounded-lg bg-gradient-to-tr from-rose-500 to-pink-500 text-white flex items-center justify-center text-xs shadow-xs">
                                            🔥
                                        </span>
                                        <div>
                                            <span class="text-xs font-bold text-slate-900 block">Fast-Track Hot Deals</span>
                                            <span class="text-[10px] text-slate-500 block">Priority Rush Hour slot</span>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="is_hot_deal" value="1" x-model="isHotDeal" class="w-4 h-4 text-rose-500 rounded border-slate-300 focus:ring-rose-400 mt-0.5 cursor-pointer">
                                </div>

                                <div class="mt-2 pt-2 border-t border-slate-100 text-[10px] flex items-center justify-between font-bold text-slate-500">
                                    <span>Highest Social Urgency</span>
                                    <span class="text-rose-600 bg-rose-100/80 px-1.5 py-0.2 rounded">Boosted Views</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button Bar -->
                    <div class="pt-5 border-t border-slate-100 flex items-center justify-end space-x-3">
                        <a href="{{ route('seller.products') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl text-white font-extrabold text-xs transition-all cursor-pointer shadow-md hover:brightness-110 active:scale-95"
                                style="background-color: #53a318;">
                            Save Changes & Update Campaign &rarr;
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- Right: Live Customer Deal Card Preview (1 col) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 overflow-hidden sticky top-24">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black uppercase tracking-wider text-[#53a318]">Live Shopper Preview</span>
                    <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">Interactive</span>
                </div>

                <!-- Deal Card Simulation -->
                <div class="rounded-2xl border border-slate-200 overflow-hidden bg-slate-50 shadow-2xs">
                    <!-- Image -->
                    <div class="w-full h-44 bg-slate-200 relative overflow-hidden flex items-center justify-center">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!imagePreview">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-slate-400 text-xs font-bold">Product Image Preview</span>
                            @endif
                        </template>
                        <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-lg text-[10px] font-black text-white shadow-sm"
                              style="background-color: #53a318;">
                            👥 <span x-text="groupSize">2</span>-Person Pool
                        </span>

                        <template x-if="isFlashSale">
                            <span class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-lg text-[10px] font-black bg-amber-500 text-white shadow-sm">
                                ⚡ Flash Deal
                            </span>
                        </template>
                        <template x-if="isHotDeal && !isFlashSale">
                            <span class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-lg text-[10px] font-black bg-rose-600 text-white shadow-sm">
                                🔥 Hot Deal
                            </span>
                        </template>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 bg-white">
                        <h4 class="text-xs font-black text-slate-900 line-clamp-2" x-text="title || 'Product Title Appears Here...'"></h4>
                        
                        <div class="mt-3 flex items-baseline justify-between">
                            <div>
                                <span class="text-base font-black text-slate-900" x-text="'$' + (groupPrice ? parseFloat(groupPrice).toFixed(2) : '0.00')"></span>
                                <span class="text-xs text-slate-400 line-through ml-1" x-text="'$' + (singlePrice ? parseFloat(singlePrice).toFixed(2) : '0.00')"></span>
                            </div>
                            <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 px-1.5 py-0.2 rounded" x-show="discountPercent > 0">
                                -<span x-text="discountPercent"></span>%
                            </span>
                        </div>

                        <!-- Progress simulation -->
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-medium">
                            <span>⏱ <span x-text="duration">24</span>h duration</span>
                            <span class="text-[#53a318] font-bold">Fast-Unlock</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-500 leading-relaxed">
                    Sales recorded for this item: <strong class="text-slate-900">{{ $product->sales_count }} units</strong>.
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
