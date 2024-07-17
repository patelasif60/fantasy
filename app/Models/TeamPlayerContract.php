<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPlayerContract extends Model
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
}
