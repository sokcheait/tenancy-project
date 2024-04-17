<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Position;
use App\Models\ShiftPosition;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ShiftController extends Controller
{
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });

        $shifts = QueryBuilder::for(Shift::class)
            ->with('positions')
            ->withCount('positions')
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->allowedFilters(['name', $globalSearch])
            ->paginate()
            ->withQueryString();  
        $positions = app(Position::class)->where('is_active',true)->get();     
        $view = "Shift/Index";  
        return Inertia::render($view, [
            'shifts' => $shifts,
            'positions' => $positions
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false)
              ->column(key: 'positions_name', label:"positions")
              ->column(key: 'time_from',sortable: true)
              ->column(key: 'time_to',sortable: true)
              ->column(key: 'shift_allowance',label:"Status")
              ->column(label: 'Actions');
        });
    }

    public function create()
    {
        $view = "Shift/Create";
        return Inertia::render($view);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'weekend_definition' => 'required',
        ]);
        $request['time_from'] = $this->formatTime($request->time_from);
        $request['time_to'] = $this->formatTime($request->time_to);
        $request['weekend_definition'] = $this->formatDate($request->weekend_definition);
        $input = [
            'name' => $request->name,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'weekend_definition' => json_encode($request->weekend_definition),
            'shift_allowance' => $request->shift_allowance,
        ];
        app(Shift::class)->create($input);
        return redirect()->route('shift.index');
    }

    public function show(Shift $shift)
    {
        //
    }

    public function edit($id)
    {
        $shift = app(Shift::class)->find($id);
        $view = "Shift/Edit";
        return Inertia::render($view,[
            'shift' => $shift
        ]);
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'weekend_definition' => 'required',
        ]);
        $shift = app(Shift::class)->find($id);
        $request['time_from'] = $this->formatTime($request->time_from);
        $request['time_to'] = $this->formatTime($request->time_to);
        $request['weekend_definition'] = $this->formatDate($request->weekend_definition);
        $input = [
            'name' => $request->name,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'weekend_definition' => json_encode($request->weekend_definition),
            'shift_allowance' => $request->shift_allowance,
        ];
        $shift->update($input);
        return redirect()->route('shift.index');
    }

    public function destroy($id)
    {
        $shift = app(Shift::class)->find($id);
        $shift->delete();
        return redirect()->route('shift.index');
    }

    public function formatTime($time) 
    {
        if(is_array($time)){
            $result = str_pad($time['hours'], 2, '0', STR_PAD_LEFT).":".str_pad($time['minutes'], 2, '0', STR_PAD_LEFT);
            return $result;
        }else{
            return $time;
        }
        
    }

    public function formatDate($date)
    {
        foreach ($date as $key=>$item) {
            $data[]= Carbon::parse($item)->format('Y-m-d');
        }
        return $data;
    }

    public function connectShift(Request $request) 
    {
        $request->validate([
            'position_id' => 'required',
        ]);
        app(ShiftPosition::class)->create($request->all());
        return redirect()->route('shift.index');
    }
}
