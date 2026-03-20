<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Apple', 'slug' => 'apple'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Sony', 'slug' => 'sony'],
            ['name' => 'Microsoft', 'slug' => 'microsoft'],
            ['name' => 'Dell', 'slug' => 'dell'],
            ['name' => 'HP', 'slug' => 'hp'],
            ['name' => 'Lenovo', 'slug' => 'lenovo'],
            ['name' => 'Asus', 'slug' => 'asus'],
            ['name' => 'LG', 'slug' => 'lg'],
            ['name' => 'Bose', 'slug' => 'bose'],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                $brand
            );
        }
    }
}