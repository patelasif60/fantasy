<?php

namespace App\Http\Requests\Season;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('seasons')->ignore($this->season->id),
            ],
            'premier_api_id' => [
                'required',
                Rule::unique('seasons')->ignore($this->season->id),
            ],
            'facup_api_id' => [
                'required',
                Rule::unique('seasons')->ignore($this->season->id),
            ],
            'start_at' => 'required',
            'end_at' => 'required',
        ];
    }
}
