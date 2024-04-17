<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Shift;
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

    public function scanAttendance()
    {
        $employees = App(Employee::class)->with(['positions.shifts' => function($query) {
            $query->where('shift_allowance',true);
        }])->get();
        $view = "Attendance/ScanAttendance";
        return Inertia::render($view,['employees' => $employees]);
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
        $employee = app(Employee::class)->find($request->employee_id);
        $position= $employee->positions->last();
        $shift = app(Shift::class)->with('positions')->whereHas('positions',function($query) use($position){
            $query->where('shift_allowance',true)->where('positions.id',$position->id);
        })->first();
        $validation_shift = $this->validationShift($shift,$request->type);
        if(!empty($validation_shift)){
            $attendance_date = Carbon::parse($request->attendance_date)->setTimezone('Asia/Phnom_penh')->format('Y-m-d');
            $timestamp = Carbon::parse($request->attendance_date)->setTimezone('Asia/Phnom_penh')->format('A');
            $input =[
                'employee_id'       => $request->employee_id,
                'time_check_in'     => $validation_shift['time_check_in'],
                'time_check_out'    => $validation_shift['time_check_out'],
                'check_in_type'     => $validation_shift['check_in_type'],
                'check_out_type'    => $validation_shift['check_out_type'],
                'timestamping'      => $timestamp,
                'attendance_date'   => $validation_shift['attendance_date'],
                'data'     => json_encode(['late_check_in'=> $validation_shift['late_check_in'],
                                            'late_check_out' => $validation_shift['late_check_out']
                                        ])
            ];
            $attendance = app(Attendance::class)->where('employee_id',$request->employee_id)
                                            ->whereDate('attendance_date',$attendance_date)
                                            ->where('timestamping',$timestamp)
                                            ->first();                                                              
            if($timestamp=='AM' && empty($attendance) || $timestamp=='PM' && empty($attendance)){
                app(Attendance::class)->create($input);
            }elseif($timestamp=='AM' && !empty($attendance) || $timestamp=='PM' && !empty($attendance)){
                // dd($validation_shift);
                $data = json_decode($attendance->data,true);
                $attendance->update([
                                    'time_check_out' => $validation_shift['time_check_out'],
                                    'check_out_type' => $validation_shift['check_out_type'],
                                    'data'           => json_encode(['late_check_in'=> $data['late_check_in'],
                                            'late_check_out' => $validation_shift['late_check_out']
                                        ])
                                ]);

            }
            return redirect()->back();                               
        }
        return redirect()->back()->withErrors(['error'=>'shift not fund']);
    }

    public function validationShift($shift,$attendance_type)
    {
        if(!empty($shift)){
            $late_check_in = 0;
            $late_check_out = 0;
            $time_check_in =null;
            $time_check_out =null;
            $check_in_type = null;
            $check_out_type = null;
            $today = Carbon::now()->setTimezone('Asia/Phnom_penh')->format('Y-m-d');
            $itme = Carbon::now()->setTimezone('Asia/Phnom_penh')->format('h:i').':00';
            $time_scan = $this->minutes($itme);
            $shift_date = json_decode($shift->weekend_definition,true);
            $shift_time_from = $this->minutes($shift->time_from);
            $shift_time_to= $this->minutes($shift->time_to);
            $attendance_date = array_filter($shift_date, function($value) use($today) {
                return $value ==$today;
            });
            if($shift_time_from < $time_scan && $time_scan < $shift_time_to){
                $late_check_in = ($time_scan - $shift_time_from);
                $time_check_in = $itme;
                $check_in_type = $attendance_type;
            }else if($shift_time_from < $time_scan && $time_scan > $shift_time_to){
                $late_check_out = ($time_scan - $shift_time_to);
                $time_check_out = $itme;
                $check_out_type = $attendance_type;
            }else if($shift_time_from > $time_scan){
                $time_check_in = $itme;
                $check_in_type = $attendance_type;
            }else if($shift_time_to < $time_scan){
                $time_check_out = $itme;
                $check_out_type = $attendance_type;
            }
            $data =[
                'check_in_type'=>$check_in_type,
                'check_out_type'=>$check_out_type,
                'time_check_in' => $time_check_in,
                'time_check_out' => $time_check_out,
                'late_check_in'=> $this->hours($late_check_in),
                'late_check_out' => $this->hours($late_check_out),
                'attendance_date' => implode(",", $attendance_date)
            ];
            return $data;
        }
        return;
    }
    private function minutes($time)
    {
        $time = explode(':', $time);
        return ($time[0]*60) + ($time[1]) + ($time[2]/60);
    }
    private function hours($minutes)
    {
        $hours = 0;
        if($minutes>0){
            $hours = floor($minutes / 60).':'.round($minutes - floor($minutes / 60) * 60).':00';
        }
        return $hours;
        
    }

    public function callEmployeeQR($id)
    {
        $employee = app(Employee::class)->find($id);
        return response()->json([
            'employee'=>$employee
        ]);
    }

    public function scanAttendanceFace(Request $request)
    {
        if ($request->hasFile('file')) {
            $file_face = $request->file;
            $str= config('face-recognition.python_version')." ".config('face-recognition.face_enc')." ".$file_face;
            $exec = exec($str);
            dd($exec);
        }
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
