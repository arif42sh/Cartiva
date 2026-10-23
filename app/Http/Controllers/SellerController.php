<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GroupBuyMember;
use App\Models\GroupBuySession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    /**
     * Merchant Performance & Overview Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $sellerId = $user->id;
        $sellerProductIds = Product::where('seller_id', $sellerId)->pluck('id');
        if ($user->isAdmin() && $sellerProductIds->isEmpty()) {
            $sellerProductIds = Product::pluck('id');
        }

        $myProductsCount = $sellerProductIds->count();

        $activeGroupBuys = GroupBuySession::whereIn('product_id', $sellerProductIds)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->count();

        $completedGroupBuys = GroupBuySession::whereIn('product_id', $sellerProductIds)
            ->where('status', 'completed')
            ->count();

        $totalEarnings = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function ($q) {
                $q->whereIn('order_status', ['processing', 'shipped', 'delivered']);
            })
            ->sum('subtotal');

        $pendingOrdersCount = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function ($q) {
                $q->where('order_status', 'processing');
            })
            ->count();

        $shippedOrdersCount = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function ($q) {
                $q->where('order_status', 'shipped');
            })
            ->count();

        $deliveredOrdersCount = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function ($q) {
                $q->where('order_status', 'delivered');
            })
            ->count();

        $lowStockCount = Product::whereIn('id', $sellerProductIds)
            ->where('stock', '<=', 5)
            ->count();

        $recentSales = OrderItem::with(['order.user', 'product'])
            ->whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function ($q) {
                $q->whereIn('order_status', ['processing', 'shipped', 'delivered']);
            })
            ->latest()
            ->take(6)
            ->get();

        $activeGroups = GroupBuySession::with(['product', 'leader', 'members.user'])
            ->whereIn('product_id', $sellerProductIds)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->latest()
            ->take(4)
            ->get();

        return view('seller.dashboard', compact(
            'myProductsCount',
            'activeGroupBuys',
            'completedGroupBuys',
            'totalEarnings',
            'pendingOrdersCount',
            'shippedOrdersCount',
            'deliveredOrdersCount',
            'lowStockCount',
            'recentSales',
            'activeGroups'
        ));
    }

    /**
     * Product Inventory & Pricing List
     */
    public function products(Request $request)
    {
        $user = Auth::user();
        $sellerId = $user->id;
        $query = Product::with('category');
        if (!$user->isAdmin()) {
            $query->where('seller_id', $sellerId);
        } else {
            $hasOwn = Product::where('seller_id', $sellerId)->exists();
            if ($hasOwn) {
                $query->where('seller_id', $sellerId);
            }
        }

        // Search filter
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

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where('stock', '>', 0);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'low_stock') {
                $query->where('stock', '<=', 5);
            } elseif ($request->status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('seller.products.index', compact('products', 'categories'));
    }

    /**
     * Show Product Creation Form
     */
    public function createProduct()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store New Product with Group Buy Tiers & Image Upload
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:4096',
            'image_url' => 'nullable|url|max:1000',
            'single_price' => 'required|numeric|min:1',
            'group_price' => 'required|numeric|min:0.5|lt:single_price',
            'tier2_group_price' => 'nullable|numeric|min:0.5|lt:group_price',
            'tier3_group_price' => 'nullable|numeric|min:0.5|lt:tier2_group_price',
            'group_size_required' => 'required|integer|min:2|max:50',
            'max_buyers_limit' => 'nullable|integer|gte:group_size_required|max:100',
            'group_duration_hours' => 'required|integer|min:1|max:168',
            'stock' => 'required|integer|min:0',
        ], [
            'title.required' => 'Product title is required.',
            'category_id.required' => 'Please select a valid category.',
            'single_price.required' => 'Single retail price is required.',
            'group_price.required' => 'Team-buy price is required.',
            'group_price.lt' => 'Team-buy price must be cheaper than the single retail price.',
            'tier2_group_price.lt' => 'Tier 2 price must be lower than standard group price.',
            'tier3_group_price.lt' => 'Tier 3 price must be lower than Tier 2 price.',
            'max_buyers_limit.gte' => 'Maximum buyer limit cannot be lower than minimum required buyers.',
        ]);

        // Inventory consistency validation:
        if ($validated['stock'] < $validated['group_size_required']) {
            return back()->withInput()->withErrors([
                'stock' => "Available stock ({$validated['stock']}) cannot be less than the Minimum Group Size ({$validated['group_size_required']} buyers). Buyers will not be able to complete a group buy."
            ]);
        }
        if (!empty($validated['max_buyers_limit']) && $validated['stock'] < $validated['max_buyers_limit']) {
            return back()->withInput()->withErrors([
                'stock' => "Available stock ({$validated['stock']}) cannot be less than the Max Buyers Cap ({$validated['max_buyers_limit']} buyers). Increase initial stock to match or exceed the team capacity limit."
            ]);
        }

        // Require either file or URL
        if (!$request->hasFile('image_file') && empty($validated['image_url'])) {
            return back()->withInput()->withErrors(['image_file' => 'Please either upload an image file or provide an image URL.']);
        }

        $imageUrl = $validated['image_url'] ?? '';
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        $slug = Str::slug($validated['title']) . '-' . Str::random(5);

        $product = Product::create([
            'seller_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'image_url' => $imageUrl,
            'single_price' => $validated['single_price'],
            'group_price' => $validated['group_price'],
            'tier2_group_price' => $validated['tier2_group_price'] ?? null,
            'tier3_group_price' => $validated['tier3_group_price'] ?? null,
            'group_size_required' => $validated['group_size_required'],
            'max_buyers_limit' => $validated['max_buyers_limit'] ?? null,
            'group_duration_hours' => $validated['group_duration_hours'],
            'stock' => $validated['stock'],
            'is_active' => true,
        ]);

        // Automatically launch initial open Group-Buy campaign pool (waiting for customers)
        $durationHours = (int) ($validated['group_duration_hours'] ?? 48);
        if ($durationHours <= 0) $durationHours = 48;

        GroupBuySession::create([
            'product_id' => $product->id,
            'leader_user_id' => null,
            'group_code' => 'GRP-' . strtoupper(Str::random(6)),
            'required_members' => $product->group_size_required ?: 2,
            'current_members' => 0,
            'status' => 'active',
            'expires_at' => Carbon::now()->addHours($durationHours),
        ]);

        return redirect()->route('seller.products')
            ->with('success', '🎉 Product listed successfully with Group-Buy campaign live!');
    }

    /**
     * Show Product Edit Form
     */
    public function editProduct(Product $product)
    {
        if ($product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized product access.');
        }

        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update Existing Product
     */
    public function updateProduct(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized product access.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:4096',
            'image_url' => 'nullable|url|max:1000',
            'single_price' => 'required|numeric|min:1',
            'group_price' => 'required|numeric|min:0.5|lt:single_price',
            'tier2_group_price' => 'nullable|numeric|min:0.5|lt:group_price',
            'tier3_group_price' => 'nullable|numeric|min:0.5|lt:tier2_group_price',
            'group_size_required' => 'required|integer|min:2|max:50',
            'max_buyers_limit' => 'nullable|integer|gte:group_size_required|max:100',
            'group_duration_hours' => 'required|integer|min:1|max:168',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'single_price.required' => 'Single retail price is required.',
            'group_price.required' => 'Team-buy price is required.',
            'group_price.lt' => 'Team-buy price must be cheaper than single retail price.',
            'tier2_group_price.lt' => 'Tier 2 price must be lower than standard group price.',
            'tier3_group_price.lt' => 'Tier 3 price must be lower than Tier 2 price.',
            'max_buyers_limit.gte' => 'Maximum buyer limit cannot be lower than minimum required buyers.',
        ]);

        if ($validated['stock'] < $validated['group_size_required']) {
            return back()->withInput()->withErrors([
                'stock' => "Available stock ({$validated['stock']}) cannot be less than the Minimum Group Size ({$validated['group_size_required']} buyers)."
            ]);
        }

        $imageUrl = $product->image_url;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $imageUrl = asset('storage/' . $path);
        } elseif ($request->filled('image_url')) {
            $imageUrl = $validated['image_url'];
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_url' => $imageUrl,
            'single_price' => $validated['single_price'],
            'group_price' => $validated['group_price'],
            'tier2_group_price' => $validated['tier2_group_price'] ?? null,
            'tier3_group_price' => $validated['tier3_group_price'] ?? null,
            'group_size_required' => $validated['group_size_required'],
            'max_buyers_limit' => $validated['max_buyers_limit'] ?? null,
            'group_duration_hours' => $validated['group_duration_hours'],
            'stock' => $validated['stock'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('seller.products')
            ->with('success', '✅ Product details and group pricing updated successfully!');
    }

    /**
     * Delete Product (Safely check active groups first)
     */
    public function destroyProduct(Product $product)
    {
        if ($product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $hasActiveGroups = $product->groupBuySessions()
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->exists();

        if ($hasActiveGroups) {
            return back()->with('error', '⚠️ Cannot delete product: Active group buying circles are currently open for this item. Please wait until they expire or complete.');
        }

        $product->delete();

        return redirect()->route('seller.products')
            ->with('success', '🗑️ Product removed from inventory.');
    }

    /**
     * Quick Toggle Active / Inactive Status
     */
    public function toggleProductStatus(Product $product)
    {
        if ($product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $product->is_active = !$product->is_active;
        $product->save();

        $statusText = $product->is_active ? 'Activated' : 'Deactivated';
        return back()->with('success', "Product has been {$statusText}.");
    }

    /**
     * Quick Stock Update from Table
     */
    public function quickStockUpdate(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->stock = (int) $request->stock;
        $product->save();

        return back()->with('success', "Stock updated for '{$product->title}' to {$product->stock} units.");
    }

    /**
     * Group Buy Sessions / Campaigns Monitoring (x, xi)
     */
    public function groups(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();

        $sellerProductsQuery = Product::where('is_active', true);
        if (!$isAdmin) {
            $sellerProductsQuery->where('seller_id', $user->id);
            $sellerProductIds = Product::where('seller_id', $user->id)->pluck('id');
        } else {
            $adminProducts = Product::where('seller_id', $user->id)->pluck('id');
            $sellerProductIds = $adminProducts->isNotEmpty() ? $adminProducts : Product::pluck('id');
        }

        $sellerProducts = $sellerProductsQuery->orderBy('title')->get([
            'id', 'title', 'group_size_required', 'group_duration_hours', 'single_price', 'group_price', 'image_url'
        ]);

        $query = GroupBuySession::with(['product', 'leader', 'members.user'])
            ->whereIn('product_id', $sellerProductIds);

        // Status Filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'active')->where('expires_at', '>', now());
            } elseif ($request->status === 'completed') {
                $query->where('status', 'completed');
            } elseif ($request->status === 'expired') {
                $query->where(function ($q) {
                    $q->where('status', 'expired')
                        ->orWhere(function ($sub) {
                            $sub->where('status', 'active')->where('expires_at', '<=', now());
                        });
                });
            }
        }

        // Search by group code or product title
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('group_code', 'like', "%{$q}%")
                    ->orWhereHas('product', function ($p) use ($q) {
                        $p->where('title', 'like', "%{$q}%");
                    });
            });
        }

        $groups = $query->latest()->paginate(12)->withQueryString();

        $activeCount = GroupBuySession::whereIn('product_id', $sellerProductIds)
            ->where('status', 'active')->where('expires_at', '>', now())->count();
        $completedCount = GroupBuySession::whereIn('product_id', $sellerProductIds)
            ->where('status', 'completed')->count();
        $expiredCount = GroupBuySession::whereIn('product_id', $sellerProductIds)
            ->where(function ($q) {
                $q->where('status', 'expired')
                    ->orWhere(function ($sub) {
                        $sub->where('status', 'active')->where('expires_at', '<=', now());
                    });
            })->count();

        return view('seller.groups.index', compact('groups', 'activeCount', 'completedCount', 'expiredCount', 'sellerProducts'));
    }

    /**
     * Launch a new Group Buy Session / Campaign Pool manually
     */
    public function storeGroup(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'required_members' => 'nullable|integer|min:2|max:100',
            'duration_hours' => 'nullable|integer|min:1|max:720',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized product campaign launch.');
        }

        $requiredMembers = !empty($validated['required_members']) ? (int) $validated['required_members'] : ($product->group_size_required ?: 2);
        $durationHours = !empty($validated['duration_hours']) ? (int) $validated['duration_hours'] : ($product->group_duration_hours ?: 48);

        $code = 'GRP-' . strtoupper(Str::random(6));

        $session = GroupBuySession::create([
            'product_id' => $product->id,
            'leader_user_id' => null,
            'group_code' => $code,
            'required_members' => $requiredMembers,
            'current_members' => 0,
            'status' => 'active',
            'expires_at' => Carbon::now()->addHours($durationHours),
        ]);

        return redirect()->route('seller.groups')
            ->with('success', "🚀 Group-Buy Pool {$code} for '{$product->title}' has been successfully launched!");
    }

    /**
     * Relaunch an expired Group Buy Session with refreshed timer
     */
    public function relaunchGroup(GroupBuySession $session)
    {
        if ($session->product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $durationHours = $session->product->group_duration_hours ?: 48;

        $session->update([
            'status' => 'active',
            'expires_at' => Carbon::now()->addHours($durationHours),
        ]);

        return redirect()->route('seller.groups')
            ->with('success', "🔄 Group-Buy Circle {$session->group_code} relaunched successfully with a fresh {$durationHours}h timer!");
    }

    /**
     * Show Specific Group Buy Session & Participating Buyers
     */
    public function showGroup(GroupBuySession $session)
    {
        if ($session->product->seller_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $session->load(['product.category', 'leader', 'members.user', 'orders.user']);

        return view('seller.groups.show', compact('session'));
    }

    /**
     * Manage Customer Orders (xii, xiii)
     */
    public function orders(Request $request)
    {
        $user = Auth::user();
        $sellerProductIds = Product::where('seller_id', $user->id)->pluck('id');
        if ($user->isAdmin() && $sellerProductIds->isEmpty()) {
            $sellerProductIds = Product::pluck('id');
        }

        $query = OrderItem::with(['order.user', 'product'])
            ->whereIn('product_id', $sellerProductIds);

        // Filter by Order Status
        if ($request->filled('status') && $request->status !== 'all') {
            $status = $request->status;
            $query->whereHas('order', function ($q) use ($status) {
                $q->where('order_status', $status);
            });
        }

        // Filter by Order Type (Solo vs Team Buy)
        if ($request->filled('type') && $request->type !== 'all') {
            $type = $request->type;
            $query->whereHas('order', function ($q) use ($type) {
                $q->where('order_type', $type);
            });
        }

        // Search by Order Number or Customer Name
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('order', function ($ord) use ($q) {
                    $ord->where('order_number', 'like', "%{$q}%")
                        ->orWhere('shipping_name', 'like', "%{$q}%")
                        ->orWhere('shipping_phone', 'like', "%{$q}%");
                })->orWhereHas('product', function ($p) use ($q) {
                    $p->where('title', 'like', "%{$q}%");
                });
            });
        }

        $orderItems = $query->latest()->paginate(15)->withQueryString();

        // Status Counts for Tabs
        $counts = [
            'all' => OrderItem::whereIn('product_id', $sellerProductIds)->count(),
            'pending_group' => OrderItem::whereIn('product_id', $sellerProductIds)->whereHas('order', fn($q) => $q->where('order_status', 'pending_group'))->count(),
            'processing' => OrderItem::whereIn('product_id', $sellerProductIds)->whereHas('order', fn($q) => $q->where('order_status', 'processing'))->count(),
            'shipped' => OrderItem::whereIn('product_id', $sellerProductIds)->whereHas('order', fn($q) => $q->where('order_status', 'shipped'))->count(),
            'delivered' => OrderItem::whereIn('product_id', $sellerProductIds)->whereHas('order', fn($q) => $q->where('order_status', 'delivered'))->count(),
            'cancelled' => OrderItem::whereIn('product_id', $sellerProductIds)->whereHas('order', fn($q) => $q->where('order_status', 'cancelled'))->count(),
        ];

        return view('seller.orders.index', compact('orderItems', 'counts'));
    }

    /**
     * Show Order Details
     */
    public function showOrder(Order $order)
    {
        $sellerProductIds = Product::where('seller_id', Auth::id())->pluck('id');

        // Check if any items belong to seller
        $sellerItems = $order->items()->whereIn('product_id', $sellerProductIds)->get();
        if ($sellerItems->isEmpty()) {
            if (Auth::user()->isAdmin()) {
                $sellerItems = $order->items;
            } else {
                abort(403, 'Unauthorized order access.');
            }
        }

        $order->load(['user', 'groupSession.members.user']);

        return view('seller.orders.show', compact('order', 'sellerItems'));
    }

    /**
     * Update Order Fulfillment Status & Tracking Info
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $sellerProductIds = Product::where('seller_id', Auth::id())->pluck('id');
        $hasItem = $order->items()->whereIn('product_id', $sellerProductIds)->exists();

        if (!$hasItem && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'order_status' => 'required|in:processing,shipped,delivered,cancelled',
            'courier_name' => 'nullable|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'order_notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->order_status;
        $newStatus = $validated['order_status'];

        // Guard: Do not allow shipping or delivering pending group orders if group is not completed!
        if ($oldStatus === 'pending_group' && in_array($newStatus, ['shipped', 'delivered'])) {
            if ($order->groupSession && !$order->groupSession->isCompleted()) {
                return back()->withErrors([
                    'order_status' => "⚠️ Cannot fulfill this order yet! This order belongs to an active Group-Buy pool ({$order->groupSession->group_code}) that has not fulfilled its required buyer quota."
                ]);
            }
        }

        // Inventory & Sales Count Restoration on Order Cancellation:
        if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
            foreach ($order->items as $item) {
                $prod = Product::find($item->product_id);
                if ($prod) {
                    $prod->increment('stock', $item->quantity);
                    $prod->decrement('sales_count', min($prod->sales_count, (int) $item->quantity));
                }
            }
        } elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            // Re-activating previously cancelled order:
            foreach ($order->items as $item) {
                $prod = Product::find($item->product_id);
                if ($prod) {
                    $prod->decrement('stock', $item->quantity);
                    $prod->increment('sales_count', (int) $item->quantity);
                }
            }
        }

        $updateData = [
            'order_status' => $validated['order_status'],
            'courier_name' => $validated['courier_name'] ?? $order->courier_name,
            'tracking_number' => $validated['tracking_number'] ?? $order->tracking_number,
        ];

        if ($validated['order_status'] === 'shipped' && !$order->shipped_at) {
            $updateData['shipped_at'] = now();
        } elseif ($validated['order_status'] === 'delivered' && !$order->delivered_at) {
            $updateData['delivered_at'] = now();
            $updateData['payment_status'] = 'paid'; // COD confirmed delivered
        }

        if (!empty($validated['order_notes'])) {
            $updateData['order_notes'] = $validated['order_notes'];
        }

        $order->update($updateData);

        return back()->with('success', "🚀 Order #{$order->order_number} status updated to " . ucfirst($validated['order_status']) . "!");
    }

    /**
     * Sales Analytics & Performance Reports (xiv)
     */
    public function analytics()
    {
        $user = Auth::user();
        $sellerProductIds = Product::where('seller_id', $user->id)->pluck('id');
        if ($user->isAdmin() && $sellerProductIds->isEmpty()) {
            $sellerProductIds = Product::pluck('id');
        }

        $totalRevenue = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', fn($q) => $q->whereIn('order_status', ['processing', 'shipped', 'delivered']))
            ->sum('subtotal');

        $totalUnitsSold = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', fn($q) => $q->whereIn('order_status', ['processing', 'shipped', 'delivered']))
            ->sum('quantity');

        // Revenue Breakdown: Group Buy vs Solo
        $groupRevenue = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', fn($q) => $q->where('order_type', 'group_buy')->whereIn('order_status', ['processing', 'shipped', 'delivered']))
            ->sum('subtotal');

        $soloRevenue = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', fn($q) => $q->where('order_type', 'single')->whereIn('order_status', ['processing', 'shipped', 'delivered']))
            ->sum('subtotal');

        // Top Selling Products
        $topProducts = Product::whereIn('id', $sellerProductIds)
            ->withCount(['orderItems as total_orders' => function ($q) {
                $q->whereHas('order', fn($o) => $o->whereIn('order_status', ['processing', 'shipped', 'delivered']));
            }])
            ->withSum(['orderItems as gross_sales' => function ($q) {
                $q->whereHas('order', fn($o) => $o->whereIn('order_status', ['processing', 'shipped', 'delivered']));
            }], 'subtotal')
            ->orderByDesc('gross_sales')
            ->take(5)
            ->get();

        // Group Buy Success Metrics
        $totalSessions = GroupBuySession::whereIn('product_id', $sellerProductIds)->count();
        $successfulSessions = GroupBuySession::whereIn('product_id', $sellerProductIds)->where('status', 'completed')->count();
        $expiredSessions = GroupBuySession::whereIn('product_id', $sellerProductIds)->where(function ($q) {
            $q->where('status', 'expired')->orWhere(fn($s) => $s->where('status', 'active')->where('expires_at', '<=', now()));
        })->count();
        $activeSessions = GroupBuySession::whereIn('product_id', $sellerProductIds)->where('status', 'active')->where('expires_at', '>', now())->count();
        $closedSessions = $successfulSessions + $expiredSessions;
        $completionRate = $closedSessions > 0 ? round(($successfulSessions / $closedSessions) * 100) : ($totalSessions > 0 ? 0 : 100);

        return view('seller.analytics.index', compact(
            'totalRevenue',
            'totalUnitsSold',
            'groupRevenue',
            'soloRevenue',
            'topProducts',
            'totalSessions',
            'successfulSessions',
            'expiredSessions',
            'activeSessions',
            'completionRate'
        ));
    }

    /**
     * Seller Store Profile Management (i)
     */
    public function profile()
    {
        $user = Auth::user();
        $categories = Category::all();

        return view('seller.profile.index', compact('user', 'categories'));
    }

    /**
     * Update Seller Profile & Storefront Details
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'business_category' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'shop_description' => 'nullable|string|max:1500',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'shop_name.required' => 'Shop / Business name is required.',
            'name.required' => 'Contact person name is required.',
        ]);

        $updateData = [
            'shop_name' => $validated['shop_name'],
            'name' => $validated['name'],
            'business_category' => $validated['business_category'] ?? $user->business_category,
            'phone' => $validated['phone'] ?? $user->phone,
            'address' => $validated['address'] ?? $user->address,
            'shop_description' => $validated['shop_description'] ?? $user->shop_description,
        ];

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('sellers/avatars', 'public');
            $updateData['avatar'] = asset('storage/' . $path);
        }

        if ($request->hasFile('banner_file')) {
            $path = $request->file('banner_file')->store('sellers/banners', 'public');
            $updateData['shop_banner'] = asset('storage/' . $path);
        }

        $user->update($updateData);

        return back()->with('success', '✨ Merchant store profile updated successfully!');
    }

    /**
     * Integrated Merchant Storefront Preview (Method A)
     * Renders a live, interactive customer-facing store preview inside the Merchant Portal with device frames.
     */
    public function storefront(Request $request)
    {
        $seller = Auth::user();
        $sellerProductIds = Product::where('seller_id', $seller->id)->pluck('id');

        $query = Product::where('seller_id', $seller->id)
            ->where('is_active', true)
            ->with(['category', 'activeGroupSessions.members.user']);

        // Search within shop preview
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

        return view('seller.storefront.index', compact(
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

