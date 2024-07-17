<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCupTeam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var bool
     */
    protected $casts = [
        'is_bye' => 'boolean',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function scopeIsByeTeams($query)
    {
        return $query->where('is_bye', true);
    }
}
