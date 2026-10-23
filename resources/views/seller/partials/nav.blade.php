<div class="mb-8">
    <!-- Top Merchant Status Bar (Executive Obsidian Slate with Brand Green Accents) -->
    <div class="rounded-3xl p-6 sm:p-7 text-white shadow-2xl mb-6 relative overflow-hidden border border-slate-700/60"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #0d2818 100%);">
        
        <!-- Ambient Glow Accents -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full blur-3xl pointer-events-none" style="background: radial-gradient(circle, rgba(83,163,24,0.18) 0%, transparent 70%);"></div>
        <div class="absolute right-48 top-0 w-48 h-48 rounded-full blur-2xl pointer-events-none" style="background: radial-gradient(circle, rgba(16,185,129,0.12) 0%, transparent 70%);"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <!-- Left: Store Avatar & Meta -->
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-2xl p-0.5 flex-shrink-0 shadow-lg flex items-center justify-center border-2 border-[#53a318]/60 bg-slate-800">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->shop_name ?? auth()->user()->name }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        <div class="w-full h-full rounded-xl text-white flex items-center justify-center font-black text-2xl shadow-inner"
                             style="background: linear-gradient(135deg, #53a318 0%, #10b981 100%);">
                            {{ strtoupper(substr(auth()->user()->shop_name ?? auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div>
                    <div class="flex items-center space-x-2.5 flex-wrap">
                        <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight drop-shadow-xs">
                            {{ auth()->user()->shop_name ?? auth()->user()->name }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-black text-white shadow-xs"
                              style="background-color: #53a318; border: 1px solid rgba(255,255,255,0.2);">
                            <svg class="w-3.5 h-3.5 mr-1 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Verified Seller
                        </span>
                    </div>
                    <p class="text-xs text-slate-300 mt-1 flex items-center space-x-2.5 flex-wrap">
                        <span class="font-medium text-slate-200">{{ auth()->user()->business_category ?? 'General Merchandise' }}</span>
                        <span class="text-slate-500">•</span>
                        <span class="font-bold text-[#84cc16]">{{ auth()->user()->products()->count() }} Live Products</span>
                        <span class="text-slate-500">•</span>
                        <span class="text-emerald-400 font-semibold flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block animate-pulse"></span>
                            <span>Store Active</span>
                        </span>
                    </p>
                </div>
            </div>

            <!-- Right: Quick Executive Action Buttons with High Contrast -->
            <div class="flex items-center space-x-2.5 flex-wrap sm:flex-nowrap">
                <!-- Add Product (Primary CTA in Brand Green) -->
                <a href="{{ route('seller.products.create') }}" 
                   class="px-4.5 py-2.5 rounded-xl text-white font-black text-xs transition-all flex items-center space-x-1.5 cursor-pointer shadow-lg hover:brightness-110 active:scale-95"
                   style="background: linear-gradient(135deg, #53a318 0%, #468c13 100%); box-shadow: 0 4px 14px rgba(83, 163, 24, 0.45); border: 1px solid rgba(255,255,255,0.2);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add Product</span>
                </a>

                <!-- Store Settings -->
                <a href="{{ route('seller.profile') }}" 
                   class="px-3.5 py-2.5 rounded-xl text-slate-200 font-bold text-xs transition-all flex items-center space-x-1.5 cursor-pointer shadow-md hover:bg-slate-700/80 hover:text-white"
                   style="background-color: rgba(30, 41, 59, 0.85); border: 1px solid rgba(255, 255, 255, 0.18);">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Strip (Crisp High-Contrast Floating Bar) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-1.5 shadow-sm flex items-center space-x-1.5 overflow-x-auto text-xs font-bold scrollbar-none">
        
        <!-- 1. Dashboard -->
        <a href="{{ route('seller.dashboard') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.dashboard') ? 'text-white font-black shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if(request()->routeIs('seller.dashboard')) style="background-color: #53a318; box-shadow: 0 3px 10px rgba(83, 163, 24, 0.35);" @endif>
            <svg class="w-4 h-4 {{ request()->routeIs('seller.dashboard') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span>Dashboard</span>
        </a>

        <!-- 2. Products -->
        <a href="{{ route('seller.products') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.products*') ? 'text-white font-black shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if(request()->routeIs('seller.products*')) style="background-color: #53a318; box-shadow: 0 3px 10px rgba(83, 163, 24, 0.35);" @endif>
            <svg class="w-4 h-4 {{ request()->routeIs('seller.products*') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <span>Products & Stock</span>
        </a>

        <!-- 3. Group Buy Campaigns -->
        <a href="{{ route('seller.groups') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.groups*') ? 'text-white font-black shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if(request()->routeIs('seller.groups*')) style="background-color: #53a318; box-shadow: 0 3px 10px rgba(83, 163, 24, 0.35);" @endif>
            <svg class="w-4 h-4 {{ request()->routeIs('seller.groups*') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span>Group-Buy Sessions</span>
        </a>

        <!-- 4. Orders & Fulfillment -->
        <a href="{{ route('seller.orders') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.orders*') ? 'text-white font-black shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if(request()->routeIs('seller.orders*')) style="background-color: #53a318; box-shadow: 0 3px 10px rgba(83, 163, 24, 0.35);" @endif>
            <svg class="w-4 h-4 {{ request()->routeIs('seller.orders*') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <span>Customer Orders</span>
        </a>

        <!-- 5. Analytics -->
        <a href="{{ route('seller.analytics') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.analytics') ? 'text-white font-black shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if(request()->routeIs('seller.analytics')) style="background-color: #53a318; box-shadow: 0 3px 10px rgba(83, 163, 24, 0.35);" @endif>
            <svg class="w-4 h-4 {{ request()->routeIs('seller.analytics') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span>Analytics & Reports</span>
        </a>

        <!-- 6. Profile Settings -->
        <a href="{{ route('seller.profile') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.profile') ? 'text-white font-black shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if(request()->routeIs('seller.profile')) style="background-color: #53a318; box-shadow: 0 3px 10px rgba(83, 163, 24, 0.35);" @endif>
            <svg class="w-4 h-4 {{ request()->routeIs('seller.profile') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Store Profile</span>
        </a>

        <!-- 7. Storefront Preview (Integrated Method A) -->
        <a href="{{ route('seller.storefront') }}" 
           class="px-4 py-2.5 rounded-xl transition-all whitespace-nowrap flex items-center space-x-2 {{ request()->routeIs('seller.storefront') ? 'text-white font-black shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if(request()->routeIs('seller.storefront')) style="background-color: #53a318; box-shadow: 0 3px 10px rgba(83, 163, 24, 0.35);" @endif>
            <svg class="w-4 h-4 {{ request()->routeIs('seller.storefront') ? 'text-white' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            <span>Storefront Preview</span>
        </a>

    </div>
</div>
