<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Electronics',
                'description' => 'Cutting-edge gadgets, devices, and consumer electronics.',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Clothing & Apparel',
                'description' => 'Premium fashion for men, women, and children.',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Home & Living',
                'description' => 'Everything to elevate your home environment.',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Sports & Outdoors',
                'description' => 'Gear and equipment for every active lifestyle.',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Books & Media',
                'description' => 'Expand your knowledge and entertainment collection.',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Beauty & Personal Care',
                'description' => 'Premium skincare, grooming, and wellness products.',
                'sort_order'  => 6,
            ],
        ];

        foreach ($categories as $data) {
            Category::create([
                ...$data,
                'slug'      => Str::slug($data['name']),
                'is_active' => true,
            ]);
        }
    }
}
