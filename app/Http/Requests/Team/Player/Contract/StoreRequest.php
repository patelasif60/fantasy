<?php

namespace App\Http\Requests\Team\Player\Contract;

use App\Rules\Team\Player\Contract\OverlapDateRule;
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
            'start_date_new' => new OverlapDateRule(request()->all()),
            'end_date_new'   => new OverlapDateRule(request()->all()),
        ];

        return $rules;
    }
}
