<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Position;
// use ProtoneMedia\LaravelMinioTestingTools\UsesMinIOServer;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use UsesMinIOServer;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'phone',
        'address',
        'is_active',
        'created_by',
        'updated_by',
        'dob',
        'age'
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class,'employee_leaves');
    }
}
