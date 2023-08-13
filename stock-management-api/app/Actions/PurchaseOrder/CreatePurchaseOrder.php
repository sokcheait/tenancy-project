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
            'po_code'       =>['nullable'],
            'amount'        =>['required'],
            'discount_perc' =>['nullable'],
            'discount'      =>['required'],
            'tax_perc'      =>['nullable'],
            'tax'           =>['required'],
            'remarks'       =>['required'],
            'status'        =>['required'],

            'item_id'       =>['required'],
            'quantity'      =>['required'],
            'price'         =>['required'],
            'unit'          =>['nullable'],
            'total'         =>['required'],
        ])->validate();

        $purchase_order = PurchaseOrder::create([
            'supplier_id'   =>$input['supplier_id'],
            'po_code'       =>$input['po_code'],
            'amount'        =>$input['amount'],
            'discount_perc' =>$input['discount_perc'],
            'discount'      =>$input['discount'],
            'tax_perc'      =>$input['tax_perc'],
            'tax'           =>$input['tax'],
            'remarks'       =>$input['remarks'],
            'status'        =>$input['status']
        ]);
        $purchase_order_item = PurchaseOrderItem::create([
            'po_id'     => $purchase_order->id,
            'item_id'   =>$input['item_id'],
            'quantity'  =>$input['quantity'],
            'price'     =>$input['price'],
            'unit'      =>$input['unit'],
            'total'     =>$input['total']
        ]);

        return $purchase_order;
    }
}