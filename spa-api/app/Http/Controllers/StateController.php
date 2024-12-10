<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        return State::orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:states,name',
            'abbreviation' => 'required|string|max:2|unique:states,abbreviation'
        ]);
        return State::create($request->all());
    }

    public function show(State $state)
    {
        if (!$state->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return $state;
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:states,name,'.$state->id,
            'abbreviation' => 'required|string|max:2|unique:states,abbreviation,'.$state->id
        ]);
        $state->update($request->all());
        return $state;
    }

    public function destroy(State $state)
    {
        if (!$state->exists()) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $state->delete();
        return response()->noContent();
    }
}
