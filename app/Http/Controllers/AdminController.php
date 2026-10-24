<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\GroupBuySession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\RefundRequest;
use App\Models\ReportedIssue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Platform Overview Command Center (SRS 4.4.xi)
     */
    public function dashboard()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalSellers = User::where('role', 'seller')->count();
        $pendingSellersCount = User::where('role', 'seller')->where('status', 'pending')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('order_status', ['processing', 'shipped', 'delivered'])->sum('total_amount');

        $activeGroupsCount = GroupBuySession::where('status', 'active')->count();
        $completedGroupsCount = GroupBuySession::where('status', 'completed')->count();
        $expiredGroupsCount = GroupBuySession::where('status', 'expired')->count();

        // Genuine customer savings calculated from catalog pricing: (single_price - group_price) * quantity
        $totalCustomerSavings = (float) DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.order_type', 'group_buy')
            ->where('orders.order_status', '!=', 'cancelled')
            ->whereRaw('products.single_price > products.group_price')
            ->sum(DB::raw('(products.single_price - products.group_price) * order_items.quantity'));

        // Pending refunds & open dispute tickets count
        $pendingRefundsCount = RefundRequest::where('status', 'pending')->count();
        $openIssuesCount = ReportedIssue::where('status', 'open')->count();

        $recentOrders = Order::with(['user', 'items.product'])->latest()->take(6)->get();
        $recentGroups = GroupBuySession::with(['product', 'leader'])->latest()->take(6)->get();
        $recentActivities = ActivityLog::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalSellers',
            'pendingSellersCount',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'activeGroupsCount',
            'completedGroupsCount',
            'expiredGroupsCount',
            'totalCustomerSavings',
            'pendingRefundsCount',
            'openIssuesCount',
            'recentOrders',
            'recentGroups',
            'recentActivities'
        ));
    }

    /**
     * i. Customer Management: Directory & Filter (SRS 4.4.i)
     */
    public function customers(Request $request)
    {
        $query = User::where(function ($q) {
            $q->where('role', 'customer')->orWhereNull('role');
        });

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('status', 'active');
            } elseif ($status === 'suspended') {
                $query->where('status', 'suspended');
            }
        }

        $sort = $request->input('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $customers = $query->withCount(['orders', 'groupMemberships'])->paginate(12)->withQueryString();

        $totalCustomersCount = User::where('role', 'customer')->count();
        $activeCustomersCount = User::where('role', 'customer')->where('status', 'active')->count();
        $suspendedCustomersCount = User::where('role', 'customer')->where('status', 'suspended')->count();
        $totalOrdersCount = Order::whereHas('user', function ($q) {
            $q->where('role', 'customer');
        })->count();
        $totalCustomerSpend = Order::whereHas('user', function ($q) {
            $q->where('role', 'customer');
        })->where('order_status', '!=', 'cancelled')->sum('total_amount');

        return view('admin.customers.index', compact(
            'customers',
            'totalCustomersCount',
            'activeCustomersCount',
            'suspendedCustomersCount',
            'totalOrdersCount',
            'totalCustomerSpend'
        ));
    }

    public function showCustomer(User $user)
    {
        $totalSpent = $user->orders()->where('order_status', '!=', 'cancelled')->sum('total_amount');
        $totalSavings = (float) DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.user_id', $user->id)
            ->where('orders.order_type', 'group_buy')
            ->where('orders.order_status', '!=', 'cancelled')
            ->whereRaw('products.single_price > products.group_price')
            ->sum(DB::raw('(products.single_price - products.group_price) * order_items.quantity'));
        
        $ordersCount = $user->orders()->count();
        $groupsCount = $user->groupMemberships()->count();

        $recentOrders = $user->orders()
            ->with(['items.product', 'groupSession.product'])
            ->latest()
            ->paginate(8, ['*'], 'orders_page');

        $groupMemberships = $user->groupMemberships()
            ->with(['session.product', 'session.leader', 'session.members.user'])
            ->latest()
            ->paginate(8, ['*'], 'groups_page');

        return view('admin.customers.show', compact(
            'user',
            'totalSpent',
            'totalSavings',
            'ordersCount',
            'groupsCount',
            'recentOrders',
            'groupMemberships'
        ));
    }

    public function toggleCustomerStatus(User $user, Request $request)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Administrator accounts cannot be suspended.');
        }

        if ($user->status === 'suspended') {
            $user->update([
                'status' => 'active',
                'status_reason' => null,
            ]);
            ActivityLog::log('customer_restored', "Customer account '{$user->name}' was restored to Active status.", 'User', $user->id);
            return back()->with('success', "Customer '{$user->name}' has been restored to Active status.");
        } else {
            $reason = $request->input('reason', 'Suspended by Administrator review.');
            $user->update([
                'status' => 'suspended',
                'status_reason' => $reason,
            ]);
            ActivityLog::log('customer_suspended', "Customer account '{$user->name}' was suspended. Reason: {$reason}", 'User', $user->id);
            return back()->with('success', "Customer '{$user->name}' has been Suspended.");
        }
    }

    /**
     * ii & iii. Seller Management & Approvals (SRS 4.4.ii, iii)
     */
    public function sellers(Request $request)
    {
        $query = User::where('role', 'seller');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('shop_name', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('business_category', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $sellers = $query->withCount(['products'])->latest()->paginate(12)->withQueryString();

        $totalSellersCount = User::where('role', 'seller')->count();
        $pendingSellersCount = User::where('role', 'seller')->where('status', 'pending')->count();
        $approvedSellersCount = User::where('role', 'seller')->where('status', 'approved')->count();
        $suspendedSellersCount = User::where('role', 'seller')->where('status', 'suspended')->count();

        return view('admin.sellers.index', compact(
            'sellers',
            'totalSellersCount',
            'pendingSellersCount',
            'approvedSellersCount',
            'suspendedSellersCount'
        ));
    }

    public function showSeller(User $user)
    {
        $products = $user->products()->with('category')->latest()->paginate(10);
        $totalProductsCount = $user->products()->count();
        
        $grossSales = (float) OrderItem::whereHas('product', function ($q) use ($user) {
            $q->where('seller_id', $user->id);
        })->whereHas('order', function ($q) {
            $q->whereIn('order_status', ['processing', 'shipped', 'delivered']);
        })->sum('subtotal');

        $ordersFulfilledCount = Order::whereHas('items.product', function ($q) use ($user) {
            $q->where('seller_id', $user->id);
        })->where('order_status', 'delivered')->count();

        return view('admin.sellers.show', compact(
            'user',
            'products',
            'totalProductsCount',
            'grossSales',
            'ordersFulfilledCount'
        ));
    }

    public function approveSeller(User $user)
    {
        $user->update([
            'status' => 'approved',
            'status_reason' => null,
        ]);

        ActivityLog::log('seller_approved', "Merchant store '{$user->shop_name}' ({$user->name}) was Approved.", 'User', $user->id);
        return back()->with('success', "Merchant '{$user->shop_name}' has been Approved. Their store is now verified and active.");
    }

    public function rejectSeller(User $user, Request $request)
    {
        $reason = $request->input('reason', 'Application did not meet platform trade compliance requirements.');
        $user->update([
            'status' => 'rejected',
            'status_reason' => $reason,
        ]);

        ActivityLog::log('seller_rejected', "Merchant store '{$user->shop_name}' was Rejected. Reason: {$reason}", 'User', $user->id);
        return back()->with('success', "Merchant application has been Rejected.");
    }

    public function toggleSellerStatus(User $user, Request $request)
    {
        if ($user->status === 'suspended') {
            $user->update([
                'status' => 'approved',
                'status_reason' => null,
            ]);
            ActivityLog::log('seller_restored', "Merchant store '{$user->shop_name}' was restored to Approved status.", 'User', $user->id);
            return back()->with('success', "Merchant '{$user->shop_name}' is now re-activated.");
        } else {
            $reason = $request->input('reason', 'Suspended due to policy violation or investigation.');
            $user->update([
                'status' => 'suspended',
                'status_reason' => $reason,
            ]);
            ActivityLog::log('seller_suspended', "Merchant store '{$user->shop_name}' was Suspended. Reason: {$reason}", 'User', $user->id);
            return back()->with('success', "Merchant '{$user->shop_name}' has been Suspended.");
        }
    }

    /**
     * iv. Product Categories Management (SRS 4.4.iv)
     */
    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->latest()->paginate(15);
        $totalCategoriesCount = Category::count();
        $totalProductsInCategories = Product::count();

        return view('admin.categories.index', compact('categories', 'totalCategoriesCount', 'totalProductsInCategories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:100'],
        ]);

        $slug = Str::slug($validated['name']);
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(10, 99);
        }

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? 'tag',
            'is_active' => true,
        ]);

        ActivityLog::log('category_created', "Product category '{$category->name}' was created.", 'Category', $category->id);
        return back()->with('success', "Category '{$category->name}' created successfully.");
    }

    public function updateCategory(Category $category, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $category->slug;
        if ($category->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            if (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug .= '-' . rand(10, 99);
            }
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? $category->icon,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : $category->is_active,
        ]);

        ActivityLog::log('category_updated', "Category '{$category->name}' was updated.", 'Category', $category->id);
        return back()->with('success', "Category '{$category->name}' updated successfully.");
    }

    public function deleteCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', "Cannot delete category '{$category->name}' because it contains {$category->products()->count()} live products.");
        }

        $name = $category->name;
        $category->delete();

        ActivityLog::log('category_deleted', "Category '{$name}' was deleted.", 'Category');
        return back()->with('success', "Category '{$name}' was deleted successfully.");
    }

    /**
     * v. Platform Products Catalog (SRS 4.4.v)
     */
    public function products(Request $request)
    {
        $query = Product::with(['category', 'seller']);

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($category_id = $request->input('category_id')) {
            $query->where('category_id', $category_id);
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function toggleProductStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        ActivityLog::log('product_status_toggle', "Product '{$product->title}' active status changed to " . ($product->is_active ? 'Active' : 'Hidden'), 'Product', $product->id);
        return back()->with('success', "Product '{$product->title}' visibility updated.");
    }

    public function toggleProductFeature(Product $product, Request $request)
    {
        $feature = $request->input('feature'); // hot_deal, flash_sale, featured
        if ($feature === 'hot_deal') {
            $product->is_hot_deal = !$product->is_hot_deal;
            $msg = $product->is_hot_deal ? 'marked as Hot Deal.' : 'removed from Hot Deals.';
        } elseif ($feature === 'flash_sale') {
            $product->is_flash_sale = !$product->is_flash_sale;
            $msg = $product->is_flash_sale ? 'added to Flash Sales.' : 'removed from Flash Sales.';
        } else {
            $product->is_featured = !$product->is_featured;
            $msg = $product->is_featured ? 'featured on Homepage.' : 'unfeatured.';
        }
        $product->save();

        ActivityLog::log('product_featured', "Product '{$product->title}' {$msg}", 'Product', $product->id);
        return back()->with('success', "Product '{$product->title}' {$msg}");
    }

    public function approveProduct(Product $product)
    {
        $product->update([
            'approval_status' => 'approved',
            'is_active' => true,
        ]);

        ActivityLog::log('product_approved', "Product '{$product->title}' was Approved.", 'Product', $product->id);
        return back()->with('success', "Product '{$product->title}' has been approved for marketplace catalog.");
    }

    public function deleteProduct(Product $product)
    {
        $title = $product->title;
        $product->delete();

        ActivityLog::log('product_deleted', "Product '{$title}' was removed by Administrator.", 'Product');
        return back()->with('success', "Product '{$title}' was successfully removed.");
    }

    /**
     * vi. Group Buying Sessions Monitor (SRS 4.4.vi)
     */
    public function groups(Request $request)
    {
        $query = GroupBuySession::with(['product', 'leader', 'members.user']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $groups = $query->latest()->paginate(15)->withQueryString();

        $activeCount = GroupBuySession::where('status', 'active')->count();
        $completedCount = GroupBuySession::where('status', 'completed')->count();
        $expiredCount = GroupBuySession::where('status', 'expired')->count();

        return view('admin.groups.index', compact('groups', 'activeCount', 'completedCount', 'expiredCount'));
    }

    public function relaunchGroup(GroupBuySession $session)
    {
        if ($session->status === 'completed') {
            return back()->with('error', "Cannot relaunch Group #{$session->group_code} because it has already reached required buyers and completed successfully.");
        }

        if ($session->product && $session->product->stock <= 0) {
            return back()->with('error', "Cannot relaunch Group #{$session->group_code} because product '{$session->product->title}' is currently out of stock.");
        }

        $session->update([
            'status' => 'active',
            'expires_at' => now()->addHours($session->product->group_duration_hours ?? 24),
        ]);

        ActivityLog::log('group_relaunched', "Group session #{$session->group_code} was relaunched for 24h.", 'GroupBuySession', $session->id);
        return back()->with('success', "Group #{$session->group_code} has been successfully relaunched with fresh timer.");
    }

    public function triggerExpirationCheck()
    {
        Artisan::call('cartiva:check-group-expirations');
        $output = Artisan::output();

        ActivityLog::log('cron_executed', "Manual scheduler trigger executed.", 'Scheduler');
        return back()->with('success', "Scheduler ran successfully: {$output}");
    }

    /**
     * vii. Order Management (SRS 4.4.vii)
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items.product', 'groupSession']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('shipping_name', 'like', "%{$search}%")
                  ->orWhere('shipping_phone', 'like', "%{$search}%");
            });
        }

        if ($order_status = $request->input('order_status')) {
            $query->where('order_status', $order_status);
        }

        if ($order_type = $request->input('order_type')) {
            $query->where('order_type', $order_type);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        $totalOrdersCount = Order::count();
        $processingCount = Order::where('order_status', 'processing')->count();
        $shippedCount = Order::where('order_status', 'shipped')->count();
        $deliveredCount = Order::where('order_status', 'delivered')->count();

        return view('admin.orders.index', compact(
            'orders',
            'totalOrdersCount',
            'processingCount',
            'shippedCount',
            'deliveredCount'
        ));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product.seller', 'groupSession.members.user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Order $order, Request $request)
    {
        $validated = $request->validate([
            'order_status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
            'courier_name' => ['nullable', 'string', 'max:100'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
        ]);

        $updates = [
            'order_status' => $validated['order_status'],
            'courier_name' => $validated['courier_name'] ?? $order->courier_name,
            'tracking_number' => $validated['tracking_number'] ?? $order->tracking_number,
        ];

        // 1. Inventory stock restoration on order cancellation
        if ($validated['order_status'] === 'cancelled' && $order->order_status !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', (int) $item->quantity);
                    $item->product->decrement('sales_count', min($item->product->sales_count, (int) $item->quantity));
                }
            }
            $updates['escrow_status'] = 'refunded';
        }

        // 2. Re-decrement stock if re-activating a previously cancelled order
        if ($order->order_status === 'cancelled' && $validated['order_status'] !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', min($item->product->stock, (int) $item->quantity));
                    $item->product->increment('sales_count', (int) $item->quantity);
                }
            }
            $updates['escrow_status'] = 'held';
        }

        if ($validated['order_status'] === 'shipped' && !$order->shipped_at) {
            $updates['shipped_at'] = now();
        }

        if ($validated['order_status'] === 'delivered') {
            if (!$order->delivered_at) {
                $updates['delivered_at'] = now();
            }
            if ($order->payment_method === 'cod') {
                $updates['payment_status'] = 'paid';
            }
            $updates['escrow_status'] = 'released';
        }

        $order->update($updates);

        ActivityLog::log('order_status_updated', "Order #{$order->order_number} status updated to {$validated['order_status']}.", 'Order', $order->id);
        return back()->with('success', "Order #{$order->order_number} status updated successfully.");
    }

    /**
     * viii. Payments & Escrow Ledger (SRS 4.4.viii)
     */
    public function payments()
    {
        $grossVolume = Order::whereIn('order_status', ['processing', 'shipped', 'delivered'])->sum('total_amount');
        // Escrow pool: only funds genuinely received into platform gateway and currently held
        $heldInEscrow = Order::where('escrow_status', 'held')
            ->where('payment_status', 'paid')
            ->whereIn('order_status', ['pending', 'processing', 'shipped'])
            ->sum('total_amount');
        // Settled merchant payout: orders where escrow has officially been released
        $releasedToSellers = Order::where('escrow_status', 'released')->sum('total_amount');
        // Platform take-rate revenue: 5% commission on settled transactions
        $platformFee = $releasedToSellers * 0.05;

        $orders = Order::with(['user', 'items.product.seller'])
            ->whereIn('payment_status', ['paid', 'cash_on_delivery'])
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact(
            'grossVolume',
            'heldInEscrow',
            'releasedToSellers',
            'platformFee',
            'orders'
        ));
    }

    public function releaseEscrow(Order $order)
    {
        $order->update(['escrow_status' => 'released']);
        ActivityLog::log('escrow_released', "Escrow funds for Order #{$order->order_number} released to merchant.", 'Order', $order->id);
        return back()->with('success', "Escrow payout for Order #{$order->order_number} has been released.");
    }

    /**
     * ix. Refund Requests Management (SRS 4.4.ix)
     */
    public function refunds(Request $request)
    {
        $query = RefundRequest::with(['order', 'user']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $refunds = $query->latest()->paginate(15)->withQueryString();

        $totalRefundsCount = RefundRequest::count();
        $pendingRefundsCount = RefundRequest::where('status', 'pending')->count();
        $approvedRefundsCount = RefundRequest::where('status', 'approved')->count();
        $totalRefundedAmount = RefundRequest::where('status', 'approved')->sum('amount');

        return view('admin.refunds.index', compact(
            'refunds',
            'totalRefundsCount',
            'pendingRefundsCount',
            'approvedRefundsCount',
            'totalRefundedAmount'
        ));
    }

    public function approveRefund(RefundRequest $refund)
    {
        $refund->update([
            'status' => 'approved',
            'processed_at' => now(),
        ]);

        if ($refund->order) {
            $order = $refund->order;
            $order->update(['escrow_status' => 'refunded', 'order_status' => 'cancelled']);

            // Restore product stock and adjust sales count
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', (int) $item->quantity);
                    $item->product->decrement('sales_count', min($item->product->sales_count, (int) $item->quantity));
                }
            }
        }

        ActivityLog::log('refund_approved', "Refund of ৳{$refund->amount} for Order #{$refund->order->order_number} approved.", 'RefundRequest', $refund->id);
        return back()->with('success', "Refund of ৳{$refund->amount} approved and marked as processed.");
    }

    public function rejectRefund(RefundRequest $refund, Request $request)
    {
        $notes = $request->input('admin_notes', 'Refund claim rejected after dispute verification.');
        $refund->update([
            'status' => 'rejected',
            'admin_notes' => $notes,
            'processed_at' => now(),
        ]);

        ActivityLog::log('refund_rejected', "Refund request #{$refund->id} was rejected. Note: {$notes}", 'RefundRequest', $refund->id);
        return back()->with('success', "Refund request has been rejected.");
    }

    /**
     * x. Reported Issues & Disputes Resolution (SRS 4.4.x)
     */
    public function issues(Request $request)
    {
        $query = ReportedIssue::with(['user', 'seller', 'order']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($priority = $request->input('priority')) {
            $query->where('priority', $priority);
        }

        $issues = $query->latest()->paginate(15)->withQueryString();

        $openCount = ReportedIssue::where('status', 'open')->count();
        $investigatingCount = ReportedIssue::where('status', 'investigating')->count();
        $resolvedCount = ReportedIssue::where('status', 'resolved')->count();

        return view('admin.issues.index', compact(
            'issues',
            'openCount',
            'investigatingCount',
            'resolvedCount'
        ));
    }

    public function showIssue(ReportedIssue $issue)
    {
        $issue->load(['user', 'seller', 'order.items.product']);
        return view('admin.issues.show', compact('issue'));
    }

    public function resolveIssue(ReportedIssue $issue, Request $request)
    {
        $validated = $request->validate([
            'admin_response' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'in:investigating,resolved,closed'],
        ]);

        $issue->update([
            'status' => $validated['status'],
            'admin_response' => $validated['admin_response'],
            'resolved_at' => $validated['status'] === 'resolved' ? now() : $issue->resolved_at,
        ]);

        ActivityLog::log('issue_resolved', "Dispute ticket #{$issue->ticket_number} marked as {$validated['status']}.", 'ReportedIssue', $issue->id);
        return back()->with('success', "Ticket #{$issue->ticket_number} resolution has been updated.");
    }

    /**
     * xi. Platform Statistics & Analytics (SRS 4.4.xi)
     */
    public function statistics()
    {
        $totalGMV = Order::whereIn('order_status', ['processing', 'shipped', 'delivered'])->sum('total_amount');
        $totalOrders = Order::count();
        $completedGroups = GroupBuySession::where('status', 'completed')->count();
        $totalGroups = GroupBuySession::count();
        $groupSuccessRate = $totalGroups > 0 ? round(($completedGroups / $totalGroups) * 100, 1) : 0;

        $totalCustomerSavings = (float) DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.order_type', 'group_buy')
            ->where('orders.order_status', '!=', 'cancelled')
            ->whereRaw('products.single_price > products.group_price')
            ->sum(DB::raw('(products.single_price - products.group_price) * order_items.quantity'));

        // Top 5 selling products
        $topProducts = Product::orderByDesc('sales_count')->take(5)->get();

        // Top 5 stores ranked by total sales units across their product catalog
        $topSellers = User::where('role', 'seller')
            ->withCount('products')
            ->withSum('products as total_sales_volume', 'sales_count')
            ->orderByDesc('total_sales_volume')
            ->take(5)
            ->get();

        return view('admin.statistics.index', compact(
            'totalGMV',
            'totalOrders',
            'completedGroups',
            'totalGroups',
            'groupSuccessRate',
            'totalCustomerSavings',
            'topProducts',
            'topSellers'
        ));
    }

    /**
     * xii. Announcements & Notifications (SRS 4.4.xii)
     */
    public function announcements()
    {
        $announcements = Announcement::latest()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
            'type' => ['required', 'in:banner_top,modal_popup,broadcast_alert'],
            'target_audience' => ['required', 'in:all,customers,sellers'],
            'action_url' => ['nullable', 'string', 'max:255'],
            'action_label' => ['nullable', 'string', 'max:100'],
        ]);

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'target_audience' => $validated['target_audience'],
            'action_url' => $validated['action_url'] ?? null,
            'action_label' => $validated['action_label'] ?? null,
            'is_active' => true,
            'created_by' => auth()->id(),
        ]);

        ActivityLog::log('announcement_created', "Announcement '{$announcement->title}' published.", 'Announcement', $announcement->id);
        return back()->with('success', "Announcement broadcast published successfully.");
    }

    public function toggleAnnouncement(Announcement $announcement)
    {
        $announcement->is_active = !$announcement->is_active;
        $announcement->save();

        ActivityLog::log('announcement_toggled', "Announcement '{$announcement->title}' active status toggled.", 'Announcement', $announcement->id);
        return back()->with('success', "Announcement status updated.");
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        $title = $announcement->title;
        $announcement->delete();

        ActivityLog::log('announcement_deleted', "Announcement '{$title}' was deleted.", 'Announcement');
        return back()->with('success', "Announcement removed successfully.");
    }

    /**
     * xiii. Overall System Activities & Logs (SRS 4.4.xiii)
     */
    public function activityLogs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(25);
        $totalLogsCount = ActivityLog::count();
        $cronCommandOutput = Artisan::output();

        return view('admin.activity-logs.index', compact('logs', 'totalLogsCount', 'cronCommandOutput'));
    }

    /**
     * Unified user directory fallback
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }
}
