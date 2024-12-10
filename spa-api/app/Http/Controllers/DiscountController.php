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
            'minimum_value' => 'required|numeric|min:0.01',
        ]);
        $data = [
            'campaign_id' => $request->campaign_id,
            'minimum_value' => $request->minimum_value,
        ];
        if ($request->type === 'percentage') {
            $data['percentage_discount'] = $request->value;
        } else {
            $data['value_discount'] = $request->value;
        }
        return Discount::create($data);
    }

    public function show(Discount $discount)
    {
        if (!$discount->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return $discount->load('campaign');
    }

    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'type' => 'required|in:percentage,value',
            'value' => 'required|numeric|min:0',
            'minimum_value' => 'required|numeric|min:0.01',
        ]);
        $data = [
            'campaign_id' => $request->campaign_id,
            'minimum_value' => $request->minimum_value,
        ];
        if ($request->type === 'percentage') {
            $data['percentage_discount'] = $request->value;
            $data['value_discount'] = null;
        } else {
            $data['value_discount'] = $request->value;
            $data['percentage_discount'] = null;
        }
        $discount->update($data);
        return $discount;
    }

    public function destroy(Discount $discount)
    {
        if (!$discount->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $discount->delete();
        return response()->noContent();
    }
}
