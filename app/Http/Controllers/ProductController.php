<?php

namespace App\Http\Controllers;

use App\Models\GroupBuySession;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        // Auto-expire any outdated sessions and release inventory
        GroupBuySession::checkAndExpireSessions();

        $product->load(['seller', 'category', 'reviews.user']);

        $userReview = auth()->check() 
            ? $product->reviews->where('user_id', auth()->id())->first() 
            : null;

        // Active official group for this specific product that has slots available
        $activeGroups = GroupBuySession::with(['leader', 'members.user'])
            ->where('product_id', $product->id)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->whereColumn('current_members', '<', 'required_members')
            ->latest()
            ->get();

        // If no active pool exists and product has stock, ensure official seller pool is live
        if ($activeGroups->isEmpty() && $product->stock > 0 && ($product->group_price > 0)) {
            $spawnedPool = GroupBuySession::autoSpawnNextPool($product);
            if ($spawnedPool) {
                $activeGroups = collect([$spawnedPool->load(['leader', 'members.user'])]);
            }
        }

        // Related products in the same category, with fallback to popular products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(8)
            ->get();

        if ($relatedProducts->count() < 4) {
            $fallback = Product::where('id', '!=', $product->id)
                ->where('is_active', true)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->latest()
                ->take(8 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->merge($fallback);
        }

        return view('products.show', compact('product', 'activeGroups', 'relatedProducts', 'userReview'));
    }

    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        // Auto-update product average rating
        $avgRating = $product->reviews()->avg('rating');
        if ($avgRating) {
            $product->update([
                'rating' => round($avgRating, 1),
            ]);
        }

        return redirect()->to(route('products.show', $product->slug) . '#customer-reviews')
            ->with('success', 'Your review has been submitted successfully!');
    }
}
