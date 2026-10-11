@extends('layouts.app')

@section('title', 'Sign In — Cartiva Group Buying Platform')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-3 sm:py-5 flex items-center justify-center min-h-[calc(100vh-120px)]"
     x-data="{
        showPass: false,
        fillDemo(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
     }">
    
    <!-- Split-Screen Container (50-50 Screen Ratio, Viewport Fit) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6 items-stretch w-full">
        
        <!-- ========================================================
             1. LEFT COLUMN: CINEMATIC SHOWCASE (100% CLEAN • ZERO BADGES • ZERO SLIDER BARS)
             ======================================================== -->
        <div class="lg:col-span-6 rounded-2xl relative overflow-hidden flex flex-col justify-between shadow-2xl border border-slate-800/80 min-h-[580px] p-6 sm:p-7 text-white select-none"
             x-data="{
                activeSlide: 0,
                slides: [
                    {
                        image: '{{ asset('images/slider-1.jpg') }}',
                        title: 'একসাথে কেনাকাটা,\nসরাসরি পাইকারি দামে সাশ্রয়!',
                        desc: 'বন্ধু ও পরিবারের সাথে দল বেঁধে কেনাকাটা করুন এবং ফ্যাক্টরি রেট আনলক করুন।'
                    },
                    {
                        image: '{{ asset('images/slider-2.jpg') }}',
                        title: 'গ্রুপে সদস্য যত বাড়বে,\nমূল্যছাড় তত গভীর হবে!',
                        desc: 'মেম্বার লক্ষ্য পূর্ণ হওয়ার সাথে সাথে স্বয়ংক্রিয়ভাবে টিয়ার ২ ও টিয়ার ৩ হোলসেল ডিসকাউন্ট কার্যকর হয়।'
                    },
                    {
                        image: '{{ asset('images/slider-3.jpg') }}',
                        title: 'নিরাপদ কেনাকাটা,\n১০০% তাৎক্ষণিক অটো-রিফান্ড!',
                        desc: 'ডেলিভারি নিশ্চিত না হওয়া পর্যন্ত প্রতিটি লেনদেন সম্পূর্ণ নিরাপদ। কোনো লুকানো চার্জ নেই।'
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
            
            <!-- Background Images with Smooth Crossfade & Subtle Cinematic Zoom -->
            <template x-for="(slide, idx) in slides" :key="idx">
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                     :class="activeSlide === idx ? 'opacity-100 z-0' : 'opacity-0 -z-10'">
                    <img :src="slide.image" 
                         :alt="slide.title"
                         class="w-full h-full object-cover object-center transform transition-transform duration-[6000ms] ease-out"
                         :class="activeSlide === idx ? 'scale-105' : 'scale-100'">
                </div>
            </template>

            <!-- Subtle Atmospheric Dark Overlays (Natural Light Maintained) -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-slate-950/30 pointer-events-none z-10"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/30 via-transparent to-slate-950/20 pointer-events-none z-10"></div>

            <!-- Top Header Bar: Clean Cartiva Branding Only (Zero Badges) -->
            <div class="relative z-20 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 bg-white/95 backdrop-blur-md py-1.5 px-3 rounded-xl shadow-md border border-white/60 hover:bg-white transition-all">
                    <img src="{{ asset('images/cartiva-logo.png') }}" alt="Cartiva" class="h-6 w-auto object-contain">
                </a>
            </div>

            <!-- Middle: Clean Atmosphere (No Scattered Badges) -->

            <!-- Bottom Content: Clean & Powerful Headline (Zero Badges • Zero Slider Bars) -->
            <div class="relative z-20 space-y-2 pb-1">
                <div class="space-y-1.5 max-w-md min-h-[92px] flex flex-col justify-end">
                    <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight drop-shadow-md leading-tight whitespace-pre-line"
                        x-text="slides[activeSlide].title">
                    </h2>

                    <p class="text-xs text-slate-200/90 font-medium drop-shadow-xs leading-relaxed"
                       x-text="slides[activeSlide].desc">
                    </p>
                </div>
            </div>

        </div>


        <!-- ========================================================
             2. RIGHT COLUMN: INTERACTIVE LOGIN FORM PANEL (50%)
             ======================================================== -->
        <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 shadow-xl p-6 sm:p-7 flex flex-col justify-between">
            
            <div class="space-y-4">
                
                <!-- Form Header -->
                <div class="space-y-0.5">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Welcome Back to Cartiva
                    </h1>
                   
                </div>

                <!-- 1-Click Quick Demo Login Fillers -->
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 block">
                            ⚡ Quick Demo Logins (1-Click Auto Fill):
                        </span>
                        <span class="text-[9px] font-bold text-[#53a318] bg-green-50 px-1.5 py-0.2 rounded">Instant 1-Click Fill</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5 text-xs font-bold">
                        <button type="button" @click="fillDemo('admin@cartiva.com', 'password123')" 
                                class="py-1.5 px-2 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-900 border border-purple-200/60 transition-all flex items-center justify-center space-x-1 text-[11px]">
                            <span>👑</span>
                            <span>Admin</span>
                        </button>

                        <button type="button" @click="fillDemo('seller@cartiva.com', 'password123')" 
                                class="py-1.5 px-2 rounded-lg bg-teal-100 hover:bg-teal-200 text-teal-900 border border-teal-200/60 transition-all flex items-center justify-center space-x-1 text-[11px]">
                            <span>🏪</span>
                            <span>Seller</span>
                        </button>

                        <button type="button" @click="fillDemo('customer@cartiva.com', 'password123')" 
                                class="py-1.5 px-2 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-900 border border-emerald-200/60 transition-all flex items-center justify-center space-x-1 text-[11px]">
                            <span>👤</span>
                            <span>Customer</span>
                        </button>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-3">
                    @csrf

                    <!-- Email / Phone Number Input -->
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-slate-700 mb-1">
                            Email Address or Phone Number *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                            </div>
                            <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="e.g. user@cartiva.com or 017XXXXXXXX"
                                   class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                        </div>
                        @error('email') 
                            <span class="text-[10px] text-rose-500 font-bold mt-1 flex items-center space-x-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $message }}</span>
                            </span> 
                        @enderror
                    </div>

                    <!-- Password Field with Show/Hide Eye Button -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-[11px] font-bold text-slate-700">
                                Password *
                            </label>
                            <a href="#" @click.prevent="alert('পাসওয়ার্ড ভুলে গেলে অ্যাডমিনের সাথে যোগাযোগ করুন: admin@cartiva.com অথবা ডেমো বাটন ব্যবহার করুন।')" 
                               class="text-[10px] font-bold text-[#53a318] hover:underline">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input :type="showPass ? 'text' : 'password'" id="password" name="password" required 
                                   placeholder="Enter your password"
                                   class="w-full pl-9 pr-9 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                            
                            <!-- Toggle Eye Button -->
                            <button type="button" @click="showPass = !showPass" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg x-show="!showPass" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPass" x-cloak class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                            </button>
                        </div>
                        @error('password') 
                            <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Helper Row: Remember Me -->
                    <div class="flex items-center justify-between text-[11px]">
                        <label class="flex items-center space-x-1.5 text-slate-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded text-[#53a318] focus:ring-[#53a318] w-3.5 h-3.5">
                            <span>Remember me on this device</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-2.5 px-4 rounded-xl font-black text-xs bg-[#53a318] hover:bg-[#468c13] text-white shadow-md shadow-green-900/20 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center space-x-2">
                        <span>Sign In to Account</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <!-- Divider: Social Auth -->
                <div class="relative py-1">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-3 text-slate-500 font-medium text-[11px]">
                            Or, sign in with
                        </span>
                    </div>
                </div>

                <!-- Social Logins (Google & Facebook Circular Buttons) -->
                <div class="flex items-center justify-center space-x-3.5 pt-0.5">
                    <a href="{{ route('login') }}" 
                       class="w-10 h-10 rounded-full border border-slate-200 hover:border-slate-300 bg-white hover:bg-slate-50 shadow-2xs transition-all hover:scale-105 active:scale-95 flex items-center justify-center"
                       title="Sign in with Google">
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                    </a>

                    <a href="{{ route('login') }}" 
                       class="w-10 h-10 rounded-full border border-slate-200 hover:border-slate-300 bg-white hover:bg-slate-50 shadow-2xs transition-all hover:scale-105 active:scale-95 flex items-center justify-center"
                       title="Sign in with Facebook">
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="12" fill="#1877F2"/>
                            <path fill="#FFFFFF" d="M15.12 12.03l.44-2.87h-2.75V7.3c0-.79.39-1.56 1.63-1.56h1.26V3.29c-.73-.1-1.63-.16-2.48-.16-2.53 0-4.18 1.53-4.18 4.3v2.73H6.5v2.87h2.52V20.2c.51.08 1.03.12 1.56.12s1.05-.04 1.56-.12v-7.17h2.98z"/>
                        </svg>
                    </a>
                </div>

                <!-- Switch to Registration Link -->
                <div class="text-center pt-1.5 border-t border-slate-100 text-xs text-slate-600">
                    New to Cartiva? 
                    <a href="{{ route('register') }}" class="font-extrabold text-[#53a318] hover:underline">
                        Create an Account 
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
