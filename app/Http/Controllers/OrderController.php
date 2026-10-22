<?php

namespace App\Http\Controllers;

use App\Models\GroupBuyMember;
use App\Models\GroupBuySession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        $orderType = $request->input('type', 'single'); // single or group_buy
        $action = $request->input('action', 'buy_single'); // buy_single, start_new, join_existing
        $sessionId = $request->input('session_id');

        $session = null;
        if ($sessionId) {
            $session = GroupBuySession::findOrFail($sessionId);
            if ($session->isExpired() || $session->isCompleted()) {
                return redirect()->route('products.show', $product->slug)
                    ->with('error', 'এই গ্রুপটির সময় শেষ হয়ে গেছে অথবা ইতোমধ্যে সম্পূর্ণ হয়ে গেছে।');
            }
        }

        $quantity = max(1, min((int) $request->input('quantity', 1), max(1, $product->stock)));

        if ($orderType === 'group_buy') {
            $unitPrice = (float) $product->group_price;
            if ($session) {
                $remaining = $session->remainingSlots();
                $quantity = min($quantity, max(1, $remaining));
            }
        } else {
            // Method 2: Dynamic Bulk Tier Pricing for Solo Buy
            $unitPrice = $product->getSoloUnitPrice($quantity);
        }

        $subtotal = $unitPrice * $quantity;
        $shipping = 0.00; // Free shipping promo
        $total = $subtotal + $shipping;

        $user = Auth::user();

        return view('orders.checkout', compact('product', 'orderType', 'action', 'session', 'unitPrice', 'quantity', 'subtotal', 'shipping', 'total', 'user'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_type' => 'required|in:single,group_buy',
            'action' => 'required|string',
            'quantity' => 'nullable|integer|min:1',
            'session_id' => 'nullable|exists:group_buy_sessions,id',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        $orderType = $request->order_type;
        $action = $request->action;

        $quantity = max(1, (int) $request->input('quantity', 1));

        // Real-time stock validation
        if ($product->stock < $quantity) {
            return back()->with('error', 'দুঃখিত, এই পণ্যের মাত্র ' . $product->stock . 'টি পণ্য স্টকে রয়েছে।');
        }

        if ($orderType === 'group_buy') {
            $unitPrice = (float) $product->group_price;
        } else {
            // Method 2: Dynamic Bulk Tier Pricing for Solo Buy
            $unitPrice = $product->getSoloUnitPrice($quantity);
        }

        $total = $unitPrice * $quantity;
        $createdSession = null;

        $order = DB::transaction(function () use ($request, $user, $product, $orderType, $action, $unitPrice, $quantity, $total, &$createdSession) {
            $sessionId = null;
            $orderStatus = 'processing';

            if ($orderType === 'group_buy') {
                if ($action === 'start_new') {
                    $targetUnits = (int) $product->group_size_required;
                    // If the user's quantity already meets or exceeds target quota, instant complete!
                    $isInstantComplete = ($quantity >= $targetUnits);

                    $createdSession = GroupBuySession::create([
                        'product_id' => $product->id,
                        'leader_user_id' => $user->id,
                        'group_code' => 'GRP-' . strtoupper(Str::random(6)),
                        'required_members' => $targetUnits,
                        'current_members' => $quantity, // Unit/Quantity-based quota
                        'status' => $isInstantComplete ? 'completed' : 'active',
                        'expires_at' => now()->addHours($product->group_duration_hours),
                    ]);

                    $sessionId = $createdSession->id;
                    $orderStatus = $isInstantComplete ? 'processing' : 'pending_group';

                    GroupBuyMember::create([
                        'group_buy_session_id' => $createdSession->id,
                        'user_id' => $user->id,
                        'is_leader' => true,
                        'joined_at' => now(),
                    ]);
                } elseif ($action === 'join_existing') {
                    $existingSession = GroupBuySession::lockForUpdate()->findOrFail($request->session_id);

                    if ($existingSession->isExpired() || $existingSession->isCompleted()) {
                        throw new \Exception('এই গ্রুপটির সময় শেষ হয়ে গেছে অথবা ইতোমধ্যে সম্পূর্ণ হয়ে গেছে।');
                    }

                    $remaining = $existingSession->remainingSlots();
                    if ($quantity > $remaining) {
                        throw new \Exception('এই গ্রুপটি সম্পন্ন করতে আর মাত্র ' . $remaining . 'টি স্লট বাকি আছে।');
                    }

                    $newTotalUnits = $existingSession->current_members + $quantity;
                    $isCompleted = ($newTotalUnits >= $existingSession->required_members);

                    $existingSession->update([
                        'current_members' => $newTotalUnits,
                        'status' => $isCompleted ? 'completed' : 'active',
                    ]);

                    $sessionId = $existingSession->id;
                    $createdSession = $existingSession;

                    // Support multiple contributions by existing members without unique key conflict
                    GroupBuyMember::firstOrCreate([
                        'group_buy_session_id' => $existingSession->id,
                        'user_id' => $user->id,
                    ], [
                        'is_leader' => false,
                        'joined_at' => now(),
                    ]);

                    if ($isCompleted) {
                        $orderStatus = 'processing';
                        // Transition all previous members' orders in this session to processing
                        Order::where('group_buy_session_id', $existingSession->id)
                            ->where('order_status', 'pending_group')
                            ->update(['order_status' => 'processing']);
                    } else {
                        $orderStatus = 'pending_group';
                    }
                }
            }

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'order_type' => $orderType,
                'group_buy_session_id' => $sessionId,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'order_status' => $orderStatus,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'order_notes' => $request->order_notes,
            ]);

            // Create Order Item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $total,
            ]);

            // Real-time stock decrement and sales increment
            $product->decrement('stock', $quantity);
            $product->increment('sales_count', $quantity);

            return $order;
        });

        if ($orderType === 'group_buy' && $createdSession) {
            if ($createdSession->status === 'completed') {
                return redirect()->route('group-buy.show', $createdSession->group_code)
                    ->with('success', 'অভিনন্দন! আপনার গ্রুপের সম্পূর্ণ কোটা পূরণ হয়েছে এবং অর্ডারটি প্রসেসিং শুরু হয়েছে।');
            }
            return redirect()->route('group-buy.show', $createdSession->group_code)
                ->with('success', 'গ্রুপ সফলভাবে শুরু হয়েছে! বাকি স্লট পূরণ করতে বন্ধুদের সাথে শেয়ার করুন।');
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে!');
    }

    public function index()
    {
        $orders = Order::with(['items.product', 'groupSession'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id() || Auth::user()->isAdmin(), 403);

        $order->load(['items.product.seller', 'groupSession.members.user']);

        return view('orders.show', compact('order'));
    }
}
