<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 50,
                'usage_limit' => 100,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
            ],
            [
                'code' => 'SAVE20',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 100,
                'max_discount' => 50,
                'usage_limit' => 50,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(2),
            ],
            [
                'code' => 'FLAT50',
                'type' => 'fixed',
                'value' => 50,
                'min_order_amount' => 200,
                'usage_limit' => 30,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 10,
                'min_order_amount' => 75,
                'usage_limit' => 200,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(6),
            ],
            [
                'code' => 'VIP25',
                'type' => 'percentage',
                'value' => 25,
                'min_order_amount' => 150,
                'max_discount' => 100,
                'usage_limit' => 10,
                'is_active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addWeek(),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
