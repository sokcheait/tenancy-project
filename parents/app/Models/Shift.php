<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Position;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'time_from',
        'time_to',
        'weekend_definition',
        'shift_allowance',
    ];
    protected $casts = [
        'weekend_definition' => 'array',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class,'shift_positions');
    }
}
