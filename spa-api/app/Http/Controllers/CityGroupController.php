<?php

namespace App\Http\Controllers;

use App\Models\CityGroup;
use Illuminate\Http\Request;

class CityGroupController extends Controller
{
    public function index()
    {
        return CityGroup::with('cities')->get();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        return CityGroup::create($request->all());
    }

    public function show(CityGroup $cityGroup)
    {
        return $cityGroup->load('cities');
    }

    public function update(Request $request, CityGroup $cityGroup)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $cityGroup->update($request->all());
        return $cityGroup;
    }

    public function destroy(CityGroup $cityGroup)
    {
        $cityGroup->delete();
        return response()->noContent();
    }
}
