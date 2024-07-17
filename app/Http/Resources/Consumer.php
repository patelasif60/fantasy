<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Consumer extends JsonResource
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
            'user_id' => $this->user_id,
            'dob' => $this->dob,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'town' => $this->town,
            'county' => $this->county,
            'post_code' => $this->post_code,
            'country' => $this->country,
            'telephone' => $this->telephone,
            'country_code' => $this->country_code,
            'favourite_club' => $this->favourite_club,
            'introduction' => $this->introduction,
            'has_games_news' => $this->has_games_news,
            'has_fl_marketing' => $this->has_fl_marketing,
            'has_third_parities' => $this->has_third_parities,
            'user' => new UserResource($this->user),
        ];
    }
}
