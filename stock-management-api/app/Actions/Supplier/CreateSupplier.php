<?php

namespace App\Actions\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateSupplier
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            "name" => ['required'],
            "cperson" => ['required'],
            "contact" => ['required'],
        ])->validate();

        $spplier = Supplier::create([
            'name'      =>$input['name'],
            'cperson'   =>$input['cperson'],
            'contact'   =>$input['contact'],
            'status'    =>$input['status']
        ]);

        return $spplier;
    }
}