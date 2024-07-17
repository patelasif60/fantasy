<?php

namespace App\Http\Requests\Fixture;

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
            'home_club'=>'different:away_club',
            'away_club'=>'different:home_club',
            'api_id' => [
                'required',
                Rule::unique('fixtures')->ignore($this->fixture->id),
            ],
        ];
    }
}
