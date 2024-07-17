<?php

namespace App\Models;

use App\Enums\EuropeanPhasesNameEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GameWeek extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gameweeks';

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
        'start' => 'date',
        'end' => 'date',
        'is_valid_cup_round' => 'boolean',
    ];

    public static $leagueSeriesNumberOfTeams = [16, 14, 12, 10, 8, 6];

    public static $proCupNumberOfTeams = [16, 13, 10, 7];

    public static function getPhases($teams, $phaseName = '')
    {
        $phases = [];
        if ($teams > 0) {
            foreach (range(1, ($teams)) as $value) {
                array_push($phases, $phaseName.' '.$value);
            }
        }

        return $phases;
    }

    public static function getLeagueSeries()
    {
        foreach (static::$leagueSeriesNumberOfTeams as $league) {
            if ($league <= 6) {
                $multiplier = 4;
            } elseif ($league <= 10) {
                $multiplier = 3;
            } else {
                $multiplier = 2;
            }

            $totalNumberPhases = ($league - 1) * $multiplier;
            $phases[$league] = self::getPhases($totalNumberPhases, 'Phase');
        }

        return $phases;
    }

    public static function getPhasesEuropaLeague($totalTeams)
    {
        return self::getPhasesEuropeanCompetitions($totalTeams);
    }

    public static function getPhasesChampionsLeague($totalTeams)
    {
        return self::getPhasesEuropeanCompetitions($totalTeams * 2);
    }

    public static function getPhasesEuropeanCompetitions($totalTeams)
    {
        $numberOfTeamsInGroup = 4;
        $multiplier = 2;
        $numberOfGroupWinners = 2;

        $totalNumberPhases = ($numberOfTeamsInGroup - 1) * $multiplier;
        $phases1 = self::getPhases($totalNumberPhases, 'Group stage - game');

        //For knockout
        $numberOfTeamsInKnockout = ($totalTeams / $numberOfTeamsInGroup) * $numberOfGroupWinners;
        $numberOfKnockoutPhases = self::getLogWithBase($numberOfTeamsInKnockout);

        // assume maximum of 10
        if ($numberOfKnockoutPhases > 10) {
            $numberOfKnockoutPhases = 10;
        }

        $phases2 = self::getPhases($numberOfKnockoutPhases, 'Knockout stage - game');
        $phases = array_merge($phases1, $phases2);

        return $phases;
    }

    public static function getPhasesProCup()
    {
        $seasonDivisions = Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
                        ->select('divisions.*')
                        ->withCount(['divisionTeams' => function ($query) {
                            $query->where('season_id', Season::getLatestSeason());
                        }])->get();

        $leagues = $seasonDivisions->pluck('division_teams_count', 'id')->filter();

        $groups[7] = $leagues->filter(function ($value, $key) {
            return $value <= 7;
        });

        $groups[10] = $leagues->filter(function ($value, $key) {
            return $value >= 8 && $value <= 10;
        });

        $groups[13] = $leagues->filter(function ($value, $key) {
            return $value >= 11 && $value <= 13;
        });

        $groups[16] = $leagues->filter(function ($value, $key) {
            return $value >= 14;
        });

        $phases = [];
        foreach ($groups as $groupKey => $group) {
            $totalNumberPhases = self::getLogWithBase($group->sum());
            $phases[$groupKey] = self::getPhases($totalNumberPhases, 'Phase');
        }

        return $phases;
    }

    public static function getLogWithBase($value, $base = 2)
    {
        if ($value > 0) {
            return ceil(log($value, $base));
        }

        return $value;
    }

    /**
     * Get the phases for the game week.
     */
    public function europeanPhases()
    {
        return $this->hasMany(EuropeanPhase::class, 'gameweek_id');
    }

    public function europeanPhasesChampionsLeague()
    {
        return $this->europeanPhases()->where('european_phases.tournament', EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);
    }

    public function europeanPhasesEuropaLeague()
    {
        return $this->europeanPhases()->where('european_phases.tournament', EuropeanPhasesNameEnum::EUROPA_LEAGUE);
    }

    public function europeanPhasesChampionsKnockouts()
    {
        return $this->europeanPhasesChampionsLeague()->where('european_phases.name', 'like', '%'.escape_like('Knockout').'%');
    }

    public function europeanPhasesEuropaKnockouts()
    {
        return $this->europeanPhasesEuropaLeague()->where('european_phases.name', 'like', '%'.escape_like('Knockout').'%');
    }

    /**
     * Get the phases for the game week.
     */
    public function leaguePhases()
    {
        return $this->hasMany(LeaguePhase::class, 'gameweek_id');
    }

    /**
     * Get the phases for the game week.
     */
    public function proCupPhases()
    {
        return $this->hasMany(ProcupPhase::class, 'gameweek_id');
    }

    /**
     * Get the season of the game week.
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public static function scopeCurrent($query)
    {
        return $query->whereDate('start', '<=', Carbon::now())
            ->whereDate('end', '>=', Carbon::now())
            ->first();
    }
}
