<?php

namespace App\Http\Resources;

use App\Http\Resources\Season as SeasonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PastWinnerHistory extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'season' => new SeasonResource($this->whenLoaded('season')),
        ];
    }
}
