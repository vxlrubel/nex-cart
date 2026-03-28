<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Full system access with all permissions',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Manage products, orders, and customers',
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Standard customer with shopping privileges',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
