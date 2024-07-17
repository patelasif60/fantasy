<?php

namespace App\Http\Requests\Manager\History;

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
            'name' => 'required|min:3',
            'season_id' => [
                'required',
                Rule::unique('past_winner_histories')->where(function ($query) {
                    return $query->where('division_id', $this->division->id);
                })->ignore($this->history->id),
            ],
        ];
    }
}
