@extends('layouts.admin')

@section('title', 'Platform Catalog Oversight - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
                <span>/</span>
                <span class="text-purple-700">Catalog</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Marketplace Catalog & Quality Control</h1>
            <p class="text-xs text-slate-500 mt-1">Audit merchant items, toggle Flash Sale & Hot Deal flags, approve product listings, and control catalog visibility.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mb-6 shadow-xs">
        <form action="{{ route('admin.products') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <div class="flex-1 relative">
                <input type="text" name="q" value="{{ request('q') }}" 
                       placeholder="Search products by title or keywords..." 
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-purple-600 focus:bg-white transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <select name="category_id" class="px-3 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-hidden focus:ring-2 focus:ring-purple-600">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="status" class="px-3 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-hidden focus:ring-2 focus:ring-purple-600">
                    <option value="">All Visibility</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Items</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Hidden Items</option>
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-xs transition-all cursor-pointer">
                    Filter
                </button>

                @if(request()->hasAny(['q', 'category_id', 'status']))
                    <a href="{{ route('admin.products') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-black border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Product Details</th>
                        <th class="py-3.5 px-6">Category</th>
                        <th class="py-3.5 px-6">Merchant Store</th>
                        <th class="py-3.5 px-6 text-right">Pricing (Solo / Team)</th>
                        <th class="py-3.5 px-6 text-center">Group Policy</th>
                        <th class="py-3.5 px-6 text-center">Stock</th>
                        <th class="py-3.5 px-6 text-center">Campaign Tags</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $prod)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 flex items-center space-x-3">
                                <img src="{{ $prod->image_url }}" alt="{{ $prod->title }}" class="w-10 h-10 rounded-xl object-cover bg-slate-100 flex-shrink-0 shadow-2xs">
                                <div>
                                    <a href="{{ route('products.show', $prod->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-purple-700 transition-colors line-clamp-1 max-w-[200px]">
                                        {{ $prod->title }}
                                    </a>
                                    <span class="text-[11px] text-slate-400 font-mono">SKU: #{{ $prod->id }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ $prod->category->name ?? 'General' }}
                            </td>

                            <td class="py-4 px-6">
                                <span class="text-teal-800 font-bold block">{{ $prod->seller->shop_name ?? $prod->seller->name ?? 'Direct' }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $prod->seller->email ?? '' }}</span>
                            </td>

                            <td class="py-4 px-6 text-right">
                                <span class="text-slate-400 line-through font-mono text-[11px] block">৳{{ number_format($prod->single_price) }}</span>
                                <span class="text-base font-black text-[#53a318] font-mono block">৳{{ number_format($prod->group_price) }}</span>
                            </td>

                            <td class="py-4 px-6 text-center font-bold text-slate-700">
                                <span class="bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full font-mono text-[11px]">
                                    {{ $prod->group_size_required }} Buyers / {{ $prod->group_duration_hours }}h
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center font-bold">
                                <span class="px-2 py-0.5 rounded-full text-[11px] {{ $prod->stock <= 5 ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-800' }}">
                                    {{ $prod->stock }} pcs
                                </span>
                            </td>

                            <!-- Campaign Tags (Hot Deal, Flash Sale, Featured) -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <form action="{{ route('admin.products.toggle-feature', $prod) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="feature" value="hot_deal">
                                        <button type="submit" class="px-1.5 py-0.5 rounded text-[10px] font-bold cursor-pointer transition-colors {{ $prod->is_hot_deal ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-slate-100 text-slate-400 hover:text-amber-600' }}" title="Toggle Hot Deal Tag">
                                            🔥 Hot
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.toggle-feature', $prod) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="feature" value="flash_sale">
                                        <button type="submit" class="px-1.5 py-0.5 rounded text-[10px] font-bold cursor-pointer transition-colors {{ $prod->is_flash_sale ? 'bg-rose-100 text-rose-900 border border-rose-300' : 'bg-slate-100 text-slate-400 hover:text-rose-600' }}" title="Toggle Flash Sale Tag">
                                            ⚡ Flash
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <!-- Visibility Status -->
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.products.toggle-status', $prod) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider cursor-pointer transition-all {{ $prod->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                                        {{ $prod->is_active ? 'Active' : 'Hidden' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('products.show', $prod->slug) }}" target="_blank" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-purple-100 text-slate-700 hover:text-purple-800 font-bold text-[11px] transition-colors">
                                        View
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $prod) }}" method="POST" onsubmit="return confirm('Remove product {{ $prod->title }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition-colors cursor-pointer">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">No products matched the search.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
