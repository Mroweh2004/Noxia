<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['user', 'cart'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function create(): View
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'cart_id' => 'nullable|exists:carts,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);
        Order::create($validated);
        return redirect()->route('admin.orders.index')->with('success', __('Order added.'));
    }

    public function edit(Order $order): View
    {
        $order->load(['user', 'cart']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'cart_id' => 'nullable|exists:carts,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);
        $order->update($validated);
        return redirect()->route('admin.orders.index')->with('success', __('Order updated.'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);
        $order->update($validated);
        return redirect()->route('admin.orders.index')->with('success', __('Order status updated.'));
    }

    /**
     * Cancel order. Implement passkey verification in this method or via middleware.
     */
    public function cancel(Request $request, Order $order)
    {
        // TODO: Verify passkey before cancelling (e.g. $request->validate(['passkey' => ...]))
        $order->update(['status' => 'cancelled']);
        return redirect()->route('admin.orders.index')->with('success', __('Order cancelled.'));
    }
}
