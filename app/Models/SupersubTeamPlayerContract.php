<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupersubTeamPlayerContract extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => 1,
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function scopegroupPlayerContracts($query)
    {
        $query->groupBy('team_id');
        $query->groupBy('player_id');
    }

    public function scopeActive($query)
    {
        $query->whereNull('end_date');
    }

    public function scopeInActive($query)
    {
        $query->WhereNotNull('end_date');
    }

    public function scopeLineUp($query)
    {
        $query->where('is_active', true)->whereNull('end_date');
    }

    public function scopeSubstitute($query)
    {
        $query->where('is_active', false)->whereNull('end_date');
    }

    public static function updateSuperSubTeamPlayer($team, $player, $date)
    {
        \Log::info('setting is_applied = 1 from updateSuperSubTeamPlayer model for team id: '.$team.' and start_date: '.$date.' and player_id: '.$player);

        return self::where('player_id', $player)
                ->where('team_id', $team)
                ->where('start_date', '>=', $date)
                ->update(['is_applied' => true]);
    }

    public static function updateSuperSubTeam($team, $date)
    {
        \Log::info('setting is_applied = 1 from updateSuperSubTeam model for team id: '.$team.' and start_date: '.$date);

        return self::where('team_id', $team)
                ->update(['is_applied' => true]);
    }
}
