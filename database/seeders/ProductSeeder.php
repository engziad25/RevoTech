<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $smartphoneCategory = Category::where('slug', 'smartphones')->first();
        $laptopCategory = Category::where('slug', 'laptops')->first();
        $appleBrand = Brand::where('slug', 'apple')->first();
        $samsungBrand = Brand::where('slug', 'samsung')->first();

        // تأكد من وجود التصنيفات والعلامات التجارية
        if (!$smartphoneCategory || !$laptopCategory || !$appleBrand || !$samsungBrand) {
            $this->command->info('Categories or brands not found. Please run CategorySeeder and BrandSeeder first.');
            return;
        }

        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'description' => 'The ultimate iPhone with titanium design and A17 Pro chip',
                'short_description' => '6.7-inch Super Retina XDR display with ProMotion',
                'price' => 1199.99,
                'compare_price' => 1299.99,
                'stock_quantity' => 50,
                'sku' => 'IP15PM-256',
                'category_id' => $smartphoneCategory->id,
                'brand_id' => $appleBrand->id,
                'images' => '/images/products/iphone-15-pro-max-1.jpg',
                'specifications' => json_encode([
                    'Display' => '6.7-inch Super Retina XDR',
                    'Processor' => 'A17 Pro',
                    'RAM' => '8GB',
                    'Storage' => '256GB',
                    'Camera' => '48MP Main + 12MP Ultra Wide + 12MP Telephoto',
                ]),
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
                'review_count' => 125,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => 'samsung-galaxy-s24-ultra',
                'description' => 'Experience the power of AI with the Galaxy S24 Ultra',
                'short_description' => '6.8-inch Dynamic AMOLED 2X display',
                'price' => 1199.99,
                'compare_price' => 1299.99,
                'stock_quantity' => 45,
                'sku' => 'SGS24U-512',
                'category_id' => $smartphoneCategory->id,
                'brand_id' => $samsungBrand->id,
                'images' => '/images/products/samsung-s24-ultra-1.jpg',
                'specifications' => json_encode([
                    'Display' => '6.8-inch Dynamic AMOLED 2X',
                    'Processor' => 'Snapdragon 8 Gen 3',
                    'RAM' => '12GB',
                    'Storage' => '512GB',
                    'Camera' => '200MP Main + 12MP Ultra Wide + 50MP Telephoto',
                ]),
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.7,
                'review_count' => 98,
            ],
            [
                'name' => 'MacBook Pro 16"',
                'slug' => 'macbook-pro-16',
                'description' => 'The most powerful MacBook Pro ever with M3 Max chip',
                'short_description' => '16-inch Liquid Retina XDR display',
                'price' => 2499.99,
                'compare_price' => 2699.99,
                'stock_quantity' => 30,
                'sku' => 'MBP16-M3-1TB',
                'category_id' => $laptopCategory->id,
                'brand_id' => $appleBrand->id,
                'images' => '/images/products/macbook-pro-16-1.jpg',
                'specifications' => json_encode([
                    'Display' => '16-inch Liquid Retina XDR',
                    'Processor' => 'M3 Max (16-core)',
                    'RAM' => '48GB',
                    'Storage' => '1TB SSD',
                    'Battery' => 'Up to 22 hours',
                ]),
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.9,
                'review_count' => 87,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']], // استخدم slug كمعرف فريد
                $product
            );
        }
    }
}