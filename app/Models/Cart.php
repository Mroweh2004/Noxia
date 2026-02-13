<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'total_price'];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Recalculate and update total_price from cart items.
     */
    public function recalculateTotal(): void
    {
        $this->load('cartItems.product');
        $this->total_price = $this->cartItems->sum(fn (CartItem $item) => $item->quantity * $item->product->effective_price);
        $this->saveQuietly();
    }
}
