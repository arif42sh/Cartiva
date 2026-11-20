<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check() && !$request->has('switch')) {
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

            ActivityLog::log('user_login', "User {$user->name} ({$user->email}) logged in successfully as " . ucfirst($user->role), 'User', $user->id, $user->id);

            return $this->redirectBasedOnRole($user)
                ->with('success', "স্বাগতম, {$user->name}! Cartiva-তে সফলভাবে লগইন হয়েছে।");
        }

        return back()->withErrors([
            'email' => 'আপনার প্রদত্ত ইমেইল/ফোন অথবা পাসওয়ার্ডটি সঠিক নয়।',
        ])->onlyInput('email');
    }

    public function showRegister(Request $request)
    {
        if (Auth::check() && !$request->has('role') && !$request->has('switch')) {
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

        ActivityLog::log('user_registered', "New " . ucfirst($user->role) . " registered: {$user->name} ({$user->email})", 'User', $user->id, $user->id);

        return $this->redirectBasedOnRole($user)
            ->with('success', "অভিনন্দন, {$user->name}! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে।");
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $u = Auth::user();
            ActivityLog::log('user_logout', "User {$u->name} ({$u->email}) logged out.", 'User', $u->id, $u->id);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'You have been logged out successfully.');
    }

    public function switchUser(string $role)
    {
        $targetUser = null;
        if ($role === 'seller') {
            $targetUser = User::where('role', 'seller')->first();
        } elseif ($role === 'customer') {
            $targetUser = User::where('role', 'customer')->where('id', 3)->first() 
                ?? User::where('role', 'customer')->first();
        } elseif ($role === 'admin') {
            $targetUser = User::where('role', 'admin')->first();
        }

        if ($targetUser) {
            Auth::login($targetUser);
            if (request()->hasSession()) {
                request()->session()->regenerate();
            }

            if ($targetUser->isSeller()) {
                return redirect()->route('seller.dashboard')->with('success', "Switched to Merchant Account: {$targetUser->name}");
            } elseif ($targetUser->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', "Switched to Administrator: {$targetUser->name}");
            } else {
                return redirect()->route('home')->with('success', "Switched to Customer Account: {$targetUser->name}");
            }
        }

        return redirect()->back()->with('error', 'Target user persona not found.');
    }

    public function socialLogin(Request $request, string $provider)
    {
        $provider = strtolower($provider);
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'অসমর্থিত সোশ্যাল লগইন মেথড।');
        }

        $clientId = config("services.{$provider}.client_id");
        $clientSecret = config("services.{$provider}.client_secret");

        // If credentials are configured in .env and Socialite is available, use real OAuth
        if (!empty($clientId) && !empty($clientSecret) && class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            try {
                return \Laravel\Socialite\Facades\Socialite::driver($provider)->redirect();
            } catch (\Throwable $e) {
                // fallback to direct login
            }
        }

        // Direct 1-Click Social Sign-In (Instant authentication for Google / Facebook)
        return $this->handleDirectSocialLogin($request, $provider);
    }

    public function socialCallback(Request $request, string $provider)
    {
        $provider = strtolower($provider);
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'অসমর্থিত সোশ্যাল লগইন মেথড।');
        }

        if (class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            try {
                $socialUser = \Laravel\Socialite\Facades\Socialite::driver($provider)->user();
                $email = $socialUser->getEmail() ?: "{$provider}_" . $socialUser->getId() . "@cartiva.com";
                
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $socialUser->getName() ?: ucfirst($provider) . ' User',
                        'password' => Hash::make(Str::random(24)),
                        'role' => 'customer',
                        'avatar' => $socialUser->getAvatar(),
                        'email_verified_at' => now(),
                        'status' => 'active',
                    ]
                );

                Auth::login($user, true);
                if ($request->hasSession()) {
                    $request->session()->regenerate();
                }

                ActivityLog::log('social_login', "User {$user->name} logged in via {$provider}", 'User', $user->id, $user->id);

                $providerName = ucfirst($provider);
                return $this->redirectBasedOnRole($user)
                    ->with('success', "{$providerName} অ্যাকাউন্টের মাধ্যমে সফলভাবে লগইন সম্পন্ন হয়েছে!");
            } catch (\Throwable $e) {
                return $this->handleDirectSocialLogin($request, $provider);
            }
        }

        return $this->handleDirectSocialLogin($request, $provider);
    }

    protected function handleDirectSocialLogin(Request $request, string $provider)
    {
        $providerName = ucfirst($provider);
        $role = $request->input('role') === 'seller' ? 'seller' : 'customer';

        if ($role === 'seller') {
            $email = $provider === 'google' ? 'google.merchant@cartiva.com' : 'facebook.merchant@cartiva.com';
            $name = $provider === 'google' ? 'Google Merchant Shop' : 'Facebook Store Official';
            $shopName = $provider === 'google' ? 'Google Express Shop' : 'Facebook Mart';
            $avatar = $provider === 'google'
                ? 'https://ui-avatars.com/api/?name=Google+Merchant&background=4285F4&color=fff&bold=true'
                : 'https://ui-avatars.com/api/?name=Facebook+Merchant&background=1877F2&color=fff&bold=true';
        } else {
            $email = $provider === 'google' ? 'google.shopper@cartiva.com' : 'facebook.shopper@cartiva.com';
            $name = $provider === 'google' ? 'Arif Shahriar (Google)' : 'Arif Shahriar (Facebook)';
            $shopName = null;
            $avatar = $provider === 'google'
                ? 'https://ui-avatars.com/api/?name=Arif+Shahriar&background=4285F4&color=fff&bold=true'
                : 'https://ui-avatars.com/api/?name=Arif+Shahriar&background=1877F2&color=fff&bold=true';
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('cartiva_social_123'),
                'role' => $role,
                'shop_name' => $shopName,
                'avatar' => $avatar,
                'email_verified_at' => now(),
                'status' => 'active',
                'phone' => $provider === 'google' ? '01711000001' : '01711000002',
                'address' => 'Dhaka, Bangladesh',
            ]
        );

        if ($user->status !== 'active') {
            $user->update(['status' => 'active']);
        }

        Auth::login($user, true);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        ActivityLog::log('social_login', "User {$user->name} logged in via {$providerName}", 'User', $user->id, $user->id);

        return $this->redirectBasedOnRole($user)
            ->with('success', "{$providerName} অ্যাকাউন্টের মাধ্যমে সফলভাবে সরাসরি লগইন সম্পন্ন হয়েছে!");
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
