<?php

namespace App\Http\Requests\Club;

use App\Traits\Fileuploader\HasImageCrop;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|unique:clubs',
            'api_id' => 'required|unique:clubs',
            'short_name' => 'required|unique:clubs',
            'short_code' => 'required|unique:clubs',
        ];
    }
}
