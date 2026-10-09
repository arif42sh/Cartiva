<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GroupBuySession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function dashboard()
    {
        $sellerId = Auth::id();

        $myProductsCount = Product::where('seller_id', $sellerId)->count();

        $sellerProductIds = Product::where('seller_id', $sellerId)->pluck('id');

        $activeGroupBuys = GroupBuySession::whereIn('product_id', $sellerProductIds)
            ->where('status', 'active')
            ->count();

        $completedGroupBuys = GroupBuySession::whereIn('product_id', $sellerProductIds)
            ->where('status', 'completed')
            ->count();

        $totalEarnings = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function ($q) {
                $q->whereIn('order_status', ['processing', 'shipped', 'delivered']);
            })
            ->sum('subtotal');

        $recentSales = OrderItem::with(['order.user', 'product'])
            ->whereIn('product_id', $sellerProductIds)
            ->latest()
            ->take(6)
            ->get();

        return view('seller.dashboard', compact(
            'myProductsCount',
            'activeGroupBuys',
            'completedGroupBuys',
            'totalEarnings',
            'recentSales'
        ));
    }

    public function products()
    {
        $products = Product::with('category')
            ->where('seller_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image_url' => 'required|url',
            'single_price' => 'required|numeric|min:1',
            'group_price' => 'required|numeric|min:0.5|lt:single_price',
            'group_size_required' => 'required|integer|min:2|max:10',
            'group_duration_hours' => 'required|integer|min:1|max:168',
            'stock' => 'required|integer|min:1',
        ]);

        $slug = Str::slug($validated['title']) . '-' . Str::random(5);

        Product::create([
            'seller_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'image_url' => $validated['image_url'],
            'single_price' => $validated['single_price'],
            'group_price' => $validated['group_price'],
            'group_size_required' => $validated['group_size_required'],
            'group_duration_hours' => $validated['group_duration_hours'],
            'stock' => $validated['stock'],
            'is_active' => true,
        ]);

        return redirect()->route('seller.products')
            ->with('success', 'Product listed successfully with Group Buy enabled!');
    }

    public function orders()
    {
        $sellerProductIds = Product::where('seller_id', Auth::id())->pluck('id');

        $orderItems = OrderItem::with(['order.user', 'product'])
            ->whereIn('product_id', $sellerProductIds)
            ->latest()
            ->paginate(15);

        return view('seller.orders.index', compact('orderItems'));
    }
}
