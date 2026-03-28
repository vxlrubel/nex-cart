<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $size = Attribute::create([
            'name' => 'Size',
            'slug' => 'size',
            'description' => 'Product size options',
            'is_active' => true,
        ]);

        $size->values()->createMany([
            ['value' => 'XS', 'slug' => 'xs', 'is_active' => true],
            ['value' => 'S', 'slug' => 's', 'is_active' => true],
            ['value' => 'M', 'slug' => 'm', 'is_active' => true],
            ['value' => 'L', 'slug' => 'l', 'is_active' => true],
            ['value' => 'XL', 'slug' => 'xl', 'is_active' => true],
            ['value' => 'XXL', 'slug' => 'xxl', 'is_active' => true],
        ]);

        $color = Attribute::create([
            'name' => 'Color',
            'slug' => 'color',
            'description' => 'Product color options',
            'is_active' => true,
        ]);

        $color->values()->createMany([
            ['value' => 'Black', 'slug' => 'black', 'color' => '#000000', 'is_active' => true],
            ['value' => 'White', 'slug' => 'white', 'color' => '#ffffff', 'is_active' => true],
            ['value' => 'Blue', 'slug' => 'blue', 'color' => '#3b82f6', 'is_active' => true],
            ['value' => 'Red', 'slug' => 'red', 'color' => '#ef4444', 'is_active' => true],
            ['value' => 'Green', 'slug' => 'green', 'color' => '#22c55e', 'is_active' => true],
            ['value' => 'Pink', 'slug' => 'pink', 'color' => '#ec4899', 'is_active' => true],
            ['value' => 'Gray', 'slug' => 'gray', 'color' => '#6b7280', 'is_active' => true],
            ['value' => 'Navy', 'slug' => 'navy', 'color' => '#1e3a8a', 'is_active' => true],
        ]);

        $storage = Attribute::create([
            'name' => 'Storage',
            'slug' => 'storage',
            'description' => 'Device storage options',
            'is_active' => true,
        ]);

        $storage->values()->createMany([
            ['value' => '128GB', 'slug' => '128gb', 'is_active' => true],
            ['value' => '256GB', 'slug' => '256gb', 'is_active' => true],
            ['value' => '512GB', 'slug' => '512gb', 'is_active' => true],
            ['value' => '1TB', 'slug' => '1tb', 'is_active' => true],
        ]);

        $ram = Attribute::create([
            'name' => 'RAM',
            'slug' => 'ram',
            'description' => 'Device RAM options',
            'is_active' => true,
        ]);

        $ram->values()->createMany([
            ['value' => '8GB', 'slug' => '8gb', 'is_active' => true],
            ['value' => '16GB', 'slug' => '16gb', 'is_active' => true],
            ['value' => '32GB', 'slug' => '32gb', 'is_active' => true],
            ['value' => '64GB', 'slug' => '64gb', 'is_active' => true],
        ]);
    }
}
