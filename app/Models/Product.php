<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'short_description', 'price',
        'compare_price', 'stock_quantity', 'sku', 'category_id', 'brand_id',
        'images', 'specifications', 'is_featured', 'is_active', 'rating',
        'review_count', 'views', 'sales_count'
    ];

    protected $casts = [
        'images' => 'array',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];
    public function category()
{
    return $this->belongsTo(Category::class);
}

public function brand()
{
    return $this->belongsTo(Brand::class);
}


    public function getMainImageAttribute()
{
    return $this->images[0] ?? '/images/placeholder.jpg';
}

    

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFormattedComparePriceAttribute(): ?string
    {
        return $this->compare_price ? '$' . number_format($this->compare_price, 2) : null;
    }
    

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', "%{$term}%")
            ->orWhere('description', 'LIKE', "%{$term}%")
            ->orWhere('sku', 'LIKE', "%{$term}%");
    }
}