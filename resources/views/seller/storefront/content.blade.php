<div class="space-y-6">

    <!-- 1. Storefront Header & Hero Banner -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        
        <!-- Top Banner (Custom uploaded or Classic Gradient) -->
        <div class="relative w-full h-44 sm:h-56 md:h-64 bg-gradient-to-r from-slate-950 via-slate-900 to-teal-950 overflow-hidden">
            @if($seller->banner_url)
                <img src="{{ $seller->banner_url }}" alt="Store Banner" class="w-full h-full object-cover">
            @else
                <!-- Classic Subtle Pattern -->
                <div class="absolute inset-0 bg-slate-900 opacity-90"></div>
                <div class="absolute inset-0 bg-[radial-gradient(#334155_1px,transparent_1px)] [background-size:20px_20px] opacity-40"></div>
            @endif

            

            <!-- Edit Branding Shortcut -->
            <a href="{{ route('seller.profile') }}" 
               class="absolute top-4 right-4 px-3 py-1.5 rounded-xl text-white font-extrabold text-[11px] shadow-md transition-all flex items-center space-x-1.5 hover:brightness-110"
               style="background-color: #53a318;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit Branding</span>
            </a>
        </div>

        <!-- Store Identity Bar -->
        <div class="px-5 pb-5 pt-0 sm:px-7 sm:pb-7 relative">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                
                <!-- Store Logo & Information -->
                <div class="flex flex-col sm:flex-row sm:items-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <!-- Logo (Only logo overlaps the banner) -->
                    <div class="-mt-10 sm:-mt-14 w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white p-1.5 shadow-xl border border-slate-200/80 flex-shrink-0 z-10 relative">
                        <div class="w-full h-full rounded-2xl overflow-hidden bg-gradient-to-tr from-slate-900 to-teal-800 text-white flex items-center justify-center text-2xl font-black">
                            @if($seller->avatar_url)
                                <img src="{{ $seller->avatar_url }}" alt="{{ $seller->shop_name ?? $seller->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($seller->shop_name ?? $seller->name, 0, 1)) }}
                            @endif
                        </div>
                    </div>

                    <!-- Details (In the clean white area below banner) -->
                    <div class="pt-1 sm:pt-3 space-y-1">
                        <div class="flex items-center space-x-2 flex-wrap">
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                {{ $seller->shop_name ?? $seller->name }}
                            </h2>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-teal-100 text-teal-800 border border-teal-200 shadow-2xs">
                                <svg class="w-3 h-3 mr-1 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Verified 
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 font-medium flex items-center space-x-2 flex-wrap">
                            <span class="font-bold text-slate-700">{{ $seller->business_category ?? 'General Merchant' }}</span>
                            <span>•</span>
                            <span>Member since {{ $seller->created_at->format('M Y') }}</span>
                            @if($seller->address)
                                <span>•</span>
                                <span class="truncate max-w-xs"> {{ $seller->address }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Store Action Buttons (Icon-Only Row) -->
                <div class="flex items-center space-x-2 self-start md:self-end">
                    <!-- Share Button (Icon Only) -->
                    <button type="button" 
                            onclick="navigator.clipboard.writeText('{{ route('shop.show', $seller->shop_slug) }}'); alert('Official store link copied! You can share this link with buyers.')" 
                            class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors flex items-center justify-center cursor-pointer shadow-2xs"
                            title="Share Store Link">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    </button>

                    <!-- WhatsApp Button (Official WhatsApp Logo, Icon Only) -->
                    @if($seller->whatsapp_number)
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $seller->whatsapp_number);
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" 
                           class="w-10 h-10 rounded-xl bg-[#25D366] hover:bg-[#20ba59] text-white transition-all shadow-md shadow-[#25D366]/25 flex items-center justify-center"
                           title="Chat on WhatsApp ({{ $seller->whatsapp_number }})">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    @endif

                    <!-- Facebook Button (Icon Only) -->
                    @if($seller->facebook_page)
                        <a href="{{ $seller->facebook_page }}" target="_blank" 
                           class="w-10 h-10 rounded-xl bg-[#1877F2] hover:bg-[#166fe5] text-white transition-all shadow-md shadow-[#1877F2]/25 flex items-center justify-center"
                           title="Visit Facebook Page">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.597 0 9 1.582 9 4.615V8z"/></svg>
                        </a>
                    @endif

                    <!-- Contact Store Button (Icon Only) -->
                    <a href="mailto:{{ $seller->email }}" 
                       class="w-10 h-10 rounded-xl bg-[#53a318] hover:bg-[#468c13] text-white transition-all shadow-md shadow-[#53a318]/25 flex items-center justify-center"
                       title="Contact Store via Email ({{ $seller->email }})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </a>
                </div>

            </div>

            <!-- Merchant Trust Metrics Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-5 border-t border-slate-100 text-xs">
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Inventory</span>
                    <span class="text-sm font-black text-slate-900 mt-0.5 block">{{ $totalProductsCount }} </span>
                </div>

                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Orders Fulfilled</span>
                    <span class="text-sm font-black text-indigo-600 mt-0.5 block">{{ $totalSalesCount }}+ Delivered</span>
                </div>

                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Satisfaction</span>
                    <span class="text-sm font-black text-emerald-600 mt-0.5 block">★ {{ number_format($avgRating, 1) }} </span>
                </div>

                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Dispatch Speed</span>
                    <span class="text-sm font-black text-teal-600 mt-0.5 block truncate" title="{{ $seller->dispatch_time ?: ' Within 24 hours' }}">
                        24 H
                    </span>
                </div>
            </div>

            <!-- Shop Description / About Store -->
            @if($seller->shop_description)
                <div class="mt-4 p-4 rounded-2xl bg-teal-50/60 border border-teal-200/80 text-xs text-slate-700 leading-relaxed">
                    <span class="font-extrabold text-teal-950 block mb-1">About Store:</span>
                    {{ $seller->shop_description }}
                </div>
            @endif

            <!-- Warranty & Return Policy -->
            @if($seller->return_policy)
                <div class="mt-3 p-4 rounded-2xl bg-amber-50/70 border border-amber-200 text-xs text-slate-700 leading-relaxed">
                    <div class="flex items-center space-x-1.5 mb-1">
                        <strong class="font-black text-amber-950">Store Return & Replacement Policy:</strong>
                    </div>
                    {{ $seller->return_policy }}
                </div>
            @endif

        </div>

    </div>

    <!-- 2. Active Ongoing Group Buy Pools by this Merchant -->
    @if($activeCircles->isNotEmpty())
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border border-amber-200 p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3.5 flex-wrap gap-2">
                <div class="flex items-center space-x-2">
        
                    <h3 class="text-sm font-black text-amber-950 tracking-tight">
                        Buying Circle from {{ $seller->shop_name ?? $seller->name }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3.5">
                @foreach($activeCircles as $circle)
                    <div class="bg-white rounded-2xl p-3.5 border border-amber-200/80 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-2.5 mb-2.5">
                                <img src="{{ $circle->product->image_url }}" alt="{{ $circle->product->title }}" class="w-10 h-10 rounded-xl object-cover bg-slate-100 border border-slate-200 flex-shrink-0">
                                <div class="min-w-0">
                                    <span class="text-xs font-bold text-slate-900 line-clamp-1">{{ $circle->product->title }}</span>
                                    <span class="font-mono text-[10px] text-teal-700 font-bold">{{ $circle->group_code }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-slate-500 font-medium">{{ $circle->current_members }}/{{ $circle->required_members }} Joined</span>
                                <span class="font-black text-emerald-600">৳{{ number_format($circle->product->group_price) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full" style="width: {{ $circle->progress_percent }}%"></div>
                            </div>
                        </div>

                        <a href="{{ route('group-buy.show', $circle->group_code) }}" target="_blank" class="mt-3 w-full py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold text-center transition-colors">
                            View Live Group &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 3. Storefront Catalog & Search Filter -->
    <div class="space-y-5">
        
        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-black text-slate-900 tracking-tight">Available Products</h3>
               
            </div>

            <form action="{{ route('seller.storefront') }}" method="GET" class="flex items-center space-x-2 flex-wrap gap-y-2">
                <div class="relative max-w-xs flex-1">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search in your store..." 
                           class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#53a318] font-medium">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                @if($categories->isNotEmpty())
                    <select name="category" onchange="this.form.submit()" class="py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                @endif

                @if(request()->hasAny(['q', 'category']))
                    <a href="{{ route('seller.storefront') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-emerald-300 p-4 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail Box -->
                        <div class="relative w-full h-44 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 p-3 mb-3 flex items-center justify-center">
                            <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[10px] font-black bg-rose-600 text-white shadow-2xs">
                                -{{ $product->discount_percent }}% OFF
                            </span>

                            <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                                {{ $product->group_size_required }} Buyers Team
                            </span>
                        </div>

                        <!-- Title & Category -->
                        <span class="text-[10px] uppercase font-bold text-emerald-600 block">{{ $product->category->name ?? 'General' }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-xs sm:text-sm font-extrabold text-slate-900 hover:text-[#53a318] line-clamp-2 mt-0.5 transition-colors">
                            {{ $product->title }}
                        </a>

                        <!-- Dual Pricing -->
                        <div class="mt-2.5 pt-2 border-t border-slate-100 space-y-1">
                            <div class="flex items-baseline space-x-1.5">
                                <span class="text-xs text-slate-400 font-bold">Team:</span>
                                <span class="text-base font-black text-emerald-600">৳{{ number_format($product->group_price) }}</span>
                                <span class="text-xs text-slate-400 line-through">৳{{ number_format($product->single_price) }}</span>
                            </div>
                            <span class="text-[10px] text-teal-700 font-bold block">
                                Save ৳{{ number_format($product->savings) }} per unit
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-3.5 flex items-center space-x-2">
                        <a href="{{ route('seller.products.edit', $product) }}" 
                           class="flex-1 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition-colors">
                            Edit
                        </a>
                        <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                           class="flex-1 py-2 rounded-xl bg-slate-900 hover:bg-[#53a318] text-white font-extrabold text-xs text-center transition-all shadow-2xs">
                            View Deal ↗
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200/90 p-8">
                    <span class="text-4xl block mb-2">🛍️</span>
                    <h3 class="text-base font-extrabold text-slate-800">No Products in This View</h3>
                    <p class="text-xs text-slate-400 mt-1">Add products or adjust filters to view items in your live storefront.</p>
                    <a href="{{ route('seller.products.create') }}" class="mt-4 inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl text-white font-bold text-xs" style="background-color: #53a318;">
                        <span>+ Add Your First Product</span>
                    </a>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
                {{ $products->links() }}
            </div>
        @endif

    </div>

</div>
