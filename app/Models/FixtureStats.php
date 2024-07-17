<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureStats extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_updated' => 'array',
    ];

    protected $guarded = ['id'];

    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    public function fixture()
    {
        return $this->hasOne(Fixture::class, 'id', 'fixture_id');
    }
}
