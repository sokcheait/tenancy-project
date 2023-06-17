<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Position;
use App\Models\EmployeeLeave;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeController extends Controller
{
    public function index()
    {
        // $employees = app(Employee::class)->with('positions')->get();
        // $view = "Employee/Index";
        // return Inertia::render($view,[
        //     'employees' => $employees
        // ]);
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('first_name', 'LIKE', "%{$value}%");
                });
            });
        });

        $employees = QueryBuilder::for(Employee::class)
            ->defaultSort('first_name')
            ->allowedSorts(['first_name', 'last_name','gender','phone','is_active'])
            ->with('positions')
            ->allowedFilters(['first_name', 'is_active', $globalSearch])
            ->paginate()
            ->withQueryString();
        $view = "Employee/Index";
        return Inertia::render($view, [
            'employees' => $employees
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->column(key: 'id')
              ->column(key: 'first_name', searchable: true, sortable: true, canBeHidden: false)
              ->column(key: 'last_name',sortable: true)
              ->column(key: 'gender',sortable: true)
              ->column(key: 'phone',sortable: true)
              ->column(key: 'positions')
              ->column(key: 'is_active',sortable: true)
              ->column(label: 'Actions');
        });
    }

    public function create()
    {
        $positions = app(Position::class)->where('is_active','true')->get()->toArray();
        $view = "Employee/Create";
        return Inertia::render($view,[
            'positions'=> $positions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:120',
            'last_name'  => 'required|max:120',
            'gender'     => 'required',
            'address'    => 'required',
            'position_id' => 'required',
            'valide_date_form' => 'required',
            'valide_date_to' => 'required'
        ]);

        $employee = app(Employee::class)->create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'gender'     => $request->gender,
            'phone'     => $request->phone,
            'address'    => $request->address,
            'is_active'  => $request->is_active
        ]);

        app(EmployeeLeave::class)->create([
            'employee_id' => $employee->id,
            'position_id' => $request->position_id,
            'start_date'  => $request->valide_date_form,
            'end_date'    => $request->valide_date_to
        ]);
        return redirect()->route('employee.index');

    }
}
