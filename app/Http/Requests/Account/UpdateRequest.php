<?php

namespace App\Http\Requests\Account;

use App\Traits\Fileuploader\HasImageCrop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use HasImageCrop;

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
            'first_name'    => 'required',
            'last_name'     => 'required',
            'password'      => 'nullable|string|min:6',
            'username'   => [
                'nullable',
                'min: 3',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
            'email'         => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
        ];
    }
}
