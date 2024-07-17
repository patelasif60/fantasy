<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureLineupPlayer extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function lineup()
    {
        return $this->belongsTo(FixtureLineup::class);
    }

    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }
}
