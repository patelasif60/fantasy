<?php

namespace App\Http\Requests\GameWeek;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'number' => 'required|numeric',
            'start' => 'required|date_format:d/m/Y|before_or_equal:end',
            'end' => 'required|date_format:d/m/Y|after_or_equal:start',
        ];
    }
}
