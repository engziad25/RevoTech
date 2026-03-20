<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Latest smartphones from top brands',
                'image' => '/images/categories/smartphones.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Powerful laptops for work and gaming',
                'image' => '/images/categories/laptops.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'Portable tablets for entertainment',
                'image' => '/images/categories/tablets.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
                'description' => 'Headphones, speakers, and more',
                'image' => '/images/categories/audio.jpg',
                'sort_order' => 4,
            ],
            [
                'name' => 'Wearables',
                'slug' => 'wearables',
                'description' => 'Smart watches and fitness trackers',
                'image' => '/images/categories/wearables.jpg',
                'sort_order' => 5,
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming consoles and accessories',
                'image' => '/images/categories/gaming.jpg',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            // استخدم firstOrCreate بدلاً من create
            Category::firstOrCreate(
                ['slug' => $category['slug']], // الشرط للبحث
                $category // البيانات للإدخال إذا لم تكن موجودة
            );
        }
    }
}