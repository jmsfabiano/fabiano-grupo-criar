<?php
namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index()
    {
        return City::with(['state', 'cityGroup'])->orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cities')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id);
                })
            ],
            'state_id' => 'required|exists:states,id',
            'city_group_id' => 'nullable|exists:city_groups,id',
        ]);

        return City::create($request->all());
    }

    public function show(City $city)
    {
        if (!$city->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return $city->load(['state', 'cityGroup']);
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cities')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id);
                })->ignore($city->id)
            ],
            'state_id' => 'required|exists:states,id',
            'city_group_id' => 'nullable|exists:city_groups,id',
        ]);

        $city->update($request->all());
        return $city;
    }

    public function destroy(City $city)
    {
        if (!$city->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $city->delete();
        return response()->noContent();
    }
}

