<?php

namespace App\Http\Requests\Club;

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
            'name' => [
                'required',
                Rule::unique('clubs')->ignore($this->club->id),
            ],
            'api_id' => [
                'required',
                Rule::unique('clubs')->ignore($this->club->id),
            ],
            'short_name' => [
                'required',
                Rule::unique('clubs')->ignore($this->club->id),
            ],
            'short_code' => [
                'required',
                Rule::unique('clubs')->ignore($this->club->id),
            ],
        ];
    }
}
