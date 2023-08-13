<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingOrder extends Model
{
    use HasFactory;

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
