<?php

namespace App\Repositories;

use App\Enums\CompetitionEnum;
use App\Models\Fixture;
use App\Models\Season;
use Carbon\Carbon;

class FixtureRepository
{
    public function create($data)
    {
        return Fixture::create([
            'season_id' => $data['season'],
            'competition' => $data['competition'],
            'home_club_id'=>$data['home_club'],
            'away_club_id'=>$data['away_club'],
            'api_id' => $data['api_id'],
            'date_time' => $data['date_time'],
        ]);
    }

    public function update($fixture, $data)
    {
        $fixture->fill([
            'season_id' => $data['season'],
            'competition' => $data['competition'],
            'home_club_id'=>$data['home_club'],
            'away_club_id'=>$data['away_club'],
            'api_id' => $data['api_id'],
            'date_time' => $data['date_time'],
        ]);

        $fixture->save();

        return $fixture;
    }

    public function playedRoundsList($division)
    {
        $playedRounds = Fixture::where('stage', '!=', 'Regular Season')
        ->where('season_id', Season::getLatestSeason())
        ->played()
        ->select('fixtures.stage')
        ->groupBy('stage')
        ->get()
        ->pluck('stage');

        return $playedRounds;
    }

    public function getCurrentFaCupRound($division)
    {
        $today = Carbon::now()->format('Y-m-d');

        $currentRound = Fixture::where('competition', CompetitionEnum::FA_CUP)
                        ->where('season_id', Season::getLatestSeason())
                        ->where(\DB::raw('CONVERT(fixtures.date_time, DATE)'), '<=', $today)
                        ->select('stage')
                        ->orderBy('id', 'desc')
                        ->first();

        return $currentRound;
    }
}
