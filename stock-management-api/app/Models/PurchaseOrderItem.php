<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PurchaseOrder;
use App\Models\Item;
use App\Models\Supplier;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'po_id',
        'item_id',
        'quantity',
        'price',
        'unit',
        'total',
    ];

    public function purchaseOrders()
    {
        return $this->belongsTo(PurchaseOrder::class,'po_id');
    }

    public function items()
    {
        return $this->belongsTo(Item::class,'item_id');
    }
}
