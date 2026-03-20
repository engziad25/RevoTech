<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_id', 'quantity', 'price', 'subtotal', 'options'
    ];

    protected $casts = [
        'options' => 'array',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::saving(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
        });

        static::saved(function ($item) {
            $item->cart->updateTotal();
        });

        static::deleted(function ($item) {
            $item->cart->updateTotal();
        });
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}