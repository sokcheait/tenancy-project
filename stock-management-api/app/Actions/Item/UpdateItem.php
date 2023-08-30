<?php

namespace App\Actions\Item;

use App\Models\Item;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateItem
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function update($item, array $input)
    {
        Validator::make($input, [
            'supplier_id'   =>['required'],
            'name'          =>['required'],
            'cost'          =>['required'],
        ])->validate();

        $result = $item->update([
            'supplier_id'   =>$input['supplier_id']??null,
            'name'          =>$input['name']??null,
            'description'   =>$input['description']??null,
            'cost'          =>$input['cost']??null,
            'status'        =>$input['status']
        ]);

        return $result;
    }
}