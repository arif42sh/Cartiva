@extends('layouts.seller')

@section('title', 'Edit Product - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{
         title: '{{ addslashes(old('title', $product->title)) }}',
         singlePrice: '{{ old('single_price', $product->single_price) }}',
         groupPrice: '{{ old('group_price', $product->group_price) }}',
         tier2Price: '{{ old('tier2_group_price', $product->tier2_group_price) }}',
         tier3Price: '{{ old('tier3_group_price', $product->tier3_group_price) }}',
         groupSize: '{{ old('group_size_required', $product->group_size_required) }}',
         duration: '{{ old('group_duration_hours', $product->group_duration_hours) }}',
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

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Product & Group Deal Parameters</h1>
            <p class="text-xs text-slate-500 mt-0.5">Modify pricing tiers, update available inventory units, or refresh product visuals.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.show', $product) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors flex items-center space-x-1.5 shadow-sm">
                <span>View Storefront Page ↗</span>
            </a>
            <a href="{{ route('seller.products') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                &larr; Back to Products
            </a>
        </div>
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

    <!-- 2-Column Full-Width Grid (Consistent max-w-7xl) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Edit Form (2 cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                
                <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- 1. Product Basics -->
                    <div class="space-y-5">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                            <span class="w-6 h-6 rounded-full text-white font-black text-xs flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">1</span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                Product Information
                            </h3>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Product Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" x-model="title" value="{{ old('title', $product->title) }}" required
                                   class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Marketplace Category <span class="text-rose-500">*</span></label>
                                <select name="category_id" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Available Stock Units <span class="text-rose-500">*</span></label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <span class="text-[10px] text-slate-500 mt-0.5 block">
                                    Current Remaining: <strong>{{ $product->stock }}</strong> | Sold: <strong>{{ $product->sales_count }}</strong> | Total: <strong>{{ $product->stock + $product->sales_count }}</strong>
                                </span>
                            </div>
                        </div>

                        <!-- Product Image Upload + URL Option -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <label class="block text-xs font-bold text-slate-800 mb-2">Update Product Image</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                                <div>
                                    <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Upload New File</span>
                                    <input type="file" name="image_file" accept="image/*" 
                                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:text-white file:cursor-pointer"
                                           style="--tw-file-bg: #53a318;">
                                </div>

                                <div>
                                    <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Or Replace Web Image URL</span>
                                    <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                                           @input="if ($event.target.value) imagePreview = $event.target.value"
                                           class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                </div>
                            </div>

                            <!-- Image Preview -->
                            <template x-if="imagePreview">
                                <div class="mt-4 flex items-center space-x-3 p-3 bg-white rounded-xl border border-slate-200">
                                    <img :src="imagePreview" alt="Preview" class="w-16 h-16 rounded-lg object-cover bg-slate-100 flex-shrink-0">
                                    <div>
                                        <span class="text-xs font-bold text-emerald-700 block">Current Thumbnail Display</span>
                                        <span class="text-[11px] text-slate-400">Featured across live circles and storefront view.</span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Product Description <span class="text-rose-500">*</span></label>
                            <textarea name="description" rows="4" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <!-- 2. Group Buy Pricing & Tiers -->
                    <div class="space-y-5">
                        <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                            <span class="w-6 h-6 rounded-full text-white font-black text-xs flex items-center justify-center shadow-xs"
                                  style="background-color: #53a318;">2</span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-slate-900">
                                Group Buying Pricing & Multi-Tier Discounts
                            </h3>
                        </div>

                        <!-- Primary Dual Pricing -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Solo Direct Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                                <input type="number" step="0.01" name="single_price" x-model="singlePrice" required
                                       class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-black text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                            </div>

                            <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200">
                                <label class="block text-xs font-bold text-emerald-950 mb-1">Standard Group-Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                                <input type="number" step="0.01" name="group_price" x-model="groupPrice" required
                                       class="w-full px-4 py-2.5 rounded-xl bg-white border border-emerald-300 text-sm font-black text-emerald-700 focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <div class="mt-1 flex items-center space-x-2 text-[10px]">
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
                        <div class="p-5 rounded-2xl bg-purple-50/50 border border-purple-200 space-y-4">
                            <div>
                                <h4 class="text-xs font-extrabold text-purple-950">Volume Price Tiers (Viral Escalation)</h4>
                                <p class="text-[11px] text-purple-700">Reward bigger teams with deeper bulk discounts.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-purple-900 mb-1">Tier 2 Price (e.g. 5+ Buyers) ($ USD)</label>
                                    <input type="number" step="0.01" name="tier2_group_price" x-model="tier2Price" placeholder="Optional"
                                           class="w-full px-3.5 py-2 rounded-xl bg-white border border-purple-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-purple-900 mb-1">Tier 3 Super-Team Price (e.g. 10+ Buyers)</label>
                                    <input type="number" step="0.01" name="tier3_group_price" x-model="tier3Price" placeholder="Optional"
                                           class="w-full px-3.5 py-2 rounded-xl bg-white border border-purple-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Group Size & Campaign Duration Rules -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Minimum Group Size <span class="text-rose-500">*</span></label>
                                <select name="group_size_required" x-model="groupSize" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    <option value="2">2 Buyers</option>
                                    <option value="3">3 Buyers</option>
                                    <option value="4">4 Buyers</option>
                                    <option value="5">5 Buyers</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Max Buyers Cap (Limit)</label>
                                <input type="number" name="max_buyers_limit" value="{{ old('max_buyers_limit', $product->max_buyers_limit) }}" min="2" max="100" placeholder="e.g. 10 (Optional)"
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Campaign Duration (Hours) <span class="text-rose-500">*</span></label>
                                <select name="group_duration_hours" x-model="duration" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    <option value="12">12 Hours</option>
                                    <option value="24">24 Hours (Standard)</option>
                                    <option value="48">48 Hours</option>
                                    <option value="72">72 Hours</option>
                                    <option value="168">7 Days</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button Bar -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                        <a href="{{ route('seller.products') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl text-white font-extrabold text-xs transition-all cursor-pointer shadow-lg hover:brightness-110 active:scale-95"
                                style="background-color: #53a318; box-shadow: 0 4px 14px rgba(83, 163, 24, 0.35);">
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
                    <span class="text-[10px] font-black uppercase tracking-wider text-[#53a318]">Live Shopper Preview</span>
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
                            <span class="text-slate-400 text-xs font-bold">Product Image Preview</span>
                        </template>
                        <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-lg text-[10px] font-black text-white shadow-sm"
                              style="background-color: #53a318;">
                            👥 <span x-text="groupSize">2</span>-Person Pool
                        </span>
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
