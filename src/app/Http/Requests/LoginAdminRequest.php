<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
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
            'adminid' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'adminid.required' => 'adminidは、入力必須です',
            'password.required' => 'passwordは、入力必須です',
        ];
    }
}
