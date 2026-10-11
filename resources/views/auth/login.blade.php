@extends('layouts.app')

@section('title', 'Sign In — Cartiva Group Buying Platform')

@section('content')
<div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12"
     x-data="{
        showPass: false,
        fillDemo(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
     }">
    
    <!-- Split-Screen Container (50-50 Screen Ratio) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch min-h-[700px]">
        
        <!-- ========================================================
             1. LEFT COLUMN: BRANDING & ACTIVE POOLS PANEL (50%)
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
                            Buy Together, Pay Less
                        </span>
                    </div>
                </div>

                <!-- Main Value Proposition Copy -->
                <div class="space-y-3">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 text-[#84cc16] text-[11px] font-black uppercase tracking-wider border border-emerald-500/30">
                        <span class="w-2 h-2 rounded-full bg-[#84cc16] animate-pulse"></span>
                        <span>WELCOME BACK MEMBER</span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                        "আপনার গ্রুপ ডিল ও<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#84cc16] via-emerald-400 to-teal-300">
                            অর্ডার ট্র্যাক করুন সহজেই!"
                        </span>
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-300 font-medium leading-relaxed max-w-md">
                        লগইন করে আপনার চলমান কেনাকাটার পুলগুলো দেখুন, বন্ধুদের সাথে শেয়ার লিংক পাঠিয়ে টার্গেট পূর্ণ করুন এবং হোলসেল রেট নিশ্চিত করুন।
                    </p>
                </div>

                <!-- Active Pool Live Tracker Preview Card -->
                <div class="p-5 rounded-2xl bg-black/40 border border-slate-800 backdrop-blur-md space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800/80 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="text-xl">🎧</span>
                            <div>
                                <h4 class="text-xs font-black text-white">SoundCore ANC Headphones</h4>
                                <span class="text-[10px] text-slate-400 font-mono">GRP-SOUND99 • Ending Soon</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-black bg-[#53a318] text-white">
                            -30% OFF
                        </span>
                    </div>

                    <!-- Progress Status -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="text-slate-300">👥 Pool Fill: ১/২ জন যুক্ত</span>
                            <span class="text-amber-400 font-mono">⏱ ৩ ঘণ্টা ১২ মিনিট বাকি</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-400 to-[#53a318] rounded-full" style="width: 50%"></div>
                        </div>
                        <span class="text-[10px] text-[#84cc16] block font-semibold">
                            🔥 আর মাত্র ১ জন হলে পাইকারি মূল্য ৳৩,১৫০ নিশ্চিত হবে!
                        </span>
                    </div>

                    <!-- Verified Review Testimonial -->
                    <div class="pt-3 border-t border-slate-800/80 text-[11px] text-slate-300 italic">
                        "বন্ধুরা মিলে একসাথে অর্ডার দিয়ে ২৫% ছাড় পেয়েছি। গ্রুপ পূর্ণ না হলে অটো-রিফান্ড থাকায় কোনো টেনশন থাকে না।"
                        <div class="text-[10px] not-italic text-slate-400 font-bold mt-1">
                            — আরিফ এস., সিএসই বিভাগ, বাউস্ট (Saidpur)
                        </div>
                    </div>
                </div>

                <!-- Trust Badges List -->
                <div class="grid grid-cols-2 gap-3 text-xs text-slate-300">
                    <div class="p-2.5 rounded-xl bg-white/5 border border-white/5 flex items-center space-x-2">
                        <span class="text-lg">🛡️</span>
                        <div>
                            <span class="font-bold block text-white text-[11px]">১০০% অটো-রিফান্ড</span>
                            <span class="text-[10px] text-slate-400">ব্যর্থ গ্রুপে ইনস্ট্যান্ট ফেরত</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-white/5 border border-white/5 flex items-center space-x-2">
                        <span class="text-lg">🔒</span>
                        <div>
                            <span class="font-bold block text-white text-[11px]">নিরাপদ এসক্রো</span>
                            <span class="text-[10px] text-slate-400">bKash, Nagad ও কার্ড সাপোর্ট</span>
                        </div>
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
             2. RIGHT COLUMN: INTERACTIVE LOGIN FORM PANEL (50%)
             ======================================================== -->
        <div class="lg:col-span-6 bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-10 lg:p-12 flex flex-col justify-between">
            
            <div class="space-y-6">
                
                <!-- Form Header -->
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Welcome Back to Cartiva
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">
                        Log in to track your active buying pools and orders.
                    </p>
                </div>

                <!-- 1-Click Quick Demo Login Fillers (For Evaluation & Demo) -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 block">
                            ⚡ Quick Demo Logins (1-Click Auto Fill):
                        </span>
                        <span class="text-[9px] font-bold text-[#53a318] bg-green-50 px-1.5 py-0.2 rounded">For CSE 3200 Demo</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-xs font-bold">
                        <button type="button" @click="fillDemo('admin@cartiva.com', 'password123')" 
                                class="py-2 px-2.5 rounded-xl bg-purple-100 hover:bg-purple-200 text-purple-900 border border-purple-200/60 transition-all flex items-center justify-center space-x-1 shadow-2xs">
                            <span>👑</span>
                            <span>Admin</span>
                        </button>

                        <button type="button" @click="fillDemo('seller@cartiva.com', 'password123')" 
                                class="py-2 px-2.5 rounded-xl bg-teal-100 hover:bg-teal-200 text-teal-900 border border-teal-200/60 transition-all flex items-center justify-center space-x-1 shadow-2xs">
                            <span>🏪</span>
                            <span>Seller</span>
                        </button>

                        <button type="button" @click="fillDemo('customer@cartiva.com', 'password123')" 
                                class="py-2 px-2.5 rounded-xl bg-emerald-100 hover:bg-emerald-200 text-emerald-900 border border-emerald-200/60 transition-all flex items-center justify-center space-x-1 shadow-2xs">
                            <span>👤</span>
                            <span>Customer</span>
                        </button>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email / Phone Number Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                            Email Address or Phone Number *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                            </div>
                            <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="e.g. user@cartiva.com or 017XXXXXXXX"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                        </div>
                        @error('email') 
                            <span class="text-[11px] text-rose-500 font-bold mt-1.5 flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $message }}</span>
                            </span> 
                        @enderror
                    </div>

                    <!-- Password Field with Show/Hide Eye Button -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-xs font-bold text-slate-700">
                                Password *
                            </label>
                            <a href="#" @click.prevent="alert('পাসওয়ার্ড ভুলে গেলে অ্যাডমিনের সাথে যোগাযোগ করুন: admin@cartiva.com অথবা ডেমো বাটন ব্যবহার করুন।')" 
                               class="text-[11px] font-bold text-[#53a318] hover:underline">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input :type="showPass ? 'text' : 'password'" id="password" name="password" required 
                                   placeholder="Enter your password"
                                   class="w-full pl-10 pr-10 py-3 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-[#53a318] focus:border-[#53a318] focus:outline-none transition-all">
                            
                            <!-- Toggle Eye Button -->
                            <button type="button" @click="showPass = !showPass" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                            </button>
                        </div>
                        @error('password') 
                            <span class="text-[11px] text-rose-500 font-bold mt-1.5 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Helper Row: Remember Me -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded text-[#53a318] focus:ring-[#53a318]">
                            <span>Remember me on this device</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl font-black text-xs sm:text-sm bg-[#53a318] hover:bg-[#468c13] text-white shadow-lg shadow-green-900/20 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center space-x-2">
                        <span>Sign In to Account</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
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

                <!-- Google One-Tap / OAuth Button -->
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

                <!-- Switch to Registration Link -->
                <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-600">
                    New to Cartiva? 
                    <a href="{{ route('register') }}" class="font-extrabold text-[#53a318] hover:underline">
                        Create an Account & Start Saving &rarr;
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
