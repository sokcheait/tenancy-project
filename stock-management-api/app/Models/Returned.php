<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returned extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'return_code',
        'amount',
        'remarks',
        'stock_ids',
    ];
}
