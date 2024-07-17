<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EuropeanPhase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the phases for the game week.
     */
    public function gameWeek()
    {
        return $this->belongsTo(GameWeek::class, 'gameweek_id');
    }

    public function europaFixtures()
    {
        return $this->hasMany(EuropaFixture::class, 'european_phase_id');
    }

    public function notEuropaWinnerFixtures()
    {
        return $this->europaFixtures()->whereNull('winner');
    }

    public function championFixtures()
    {
        return $this->hasMany(ChampionFixture::class, 'european_phase_id');
    }

    public function notChampionWinnerFixtures()
    {
        return $this->championFixtures()->whereNull('winner');
    }

    public function championEuropaFixtures()
    {
        return $this->hasMany(ChampionEuropaFixture::class, 'european_phase_id');
    }

    public function notChampionEuropaWinnerFixtures()
    {
        return $this->championEuropaFixtures()->whereNull('winner')->whereNull('bye_type');
    }
}
