@extends('layouts.app')

@section('title', 'Secure Checkout - Cartiva')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Checkout & Order Confirmation</h1>
        <p class="text-xs text-slate-500 mt-1">
            @if($orderType === 'group_buy')
                ⚡ You are taking part in a <strong>Group Buy Deal</strong>. Your team discount is applied!
            @else
                📦 Standard Solo Direct Purchase.
            @endif
        </p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="order_type" value="{{ $orderType }}">
        <input type="hidden" name="action" value="{{ $action }}">
        @if($session)
            <input type="hidden" name="session_id" value="{{ $session->id }}">
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
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
                        <input type="text" name="order_notes" placeholder="Special delivery instructions..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                        <span>💳 Select Payment Method</span>
                    </h2>

                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50/30 cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="Cash on Delivery" checked class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">Cash on Delivery (COD)</span>
                                    <span class="text-[11px] text-slate-500">Pay when your package arrives at your door</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-emerald-700">Recommended</span>
                        </label>

                        <label class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="payment_method" value="bKash / Nagad Instant" class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">bKash / Nagad Mobile Wallet</span>
                                    <span class="text-[11px] text-slate-500">Instant digital checkout</span>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-slate-400">Zero Fee</span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-6">
                    <h2 class="text-base font-bold text-slate-900">Order Summary</h2>

                    <!-- Product Item -->
                    <div class="flex space-x-4 pb-6 border-b border-slate-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-20 h-20 rounded-xl object-cover bg-slate-100 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xs font-bold text-slate-900 line-clamp-2">{{ $product->title }}</h3>
                            <span class="text-[11px] text-slate-500 mt-1 block">Qty: 1</span>
                            <div class="mt-1">
                                @if($orderType === 'group_buy')
                                    <span class="text-xs font-extrabold text-emerald-600">${{ number_format($product->group_price, 2) }}</span>
                                    <span class="text-[11px] text-slate-400 line-through ml-1">${{ number_format($product->single_price, 2) }}</span>
                                @else
                                    <span class="text-xs font-bold text-slate-800">${{ number_format($product->single_price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Price Calculations -->
                    <div class="space-y-2.5 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-900">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($orderType === 'group_buy')
                            <div class="flex justify-between text-emerald-600 font-bold">
                                <span>Team Buy Savings</span>
                                <span>-${{ number_format($product->savings, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Express Shipping</span>
                            <span class="text-emerald-600 font-bold">FREE</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="text-sm font-black text-slate-900">Total Due</span>
                            <span class="text-2xl font-black text-emerald-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Safety Guarantee -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-500 flex items-start space-x-2">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>If group buy timer expires without completing the slots, your payment is 100% refunded automatically.</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 px-6 rounded-xl font-black text-sm bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center space-x-2">
                        <span>Confirm & Place Order</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection
