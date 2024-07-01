<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class FutureDateTime implements Rule
{
    protected $date;
    protected $time;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date, $time)
    {
        $this->date = $date;
        $this->time = $time;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', "{$this->date} {$this->time}");

        return $dateTime->isFuture();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '過去の日時は選択できません。';
    }
}
