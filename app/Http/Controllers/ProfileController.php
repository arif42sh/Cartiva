<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'address_tag' => ['nullable', 'string', 'max:50'],
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

        if ($request->filled('latitude')) {
            $user->latitude = $request->input('latitude');
        }
        if ($request->filled('longitude')) {
            $user->longitude = $request->input('longitude');
        }
        if ($request->filled('address_tag')) {
            $user->address_tag = $request->input('address_tag');
        }

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

    /**
     * Search location autocomplete via backend proxy (avoids CORS & rate limits).
     */
    public function searchLocation(Request $request)
    {
        $query = trim($request->input('q', ''));
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = Cache::remember('geo_search_' . md5(strtolower($query)), 3600, function () use ($query) {
            // First try Photon Komoot (biased to Bangladesh)
            try {
                $response = Http::timeout(3)
                    ->withUserAgent('Cartiva/1.0')
                    ->get('https://photon.komoot.io/api/', [
                        'q' => $query,
                        'lat' => 23.8103,
                        'lon' => 90.4125,
                        'limit' => 6,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['features'])) {
                        $items = [];
                        foreach ($data['features'] as $f) {
                            $props = $f['properties'] ?? [];
                            $coords = $f['geometry']['coordinates'] ?? [90.4125, 23.8103];
                            $items[] = [
                                'lat' => (float)$coords[1],
                                'lng' => (float)$coords[0],
                                'title' => $props['name'] ?? $props['street'] ?? $props['locality'] ?? $props['district'] ?? 'Location',
                                'subtitle' => implode(', ', array_filter([
                                    $props['street'] ?? null,
                                    $props['locality'] ?? null,
                                    $props['district'] ?? null,
                                    $props['city'] ?? $props['state'] ?? null,
                                ])),
                                'house' => $props['housenumber'] ?? '',
                                'road' => $props['street'] ?? '',
                                'area' => $props['locality'] ?? $props['district'] ?? '',
                                'city' => $props['city'] ?? $props['state'] ?? 'Dhaka',
                            ];
                        }
                        return $items;
                    }
                }
            } catch (\Throwable $e) {}

            // Fallback to Nominatim
            try {
                $response = Http::timeout(3)
                    ->withUserAgent('CartivaECommerce/1.0 (contact@cartiva.com)')
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'format' => 'jsonv2',
                        'q' => $query,
                        'countrycodes' => 'bd',
                        'limit' => 5,
                        'accept-language' => 'en',
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $items = [];
                    foreach ($data as $item) {
                        $items[] = [
                            'lat' => (float)$item['lat'],
                            'lng' => (float)$item['lon'],
                            'title' => $item['name'] ?? explode(',', $item['display_name'])[0],
                            'subtitle' => $item['display_name'],
                            'house' => '',
                            'road' => '',
                            'area' => explode(',', $item['display_name'])[0] ?? '',
                            'city' => 'Dhaka',
                        ];
                    }
                    return $items;
                }
            } catch (\Throwable $e) {}

            return [];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Reverse geocode coordinates to structured address.
     */
    public function reverseGeocode(Request $request)
    {
        $lat = round((float)$request->input('lat', 23.8103), 4);
        $lng = round((float)$request->input('lng', 90.4125), 4);

        $result = Cache::remember("geo_rev_{$lat}_{$lng}", 86400, function () use ($lat, $lng) {
            try {
                $response = Http::timeout(3)
                    ->withUserAgent('CartivaECommerce/1.0 (contact@cartiva.com)')
                    ->get('https://nominatim.openstreetmap.org/reverse', [
                        'format' => 'jsonv2',
                        'lat' => $lat,
                        'lon' => $lng,
                        'accept-language' => 'en',
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $addr = $data['address'] ?? [];
                    return [
                        'lat' => $lat,
                        'lng' => $lng,
                        'house' => $addr['house_number'] ?? $addr['building'] ?? '',
                        'road' => $addr['road'] ?? $addr['residential'] ?? $addr['street'] ?? '',
                        'area' => $addr['quarter'] ?? $addr['suburb'] ?? $addr['neighbourhood'] ?? $addr['city_district'] ?? '',
                        'city' => $addr['city'] ?? $addr['town'] ?? $addr['municipality'] ?? $addr['state_district'] ?? 'Dhaka',
                        'display_name' => $data['display_name'] ?? '',
                    ];
                }
            } catch (\Throwable $e) {}

            // Fallback to Photon reverse
            try {
                $response = Http::timeout(3)
                    ->withUserAgent('Cartiva/1.0')
                    ->get('https://photon.komoot.io/reverse', [
                        'lat' => $lat,
                        'lon' => $lng,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['features'])) {
                        $p = $data['features'][0]['properties'] ?? [];
                        return [
                            'lat' => $lat,
                            'lng' => $lng,
                            'house' => $p['housenumber'] ?? '',
                            'road' => $p['street'] ?? '',
                            'area' => $p['locality'] ?? $p['district'] ?? '',
                            'city' => $p['city'] ?? $p['state'] ?? 'Dhaka',
                            'display_name' => implode(', ', array_filter([$p['name'] ?? null, $p['street'] ?? null, $p['locality'] ?? null, $p['district'] ?? null, $p['city'] ?? null])),
                        ];
                    }
                }
            } catch (\Throwable $e) {}

            return [
                'lat' => $lat,
                'lng' => $lng,
                'house' => '',
                'road' => '',
                'area' => '',
                'city' => 'Dhaka',
                'display_name' => "Location at {$lat}, {$lng}",
            ];
        });

        return response()->json($result);
    }
}
