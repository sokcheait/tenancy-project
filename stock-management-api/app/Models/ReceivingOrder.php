<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivingOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'form_id',
        'from_order',
        'amount',
        'discount_perc',
        'discount',
        'tax_perc',
        'tax',
        'stock_ids',
        'remarks',
    ];
}
