<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $managerRole = Role::where('slug', 'manager')->first();
        $customerRole = Role::where('slug', 'customer')->first();

        $allPermissions = Permission::all()->pluck('id', 'slug')->toArray();

        // Admin gets all permissions
        $adminPermissions = [
            'product.view', 'product.create', 'product.update', 'product.delete',
            'category.view', 'category.create', 'category.update', 'category.delete',
            'order.view', 'order.manage', 'order.create',
            'customer.view', 'customer.manage',
            'coupon.view', 'coupon.create', 'coupon.update', 'coupon.delete',
            'review.view', 'review.manage',
            'user.view', 'user.create', 'user.update', 'user.delete',
            'role.view', 'role.create', 'role.update', 'role.delete',
            'permission.manage',
            'dashboard.view', 'report.view',
            'settings.manage',
            'cart.manage', 'checkout.process',
            'wishlist.manage',
        ];

        $adminRole->permissions()->attach(
            array_intersect_key($allPermissions, array_flip($adminPermissions))
        );

        // Manager permissions
        $managerPermissions = [
            'product.view', 'product.create', 'product.update', 'product.delete',
            'category.view', 'category.create', 'category.update', 'category.delete',
            'order.view', 'order.manage',
            'review.view', 'review.manage',
            'coupon.view', 'coupon.create', 'coupon.update', 'coupon.delete',
            'dashboard.view', 'report.view',
        ];

        $managerRole->permissions()->attach(
            array_intersect_key($allPermissions, array_flip($managerPermissions))
        );

        // Customer permissions
        $customerPermissions = [
            'product.view',
            'category.view',
            'order.view', 'order.create',
            'cart.manage', 'checkout.process',
            'wishlist.manage',
            'review.view',
        ];

        $customerRole->permissions()->attach(
            array_intersect_key($allPermissions, array_flip($customerPermissions))
        );
    }
}
