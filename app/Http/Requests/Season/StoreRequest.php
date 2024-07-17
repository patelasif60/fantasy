<?php

namespace App\Http\Requests\Season;

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
            'name' => 'required|unique:seasons',
            'premier_api_id' => 'required|unique:seasons',
            'facup_api_id' => 'required|unique:seasons',
            'start_at' => 'required',
            'end_at' => 'required',
        ];
    }
}
