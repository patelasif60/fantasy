<?php

namespace App\Http\Requests\Package;

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
            'price' => 'required|numeric|min:0|max:100',
            'minimum_teams' => 'required|numeric|min:1|max:16',
            'maximum_teams' => 'required|numeric|min:1|max:16',
            'auction_types' => 'required',
            'pre_season_auction_budget' => 'required|numeric|min:0|max:1000',
            'pre_season_auction_bid_increment' => 'required|numeric|min:0|max:10',
            'seal_bids_budget' => 'required|numeric|min:0|max:1000',
            'seal_bid_increment' => 'required|numeric|min:0|max:10',
            'seal_bid_minimum' => 'required|numeric|min:0',
            'max_seal_bids_per_team_per_round' => 'required|numeric|min:0',
            'default_squad_size' => 'required|numeric|min:11|max:18',
            'default_max_player_each_club' => 'required|numeric|min:1',
            'season_free_agent_transfer_limit' => 'required|numeric|min:0',
            'monthly_free_agent_transfer_limit' => 'required|numeric|min:0',
        ];

        foreach ($this->request->get('points') as $eventKey => $eventVal) {
            foreach ($eventVal as $positionKey => $positionValue) {
                $rules['points.'.$eventKey.'.'.$positionKey] = 'required|numeric|min:-10|max:10';
            }
        }

        return $rules;
    }
}
