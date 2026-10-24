<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'status_reason',
        'shop_name',
        'shop_slug',
        'business_category',
        'shop_description',
        'shop_banner',
        'phone',
        'whatsapp_number',
        'facebook_page',
        'dispatch_time',
        'return_policy',
        'address',
        'warehouse_address',
        'payout_method',
        'payout_details',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer' || empty($this->role);
    }

    public function isActive(): bool
    {
        return ($this->status ?? 'active') === 'active' || ($this->isSeller() && $this->status === 'approved');
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function groupMemberships(): HasMany
    {
        return $this->hasMany(GroupBuyMember::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ledGroupSessions(): HasMany
    {
        return $this->hasMany(GroupBuySession::class, 'leader_user_id');
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if (empty($this->avatar)) return null;
        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }
        return asset('storage/' . ltrim($this->avatar, '/'));
    }

    public function getBannerUrlAttribute(): ?string
    {
        if (empty($this->shop_banner)) return null;
        if (str_starts_with($this->shop_banner, 'http://') || str_starts_with($this->shop_banner, 'https://')) {
            return $this->shop_banner;
        }
        return asset('storage/' . ltrim($this->shop_banner, '/'));
    }

    public function getShopSlugAttribute(): string
    {
        return $this->attributes['shop_slug'] ?? \Illuminate\Support\Str::slug($this->shop_name ?? $this->name);
    }

    public function getTotalSpentAttribute(): float
    {
        return (float) $this->orders()->where('order_status', '!=', 'cancelled')->sum('total_amount');
    }

    public function getTotalSavingsAttribute(): float
    {
        $groupOrders = $this->orders()->where('order_type', 'group_buy')->where('order_status', '!=', 'cancelled')->get();
        return (float) ($groupOrders->sum('total_amount') * 0.25);
    }
}
