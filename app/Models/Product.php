<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'title',
        'slug',
        'description',
        'image_url',
        'gallery',
        'single_price',
        'group_price',
        'tier2_group_price',
        'tier3_group_price',
        'group_size_required',
        'discount_tiers',
        'min_quota_to_ship',
        'max_buyers_limit',
        'group_duration_hours',
        'stock',
        'is_active',
        'approval_status',
        'is_featured',
        'is_hot_deal',
        'is_flash_sale',
        'rating',
        'sales_count',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'discount_tiers' => 'array',
            'single_price' => 'decimal:2',
            'group_price' => 'decimal:2',
            'tier2_group_price' => 'decimal:2',
            'tier3_group_price' => 'decimal:2',
            'is_active' => 'boolean',
            'rating' => 'decimal:2',
            'group_size_required' => 'integer',
            'min_quota_to_ship' => 'integer',
            'max_buyers_limit' => 'integer',
            'stock' => 'integer',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function groupBuySessions(): HasMany
    {
        return $this->hasMany(GroupBuySession::class);
    }

    public function activeGroupSessions(): HasMany
    {
        return $this->hasMany(GroupBuySession::class)
            ->where('status', 'active')
            ->where('expires_at', '>', now());
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function getDiscountPercentAttribute(): int
    {
        if ($this->single_price > 0 && $this->single_price > $this->group_price) {
            return (int) round((($this->single_price - $this->group_price) / $this->single_price) * 100);
        }
        return 0;
    }

    public function getSavingsAttribute(): float
    {
        return max(0, (float) ($this->single_price - $this->group_price));
    }

    /**
     * Get all structured tiers (custom intermediate tiers + target tier)
     * Sorted by min_members ascending.
     */
    public function getFormattedTiersAttribute(): array
    {
        $tiers = [];
        $rawTiers = is_array($this->discount_tiers) ? $this->discount_tiers : [];

        foreach ($rawTiers as $tier) {
            $members = (int) ($tier['min_members'] ?? 0);
            $discountPct = (float) ($tier['discount_percent'] ?? 0);

            if ($members > 0 && $discountPct > 0) {
                $calcPrice = round((float) $this->single_price * (1 - ($discountPct / 100)), 2);
                $tiers[$members] = [
                    'min_members' => $members,
                    'discount_percent' => $discountPct,
                    'price' => $calcPrice,
                    'savings' => max(0, round((float) $this->single_price - $calcPrice, 2)),
                    'is_target' => false,
                ];
            }
        }

        // Include Target Group Tier
        $targetMembers = (int) $this->group_size_required;
        $targetDiscount = (float) $this->discount_percent;
        $targetPrice = (float) $this->group_price;

        $tiers[$targetMembers] = [
            'min_members' => $targetMembers,
            'discount_percent' => $targetDiscount,
            'price' => $targetPrice,
            'savings' => max(0, round((float) $this->single_price - $targetPrice, 2)),
            'is_target' => true,
        ];

        ksort($tiers);
        return array_values($tiers);
    }

    /**
     * Get lowest tier minimum member requirement (Safe threshold)
     */
    public function getLowestTierMinMembers(): int
    {
        $tiers = $this->formatted_tiers;
        if (!empty($tiers)) {
            return (int) $tiers[0]['min_members'];
        }
        return (int) ($this->min_quota_to_ship ?: $this->group_size_required);
    }

    /**
     * Find active tier achieved by current member count
     */
    public function getTierForMemberCount(int $members): ?array
    {
        $tiers = $this->formatted_tiers;
        $achieved = null;

        foreach ($tiers as $tier) {
            if ($members >= $tier['min_members']) {
                $achieved = $tier;
            }
        }

        return $achieved;
    }

    /**
     * Calculate price for given member count based on unlocked tier
     */
    public function calculatePriceForMemberCount(int $members): float
    {
        $tier = $this->getTierForMemberCount($members);
        if ($tier) {
            return (float) $tier['price'];
        }
        return (float) $this->single_price;
    }

    /**
     * Calculate tiered unit price for Solo / Direct Buy
     * Tier 1 (1 unit): Full Retail Single Price
     * Tier 2 (2 units): Mini Bulk (80% towards wholesale group price)
     * Tier 3 (3+ units): Direct Wholesale Group Price
     */
    public function getSoloUnitPrice(int $quantity = 1): float
    {
        $single = (float) $this->single_price;
        $group = (float) $this->group_price;

        if ($quantity >= 3) {
            return $group;
        } elseif ($quantity === 2) {
            $diff = $single - $group;
            $tier2 = $single - ($diff * 0.8);
            return (float) round($tier2, -1);
        }

        return $single;
    }

    public function getTier2PriceAttribute(): float
    {
        return $this->getSoloUnitPrice(2);
    }

    /**
     * Scope query to only products that are active, approved, and belong to approved sellers
     */
    public function scopeMarketplaceVisible($query)
    {
        return $query->where('is_active', true)
            ->where('approval_status', 'approved')
            ->where(function ($q) {
                $q->whereNull('seller_id')
                  ->orWhereHas('seller', function ($sq) {
                      $sq->where('status', 'approved');
                  });
            });
    }
}
