<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'product_id', 'session_id'];

    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeForSession(Builder $query, ?string $sessionId): Builder
    {
        return $query->where('session_id', $sessionId);
    }
}
