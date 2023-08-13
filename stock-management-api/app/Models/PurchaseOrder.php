<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\PurchaseOrderItem;

class PurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'po_code',
        'amount',
        'discount_perc',
        'discount',
        'tax_perc',
        'tax',
        'remarks',
        'status'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function purchaseOrderItems()
    {
        return $this->belongsTo(PurchaseOrderItem::class,'id');
    }
}
