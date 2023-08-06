<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoriesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_name' => ['required'],
            'is_active' => ['required']
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'status'    => 422,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }

    // public function messages()

    // {
    //     return [

    //         'category_name.required' => 'Category name is required',

    //         'is_active.required' => 'Active is required'
    //     ];

    // }

}
