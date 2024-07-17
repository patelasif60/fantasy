<?php

namespace App\Http\Resources;

use App\Models\PredefinedCrest;
use App\Http\Resources\Consumer as ConsumerResource;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
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
            'manager_id' => $this->manager_id,
            'crest_id' => $this->crest_id,
            'pitch_id' => $this->pitch_id,
            'is_approved' => $this->is_approved,
            'is_paid' => $this->isPaid(),
            'uuid' => $this->uuid,
            'crest_url' => $this->getCrestImageThumb(),
            'team_budget' => $this->team_budget,
            'season_quota_used' => $this->season_quota_used,
            'monthly_quota_used' => $this->monthly_quota_used,
            'ownTeam' => $this->manager_id === auth('api')->user()->consumer->id,
            'consumer' => new ConsumerResource($this->whenLoaded('consumer')),
            'manager'=>$this->when($this->relationloaded('manager'), function () {
                return new UserResource($this->manager);
            }),
        ];
    }
}
