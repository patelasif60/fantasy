<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPlayerPoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id', 'player_id', 'goal', 'conceded', 'assist', 'clean_sheet', 'appearance', 'total', 'team_point_id', 'own_goal', 'red_card', 'yellow_card', 'penalty_save', 'penalty_missed', 'goalkeeper_save', 'club_win',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function teamPoint()
    {
        return $this->hasOne(TeamPoint::class, 'id', 'team_point_id');
    }
}
