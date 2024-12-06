<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        return Discount::with('campaign')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'type' => 'required|in:percentage,value',
            'value' => 'required|numeric|min:0',
        ]);
        return Discount::create($request->all());
    }

    public function show(Discount $discount)
    {
        return $discount->load('campaign');
    }

    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'type' => 'required|in:percentage,value',
            'value' => 'required|numeric|min:0',
        ]);
        $discount->update($request->all());
        return $discount;
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->noContent();
    }
}
