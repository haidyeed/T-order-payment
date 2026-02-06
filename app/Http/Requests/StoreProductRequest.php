<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|min:5|max:255',
            'sku' => 'required|min:5|max:255',
            'price' => 'required|numeric|min:1',
            'status' => 'numeric|min:0|max:1',
            'order' => 'numeric|min:0',
        ];
    }
}