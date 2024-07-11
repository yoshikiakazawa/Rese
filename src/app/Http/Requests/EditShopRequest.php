<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditShopRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'shop_name' => 'required|string|max:255',
            'area_id' => 'required|integer',
            'genre_id' => 'required|integer',
            'overview' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'shop_name.required' => 'ショップ名は必須です。',
            'area_id.required' => 'エリアは必須です。',
            'genre_id.required' => 'ジャンルは必須です。',
            'overview.required' => '概要は必須です。',
        ];
    }
}
