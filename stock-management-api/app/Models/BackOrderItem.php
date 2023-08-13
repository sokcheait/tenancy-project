<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bo_id',
        'item_id',
        'quantity',
        'price',
        'unit',
        'total',
    ];
}
