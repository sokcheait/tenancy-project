<?php

namespace App\Actions\ReceivingOrder;

use App\Models\ReceivingOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateReceivingOrder
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'form_id'       =>['required'],
            'from_order'    =>['required'],
            'amount'        =>['required'],
            'discount'      =>['required'],
            'tax'           =>['required'],
        ])->validate();

        $receiving_order = ReceivingOrder::create([
            'form_id'       =>$input['form_id'],
            'from_order'    =>$input['from_order'],
            'amount'        =>$input['amount'],
            'discount_perc' =>$input['discount_perc'],
            'discount'      =>$input['discount'],
            'tax_perc'      =>$input['tax_perc'],
            'tax'           =>$input['tax'],
            'stock_ids'     =>$input['stock_ids'],
            'remarks'       =>$input['remarks'],
            'from_code'     =>$input['from_code']
        ]);

        return $receiving_order;

    }
}