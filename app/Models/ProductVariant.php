<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'size_id', 'color_id', 'sku', 'stock',
        'price_override', 'sale_price_override', 'is_active',
    ];

    protected $casts = [
        'stock' => 'integer',
        'price_override' => 'decimal:2',
        'sale_price_override' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_variant_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function getEffectivePriceAttribute()
    {
        if ($this->sale_price_override !== null) {
            return $this->sale_price_override;
        }
        if ($this->product->sale_price !== null) {
            return $this->product->sale_price;
        }

        return $this->price_override ?? $this->product->base_price;
    }

    public function getEffectiveBasePriceAttribute()
    {
        return $this->price_override ?? $this->product->base_price;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->effective_price < $this->effective_base_price;
    }
}
