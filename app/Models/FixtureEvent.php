<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureEvent extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function club()
    {
        return $this->hasOne(Club::class, 'id', 'club_id');
    }

    public function details()
    {
        return $this->hasMany(FixtureEventDetails::class, 'event_id', 'id');
    }

    public function eventType()
    {
        return $this->hasOne(FixtureEventType::class, 'id', 'event_type');
    }

    public function fixture()
    {
        return $this->hasOne(Fixture::class, 'id', 'fixture_id');
    }

    public function getMinuteAttribute()
    {
        return explode(':', $this->attributes['minute'])[0];
    }

    public function getSecondAttribute()
    {
        return explode(':', $this->attributes['minute'])[1];
    }

    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    public function subPlayer()
    {
        return $this->hasOne(Player::class, 'id', 'sub_player_id');
    }
}
