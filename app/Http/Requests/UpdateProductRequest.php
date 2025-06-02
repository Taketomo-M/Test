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

    public function messages()
{
    return [
        'product_name.required' => '商品名は必須です。',
        'company_id.required' => 'メーカーを選択してください。',
        'company_id.exists' => '選択されたメーカーが存在しません。',
        'price.required' => '価格は必須です。',
        'price.integer' => '価格は数値で入力してください。',
        'price.min' => '価格は0以上である必要があります。',
        'price.max' => '価格は1000000以下である必要があります。',
        'stock.required' => '在庫数は必須です。',
        'stock.integer' => '在庫数は数値で入力してください。',
        'stock.min' => '在庫数は0以上である必要があります。',
        'stock.max' => '在庫数は10000以下である必要があります。',
        'comment.max' => 'コメントは1000文字以内で入力してください。',
        'image.image' => '画像ファイルを指定してください。',
        'image.max' => '画像ファイルは2MB以内でアップロードしてください。',
    ];
}

}
