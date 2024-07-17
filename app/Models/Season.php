<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
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
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'available_packages' => 'array',
        'premier_api_id' => 'string',
        'facup_api_id' => 'string',
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    public static function getLatestSeason()
    {
        return self::getSeasonByOffset(0);
    }

    public static function getPreviousSeason()
    {
        return self::getSeasonByOffset(1);
    }

    public static function getSeasonByOffset($offset = 0)
    {
        return self::orderBy('start_at', 'DESC')->offset($offset)->limit(1)->first()->id;
    }

    /**
     * Get the fixtures for the season.
     */
    public function fixtures()
    {
        return $this->hasMany(Fixture::class);
    }

    /**
     * Get the game weeks for the season.
     */
    public function gameweeks()
    {
        return $this->hasMany(GameWeek::class);
    }

    public function scopeIsPreSeasonState($query)
    {
        $seasonStart = Carbon::parse($this->find($this->getLatestSeason())->start_at);

        return ($seasonStart->greaterThan(Carbon::now())) ? true : false;
    }

    public function firstFixturePlayed()
    {
        $firstFixtureDate = array_get($this->fixtures()->where('status','Played')->orderBy('date_time', 'ASC')->first(), 'date_time');

        return $firstFixtureDate && Carbon::parse($firstFixtureDate)->isPast();
    }

    public function isSeasonStart()
    {
        if($this) {
            
            $now = now();
            $latestSeasonStartDate = $this->start_at;
            $latestSeasonEndDate = $this->end_at;

            return $now->between($latestSeasonStartDate, $latestSeasonEndDate);
        }

        return false;
    }
}
