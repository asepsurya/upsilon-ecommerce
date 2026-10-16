<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoBanner extends Model
{
    /** @use HasFactory<PromoBannerFactory> */
    use HasFactory;

    protected $fillable = [
        'heading',
        'title',
        'image',
        'image_mobile',
        'link',
        'link_text',
        'background_color',
        'text_color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = ['image_url', 'image_mobile_url'];

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return '';
        }

        return asset(str_starts_with($this->image, 'storage/') ? $this->image : 'storage/'.$this->image);
    }

    public function getImageMobileUrlAttribute(): string
    {
        if (! $this->image_mobile) {
            return '';
        }

        return asset(str_starts_with($this->image_mobile, 'storage/') ? $this->image_mobile : 'storage/'.$this->image_mobile);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc');
    }

    public function scopeSorted(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}
