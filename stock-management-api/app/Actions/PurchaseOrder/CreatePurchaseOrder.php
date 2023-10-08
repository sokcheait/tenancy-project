<?php

namespace App\Actions\PurchaseOrder;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreatePurchaseOrder
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): PurchaseOrder
    {
        Validator::make($input, [
            'supplier_id'   =>['required'],
            'amount'        =>['required'],
            'status'        =>['required'],
        ])->validate();

        $purchase_order = PurchaseOrder::create([
            'supplier_id'   =>$input['supplier_id']??null,
            'po_code'       =>$input['po_code']??null,
            'amount'        =>$input['amount']??null,
            'discount_perc' =>$input['discount_perc']??null,
            'discount'      =>$input['discount']??null,
            'tax_perc'      =>$input['tax_perc']??null,
            'tax'           =>$input['tax']??null,
            'remarks'       =>$input['remarks'],
            'status'        =>$input['status'],
        ]);

        return $purchase_order;
    }
}