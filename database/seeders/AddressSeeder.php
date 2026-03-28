<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@nexcart.com')->first();

        if ($customer) {
            $addresses = [
                [
                    'user_id' => $customer->id,
                    'type' => 'shipping',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'address_line_1' => '123 Main Street',
                    'city' => 'New York',
                    'state' => 'NY',
                    'postal_code' => '10001',
                    'country' => 'US',
                    'phone' => '+1 (555) 123-4567',
                    'is_default' => true,
                ],
                [
                    'user_id' => $customer->id,
                    'type' => 'billing',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'address_line_1' => '456 Oak Avenue',
                    'city' => 'Los Angeles',
                    'state' => 'CA',
                    'postal_code' => '90001',
                    'country' => 'US',
                    'phone' => '+1 (555) 987-6543',
                    'is_default' => false,
                ],
            ];

            foreach ($addresses as $address) {
                Address::create($address);
            }
        }

        $admin = User::where('email', 'admin@nexcart.com')->first();
        if ($admin) {
            Address::create([
                'user_id' => $admin->id,
                'type' => 'shipping',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'address_line_1' => '789 Admin Plaza',
                'city' => 'San Francisco',
                'state' => 'CA',
                'postal_code' => '94102',
                'country' => 'US',
                'phone' => '+1 (555) 000-0000',
                'is_default' => true,
            ]);
        }
    }
}
