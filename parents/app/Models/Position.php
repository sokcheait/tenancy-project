<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Shift;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Position extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

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

    public function shifts()
    {
        return $this->belongsToMany(Shift::class,'shift_positions');
    }

    // public static function boot()
    // {
    //     static::creating(function (Position $position) {
    //         $position->created_by = Auth::user()->id;
    //     });
    // }
}
