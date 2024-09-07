<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Position;
use App\Models\Attendance;
use App\Models\EmployeeLevel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $appends = ['face_employee'];
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

    public function getFaceEmployeeAttribute()
    {
        return !empty($this->getFirstMedia('face_employee'))?$this->getFirstMedia('face_employee')->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(10)):null;
    }
}
