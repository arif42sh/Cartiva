<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the user profile overview dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        $orders = $user->orders()
            ->with(['items.product', 'groupSession.product'])
            ->latest()
            ->take(6)
            ->get();

        $activeGroups = $user->groupMemberships()
            ->with(['session.product', 'session.members.user'])
            ->latest()
            ->take(6)
            ->get();

        // Calculate total group savings estimate
        $totalSpent = $user->orders()->where('order_status', '!=', 'cancelled')->sum('total_amount');
        $estimatedSavings = $user->orders()
            ->where('order_type', 'group_buy')
            ->where('order_status', '!=', 'cancelled')
            ->sum('total_amount') * 0.25;

        return view('profile.index', compact('user', 'orders', 'activeGroups', 'totalSpent', 'estimatedSavings'));
    }

    /**
     * Update basic user profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($validated);

        return back()->with('success', 'প্রোফাইল তথ্য সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Update the user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
    }
}
