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

        // Ending Soon & Hot Groups (ordered by closest deadline and high slot fill)
        $activeGroups = GroupBuySession::with(['product', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->orderBy('expires_at', 'asc')
            ->take(6)
            ->get();

        // Top trending deals (highest discount percentage)
        $trendingDeals = Product::where('is_active', true)
            ->orderByRaw('((single_price - group_price) / single_price) DESC')
            ->take(4)
            ->get();

        // Real-Time Social Proof Stats
        $stats = [
            'completed_groups' => 1450 + GroupBuySession::where('status', 'completed')->count(),
            'total_saved' => 2850000 + (int) GroupBuySession::count() * 1250,
            'verified_sellers' => 120 + User::where('role', 'seller')->count(),
        ];

        return view('index', compact('categories', 'products', 'activeGroups', 'trendingDeals', 'stats'));
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

        $trendingDeals = collect();

        $stats = [
            'completed_groups' => 1450 + GroupBuySession::where('status', 'completed')->count(),
            'total_saved' => 2850000,
            'verified_sellers' => 120 + User::where('role', 'seller')->count(),
        ];

        return view('index', compact('categories', 'products', 'activeGroups', 'trendingDeals', 'category', 'stats'));
    }
}
