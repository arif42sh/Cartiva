@extends('layouts.app')

@section('title', 'My Products - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('seller.dashboard') }}" class="hover:text-teal-600">Merchant Hub</a>
                <span>/</span>
                <span class="text-slate-800">Products</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Product Inventory & Team Pricing</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('seller.products.create') }}" class="px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md transition-all flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add New Product</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-6">Product</th>
                        <th class="py-3 px-6">Category</th>
                        <th class="py-3 px-6">Solo Price</th>
                        <th class="py-3 px-6">Team Price</th>
                        <th class="py-3 px-6">Team Size</th>
                        <th class="py-3 px-6">Duration</th>
                        <th class="py-3 px-6">Stock</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 flex items-center space-x-3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-10 h-10 rounded-lg object-cover bg-slate-100">
                                <div>
                                    <span class="font-bold text-slate-900 block line-clamp-1">{{ $product->title }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $product->sales_count }} sales</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $product->category->name ?? 'None' }}</td>
                            <td class="py-4 px-6 text-slate-500">${{ number_format($product->single_price, 2) }}</td>
                            <td class="py-4 px-6 font-bold text-emerald-600">
                                ${{ number_format($product->group_price, 2) }}
                                <span class="text-[10px] bg-emerald-100 text-emerald-800 px-1 py-0.5 rounded font-black ml-1">-{{ $product->discount_percent }}%</span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700">{{ $product->group_size_required }} Buyers</td>
                            <td class="py-4 px-6 text-slate-600">{{ $product->group_duration_hours }}h</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $product->stock > 10 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $product->stock }} in stock
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('products.show', $product) }}" target="_blank" class="text-teal-600 hover:text-teal-800 font-bold">
                                    View Live &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400 font-medium">No products created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection
