<?php

namespace App\Repositories;

use App\Models\DivisionTeam;
use App\Models\Season;
use App\Models\Team;

class DivisionTeamRepository
{
    public function create($data)
    {
        return DivisionTeam::create([
            'division_id'     => $data['division_id'],
            'team_id'       => $data['team_id'],
            'season_id'      => $data['season_id'],
        ]);
    }

    public function update($divisionTeam, $data)
    {
        $divisionTeam->fill([
            'division_id'     => $data['division_id'],
            'team_id'       => $data['team_id'],
            'season_id'      => $data['season_id'],
        ]);

        $divisionTeam->save();

        return $divisionTeam;
    }

    public function getTeams($team_id = null)
    {
        if ($team_id) {
            return Team::with('consumer.user')->whereNotIn('id', collect(DivisionTeam::where('team_id', '!=', $team_id)->pluck('team_id'))->values()->all())->get();
        }

        return Team::with('consumer.user')->whereNotIn('id', collect(DivisionTeam::pluck('team_id'))->values()->all())->get();
    }

    public function getSeasons()
    {
        return Season::orderBy('id', 'desc')->pluck('name', 'id')->all();
    }

    public function getDivisionTeams($division_id)
    {
        return DivisionTeam::where('division_id', $division_id)->with('season')->get();
    }
}
