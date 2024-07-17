<?php

namespace App\Http\Requests\Player\Contract;

use App\Rules\Player\Contract\OverlapDateRule;
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
        return [
            'club_id'    => 'required',
            'position'   => 'required',
            'start_date' => ['required', new OverlapDateRule($this->route('player'))],
            'end_date'   => ['nullable', 'date_format:'.config('fantasy.date.format'), 'after:start_date', new OverlapDateRule($this->route('player'))],
        ];
    }
}
