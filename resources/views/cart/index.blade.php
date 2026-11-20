@extends('layouts.app')

@section('title', 'My Cart - Cartiva')

@section('content')
<div class="bg-[#f8f9fa] min-h-screen py-6 sm:py-8"
     x-data="{
        cartItems: window.CartivaCart ? window.CartivaCart.getCart() : JSON.parse(localStorage.getItem('cartiva_cart') || '[]'),
        voucherCode: '',
        voucherDiscount: 0,
        appliedVoucher: null,
        voucherError: '',
        voucherSuccess: '',
        discountOpen: true,
        clubPointsOpen: false,
        usePoints: false,
        userPoints: 2750,
        pointsDiscount: 0,
        shippingFee: 0,
        
        init() {
            // Auto seed with sample products if cart is completely empty on first visit
            if (this.cartItems.length === 0 && !localStorage.getItem('cartiva_cart_visited')) {
                localStorage.setItem('cartiva_cart_visited', 'true');
                @if(isset($sampleProducts) && $sampleProducts->count() > 0)
                    @foreach($sampleProducts as $p)
                        window.CartivaCart.addItem({
                            id: {{ $p->id }},
                            title: '{{ addslashes($p->title) }}',
                            price: {{ $p->group_price }},
                            original_price: {{ $p->single_price }},
                            image: '{{ $p->image_url }}',
                            slug: '{{ $p->slug }}',
                            seller: '{{ addslashes($p->seller->store_name ?? $p->seller->name ?? "Cartiva Official Store") }}'
                        }, 1);
                    @endforeach
                    this.cartItems = window.CartivaCart.getCart();
                @endif
            }

            window.addEventListener('storage', (e) => {
                if (e.key === 'cartiva_cart') {
                    this.cartItems = window.CartivaCart.getCart();
                }
            });
            window.addEventListener('cart-updated', (e) => {
                this.cartItems = e.detail || window.CartivaCart.getCart();
            });
        },

        get totalItemsCount() {
            return this.cartItems.reduce((acc, i) => acc + (parseInt(i.quantity) || 1), 0);
        },
        get subtotal() {
            return this.cartItems.reduce((acc, i) => acc + ((parseFloat(i.price) || 0) * (parseInt(i.quantity) || 1)), 0);
        },
        get estimatedOriginalTotal() {
            return this.cartItems.reduce((acc, i) => {
                const orig = (i.original_price && parseFloat(i.original_price) > parseFloat(i.price)) 
                    ? parseFloat(i.original_price) 
                    : Math.round((parseFloat(i.price) || 0) * 1.15);
                return acc + (orig * (parseInt(i.quantity) || 1));
            }, 0);
        },
        get totalSavings() {
            return Math.max(0, this.estimatedOriginalTotal - this.subtotal) + this.voucherDiscount + this.pointsDiscount;
        },
        get grandTotal() {
            return Math.max(0, this.subtotal - this.voucherDiscount - this.pointsDiscount + this.shippingFee);
        },
        get rewardPointsEarned() {
            return Math.round(this.grandTotal * 0.018); // 1.8% cash point earn rate
        },

        updateQty(id, delta) {
            this.cartItems = window.CartivaCart.updateQuantity(id, delta);
        },
        setQty(id, val) {
            const parsed = parseInt(val);
            if (!isNaN(parsed) && parsed > 0) {
                this.cartItems = window.CartivaCart.setQuantity(id, parsed);
            }
        },
        removeItem(id) {
            this.cartItems = window.CartivaCart.removeItem(id);
            if (this.cartItems.length === 0) {
                this.appliedVoucher = null;
                this.voucherDiscount = 0;
            }
        },
        emptyCart() {
            if (confirm('Are you sure you want to empty your cart?')) {
                window.CartivaCart.clear();
                this.cartItems = [];
                this.appliedVoucher = null;
                this.voucherDiscount = 0;
            }
        },
        saveForLater(item) {
            if (typeof window.addToWishlist === 'function') {
                window.addToWishlist(item);
            }
            this.removeItem(item.id);
        },
        applyVoucher() {
            this.voucherError = '';
            this.voucherSuccess = '';
            const code = this.voucherCode.trim().toUpperCase();

            if (!code) {
                this.voucherError = 'Please enter a voucher code.';
                return;
            }

            const coupons = {
                'CARTIVA50': 50,
                'SAVE100': 100,
                'PICKABOO': 150,
                'GROUPBUY': 80
            };

            if (coupons[code]) {
                this.appliedVoucher = code;
                this.voucherDiscount = coupons[code];
                this.voucherSuccess = `Voucher '${code}' applied successfully! (৳${coupons[code]} Off)`;
                this.voucherCode = '';
            } else {
                this.voucherError = 'Invalid or expired voucher code.';
            }
        },
        removeVoucher() {
            this.appliedVoucher = null;
            this.voucherDiscount = 0;
            this.voucherSuccess = '';
            this.voucherError = '';
        },
        toggleClubPoints() {
            this.usePoints = !this.usePoints;
            if (this.usePoints) {
                // Redeem up to 100 Taka or 20% of subtotal
                this.pointsDiscount = Math.min(100, Math.round(this.subtotal * 0.1));
            } else {
                this.pointsDiscount = 0;
            }
        },
        seedSampleCart() {
            @if(isset($sampleProducts) && $sampleProducts->count() > 0)
                @foreach($sampleProducts as $p)
                    window.CartivaCart.addItem({
                        id: {{ $p->id }},
                        title: '{{ addslashes($p->title) }}',
                        price: {{ $p->group_price }},
                        original_price: {{ $p->single_price }},
                        image: '{{ $p->image_url }}',
                        slug: '{{ $p->slug }}',
                        seller: '{{ addslashes($p->seller->store_name ?? $p->seller->name ?? "Cartiva Official Store") }}'
                    }, 1);
                @endforeach
                this.cartItems = window.CartivaCart.getCart();
            @endif
        },
        proceedToCheckout() {
            if (this.cartItems.length === 0) {
                alert('Your cart is empty. Add products to proceed.');
                return;
            }
            const first = this.cartItems[0];
            window.location.href = '{{ route('checkout') }}?product_id=' + first.id + '&quantity=' + (first.quantity || 1) + '&type=single';
        }
     }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- 1. CART VIEW: WHEN ITEMS ARE PRESENT (Exact Pickaboo Layout) -->
        <div x-show="cartItems.length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                
                <!-- LEFT COLUMN: Cart Items List (8 cols) -->
                <div class="lg:col-span-8">
                    
                    <!-- White Container for Cart -->
                    <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden">
                        
                        <!-- Header: My Cart (X) & Empty Cart Action (Exact Pickaboo style) -->
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <h1 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                                My Cart (<span x-text="totalItemsCount"></span>)
                            </h1>

                            <button type="button" 
                                    @click="emptyCart()" 
                                    class="inline-flex items-center space-x-1.5 text-xs sm:text-sm font-semibold text-rose-600 hover:text-rose-700 transition-colors cursor-pointer group">
                                <svg class="w-4 h-4 text-rose-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Empty Cart</span>
                            </button>
                        </div>

                        <!-- Cart Items List (Divided rows) -->
                        <div class="divide-y divide-slate-100">
                            <template x-for="item in cartItems" :key="item.id">
                                <div class="p-5 flex flex-col sm:flex-row items-start justify-between gap-5 transition-colors hover:bg-slate-50/40">
                                    
                                    <!-- Left Section: Image + Title + Info + Price -->
                                    <div class="flex items-start space-x-4 min-w-0 flex-1">
                                        
                                        <!-- Image Container with Badges (Pickaboo style) -->
                                        <div class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-lg bg-white border border-slate-200 p-1 flex-shrink-0 flex items-center justify-center">
                                            
                                            <!-- Discount Badge on top-right -->
                                            <template x-if="item.original_price && item.original_price > item.price">
                                                <span class="absolute -top-2 -right-2 px-1.5 py-0.5 rounded text-[10px] font-bold bg-[#ff5722] text-white shadow-2xs">
                                                    -<span x-text="Math.round(((item.original_price - item.price) / item.original_price) * 100)"></span>%
                                                </span>
                                            </template>

                                            <!-- Thumbnail -->
                                            <template x-if="item.image">
                                                <img :src="item.image" :alt="item.title" class="w-full h-full object-contain">
                                            </template>
                                            <template x-if="!item.image">
                                                <div class="w-full h-full flex items-center justify-center text-slate-300 text-2xl font-bold bg-slate-50">
                                                    🛍️
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Details Block -->
                                        <div class="min-w-0 flex-1 space-y-1">
                                            <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-snug line-clamp-2 hover:text-[#53a318] transition-colors">
                                                <a :href="item.slug ? ('/product/' + item.slug) : '#'" x-text="item.title"></a>
                                            </h2>

                                            <!-- Sold By -->
                                            <p class="text-xs text-slate-500 font-medium">
                                                Sold by: <span class="text-slate-700 font-semibold" x-text="item.seller || 'Cartiva Official Store'"></span>
                                            </p>

                                            <!-- In Stock Indicator -->
                                            <p class="text-xs text-emerald-600 font-semibold flex items-center space-x-1">
                                                <span>In Stock</span>
                                            </p>

                                            <!-- Pricing block (Pickaboo style: Large bold current price, Strikethrough original price, Subtotal below) -->
                                            <div class="pt-2">
                                                <div class="flex items-baseline space-x-2">
                                                    <span class="text-base sm:text-lg font-black text-slate-900">
                                                        ৳ <span x-text="Number(item.price).toLocaleString()"></span>
                                                    </span>
                                                    <template x-if="item.original_price && item.original_price > item.price">
                                                        <span class="text-xs sm:text-sm text-slate-400 line-through">
                                                            ৳ <span x-text="Number(item.original_price).toLocaleString()"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                                <p class="text-xs sm:text-sm font-bold text-slate-800 mt-1">
                                                    Subtotal: ৳ <span x-text="Number((item.price || 0) * (item.quantity || 1)).toLocaleString()"></span>
                                                </p>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Right Section: Quantity Stepper, Save for later, Remove Button -->
                                    <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-start w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 flex-shrink-0">
                                        
                                        <!-- Quantity Stepper Block -->
                                        <div class="flex flex-col sm:items-end">
                                            <span class="text-[11px] font-medium text-slate-500 mb-1 hidden sm:block">Quantity:</span>
                                            
                                            <!-- Stepper Box (Exact Pickaboo Boxed Stepper) -->
                                            <div class="inline-flex items-center rounded-lg border border-slate-300 bg-white overflow-hidden shadow-2xs">
                                                <button type="button" 
                                                        @click="updateQty(item.id, -1)" 
                                                        class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-black text-xs sm:text-sm transition-colors cursor-pointer select-none">
                                                    &minus;
                                                </button>
                                                <input type="number" 
                                                       min="1" 
                                                       :value="item.quantity || 1" 
                                                       @change="setQty(item.id, $event.target.value)"
                                                       class="w-9 sm:w-10 h-7 sm:h-8 text-center text-xs sm:text-sm font-bold text-slate-900 border-x border-slate-200 focus:outline-none p-0 bg-transparent" />
                                                <button type="button" 
                                                        @click="updateQty(item.id, 1)" 
                                                        class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-black text-xs sm:text-sm transition-colors cursor-pointer select-none">
                                                    &#43;
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Secondary Actions -->
                                        <div class="flex items-center sm:flex-col sm:items-end gap-2 sm:gap-1 mt-0 sm:mt-2.5">
                                            <button type="button" 
                                                    @click="saveForLater(item)" 
                                                    class="text-xs text-slate-500 hover:text-slate-800 underline-offset-2 hover:underline cursor-pointer">
                                                Save for later
                                            </button>

                                            <!-- Outlined Blue Remove Button (Exact Pickaboo Style) -->
                                            <button type="button" 
                                                    @click="removeItem(item.id)" 
                                                    class="px-4 py-1.5 rounded-lg border border-sky-400 text-sky-600 hover:border-rose-400 hover:bg-rose-50 hover:text-rose-600 font-bold text-xs transition-colors cursor-pointer">
                                                Remove
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </template>
                        </div>

                    </div>

                    <!-- Return to Shopping Link -->
                    <div class="mt-4 flex items-center justify-between">
                        <a href="{{ route('home') }}" class="text-xs sm:text-sm font-bold text-slate-600 hover:text-[#53a318] inline-flex items-center space-x-1.5 transition-colors">
                            <span>&larr;</span>
                            <span>Continue Shopping</span>
                        </a>
                        <span class="text-xs text-slate-400 font-medium">Safe & Encrypted Checkout</span>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Order Summary (4 cols - Exact Pickaboo Sidebar) -->
                <div class="lg:col-span-4">
                    
                    <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs p-5 space-y-4 sticky top-24">
                        
                        <!-- Header -->
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 pb-2 border-b border-slate-100">
                            Order Summary
                        </h2>

                        <!-- Accordion 1: Apply Discount Code -->
                        <div class="border-b border-slate-100 pb-3">
                            <button type="button" 
                                    @click="discountOpen = !discountOpen" 
                                    class="w-full flex items-center justify-between py-1 text-xs font-bold text-slate-800 hover:text-[#53a318] cursor-pointer">
                                <span>Apply Discount Code</span>
                                <svg class="w-4 h-4 transform transition-transform" :class="discountOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="discountOpen" x-transition class="pt-2.5 space-y-2">
                                <div class="space-y-2" x-show="!appliedVoucher">
                                    <input type="text" 
                                           x-model="voucherCode" 
                                           @keydown.enter.prevent="applyVoucher()"
                                           placeholder="Enter Voucher Code" 
                                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-medium placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-400 focus:border-sky-400 uppercase">
                                    
                                    <!-- Light Blue Apply Button (Exact Pickaboo styling) -->
                                    <button type="button" 
                                            @click="applyVoucher()"
                                            class="w-full py-2 px-3 rounded-lg bg-[#7dd3fc] hover:bg-[#38bdf8] text-white font-bold text-xs sm:text-sm shadow-2xs transition-colors cursor-pointer">
                                        Apply
                                    </button>
                                </div>

                                <!-- Applied Voucher Chip -->
                                <div x-show="appliedVoucher" class="p-2.5 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs">
                                    <div>
                                        <span class="font-bold text-emerald-800" x-text="appliedVoucher"></span>
                                        <span class="text-emerald-600 block text-[11px]">-৳<span x-text="voucherDiscount"></span> discount applied</span>
                                    </div>
                                    <button type="button" @click="removeVoucher()" class="text-xs font-bold text-rose-600 hover:underline cursor-pointer">Remove</button>
                                </div>

                                <!-- Quick Codes -->
                                <div class="flex items-center gap-1.5 flex-wrap pt-1" x-show="!appliedVoucher">
                                    <span class="text-[10px] text-slate-400 font-semibold">Try:</span>
                                    <button type="button" @click="voucherCode = 'CARTIVA50'; applyVoucher()" class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 cursor-pointer">CARTIVA50</button>
                                    <button type="button" @click="voucherCode = 'PICKABOO'; applyVoucher()" class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-sky-50 text-sky-700 hover:bg-sky-100 cursor-pointer">PICKABOO</button>
                                </div>

                                <p x-show="voucherError" x-text="voucherError" class="text-xs text-rose-600 font-medium"></p>
                                <p x-show="voucherSuccess" x-text="voucherSuccess" class="text-xs text-emerald-600 font-medium"></p>
                            </div>
                        </div>

                        <!-- Accordion 2: Use Club Points (Pickaboo Feature) -->
                        <div class="border-b border-slate-100 pb-3">
                            <button type="button" 
                                    @click="clubPointsOpen = !clubPointsOpen" 
                                    class="w-full flex items-center justify-between py-1 text-xs font-bold text-slate-800 hover:text-[#53a318] cursor-pointer">
                                <span>Use Club Points</span>
                                <svg class="w-4 h-4 transform transition-transform" :class="clubPointsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="clubPointsOpen" x-transition class="pt-2 space-y-2 text-xs">
                                <p class="text-slate-600 text-[11px]">
                                    You have <strong class="text-amber-500 font-bold" x-text="userPoints"></strong> Club Points available.
                                </p>
                                <button type="button" 
                                        @click="toggleClubPoints()"
                                        :class="usePoints ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                                        class="w-full py-1.5 px-3 rounded-lg font-bold text-xs transition-colors cursor-pointer">
                                    <span x-text="usePoints ? '✓ Points Applied (-৳' + pointsDiscount + ')' : 'Redeem Points for Discount'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Cart Subtotal Section (Exact Pickaboo text & layout) -->
                        <div class="space-y-2 text-xs sm:text-sm">
                            <span class="text-xs font-bold text-slate-900 block">Cart Subtotal</span>

                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal (<span x-text="totalItemsCount"></span> <span x-text="totalItemsCount > 1 ? 'Items' : 'Item'"></span>)</span>
                                <span class="font-bold text-slate-900">৳ <span x-text="Number(subtotal).toLocaleString()"></span></span>
                            </div>

                            <div class="flex justify-between text-slate-600">
                                <span>Shipping</span>
                                <span class="font-bold text-slate-900">৳ <span x-text="shippingFee"></span></span>
                            </div>

                            <!-- Voucher / Points discounts if applied -->
                            <div class="flex justify-between text-emerald-600 font-semibold" x-show="voucherDiscount > 0">
                                <span>Voucher Discount</span>
                                <span>- ৳ <span x-text="voucherDiscount"></span></span>
                            </div>
                            <div class="flex justify-between text-amber-600 font-semibold" x-show="pointsDiscount > 0">
                                <span>Club Points Discount</span>
                                <span>- ৳ <span x-text="pointsDiscount"></span></span>
                            </div>
                        </div>

                        <!-- Total Line -->
                        <div class="border-t border-slate-200 pt-3 flex justify-between items-baseline">
                            <span class="text-base font-bold text-slate-900">Total</span>
                            <span class="text-xl sm:text-2xl font-black text-slate-900">
                                ৳ <span x-text="Number(grandTotal).toLocaleString()"></span>
                            </span>
                        </div>

                        <!-- Reward Note (Exact Pickaboo reward line) -->
                        <div class="text-[11px] text-slate-600 pt-1 border-t border-slate-100 leading-relaxed">
                            <p>
                                Checkout now and earn <strong class="text-sky-600 font-bold" x-text="rewardPointsEarned"></strong> Points for this order.
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                Applies only to registered customers, may vary when logged in.
                            </p>
                        </div>

                        <!-- Checkout Button -->
                        <button type="button" 
                                @click="proceedToCheckout()"
                                class="w-full py-3 px-4 rounded-xl font-bold text-sm text-white bg-[#53a318] hover:bg-[#468c13] shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center space-x-1.5 cursor-pointer active:scale-[0.99]">
                            <span>Proceed to Checkout</span>
                            <span>&rarr;</span>
                        </button>

                    </div>

                </div>

            </div>
        </div>

        <!-- 2. EMPTY CART VIEW (When cartItems is empty) -->
        <div x-show="cartItems.length === 0" class="max-w-xl mx-auto my-12 bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-8 sm:p-10 text-center">
            <div class="w-20 h-20 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-3xl">
                🛒
            </div>
            
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-1">Your Shopping Cart is Empty</h2>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto mb-6">
                You have no items in your shopping cart. Discover our best deals and start shopping now!
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white font-bold text-xs sm:text-sm transition-all shadow-xs inline-flex items-center justify-center space-x-1.5">
                    <span>Continue Shopping</span>
                </a>
                
                <button type="button" 
                        @click="seedSampleCart()" 
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-sky-400 text-sky-600 hover:bg-sky-50 font-bold text-xs sm:text-sm transition-colors inline-flex items-center justify-center space-x-1.5 cursor-pointer">
                    <span>⚡ Load Sample Items to Test</span>
                </button>
            </div>
        </div>

        <!-- 3. RECOMMENDED PRODUCTS SECTION -->
        @if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
            <div class="mt-12 pt-8 border-t border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Recommended For You</h3>
                    <a href="{{ route('categories.index') }}" class="text-xs font-bold text-[#53a318] hover:underline">
                        View All Deals &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($recommendedProducts as $product)
                        <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs hover:shadow transition-all p-3.5 flex flex-col justify-between group">
                            
                            <!-- Thumbnail -->
                            <div class="relative w-full aspect-square bg-slate-50 rounded-lg overflow-hidden mb-2.5 p-2 flex items-center justify-center">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform">
                                @else
                                    <span class="text-3xl text-slate-300">🛍️</span>
                                @endif
                                
                                @if($product->single_price > $product->group_price)
                                    <span class="absolute top-2 right-2 px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#ff5722] text-white">
                                        -{{ round((($product->single_price - $product->group_price) / max(1, $product->single_price)) * 100) }}%
                                    </span>
                                @endif
                            </div>

                            <!-- Title & Pricing -->
                            <div class="space-y-1 flex-1 flex flex-col justify-between">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold text-slate-900 line-clamp-2 hover:text-[#53a318] transition-colors leading-snug">
                                    {{ $product->title }}
                                </a>

                                <div class="pt-2">
                                    <div class="flex items-baseline space-x-1.5">
                                        <span class="text-sm font-black text-slate-900">৳{{ number_format($product->group_price) }}</span>
                                        <span class="text-[11px] text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                                    </div>
                                    <button type="button" 
                                            @click="window.addToCart({ id: {{ $product->id }}, title: '{{ addslashes($product->title) }}', price: {{ $product->group_price }}, original_price: {{ $product->single_price }}, image: '{{ $product->image_url }}', slug: '{{ $product->slug }}' })"
                                            class="mt-2 w-full py-1.5 px-3 rounded-lg bg-slate-100 hover:bg-[#53a318] hover:text-white text-slate-700 font-bold text-xs transition-colors flex items-center justify-center space-x-1 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
