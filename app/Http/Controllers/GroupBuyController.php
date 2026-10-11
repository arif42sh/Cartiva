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
        $session->load(['product.seller', 'leader', 'members.user']);

        $userAlreadyJoined = Auth::check() && $session->hasUserJoined(Auth::id());
        $isExpired = $session->isExpired();
        $isCompleted = $session->isCompleted();

        // Calculate seconds remaining for Alpine countdown timer (cast to int to avoid floating decimals)
        $secondsRemaining = max(0, (int) round(now()->diffInSeconds($session->expires_at, false)));

        return view('group-buy.show', compact('session', 'userAlreadyJoined', 'isExpired', 'isCompleted', 'secondsRemaining'));
    }

    public function start(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please log in to start a Group Buy team.');
        }

        $quantity = max(1, (int) $request->input('quantity', 1));

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
            return redirect()->route('login')->with('info', 'Please log in to join this Team Buy.');
        }

        if ($session->isExpired()) {
            return redirect()->route('group-buy.show', $session)
                ->with('error', 'This Group Buy session has expired.');
        }

        if ($session->isCompleted()) {
            return redirect()->route('group-buy.show', $session)
                ->with('error', 'This Group Buy team is already full!');
        }

        if ($session->hasUserJoined(Auth::id())) {
            return redirect()->route('group-buy.show', $session)
                ->with('info', 'You are already a member of this team.');
        }

        $quantity = max(1, (int) $request->input('quantity', 1));

        // Redirect to checkout with group session ID and quantity
        return redirect()->route('checkout', [
            'product_id' => $session->product_id,
            'type' => 'group_buy',
            'session_id' => $session->id,
            'action' => 'join_existing',
            'quantity' => $quantity,
        ]);
    }
}
