<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_date',
        'time_check_in',
        'time_check_out',
        'timestamping',
        'check_in_type',
        'check_out_type',
        'data',
    ];
    protected $casts = [
        'data' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
