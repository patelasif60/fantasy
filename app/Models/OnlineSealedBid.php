<?php

namespace App\Models;

use App\Enums\OnlineSealedBidStatusEnum;
use Illuminate\Database\Eloquent\Model;

class OnlineSealedBid extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Scope a query to only include active teams.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWin($query)
    {
        return $query->where('status', OnlineSealedBidStatusEnum::WIN);
    }

    /**
     * Scope a query to only include active teams.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLose($query)
    {
        return $query->where('status', OnlineSealedBidStatusEnum::LOSS);
    }
}
