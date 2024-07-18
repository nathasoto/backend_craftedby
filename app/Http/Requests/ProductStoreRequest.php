<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        // Check if the current user has permission to create the product
//        return auth()->user()->hasPermissionTo('product.create');
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => ['required', 'string', 'max:255'],
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'material' => 'required|string',
            'history' => 'required|string',
            'image_path' => 'required|string',
            'description' => 'required|string',
            'categories_id' => 'required|string',
            'shop_id' => 'required|string',
            'color_ids' => 'required|array',
            'color_ids.*' => 'exists:colors,id',
            'size_ids' => 'required|array',
            'size_ids.*' => 'exists:sizes,id',
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ],422));

    }

    public function messages()

    {

        return [

            'name.required' => 'name is required',
            'price.required' => 'price is required',
            'weight.required' => 'weight is required',
            'stock.required' => 'stock is required',
            'material.required' => 'material is required',
            'history_anécdota.required' => 'history_anécdota is required',
            'image_path.required' => 'image_path is required',
            'description.required' => 'description is required',
            'categories_id.required' => 'categories_id is required',
            'shop_id.required' => 'shop_id is required',

        ];

    }
}
