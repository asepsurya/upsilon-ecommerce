<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\VoucherUsage;

class VoucherService
{
    public function validate(string $code, float $subtotal, ?int $userId = null, ?string $sessionId = null): ?Voucher
    {
        $voucher = Voucher::byCode($code)->valid()->first();

        if (! $voucher) {
            return null;
        }

        if ($subtotal < $voucher->min_purchase) {
            return null;
        }

        if ($voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit) {
            return null;
        }

        $alreadyUsed = VoucherUsage::where('voucher_id', $voucher->id)
            ->where(function ($q) use ($userId, $sessionId) {
                $q->when($userId, fn ($q) => $q->where('user_id', $userId))
                    ->when(! $userId && $sessionId, fn ($q) => $q->where('session_id', $sessionId));
            })->exists();

        if ($alreadyUsed) {
            return null;
        }

        return $voucher;
    }

    public function calculateDiscount(Voucher $voucher, float $subtotal): float
    {
        if ($voucher->type === 'percentage') {
            $discount = $subtotal * ($voucher->value / 100);
        } else {
            $discount = $voucher->value;
        }

        if ($voucher->max_discount && $discount > $voucher->max_discount) {
            $discount = $voucher->max_discount;
        }

        return min($discount, $subtotal);
    }

    public function apply(Voucher $voucher, float $subtotal, ?int $userId = null, ?string $sessionId = null, ?int $orderId = null): float
    {
        $discount = $this->calculateDiscount($voucher, $subtotal);

        VoucherUsage::create([
            'voucher_id' => $voucher->id,
            'user_id' => $userId,
            'session_id' => $sessionId,
            'order_id' => $orderId,
            'discount_amount' => $discount,
        ]);

        $voucher->increment('used_count');

        return $discount;
    }
}
