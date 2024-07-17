<?php

namespace App\Repositories;

use App\Models\PastWinnerHistory;

class PastWinnerHistoryRepository
{
    public function create($division, $data)
    {
        $history = $division->histories()->create([
            'name' => $data['name'],
            'season_id' => $data['season_id'],
        ]);

        return $history;
    }

    public function update($history, $data)
    {
        $history = $history->fill([
            'name' => $data['name'],
            'season_id' => $data['season_id'],
        ]);

        $history->save();

        return $history;
    }

    public function getHallOfFame($division)
    {
        $divisionIds = $division->getDivisionFromUuid();
        $histories = PastWinnerHistory::with('season')->whereIn('division_id',$divisionIds)->get();
        $histories = $histories->sortByDesc('season.start_at');

        return $histories;
    }
}
