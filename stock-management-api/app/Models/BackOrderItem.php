<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BackOrder;

class BackOrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bo_id',
        'item_id',
        'quantity',
        'price',
        'unit',
        'total',
    ];

    public function backOrders()
    {
        return $this->belongsTo(BackOrder::class,'bo_id');
    }
}
