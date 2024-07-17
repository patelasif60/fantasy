<?php

namespace App\Http\Requests\Api\Division;

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
        return [
            'name' => 'required|nullable|max:255',
            'introduction' => 'present|nullable',
            'parent_division_id' => 'present|nullable',
            'auction_date' => 'present|nullable',
            'budget_rollover' => 'present|nullable',
            'auction_types' => 'present|nullable',
            'manual_bid' => 'present|nullable',
            'first_seal_bid_deadline' => 'present|nullable',
            'seal_bid_deadline_repeat' => 'present|nullable',
            'money_back' => 'present|nullable',
            'tie_preference' => 'present|nullable',
            'rules' => 'present|nullable',
            'free_agent_transfer_after' => 'present|nullable',
            'free_agent_transfer_authority' => 'present|nullable',
            'enable_free_agent_transfer' => 'present|nullable',
            'allow_weekend_changes' => 'present|nullable',
            'default_squad_size' => 'present|nullable|numeric|min:11|max:18',
            'default_max_player_each_club' => 'present|nullable|numeric|min:1|max:5',
            'available_formations' => 'present|nullable',
            'defensive_midfields' => 'present|nullable',
            'merge_defenders' => 'present|nullable',
            'pre_season_auction_budget' => 'present|nullable|numeric|min:0|max:1000',
            'pre_season_auction_bid_increment' => 'present|nullable|numeric|min:0|max:10',
            'seal_bids_budget' => 'present|nullable|numeric|min:0|max:1000',
            'seal_bid_increment' => 'present|nullable|numeric|min:0|max:10',
            'seal_bid_minimum' => 'present|nullable|numeric|min:0',
            'max_seal_bids_per_team_per_round' => 'present|nullable|numeric|min:0',
            'season_free_agent_transfer_limit' => 'present|nullable|numeric|min:0',
            'monthly_free_agent_transfer_limit' => 'present|nullable|numeric|min:0',
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
            'default_squad_size.min' => 'Please enter a value greater than or equal to :min',
            'default_squad_size.max' => 'Please enter a value less than or equal to :max',
            'default_max_player_each_club.max' => 'Please enter a value less than or equal to :max',
            'default_max_player_each_club.min' => 'After auction, Club quota can only be increased.',
        ];
    }
}
