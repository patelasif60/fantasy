<?php

namespace App\Http\Requests\Season;

use Illuminate\Foundation\Http\FormRequest;

class RolloverRequest extends FormRequest
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
            'duplicate_from' => 'required',
        ];
    }
}
