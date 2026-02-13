<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->where('status', 'active')->paginate(12);
        return view('products.index', compact('products'));
    }

    public function filter(Request $request): View
    {
        $query = Product::with('category')->where('status', 'active');
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $products = $query->paginate(12)->withQueryString();
        return view('products.index', compact('products'));
    }

    public function search(Request $request): View
    {
        $q = $request->get('q', '');
        $products = Product::with('category')
            ->where('status', 'active')
            ->when($q, fn ($qry) => $qry->where('name', 'like', "%{$q}%")->orWhere('details', 'like', "%{$q}%"))
            ->paginate(12)
            ->withQueryString();
        return view('products.index', compact('products', 'q'));
    }

    public function show(Product $product): View
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }
}
