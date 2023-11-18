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

    protected $casts = [
        'created_at' => 'date:d/m/Y h:i',
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
}
