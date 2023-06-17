<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PositionController extends Controller
{
    public function index()
    {
        // $str= config('face-recognition.python_version')." ".config('face-recognition.face_enc');
        // $exec = exec($str);
        // dd($exec);
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });

        $positions = QueryBuilder::for(Position::class)
            ->defaultSort('name')
            ->allowedSorts(['name', 'is_active'])
            ->allowedFilters(['name', 'is_active', $globalSearch])
            ->paginate()
            ->withQueryString();
        $view = "Position/Index";
        return Inertia::render($view, [
            'positions' => $positions
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false)
              ->column(key: 'is_active',sortable: true)
              ->column(label: 'Actions');
        });
    }
    public function create()
    {
        $view = "Position/Create";
        return Inertia::render($view);
    }
    public function store(Request $request)
    {
        dd($request->image);
        $input = $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $position = app(Position::class)->create([
            'name' => $input['name'],
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id
        ]);

        if($request->hasFile('image')){
            $position->addMediaFromRequest('image')->toMediaCollection('image');
        }
        
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
