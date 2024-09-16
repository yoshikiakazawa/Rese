<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'comment' => 'required|max:400',
            'image' => 'mimes:png,jpg,|max:2048',
            'rank' => 'required|integer|min:1|max:5',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => '口コミは必須です',
            'comment.max' => '400文字を超えています',
            'image.mimes' => '「.png」もしくは「.jpg」形式でアップロードしてください',
            'image.max' => '2MB以下でアップロードしてください',
            'rank.required' => '評価は★1以上でお願いします',
            'rank.min' => '評価は★1以上でお願いします',
            'rank.max' => '評価は★1以上でお願いします',
        ];
    }
}
