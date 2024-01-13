<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportAttendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $attendance =  app(Attendance::class)
        //  ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')
        //  ->select(['attendances.employee_id','attendances.attendance_date', 
        //         DB::raw('MIN(attendances.time_check_in) AS time_check_in_am'),
        //         DB::raw('MAX(attendances.time_check_out) AS time_check_out_am'),
        //         DB::raw('MAX(attendances.time_check_in) AS time_check_in_pm'),
        //         DB::raw('MIN(attendances.time_check_out) AS time_check_out_pm'),
        //         'employees.first_name',
        //         'employees.last_name',
        //         'employees.gender',
        //         ])
        //  ->groupBy('attendances.employee_id','employees.first_name',
        //         'employees.last_name','employees.gender','attendances.attendance_date')
        //  ->get();                                   
        
        // dd($attendance);                                    
                                            
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->whereHas('employee',function($q) use($value){
                        $q->where('first_name', 'LIKE', "%{$value}%");
                    });
                });
            });
        });

        $attendances = QueryBuilder::for(Attendance::class)
            // ->defaultSort('employee_name')
            ->allowedSorts(['employee_name', 'employee_gender','attendance_date','time_check_in','time_check_out','timestamping'])
            ->with('employee')
            ->allowedFilters(['employee_name', $globalSearch])
            ->orderByRaw('attendances.attendance_date desc,attendances.employee_id desc')
            ->paginate()
            ->withQueryString();
        $view = "Attendance/Index";
        return Inertia::render($view, [
            'attendances' => $attendances
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->column(key: 'id',label:'#No')
              ->column(key: 'employee_name')
              ->column(key: 'employee_gender',label:"Gender")
              ->column(key: 'attendance_date')
              ->column(key: 'time_check_in')
              ->column(key: 'time_check_out')
              ->column(key: 'timestamping');
              
        });
    }

    public function attendanceExcel(Request $request)
    {
        $attendance =  app(Attendance::class)
         ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')
         ->whereDate('attendances.attendance_date',$request->data)
         ->select(['attendances.employee_id','attendances.attendance_date', 
                DB::raw('MIN(attendances.time_check_in) AS time_check_in_am'),
                DB::raw('MAX(attendances.time_check_out) AS time_check_out_am'),
                DB::raw('MAX(attendances.time_check_in) AS time_check_in_pm'),
                DB::raw('MIN(attendances.time_check_out) AS time_check_out_pm'),
                'employees.first_name',
                'employees.last_name',
                'employees.gender',
                ])
         ->groupBy('attendances.employee_id','employees.first_name',
                'employees.last_name','employees.gender','attendances.attendance_date')
         ->get();
        $name = "attendance".$request->data;                                    
        return Excel::download(new ExportAttendance($attendance), $name.'.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendance_date = Carbon::parse($request->attendance_date)->setTimezone('Asia/Phnom_penh')->format('Y-m-d');
        $time = Carbon::parse($request->attendance_date)->setTimezone('Asia/Phnom_penh')->format('h:i:s');
        $timestamp = Carbon::parse($request->attendance_date)->setTimezone('Asia/Phnom_penh')->format('A');
        $attendance = app(Attendance::class)->where('employee_id',$request->employee_id)
                                            ->whereDate('attendance_date',$attendance_date)
                                            ->where('timestamping',$timestamp)
                                            ->first();
        $check_in = '';
        $check_out = '';
        if($timestamp=='AM' && empty($attendance) || $timestamp=='PM' && empty($attendance)){
            $check_in = $time;
            app(Attendance::class)->create([
                'employee_id'       => $request->employee_id,
                'attendance_date'   => $attendance_date,
                'time_check_in'     => $check_in,
                'time_check_out'    => $check_out,
                'timestamping'      => $timestamp
            ]);
        }elseif($timestamp=='AM' && !empty($attendance) || $timestamp=='PM' && !empty($attendance)){
            $check_out = $time;
            $attendance->update(['time_check_out'    => $check_out]);

        }    
        return redirect()->route('attendance.index');
        // dd($attendance_date,$time,$timestamp);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
