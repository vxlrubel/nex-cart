<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@nexcart.com')->first();

        if (! $customer) {
            return;
        }

        $products = Product::where('is_active', true)->take(10)->get();

        $reviews = [
            [
                'rating' => 5,
                'title' => 'Amazing product!',
                'comment' => 'This exceeded my expectations. Great quality and fast shipping!',
            ],
            [
                'rating' => 4,
                'title' => 'Very good',
                'comment' => 'Good value for money. Would recommend to others.',
            ],
            [
                'rating' => 5,
                'title' => 'Excellent!',
                'comment' => 'Best purchase I have made recently. Highly recommended!',
            ],
            [
                'rating' => 3,
                'title' => 'Average',
                'comment' => 'It is okay, but expected a bit more for this price.',
            ],
            [
                'rating' => 5,
                'title' => 'Love it!',
                'comment' => 'Perfect for my needs. Great design and functionality.',
            ],
        ];

        foreach ($products as $index => $product) {
            $reviewData = $reviews[$index % count($reviews)];

            Review::create([
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'rating' => $reviewData['rating'],
                'title' => $reviewData['title'],
                'comment' => $reviewData['comment'],
                'is_verified' => true,
                'status' => 'approved',
            ]);
        }
    }
}
