<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupBuySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'leader_user_id',
        'group_code',
        'required_members',
        'min_quota_to_ship',
        'max_buyers_limit',
        'current_members',
        'status',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'required_members' => 'integer',
            'min_quota_to_ship' => 'integer',
            'max_buyers_limit' => 'integer',
            'current_members' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_user_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(GroupBuyMember::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired' || ($this->status === 'active' && $this->expires_at->isPast());
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed' || $this->current_members >= $this->required_members;
    }

    public function getEffectiveMinQuotaAttribute(): int
    {
        if ($this->min_quota_to_ship && $this->min_quota_to_ship > 0) {
            return (int) $this->min_quota_to_ship;
        }
        if ($this->product && $this->product->min_quota_to_ship && $this->product->min_quota_to_ship > 0) {
            return (int) $this->product->min_quota_to_ship;
        }
        return (int) $this->required_members;
    }

    public function hasReachedSoftThreshold(): bool
    {
        return $this->current_members >= $this->effective_min_quota;
    }

    public function remainingSlots(): int
    {
        return max(0, $this->required_members - $this->current_members);
    }

    public function getProgressPercentAttribute(): int
    {
        if ($this->required_members > 0) {
            return min(100, (int) round(($this->current_members / $this->required_members) * 100));
        }
        return 0;
    }

    public function getCurrentMembersCountAttribute(): int
    {
        return (int) $this->current_members;
    }

    public function getRequiredMembersCountAttribute(): int
    {
        return max(1, (int) $this->required_members);
    }

    public function hasUserJoined(int $userId): bool
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    /**
     * Check and expire inactive/timed-out sessions.
     * Implements "Tiered Quota / Soft Threshold Closing":
     * - If current_members >= effective_min_quota, deal successfully locks in & ships!
     * - If current_members < effective_min_quota, it's Hard Failure and automatically refunds.
     */
    public static function checkAndExpireSessions(): void
    {
        $expiredSessions = self::with(['product'])
            ->where('status', 'active')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expiredSessions as $session) {
            $minQuota = $session->effective_min_quota;

            // Tiered Quota / Soft Threshold Check:
            if ($session->current_members >= $minQuota && $session->current_members > 0) {
                // SUCCESS: Soft threshold met! Mark as completed and fulfill orders.
                $session->update(['status' => 'completed']);

                Order::where('group_buy_session_id', $session->id)
                    ->where('order_status', 'pending_group')
                    ->update(['order_status' => 'processing']);
            } else {
                // HARD FAILURE: Below minimum quota. Cancel and refund.
                $session->update(['status' => 'expired']);

                $pendingOrders = Order::where('group_buy_session_id', $session->id)
                    ->where('order_status', 'pending_group')
                    ->get();

                foreach ($pendingOrders as $order) {
                    $order->update([
                        'order_status' => 'cancelled',
                        'payment_status' => 'refunded'
                    ]);

                    foreach ($order->items as $item) {
                        $prod = Product::find($item->product_id);
                        if ($prod) {
                            $prod->increment('stock', $item->quantity);
                            $prod->decrement('sales_count', min($prod->sales_count, (int) $item->quantity));
                        }
                    }
                }
            }
        }
    }
}
