<?php

namespace App\Http\Requests\Player;

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
            'last_name' => 'required',
            'short_code' => [
                'nullable',
                Rule::unique('players')->ignore($this->player->id),
            ],
            'api_id' => [
                'required',
                Rule::unique('players')->ignore($this->player->id),
            ],
        ];
    }
}
