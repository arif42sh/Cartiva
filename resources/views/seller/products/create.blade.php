@extends('layouts.app')

@section('title', 'List New Product - Cartiva Seller')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{
         singlePrice: '{{ old('single_price', '') }}',
         groupPrice: '{{ old('group_price', '') }}',
         tier2Price: '{{ old('tier2_group_price', '') }}',
         tier3Price: '{{ old('tier3_group_price', '') }}',
         imagePreview: null,
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
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Create New Product & Group Campaign</h1>
            <p class="text-xs text-slate-500 mt-0.5">Define multi-tier group discounts, buyer caps, stock, and upload product visuals.</p>
        </div>
        <a href="{{ route('seller.products') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
            &larr; Back to Products
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

    <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-10 shadow-xs">
        
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

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
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Anker SoundCore Space One Wireless Headphones"
                           class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500 transition-all">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Marketplace Category <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="">Select a category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Initial Stock Units <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 50) }}" min="0" required
                               class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <!-- Product Image Upload + URL Option -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-xs font-bold text-slate-800 mb-2">Product Image (File Upload or Web URL) <span class="text-rose-500">*</span></label>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <!-- File Upload -->
                        <div>
                            <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Option A: Upload Local Image File</span>
                            <input type="file" name="image_file" accept="image/*" 
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                   class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-600 file:text-white hover:file:bg-teal-700 file:cursor-pointer">
                            <span class="text-[10px] text-slate-400 mt-1 block">JPG, PNG, WEBP up to 4MB</span>
                        </div>

                        <!-- Image URL -->
                        <div>
                            <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Option B: Or Direct Image Web URL</span>
                            <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/photo-..."
                                   @input="if ($event.target.value) imagePreview = $event.target.value"
                                   class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <template x-if="imagePreview">
                        <div class="mt-4 flex items-center space-x-3 p-3 bg-white rounded-xl border border-slate-200">
                            <img :src="imagePreview" alt="Preview" class="w-16 h-16 rounded-lg object-cover bg-slate-100 flex-shrink-0">
                            <div>
                                <span class="text-xs font-bold text-emerald-700 block">Image Selected & Ready</span>
                                <span class="text-[11px] text-slate-400">This thumbnail will be featured on customer deal feeds.</span>
                            </div>
                        </div>
                    </template>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Product Description <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="4" required placeholder="Highlight key specifications, package contents, materials, warranty, and special team-buy benefits..."
                              class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">{{ old('description') }}</textarea>
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
                        <input type="number" step="0.01" name="single_price" x-model="singlePrice" required placeholder="149.00"
                               class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-black text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                        <span class="text-[11px] text-slate-500 mt-1 block">Full retail price when purchased individually.</span>
                    </div>

                    <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200">
                        <label class="block text-xs font-bold text-emerald-950 mb-1">Standard Group Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="group_price" x-model="groupPrice" required placeholder="99.00"
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

                <!-- Advanced Wholesale Price Tiers (Requirement v) -->
                <div class="p-5 rounded-2xl bg-slate-50/70 border border-slate-200">
                    <div class="mb-3">
                        <span class="text-xs font-bold text-slate-800 block">Optional Volume Tiers (Larger Teams)</span>
                        <span class="text-[11px] text-slate-500">Incentivize viral sharing with deeper discounts for larger circles.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-purple-900 mb-1">Tier 2 Price (e.g. 5+ Buyers) ($ USD)</label>
                            <input type="number" step="0.01" name="tier2_group_price" value="{{ old('tier2_group_price') }}" placeholder="Optional (e.g. 89.00)"
                                   class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Even cheaper than standard group price</span>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-purple-900 mb-1">Tier 3 Super-Team Price (e.g. 10+ Buyers) ($ USD)</label>
                            <input type="number" step="0.01" name="tier3_group_price" value="{{ old('tier3_group_price') }}" placeholder="Optional (e.g. 79.00)"
                                   class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Mega pool wholesale rate</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Group Size & Campaign Duration Rules -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Minimum Group Size <span class="text-rose-500">*</span></label>
                        <select name="group_size_required" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="2" {{ old('group_size_required', 2) == 2 ? 'selected' : '' }}>2 Buyers (Fastest completion)</option>
                            <option value="3" {{ old('group_size_required') == 3 ? 'selected' : '' }}>3 Buyers</option>
                            <option value="4" {{ old('group_size_required') == 4 ? 'selected' : '' }}>4 Buyers</option>
                            <option value="5" {{ old('group_size_required') == 5 ? 'selected' : '' }}>5 Buyers (Community)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Max Buyers Cap (Limit)</label>
                        <input type="number" name="max_buyers_limit" value="{{ old('max_buyers_limit') }}" min="2" max="100" placeholder="e.g. 10 (Optional)"
                               class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                        <span class="text-[10px] text-slate-400 mt-0.5 block">Leave empty for unlimited slots</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Campaign Duration (Hours) <span class="text-rose-500">*</span></label>
                        <select name="group_duration_hours" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="12" {{ old('group_duration_hours') == 12 ? 'selected' : '' }}>12 Hours (Flash Deal)</option>
                            <option value="24" {{ old('group_duration_hours', 24) == 24 ? 'selected' : '' }}>24 Hours (Standard)</option>
                            <option value="48" {{ old('group_duration_hours') == 48 ? 'selected' : '' }}>48 Hours (Weekend Deal)</option>
                            <option value="72" {{ old('group_duration_hours') == 72 ? 'selected' : '' }}>72 Hours</option>
                            <option value="168" {{ old('group_duration_hours') == 168 ? 'selected' : '' }}>7 Days (Weekly Special)</option>
                        </select>
                    </div>
                </div>

            </div>

            <!-- Submit Button Bar -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('seller.products') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-md shadow-teal-600/25 transition-all cursor-pointer">
                    Publish Product & Launch Campaign &rarr;
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
