<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $avatarObject = $this->consumer->getMedia('avatar')->last();

        $avatar = null;
        if ($avatarObject) {
            $avatar = $avatarObject->getUrl('thumb');
        }

        $country_code = '+44';

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'status' => $this->status,
            'last_login_at' => $this->last_login_at,
            'dob' => $this->consumer->dob,
            'address_1' => $this->consumer->address_1,
            'address_2' => $this->consumer->address_2,
            'town' => $this->consumer->town,
            'county' => $this->consumer->county,
            'post_code' => $this->consumer->post_code,
            'country' => $this->consumer->country,
            'telephone' => $this->consumer->telephone,
            'country_code' => $this->consumer->country_code ? $this->consumer->country_code : $country_code,
            'favourite_club' => $this->consumer->favourite_club,
            'introduction' => $this->consumer->introduction,
            'has_games_news' => $this->consumer->has_games_news,
            'has_fl_marketing' => $this->consumer->has_fl_marketing,
            'has_third_parities' => $this->consumer->has_third_parities,
            'profile_pic'=>$avatar,
        ];
    }
}
