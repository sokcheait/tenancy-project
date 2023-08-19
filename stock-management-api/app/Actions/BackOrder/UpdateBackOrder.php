<?php

namespace App\Actions\BackOrder;

use App\Models\BackOrder;
use App\Models\BackOrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateBackOrder
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function update(array $input)
    {
        Validator::make($input, [
            'receiving_id'  =>['required'],
            'po_id'         =>['required'],
            'supplier_id'   =>['required'],
            'bo_code'       =>['nullable'],
            'amount'        =>['required'],
            'discount_perc' =>['nullable'],
            'discount'      =>['required'],
            'tax_perc'      =>['required'],
            'tax'           =>['required'],
            'remarks'       =>['required'],
            'status'        =>['required'],

            'item_id'       =>['required'],
            'quantity'      =>['required'],
            'price'         =>['required'],
            'unit'          =>['nullable'],
            'total'         =>['required'],
        ])->validate();

        // $back_order = BackOrder::create([
        //     'receiving_id'  =>$input['receiving_id'],
        //     'po_id'         =>$input['po_id'],
        //     'supplier_id'   =>$input['supplier_id'],
        //     'bo_code'       =>$input['bo_code'],
        //     'amount'        =>$input['amount'],
        //     'discount_perc' =>$input['discount_perc'],
        //     'discount'      =>$input['discount'],
        //     'tax_perc'      =>$input['tax_perc'],
        //     'tax'           =>$input['tax'],
        //     'remarks'       =>$input['remarks'],
        //     'status'        =>$input['status']
        // ]);
        // $back_order_item = BackOrderItem::create([
        //     'bo_id'     =>$back_order->id,
        //     'item_id'   =>$input['item_id'],
        //     'quantity'  =>$input['quantity'],
        //     'price'     =>$input['price'],
        //     'unit'      =>$input['unit'],
        //     'total'     =>$input['total']
        // ]);

        // return $back_order;
    }
}