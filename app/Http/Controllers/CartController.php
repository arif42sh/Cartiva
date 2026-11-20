<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the dedicated shopping cart page.
     */
    public function index()
    {
        $recommendedProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $sampleProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->take(2)
            ->get();

        return view('cart.index', compact('recommendedProducts', 'sampleProducts'));
    }
}
