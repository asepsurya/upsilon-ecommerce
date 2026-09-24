<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoucherUsage extends Model
{
    protected $fillable = ['voucher_id', 'order_id', 'user_id', 'session_id', 'discount_amount'];

    protected $casts = [
        'voucher_id' => 'integer',
        'order_id' => 'integer',
        'user_id' => 'integer',
        'discount_amount' => 'decimal:2',
    ];

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
