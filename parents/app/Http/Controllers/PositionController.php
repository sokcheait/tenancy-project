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
    public function __construct()
    {
         $this->middleware('permission:position.index|position.create|position.edit|position.destroy', ['only' => ['index','store']]);
         $this->middleware('permission:position.create', ['only' => ['create','store']]);
         $this->middleware('permission:position.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:position.destroy', ['only' => ['destroy']]);
    }

    public function index()
    {
        // $url = "http://127.0.0.1:9000/bg-image/michael-dam-mEZ3PoFGs_k-unsplash.jpg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=8S155RX1KFUQGSLHGAXQ%2F20230618%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20230618T012915Z&X-Amz-Expires=604800&X-Amz-Security-Token=eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NLZXkiOiI4UzE1NVJYMUtGVVFHU0xIR0FYUSIsImV4cCI6MTY4NzA5NDcxNywicGFyZW50IjoiYWRtaW4ifQ.4CwSTS2TXVVmZL4XfaFrC3hmOR-xZFZiEYeOVeFnzIgKOPpHyUkYHiI_j15DEZ7EumP1AMLBgkbs2ugPq2UewA&X-Amz-SignedHeaders=host&versionId=null&X-Amz-Signature=a03808d99005c89c0c57b005bd6e5a52d37a2360892eda8b78e36ad76cb39014";
        // $str= config('face-recognition.python_version')." ".config('face-recognition.face_enc')." ".$url;
        // $exec = exec($str);
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
        $input = $request->validate([
            'name' => 'required|string',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
