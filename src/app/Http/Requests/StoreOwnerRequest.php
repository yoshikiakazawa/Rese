<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest extends FormRequest
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
            'ownerid' => 'required|min:8|unique:owners',
            'password' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'ownerid.required' => 'IDは必須です。',
            'password.required' => 'パスワードは必須です。',
            'ownerid.min' => 'IDは最低8文字以上必要です。',
            'password.min' => 'パスワードは最低8文字以上必要です。',
            'ownerid.unique' => 'このIDは既に登録されています。'
        ];
    }
}