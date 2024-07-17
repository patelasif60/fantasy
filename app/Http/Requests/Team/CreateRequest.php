<?php

namespace App\Http\Requests\Team;

use App\Traits\Fileuploader\HasImageCrop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
            'crest_id' => Rule::requiredIf(function () {
                return $this->get('fileuploader-list-crest') == '';
            }),
            'crest' => Rule::requiredIf(function () {
                return $this->has('crest') && ($this->get('crest_id') == '' || $this->get('crest_id') == null);
            }),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'crest_id.required' => 'Select team badge or upload your own badge',
            'crest.required'  => 'Select team badge or upload your own badge',
        ];
    }
}
