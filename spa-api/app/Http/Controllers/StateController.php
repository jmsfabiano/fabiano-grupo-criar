<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        return State::all();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        return State::create($request->all());
    }

    public function show(State $state)
    {
        return $state;
    }

    public function update(Request $request, State $state)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $state->update($request->all());
        return $state;
    }

    public function destroy(State $state)
    {
        $state->delete();
        return response()->noContent();
    }
}
