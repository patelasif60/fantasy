<?php

namespace App\Repositories;

class EuropeanPhaseRepository
{
    public function create($gameweek, $tournament, $name)
    {
        return $gameweek->europeanPhases()->create([
            'tournament' => $tournament,
            'name' => $name,
        ]);
    }

    public function update($europeanCompetitions, $name)
    {
        $europeanCompetitions->fill([
            'name' => $name,
        ]);

        return $europeanCompetitions->save();
    }
}
