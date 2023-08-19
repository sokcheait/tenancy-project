<?php

namespace App\Actions\Item;

use App\Models\Item;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateItem
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'supplier_id'   =>['required'],
            'name'          =>['required'],
            'cost'          =>['required'],
        ])->validate();

        $item = Item::create([
            'supplier_id'   =>$input['supplier_id'],
            'name'          =>$input['name'],
            'cost'          =>$input['cost'],
            'status'        =>$input['status']
        ]);

        return $item;
    }
}