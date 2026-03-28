<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $managerRole = Role::where('slug', 'manager')->first();
        $customerRole = Role::where('slug', 'customer')->first();

        // Admin gets all permissions
        $adminPermissions = [
            // Products
            'product.view', 'product.create', 'product.update', 'product.delete',
            // Categories
            'category.view', 'category.create', 'category.update', 'category.delete',
            // Orders
            'order.view', 'order.manage', 'order.create',
            // Customers
            'customer.view', 'customer.manage',
            // Coupons
            'coupon.view', 'coupon.create', 'coupon.update', 'coupon.delete',
            // Reviews
            'review.view', 'review.manage',
            // Users
            'user.view', 'user.create', 'user.update', 'user.delete',
            // Roles & Permissions
            'role.view', 'role.create', 'role.update', 'role.delete',
            'permission.manage',
            // Dashboard & Reports
            'dashboard.view', 'report.view',
            // Settings
            'settings.manage',
            // Cart
            'cart.manage', 'checkout.process',
            // Wishlist
            'wishlist.manage',
        ];

        foreach ($adminPermissions as $permission) {
            $adminRole->permissions()->create(['slug' => $permission]);
        }

        // Manager permissions
        $managerPermissions = [
            // Products
            'product.view', 'product.create', 'product.update', 'product.delete',
            // Categories
            'category.view', 'category.create', 'category.update', 'category.delete',
            // Orders
            'order.view', 'order.manage',
            // Reviews
            'review.view', 'review.manage',
            // Coupons
            'coupon.view', 'coupon.create', 'coupon.update', 'coupon.delete',
            // Dashboard
            'dashboard.view', 'report.view',
        ];

        foreach ($managerPermissions as $permission) {
            $managerRole->permissions()->create(['slug' => $permission]);
        }

        // Customer permissions (shopping)
        $customerPermissions = [
            'product.view',
            'category.view',
            'order.view', 'order.create',
            'cart.manage', 'checkout.process',
            'wishlist.manage',
            'review.view',
        ];

        foreach ($customerPermissions as $permission) {
            $customerRole->permissions()->create(['slug' => $permission]);
        }
    }
}
