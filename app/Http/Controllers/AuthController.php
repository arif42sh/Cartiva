<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ], [
            'email.required' => 'ইমেইল অথবা ফোন নম্বর প্রদান করুন।',
            'password.required' => 'পাসওয়ার্ড প্রদান করুন।',
        ]);

        $loginInput = trim($request->input('email'));
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return $this->redirectBasedOnRole($user)
                ->with('success', "স্বাগতম, {$user->name}! Cartiva-তে সফলভাবে লগইন হয়েছে।");
        }

        return back()->withErrors([
            'email' => 'আপনার প্রদত্ত ইমেইল/ফোন অথবা পাসওয়ার্ডটি সঠিক নয়।',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        $categories = Category::all();
        return view('auth.register', compact('categories'));
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'role' => ['required', 'in:customer,seller'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ];

        if ($request->input('role') === 'seller') {
            $rules['shop_name'] = ['required', 'string', 'max:255'];
            $rules['business_category'] = ['nullable', 'string', 'max:100'];
        }

        $messages = [
            'name.required' => 'আপনার পূর্ণ নাম প্রদান করুন।',
            'email.required' => 'সঠিক ইমেইল অ্যাড্রেস প্রদান করুন।',
            'email.unique' => 'এই ইমেইলটি দিয়ে ইতিমধ্যে অ্যাকাউন্ট তৈরি করা হয়েছে।',
            'password.required' => 'কমপক্ষে ৬ ডিজিটের পাসওয়ার্ড দিন।',
            'password.confirmed' => 'পাসওয়ার্ড কনফার্মেশন মিলছে না।',
            'shop_name.required' => 'দোকান বা ব্যবসার নাম প্রদান করুন।',
        ];

        $validated = $request->validate($rules, $messages);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'shop_name' => $validated['shop_name'] ?? null,
            'business_category' => $validated['business_category'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user)
            ->with('success', "অভিনন্দন, {$user->name}! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে।");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'You have been logged out successfully.');
    }

    protected function redirectBasedOnRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSeller()) {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->intended(route('home'));
    }
}
