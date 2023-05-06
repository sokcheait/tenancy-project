<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Position;
use App\Models\EmployeeLeave;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = app(Employee::class)->with('positions')->get();
        $view = "Employee/Index";
        return Inertia::render($view,[
            'employees' => $employees
        ]);
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
