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

        $query = Product::with(['category', 'seller', 'activeGroupSessions.members.user'])
            ->marketplaceVisible();

        // Search filter
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas('category', function ($catSub) use ($q) {
                        $catSub->where('name', 'like', "%{$q}%")
                               ->orWhere('slug', 'like', "%{$q}%");
                    })
                    ->orWhereHas('seller', function ($selSub) use ($q) {
                        $selSub->where('name', 'like', "%{$q}%");
                    });
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
                } elseif ($catSlug === 'computing-gaming' || $catSlug === 'computers-accessories') {
                    $sub->whereIn('slug', ['computing-gaming', 'computers-accessories']);
                } elseif (in_array($catSlug, ['fashion-wearables', 'winter-specials', 'fashion-bags'])) {
                    $sub->whereIn('slug', ['fashion-wearables', 'winter-specials', 'fashion-bags']);
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
            ->orderByRaw('(SELECT COALESCE(is_hot_deal, 0) FROM products WHERE products.id = group_buy_sessions.product_id) DESC')
            ->orderByRaw('(current_members / required_members) DESC')
            ->orderBy('expires_at', 'asc')
            ->take(12)
            ->get();

        // 3. Active Groups List (Group Pools Core Section)
        $activeGroupsQuery = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members');

        if ($request->filled('q')) {
            $searchQ = $request->input('q');
            $activeGroupsQuery->where(function ($sub) use ($searchQ) {
                $sub->where('group_code', 'like', "%{$searchQ}%")
                    ->orWhereHas('product', function ($p) use ($searchQ) {
                        $p->where('title', 'like', "%{$searchQ}%");
                    });
            });
        }

        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $activeGroupsQuery->whereHas('product.category', function ($sub) use ($catSlug) {
                if ($catSlug === 'smart-tech-audio' || $catSlug === 'tech-accessories') {
                    $sub->whereIn('slug', ['smart-tech-audio', 'tech-accessories']);
                } elseif ($catSlug === 'home-living' || $catSlug === 'home-lifestyle') {
                    $sub->whereIn('slug', ['home-living', 'home-lifestyle']);
                } elseif ($catSlug === 'computing-gaming' || $catSlug === 'computers-accessories') {
                    $sub->whereIn('slug', ['computing-gaming', 'computers-accessories']);
                } elseif (in_array($catSlug, ['fashion-wearables', 'winter-specials', 'fashion-bags'])) {
                    $sub->whereIn('slug', ['fashion-wearables', 'winter-specials', 'fashion-bags']);
                } else {
                    $sub->where('slug', $catSlug);
                }
            });
        }

        $activeGroups = $activeGroupsQuery->latest()->take(24)->get();

        if (!$spotlightGroup) {
            $spotlightGroup = $activeGroups->first();
        }

        $almostCompletedGroups = $urgentGroups;
        $todayDeals = Product::with(['category', 'seller', 'activeGroupSessions'])->where('is_active', true)->orderBy('sales_count', 'desc')->take(4)->get();
        $flashDeals = Product::with(['category', 'seller', 'activeGroupSessions'])
            ->where('is_active', true)
            ->orderBy('is_flash_sale', 'desc')
            ->orderByRaw('((single_price - group_price) / single_price) DESC')
            ->take(12)
            ->get();
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
        } elseif (in_array($category->slug, ['computing-gaming', 'computers-accessories'])) {
            $related = Category::whereIn('slug', ['computing-gaming', 'computers-accessories'])->pluck('id')->toArray();
            $categoryIds = array_unique(array_merge($categoryIds, $related));
        } elseif (in_array($category->slug, ['fashion-wearables', 'winter-specials', 'fashion-bags'])) {
            $related = Category::whereIn('slug', ['fashion-wearables', 'winter-specials', 'fashion-bags'])->pluck('id')->toArray();
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

    public function categoriesIndex(Request $request)
    {
        $selectedCategorySlug = $request->input('category', 'all');
        $buyingMode = $request->input('buying_mode', 'all'); // 'all', 'direct', 'group'
        $pricePreset = $request->input('price');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minDiscount = $request->input('min_discount');
        $searchQ = $request->input('q');
        $sort = $request->input('sort', 'latest');

        $categories = Category::withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $selectedCategoryModel = null;
        if ($selectedCategorySlug !== 'all') {
            $selectedCategoryModel = Category::where('slug', $selectedCategorySlug)->first();
        }

        $productsQuery = Product::with(['category', 'seller', 'activeGroupSessions.members.user'])
            ->where('is_active', true);

        // Search Filter
        if ($request->filled('q')) {
            $q = trim($searchQ);
            $productsQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Category Filter
        if ($selectedCategorySlug !== 'all') {
            $productsQuery->whereHas('category', function ($sub) use ($selectedCategorySlug) {
                if ($selectedCategorySlug === 'smart-tech-audio' || $selectedCategorySlug === 'tech-accessories') {
                    $sub->whereIn('slug', ['smart-tech-audio', 'tech-accessories']);
                } elseif ($selectedCategorySlug === 'home-living' || $selectedCategorySlug === 'home-lifestyle') {
                    $sub->whereIn('slug', ['home-living', 'home-lifestyle']);
                } elseif ($selectedCategorySlug === 'computing-gaming' || $selectedCategorySlug === 'computers-accessories') {
                    $sub->whereIn('slug', ['computing-gaming', 'computers-accessories']);
                } elseif (in_array($selectedCategorySlug, ['fashion-wearables', 'winter-specials', 'fashion-bags'])) {
                    $sub->whereIn('slug', ['fashion-wearables', 'winter-specials', 'fashion-bags']);
                } else {
                    $sub->where('slug', $selectedCategorySlug);
                }
            });
        }

        // Buying Mode Preference Filter
        if ($buyingMode === 'group') {
            $productsQuery->whereHas('activeGroupSessions', function ($q) {
                $q->where('status', 'active')->where('expires_at', '>', now());
            });
        } elseif ($buyingMode === 'direct') {
            $productsQuery->whereDoesntHave('activeGroupSessions', function ($q) {
                $q->where('status', 'active')->where('expires_at', '>', now());
            });
        }

        // Price Filter
        if ($pricePreset) {
            if ($pricePreset === 'under_1000') {
                $productsQuery->where('group_price', '<', 1000);
            } elseif ($pricePreset === '1000_3000') {
                $productsQuery->whereBetween('group_price', [1000, 3000]);
            } elseif ($pricePreset === '3000_7000') {
                $productsQuery->whereBetween('group_price', [3000, 7000]);
            } elseif ($pricePreset === 'above_7000') {
                $productsQuery->where('group_price', '>', 7000);
            }
        } else {
            if ($request->filled('min_price')) {
                $productsQuery->where('group_price', '>=', (float) $minPrice);
            }
            if ($request->filled('max_price')) {
                $productsQuery->where('group_price', '<=', (float) $maxPrice);
            }
        }

        // Minimum Discount Filter
        if ($request->filled('min_discount')) {
            $discVal = (int) $minDiscount;
            $productsQuery->whereRaw('ROUND(((single_price - group_price) / single_price) * 100) >= ?', [$discVal]);
        }

        // Sorting
        switch ($sort) {
            case 'discount':
                $productsQuery->orderByRaw('((single_price - group_price) / single_price) DESC');
                break;
            case 'price_low':
                $productsQuery->orderBy('group_price', 'asc');
                break;
            case 'price_high':
                $productsQuery->orderBy('group_price', 'desc');
                break;
            case 'popular':
                $productsQuery->orderBy('sales_count', 'desc');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->paginate(20)->withQueryString();

        $totalProductsCount = Product::where('is_active', true)->count();

        return view('categories.index', compact(
            'categories',
            'products',
            'selectedCategorySlug',
            'selectedCategoryModel',
            'buyingMode',
            'pricePreset',
            'minPrice',
            'maxPrice',
            'minDiscount',
            'searchQ',
            'sort',
            'totalProductsCount'
        ));
    }

    public function hotDeals(Request $request)
    {
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $query = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members');

        // 1. Category Filter
        $selectedCategory = $request->input('category');
        if ($request->filled('category') && $selectedCategory !== 'all') {
            $query->whereHas('product.category', function ($q) use ($selectedCategory) {
                if (in_array($selectedCategory, ['smart-tech-audio', 'tech-accessories'])) {
                    $q->whereIn('slug', ['smart-tech-audio', 'tech-accessories']);
                } elseif (in_array($selectedCategory, ['home-living', 'home-lifestyle'])) {
                    $q->whereIn('slug', ['home-living', 'home-lifestyle']);
                } else {
                    $q->where('slug', $selectedCategory);
                }
            });
        }

        // 2. Pool Urgency / Status Filter
        $filter = $request->input('filter', 'all');
        if ($filter === '1_slot') {
            $query->whereRaw('(required_members - current_members) = 1');
        } elseif ($filter === 'ending_today') {
            $query->where('expires_at', '<=', now()->addHours(12));
        }

        // 3. Price Filter (Preset or Custom Min/Max)
        $pricePreset = $request->input('price_range');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if ($pricePreset) {
            if ($pricePreset === 'under_1000') {
                $query->whereHas('product', fn($q) => $q->where('group_price', '<', 1000));
            } elseif ($pricePreset === '1000_3000') {
                $query->whereHas('product', fn($q) => $q->whereBetween('group_price', [1000, 3000]));
            } elseif ($pricePreset === '3000_7000') {
                $query->whereHas('product', fn($q) => $q->whereBetween('group_price', [3000, 7000]));
            } elseif ($pricePreset === 'above_7000') {
                $query->whereHas('product', fn($q) => $q->where('group_price', '>', 7000));
            }
        } else {
            if ($request->filled('min_price')) {
                $query->whereHas('product', fn($q) => $q->where('group_price', '>=', (float) $minPrice));
            }
            if ($request->filled('max_price')) {
                $query->whereHas('product', fn($q) => $q->where('group_price', '<=', (float) $maxPrice));
            }
        }

        // 4. Minimum Discount Filter
        $minDiscount = $request->input('min_discount');
        if ($request->filled('min_discount')) {
            $discVal = (int) $minDiscount;
            $query->whereHas('product', function ($q) use ($discVal) {
                $q->whereRaw('ROUND(((single_price - group_price) / single_price) * 100) >= ?', [$discVal]);
            });
        }

        // 5. Search Query
        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->whereHas('product', function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // 6. Sorting
        $sort = $request->input('sort', 'urgency');
        if ($sort === 'discount') {
            $query->join('products as p_sort', 'group_buy_sessions.product_id', '=', 'p_sort.id')
                  ->orderByRaw('((p_sort.single_price - p_sort.group_price) / p_sort.single_price) DESC')
                  ->select('group_buy_sessions.*');
        } elseif ($sort === 'price_low') {
            $query->join('products as p_sort', 'group_buy_sessions.product_id', '=', 'p_sort.id')
                  ->orderBy('p_sort.group_price', 'asc')
                  ->select('group_buy_sessions.*');
        } elseif ($sort === 'price_high') {
            $query->join('products as p_sort', 'group_buy_sessions.product_id', '=', 'p_sort.id')
                  ->orderBy('p_sort.group_price', 'desc')
                  ->select('group_buy_sessions.*');
        } elseif ($sort === 'most_filled') {
            $query->orderByRaw('(current_members / required_members) DESC');
        } elseif ($sort === 'latest') {
            $query->latest();
        } else {
            // Default: highest percent filled first, then soonest expiry
            $query->orderByRaw('(current_members / required_members) DESC')
                  ->orderBy('expires_at', 'asc');
        }

        $hotGroups = $query->paginate(15)->withQueryString();

        return view('hot-deals', compact(
            'hotGroups', 
            'categories', 
            'filter', 
            'sort', 
            'selectedCategory', 
            'pricePreset', 
            'minPrice', 
            'maxPrice', 
            'minDiscount'
        ));
    }

    /**
     * Dedicated Group Pools Social Commerce Interface
     */
    public function groupPools(Request $request)
    {
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $query = GroupBuySession::with(['product.category', 'leader', 'members.user'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members');

        // 1. Category Filter
        $selectedCategory = $request->input('category');
        if ($request->filled('category') && $selectedCategory !== 'all') {
            $query->whereHas('product.category', function ($q) use ($selectedCategory) {
                if (in_array($selectedCategory, ['smart-tech-audio', 'tech-accessories'])) {
                    $q->whereIn('slug', ['smart-tech-audio', 'tech-accessories']);
                } elseif (in_array($selectedCategory, ['home-living', 'home-lifestyle'])) {
                    $q->whereIn('slug', ['home-living', 'home-lifestyle']);
                } else {
                    $q->where('slug', $selectedCategory);
                }
            });
        }

        // 2. Pool Urgency / Status Filter
        $filter = $request->input('filter', 'all');
        if ($filter === '1_slot') {
            $query->whereRaw('(required_members - current_members) = 1');
        } elseif ($filter === 'ending_soon') {
            $query->where('expires_at', '<=', now()->addHours(6));
        } elseif ($filter === '40_percent') {
            $query->whereHas('product', function ($q) {
                $q->whereRaw('ROUND(((single_price - group_price) / single_price) * 100) >= 40');
            });
        } elseif ($filter === 'winter') {
            $query->whereHas('product', function ($q) {
                $q->where('title', 'like', '%winter%')
                  ->orWhere('title', 'like', '%fleece%')
                  ->orWhereHas('category', fn($c) => $c->where('slug', 'winter-specials'));
            });
        } elseif ($filter === 'tech') {
            $query->whereHas('product', function ($q) {
                $q->where('title', 'like', '%anc%')
                  ->orWhere('title', 'like', '%earbuds%')
                  ->orWhere('title', 'like', '%keyboard%')
                  ->orWhereHas('category', fn($c) => $c->whereIn('slug', ['smart-tech-audio', 'tech-accessories']));
            });
        }

        // 3. Price Filter (Preset or Custom Min/Max)
        $pricePreset = $request->input('price_range');
        if ($pricePreset) {
            if ($pricePreset === 'under_1000') {
                $query->whereHas('product', fn($q) => $q->where('group_price', '<', 1000));
            } elseif ($pricePreset === '1000_3000') {
                $query->whereHas('product', fn($q) => $q->whereBetween('group_price', [1000, 3000]));
            } elseif ($pricePreset === '3000_7000') {
                $query->whereHas('product', fn($q) => $q->whereBetween('group_price', [3000, 7000]));
            } elseif ($pricePreset === 'above_7000') {
                $query->whereHas('product', fn($q) => $q->where('group_price', '>', 7000));
            }
        }

        // 4. Search Query
        if ($request->filled('q')) {
            $keyword = trim($request->input('q'));
            $query->where(function ($sub) use ($keyword) {
                $sub->where('group_code', 'like', "%{$keyword}%")
                    ->orWhereHas('product', function ($p) use ($keyword) {
                        $p->where('title', 'like', "%{$keyword}%")
                          ->orWhere('description', 'like', "%{$keyword}%");
                    });
            });
        }

        // 5. Sorting
        $sort = $request->input('sort', 'urgency');
        if ($sort === 'discount') {
            $query->join('products as p_sort', 'group_buy_sessions.product_id', '=', 'p_sort.id')
                  ->orderByRaw('((p_sort.single_price - p_sort.group_price) / p_sort.single_price) DESC')
                  ->select('group_buy_sessions.*');
        } elseif ($sort === 'price_low') {
            $query->join('products as p_sort', 'group_buy_sessions.product_id', '=', 'p_sort.id')
                  ->orderBy('p_sort.group_price', 'asc')
                  ->select('group_buy_sessions.*');
        } elseif ($sort === 'price_high') {
            $query->join('products as p_sort', 'group_buy_sessions.product_id', '=', 'p_sort.id')
                  ->orderBy('p_sort.group_price', 'desc')
                  ->select('group_buy_sessions.*');
        } elseif ($sort === 'most_filled') {
            $query->orderByRaw('(current_members / required_members) DESC');
        } elseif ($sort === 'latest') {
            $query->latest();
        } else {
            // Default: Most urgent first
            $query->orderByRaw('(current_members / required_members) DESC')
                  ->orderBy('expires_at', 'asc');
        }

        $pools = $query->paginate(20)->withQueryString();

        // Platform Real-Time Stats
        $stats = [
            'active_pools_count' => GroupBuySession::where('status', 'active')->where('expires_at', '>', now())->whereColumn('current_members', '<', 'required_members')->count(),
            'almost_full_count' => GroupBuySession::where('status', 'active')->where('expires_at', '>', now())->whereRaw('(required_members - current_members) = 1')->count(),
            'total_saved_bdt' => 2850000 + (GroupBuySession::where('status', 'completed')->count() * 1450),
            'verified_buyers_today' => 64 + rand(4, 15),
        ];

        return view('group-pools.index', compact(
            'pools',
            'categories',
            'filter',
            'sort',
            'selectedCategory',
            'pricePreset',
            'stats'
        ));
    }

    /**
     * Dedicated Flash Sales Rush Interface
     */
    public function flashSales(Request $request)
    {
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        // 1. Time Slots Definition
        $timeSlots = [
            [
                'id' => 'ended',
                'time' => '10:00 AM',
                'label' => 'Past Drop',
                'subtext' => 'Ended',
                'status' => 'ended',
                'is_live' => false,
                'is_upcoming' => false,
                'is_ended' => true,
                'unlock_time' => '10:00 AM',
                'badge' => 'ENDED',
            ],
            [
                'id' => 'live',
                'time' => '02:00 PM',
                'label' => 'LIVE NOW',
                'subtext' => 'Ends in 03:42:18',
                'status' => 'live',
                'is_live' => true,
                'is_upcoming' => false,
                'is_ended' => false,
                'unlock_time' => '02:00 PM',
                'badge' => 'ACTIVE DROP',
            ],
            [
                'id' => 'upcoming_1',
                'time' => '06:00 PM',
                'label' => 'Starts in 4h',
                'subtext' => 'Set Alert',
                'status' => 'upcoming',
                'is_live' => false,
                'is_upcoming' => true,
                'is_ended' => false,
                'unlock_time' => '06:00 PM',
                'badge' => 'UPCOMING',
            ],
            [
                'id' => 'upcoming_2',
                'time' => '10:00 PM',
                'label' => 'Night Rush',
                'subtext' => 'Midnight Drop',
                'status' => 'upcoming',
                'is_live' => false,
                'is_upcoming' => true,
                'is_ended' => false,
                'unlock_time' => '10:00 PM',
                'badge' => 'NIGHT RUSH',
            ],
        ];

        // 2. Fetch active products from DB or fallback mock array
        $dbProducts = Product::with(['category', 'seller', 'activeGroupSessions'])
            ->where('is_active', true)
            ->orderBy('is_flash_sale', 'desc')
            ->orderByRaw('((single_price - group_price) / single_price) DESC')
            ->get();

        $enrichedDeals = [];
        $slotDistribution = [
            'live', 'live', 'live', 'live', 'live', 
            'live', 'live', 'live', 'live', 'live',
            'upcoming_1', 'upcoming_1', 'upcoming_1', 'upcoming_1', 'upcoming_1', 
            'upcoming_2', 'upcoming_2', 'upcoming_2', 'upcoming_2', 'upcoming_2',
            'ended', 'ended', 'ended', 'ended', 'ended'
        ];

        if ($dbProducts->isNotEmpty()) {
            foreach ($dbProducts as $index => $product) {
                // If product is specifically enrolled in Flash Sales by merchant/admin, guarantee it goes to 'live' slot
                $slotId = $product->is_flash_sale ? 'live' : $slotDistribution[$index % count($slotDistribution)];
                
                // Deterministic high-conversion flash discount (38% to 68%)
                $discountPct = intval(38 + (($product->id * 7) % 31));
                $flashPrice = round($product->single_price * (1 - ($discountPct / 100)));
                $savingsAmount = round($product->single_price - $flashPrice);
                
                // Collective pool extra savings
                $poolPrice = $product->group_price > 0 ? $product->group_price : round($flashPrice * 0.88);
                $poolExtraSavings = max(80, round($flashPrice - $poolPrice));
                if ($poolExtraSavings <= 0) {
                    $poolExtraSavings = max(100, round($flashPrice * 0.12));
                    $poolPrice = max(50, $flashPrice - $poolExtraSavings);
                }

                // Stock claiming urgency
                $claimedPct = intval(65 + (($product->id * 9) % 28)); // 65% to 93%
                $stockLeft = max(1, min(8, intval((100 - $claimedPct) / 3)));
                if ($slotId === 'ended') {
                    $claimedPct = 100;
                    $stockLeft = 0;
                }

                $claimedCount = max(85, intval(($product->sales_count * 2) + (($product->id * 23) % 90)));

                $unlockTime = '02:00 PM';
                if ($slotId === 'upcoming_1') $unlockTime = '06:00 PM';
                elseif ($slotId === 'upcoming_2') $unlockTime = '10:00 PM';
                elseif ($slotId === 'ended') $unlockTime = '10:00 AM';

                $rawCat = $product->category->name ?? 'General';
                $cleanCat = trim(preg_replace('/\(.*?\)/', '', $rawCat));
                $catSlug = $product->category->slug ?? 'gadgets';

                $remainingSecs = max(1800, (2 * 3600) + (($product->id * 437) % 10800));
                $roomCode = 'GRP-' . strtoupper(substr(str_replace('-', '', $product->slug), 0, 6));
                $joinedCount = ($product->id % 2 === 0) ? 2 : 1;
                $requiredCount = ($product->id % 2 === 0) ? 3 : 2;

                $enrichedDeals[] = [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'image_url' => $product->image_url,
                    'category_name' => $cleanCat,
                    'category_slug' => $catSlug,
                    'single_price' => (float)$product->single_price,
                    'flash_price' => (float)$flashPrice,
                    'discount_percent' => $discountPct,
                    'savings_amount' => (float)$savingsAmount,
                    'pool_price' => (float)$poolPrice,
                    'pool_extra_savings' => (float)$poolExtraSavings,
                    'rating' => (float)($product->rating ?: 4.8),
                    'sales_count' => (int)($product->sales_count ?: 45),
                    'claimed_count' => $claimedCount,
                    'claimed_percent' => $claimedPct,
                    'stock_left' => $stockLeft,
                    'is_almost_sold_out' => ($stockLeft <= 2),
                    'is_deep_discount' => ($discountPct >= 50),
                    'is_under_999' => ($flashPrice < 1000),
                    'slot_id' => $slotId,
                    'unlock_time' => $unlockTime,
                    'remaining_secs' => $remainingSecs,
                    'room_code' => $roomCode,
                    'joined_count' => $joinedCount,
                    'required_count' => $requiredCount,
                ];
            }
        } else {
            // Standalone Mock Dataset for instant out-of-the-box rendering/testing
            $mockItems = [
                [
                    'id' => 101,
                    'title' => 'SoundCore Ultra ANC Wireless Studio Headphones',
                    'slug' => 'soundcore-ultra-anc-wireless',
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
                    'category_name' => 'Gadgets & Audio',
                    'category_slug' => 'gadgets',
                    'single_price' => 4500,
                    'flash_price' => 1990,
                    'discount_percent' => 56,
                    'savings_amount' => 2510,
                    'pool_price' => 1840,
                    'pool_extra_savings' => 150,
                    'rating' => 4.9,
                    'sales_count' => 140,
                    'claimed_count' => 182,
                    'claimed_percent' => 88,
                    'stock_left' => 4,
                    'is_almost_sold_out' => true,
                    'is_deep_discount' => true,
                    'is_under_999' => false,
                    'slot_id' => 'live',
                    'unlock_time' => '02:00 PM',
                ],
                [
                    'id' => 102,
                    'title' => 'Heavyweight 450 GSM Organic Fleece Winter Drop Hoodie',
                    'slug' => 'heavyweight-fleece-hoodie',
                    'image_url' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80',
                    'category_name' => 'Campus Apparel',
                    'category_slug' => 'apparel',
                    'single_price' => 1850,
                    'flash_price' => 890,
                    'discount_percent' => 52,
                    'savings_amount' => 960,
                    'pool_price' => 740,
                    'pool_extra_savings' => 150,
                    'rating' => 4.95,
                    'sales_count' => 310,
                    'claimed_count' => 264,
                    'claimed_percent' => 92,
                    'stock_left' => 3,
                    'is_almost_sold_out' => true,
                    'is_deep_discount' => true,
                    'is_under_999' => true,
                    'slot_id' => 'live',
                    'unlock_time' => '02:00 PM',
                ],
                [
                    'id' => 103,
                    'title' => '65W GaN III Multiport Super Fast Charging Hub',
                    'slug' => '65w-gan-fast-charger',
                    'image_url' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&q=80',
                    'category_name' => 'Gadgets & Audio',
                    'category_slug' => 'gadgets',
                    'single_price' => 2200,
                    'flash_price' => 980,
                    'discount_percent' => 55,
                    'savings_amount' => 1220,
                    'pool_price' => 830,
                    'pool_extra_savings' => 150,
                    'rating' => 4.85,
                    'sales_count' => 95,
                    'claimed_count' => 110,
                    'claimed_percent' => 74,
                    'stock_left' => 8,
                    'is_almost_sold_out' => false,
                    'is_deep_discount' => true,
                    'is_under_999' => true,
                    'slot_id' => 'live',
                    'unlock_time' => '02:00 PM',
                ],
                [
                    'id' => 104,
                    'title' => 'AeroFit Pro Wireless Sport Earbuds with BassBoost',
                    'slug' => 'aerofit-pro-wireless-earbuds',
                    'image_url' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80',
                    'category_name' => 'Gadgets & Audio',
                    'category_slug' => 'gadgets',
                    'single_price' => 3250,
                    'flash_price' => 1490,
                    'discount_percent' => 54,
                    'savings_amount' => 1760,
                    'pool_price' => 1340,
                    'pool_extra_savings' => 150,
                    'rating' => 4.88,
                    'sales_count' => 220,
                    'claimed_count' => 195,
                    'claimed_percent' => 85,
                    'stock_left' => 5,
                    'is_almost_sold_out' => true,
                    'is_deep_discount' => true,
                    'is_under_999' => false,
                    'slot_id' => 'live',
                    'unlock_time' => '02:00 PM',
                ],
                [
                    'id' => 105,
                    'title' => 'CyberBeast RGB 75% Mechanical Hot-Swap Keyboard',
                    'slug' => 'cyberbeast-rgb-mechanical-keyboard',
                    'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',
                    'category_name' => 'Gadgets & Audio',
                    'category_slug' => 'gadgets',
                    'single_price' => 4800,
                    'flash_price' => 2350,
                    'discount_percent' => 51,
                    'savings_amount' => 2450,
                    'pool_price' => 2150,
                    'pool_extra_savings' => 200,
                    'rating' => 4.92,
                    'sales_count' => 88,
                    'claimed_count' => 0,
                    'claimed_percent' => 0,
                    'stock_left' => 25,
                    'is_almost_sold_out' => false,
                    'is_deep_discount' => true,
                    'is_under_999' => false,
                    'slot_id' => 'upcoming_1',
                    'unlock_time' => '06:00 PM',
                ],
                [
                    'id' => 106,
                    'title' => 'Minimalist Water-Resistant Commuter Laptop Backpack 25L',
                    'slug' => 'minimalist-laptop-backpack',
                    'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&q=80',
                    'category_name' => 'Campus Apparel',
                    'category_slug' => 'apparel',
                    'single_price' => 2400,
                    'flash_price' => 950,
                    'discount_percent' => 60,
                    'savings_amount' => 1450,
                    'pool_price' => 820,
                    'pool_extra_savings' => 130,
                    'rating' => 4.86,
                    'sales_count' => 175,
                    'claimed_count' => 0,
                    'claimed_percent' => 0,
                    'stock_left' => 30,
                    'is_almost_sold_out' => false,
                    'is_deep_discount' => true,
                    'is_under_999' => true,
                    'slot_id' => 'upcoming_1',
                    'unlock_time' => '06:00 PM',
                ],
                [
                    'id' => 107,
                    'title' => '1.96-inch AMOLED IP68 Bluetooth Calling Smartwatch',
                    'slug' => 'amoled-smartwatch-ip68',
                    'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80',
                    'category_name' => 'Gadgets & Audio',
                    'category_slug' => 'gadgets',
                    'single_price' => 3990,
                    'flash_price' => 1890,
                    'discount_percent' => 53,
                    'savings_amount' => 2100,
                    'pool_price' => 1690,
                    'pool_extra_savings' => 200,
                    'rating' => 4.79,
                    'sales_count' => 130,
                    'claimed_count' => 0,
                    'claimed_percent' => 0,
                    'stock_left' => 18,
                    'is_almost_sold_out' => false,
                    'is_deep_discount' => true,
                    'is_under_999' => false,
                    'slot_id' => 'upcoming_2',
                    'unlock_time' => '10:00 PM',
                ],
                [
                    'id' => 108,
                    'title' => 'Compact 1500W Rapid Air Fryer with Digital Preset Menu',
                    'slug' => 'compact-rapid-air-fryer',
                    'image_url' => 'https://images.unsplash.com/photo-1585670149967-b4f4da88cc9f?w=800&q=80',
                    'category_name' => 'Lifestyle & Home',
                    'category_slug' => 'home',
                    'single_price' => 6500,
                    'flash_price' => 3200,
                    'discount_percent' => 51,
                    'savings_amount' => 3300,
                    'pool_price' => 2950,
                    'pool_extra_savings' => 250,
                    'rating' => 4.91,
                    'sales_count' => 60,
                    'claimed_count' => 50,
                    'claimed_percent' => 100,
                    'stock_left' => 0,
                    'is_almost_sold_out' => false,
                    'is_deep_discount' => true,
                    'is_under_999' => false,
                    'slot_id' => 'ended',
                    'unlock_time' => '10:00 AM',
                ],
            ];
            $enrichedDeals = $mockItems;
        }

        $selectedSlot = $request->input('slot', 'live');
        $validSlotIds = array_column($timeSlots, 'id');
        if (!in_array($selectedSlot, $validSlotIds)) {
            $selectedSlot = 'live';
        }

        return view('flash-sales.index', compact(
            'timeSlots',
            'enrichedDeals',
            'categories',
            'selectedSlot'
        ));
    }

    /**
     * Public Merchant Storefront Page
     */
    public function shop($seller, Request $request = null)
    {
        $request = $request ?? request();

        if ($seller instanceof User) {
            $sellerModel = $seller;
        } elseif (is_numeric($seller)) {
            $sellerModel = User::find($seller);
        } else {
            $sellerModel = User::where('shop_slug', $seller)->first()
                ?? User::where('id', $seller)->first();

            if (!$sellerModel) {
                $slugClean = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', (string) $seller));
                $sellers = User::where('role', 'seller')->get();
                $sellerModel = $sellers->first(function ($u) use ($slugClean, $seller) {
                    $uClean = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', (string) ($u->shop_name ?? $u->name)));
                    return $uClean === $slugClean || \Illuminate\Support\Str::slug($u->shop_name ?? $u->name) === $seller;
                });
            }
        }

        if (!$sellerModel || (!$sellerModel->isSeller() && $sellerModel->products()->count() === 0)) {
            abort(404, 'Merchant storefront not found.');
        }

        $seller = $sellerModel;

        $sellerProductIds = Product::where('seller_id', $seller->id)->pluck('id');

        $query = Product::where('seller_id', $seller->id)
            ->where('is_active', true)
            ->with(['category', 'activeGroupSessions.members.user']);

        // Search within shop
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::whereHas('products', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id)->where('is_active', true);
        })->get();

        // Active ongoing circles for this shop's items
        $activeCircles = GroupBuySession::with(['product', 'leader', 'members.user'])
            ->whereIn('product_id', $sellerProductIds)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->latest()
            ->take(4)
            ->get();

        $totalProductsCount = Product::where('seller_id', $seller->id)->where('is_active', true)->count();
        $totalSalesCount = Product::where('seller_id', $seller->id)->sum('sales_count') ?: 150;
        $avgRating = Product::where('seller_id', $seller->id)->avg('rating') ?: 4.9;

        return view('shop.show', compact(
            'seller',
            'products',
            'categories',
            'activeCircles',
            'totalProductsCount',
            'totalSalesCount',
            'avgRating'
        ));
    }
}
