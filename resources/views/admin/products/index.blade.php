@extends('layouts.app')

@section('title', 'Platform Catalog - Cartiva Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600">Admin Dashboard</a>
            <span>/</span>
            <span class="text-slate-800">Catalog</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Marketplace Catalog</h1>
        <p class="text-xs text-slate-500 mt-1">Review all seller items, discounts, and group buying parameters.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-6">Product</th>
                        <th class="py-3 px-6">Category</th>
                        <th class="py-3 px-6">Merchant</th>
                        <th class="py-3 px-6">Solo Price</th>
                        <th class="py-3 px-6">Team Price</th>
                        <th class="py-3 px-6">Group Rules</th>
                        <th class="py-3 px-6">Stock</th>
                        <th class="py-3 px-6">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $prod)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 flex items-center space-x-3">
                                <img src="{{ $prod->image_url }}" alt="{{ $prod->title }}" class="w-10 h-10 rounded-lg object-cover bg-slate-100">
                                <span class="font-bold text-slate-900 line-clamp-1 max-w-xs">{{ $prod->title }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $prod->category->name ?? 'None' }}</td>
                            <td class="py-4 px-6 text-teal-700 font-semibold">{{ $prod->seller->name ?? 'Unknown' }}</td>
                            <td class="py-4 px-6 text-slate-500">${{ number_format($prod->single_price, 2) }}</td>
                            <td class="py-4 px-6 font-bold text-emerald-600">
                                ${{ number_format($prod->group_price, 2) }}
                                <span class="text-[10px] bg-emerald-100 text-emerald-800 px-1 py-0.5 rounded ml-1">-{{ $prod->discount_percent }}%</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $prod->group_size_required }} Buyers • {{ $prod->group_duration_hours }}h</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $prod->stock > 10 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $prod->stock }} units
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('products.show', $prod) }}" target="_blank" class="text-purple-600 hover:text-purple-800 font-bold">
                                    View &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400 font-medium">No products in catalog.</td>
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
