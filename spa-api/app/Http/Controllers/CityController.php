<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return City::with(['state', 'cityGroup'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'city_group_id' => 'nullable|exists:city_groups,id',
        ]);
        return City::create($request->all());
    }

    public function show(City $city)
    {
        return $city->load(['state', 'cityGroup']);
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'city_group_id' => 'nullable|exists:city_groups,id',
        ]);
        $city->update($request->all());
        return $city;
    }

    public function destroy(City $city)
    {
        $city->delete();
        return response()->noContent();
    }
}
