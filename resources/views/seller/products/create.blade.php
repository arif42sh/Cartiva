@extends('layouts.seller')

@section('title', 'List New Product - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{
         title: '{{ addslashes(old('title', '')) }}',
         singlePrice: '{{ old('single_price', '') }}',
         groupPrice: '{{ old('group_price', '') }}',
         tier2Price: '{{ old('tier2_group_price', '') }}',
         tier3Price: '{{ old('tier3_group_price', '') }}',
         groupSize: '{{ old('group_size_required', 2) }}',
         duration: '{{ old('group_duration_hours', 24) }}',
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

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Create New Product & Group Campaign</h1>
            <p class="text-xs text-slate-500 mt-0.5">Define multi-tier group discounts, buyer caps, stock, and upload product visuals.</p>
        </div>
        <a href="{{ route('seller.products') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors self-start sm:self-auto">
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

    <!-- 2-Column Full-Width Grid (Consistent max-w-7xl) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Form Card (2 cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

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
                            <input type="text" name="title" x-model="title" value="{{ old('title') }}" required placeholder="e.g. Anker SoundCore Space One Wireless Headphones"
                                   class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Marketplace Category <span class="text-rose-500">*</span></label>
                                <select name="category_id" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Available Inventory Stock Units <span class="text-rose-500">*</span></label>
                                <input type="number" name="stock" value="{{ old('stock', 50) }}" min="2" required
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <span class="text-[10px] text-slate-400 mt-0.5 block">Total quantity available for sale (must be &ge; group size)</span>
                            </div>
                        </div>

                        <!-- Product Image Upload + URL Option -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                            <label class="block text-xs font-bold text-slate-800 mb-2">Product Image (File Upload or Web URL) <span class="text-rose-500">*</span></label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                                <!-- File Upload -->
                                <div>
                                    <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Option A: Upload Local Image File</span>
                                    <input type="file" name="image_file" accept="image/*" 
                                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:text-white file:cursor-pointer"
                                           style="--tw-file-bg: #53a318;">
                                    <span class="text-[10px] text-slate-400 mt-1 block">JPG, PNG, WEBP up to 4MB</span>
                                </div>

                                <!-- Image URL -->
                                <div>
                                    <span class="text-[11px] font-semibold text-slate-500 block mb-1.5">Option B: Or Direct Image Web URL</span>
                                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/photo-..."
                                           @input="if ($event.target.value) imagePreview = $event.target.value"
                                           class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
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
                                      class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">{{ old('description') }}</textarea>
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
                                <input type="number" step="0.01" name="single_price" x-model="singlePrice" required placeholder="149.00"
                                       class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-black text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <span class="text-[10px] text-slate-400 mt-1 block">Full price for single customer checkout</span>
                            </div>

                            <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200">
                                <label class="block text-xs font-bold text-emerald-950 mb-1">Standard Group-Buy Price ($ USD) <span class="text-rose-500">*</span></label>
                                <input type="number" step="0.01" name="group_price" x-model="groupPrice" required placeholder="99.00"
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
                                    <input type="number" step="0.01" name="tier2_group_price" x-model="tier2Price" value="{{ old('tier2_group_price') }}" placeholder="Optional (e.g. 89.00)"
                                           class="w-full px-3.5 py-2 rounded-xl bg-white border border-purple-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">Cheaper than standard group rate</span>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-purple-900 mb-1">Tier 3 Super-Team Price (e.g. 10+ Buyers)</label>
                                    <input type="number" step="0.01" name="tier3_group_price" x-model="tier3Price" value="{{ old('tier3_group_price') }}" placeholder="Optional (e.g. 79.00)"
                                           class="w-full px-3.5 py-2 rounded-xl bg-white border border-purple-200 text-xs font-bold focus:outline-hidden focus:ring-2 focus:ring-purple-500">
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">Mega pool wholesale rate</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Group Size & Campaign Duration Rules -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Minimum Group Size <span class="text-rose-500">*</span></label>
                                <select name="group_size_required" x-model="groupSize" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    <option value="2">2 Buyers (Fastest completion)</option>
                                    <option value="3">3 Buyers</option>
                                    <option value="4">4 Buyers</option>
                                    <option value="5">5 Buyers (Community)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Max Buyers Cap (Per Circle)</label>
                                <input type="number" name="max_buyers_limit" value="{{ old('max_buyers_limit') }}" min="2" max="100" placeholder="e.g. 8 (Optional)"
                                       class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                <span class="text-[10px] text-slate-400 mt-0.5 block">Maximum buyers allowed in a single circle</span>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Campaign Duration (Hours) <span class="text-rose-500">*</span></label>
                                <select name="group_duration_hours" x-model="duration" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                                    <option value="12">12 Hours (Flash Deal)</option>
                                    <option value="24">24 Hours (Standard)</option>
                                    <option value="48">48 Hours (Weekend Deal)</option>
                                    <option value="72">72 Hours</option>
                                    <option value="168">7 Days (Weekly Special)</option>
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
                            Publish Product & Launch Campaign &rarr;
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
                    💡 <strong>Pro Tip:</strong> Products with a 2-person group requirement fill within 2.3 hours on average.
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
