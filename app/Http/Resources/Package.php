<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Package extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'private_league' => $this->private_league,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'custom_squad_size' => $this->custom_squad_size,
            'custom_club_quota' => $this->custom_club_quota,
            'allow_weekend_changes' => $this->allow_weekend_changes,
            'allow_custom_cup' => $this->allow_custom_cup,
            'allow_fa_cup' => $this->allow_fa_cup,
            'allow_champion_league' => $this->allow_champion_league,
            'allow_europa_league' => $this->allow_europa_league,
            'allow_pro_cup' => $this->allow_pro_cup,
            'allow_head_to_head' => $this->allow_head_to_head,
            'allow_linked_league' => $this->allow_linked_league,
            'digital_prize_type' => $this->digital_prize_type,
            'allow_custom_scoring' => $this->allow_custom_scoring,
            'max_free_places' => $this->max_free_places,
            'enable_supersubs' => $this->enable_supersubs,
            'badge_color' => $this->badge_color,
            'allow_auction_budget' => $this->allow_auction_budget,
            'allow_bid_increment' => $this->allow_bid_increment,
            'allow_process_bids' => $this->allow_process_bids,
            'allow_defensive_midfielders' => $this->allow_defensive_midfielders,
            'allow_merge_defenders' => $this->allow_merge_defenders,
            'allow_weekend_changes_editable' => $this->allow_weekend_changes_editable,
            'allow_rollover_budget' => $this->allow_rollover_budget,
            'allow_available_formations' => $this->allow_available_formations,
            'allow_supersubs' => $this->allow_supersubs,
            'allow_seal_bid_deadline_repeat' => $this->allow_seal_bid_deadline_repeat,
            'allow_season_free_agent_transfer_limit' => $this->allow_season_free_agent_transfer_limit,
            'allow_monthly_free_agent_transfer_limit' => $this->allow_monthly_free_agent_transfer_limit,
            'allow_free_agent_transfer_authority' => $this->allow_free_agent_transfer_authority,
            'allow_enable_free_agent_transfer' => $this->allow_enable_free_agent_transfer,
            'allow_free_agent_transfer_after' => $this->allow_free_agent_transfer_after,
            'allow_seal_bid_minimum' => $this->allow_seal_bid_minimum,
            'allow_money_back' => $this->allow_money_back,
            'allow_tie_preference' => $this->allow_tie_preference,
            'money_back_types' => $this->money_back_types,
            'free_placce_for_new_user' => $this->free_placce_for_new_user,
            'allow_season_budget' => $this->allow_season_budget,
            'allow_max_bids_per_round' => $this->allow_max_bids_per_round,
            'available_formations' => $this->available_formations,
        ];
    }
}
