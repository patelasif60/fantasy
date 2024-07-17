<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pitch extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $imageUrl = 'http://via.placeholder.com/140x100?text=No+Image';
        if (! empty($this->getMedia('crest')->last())) {
            $imageUrl = $this->getMedia('crest')->last()->getUrl('thumb');
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'pitch' => $this->pitch,
            'is_published' => $this->is_published,
            'image' => $imageUrl,
        ];
    }
}
