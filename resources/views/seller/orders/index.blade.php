@extends('layouts.seller')

@section('title', 'Manage Customer Orders - Cartiva Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ quickStatusModal: false, selectedOrder: null, newStatus: '', courier: '', tracking: '' }">

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

    <!-- Header & Status Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Customer Orders & Fulfillment</h1>
            <p class="text-xs text-slate-500 mt-0.5">Manage customer deliveries, update parcel status, and attach courier tracking info.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center space-x-1.5 p-1 bg-white rounded-2xl border border-slate-200 shadow-xs text-xs font-bold overflow-x-auto">
            <a href="{{ route('seller.orders') }}" 
               class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ !request('status') || request('status') === 'all' ? 'text-white font-black shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}"
               @if(!request('status') || request('status') === 'all') style="background-color: #53a318; box-shadow: 0 2px 8px rgba(83, 163, 24, 0.35);" @endif>
                All ({{ $counts['all'] }})
            </a>
            <a href="{{ route('seller.orders') }}?status=pending_group" 
               class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'pending_group' ? 'bg-amber-600 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                Pending Group ({{ $counts['pending_group'] }})
            </a>
            <a href="{{ route('seller.orders') }}?status=processing" 
               class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'processing' ? 'bg-blue-600 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                To Dispatch ({{ $counts['processing'] }})
            </a>
            <a href="{{ route('seller.orders') }}?status=shipped" 
               class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'shipped' ? 'bg-indigo-600 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                In Transit ({{ $counts['shipped'] }})
            </a>
            <a href="{{ route('seller.orders') }}?status=delivered" 
               class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'delivered' ? 'bg-emerald-600 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                Delivered ({{ $counts['delivered'] }})
            </a>
            <a href="{{ route('seller.orders') }}?status=cancelled" 
               class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap {{ request('status') === 'cancelled' ? 'bg-rose-600 text-white shadow-xs font-black' : 'text-slate-600 hover:bg-slate-100' }}">
                Cancelled ({{ $counts['cancelled'] }})
            </a>
        </div>
    </div>

    <!-- Search & Type Filter Bar -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs mb-6">
        <form action="{{ route('seller.orders') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- Search Input -->
            <div class="relative flex-1 max-w-md">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by order number (ORD-...), customer name, or phone..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500 transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex items-center space-x-2">
                <select name="type" onchange="this.form.submit()" class="py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    <option value="">All Order Types</option>
                    <option value="group_buy" {{ request('type') === 'group_buy' ? 'selected' : '' }}>Team Buy Only</option>
                    <option value="single" {{ request('type') === 'single' ? 'selected' : '' }}>Solo Buy Only</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition-colors">
                    Filter
                </button>

                @if(request()->hasAny(['q', 'type', 'status']))
                    <a href="{{ route('seller.orders') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-3.5 min-w-[190px] max-w-[240px]">Product Ordered</th>
                        <th class="py-3 px-3.5 whitespace-nowrap">Order ID & Date</th>
                        <th class="py-3 px-3.5 whitespace-nowrap">Customer</th>
                        <th class="py-3 px-3.5 max-w-[140px]">Delivery Address</th>
                        <th class="py-3 px-3.5 whitespace-nowrap">Subtotal</th>
                        <th class="py-3 px-3.5 whitespace-nowrap">Type</th>
                        <th class="py-3 px-3.5 whitespace-nowrap">Status</th>
                        <th class="py-3 px-3.5 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orderItems as $item)
                        @php
                            $order = $item->order;
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            
                            <!-- Product -->
                            <td class="py-3 px-3.5 min-w-[190px] max-w-[240px]">
                                <div class="flex items-center space-x-2.5">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->title }}" class="w-10 h-10 rounded-xl object-contain bg-slate-50 border border-slate-200 p-0.5 flex-shrink-0">
                                    <div class="min-w-0 flex-1">
                                        <span class="font-extrabold text-slate-900 block text-xs leading-snug line-clamp-2" title="{{ $item->product->title }}">
                                            {{ $item->product->title }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-semibold mt-0.5 block">Qty: {{ $item->quantity }} × ৳{{ number_format($item->unit_price) }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Order ID & Date -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                <a href="{{ route('seller.orders.show', $order) }}" class="font-mono font-bold text-teal-600 hover:text-teal-800 hover:underline block text-xs">
                                    {{ $order->order_number }}
                                </a>
                                <span class="text-[10px] text-slate-400 font-medium block">{{ $order->created_at->format('M d, Y H:i') }}</span>
                            </td>

                            <!-- Customer -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                <span class="font-bold text-slate-800 block text-xs truncate max-w-[120px]" title="{{ $order->shipping_name }}">{{ $order->shipping_name }}</span>
                                <span class="text-[10px] text-slate-500 font-mono block">{{ $order->shipping_phone }}</span>
                            </td>

                            <!-- Delivery Address -->
                            <td class="py-3 px-3.5 max-w-[140px]">
                                <span class="text-slate-600 truncate block text-[11px]" title="{{ $order->shipping_address }}">
                                    {{ $order->shipping_address }}
                                </span>
                            </td>

                            <!-- Subtotal -->
                            <td class="py-3 px-3.5 font-black text-emerald-600 whitespace-nowrap text-xs">
                                ৳{{ number_format($item->subtotal) }}
                            </td>

                            <!-- Order Type -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold whitespace-nowrap {{ $order->order_type === 'group_buy' ? 'bg-teal-50 text-teal-800 border border-teal-200/90 shadow-2xs' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                    @if($order->order_type === 'group_buy')
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 mr-1 flex-shrink-0"></span>
                                        <span>Team Buy</span>
                                    @else
                                        <span>Solo</span>
                                    @endif
                                </span>
                            </td>

                            <!-- Status & Tracking -->
                            <td class="py-3 px-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold whitespace-nowrap
                                    {{ $order->order_status === 'pending_group' ? 'bg-amber-50 text-amber-800 border border-amber-200 shadow-2xs' : 
                                      ($order->order_status === 'processing' ? 'bg-blue-50 text-blue-800 border border-blue-200 shadow-2xs' : 
                                      ($order->order_status === 'shipped' ? 'bg-indigo-50 text-indigo-800 border border-indigo-200 shadow-2xs' : 
                                      ($order->order_status === 'delivered' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-2xs' : 
                                      ($order->order_status === 'cancelled' ? 'bg-rose-50 text-rose-800 border border-rose-200 shadow-2xs' : 'bg-slate-100 text-slate-700 border border-slate-200')))) }}">
                                    @if($order->order_status === 'pending_group')
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1 flex-shrink-0 animate-pulse"></span>
                                        <span>Pending Group</span>
                                    @elseif($order->order_status === 'processing')
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1 flex-shrink-0"></span>
                                        <span>Processing</span>
                                    @elseif($order->order_status === 'shipped')
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1 flex-shrink-0"></span>
                                        <span>Shipped</span>
                                    @elseif($order->order_status === 'delivered')
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 flex-shrink-0"></span>
                                        <span>Delivered</span>
                                    @elseif($order->order_status === 'cancelled')
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1 flex-shrink-0"></span>
                                        <span>Cancelled</span>
                                    @else
                                        <span>{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                                    @endif
                                </span>

                                @if($order->courier_name || $order->tracking_number)
                                    <span class="text-[9px] text-slate-500 mt-1 block">
                                        🚚 {{ $order->courier_name ?? 'Courier' }}: <strong class="font-mono text-slate-700">{{ $order->tracking_number ?? 'N/A' }}</strong>
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center space-x-1.5">
                                    <button type="button" 
                                            @click="quickStatusModal = true; selectedOrder = {{ $order->toJson() }}; newStatus = '{{ $order->order_status }}'; courier = '{{ $order->courier_name ?? '' }}'; tracking = '{{ $order->tracking_number ?? '' }}';" 
                                            class="px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors cursor-pointer"
                                            title="Update fulfillment status">
                                        Update
                                    </button>

                                    <a href="{{ route('seller.orders.show', $order) }}" 
                                       class="px-3 py-1 rounded-xl bg-slate-900 hover:bg-[#53a318] text-white font-black text-xs transition-colors shadow-2xs"
                                       title="View full invoice & order details">
                                        View
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <span class="text-3xl block mb-2">📋</span>
                                No orders matching the current filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $orderItems->links() }}
        </div>
    </div>

    <!-- Quick Status Update Modal -->
    <div x-show="quickStatusModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div @click.outside="quickStatusModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100">
            <div class="flex items-center justify-between mb-3 border-b border-slate-100 pb-3">
                <h4 class="text-base font-extrabold text-slate-900">Update Order Status</h4>
                <button type="button" @click="quickStatusModal = false" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>

            <p class="text-xs text-slate-500 mb-4">
                Order Number: <strong class="text-slate-800 font-mono" x-text="selectedOrder ? selectedOrder.order_number : ''"></strong>
            </p>

            <form :action="'{{ url('/seller/orders') }}/' + (selectedOrder ? selectedOrder.id : '') + '/status'" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Parcel / Order Status</label>
                    <select name="order_status" x-model="newStatus" required 
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                        <option value="processing">Processing (Packaging Order)</option>
                        <option value="shipped">Shipped (Handed over to Courier)</option>
                        <option value="delivered">Delivered (Completed)</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Courier Service Name (Optional)</label>
                    <input type="text" name="courier_name" x-model="courier" placeholder="e.g. Steadfast Courier, Pathao, RedX, DHL" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Consignment / Tracking Number (Optional)</label>
                    <input type="text" name="tracking_number" x-model="tracking" placeholder="e.g. ST-99882244" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="quickStatusModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-teal-600 text-white font-bold text-xs hover:bg-teal-700 transition-colors shadow-xs">
                        Update Fulfillment
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
