<?php

namespace App\Http\Resources;

use App\Http\Resources\CustomCupRoundGameweek as CustomCupRoundGameweekResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomCupRound extends JsonResource
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
            'round' =>  $this->round,
            'custom_cup_id' => $this->custom_cup_id,
            'gameweeks' => CustomCupRoundGameweekResource::collection($this->whenLoaded('gameWeeks')),
        ];
    }
}
