<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->get();

        foreach ($users as $user) {
            $cart = Cart::create([
                'user_id' => $user->id,
                'session_id' => null,
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
            ]);

            $products = Product::inRandomOrder()->take(rand(1, 3))->get();

            foreach ($products as $product) {
                $quantity = rand(1, 2);
                $price = $product->price;
                $total = $price * $quantity;

                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'variant_id' => null,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ]);
            }

            $cart->calculateTotals();
        }
    }
}
