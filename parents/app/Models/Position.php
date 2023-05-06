<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class Position extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        
    ];
    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    // public static function boot()
    // {
    //     static::creating(function (Position $position) {
    //         $position->created_by = Auth::user()->id;
    //     });
    // }
}
