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
                                <label class="block text-xs font-bold text-slate-700 mb-1">Solo Direct Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                                <input type="number" step="0.01" name="single_price" x-model="singlePrice" required placeholder="149.00"
                                       class="w-full px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-black text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <span class="text-[9px] text-slate-400 mt-0.5 block">Full price for single customer checkout</span>
                            </div>

                            <div class="p-3 rounded-xl bg-emerald-50/60 border border-emerald-200">
                                <label class="block text-xs font-bold text-emerald-950 mb-1">Standard Group-Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                                <input type="number" step="0.01" name="group_price" x-model="groupPrice" required placeholder="99.00"
                                       class="w-full px-3 py-1.5 rounded-lg bg-white border border-emerald-300 text-xs font-black text-emerald-700 focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <div class="mt-0.5 flex items-center space-x-2 text-[10px]">
                                    <span class="text-emerald-800 font-bold" x-show="discountPercent > 0">
                                        Discount: <strong x-text="discountPercent + '% OFF'"></strong>
                                    </span>
                                    <span class="text-emerald-800 font-bold" x-show="savings > 0">
                                        (Save $<span x-text="savings"></span>)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Optional Tier 2 & Tier 3 -->
                        <div class="p-3 rounded-xl bg-purple-50/50 border border-purple-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-extrabold text-purple-950">Volume Price Tiers</h4>
                                <span class="text-[10px] text-purple-600 font-medium">Bigger teams unlock deeper rates</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <div>
                                    <label class="block text-[10px] font-bold text-purple-900 mb-0.5">Tier 2 Price (5+ Buyers) ($ USD)</label>
                                    <input type="number" step="0.01" name="tier2_group_price" x-model="tier2Price" value="{{ old('tier2_group_price', $product->tier2_group_price) }}" placeholder="Optional (e.g. 89.00)"
                                           class="w-full px-3 py-1.5 rounded-lg bg-white border border-purple-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-purple-900 mb-0.5">Tier 3 Super-Team Price (10+ Buyers)</label>
                                    <input type="number" step="0.01" name="tier3_group_price" x-model="tier3Price" value="{{ old('tier3_group_price', $product->tier3_group_price) }}" placeholder="Optional (e.g. 79.00)"
                                           class="w-full px-3 py-1.5 rounded-lg bg-white border border-purple-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
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
