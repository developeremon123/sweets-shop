<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialStoreRequest extends FormRequest
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
            'client_name' => 'bail|required|string|max:255',
            'client_designation' => 'bail|required|string|max:255',
            'client_message' => 'bail|required|string',
            'client_image' => 'bail|nullable|image|mimes:png,jpg,jpeg',
        ];
    }
}
