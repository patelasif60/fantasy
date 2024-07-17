<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DivisionPoint extends JsonResource
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
            'division_id' => $this->division_id,
            'events' => $this->events,
            'goal_keeper' => $this->division->getOptionValue('goal_keeper', $this->events),
            'centre_back' => $this->division->getOptionValue('centre_back', $this->events),
            'full_back' => $this->division->getOptionValue('full_back', $this->events),
            'defensive_mid_fielder' => $this->division->getOptionValue('defensive_mid_fielder', $this->events),
            'mid_fielder' => $this->division->getOptionValue('mid_fielder', $this->events),
            'striker' => $this->division->getOptionValue('striker', $this->events),

        ];
    }
}
