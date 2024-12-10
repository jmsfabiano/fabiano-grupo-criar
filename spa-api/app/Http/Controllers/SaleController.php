<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\City;
use App\Models\Product;
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
            'total' => 0,
            'discount_applied' => 0,
        ]);

        $totalPrice = 0;
        foreach ($request->products as $product) {
            $sale->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            $totalPrice += $product['quantity'] * Product::find($product['id'])->price;
        }

        $city = City::with(['cityGroup.campaign.discounts'])->find($request->city_id);
        $discount = 0;

        if ($city->cityGroup && $city->cityGroup->campaign) {
            $campaignDiscount = $city->cityGroup->campaign->discounts->first();
            if ($campaignDiscount) {
                if (!$campaignDiscount->minimum_value || $totalPrice >= $campaignDiscount->minimum_value) {
                    if ($campaignDiscount->type === 'percentage') {
                        $discount = ($totalPrice * $campaignDiscount->percentage_discount) / 100;
                    } else {
                        $discount = $campaignDiscount->value_discount;
                    }
                }
            }
        }

        $sale->update([
            'total' => $totalPrice,
            'discount_applied' => $discount
        ]);

        return $sale->load(['products', 'city.cityGroup.campaign.discounts']);
    }

    public function show(Sale $sale)
    {
        if (!$sale->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return $sale->load(['city', 'products']);
    }
}
