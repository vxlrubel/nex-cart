<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@nexcart.com',
            'password' => Hash::make('admin123'),
        ]);

        $adminRole = Role::where('slug', 'admin')->first();
        $admin->roles()->attach($adminRole->id);

        // Create manager user
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@nexcart.com',
            'password' => Hash::make('manager123'),
        ]);

        $managerRole = Role::where('slug', 'manager')->first();
        $manager->roles()->attach($managerRole->id);

        // Create test customer
        $customer = User::create([
            'name' => 'John Doe',
            'email' => 'customer@nexcart.com',
            'password' => Hash::make('customer123'),
        ]);

        $customerRole = Role::where('slug', 'customer')->first();
        $customer->roles()->attach($customerRole->id);
    }
}
