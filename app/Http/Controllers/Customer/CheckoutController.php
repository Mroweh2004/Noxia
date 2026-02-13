<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Cart $cart)
    {
        $this->authorize('view', $cart);
        $cart->load('cartItems.product');
        return view('customer.checkout.show', compact('cart'));
    }

    public function pay(Cart $cart, Request $request)
    {
        $this->authorize('update', $cart);
        // TODO: Process payment (gateway integration), create order, clear cart.
        $cart->update(['status' => 'checked_out']);
        return redirect()->route('customer.checkout.confirmation')->with('success', __('Order placed successfully.'));
    }

    public function confirmation()
    {
        return view('customer.checkout.confirmation');
    }
}
