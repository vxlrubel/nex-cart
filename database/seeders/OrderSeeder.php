<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->get();
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery'];

        foreach ($users as $user) {
            $orderCount = rand(1, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                $status = $statuses[array_rand($statuses)];
                $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'payment_method' => $paymentMethod,
                    'payment_transaction_id' => 'TXN-'.strtoupper(uniqid()),
                    'subtotal' => 0,
                    'tax' => 0,
                    'shipping_cost' => rand(5, 20),
                    'discount' => 0,
                    'total' => 0,
                    'shipping_name' => $user->name,
                    'shipping_email' => $user->email,
                    'shipping_phone' => '+1234567890',
                    'shipping_address' => '123 Main Street',
                    'shipping_city' => 'New York',
                    'shipping_state' => 'NY',
                    'shipping_postal_code' => '10001',
                    'shipping_country' => 'US',
                    'notes' => null,
                    'ordered_at' => now()->subDays(rand(1, 30)),
                ]);

                $products = Product::inRandomOrder()->take(rand(2, 4))->get();
                $subtotal = 0;

                foreach ($products as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    $total = $price * $quantity;
                    $subtotal += $total;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'variant_id' => null,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'variant_name' => null,
                        'price' => $price,
                        'quantity' => $quantity,
                        'total' => $total,
                    ]);
                }

                $tax = $subtotal * 0.1;
                $discount = rand(0, 1) ? rand(5, 20) : 0;
                $total = $subtotal + $tax + $order->shipping_cost - $discount;

                $order->update([
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => $discount,
                    'total' => $total,
                ]);

                if ($paymentStatus === 'paid') {
                    Payment::create([
                        'order_id' => $order->id,
                        'user_id' => $user->id,
                        'method' => $paymentMethod,
                        'transaction_id' => 'PAY-'.strtoupper(uniqid()),
                        'amount' => $total,
                        'currency' => 'USD',
                        'status' => 'completed',
                        'response_data' => [],
                    ]);
                }
            }
        }
    }
}
