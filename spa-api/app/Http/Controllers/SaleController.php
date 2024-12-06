<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return Sale::with(['city', 'products'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $sale = Sale::create([
            'city_id' => $request->city_id,
            'total_price' => 0, // Será calculado
            'applied_discount' => 0,
        ]);

        $totalPrice = 0;
        foreach ($request->products as $product) {
            $sale->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            $totalPrice += $product['quantity'] * Product::find($product['id'])->price;
        }

        $sale->update(['total_price' => $totalPrice]);

        return $sale->load('products');
    }
}
