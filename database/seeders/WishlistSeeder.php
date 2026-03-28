<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->get();

        foreach ($users as $user) {
            $products = Product::inRandomOrder()->take(rand(2, 5))->get();

            foreach ($products as $product) {
                Wishlist::firstOrCreate([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
