<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function index()
    {
        $positions = app(Position::class)->all();
        $view = "Position/Index";
        return Inertia::render($view,[
            'positions' => $positions
        ]);
    }
    public function create()
    {
        $view = "Position/Create";
        return Inertia::render($view);
    }
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string',
        ]);
        
        app(Position::class)->create([
            'name' => $input['name'],
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id
        ]);
        return redirect()->route('position.index');
    }
    public function edit($id){
        $position = app(Position::class)->find($id);
        $view = "Position/Edit";
        return Inertia::render($view,[
           'position' => $position
        ]);
    }

    public function update($id, Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string',
        ]);
        $position = app(Position::class)->find($id);
        $position->update([
            'name' => $input['name'],
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id
        ]);
        return redirect()->route('position.index');
    }
    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('position.index');
    }
}
