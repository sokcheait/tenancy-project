<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftPosition extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'shift_id',
        'position_id',
    ];
}
