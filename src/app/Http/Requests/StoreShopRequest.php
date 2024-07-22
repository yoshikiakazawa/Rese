<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
            'area_id' => 'required|integer',
            'genre_id' => 'required|integer',
            'overview' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'shop_name.required' => 'ショップ名は必須です',
            'image.required' => '画像は必須です',
            'image.image' => '画像ファイル形式が無効です',
            'image.max' => 'アップロードサイズ3MB未満です',
            'area_id.required' => 'エリアは必須です',
            'genre_id.required' => 'ジャンルは必須です',
            'overview.required' => '概要は必須です',
        ];
    }
}
