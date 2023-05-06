<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

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
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $imageName=time().$file->getClientOriginalName();
            $filePath = 'images/' . $imageName;
            Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
            // $imagestore = Storage::disk('s3')->temporaryUrl($imageName, \Carbon\Carbon::now()->addMinutes(1));
        }
        $position = app(Position::class)->create([
            'name' => $input['name'],
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id
        ]);
        app(Media::class)->create([
            'mediable_id' => $position->id,
            'mediable_type' => Position::class,
            'path' => $imageName
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
