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
        'current_members',
        'status',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'required_members' => 'integer',
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

    public function remainingSlots(): int
    {
        return max(0, $this->required_members - $this->current_members);
    }

    public function hasUserJoined(int $userId): bool
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    /**
     * Check and expire inactive/timed-out sessions, refund pending orders, and release stock
     */
    public static function checkAndExpireSessions(): void
    {
        $expiredSessions = self::where('status', 'active')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expiredSessions as $session) {
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
                    Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                }
            }
        }
    }
}
