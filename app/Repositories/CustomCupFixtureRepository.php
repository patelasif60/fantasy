<?php

namespace App\Repositories;

use App\Enums\CustomCupStatusEnum;
use App\Models\CustomCup;
use App\Models\CustomCupFixture;
use App\Models\CustomCupRound;
use App\Models\Season;

class CustomCupFixtureRepository
{
    public function getStartGameweekRecords($date)
    {
        $cup = CustomCup::join('custom_cup_rounds', 'custom_cup_rounds.custom_cup_id', '=', 'custom_cups.id')
        ->join('custom_cup_round_gameweeks', 'custom_cup_round_gameweeks.custom_cup_round_id', '=', 'custom_cup_rounds.id')
        ->join('gameweeks', 'gameweeks.id', '=', 'custom_cup_round_gameweeks.gameweek_id')
        ->select('custom_cups.id', 'custom_cups.is_bye_random', 'custom_cup_rounds.id as custom_cup_round_id', 'custom_cup_round_gameweeks.id as custom_cup_round_gameweek_id', 'gameweeks.start')
        ->whereDate('gameweeks.start', '=', $date)
        ->where('custom_cups.status', '=', CustomCupStatusEnum::PENDING)
        ->orderBy('custom_cup_round_gameweeks.gameweek_id', 'ASC')
        ->orderBy('gameweeks.start', 'ASC')
        ->get();

        return $cup;
    }

    public function getEndGameweekRecords($date)
    {
        $cup = CustomCupRound::join('custom_cups', 'custom_cup_rounds.custom_cup_id', '=', 'custom_cups.id')
            ->join('custom_cup_round_gameweeks', 'custom_cup_round_gameweeks.custom_cup_round_id', '=', 'custom_cup_rounds.id')
            ->join('custom_cup_fixtures', 'custom_cup_fixtures.custom_cup_round_id', '=', 'custom_cup_rounds.id')
            ->join('gameweeks', function ($join) {
                $join->on('gameweeks.id', 'custom_cup_round_gameweeks.gameweek_id');
                $join->on('gameweeks.id', 'custom_cup_fixtures.gameweek_id');
            })
            ->select('custom_cup_rounds.id', 'custom_cup_rounds.custom_cup_id')
            ->whereDate('gameweeks.end', '=', $date)
            ->where('custom_cup_fixtures.season_id', '=', Season::getLatestSeason())
            ->get()->keyBy('id');

        return $cup;
    }

    public function getRoundWinnerTeams($id)
    {
        return CustomCupFixture::where('custom_cup_round_id', $id)
                ->whereNotNull('winner')
                ->get();
    }

    public function getCustomCup($date)
    {
        $cup = CustomCupRound::join('custom_cups', 'custom_cup_rounds.custom_cup_id', '=', 'custom_cups.id')
            ->join('custom_cup_round_gameweeks', 'custom_cup_round_gameweeks.custom_cup_round_id', '=', 'custom_cup_rounds.id')
            ->join('custom_cup_fixtures', 'custom_cup_fixtures.custom_cup_round_id', '=', 'custom_cup_rounds.id')
            ->join('gameweeks', function ($join) {
                $join->on('gameweeks.id', 'custom_cup_round_gameweeks.gameweek_id');
                $join->on('gameweeks.id', 'custom_cup_fixtures.gameweek_id');
            })
            ->select('custom_cup_rounds.id', 'custom_cup_fixtures.id as custom_fixture_id', 'custom_cups.id as custom_cup_id', 'custom_cup_round_gameweeks.id as custom_cup_round_gameweek_id', 'gameweeks.start', 'custom_cup_fixtures.home', 'custom_cup_fixtures.away', 'gameweeks.id as gameweek_id', 'custom_cup_fixtures.gameweek_id as fixture_gameweek_id')
            ->whereDate('gameweeks.end', '=', $date)
            ->where('custom_cup_fixtures.season_id', '=', Season::getLatestSeason())
            ->orderBy('custom_cup_round_gameweeks.gameweek_id', 'ASC')
            ->orderBy('gameweeks.start', 'ASC')
            ->get()->keyBy('id');

        return $cup;
    }

    public function createMultiple($data)
    {
        return CustomCupFixture::insert($data);
    }

    public function update($fixture, $data)
    {
        $fixture->fill($data);

        return $fixture->save();
    }

    public function getFixtureRounds($division, $consumer)
    {
        return ProcupPhase::join('procup_fixtures', 'procup_fixtures.procup_phase_id', '=', 'procup_phases.id')
            ->join('teams', function ($join) {
                $join->on('procup_fixtures.home', 'teams.id');
                $join->orOn('procup_fixtures.away', 'teams.id');
            })
            ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('divisions.id', '=', $division->id)
            ->where('consumers.id', '=', $consumer)
            ->select('procup_phases.id', 'procup_phases.name')
            ->groupBy('procup_phases.id')
            ->pluck('name', 'id');
    }

    public function getManagerCupRounds($division, $team)
    {
        return CustomCup::join('divisions', 'divisions.id', '=', 'custom_cups.division_id')
            ->join('custom_cup_teams', 'custom_cup_teams.custom_cup_id', '=', 'custom_cups.id')
            ->select('custom_cups.*')
            ->where('divisions.id', '=', $division->id)
            ->where('custom_cup_teams.team_id', '=', $team->id)
            ->where('custom_cups.status', CustomCupStatusEnum::ACTIVE)
            ->groupBy('custom_cups.id', 'custom_cups.name')
            ->get();
    }

    public function deleteFixturesByRoundGameWeek($gameweek)
    {
        return CustomCupFixture::where('custom_cup_round_id', $gameweek->custom_cup_round_id)
                                ->where('gameweek_id', $gameweek->gameweek_id)
                                ->delete();
    }
}
