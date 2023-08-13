<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiving_id',
        'po_id',
        'supplier_id',
        'bo_code',
        'amount',
        'discount_perc',
        'discount',
        'tax_perc',
        'tax',
        'remarks',
        'status'
    ];
}
