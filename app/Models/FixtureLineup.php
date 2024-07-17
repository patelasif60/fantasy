<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureLineup extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'lineup_type' => 'string',
    ];

    public function formation()
    {
        return $this->belongsTo(FixtureFormation::class, 'formation_id', 'id');
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class, 'fixture_id', 'id');
    }

    public function lineupPlayer()
    {
        return $this->hasMany(FixtureLineupPlayer::class, 'lineup_id', 'id');
    }
}
