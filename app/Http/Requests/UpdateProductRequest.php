<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0|max:1000000',
            'stock'        => 'required|integer|min:0|max:10000',
            'comment'      => 'nullable|string|max:1000',
            'image'        => 'nullable|image|max:2048',
            'delete_image' => 'nullable|boolean',
        ];
    }
}
