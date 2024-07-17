<?php

namespace App\Repositories;

use App\Models\FixtureStats;

class FixtureStatsRepository
{
    public function getByPlayerContracts($player_id, $date = [])
    {
        $stats = FixtureStats::where('player_id', $player_id)
                 ->with(['player.teamPlayerPoint', 'fixture']);

        if (! empty($date['start_date'])) {
            $stats->whereHas('fixture', function ($query) use ($date) {
                $query->whereDate('date_time', '>=', $date['start_date']);
            });
        }

        if (! empty($date['end_date'])) {
            $stats->whereHas('fixture', function ($query) use ($date) {
                $query->whereDate('date_time', '<=', $date['end_date']);
            });
        }

        return $stats->get();
    }

    public function getFixtureStatByFixture($fixture_id, $player_id)
    {
        $stat = FixtureStats::where('fixture_id', $fixture_id)
                        ->where('player_id', $player_id)
                        ->first();

        return $stat;
    }
}
