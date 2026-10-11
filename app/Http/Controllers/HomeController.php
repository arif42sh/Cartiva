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
        // If search looks like a group code (e.g. GRP-...), check and redirect to the room
        if ($request->filled('q')) {
            $searchQuery = trim($request->input('q'));
            if (str_starts_with(strtoupper($searchQuery), 'GRP-')) {
                $matchedGroup = GroupBuySession::where('group_code', strtoupper($searchQuery))->first();
                if ($matchedGroup) {
                    return redirect()->route('group-buy.show', $matchedGroup);
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
            $query->whereHas('category', function ($sub) use ($request) {
                $sub->where('slug', $request->input('category'));
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

        // 2. Ending Soon & Rush Hour Pools (Urgency Section)
        $urgentGroups = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->orderBy('expires_at', 'asc')
            ->take(4)
            ->get();

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

    public function category(Category $category)
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with(['category', 'seller'])
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        $activeGroups = GroupBuySession::with(['product', 'leader', 'members.user'])
            ->whereHas('product', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            })
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->orderBy('expires_at', 'asc')
            ->take(6)
            ->get();

        $almostCompletedGroups = $activeGroups->take(4);
        $todayDeals = $products->take(4);
        $flashDeals = $products->take(4);
        $popularGroupBuys = $products->take(8);
        $newArrivals = $products->take(8);
        $recommendedDeals = $products->take(6);

        $stats = [
            'completed_groups' => 1450 + GroupBuySession::where('status', 'completed')->count(),
            'total_saved' => 2850000,
            'verified_sellers' => 120 + User::where('role', 'seller')->count(),
            'active_buyers' => 5800 + User::count(),
        ];

        $spotlightGroup = $activeGroups->first();
        $urgentGroups = $almostCompletedGroups;

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
            'category', 
            'stats'
        ));
    }
}
