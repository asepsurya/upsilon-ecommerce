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
        'is_active', 'sort_order', 'bundle_type', 'bundle_original_price',
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

    public function manualItems(): HasMany
    {
        return $this->hasMany(BundleManual::class);
    }

    public function subBundles(): HasMany
    {
        return $this->hasMany(SubBundle::class)->orderBy('sort_order');
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
        // Manual override takes precedence
        if ($this->bundle_original_price && $this->bundle_original_price > 0) {
            return (float) $this->bundle_original_price;
        }

        $catalogTotal = $this->items->sum(function ($item) {
            return ($item->product?->base_price ?? 0) * $item->quantity;
        });

        // Manual items don't have product prices, so we can't calculate original price for them
        return $catalogTotal;
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
