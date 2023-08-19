<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Supplier;
use App\Models\ReceivingOrder;
use App\Models\PurchaseOrder;

class BackOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function receiving()
    {
        return $this->belongsTo(ReceivingOrder::class,'receiving_id');
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseOrder::class,'po_id');
    }
}
