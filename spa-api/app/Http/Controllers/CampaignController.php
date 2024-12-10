<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        return Campaign::with('cityGroup')->orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_group_id' => [
            'required',
            'exists:city_groups,id',
                function ($attribute, $value, $fail) {
                    $existingCampaign = Campaign::where('city_group_id', $value)
                        ->where('is_active', true)
                        ->exists();
                    if ($existingCampaign) {
                        $fail('There is already an active campaign for this group.');
                    }
                },
            ],
            'is_active' => 'required|boolean',
        ]);
        return Campaign::create($request->all());
    }

    public function show(Campaign $campaign)
    {
        if (!$campaign->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return $campaign->load('cityGroup');
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_group_id' => [
            'required',
            'exists:city_groups,id',
                function ($attribute, $value, $fail) use ($campaign) {
                    $existingCampaign = Campaign::where('city_group_id', $value)
                        ->where('is_active', true)
                        ->where('id', '!=', $campaign->id)
                        ->exists();
                        
                    if ($existingCampaign) {
                        $fail('There is already an active campaign for this group.');
                    }
                },
            ],
            'is_active' => 'required|boolean',
        ]);
        $campaign->update($request->all());
        return $campaign;
    }

    public function destroy(Campaign $campaign)
    {
        if (!$campaign->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $campaign->delete();
        return response()->noContent();
    }
}
