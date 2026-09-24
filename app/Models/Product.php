<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'material', 'size_fit',
        'base_price', 'sale_price', 'is_new_arrival', 'is_featured',
        'is_bestseller', 'sort_order', 'is_active', 'badge', 'edition',
        'subtitle', 'bottom_label',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_new_arrival' => 'boolean',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function activeVariants(): HasMany
    {
        return $this->variants()->where('is_active', true)->where('stock', '>', 0);
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_variants');
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_variants');
    }

    public function carts(): HasManyThrough
    {
        return $this->hasManyThrough(CartItem::class, ProductVariant::class);
    }

    public function wishlists(): HasManyThrough
    {
        return $this->hasManyThrough(Wishlist::class, ProductVariant::class);
    }

    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(OrderItem::class, ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNewArrival($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopePriceBetween($query, $min, $max)
    {
        return $query->where(function ($q) use ($min) {
            $q->where('base_price', '>=', $min)
                ->orWhere('sale_price', '>=', $min);
        })->where(function ($q) use ($max) {
            $q->where('base_price', '<=', $max)
                ->orWhere('sale_price', '<=', $max);
        });
    }

    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?? $this->base_price;
    }

    public function getDiscountPercentAttribute()
    {
        if (! $this->sale_price || $this->sale_price >= $this->base_price) {
            return 0;
        }

        return round((($this->base_price - $this->sale_price) / $this->base_price) * 100);
    }
}
