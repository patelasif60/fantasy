<?php

namespace App\Http\Requests\Consumer;

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
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date_format:d/m/Y|before:now',
            'address_1' => 'required',
            'post_code' => 'required',
            'username' => [
                'nullable',
                'min: 3',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user->id),
            ],
        ];
    }
}
