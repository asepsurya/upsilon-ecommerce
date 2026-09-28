<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'min_purchase' => 100,
                'max_discount' => 50,
                'usage_limit' => 100,
                'used_count' => 0,
                'starts_at' => now()->subDays(5),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'FLASH50K',
                'type' => 'fixed',
                'value' => 50000,
                'min_purchase' => 500,
                'max_discount' => null,
                'usage_limit' => 50,
                'used_count' => 0,
                'starts_at' => now()->subDays(2),
                'expires_at' => now()->addDays(5),
                'is_active' => true,
            ],
            [
                'code' => 'VIP20',
                'type' => 'percentage',
                'value' => 20,
                'min_purchase' => 200,
                'max_discount' => 100,
                'usage_limit' => null,
                'used_count' => 0,
                'starts_at' => now(),
                'expires_at' => null,
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED',
                'type' => 'fixed',
                'value' => 25000,
                'min_purchase' => 300,
                'max_discount' => null,
                'usage_limit' => 20,
                'used_count' => 0,
                'starts_at' => now()->subMonths(2),
                'expires_at' => now()->subDays(1),
                'is_active' => false,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}
