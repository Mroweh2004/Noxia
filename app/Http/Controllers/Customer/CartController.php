<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product, Cart $cart, Request $request)
    {
        $quantity = (int) $request->input('quantity', 1);
        $item = $cart->cartItems()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = $item->quantity + $quantity;
        $item->save();
        $cart->recalculateTotal();
        return redirect()->route('customer.cart.show', $cart)->with('success', __('Added to cart.'));
    }

    public function remove(Product $product, Cart $cart)
    {
        $cart->cartItems()->where('product_id', $product->id)->delete();
        $cart->recalculateTotal();
        return redirect()->route('customer.cart.show', $cart)->with('success', __('Removed from cart.'));
    }

    public function show(?Cart $cart = null)
    {
        $cart = $cart ?? auth()->user()->carts()->where('status', 'active')->firstOrCreate([], ['status' => 'active', 'total_price' => 0]);
        $cart->load('cartItems.product');
        return view('customer.cart.show', compact('cart'));
    }
}
