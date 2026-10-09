<?php

namespace App\Http\Controllers;

use App\Models\GroupBuySession;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load(['seller', 'category']);

        // Active groups for this specific product that have slots available
        $activeGroups = GroupBuySession::with(['leader', 'members.user'])
            ->where('product_id', $product->id)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->latest()
            ->get();

        // Related products in the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'activeGroups', 'relatedProducts'));
    }
}
