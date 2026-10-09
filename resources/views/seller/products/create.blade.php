@extends('layouts.app')

@section('title', 'List New Product - Cartiva Seller')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <a href="{{ route('seller.products') }}" class="text-xs font-bold text-slate-500 hover:text-teal-600 flex items-center space-x-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span>Back to Inventory</span>
        </a>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">List New Product with Group Buying</h1>
        <p class="text-xs text-slate-500 mt-1">Configure both solo retail pricing and wholesale group buy parameters.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm">
        
        <form action="{{ route('seller.products.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Basic Details -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-teal-800 border-b border-slate-100 pb-2">
                    1. Product Basics
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Product Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Ultra ANC Wireless Headphones"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    @error('title') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category</label>
                        <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                            <option value="">Select a category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Initial Stock Units</label>
                        <input type="number" name="stock" value="{{ old('stock', 50) }}" min="1" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        @error('stock') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Image URL (Direct high-res photo link)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" required placeholder="https://images.unsplash.com/..."
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    @error('image_url') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Product Description</label>
                    <textarea name="description" rows="3" required placeholder="Detailed product specifications, warranty, features..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('description') }}</textarea>
                    @error('description') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Group Buy Pricing Architecture -->
            <div class="space-y-4 pt-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-emerald-800 border-b border-slate-100 pb-2">
                    2. Dual Pricing & Group Mechanics
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Solo Standard Price ($ USD)</label>
                        <input type="number" step="0.01" name="single_price" value="{{ old('single_price') }}" required placeholder="149.00"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <span class="text-[11px] text-slate-500 mt-1 block">Full retail price for solo buyers</span>
                        @error('single_price') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200">
                        <label class="block text-xs font-bold text-emerald-900 mb-1">Discounted Team Buy Price ($ USD)</label>
                        <input type="number" step="0.01" name="group_price" value="{{ old('group_price') }}" required placeholder="99.00"
                               class="w-full px-4 py-2.5 rounded-xl border border-emerald-300 text-xs font-bold text-emerald-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <span class="text-[11px] text-emerald-700 mt-1 block">Must be lower than solo price</span>
                        @error('group_price') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Required Group Size (Buyers)</label>
                        <select name="group_size_required" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                            <option value="2" {{ old('group_size_required') == 2 ? 'selected' : '' }}>2 People (Quickest to fill - Recommended)</option>
                            <option value="3" {{ old('group_size_required') == 3 ? 'selected' : '' }}>3 People</option>
                            <option value="4" {{ old('group_size_required') == 4 ? 'selected' : '' }}>4 People</option>
                            <option value="5" {{ old('group_size_required') == 5 ? 'selected' : '' }}>5 People</option>
                        </select>
                        @error('group_size_required') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Group Countdown Duration (Hours)</label>
                        <select name="group_duration_hours" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                            <option value="12" {{ old('group_duration_hours') == 12 ? 'selected' : '' }}>12 Hours (Flash Deal)</option>
                            <option value="24" {{ old('group_duration_hours', 24) == 24 ? 'selected' : '' }}>24 Hours (Standard)</option>
                            <option value="48" {{ old('group_duration_hours') == 48 ? 'selected' : '' }}>48 Hours (Weekend Deal)</option>
                            <option value="72" {{ old('group_duration_hours') == 72 ? 'selected' : '' }}>72 Hours</option>
                        </select>
                        @error('group_duration_hours') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('seller.products') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white shadow-md shadow-teal-600/30 transition-all">
                    Publish & Activate Deal
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
