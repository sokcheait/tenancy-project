<?php

namespace App\Actions\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateSupplier
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function update($supplier ,array $input)
    {
        // dd($supplier);
        Validator::make($input, [
            "name" => ['required'],
            "cperson" => ['required'],
            "contact" => ['required'],
        ])->validate();

        $result = $supplier->update([
            'name'      =>$input['name'],
            'cperson'   =>$input['cperson'],
            'contact'   =>$input['contact'],
            'status'    =>$input['status']
        ]);

        return $result;
    }
}