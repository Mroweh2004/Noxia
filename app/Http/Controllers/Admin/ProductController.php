<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function sort(Request $request): View
    {
        $sort = $request->get('sort', 'created_at');
        $dir = $request->get('dir', 'desc');
        $products = Product::with('category')->orderBy($sort, $dir)->paginate(15)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'serial_number' => 'required|string|unique:products,serial_number',
            'unit_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'price_after_sale' => 'nullable|numeric|min:0',
            'product_image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'gender' => 'required|in:male,female,unisex',
            'amount' => 'required|integer|min:0',
            'status' => 'required|in:active,out_of_stock',
        ]);
        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', __('Product added.'));
    }

    public function edit(Product $product): View
    {
        $product->load('category');
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'serial_number' => 'required|string|unique:products,serial_number,' . $product->id,
            'unit_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'price_after_sale' => 'nullable|numeric|min:0',
            'product_image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'gender' => 'required|in:male,female,unisex',
            'amount' => 'required|integer|min:0',
            'status' => 'required|in:active,out_of_stock',
        ]);
        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', __('Product updated.'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', __('Product removed.'));
    }
}
