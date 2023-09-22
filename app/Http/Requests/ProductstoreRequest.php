<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductstoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id'       => 'bail|required|numeric',
            'name'              => 'bail|required|string|max:255',
            'product_code'      => 'bail|required|numeric|unique:products,product_code',
            'product_price'     => 'bail|required|numeric|min:0',
            'product_stock'     => 'bail|required|numeric|min:1',
            'alert_quantity'    => 'bail|required|numeric|min:1',
            'short_description' => 'bail|nullable|string',
            'long_description'  => 'bail|nullable|string',
            'additional_info'   => 'bail|nullable|string',
            'product_image'     => 'bail|required|image|mimes:png,jpg,jpeg,svg',
        ];
    }
}
