<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'session_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function activeItems(): HasMany
    {
        return $this->items()->whereHas('variant', function ($q) {
            $q->where('is_active', true);
        });
    }

    public function getTotalAttribute()
    {
        return $this->items->sum('subtotal');
    }

    public function getCountAttribute()
    {
        return $this->items->sum('quantity');
    }
}
