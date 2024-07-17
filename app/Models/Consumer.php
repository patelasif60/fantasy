<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Consumer extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that aren't mass assignable.
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
        'has_games_news' => 'boolean',
        'has_fl_marketing' => 'boolean',
        'has_third_parities' => 'boolean',
        //'dob' => 'date',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 250, 250)
            ->performOnCollections('avatar');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    /**
     * Get the consumer data associated with the user,
     * in case the user has registered as a consumer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the division data associated with the consumer.
     */
    public function coChairmenDivisions()
    {
        return $this->belongsToMany(Division::class, 'division_co_chairman', 'co_chairman_id', 'division_id');
    }

    public function divisions()
    {
        return $this->hasMany(Division::class, 'chairman_id');
    }

    /**
     * Get the teams data associated with the user.
     */
    public function teams()
    {
        return $this->hasMany(Team::class, 'manager_id');
    }

    /**
     * Check consumer have own division.
     */
    public function ownLeagues($division)
    {
        if (request()->hasSession()) {
            if ($division->coChairmen) {
                foreach ($division->coChairmen as $key => $chairmen) {
                    if ($this->id === $chairmen->pivot->co_chairman_id) {
                        return true;
                    }
                }
            }

            if (session('league.role', 'chairman') === 'chairman') {
                return $this->id === $division->chairman_id;
            }

            return false;
        } else {
            return $this->ownLeaguesNav($division);
        }
    }

    public function ownLeaguesNav($division)
    {
        return $this->id === $division->chairman_id;
    }

    /**
     * Check consumer have own team.
     */
    public function ownTeam($division)
    {
        return $division->divisionTeams()->where('manager_id', $this->id)->count();
    }

    /**
     * Get own team details.
     */
    public function ownTeamDetails($division)
    {
        return $division->divisionTeams()->where('manager_id', $this->id)->first();
    }

    /**
     * Get own team details.
     */
    public function ownFirstApprovedTeamDetails($division)
    {
        return $division->divisionTeams()->where('manager_id', $this->id)->where('is_approved', true)->first();
    }

    public function getFirstApprovedTeamDetails($division)
    {
        return $division->divisionTeams()->where('is_approved', true)->first();
    }

    public function ownDivisionWithRegisterTeam($with = [])
    {
        $season = Season::getLatestSeason();

        $divisions = Division::with($with)
                    ->join('division_teams', function ($join) use($season) {
                        $join->on('divisions.id', '=', 'division_teams.division_id')
                            ->where('division_teams.season_id', $season);
                    })
                    ->select('divisions.*')
                    ->where('divisions.chairman_id', $this->id)
                    ->groupBy('divisions.id')
                    ->get();

        $divisionTeams = Division::with($with)
                    ->join('division_teams', function ($join) use($season) {
                        $join->on('divisions.id', '=', 'division_teams.division_id')
                            ->where('division_teams.season_id', $season);
                    })
                    ->join('teams', 'teams.id', '=', 'division_teams.team_id')
                    ->select('divisions.*', DB::raw('1 as active'))
                    ->where('teams.manager_id', $this->id)
                    ->whereNotIn('divisions.id',$divisions->pluck('id'))
                    ->where('teams.is_approved', true)
                    ->where('division_teams.season_id', $season)
                    ->groupBy('divisions.id')
                    ->get();

        $sameDivisions = $divisions->merge($divisionTeams);

        $parentDivisionIds = $sameDivisions->pluck('parent_division_id');
        $divisionIds = $sameDivisions->pluck('id');
        $mergedAllDivision = $parentDivisionIds->merge($divisionIds)->unique()->filter();

        if($mergedAllDivision->count()) {
            $parentDivisionTeams = Division::with($with)
                     ->join('division_teams', function ($join) use($season) {
                        $join->on('divisions.id', '=', 'division_teams.division_id')
                            ->where('division_teams.season_id', $season);
                    })
                    ->join('teams', 'teams.id', '=', 'division_teams.team_id')
                    ->select('divisions.*', DB::raw('1 as active'))
                    ->whereIn('divisions.parent_division_id', $mergedAllDivision)
                    ->OrWhereIn('divisions.id', $mergedAllDivision)
                    ->where('teams.is_approved', true)
                    ->where('division_teams.season_id', $season)
                    ->groupBy('divisions.id')
                    ->get();

            $merged = $sameDivisions->merge($parentDivisionTeams);

        } else {
            $merged = $sameDivisions;
        }

        $divisions = $merged->flatten()->unique(function ($division) {
            if ($division) {
                return $division->id;
            }
        })->sortBy('name');
        

        return $divisions;
    }

    public function ownDivisionTeams()
    {
        return Division::whereHas('divisionTeams', function ($query) {
            $query->where('manager_id', $this->id)
            ->where('season_id', Season::getLatestSeason());
        })
        ->get();
    }

    public function ownDivisionWithoutTeam()
    {
        return Division::where('chairman_id', $this->id)
        ->with('divisionTeams')
        ->has('divisionTeams', '=', 0)
        ->first();
    }

    /**
     * Check consumer is co-chairman an have own division.
     */
    public function coChairmanOwnLeagues($division)
    {
        if ($division->coChairmen) {
            $response = false;
            foreach ($division->coChairmen as $key => $chairmen) {
                if ($this->id === $chairmen->pivot->co_chairman_id) {
                    $response = true;
                    break;
                }
            }
        }

        return $response;
    }

    public function getDefaultDivison()
    {
        return Division::where('chairman_id', $this->id)
        ->first();
    }

    public function feedCount()
    {
        return $this->hasOne(FeedCount::class);
    }

    /**
     * Check consumer is co-chairman of a league.
     */
    public function isCoChairmanOfLeague($division)
    {
        $flag = false;
        if ($division->coChairmen) {
            foreach ($division->coChairmen as $key => $chairmen) {
                if ($this->id === $chairmen->pivot->co_chairman_id) {
                    $flag = true;
                }
            }
        }

        return $flag;
    }

    public function ownTeamInParentAssociatedLeague($division)
    {
        $season = Season::getLatestSeason();

        $divisions = Division::leftJoin('division_teams', function ($join) use ($season) {
            $join->on('divisions.id', '=', 'division_teams.division_id')
                            ->where('division_teams.season_id', $season);
        })
                    ->select('divisions.*')
                    ->where('divisions.parent_division_id', $division->id)
                    ->get();

        $divisionTeams = Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
                    ->join('teams', 'teams.id', '=', 'division_teams.team_id')
                    ->select('divisions.*', DB::raw('1 as active'))
                    ->where('teams.manager_id', $this->id)
                    ->where('teams.is_approved', true)
                    ->where('division_teams.season_id', $season)
                    ->get();

        $divisionTeamIds = $divisions->merge($divisionTeams);

        $sameDivisionIds = $divisionTeamIds->pluck('id');
        $parentDivisionIds = $divisionTeamIds->pluck('parent_division_id');

        if (empty(array_filter($parentDivisionIds->toArray()))) {
            $parentDivisionIds = $divisionTeamIds->pluck('id');
        }

        $parentDivisionTeams = collect();
        if(count($parentDivisionIds)) {
            $parentDivisionTeams = Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
                    ->join('teams', 'teams.id', '=', 'division_teams.team_id')
                    ->select('divisions.*', DB::raw('1 as active'))
                    ->whereIn('divisions.parent_division_id', $parentDivisionIds)
                    ->OrWhere('divisions.id', $parentDivisionIds)
                    ->where('teams.is_approved', true)
                    ->where('division_teams.season_id', $season)
                    ->groupBy('divisions.id')
                    ->get();
        }

        $authUserLeagueArray = Division::where('chairman_id', $this->id)->get()->pluck('id');
        $authChildLinkedLeagueArray = ChildLinkedLeague::whereIn('division_id', $authUserLeagueArray)->get()->pluck('id');
        $authParentLinkedLeagueArray = ParentLinkedLeague::whereIn('division_id', $authUserLeagueArray)->get()->pluck('id');

        $authArray = $authChildLinkedLeagueArray->merge($authParentLinkedLeagueArray);

        $authChildLinkedLeagueArray = ChildLinkedLeague::whereIn('parent_linked_league_id', $authArray)->get()->pluck('division_id');
        $authParentLinkedLeagueArray = ParentLinkedLeague::whereIn('id', $authArray)->get()->pluck('division_id');

        $authDivisionIds = $authChildLinkedLeagueArray->merge($authParentLinkedLeagueArray);

        if ($parentDivisionTeams->contains($division->id) || $parentDivisionIds->contains($division->id) || $authDivisionIds->contains($division->id)) {
            
            return true;
        }

        return false;
    }
}
