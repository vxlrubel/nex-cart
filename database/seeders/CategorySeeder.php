<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest gadgets and electronic devices',
                'is_active' => true,
                'order' => 1,
                'children' => [
                    ['name' => 'Smartphones', 'slug' => 'smartphones', 'is_active' => true],
                    ['name' => 'Laptops', 'slug' => 'laptops', 'is_active' => true],
                    ['name' => 'Tablets', 'slug' => 'tablets', 'is_active' => true],
                    ['name' => 'Accessories', 'slug' => 'electronics-accessories', 'is_active' => true],
                ],
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing, shoes and accessories',
                'is_active' => true,
                'order' => 2,
                'children' => [
                    ['name' => 'Men', 'slug' => 'men-fashion', 'is_active' => true],
                    ['name' => 'Women', 'slug' => 'women-fashion', 'is_active' => true],
                    ['name' => 'Shoes', 'slug' => 'shoes', 'is_active' => true],
                    ['name' => 'Watches', 'slug' => 'watches', 'is_active' => true],
                ],
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Furniture and home decor',
                'is_active' => true,
                'order' => 3,
                'children' => [
                    ['name' => 'Furniture', 'slug' => 'furniture', 'is_active' => true],
                    ['name' => 'Home Decor', 'slug' => 'home-decor', 'is_active' => true],
                    ['name' => 'Bedding', 'slug' => 'bedding', 'is_active' => true],
                    ['name' => 'Kitchen', 'slug' => 'kitchen', 'is_active' => true],
                ],
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports equipment and fitness',
                'is_active' => true,
                'order' => 4,
                'children' => [
                    ['name' => 'Fitness', 'slug' => 'fitness', 'is_active' => true],
                    ['name' => 'Outdoor', 'slug' => 'outdoor', 'is_active' => true],
                    ['name' => 'Cycling', 'slug' => 'cycling', 'is_active' => true],
                ],
            ],
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Skincare and cosmetics',
                'is_active' => true,
                'order' => 5,
                'children' => [
                    ['name' => 'Skincare', 'slug' => 'skincare', 'is_active' => true],
                    ['name' => 'Makeup', 'slug' => 'makeup', 'is_active' => true],
                    ['name' => 'Fragrances', 'slug' => 'fragrances', 'is_active' => true],
                ],
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books, eBooks and audiobooks',
                'is_active' => true,
                'order' => 6,
                'children' => [
                    ['name' => 'Fiction', 'slug' => 'fiction', 'is_active' => true],
                    ['name' => 'Non-Fiction', 'slug' => 'non-fiction', 'is_active' => true],
                    ['name' => 'Children Books', 'slug' => 'children-books', 'is_active' => true],
                ],
            ],
        ];

        foreach ($categories as $cat) {
            $children = $cat['children'] ?? [];
            unset($cat['children']);

            $category = Category::create($cat);

            foreach ($children as $child) {
                Category::create([
                    'name' => $child['name'],
                    'slug' => $child['slug'],
                    'parent_id' => $category->id,
                    'is_active' => $child['is_active'],
                ]);
            }
        }
    }
}
