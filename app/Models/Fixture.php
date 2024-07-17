<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function home_team()
    {
        return $this->belongsTo(Club::class, 'home_club_id', 'id');
    }

    public function away_team()
    {
        return $this->belongsTo(Club::class, 'away_club_id', 'id');
    }

    public function scopePlayed($query)
    {
        return $query->where('status', 'Played');
    }

    public static function checkFixtureForSwap($fixtureDate = '')
    {
        $allowTeamChanges = false;

        if ($fixtureDate == '') {
            $fixtureDate = Carbon::now();
        } else {
            $fixtureDate = Carbon::parse($fixtureDate);
        }

        if (! $fixtureDate->isFriday()) {
            if ($fixtureDate->isTuesday() || $fixtureDate->isWednesday() || $fixtureDate->isThursday()) {
                $friday = $fixtureDate->copy()->next(Carbon::FRIDAY);
            } else {
                $friday = $fixtureDate->copy()->previous(Carbon::FRIDAY);
            }
        } else {
            $friday = $fixtureDate->copy()->startOfDay();
        }

        $monday = $friday->copy()->next(Carbon::MONDAY)->endOfDay();

        $block1 = $fixtureDate->between($friday, $monday);

        if (! $fixtureDate->isTuesday()) {
            $tuesday = $fixtureDate->copy()->previous(Carbon::TUESDAY);
        } else {
            $tuesday = $fixtureDate->copy()->startOfDay();
        }

        $thursday = $tuesday->copy()->next(Carbon::THURSDAY)->endOfDay();

        $fixture = self::whereBetween('date_time', [$tuesday, $thursday])
                            ->first([\DB::raw('min(date_time) as min_date'), \DB::raw('max(date_time) as max_date')]);

        if ($fixture) {
            $midWeekDt['start'] = $fixture->min_date;
            $midWeekDt['end'] = $fixture->max_date;

            $midWeekStartDt = Carbon::parse($fixture->min_date);
            $midWeekEndDt = Carbon::parse($fixture->max_date);

            if ($fixtureDate->between($midWeekStartDt, $midWeekEndDt)) {
                $allowTeamChanges = true;
            }
        }

        $fixture = self::whereBetween('date_time', [$friday, $monday])
                            ->first([\DB::raw('min(date_time) as min_date'), \DB::raw('max(date_time) as max_date')]);
        if ($fixture) {
            $weekEndDt['start'] = $fixture->min_date;
            $weekEndDt['end'] = $fixture->max_date;

            $weekEndStartDt = Carbon::parse($fixture->min_date);
            $weekEndEndDt = Carbon::parse($fixture->max_date);

            if ($fixtureDate->between($weekEndStartDt, $weekEndEndDt)) {
                $allowTeamChanges = true;
            }
        }

        return $allowTeamChanges;
    }
}
