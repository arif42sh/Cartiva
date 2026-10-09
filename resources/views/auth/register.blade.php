@extends('layouts.app')

@section('title', 'Create Account - Cartiva')

@section('content')
<div class="max-w-md mx-auto px-4 py-14" x-data="{ role: 'customer' }">

    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Join Cartiva</h1>
            <p class="text-xs text-slate-500">Create an account to start shopping together or sell products.</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Role Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">I want to register as:</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="p-3 rounded-xl border text-center cursor-pointer transition-all"
                           :class="role === 'customer' ? 'border-emerald-600 bg-emerald-50 text-emerald-900 font-bold' : 'border-slate-200 text-slate-600'">
                        <input type="radio" name="role" value="customer" x-model="role" class="hidden">
                        <span class="block text-sm">🛒 Customer</span>
                        <span class="text-[10px] block opacity-75">Team Buy & Save</span>
                    </label>

                    <label class="p-3 rounded-xl border text-center cursor-pointer transition-all"
                           :class="role === 'seller' ? 'border-teal-600 bg-teal-50 text-teal-900 font-bold' : 'border-slate-200 text-slate-600'">
                        <input type="radio" name="role" value="seller" x-model="role" class="hidden">
                        <span class="block text-sm">🏪 Merchant</span>
                        <span class="text-[10px] block opacity-75">Sell & List Deals</span>
                    </label>
                </div>
                @error('role') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Full Name / Store Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                @error('name') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                @error('email') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    @error('password') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number (Optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+880 1..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Delivery Address (Optional)</label>
                <textarea name="address" rows="2" placeholder="Street, City..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('address') }}</textarea>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-bold text-xs bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-600/30 transition-all">
                Create Account
            </button>
        </form>

        <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-600">
            Already registered? 
            <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:underline">Sign in here</a>
        </div>

    </div>

</div>
@endsection
