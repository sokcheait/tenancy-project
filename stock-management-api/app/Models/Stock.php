<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'quantity',
        'unit',
        'price',
        'total',
        'type',
    ];

    public function items()
    {
        return $this->belongsTo(Item::class,'item_id');
    }
}
