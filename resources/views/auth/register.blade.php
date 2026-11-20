@extends('layouts.app')

@section('title', 'Sign Up — Cartiva Group Buying Platform')

@section('content')
<div class="max-w-[860px] mx-auto px-4 py-6 sm:py-10 flex items-center justify-center min-h-[calc(100vh-140px)]">
    
    <!-- Unified Split Card Container -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 w-full bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/90 overflow-hidden">
        
        <!-- Left Showcase Column -->
        <div class="hidden lg:flex lg:col-span-5 relative overflow-hidden flex-col justify-between p-7 text-white select-none bg-slate-900"
             x-data="{
                activeSlide: 0,
                slides: [
                    {
                        image: '{{ asset('images/slider-1.jpg') }}',
                        title: 'একসাথে কেনাকাটা,\nপাইকারি দামে সাশ্রয়!',
                        desc: 'বন্ধু ও পরিবারের সাথে দল বেঁধে ফ্যাক্টরি রেটে শপিং উপভোগ করুন।'
                    },
                    {
                        image: '{{ asset('images/slider-2.jpg') }}',
                        title: 'গ্রুপে সদস্য যত বাড়বে,\nমূল্যছাড় তত গভীর হবে!',
                        desc: 'লক্ষ্য পূর্ণ হওয়ার সাথে সাথে স্বয়ংক্রিয়ভাবে টিয়ার ২ ও ৩ ডিসকাউন্ট কার্যকর হয়।'
                    },
                    {
                        image: '{{ asset('images/slider-3.jpg') }}',
                        title: 'নিরাপদ কেনাকাটা,\nতাৎক্ষণিক অটো-রিফান্ড!',
                        desc: 'ডেলিভারি নিশ্চিত না হওয়া পর্যন্ত প্রতিটি লেনদেন সম্পূর্ণ নিরাপদ।'
                    }
                ],
                timer: null,
                startSlider() {
                    this.timer = setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    }, 5000);
                }
             }"
             x-init="startSlider()">
            
            <!-- Background Images -->
            <template x-for="(slide, idx) in slides" :key="idx">
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                     :class="activeSlide === idx ? 'opacity-100 z-0' : 'opacity-0 -z-10'">
                    <img :src="slide.image" 
                         :alt="slide.title"
                         class="w-full h-full object-cover object-center transform transition-transform duration-[6000ms] ease-out"
                         :class="activeSlide === idx ? 'scale-105' : 'scale-100'">
                </div>
            </template>

            <!-- Atmospheric Overlays -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/40 to-slate-950/30 pointer-events-none z-10"></div>

            <!-- Top Header Bar -->
            <div class="relative z-20 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 bg-white/95 backdrop-blur-md py-1.5 px-3 rounded-xl shadow-md border border-white/60 hover:bg-white transition-all">
                    <img src="{{ asset('images/cartiva-logo.png') }}" alt="Cartiva" class="h-5 w-auto object-contain">
                </a>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 backdrop-blur-md text-white border border-white/30">
                    Join Cartiva
                </span>
            </div>

            <!-- Bottom Content -->
            <div class="relative z-20 space-y-1.5 pt-12">
                <div class="min-h-[80px] flex flex-col justify-end">
                    <h2 class="text-lg font-black text-white tracking-tight drop-shadow-md leading-tight whitespace-pre-line"
                        x-text="slides[activeSlide].title">
                    </h2>
                    <p class="text-[11px] text-slate-200/90 font-medium drop-shadow-xs leading-relaxed mt-1"
                       x-text="slides[activeSlide].desc">
                    </p>
                </div>
                <!-- Mini slide dots -->
                <div class="flex items-center space-x-1.5 pt-2">
                    <template x-for="(s, i) in slides" :key="i">
                        <button type="button" @click="activeSlide = i" 
                                class="h-1 rounded-full transition-all duration-300"
                                :class="activeSlide === i ? 'w-5 bg-[#53a318]' : 'w-1.5 bg-white/40'"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Form Column -->
        <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-center"
             x-data="{
                role: '{{ old('role', request('role', 'customer')) }}',
                showPass: false,
                showConfirmPass: false,
                agreedTerms: true
             }">
            <div class="max-w-[400px] mx-auto w-full space-y-3.5">
                
                <!-- Form Header -->
                <div class="space-y-1">
                    <div class="flex items-center justify-between lg:hidden mb-2">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/cartiva-logo.png') }}" alt="Cartiva" class="h-6 w-auto object-contain">
                        </a>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Create Your Account
                    </h1>
                    <p class="text-xs text-slate-500 font-medium">
                        Join thousands saving together with wholesale group deals
                    </p>
                </div>

                <!-- Role Selection Switcher -->
                <div>
                    <div class="grid grid-cols-2 gap-1.5 p-1 rounded-xl bg-slate-100 border border-slate-200/80">
                        <button type="button" @click="role = 'customer'"
                                :class="role === 'customer' ? 'bg-white text-slate-900 shadow-xs border-slate-200 font-black' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                                class="py-1.5 px-3 rounded-lg border border-transparent text-center transition-all flex items-center justify-center space-x-1.5 text-xs cursor-pointer">
                            <span>👤 Shopper (Customer)</span>
                        </button>

                        <button type="button" @click="role = 'seller'"
                                :class="role === 'seller' ? 'bg-white text-teal-900 shadow-xs border-teal-200 font-black' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                                class="py-1.5 px-3 rounded-lg border border-transparent text-center transition-all flex items-center justify-center space-x-1.5 text-xs cursor-pointer">
                            <span>🏪 Merchant (Seller)</span>
                        </button>
                    </div>
                </div>

                <!-- Registration Form -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-2.5">
                    @csrf
                    <input type="hidden" name="role" :value="role">

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-[11px] font-bold text-slate-700 mb-0.5">
                            <span x-text="role === 'seller' ? 'Owner / Contact Person Full Name *' : 'Full Name *'"></span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                                   placeholder="e.g. Arif Shahriar"
                                   class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318]/20 focus:border-[#53a318] bg-slate-50/60 focus:bg-white focus:outline-none transition-all">
                        </div>
                        @error('name') <span class="text-[10px] text-rose-500 font-bold mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Seller-Specific Fields -->
                    <div x-show="role === 'seller'" x-cloak class="space-y-2 p-2.5 rounded-xl bg-teal-50/70 border border-teal-200/80">
                        <div>
                            <label for="shop_name" class="block text-[11px] font-bold text-teal-950 mb-0.5">
                                Shop / Business Name *
                            </label>
                            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}"
                                   placeholder="e.g. Apex Tech & Lifestyle"
                                   class="w-full px-3 py-1.5 rounded-lg border border-teal-200 text-xs font-semibold text-slate-800 bg-white placeholder-slate-400 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all">
                            @error('shop_name') <span class="text-[10px] text-rose-500 font-bold mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="business_category" class="block text-[11px] font-bold text-teal-950 mb-0.5">
                                Primary Product Category *
                            </label>
                            <select id="business_category" name="business_category" 
                                    class="w-full px-3 py-1.5 rounded-lg border border-teal-200 text-xs font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-teal-500 focus:outline-none cursor-pointer">
                                <option value="">Select Category...</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->name }}" {{ old('business_category') == $category->name ? 'selected' : '' }}>
                                        {{ $category->icon ?? '📦' }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Email & Phone 2-Col Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <label for="email" class="block text-[11px] font-bold text-slate-700 mb-0.5">Email Address *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                       placeholder="name@example.com"
                                       class="w-full pl-8 pr-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318]/20 focus:border-[#53a318] bg-slate-50/60 focus:bg-white focus:outline-none transition-all">
                            </div>
                            @error('email') <span class="text-[10px] text-rose-500 font-bold mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-[11px] font-bold text-slate-700 mb-0.5">Phone (BD)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                       placeholder="017XXXXXXXX"
                                       class="w-full pl-8 pr-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318]/20 focus:border-[#53a318] bg-slate-50/60 focus:bg-white focus:outline-none transition-all">
                            </div>
                            @error('phone') <span class="text-[10px] text-rose-500 font-bold mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Password & Confirm 2-Col Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <label for="password" class="block text-[11px] font-bold text-slate-700 mb-0.5">Password *</label>
                            <div class="relative">
                                <input :type="showPass ? 'text' : 'password'" id="password" name="password" required 
                                       placeholder="Min 6 chars"
                                       class="w-full pl-3 pr-8 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318]/20 focus:border-[#53a318] bg-slate-50/60 focus:bg-white focus:outline-none transition-all">
                                
                                <button type="button" @click="showPass = !showPass" 
                                        class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                    <svg x-show="!showPass" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPass" x-cloak class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                </button>
                            </div>
                            @error('password') <span class="text-[10px] text-rose-500 font-bold mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[11px] font-bold text-slate-700 mb-0.5">Confirm *</label>
                            <div class="relative">
                                <input :type="showConfirmPass ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required 
                                       placeholder="Repeat password"
                                       class="w-full pl-3 pr-8 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318]/20 focus:border-[#53a318] bg-slate-50/60 focus:bg-white focus:outline-none transition-all">
                                
                                <button type="button" @click="showConfirmPass = !showConfirmPass" 
                                        class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                    <svg x-show="!showConfirmPass" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showConfirmPass" x-cloak class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="pt-0.5">
                        <label class="flex items-start space-x-1.5 text-[10px] text-slate-600 cursor-pointer">
                            <input type="checkbox" name="terms" x-model="agreedTerms" required 
                                   class="mt-0.5 rounded border-slate-300 text-[#53a318] focus:ring-[#53a318] w-3.5 h-3.5">
                            <span>
                                I agree to Cartiva's <a href="#" class="font-bold text-[#53a318] hover:underline">Terms</a>
                                and <a href="#" class="font-bold text-[#53a318] hover:underline">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" :disabled="!agreedTerms"
                            class="w-full py-2.5 px-4 rounded-xl font-bold text-xs bg-[#53a318] hover:bg-[#468c13] disabled:opacity-50 text-white shadow-sm hover:shadow-md transition-all flex items-center justify-center space-x-1.5 cursor-pointer mt-1">
                        <span>Create Account</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <!-- Divider: Social Auth -->
                <div class="relative py-0.5">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-2.5 text-slate-400 font-medium text-[11px]">
                            Or register with
                        </span>
                    </div>
                </div>

                <!-- Social Logins -->
                <div class="grid grid-cols-2 gap-2.5">
                    <a href="{{ route('auth.social', 'google') }}" 
                       class="py-2 px-3 rounded-xl border border-slate-200 hover:border-slate-300 bg-white hover:bg-slate-50 transition-all flex items-center justify-center space-x-2 text-xs font-semibold text-slate-700 shadow-2xs">
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Google</span>
                    </a>

                    <a href="{{ route('auth.social', 'facebook') }}" 
                       class="py-2 px-3 rounded-xl border border-slate-200 hover:border-slate-300 bg-white hover:bg-slate-50 transition-all flex items-center justify-center space-x-2 text-xs font-semibold text-slate-700 shadow-2xs">
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="12" fill="#1877F2"/>
                            <path fill="#FFFFFF" d="M15.12 12.03l.44-2.87h-2.75V7.3c0-.79.39-1.56 1.63-1.56h1.26V3.29c-.73-.1-1.63-.16-2.48-.16-2.53 0-4.18 1.53-4.18 4.3v2.73H6.5v2.87h2.52V20.2c.51.08 1.03.12 1.56.12s1.05-.04 1.56-.12v-7.17h2.98z"/>
                        </svg>
                        <span>Facebook</span>
                    </a>
                </div>

                <!-- Switch to Login Link -->
                <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-500">
                    Already registered? 
                    <a href="{{ route('login') }}" class="font-bold text-[#53a318] hover:underline">
                        Sign In
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
