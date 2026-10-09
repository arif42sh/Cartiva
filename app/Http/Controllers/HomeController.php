<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GroupBuySession;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
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

        // Active Group Buys with slots open
        $activeGroups = GroupBuySession::with(['product', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->latest()
            ->take(6)
            ->get();

        // Top trending deals (highest discount)
        $trendingDeals = Product::where('is_active', true)
            ->orderByRaw('((single_price - group_price) / single_price) DESC')
            ->take(4)
            ->get();

        return view('index', compact('categories', 'products', 'activeGroups', 'trendingDeals'));
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
            ->latest()
            ->take(6)
            ->get();

        $trendingDeals = collect();

        return view('index', compact('categories', 'products', 'activeGroups', 'trendingDeals', 'category'));
    }
}
