<div class="mb-8">
    <!-- Top Merchant Status Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-teal-950 rounded-3xl p-5 sm:p-6 text-white shadow-xl mb-6 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 top-0 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 p-1 flex-shrink-0 shadow-inner flex items-center justify-center">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->shop_name ?? auth()->user()->name }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        <div class="w-full h-full rounded-xl bg-gradient-to-tr from-teal-500 to-emerald-400 text-white flex items-center justify-center font-black text-xl shadow-xs">
                            {{ strtoupper(substr(auth()->user()->shop_name ?? auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div>
                    <div class="flex items-center space-x-2">
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                            {{ auth()->user()->shop_name ?? auth()->user()->name }}
                        </h2>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-teal-400/20 text-teal-300 border border-teal-400/30">
                            <svg class="w-3 h-3 mr-1 text-teal-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Verified Seller
                        </span>
                    </div>
                    <p class="text-xs text-slate-300 mt-0.5 flex items-center space-x-2">
                        <span>{{ auth()->user()->business_category ?? 'General Merchandise' }}</span>
                        <span>•</span>
                        <span class="text-emerald-400 font-semibold">{{ auth()->user()->products()->count() }} Live Products</span>
                        <span>•</span>
                        <a href="{{ route('shop.show', auth()->user()) }}" target="_blank" class="text-teal-300 hover:text-white underline font-semibold transition-colors flex items-center space-x-1">
                            <span>Live Storefront</span>
                            <span class="text-[10px]">↗</span>
                        </a>
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-2.5 flex-wrap sm:flex-nowrap">
                <a href="{{ route('shop.show', auth()->user()) }}" target="_blank"
                   class="px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white font-bold text-xs transition-colors flex items-center space-x-1.5 cursor-pointer shadow-2xs"
                   title="View your store as seen by buyers">
                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span>View Public Store</span>
                </a>

                <a href="{{ route('seller.products.create') }}" 
                   class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white font-extrabold text-xs shadow-lg shadow-teal-500/25 transition-all flex items-center space-x-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add Product</span>
                </a>

                <a href="{{ route('seller.profile') }}" 
                   class="px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white font-bold text-xs transition-colors flex items-center space-x-1">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Strip -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-1.5 shadow-xs flex items-center space-x-1 overflow-x-auto text-xs font-bold scrollbar-none">
        
        <!-- 1. Dashboard -->
        <a href="{{ route('seller.dashboard') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.dashboard') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span>Dashboard</span>
        </a>

        <!-- 2. Products -->
        <a href="{{ route('seller.products') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.products*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <span>Products & Stock</span>
        </a>

        <!-- 3. Group Buy Campaigns -->
        <a href="{{ route('seller.groups') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.groups*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span>Group-Buy Sessions</span>
        </a>

        <!-- 4. Orders & Fulfillment -->
        <a href="{{ route('seller.orders') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.orders*') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <span>Customer Orders</span>
        </a>

        <!-- 5. Analytics -->
        <a href="{{ route('seller.analytics') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.analytics') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span>Analytics & Reports</span>
        </a>

        <!-- 6. Profile Settings -->
        <a href="{{ route('seller.profile') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.profile') ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Store Profile</span>
        </a>

    </div>
</div>
