<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'user_id',
        'session_id',
        'ip_address',
        'viewed_at',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
        'viewed_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('viewed_at', '>=', now()->subDays($days));
    }
}
