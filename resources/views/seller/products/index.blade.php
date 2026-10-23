@extends('layouts.app')

@section('title', 'Manage Products & Stock - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ quickStockModal: false, selectedProduct: null, stockValue: 0 }">

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

    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold flex items-center justify-between shadow-2xs">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900">&times;</button>
        </div>
    @endif

    <!-- Controls Bar: Search, Category Filter, Status Pills -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs mb-6">
        <form action="{{ route('seller.products') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Search Input -->
            <div class="relative flex-1 max-w-md">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products by title or keywords..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500 transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- Filters -->
            <div class="flex items-center space-x-2 flex-wrap sm:flex-nowrap">
                <select name="category" onchange="this.form.submit()" class="py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()" class="py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Items</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Items</option>
                    <option value="low_stock" {{ request('status') === 'low_stock' ? 'selected' : '' }}>Low Stock (≤5)</option>
                    <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>

                @if(request()->hasAny(['q', 'category', 'status']))
                    <a href="{{ route('seller.products') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition-colors">
                        Clear
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Products Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Product Details</th>
                        <th class="py-3.5 px-6">Category</th>
                        <th class="py-3.5 px-6">Pricing & Tiers</th>
                        <th class="py-3.5 px-6">Group Rules</th>
                        <th class="py-3.5 px-6">Stock Level</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            
                            <!-- Product Info -->
                            <td class="py-4 px-6 flex items-center space-x-3.5">
                                <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                                <div class="max-w-xs">
                                    <a href="{{ route('products.show', $product) }}" target="_blank" class="font-extrabold text-slate-900 hover:text-teal-600 line-clamp-1 transition-colors">
                                        {{ $product->title }}
                                    </a>
                                    <div class="flex items-center space-x-2 text-[10px] text-slate-400 mt-0.5">
                                        <span>{{ $product->sales_count }} sales</span>
                                        <span>•</span>
                                        <span>★ {{ number_format($product->rating, 1) }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-[11px]">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            <!-- Pricing & Tiers -->
                            <td class="py-4 px-6">
                                <div class="space-y-0.5">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-slate-400 font-medium">Solo:</span>
                                        <span class="font-bold text-slate-700">${{ number_format($product->single_price, 2) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-teal-700 font-bold">Team:</span>
                                        <span class="font-black text-emerald-600">${{ number_format($product->group_price, 2) }}</span>
                                        <span class="text-[9px] bg-emerald-100 text-emerald-800 px-1 py-0.2 rounded font-black">-{{ $product->discount_percent }}%</span>
                                    </div>
                                    @if($product->tier2_group_price)
                                        <span class="block text-[10px] text-purple-600 font-semibold">Tier 2: ${{ number_format($product->tier2_group_price, 2) }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Group Rules -->
                            <td class="py-4 px-6">
                                <div class="text-[11px] font-semibold text-slate-700">
                                    <div>👥 Min: <strong class="text-slate-900">{{ $product->group_size_required }}</strong> buyers</div>
                                    @if($product->max_buyers_limit)
                                        <div class="text-[10px] text-slate-500">Max limit: {{ $product->max_buyers_limit }}</div>
                                    @endif
                                    <div class="text-[10px] text-amber-600 font-bold mt-0.5">⏱ {{ $product->group_duration_hours }}h campaign</div>
                                </div>
                            </td>

                            <!-- Stock Level -->
                            <td class="py-4 px-6">
                                <button type="button" 
                                        @click="quickStockModal = true; selectedProduct = {{ $product->toJson() }}; stockValue = {{ $product->stock }};" 
                                        class="group inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-xl text-xs font-bold border transition-all cursor-pointer
                                        {{ $product->stock <= 0 ? 'bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100' : 
                                          ($product->stock <= 5 ? 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-800 border-emerald-200 hover:bg-emerald-100') }}"
                                        title="Click to quickly update stock">
                                    <span>{{ $product->stock }} in stock</span>
                                    <svg class="w-3 h-3 opacity-60 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </td>

                            <!-- Active / Inactive Status -->
                            <td class="py-4 px-6">
                                <form action="{{ route('seller.products.toggle-status', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="px-2.5 py-1 rounded-full text-[10px] font-black cursor-pointer transition-all {{ $product->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200 border border-emerald-300' : 'bg-slate-200 text-slate-600 hover:bg-slate-300 border border-slate-300' }}"
                                            title="Click to toggle status">
                                        {{ $product->is_active ? '● Active' : '○ Inactive' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center space-x-2">
                                    <a href="{{ route('seller.products.edit', $product) }}" 
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#53a318] transition-colors" 
                                       title="Edit Product & Pricing">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product? (It cannot be undone)')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-700 hover:text-rose-600 transition-colors cursor-pointer" title="Delete Product">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>

                                    <a href="{{ route('products.show', $product) }}" target="_blank" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors" title="View Storefront Page">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <span class="text-3xl block mb-2">📦</span>
                                <p class="text-xs font-bold text-slate-600">No products found matching your criteria.</p>
                                <a href="{{ route('seller.products.create') }}" 
                                   class="mt-3 inline-block px-4.5 py-2.5 rounded-xl text-white font-extrabold text-xs transition-all shadow-md hover:brightness-110"
                                   style="background-color: #53a318; box-shadow: 0 4px 12px rgba(83, 163, 24, 0.35);">
                                    + Add Your First Product
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Quick Stock Update Modal -->
    <div x-show="quickStockModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div @click.outside="quickStockModal = false" class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl border border-slate-100">
            <h4 class="text-base font-extrabold text-slate-900 mb-1">Quick Stock Restock</h4>
            <p class="text-xs text-slate-500 mb-4" x-text="selectedProduct ? selectedProduct.title : ''"></p>

            <form :action="'{{ url('/seller/products') }}/' + (selectedProduct ? selectedProduct.id : '') + '/quick-stock'" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Available Quantity Units</label>
                    <input type="number" name="stock" x-model="stockValue" min="0" required 
                           class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-sm font-black focus:outline-hidden focus:ring-2 focus:ring-[#53a318]">
                </div>

                <div class="flex items-center justify-end space-x-2">
                    <button type="button" @click="quickStockModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 rounded-xl text-white font-extrabold text-xs transition-all shadow-md hover:brightness-110"
                            style="background-color: #53a318;">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
