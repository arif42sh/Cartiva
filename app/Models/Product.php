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
        'group_size_required',
        'group_duration_hours',
        'stock',
        'is_active',
        'rating',
        'sales_count',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'single_price' => 'decimal:2',
            'group_price' => 'decimal:2',
            'is_active' => 'boolean',
            'rating' => 'decimal:2',
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
}
