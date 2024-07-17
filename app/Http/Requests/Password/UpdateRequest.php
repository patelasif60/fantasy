<?php

namespace App\Http\Requests\Password;

use App\Rules\PasswordCheck;
use Illuminate\Foundation\Http\FormRequest;

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
            'current_password' => [
                'required',
                new PasswordCheck,
            ],
            'password' => [
                'required',
                'min: 6',
                'confirmed',
            ],
            'password_confirmation' => 'required',
        ];
    }
}
