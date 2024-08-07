<?php

namespace App\Http\Requests\Division;

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
        $rules = [
            'name' => 'required|max:255',
            'package_id' => 'required',
        ];
        if ($this->request->get('social_id') == 0) {
            $rules['chairman_id'] = 'required';
        }

        return $rules;
    }
}
