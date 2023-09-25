<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuponStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cuponName' => 'bail|required|string|max:255|unique:cupons,cuponName',
            'discount_amount' => 'bail|required|numeric',
            'minimum_purchase_amount' => 'bail|required|numeric',
            'validity_till' => 'bail|required|date',
        ];
    }
}
