<?php

namespace App\Http\Requests\Division\Setting;

use App\Enums\SealedBidDeadLinesEnum;
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
        $rules = [];

        if ($this->name == 'transfer') {
            $rules = [
                'season_free_agent_transfer_limit' => 'nullable|numeric',
                'monthly_free_agent_transfer_limit' => 'nullable|numeric',
                'seal_bid_increment' => 'nullable|numeric|min:0|max:10',
                'seal_bid_minimum' => 'nullable|numeric',
                'max_seal_bids_per_team_per_round' => 'nullable|numeric|min:0|max:10',
            ];

            if ($this->request->has('round_end_date') && $this->request->has('round_end_time')) {
                foreach ($this->request->get('round_end_date') as $key => $val) {
                    $rules['round_end_date.'.$key.'.'.key($val)] = 'required|date_format:d/m/Y';
                }

                foreach ($this->request->get('round_end_time') as $key => $val) {
                    $rules['round_end_time.'.$key.'.'.key($val)] = 'required|date_format:H:i:s';
                }
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];
        if ($this->request->has('round_end_date') && $this->request->has('round_end_time')) {
            foreach ($this->request->get('round_end_date') as $key => $val) {
                $messages['round_end_date.'.$key.'.'.key($val).'.required'] = 'The round '.($key + 1).' end date field is required.';
                $messages['round_end_date.'.$key.'.'.key($val).'.date_format'] = 'The round '.($key + 1).' end date is invalid.';
            }

            foreach ($this->request->get('round_end_time') as $key => $val) {
                $messages['round_end_time.'.$key.'.'.key($val).'.required'] = 'The round '.($key + 1).' end time field is required.';
                $messages['round_end_time.'.$key.'.'.key($val).'.date_format'] = 'The round '.($key + 1).' end time is invalid.';
            }
        }

        return $messages;
    }
}
