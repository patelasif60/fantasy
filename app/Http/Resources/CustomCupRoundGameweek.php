<?php

namespace App\Http\Resources;

use App\Http\Resources\GameWeek as GameWeekResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomCupRoundGameweek extends JsonResource
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
            'gameweek_id' =>  $this->gameweek_id,
            'custom_cup_round_id' => $this->custom_cup_round_id,
            'gameweek' => new GameWeekResource($this->whenLoaded('gameweek')),
        ];
    }
}
