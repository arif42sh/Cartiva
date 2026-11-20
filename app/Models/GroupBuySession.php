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
        'discount_tiers',
        'achieved_tier_members',
        'achieved_discount_percent',
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
            'discount_tiers' => 'array',
            'achieved_tier_members' => 'integer',
            'achieved_discount_percent' => 'decimal:2',
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

    /**
     * Get all structured tiers for this session
     */
    public function getAllTiersAttribute(): array
    {
        if ($this->product) {
            return $this->product->formatted_tiers;
        }
        return [];
    }

    /**
     * Get tier currently achieved by current member count
     */
    public function getCurrentAchievedTierAttribute(): ?array
    {
        if ($this->product) {
            return $this->product->getTierForMemberCount($this->current_members);
        }
        return null;
    }

    /**
     * Get next upcoming tier to motivate buyers to invite more
     */
    public function getNextTierAttribute(): ?array
    {
        $tiers = $this->all_tiers;
        foreach ($tiers as $tier) {
            if ($this->current_members < $tier['min_members']) {
                $tier['members_needed'] = max(1, $tier['min_members'] - $this->current_members);
                return $tier;
            }
        }
        return null;
    }

    public function getEffectiveMinQuotaAttribute(): int
    {
        $tiers = $this->all_tiers;
        if (!empty($tiers)) {
            // Lowest milestone guarantees no dismissal!
            return (int) $tiers[0]['min_members'];
        }
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
     * Auto-open next round pool (Round 2 / Group 2) for this product
     * if no other active group currently exists.
     */
    public static function autoSpawnNextPool(Product $product): ?self
    {
        if (!$product || !$product->is_active || $product->stock <= 0) {
            return null;
        }

        $hasActive = self::where('product_id', $product->id)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->exists();

        if ($hasActive) {
            return null;
        }

        return self::create([
            'product_id' => $product->id,
            'leader_user_id' => null, // Open pool ready for first buyer
            'group_code' => 'GRP-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'required_members' => (int) ($product->group_size_required ?: 10),
            'discount_tiers' => $product->discount_tiers,
            'min_quota_to_ship' => $product->min_quota_to_ship,
            'max_buyers_limit' => $product->max_buyers_limit,
            'current_members' => 0,
            'status' => 'active',
            'expires_at' => now()->addHours((int) ($product->group_duration_hours ?: 48)),
        ]);
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
                // SUCCESS: Soft threshold / Tier milestone met! Mark as completed with achieved tier!
                $achievedTier = $session->current_achieved_tier;
                $achievedMembers = $achievedTier['min_members'] ?? $session->current_members;
                $achievedDiscount = $achievedTier['discount_percent'] ?? ($session->product->discount_percent ?? 0);

                $session->update([
                    'status' => 'completed',
                    'achieved_tier_members' => $achievedMembers,
                    'achieved_discount_percent' => $achievedDiscount,
                ]);

                Order::where('group_buy_session_id', $session->id)
                    ->where('order_status', 'pending_group')
                    ->update(['order_status' => 'processing']);

                // Auto-open next pool for this product
                if ($session->product) {
                    self::autoSpawnNextPool($session->product);
                }
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
