<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bundle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'thumbnail', 'bundle_price',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'bundle_price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = ['original_price', 'discount_percent'];

    public function items(): HasMany
    {
        return $this->hasMany(BundleItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_items')
            ->withPivot('quantity');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function getOriginalPriceAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return ($item->product?->base_price ?? 0) * $item->quantity;
        });
    }

    public function getDiscountPercentAttribute(): int
    {
        $originalPrice = $this->original_price;

        if ($originalPrice <= 0 || ! $this->bundle_price) {
            return 0;
        }

        $discount = (($originalPrice - $this->bundle_price) / $originalPrice) * 100;

        return max(0, (int) round($discount));
    }
}
