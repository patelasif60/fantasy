<?php

namespace App\Http\Requests\Division;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|max:255',
            'package_id' => 'required',
            'pre_season_auction_budget' => 'nullable|numeric|min:0|max:1000',
            'pre_season_auction_bid_increment' => 'nullable|numeric|min:0|max:10',
            'seal_bids_budget' => 'nullable|numeric|min:0|max:1000',
            'seal_bid_increment' => 'nullable|numeric|min:0|max:10',
            'seal_bid_minimum' => 'nullable|numeric|min:0',
            'max_seal_bids_per_team_per_round' => 'nullable|numeric|min:0',
            'default_squad_size' => 'nullable|numeric|min:11|max:18',
            'default_max_player_each_club' => 'nullable|numeric|min:1',
            'season_free_agent_transfer_limit' => 'nullable|numeric|min:0',
            'monthly_free_agent_transfer_limit' => 'nullable|numeric|min:0',
        ];
        if ($this->request->get('social_id') == 0) {
            $rules['chairman_id'] = 'required';
        }

        foreach ($this->request->get('points') as $eventKey => $eventVal) {
            foreach ($eventVal as $positionKey => $positionValue) {
                $rules['points.'.$eventKey.'.'.$positionKey] = 'nullable|numeric|min:-10|max:10';
            }
        }

        return $rules;
    }
}
