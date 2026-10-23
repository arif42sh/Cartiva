<?php

namespace App\Http\Controllers;

use App\Models\GroupBuyMember;
use App\Models\GroupBuySession;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupBuyController extends Controller
{
    public function show(GroupBuySession $session)
    {
        // Auto-expire outdated sessions in real-time
        GroupBuySession::checkAndExpireSessions();

        $session->load(['product.seller', 'leader', 'members.user', 'orders.user']);

        $userAlreadyJoined = Auth::check() && $session->hasUserJoined(Auth::id());
        $isExpired = $session->isExpired();
        $isCompleted = $session->isCompleted();

        // Calculate seconds remaining for Alpine countdown timer
        $secondsRemaining = max(0, (int) round(now()->diffInSeconds($session->expires_at, false)));

        // Can the leader dismiss this session? (Only if no other members have joined/paid)
        $canLeaderDismiss = Auth::check() 
            && Auth::id() === $session->leader_user_id 
            && !$isCompleted 
            && !$isExpired 
            && $session->orders()->where('user_id', '!=', Auth::id())->count() === 0;

        return view('group-buy.show', compact('session', 'userAlreadyJoined', 'isExpired', 'isCompleted', 'secondsRemaining', 'canLeaderDismiss'));
    }

    public function start(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'গ্রুপ শুরু করতে অনুগ্রহ করে লগইন করুন।');
        }

        // Global Anti-Fraud Rule: Sellers cannot start or buy their own listings
        if (Auth::id() === $product->seller_id) {
            return redirect()->route('products.show', $product->slug)
                ->with('error', '⚠️ আপনি এই প্রোডাক্টের সেলার। সেলাররা নিজের প্রোডাক্টের টিম-বাই শুরু করতে পারেন না।');
        }

        // Check if user already has an active, running group for this product
        $existingActiveSession = GroupBuySession::where('product_id', $product->id)
            ->where('leader_user_id', Auth::id())
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->first();

        if ($existingActiveSession) {
            return redirect()->route('group-buy.show', $existingActiveSession->group_code)
                ->with('info', 'আপনার এই প্রোডাক্টের জন্য ইতোমধ্যে একটি সক্রিয় টিম রয়েছে। লিংক শেয়ার করে বন্ধুদের আমন্ত্রণ জানান!');
        }

        $quantity = max(1, min((int) $request->input('quantity', 1), max(1, $product->stock)));

        // Redirect to checkout with order_type = group_buy, start_new = 1, and quantity
        return redirect()->route('checkout', [
            'product_id' => $product->id,
            'type' => 'group_buy',
            'action' => 'start_new',
            'quantity' => $quantity,
        ]);
    }

    public function join(Request $request, GroupBuySession $session)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'গ্রুপে যুক্ত হতে অনুগ্রহ করে লগইন করুন।');
        }

        // Global Anti-Fraud Rule: Sellers cannot join team buy circles on their own listings
        if (Auth::id() === $session->product->seller_id) {
            return redirect()->route('products.show', $session->product->slug)
                ->with('error', '⚠️ আপনি এই প্রোডাক্টের সেলার। সেলাররা নিজের প্রোডাক্টের টিম-বাই সার্কেলে জয়েন করতে পারেন না।');
        }

        if ($session->isExpired()) {
            return redirect()->route('group-buy.show', $session->group_code)
                ->with('error', 'এই গ্রুপের সময়সীমা শেষ হয়ে গেছে।');
        }

        if ($session->isCompleted()) {
            return redirect()->route('group-buy.show', $session->group_code)
                ->with('error', 'এই গ্রুপটির কোটা ইতোমধ্যে সম্পূর্ণ হয়েছে!');
        }

        $remaining = $session->remainingSlots();
        if ($remaining <= 0) {
            return redirect()->route('group-buy.show', $session->group_code)
                ->with('error', 'এই গ্রুপে কোনো খালি স্লট নেই।');
        }

        // Cap requested quantity to remaining slots
        $quantity = max(1, min((int) $request->input('quantity', 1), $remaining));

        // Redirect to checkout with group session ID and quantity
        return redirect()->route('checkout', [
            'product_id' => $session->product_id,
            'type' => 'group_buy',
            'session_id' => $session->id,
            'action' => 'join_existing',
            'quantity' => $quantity,
        ]);
    }

    public function dismiss(GroupBuySession $session)
    {
        if (!Auth::check() || Auth::id() !== $session->leader_user_id) {
            abort(403, 'অননুমোদিত অনুরোধ।');
        }

        if ($session->isCompleted()) {
            return redirect()->route('group-buy.show', $session->group_code)
                ->with('error', 'গ্রুপটি ইতোমধ্যে সম্পন্ন হয়েছে, বাতিল করা সম্ভব নয়।');
        }

        // Check if other members have joined and paid
        $otherOrdersCount = $session->orders()->where('user_id', '!=', Auth::id())->count();
        if ($otherOrdersCount > 0) {
            return redirect()->route('group-buy.show', $session->group_code)
                ->with('error', 'এই গ্রুপে অন্যান্য ক্রেতা যুক্ত হয়ে পেমেন্ট সম্পন্ন করেছেন, তাই এটি বাতিল করা যাবে না।');
        }

        // Cancel leader's pending order and release reserved stock
        $leaderOrders = $session->orders()->where('user_id', Auth::id())->get();
        foreach ($leaderOrders as $order) {
            $order->update([
                'order_status' => 'cancelled',
                'payment_status' => 'refunded'
            ]);
            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }
        }

        $session->update(['status' => 'expired']);

        return redirect()->route('products.show', $session->product->slug)
            ->with('success', 'আপনার গ্রুপটি সফলভাবে বাতিল করা হয়েছে।');
    }
}
