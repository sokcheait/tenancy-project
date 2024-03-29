<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Employee;

class EmployeeLevel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'position_id',
        'staff_id',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    
    public function employee()
    {
        return $this->hasOne(Employee::class,'employee_id');
    }
}
