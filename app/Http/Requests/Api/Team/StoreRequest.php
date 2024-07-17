<?php

namespace App\Http\Requests\Api\Team;

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
        if ($this->request->get('crest_id')) {
            return [
                'name' => 'required|max:255',
                'crest_id' => 'required|integer',
            ];
        }

        return [
            'name' => 'required|max:255',
            'crest' => 'required',
        ];
    }
}
