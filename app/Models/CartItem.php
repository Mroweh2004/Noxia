<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'cart_id', 'quantity'];

    protected static function booted(): void
    {
        static::saved(fn (CartItem $item) => $item->cart->recalculateTotal());
        static::deleted(function (CartItem $item): void {
            $cart = Cart::find($item->cart_id);
            if ($cart) {
                $cart->recalculateTotal();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->quantity * ($this->product->price_after_sale ?? $this->product->price);
    }
}
