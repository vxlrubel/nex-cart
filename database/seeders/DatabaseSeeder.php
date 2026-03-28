<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            AttributeSeeder::class,
            CouponSeeder::class,
            AddressSeeder::class,
            ReviewSeeder::class,
            CartSeeder::class,
            OrderSeeder::class,
            WishlistSeeder::class,
        ]);
    }
}
