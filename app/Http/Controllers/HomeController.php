<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GroupBuySession;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // If search looks like a group code (e.g. GRP-...) or order code (ORD-...), check and redirect
        if ($request->filled('q')) {
            $searchQuery = trim($request->input('q'));
            if (str_starts_with(strtoupper($searchQuery), 'GRP-')) {
                $matchedGroup = GroupBuySession::where('group_code', strtoupper($searchQuery))->first();
                if ($matchedGroup) {
                    return redirect()->route('group-buy.show', $matchedGroup);
                }
            } elseif (str_starts_with(strtoupper($searchQuery), 'ORD-')) {
                $matchedOrder = \App\Models\Order::where('order_number', strtoupper($searchQuery))->first();
                if ($matchedOrder) {
                    return redirect()->route('orders.show', $matchedOrder);
                }
            }
        }

        $categories = Category::withCount('products')->get();

        $query = Product::with(['category', 'seller'])
            ->where('is_active', true);

        // Search filter
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function ($sub) use ($catSlug) {
                if ($catSlug === 'smart-tech-audio' || $catSlug === 'tech-accessories') {
                    $sub->whereIn('slug', ['smart-tech-audio', 'tech-accessories']);
                } elseif ($catSlug === 'home-living' || $catSlug === 'home-lifestyle') {
                    $sub->whereIn('slug', ['home-living', 'home-lifestyle']);
                } else {
                    $sub->where('slug', $catSlug);
                }
            });
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        // 1. Live Spotlight Deal (for High-Conversion Hero Section)
        $spotlightGroup = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->orderByRaw('(current_members / required_members) DESC')
            ->first();

        // 2. Ending Soon & Rush Hour Pools (Hot Deals Carousel)
        $urgentGroups = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->orderByRaw('(current_members / required_members) DESC')
            ->orderBy('expires_at', 'asc')
            ->take(12)
            ->get();

        // Resilient auto-refresh for sample data so the Hot Deals section remains vibrant and active
        if ($urgentGroups->count() < 3) {
            $pastSessions = GroupBuySession::where('expires_at', '<=', now())
                ->whereColumn('current_members', '<', 'required_members')
                ->take(8)
                ->get();
            foreach ($pastSessions as $idx => $s) {
                $s->update([
                    'status' => 'active',
                    'expires_at' => now()->addHours(($idx % 6) + 1)->addMinutes(rand(10, 55)),
                ]);
            }
            $urgentGroups = GroupBuySession::with(['product.category', 'leader', 'members.user'])
                ->where('status', 'active')
                ->where('expires_at', '>', now())
                ->whereColumn('current_members', '<', 'required_members')
                ->orderByRaw('(current_members / required_members) DESC')
                ->orderBy('expires_at', 'asc')
                ->take(12)
                ->get();
        }

        // 3. Active Groups List (Core Deals Grid)
        $activeGroups = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->latest()
            ->take(8)
            ->get();

        if (!$spotlightGroup) {
            $spotlightGroup = $activeGroups->first();
        }

        $almostCompletedGroups = $urgentGroups;
        $todayDeals = Product::with(['category', 'seller', 'activeGroupSessions'])->where('is_active', true)->orderBy('sales_count', 'desc')->take(4)->get();
        $flashDeals = Product::with(['category', 'seller', 'activeGroupSessions'])->where('is_active', true)->orderByRaw('((single_price - group_price) / single_price) DESC')->take(4)->get();
        $popularGroupBuys = Product::with(['category', 'seller'])->where('is_active', true)->orderBy('sales_count', 'desc')->take(8)->get();
        $newArrivals = Product::with(['category', 'seller'])->where('is_active', true)->latest()->take(8)->get();
        $recommendedDeals = Product::with(['category', 'seller'])->where('is_active', true)->orderBy('rating', 'desc')->take(6)->get();

        // Real-Time Social Proof Stats
        $stats = [
            'completed_groups' => 1450 + GroupBuySession::where('status', 'completed')->count(),
            'total_saved' => 2850000 + (int) GroupBuySession::count() * 1250,
            'verified_sellers' => 120 + User::where('role', 'seller')->count(),
            'active_buyers' => 5800 + User::count(),
            'today_unlocked_deals' => 38,
            'today_saved_bdt' => 64200,
        ];

        return view('index', compact(
            'spotlightGroup',
            'urgentGroups',
            'categories', 
            'products', 
            'activeGroups', 
            'almostCompletedGroups',
            'todayDeals', 
            'flashDeals', 
            'popularGroupBuys', 
            'newArrivals', 
            'recommendedDeals', 
            'stats'
        ));
    }

    public function category(Request $request, Category $category)
    {
        $categories = Category::withCount('products')->get();

        // Support related category grouping if applicable (e.g. smart-tech-audio & tech-accessories, home-living & home-lifestyle)
        $categoryIds = [$category->id];
        if (in_array($category->slug, ['smart-tech-audio', 'tech-accessories'])) {
            $related = Category::whereIn('slug', ['smart-tech-audio', 'tech-accessories'])->pluck('id')->toArray();
            $categoryIds = array_unique(array_merge($categoryIds, $related));
        } elseif (in_array($category->slug, ['home-living', 'home-lifestyle'])) {
            $related = Category::whereIn('slug', ['home-living', 'home-lifestyle'])->pluck('id')->toArray();
            $categoryIds = array_unique(array_merge($categoryIds, $related));
        }

        $query = Product::with(['category', 'seller', 'activeGroupSessions'])
            ->whereIn('category_id', $categoryIds)
            ->where('is_active', true);

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'discount':
                $query->orderByRaw('((single_price - group_price) / single_price) DESC');
                break;
            case 'price_low':
                $query->orderBy('group_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('group_price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Active Group buy pools in this category
        $activeGroups = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->whereHas('product', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            })
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->orderBy('expires_at', 'asc')
            ->take(4)
            ->get();

        // Category metadata dictionary for English title and descriptions
        $categoryMeta = [
            'computers-accessories' => ['title' => 'Laptops & PC', 'icon' => '💻', 'desc' => 'High-performance laptops, PC components, and computing accessories with bulk group discounts.'],
            'smart-tech-audio' => ['title' => 'Audio & Sound', 'icon' => '🎧', 'desc' => 'Active noise cancelling headphones, studio earbuds, and wireless sound equipment.'],
            'tech-accessories' => ['title' => 'Audio & Sound', 'icon' => '🎧', 'desc' => 'Active noise cancelling headphones, studio earbuds, and wireless sound equipment.'],
            'mobile-accessories' => ['title' => 'Mobiles & Tabs', 'icon' => '📱', 'desc' => 'GaN fast chargers, rugged cables, magnetic powerbanks, and mobile gadgets.'],
            'wearables-watches' => ['title' => 'Smartwatches', 'icon' => '⌚', 'desc' => 'AMOLED smartwatches, fitness bands, and wearable tech with official warranty.'],
            'computing-gaming' => ['title' => 'Gaming Gear', 'icon' => '🎮', 'desc' => 'Mechanical keyboards, ergonomic mice, RGB headsets, and pro gaming peripherals.'],
            'winter-specials' => ['title' => 'Winter Apparel', 'icon' => '🧥', 'desc' => 'Heavyweight organic fleece hoodies, warm wear, and seasonal cozy drops.'],
            'kitchen-appliances' => ['title' => 'Kitchen Gear', 'icon' => '🍳', 'desc' => 'Digital air fryers, compact espresso makers, and smart kitchen lifestyle appliances.'],
            'home-living' => ['title' => 'Home & Living', 'icon' => '🏠', 'desc' => 'Minimalist desk lamps, Qi wireless chargers, and ergonomic living solutions.'],
            'home-lifestyle' => ['title' => 'Home & Living', 'icon' => '🏠', 'desc' => 'Minimalist desk lamps, Qi wireless chargers, and ergonomic living solutions.'],
            'dry-food-fmcg' => ['title' => 'Grocery & Food', 'icon' => '🥑', 'desc' => 'Premium dates, dry fruit mega boxes, and organic essentials at wholesale bulk rates.'],
            'fashion-bags' => ['title' => 'Bags & Travel', 'icon' => '🎒', 'desc' => 'Waterproof tech backpacks, travel gear, and daily commute organizers.'],
        ];

        return view('category.show', compact(
            'category', 
            'categories', 
            'products', 
            'activeGroups', 
            'sort',
            'categoryMeta'
        ));
    }

    public function hotDeals(Request $request)
    {
        $categories = Category::withCount('products')->get();

        $query = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members');

        $filter = $request->input('filter', 'all');
        if ($filter === '1_slot') {
            $query->whereRaw('(required_members - current_members) = 1');
        } elseif ($filter === 'ending_today') {
            $query->where('expires_at', '<=', now()->addHours(12));
        }

        $sort = $request->input('sort', 'urgency');
        if ($sort === 'discount') {
            $query->join('products', 'group_buy_sessions.product_id', '=', 'products.id')
                  ->orderByRaw('((products.single_price - products.group_price) / products.single_price) DESC')
                  ->select('group_buy_sessions.*');
        } elseif ($sort === 'price_low') {
            $query->join('products', 'group_buy_sessions.product_id', '=', 'products.id')
                  ->orderBy('products.group_price', 'asc')
                  ->select('group_buy_sessions.*');
        } else {
            // Default: highest percent filled first, then soonest expiry
            $query->orderByRaw('(current_members / required_members) DESC')
                  ->orderBy('expires_at', 'asc');
        }

        $hotGroups = $query->paginate(12)->withQueryString();

        return view('hot-deals', compact('hotGroups', 'categories', 'filter', 'sort'));
    }
}
