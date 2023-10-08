<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use App\Models\PurchaseOrder;

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
        'created_at',
    ];

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => Carbon::parse($value)->format('d/m/Y H:i:s'),
            set: fn ($value, $attributes) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function purchaseOrders()
    {
        return $this->belongsTo(PurchaseOrder::class,'form_id');
    }
}
