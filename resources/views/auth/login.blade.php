@extends('layouts.app')

@section('title', 'Sign In - Cartiva')

@section('content')
<div class="max-w-md mx-auto px-4 py-16" x-data="{
    fillDemo(email, pass) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pass;
    }
}">

    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mx-auto shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Sign In to Cartiva</h1>
            <p class="text-xs text-slate-500">Access your deals, active groups, and order history.</p>
        </div>

        <!-- 1-Click Demo Login Fillers -->
        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Quick Demo Logins (1-Click Fill):</span>
            <div class="grid grid-cols-3 gap-1.5 text-[11px] font-semibold">
                <button type="button" @click="fillDemo('admin@cartiva.com', 'password123')" class="py-1.5 px-2 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-900 transition-colors">
                    👑 Admin
                </button>
                <button type="button" @click="fillDemo('seller@cartiva.com', 'password123')" class="py-1.5 px-2 rounded-lg bg-teal-100 hover:bg-teal-200 text-teal-900 transition-colors">
                    🏪 Seller
                </button>
                <button type="button" @click="fillDemo('customer@cartiva.com', 'password123')" class="py-1.5 px-2 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-900 transition-colors">
                    👤 Customer
                </button>
            </div>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                @error('email') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                @error('password') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-bold text-xs bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-600/30 transition-all">
                Sign In
            </button>
        </form>

        <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-600">
            Don't have an account yet? 
            <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:underline">Register now</a>
        </div>

    </div>

</div>
@endsection
