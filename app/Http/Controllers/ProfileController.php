<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the comprehensive user profile dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        $totalOrdersCount = $user->orders()->count();
        $activeGroupsCount = $user->orders()->where('order_type', 'group_buy')->count();

        $orders = $user->orders()
            ->with(['items.product', 'groupSession.product'])
            ->latest()
            ->take(8)
            ->get();

        $activeGroups = $user->groupMemberships()
            ->with(['session.product', 'session.members.user'])
            ->latest()
            ->take(8)
            ->get();

        // Calculate actual group savings
        $totalSpent = $user->total_spent;
        $estimatedSavings = $user->total_savings;

        return view('profile.index', compact('user', 'orders', 'activeGroups', 'totalSpent', 'estimatedSavings', 'totalOrdersCount', 'activeGroupsCount'));
    }

    /**
     * Update user profile information including Avatar photo and address.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string', 'max:500'],
            'shop_name' => ['nullable', 'string', 'max:255'],
            'business_category' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:4096'],
        ], [
            'name.required' => 'Please enter your name.',
            'avatar.image' => 'Avatar must be a valid image file.',
            'avatar.max' => 'Avatar cannot exceed 4MB.',
        ]);

        // Handle Avatar File Upload
        if ($request->hasFile('avatar')) {
            // Delete previous avatar file if stored locally
            if ($user->avatar && str_starts_with($user->avatar, '/storage/avatars/')) {
                $oldPath = str_replace('/storage/', '', $user->avatar);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = '/storage/' . $path;
        } elseif ($request->boolean('remove_avatar')) {
            if ($user->avatar && str_starts_with($user->avatar, '/storage/avatars/')) {
                $oldPath = str_replace('/storage/', '', $user->avatar);
                Storage::disk('public')->delete($oldPath);
            }
            $user->avatar = null;
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;

        if ($user->isSeller() || $request->filled('shop_name')) {
            $user->shop_name = $validated['shop_name'] ?? $user->shop_name;
            $user->business_category = $validated['business_category'] ?? $user->business_category;
        }

        $user->save();

        $section = $request->input('section');
        if ($section === 'address') {
            $message = 'Location updated';
        } elseif ($section === 'merchant') {
            $message = 'Store details updated';
        } elseif ($request->hasFile('avatar')) {
            $message = 'Profile photo updated';
        } else {
            $message = 'Profile updated';
        }

        return back()->with('success', $message);
    }

    /**
     * Update the user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'Current password is required.',
            'current_password.current_password' => 'Current password does not match.',
            'password.required' => 'New password is required.',
            'password.confirmed' => 'New password confirmation does not match.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated');
    }
}
