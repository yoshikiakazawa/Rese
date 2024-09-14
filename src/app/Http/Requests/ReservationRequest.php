<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FutureDateTime;

class ReservationRequest extends FormRequest
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
        $date = request()->input('date');
        $time = request()->input('time');

        return [
            'date' => 'required|after_or_equal:today',
            'time' => ['required', new FutureDateTime($date, $time)],
            'number' => 'required|integer',
            'rank' => 'integer|min:1|max:5',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'time.required' => '時間を入力してください',
            'number.required' => '人数を入力してください',
            'date.after_or_equal' => '過去の日付では予約できません。',
        ];
    }
}
