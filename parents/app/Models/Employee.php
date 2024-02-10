<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Position;
use App\Models\Attendance;
use App\Models\EmployeeLevel;

// use ProtoneMedia\LaravelMinioTestingTools\UsesMinIOServer;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use UsesMinIOServer;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'address',
        'is_active',
        'created_by',
        'updated_by',
        'dob',
        'age',
        'data'
    ];
    protected $casts = [
        'data' => 'array',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class,'employee_levels');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function employeeLevel()
    {
        return $this->hasOne(EmployeeLevel::class);
    }
}
