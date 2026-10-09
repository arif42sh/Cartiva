<?php

namespace App\Http\Controllers;

use App\Models\GroupBuySession;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('order_status', ['processing', 'shipped', 'delivered'])->sum('total_amount');

        $activeGroupsCount = GroupBuySession::where('status', 'active')->count();
        $completedGroupsCount = GroupBuySession::where('status', 'completed')->count();

        $recentOrders = Order::with(['user', 'items.product'])->latest()->take(5)->get();
        $recentGroups = GroupBuySession::with(['product', 'leader'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalSellers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'activeGroupsCount',
            'completedGroupsCount',
            'recentOrders',
            'recentGroups'
        ));
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function products()
    {
        $products = Product::with(['category', 'seller'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function groups()
    {
        $groups = GroupBuySession::with(['product', 'leader', 'members.user'])
            ->latest()
            ->paginate(15);

        return view('admin.groups.index', compact('groups'));
    }

    public function triggerExpirationCheck()
    {
        Artisan::call('cartiva:check-group-expirations');
        $output = Artisan::output();

        return back()->with('success', "Scheduler ran successfully: {$output}");
    }
}
