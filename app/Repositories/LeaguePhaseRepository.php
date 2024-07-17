<?php

namespace App\Repositories;

class LeaguePhaseRepository
{
    public function create($gameweek, $size, $name)
    {
        return $gameweek->leaguePhases()->create([
            'size' => $size,
            'name' => $name,
        ]);
    }

    public function update($leagueSeries, $name)
    {
        $leagueSeries->fill([
            'name' => $name,
        ]);

        return $leagueSeries->save();
    }
}
