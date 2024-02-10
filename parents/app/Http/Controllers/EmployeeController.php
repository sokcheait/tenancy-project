<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Position;
use App\Models\EmployeeLevel;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use App\Repositores\EmployeeRepository;
use Carbon\Carbon;

class EmployeeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $employee;
    public function __construct(EmployeeRepository $employee)
    {
         $this->middleware('permission:employee.index|employee.create|employee.edit|employee.destroy', ['only' => ['index','show']]);
         $this->middleware('permission:employee.create', ['only' => ['create','store']]);
         $this->middleware('permission:employee.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:employee.destroy', ['only' => ['destroy']]);

        $this->employee = $employee;  
    }

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
            ->with(['positions','attendances'])
            ->withCount('attendances')
            ->allowedFilters(['first_name', 'is_active', $globalSearch])
            ->orderBy('employees.id', 'desc')
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
        $positions = app(Position::class)->where('is_active','true')->get();
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
            'position_id' => 'required',
            'dob' => 'required',
            'valide_date_form' => 'required',
            'valide_date_to' => 'required'
        ]);
        $data = [
            'valide_date_card_form'=> Carbon::parse($request->valide_date_card_form)->format('Y-m-d'),
            'valide_date_card_to'=> Carbon::parse($request->valide_date_card_to)->format('Y-m-d'),
            'id_card'=>$request->id_card
        ];
        $employee = app(Employee::class)->create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'gender'     => $request->gender,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'dob'        => $request->dob,
            'age'        => $request->age,
            'is_active'  => $request->is_active,
            'data'       => json_encode($data,true)
        ]);

        app(EmployeeLevel::class)->create([
            'employee_id' => $employee->id,
            'position_id' => $request->position_id,
            'staff_id'    => $request->staff_id,
            'start_date'  => $request->valide_date_form,
            'end_date'    => $request->valide_date_to
        ]);
        return redirect()->route('employee.index');

    }

    public function edit($id)
    {
        $employee = $this->employee->with(['positions','employeeLevel'])->find($id);
        $positions = app(Position::class)->where('is_active','true')->get();
        $view = "Employee/Edit";
        return Inertia::render($view,[
            'employee' => $employee,
            'positions'=> $positions
        ]);
    }
    public function update($id,Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:120',
            'last_name'  => 'required|max:120',
            'gender'     => 'required',
            'position_id' => 'required',
            'dob' => 'required',
            'valide_date_form' => 'required',
            'valide_date_to' => 'required'
        ]);
        $data = [
            'valide_date_card_form'=> Carbon::parse($request->valide_date_card_form)->format('Y-m-d'),
            'valide_date_card_to'=> Carbon::parse($request->valide_date_card_to)->format('Y-m-d'),
            'id_card'=>$request->id_card
        ];

        $find_employee = $this->employee->with(['positions','employeeLevel'])->find($id);
        $find_employee_level = app(EmployeeLevel::class)->find($find_employee->employeeLevel->id);

        $find_employee->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'gender'     => $request->gender,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'dob'        => $request->dob,
            'age'        => $request->age,
            'is_active'  => $request->is_active,
            'data'       => json_encode($data,true)
        ]);
        $find_employee_level->update([
            'position_id' => $request->position_id,
            'staff_id'    => $request->staff_id,
            'start_date'  => $request->valide_date_form,
            'end_date'    => $request->valide_date_to
        ]);
        return redirect()->route('employee.index');
    }
}
