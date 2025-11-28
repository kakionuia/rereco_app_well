<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = [
            'Electronics',
            'Home & Garden',
            'Books',
            'Clothing'
        ];

        foreach ($cats as $c) {
            Category::create([
                'name' => $c,
                'slug' => Str::slug($c),
            ]);
        }

        $sample = [
            ['name' => 'Wireless Headphones', 'category' => 'electronics', 'price' => 79.99, 'image' => '/image/tutup.jpg'],
            ['name' => 'Ceramic Plant Pot', 'category' => 'home-garden', 'price' => 24.50, 'image' => '/image/tutup.jpg'],
            ['name' => 'Learning Laravel (Book)', 'category' => 'books', 'price' => 19.99, 'image' => '/image/tutup.jpg'],
            ['name' => 'Casual T-Shirt', 'category' => 'clothing', 'price' => 12.00, 'image' => '/image/tutup.jpg'],
        ];

        foreach ($sample as $p) {
            $cat = Category::where('slug', $p['category'])->first();
            Product::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name'].'-'.Str::random(4)),
                'description' => 'Sample product: '.$p['name'].'. This is a seeded sample item to demo the shop page.',
                'price' => $p['price'],
                'stock' => 10,
                'category_id' => $cat?->id,
                'image' => $p['image'],
                'is_active' => true,
            ]);
        }
    }
}
