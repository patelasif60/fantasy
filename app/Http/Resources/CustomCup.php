<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomCup extends JsonResource
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
            'division_id' => $this->division_id,
            'is_bye_random' => $this->is_bye_random,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'teamCount' => $this->teams->count(),
            'byesTeamsCount' => $this->teams->where('is_bye', true)->count(),
        ];
    }
}
