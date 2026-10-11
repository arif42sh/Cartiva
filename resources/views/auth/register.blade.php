@extends('layouts.app')

@section('title', 'Sign Up — Cartiva Group Buying Platform')

@section('content')
<div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12">
    
    <!-- Split-Screen Container (50-50 Screen Ratio) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch min-h-[750px]">
        
        <!-- ========================================================
             1. LEFT COLUMN: BRANDING & SOCIAL PROOF PANEL (50%)
             ======================================================== -->
        <div class="lg:col-span-6 rounded-3xl bg-gradient-to-br from-slate-950 via-[#0a2008] to-slate-900 border border-slate-800 shadow-2xl p-8 sm:p-12 lg:p-14 text-white flex flex-col justify-between relative overflow-hidden">
            
            <!-- Background Radial Glows -->
            <div class="absolute -top-32 -left-32 w-80 h-80 bg-[#53a318]/25 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                
                <!-- Brand Header -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2.5 rounded-2xl shadow-lg border border-white/20">
                        <img src="{{ asset('images/cartiva-logo.png') }}" alt="Cartiva" class="h-8 w-auto object-contain">
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-black bg-[#53a318]/30 text-[#84cc16] border border-[#53a318]/40 uppercase">
                            GROUP BUY
                        </span>
                        <span class="text-xs text-slate-400 font-bold tracking-wider uppercase block mt-1">
                            Pool Demand • Slash Prices
                        </span>
                    </div>
                </div>

                <!-- Main Value Proposition Copy -->
                <div class="space-y-3">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 text-[#84cc16] text-[11px] font-black uppercase tracking-wider border border-emerald-500/30">
                        <span class="w-2 h-2 rounded-full bg-[#84cc16] animate-pulse"></span>
                        <span>SMART COMMUNITY COMMERCE</span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                        "দল বেঁধে কিনলে<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#84cc16] via-emerald-400 to-teal-300">
                            পাইকারি দামে সাশ্রয়!"
                        </span>
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-300 font-medium leading-relaxed max-w-md">
                        যুক্ত হোন ৫,০০০+ সচেতন ক্রেতা এবং ১২০+ ভেরিফাইড মার্চেন্টের সাথে। একসাথে অর্ডার ভলিউম তৈরি করে আনলক করুন সরাসরি হোলসেল ফ্যাক্টরি ডিসকাউন্ট।
                    </p>
                </div>

                <!-- Illustrative Graphic: Dynamic Tier Discount Progress Simulation -->
                <div class="p-5 rounded-2xl bg-black/40 border border-slate-800 backdrop-blur-md space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800/80 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="text-xl">🎓</span>
                            <div>
                                <h4 class="text-xs font-black text-white">BAUST Fleece Winter Hoodie</h4>
                                <span class="text-[10px] text-slate-400 font-mono">GRP-BAUST05 • Live Pool</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-black bg-rose-600/90 text-white">
                            -25% OFF
                        </span>
                    </div>

                    <!-- Step Tiers Visual -->
                    <div class="grid grid-cols-3 gap-2 text-center text-[10px]">
                        <div class="p-2 rounded-xl bg-slate-900/80 border border-slate-800">
                            <span class="text-slate-400 block font-bold">একক দাম</span>
                            <span class="text-slate-300 line-through font-bold">৳১,০০০</span>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-900/80 border border-slate-800">
                            <span class="text-amber-400 block font-bold">টিয়ার ১ (৩ জন)</span>
                            <span class="text-white font-bold">৳৮৫০</span>
                        </div>
                        <div class="p-2 rounded-xl bg-green-950/60 border border-[#53a318]/50 text-[#84cc16]">
                            <span class="block font-black">টিয়ার ২ (৫ জন)</span>
                            <span class="font-black text-xs text-white">৳৭৫০ 🔥</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="text-slate-300">👥 ৪/৫ জন সদস্য যুক্ত হয়েছেন</span>
                            <span class="text-[#84cc16]">৮০% পূর্ণ</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-800 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-[#84cc16] rounded-full animate-pulse" style="width: 80%"></div>
                        </div>
                        <span class="text-[10px] text-amber-300 block font-semibold">
                            ⚡ আর মাত্র ১ জন হলেই টিয়ার ২ পাইকারি রেট আনলক হবে!
                        </span>
                    </div>

                    <!-- Live Ticker Inside Panel -->
                    <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-[11px] text-slate-300">
                        <span class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>Arif S. just joined & saved ৳২৫০</span>
                        </span>
                        <span class="text-[#84cc16] font-mono font-bold">Just now</span>
                    </div>
                </div>

                <!-- Trust & Policy Reassurance Pillars -->
                <div class="space-y-2.5 text-xs text-slate-300">
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-[#84cc16] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>১০০% অটো-রিফান্ড গ্যারান্টি:</strong> গ্রুপ মেম্বার পূরণ না হলে পেমেন্ট ইনস্ট্যান্ট ফেরত।</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-[#84cc16] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>নিরাপদ এসক্রো চেকআউট:</strong> ডেলিভারি নিশ্চিত না হওয়া পর্যন্ত অর্থ সুরক্ষিত।</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-[#84cc16] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>ভেরিফাইড মার্চেন্ট ও আসল পণ্য:</strong> ত্রুটিযুক্ত পণ্যে ৪৮ ঘণ্টার রিপ্লেসমেন্ট।</span>
                    </div>
                </div>

            </div>

            <!-- Bottom Attribution -->
            <div class="relative z-10 pt-8 mt-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-start sm:items-center justify-between text-[11px] text-slate-500 gap-2">
                <span>&copy; {{ date('Y') }} Cartiva Group Commerce Inc.</span>
                <span>Course: <strong>CSE 3200 (BAUST)</strong></span>
            </div>

        </div>


        <!-- ========================================================
             2. RIGHT COLUMN: INTERACTIVE AUTH FORM PANEL (50%)
             ======================================================== -->
        <div class="lg:col-span-6 bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-10 lg:p-12 flex flex-col justify-between"
             x-data="{
                role: '{{ old('role', 'customer') }}',
                showPass: false,
                showConfirmPass: false,
                agreedTerms: true
             }">
            
            <div class="space-y-6">
                
                <!-- Header Title -->
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Create Your Account
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">
                        গ্রুপ বাই ছাড় উপভোগ করতে অথবা মার্চেন্ট হিসেবে পণ্য বিক্রয় করতে যোগ দিন।
                    </p>
                </div>

                <!-- Role Selection Switcher (Top of the Form) -->
                <div>
                    <span class="text-xs font-bold text-slate-700 block mb-2">আমি নিবন্ধন করতে চাই (Register as):</span>
                    <div class="grid grid-cols-2 gap-3 p-1.5 rounded-2xl bg-slate-100 border border-slate-200">
                        
                        <!-- Customer Role Tab -->
                        <button type="button" @click="role = 'customer'"
                                :class="role === 'customer' ? 'bg-white text-slate-900 shadow-md border-emerald-600 font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                class="py-3 px-3 rounded-xl border border-transparent text-center transition-all flex flex-col items-center justify-center space-y-0.5">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-base">🛒</span>
                                <span class="text-xs">Buyer / Customer</span>
                            </div>
                            <span class="text-[10px] text-emerald-700 block">Team Buy & Save</span>
                        </button>

                        <!-- Seller Role Tab -->
                        <button type="button" @click="role = 'seller'"
                                :class="role === 'seller' ? 'bg-white text-slate-900 shadow-md border-teal-600 font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                class="py-3 px-3 rounded-xl border border-transparent text-center transition-all flex flex-col items-center justify-center space-y-0.5">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-base">🏪</span>
                                <span class="text-xs">Merchant / Seller</span>
                            </div>
                            <span class="text-[10px] text-teal-700 block">Bulk Supply & Sell</span>
                        </button>
                    </div>
                </div>

                <!-- Registration Form -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" :value="role">

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1">
                            <span x-text="role === 'seller' ? 'Owner / Contact Person Full Name *' : 'Full Name *'"></span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                                   placeholder="e.g. Arif Shariar"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                        </div>
                        @error('name') <span class="text-[11px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Seller-Specific Fields: Shop Name & Business Category -->
                    <div x-show="role === 'seller'" x-cloak class="space-y-4 p-4 rounded-2xl bg-teal-50/60 border border-teal-200/80">
                        <div>
                            <label for="shop_name" class="block text-xs font-bold text-teal-950 mb-1">
                                Shop / Business Name *
                            </label>
                            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}"
                                   placeholder="e.g. TechZone Gadgets & Audio"
                                   class="w-full px-4 py-2.5 rounded-xl border border-teal-200 text-xs font-semibold text-slate-800 bg-white placeholder-slate-400 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all">
                            @error('shop_name') <span class="text-[11px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="business_category" class="block text-xs font-bold text-teal-950 mb-1">
                                Primary Product Category *
                            </label>
                            <select id="business_category" name="business_category" 
                                    class="w-full px-4 py-2.5 rounded-xl border border-teal-200 text-xs font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-teal-500 focus:outline-none cursor-pointer">
                                <option value="">Select Category...</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->name }}" {{ old('business_category') == $category->name ? 'selected' : '' }}>
                                        {{ $category->icon ?? '📦' }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Email Address & Phone Number -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                       placeholder="name@example.com"
                                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                            </div>
                            @error('email') <span class="text-[11px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">Phone Number (BD)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                       placeholder="017XXXXXXXX"
                                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                            </div>
                            @error('phone') <span class="text-[11px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Password & Confirm Password (with Show/Hide Eye Toggle) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Password *</label>
                            <div class="relative">
                                <input :type="showPass ? 'text' : 'password'" id="password" name="password" required 
                                       placeholder="Min 6 characters"
                                       class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                                
                                <button type="button" @click="showPass = !showPass" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                </button>
                            </div>
                            @error('password') <span class="text-[11px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1">Confirm Password *</label>
                            <div class="relative">
                                <input :type="showConfirmPass ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required 
                                       placeholder="Repeat password"
                                       class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                                
                                <button type="button" @click="showConfirmPass = !showConfirmPass" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <svg x-show="!showConfirmPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showConfirmPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Policy Checkbox -->
                    <div class="pt-1">
                        <label class="flex items-start space-x-2 text-xs text-slate-600 cursor-pointer">
                            <input type="checkbox" name="terms" x-model="agreedTerms" required 
                                   class="mt-0.5 rounded text-[#53a318] focus:ring-[#53a318]">
                            <span>
                                I agree to Cartiva's <a href="#" class="font-bold text-[#53a318] hover:underline">Terms of Service</a>, 
                                <a href="#" class="font-bold text-[#53a318] hover:underline">Privacy Policy</a>, 
                                and Group Buying <a href="#" class="font-bold text-[#53a318] hover:underline">100% Refund Guarantee Rules</a>.
                            </span>
                        </label>
                    </div>

                    <!-- Primary Submit Button -->
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl font-black text-xs sm:text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-lg shadow-green-900/20 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center space-x-2">
                        <span x-text="role === 'seller' ? 'Apply as Merchant / Seller &rarr;' : 'Create My Account & Start Saving &rarr;'"></span>
                    </button>
                </form>

                <!-- Divider: Social Auth -->
                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-3 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                            Or continue with
                        </span>
                    </div>
                </div>

                <!-- Google Sign-In Button -->
                <div>
                    <a href="{{ route('login') }}" 
                       class="w-full py-2.5 px-4 rounded-xl border border-slate-200 hover:border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-2xs transition-all flex items-center justify-center space-x-3">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Continue with Google</span>
                    </a>
                </div>

                <!-- Switch to Login Link -->
                <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-extrabold text-[#53a318] hover:underline">
                        Sign In &rarr;
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
