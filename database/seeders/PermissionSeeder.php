<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Product permissions
            ['name' => 'product.view', 'slug' => 'product.view', 'description' => 'View products'],
            ['name' => 'product.create', 'slug' => 'product.create', 'description' => 'Create products'],
            ['name' => 'product.update', 'slug' => 'product.update', 'description' => 'Update products'],
            ['name' => 'product.delete', 'slug' => 'product.delete', 'description' => 'Delete products'],

            // Category permissions
            ['name' => 'category.view', 'slug' => 'category.view', 'description' => 'View categories'],
            ['name' => 'category.create', 'slug' => 'category.create', 'description' => 'Create categories'],
            ['name' => 'category.update', 'slug' => 'category.update', 'description' => 'Update categories'],
            ['name' => 'category.delete', 'slug' => 'category.delete', 'description' => 'Delete categories'],

            // Order permissions
            ['name' => 'order.view', 'slug' => 'order.view', 'description' => 'View orders'],
            ['name' => 'order.manage', 'slug' => 'order.manage', 'description' => 'Manage orders (update status, cancel)'],
            ['name' => 'order.create', 'slug' => 'order.create', 'description' => 'Create orders'],

            // Customer permissions
            ['name' => 'customer.view', 'slug' => 'customer.view', 'description' => 'View customers'],
            ['name' => 'customer.manage', 'slug' => 'customer.manage', 'description' => 'Manage customers'],

            // Coupon permissions
            ['name' => 'coupon.view', 'slug' => 'coupon.view', 'description' => 'View coupons'],
            ['name' => 'coupon.create', 'slug' => 'coupon.create', 'description' => 'Create coupons'],
            ['name' => 'coupon.update', 'slug' => 'coupon.update', 'description' => 'Update coupons'],
            ['name' => 'coupon.delete', 'slug' => 'coupon.delete', 'description' => 'Delete coupons'],

            // Review permissions
            ['name' => 'review.view', 'slug' => 'review.view', 'description' => 'View reviews'],
            ['name' => 'review.manage', 'slug' => 'review.manage', 'description' => 'Manage reviews (approve/reject)'],

            // User management permissions
            ['name' => 'user.view', 'slug' => 'user.view', 'description' => 'View users'],
            ['name' => 'user.create', 'slug' => 'user.create', 'description' => 'Create users'],
            ['name' => 'user.update', 'slug' => 'user.update', 'description' => 'Update users'],
            ['name' => 'user.delete', 'slug' => 'user.delete', 'description' => 'Delete users'],

            // Role & Permission permissions
            ['name' => 'role.view', 'slug' => 'role.view', 'description' => 'View roles'],
            ['name' => 'role.create', 'slug' => 'role.create', 'description' => 'Create roles'],
            ['name' => 'role.update', 'slug' => 'role.update', 'description' => 'Update roles'],
            ['name' => 'role.delete', 'slug' => 'role.delete', 'description' => 'Delete roles'],
            ['name' => 'permission.manage', 'slug' => 'permission.manage', 'description' => 'Manage permissions'],

            // Dashboard & Reports
            ['name' => 'dashboard.view', 'slug' => 'dashboard.view', 'description' => 'View dashboard'],
            ['name' => 'report.view', 'slug' => 'report.view', 'description' => 'View reports'],

            // Settings
            ['name' => 'settings.manage', 'slug' => 'settings.manage', 'description' => 'Manage system settings'],

            // Cart & Checkout (customer actions)
            ['name' => 'cart.manage', 'slug' => 'cart.manage', 'description' => 'Manage shopping cart'],
            ['name' => 'checkout.process', 'slug' => 'checkout.process', 'description' => 'Process checkout'],

            // Wishlist
            ['name' => 'wishlist.manage', 'slug' => 'wishlist.manage', 'description' => 'Manage wishlist'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
