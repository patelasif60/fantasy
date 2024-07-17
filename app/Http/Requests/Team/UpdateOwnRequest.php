<?php

namespace App\Http\Requests\Team;

use App\Traits\Fileuploader\HasImageCrop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOwnRequest extends FormRequest
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
            'name' => 'required',
            'crest_id' => 'sometimes|'.Rule::requiredIf(function () {
                return $this->get('fileuploader-list-crest') == '';
            }),
            'crest' => 'sometimes|'.Rule::requiredIf(function () {
                return $this->get('crest_id') == '' || $this->get('crest_id') == null;
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
