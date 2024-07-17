<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PredefinedCrest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $url = asset('assets/frontend/img/default/square/default-thumb-100.png');

        if (! empty($this->getMedia('crest')->last())) {
            $url = $this->getMedia('crest')->last()->getUrl('thumb');
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_published' => $this->is_published,
            'image' => $url,
        ];
    }
}
