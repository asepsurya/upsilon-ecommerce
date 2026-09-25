<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id', 'product_variant_id', 'image', 'is_primary', 'sort_order',
    ];

    protected $casts = ['is_primary' => 'boolean'];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return asset(str_starts_with($this->image, 'storage/') ? $this->image : 'storage/'.$this->image);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
