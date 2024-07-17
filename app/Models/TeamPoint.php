<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id', 'goal', 'assist', 'clean_sheet', 'appearance', 'total', 'conceded', 'fixture_id', 'own_goal', 'red_card', 'yellow_card', 'penalty_save', 'penalty_missed', 'goalkeeper_save', 'club_win',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function fixture()
    {
        return $this->hasOne(Fixture::class, 'id', 'fixture_id');
    }

    public function playerPoints()
    {
        return $this->hasMany(TeamPlayerPoint::class, 'id', 'team_point_id');
    }
}
