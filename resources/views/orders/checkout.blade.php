@extends('layouts.app')

@section('title', 'Secure Checkout — Cartiva')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Checkout & Order Confirmation</h1>
        <p class="text-xs text-slate-500 mt-1">
            @if($orderType === 'group_buy')
                 You are securing a slot in a <strong>Group Buy Deal</strong>. Your team wholesale discount is applied!
            @else
                Standard Solo Direct Purchase. Immediate dispatch.
            @endif
        </p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="order_type" value="{{ $orderType }}">
        <input type="hidden" name="action" value="{{ $action }}">
        <input type="hidden" name="quantity" value="{{ $quantity }}">
        @if($session)
            <input type="hidden" name="session_id" value="{{ $session->id }}">
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left: Shipping & Payment Form -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Shipping Address Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                        <span>📍 Delivery Information</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Full Name</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', $user->name ?? '') }}" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            @error('shipping_name') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Contact Phone</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', $user->phone ?? '') }}" required placeholder="+880 1..."
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            @error('shipping_phone') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Shipping Street Address</label>
                        <textarea name="shipping_address" rows="3" required placeholder="House, Road, Area, City..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('shipping_address', $user->address ?? '') }}</textarea>
                        @error('shipping_address') <span class="text-[11px] text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Order Notes (Optional)</label>
                        <input type="text" name="order_notes" placeholder="Any special delivery instructions..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>

                <!-- Digital Payment Method Card (No COD) -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                            <span>💳 Digital Payment Method</span>
                        </h2>
                        <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                            Pre-paid Secure
                        </span>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50/30 cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="bKash Online Payment" checked class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">bKash Mobile Wallet</span>
                                    <span class="text-[11px] text-slate-500">Direct online payment via bKash gateway</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-pink-600 bg-pink-50 px-2 py-0.5 rounded border border-pink-200">bKash</span>
                        </label>

                        <label class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="Nagad Mobile Payment" class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">Nagad Mobile Payment</span>
                                    <span class="text-[11px] text-slate-500">Fast digital transfer via Nagad wallet</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded border border-orange-200">Nagad</span>
                        </label>

                        <label class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="Card Payment (Visa/Mastercard)" class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">Debit / Credit Card</span>
                                    <span class="text-[11px] text-slate-500">Visa, Mastercard, Amex supported</span>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-slate-400">Card</span>
                        </label>
                    </div>

                    <p class="text-[11px] text-slate-400 leading-relaxed pt-1">
                        * Note: Pre-paid orders are protected by Cartiva Buyer Guarantee. In group buys, if your team fails to complete before time runs out, an automatic 100% refund is initiated back to your account immediately.
                    </p>
                </div>

            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-6">
                    <h2 class="text-base font-bold text-slate-900">Order Summary</h2>

                    <!-- Product Item -->
                    <div class="flex space-x-4 pb-6 border-b border-slate-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-20 h-20 rounded-xl object-cover bg-slate-100 flex-shrink-0">
                        <div class="flex-1 min-w-0 space-y-1">
                            <h3 class="text-xs font-bold text-slate-900 line-clamp-2 leading-snug">{{ $product->title }}</h3>
                            <div class="flex items-center space-x-2 text-[11px]">
                                <span class="text-slate-700 font-bold bg-slate-100 px-2 py-0.5 rounded">Qty: {{ $quantity }}</span>
                                <span class="text-slate-400">@ ৳{{ number_format($unitPrice) }}</span>
                            </div>
                            <div class="mt-1">
                                @if($orderType === 'group_buy')
                                    <span class="text-xs font-extrabold text-[#53a318]">৳{{ number_format($unitPrice) }} / unit</span>
                                    <span class="text-[11px] text-slate-400 line-through ml-1">৳{{ number_format($product->single_price) }}</span>
                                @else
                                    <span class="text-xs font-bold text-slate-800">৳{{ number_format($unitPrice) }} / unit</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Price Calculations -->
                    <div class="space-y-2.5 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Subtotal ({{ $quantity }} {{ $quantity > 1 ? 'items' : 'item' }})</span>
                            <span class="font-bold text-slate-900">৳{{ number_format($subtotal) }}</span>
                        </div>

                        @if($orderType === 'group_buy')
                            <div class="flex justify-between text-emerald-600 font-bold">
                                <span>Savings</span>
                                <span>-৳{{ number_format(($product->single_price - $unitPrice) * $quantity) }}</span>
                            </div>
                        @elseif($orderType === 'single' && $quantity >= 2)
                            <div class="flex justify-between text-emerald-600 font-bold">
                                <span>Bulk Discount</span>
                                <span>-৳{{ number_format(($product->single_price - $unitPrice) * $quantity) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Nationwide Delivery</span>
                            <span class="text-emerald-600 font-bold">FREE PROMO</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="text-sm font-black text-slate-900">Total Payable</span>
                            <span class="text-2xl font-black text-[#53a318]">৳{{ number_format($total) }}</span>
                        </div>
                    </div>

                    <!-- Safety Guarantee -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-500 flex items-start space-x-2">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>If group buy timer expires without completing required members, your payment is 100% refunded automatically.</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-4 px-6 rounded-xl font-black text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-lg shadow-emerald-700/20 transition-all flex items-center justify-center space-x-2 cursor-pointer active:scale-[0.99]">
                        <span>Pay ৳{{ number_format($total) }} & Place Order</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>

                    <!-- Cancel / Return Link -->
                    <div class="pt-2 text-center">
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="inline-flex items-center space-x-1.5 text-xs font-bold text-slate-500 hover:text-rose-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Cancel & Return</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection
