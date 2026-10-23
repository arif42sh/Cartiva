@extends('layouts.app')

@section('title', 'Edit Product - Cartiva Seller')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{
         singlePrice: '{{ old('single_price', $product->single_price) }}',
         groupPrice: '{{ old('group_price', $product->group_price) }}',
         tier2Price: '{{ old('tier2_group_price', $product->tier2_group_price) }}',
         tier3Price: '{{ old('tier3_group_price', $product->tier3_group_price) }}',
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

    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('seller.products') }}" class="hover:text-teal-600">Products</a>
                <span>/</span>
                <span class="text-slate-800">Edit</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit: {{ $product->title }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Modify pricing tiers, group duration, stock levels, or update imagery.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.show', $product) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition-colors">
                View Live Page &rarr;
            </a>
            <a href="{{ route('seller.products') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                Back to Inventory
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

    <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-10 shadow-xs">
        
        <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. Product Basics -->
            <div class="space-y-5">
                <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-teal-800 font-black text-xs flex items-center justify-center">1</span>
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">
                        Product Information
                    </h3>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Product Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}" required 
                           class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500 transition-all">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Marketplace Category <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Stock Level Units <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                               class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <!-- Product Image Update -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-xs font-bold text-slate-800 mb-2">Update Product Image (Optional)</label>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <!-- File Upload -->
                        <div>
                            <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Upload Replacement Image File</span>
                            <input type="file" name="image_file" accept="image/*" 
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                   class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-600 file:text-white hover:file:bg-teal-700 file:cursor-pointer">
                            <span class="text-[10px] text-slate-400 mt-1 block">Leave empty to keep existing image</span>
                        </div>

                        <!-- Image URL -->
                        <div>
                            <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Or Replace with Image Web URL</span>
                            <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" placeholder="https://..."
                                   @input="if ($event.target.value) imagePreview = $event.target.value"
                                   class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <template x-if="imagePreview">
                        <div class="mt-4 flex items-center space-x-3 p-3 bg-white rounded-xl border border-slate-200">
                            <img :src="imagePreview" alt="Preview" class="w-16 h-16 rounded-lg object-cover bg-slate-100 flex-shrink-0">
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">Current Thumbnail Display</span>
                                <span class="text-[11px] text-slate-400">Featured in customer group circles and flash deals.</span>
                            </div>
                        </div>
                    </template>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Product Description <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="4" required 
                              class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Active Status Checkbox -->
                <div class="flex items-center space-x-2.5 pt-2">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }} 
                           class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300">
                    <label for="is_active" class="text-xs font-bold text-slate-800 cursor-pointer">
                        Product is Active (Visible on marketplace catalog & available for group buying)
                    </label>
                </div>
            </div>

            <!-- 2. Group Buy Pricing & Tiers -->
            <div class="space-y-5">
                <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs flex items-center justify-center">2</span>
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">
                        Group Buying Pricing & Multi-Tier Discounts
                    </h3>
                </div>

                <!-- Primary Dual Pricing -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Solo Direct Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="single_price" x-model="singlePrice" required
                               class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-black text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                        <span class="text-[11px] text-slate-500 mt-1 block">Full retail price when purchased individually.</span>
                    </div>

                    <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200">
                        <label class="block text-xs font-bold text-emerald-950 mb-1">Standard Group Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="group_price" x-model="groupPrice" required
                               class="w-full px-4 py-2.5 rounded-xl bg-white border border-emerald-300 text-sm font-black text-emerald-700 focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                        <span class="text-[11px] text-emerald-700 mt-1 block">Must be lower than solo retail price.</span>
                    </div>
                </div>

                <!-- Live Savings Pill -->
                <div x-show="discountPercent > 0" class="p-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white flex items-center justify-between text-xs font-bold shadow-xs">
                    <div class="flex items-center space-x-2">
                        <span class="text-base">🔥</span>
                        <span>Team buyers will save <strong x-text="'$' + savings"></strong> per unit!</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-md bg-white text-emerald-800 text-[11px] font-black" x-text="'-' + discountPercent + '% OFF'"></span>
                </div>

                <!-- Advanced Wholesale Price Tiers -->
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200">
                    <div class="mb-3">
                        <span class="text-xs font-bold text-slate-800 block">Volume Tiers (Larger Teams)</span>
                        <span class="text-[11px] text-slate-500">Incentivize viral sharing with deeper discounts for larger circles.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-purple-900 mb-1">Tier 2 Price (e.g. 5+ Buyers) ($ USD)</label>
                            <input type="number" step="0.01" name="tier2_group_price" value="{{ old('tier2_group_price', $product->tier2_group_price) }}" placeholder="Optional (e.g. 89.00)"
                                   class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Lower than standard group price</span>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-purple-900 mb-1">Tier 3 Super-Team Price (e.g. 10+ Buyers) ($ USD)</label>
                            <input type="number" step="0.01" name="tier3_group_price" value="{{ old('tier3_group_price', $product->tier3_group_price) }}" placeholder="Optional (e.g. 79.00)"
                                   class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Mega pool wholesale rate</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Group Size & Duration Rules -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Minimum Group Size <span class="text-rose-500">*</span></label>
                        <select name="group_size_required" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="2" {{ old('group_size_required', $product->group_size_required) == 2 ? 'selected' : '' }}>2 Buyers</option>
                            <option value="3" {{ old('group_size_required', $product->group_size_required) == 3 ? 'selected' : '' }}>3 Buyers</option>
                            <option value="4" {{ old('group_size_required', $product->group_size_required) == 4 ? 'selected' : '' }}>4 Buyers</option>
                            <option value="5" {{ old('group_size_required', $product->group_size_required) == 5 ? 'selected' : '' }}>5 Buyers</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Max Buyers Cap (Limit)</label>
                        <input type="number" name="max_buyers_limit" value="{{ old('max_buyers_limit', $product->max_buyers_limit) }}" min="2" max="100" placeholder="e.g. 10 (Optional)"
                               class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                        <span class="text-[10px] text-slate-400 mt-0.5 block">Leave empty for unlimited slots</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Campaign Duration (Hours) <span class="text-rose-500">*</span></label>
                        <select name="group_duration_hours" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="12" {{ old('group_duration_hours', $product->group_duration_hours) == 12 ? 'selected' : '' }}>12 Hours</option>
                            <option value="24" {{ old('group_duration_hours', $product->group_duration_hours) == 24 ? 'selected' : '' }}>24 Hours (Standard)</option>
                            <option value="48" {{ old('group_duration_hours', $product->group_duration_hours) == 48 ? 'selected' : '' }}>48 Hours</option>
                            <option value="72" {{ old('group_duration_hours', $product->group_duration_hours) == 72 ? 'selected' : '' }}>72 Hours</option>
                            <option value="168" {{ old('group_duration_hours', $product->group_duration_hours) == 168 ? 'selected' : '' }}>7 Days</option>
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
@endsection
