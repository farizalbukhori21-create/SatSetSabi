<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class StoreController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->with(['products' => fn($q) => $q->where('is_active', true)->with('denominations')])->get();
        $products = Product::where('is_active', true)->with(['category','denominations'])->latest()->get();
        return view('store.index', compact('categories','products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load(['category','denominations' => fn($q) => $q->where('is_active', true)]);
        return view('store.show', compact('product'));
    }
}
