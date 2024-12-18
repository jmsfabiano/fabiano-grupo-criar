<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        return Product::create($request->all());
    }

    public function show(Product $product)
    {
        if (!$product->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        $product->update($request->all());
        return $product;
    }

    public function destroy(Product $product)
    {
        if (!$product->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $product->delete();
        return response()->noContent();
    }
}
