<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BundleManual extends Model
{
    protected $table = 'bundle_manual';

    protected $fillable = [
        'bundle_id',
        'sub_bundle_id',
        'product_name',
        'quantity',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'sort_order' => 'integer',
    ];

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class);
    }

    public function subBundle(): BelongsTo
    {
        return $this->belongsTo(SubBundle::class);
    }
}
