<?php

namespace App\Http\Controllers;

use App\Models\CityGroup;
use Illuminate\Http\Request;

class CityGroupController extends Controller
{
    public function index()
    {
        return CityGroup::orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:city_groups,name'
        ]);
        return CityGroup::create($request->all());
    }

    public function show(CityGroup $cityGroup)
    {
        if (!$cityGroup->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return $cityGroup;
    }

    public function update(Request $request, CityGroup $cityGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:city_groups,name,'.$cityGroup->id
        ]);
        $cityGroup->update($request->all());
        return $cityGroup;
    }

    public function destroy(CityGroup $cityGroup)
    {
        if (!$cityGroup->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $cityGroup->delete();
        return response()->noContent();
    }
}
