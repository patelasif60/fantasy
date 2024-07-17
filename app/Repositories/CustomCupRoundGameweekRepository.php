<?php

namespace App\Repositories;

class CustomCupRoundGameweekRepository
{
    public function create($round, $data)
    {
        $gameWeek = $round->gameWeeks()->create([
            'gameweek_id' => $data,
        ]);

        return $gameWeek;
    }
}
