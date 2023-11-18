<?php

namespace App\Actions\Returned;

use App\Models\Returned;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateReturned
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            "supplier_id" => ['required'],
            "amount" => ['required'],
        ])->validate();

        $returned = Returned::create([
            'supplier_id'=>$input['supplier_id'],
            'return_code'=>$input['return_code'],
            'amount'=>$input['amount'],
            'remarks'=>$input['remarks'],
            'stock_ids'=>$input['stock_ids'],
        ]);

        return $returned;
    }
}