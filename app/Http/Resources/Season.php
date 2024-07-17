<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Season extends JsonResource
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
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
