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

        // Calculate seconds remaining for Alpine countdown timer
        $secondsRemaining = max(0, now()->diffInSeconds($session->expires_at, false));

        return view('group-buy.show', compact('session', 'userAlreadyJoined', 'isExpired', 'isCompleted', 'secondsRemaining'));
    }

    public function start(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please log in to start a Group Buy team.');
        }

        // Redirect to checkout with order_type = group_buy and start_new = 1
        return redirect()->route('checkout', [
            'product_id' => $product->id,
            'type' => 'group_buy',
            'action' => 'start_new',
        ]);
    }

    public function join(GroupBuySession $session)
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

        // Redirect to checkout with group session ID
        return redirect()->route('checkout', [
            'product_id' => $session->product_id,
            'type' => 'group_buy',
            'session_id' => $session->id,
            'action' => 'join_existing',
        ]);
    }
}
