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
        'name',
        'details',
        'serial_number',
        'unit_price',
        'price',
        'price_after_sale',
        'product_image',
        'category_id',
        'gender',
        'amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'price' => 'decimal:2',
            'price_after_sale' => 'decimal:2',
            'amount' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->price_after_sale ?? $this->price;
    }
}
