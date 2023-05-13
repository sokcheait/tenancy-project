<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $position = app(Position::class)->create([
            'name' => $input['name'],
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id
        ]);
        app(Media::class)->create([
            'mediable_id' => $position->id,
            'mediable_type' => Position::class
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
