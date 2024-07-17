<?php

namespace App\Http\Resources;

use App\Enums\PlayerContractPositionEnum;
use App\Enums\YesNoEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueReport extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $position = player_position_short($this->position);

        if ($this->position == PlayerContractPositionEnum::DEFENSIVE_MIDFIELDER) {
            if (! is_null($this->division_merge_defenders)) {
                $mergeDefenders = $this->division_merge_defenders;
            } else {
                $mergeDefenders = $this->package_merge_defenders;
            }

            if ($mergeDefenders == YesNoEnum::YES) {
                $position = 'DF';
            }
        }

        return [
            'position' => $position,
            'player_first_name' => $this->player_first_name,
            'player_last_name' => $this->player_last_name,
            'manager_first_name' => $this->manager_first_name,
            'manager_last_name' => $this->manager_last_name,
            'club_name' => $this->club_name,
            'team_name' => $this->team_name,
            'transfer_value' => $this->transfer_value,
            'goal' => $this->goal,
            'assist' => $this->assist,
            'clean_sheet' => $this->clean_sheet,
            'conceded' => $this->conceded,
            'appearance' => $this->appearance,
            'total' => $this->total,
        ];
    }
}
