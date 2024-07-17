<?php

namespace App\Repositories;

use App\Models\GameWeek;
use App\Models\Season;
use Illuminate\Support\Arr;

class GameWeekRepository
{
    public function create($season, $data)
    {
        return $season->gameweeks()->create([
            'number' => $data['number'],
            'is_valid_cup_round' => Arr::get($data, 'is_valid_cup_round', 0),
            'start' => $data['start'],
            'end' => $data['end'],
            'notes' => $data['notes'],
        ]);
    }

    public function update($gameweek, $data)
    {
        $gameweek->fill([
            'number' => $data['number'],
            'is_valid_cup_round' => Arr::get($data, 'is_valid_cup_round', 0),
            'start' => $data['start'],
            'end' => $data['end'],
            'notes' => $data['notes'],
        ]);

        $gameweek->save();

        return $gameweek;
    }

    public function getPreviousGameWeeksFromDate($date, $limit = null)
    {
        $gameweeks = GameWeek::where('end', '<', $date)->where('season_id', Season::getLatestSeason());
        if ($limit) {
            $gameweeks = $gameweeks->limit($limit);
        }
        $gameweeks = $gameweeks->orderBy('end', 'desc')->get();

        return $gameweeks;
    }

    public function getGameWeekUsingSize($size, $division)
    {
        $gameweeks = GameWeek::join('league_phases', 'league_phases.gameweek_id', '=', 'gameweeks.id')
            ->select('gameweeks.*')
            ->where('gameweeks.season_id', Season::getLatestSeason())
            ->where('league_phases.size', $size)
            ->groupBy('gameweeks.id')
            ->get();

        return $gameweeks;
    }

    public function getGameWeeks()
    {
        return GameWeek::where('season_id', Season::getLatestSeason())
                ->where('start', '>', now())
                ->get();
    }

    public function getGameWeeksValidCups()
    {
        return GameWeek::where('season_id', Season::getLatestSeason())
                ->where('start', '>', now())
                ->where('is_valid_cup_round', true)
                ->get();
    }

    public function getActiveGameWeek()
    {
        return GameWeek::where('season_id', Season::getLatestSeason())
                ->whereDate('start', '<=', now())
                ->whereDate('end', '>', now())
                ->first();
    }

    public function getLastActiveGameWeek()
    {
        return GameWeek::where('season_id', Season::getLatestSeason())
                ->where('start', '>', now())
                ->first();
    }

    public function getAllGameWeeks($division)
    {
        return GameWeek::where('season_id', Season::getLatestSeason())
                ->orderBy('start')
                ->get();
    }

    public function getCurrentGameWeek()
    {
        $activeGameWeek = GameWeek::where('season_id', Season::getLatestSeason())
                        ->where('start', '<=', now())
                        ->where('end', '>', now())
                        ->first();

        if (! isset($activeGameWeek)) {
            $activeGameWeek = (object) [
                'id' => '',
                'season_id' => '',
                'number' => '',
                'start' => '',
                'end' => '',
                'is_valid_cup_round' => '',
            ];
        }

        return $activeGameWeek;
    }
}
