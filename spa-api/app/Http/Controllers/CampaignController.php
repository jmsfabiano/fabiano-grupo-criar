<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        return Campaign::with('cityGroup')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_group_id' => 'required|exists:city_groups,id',
            'is_active' => 'required|boolean',
        ]);
        return Campaign::create($request->all());
    }

    public function show(Campaign $campaign)
    {
        return $campaign->load('cityGroup');
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_group_id' => 'required|exists:city_groups,id',
            'is_active' => 'required|boolean',
        ]);
        $campaign->update($request->all());
        return $campaign;
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->noContent();
    }
}
