<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupBuyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_buy_session_id',
        'user_id',
        'is_leader',
        'joined_at',
    ];

    protected function casts(): array
    {
        return [
            'is_leader' => 'boolean',
            'joined_at' => 'datetime',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(GroupBuySession::class, 'group_buy_session_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
