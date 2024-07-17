<?php

namespace App\Repositories;

use App\Models\Fixture;
use App\Models\Season;

class PlTableRepository
{
    public function stats()
    {
        $fixtures = Fixture::join('clubs as ch', 'ch.id', 'fixtures.home_club_id')
                        ->join('clubs as ca', 'ca.id', 'fixtures.away_club_id')
                        ->where('fixtures.season_id', Season::getLatestSeason())
                        ->where('competition', 'Premier League')
                        ->where('status', 'Played')
                        ->whereNotNull('outcome')
                        ->selectRaw('fixtures.home_club_id, ch.short_name AS hclub, fixtures.away_club_id, ca.short_name AS aclub, fixtures.status, fixtures.outcome, fixtures.home_score, fixtures.away_score, fixtures.winner, fixtures.date_time, ch.short_code as ch_short_code, ca.short_code as ca_short_code')
                        ->get();

        $clubs = [];

        foreach ($fixtures as $key => $fixture) {
            if (array_key_exists($fixture->home_club_id, $clubs)) {
                $played = $clubs[$fixture->home_club_id]['played'];
                $clubs[$fixture->home_club_id]['played'] = $played + 1;
                $clubs[$fixture->home_club_id]['goal'] += $fixture->home_score;
                $clubs[$fixture->home_club_id]['ga'] += $fixture->away_score;
            } else {
                $clubs[$fixture->home_club_id]['club_id'] = $fixture->home_club_id;
                $clubs[$fixture->home_club_id]['club'] = $fixture->hclub;
                $clubs[$fixture->home_club_id]['short_code'] = $fixture->ch_short_code;
                $clubs[$fixture->home_club_id]['played'] = 1;
                $clubs[$fixture->home_club_id]['won'] = 0;
                $clubs[$fixture->home_club_id]['drawn'] = 0;
                $clubs[$fixture->home_club_id]['home_goal'] = 0;
                $clubs[$fixture->home_club_id]['home_ga'] = 0;
                $clubs[$fixture->home_club_id]['away_goal'] = 0;
                $clubs[$fixture->home_club_id]['away_ga'] = 0;
                $clubs[$fixture->home_club_id]['goal'] = $fixture->home_score;
                $clubs[$fixture->home_club_id]['ga'] = $fixture->away_score;
                $clubs[$fixture->home_club_id]['cs'] = 0;
                $clubs[$fixture->home_club_id]['home_cs'] = 0;
                $clubs[$fixture->home_club_id]['away_cs'] = 0;
            }

            if (array_key_exists($fixture->away_club_id, $clubs)) {
                $played = $clubs[$fixture->away_club_id]['played'];
                $clubs[$fixture->away_club_id]['played'] = $played + 1;
                $clubs[$fixture->away_club_id]['goal'] += $fixture->away_score;
                $clubs[$fixture->away_club_id]['ga'] += $fixture->home_score;
            } else {
                $clubs[$fixture->away_club_id]['club_id'] = $fixture->away_club_id;
                $clubs[$fixture->away_club_id]['club'] = $fixture->aclub;
                $clubs[$fixture->away_club_id]['short_code'] = $fixture->ca_short_code;
                $clubs[$fixture->away_club_id]['played'] = 1;
                $clubs[$fixture->away_club_id]['won'] = 0;
                $clubs[$fixture->away_club_id]['drawn'] = 0;
                $clubs[$fixture->away_club_id]['home_goal'] = 0;
                $clubs[$fixture->away_club_id]['home_ga'] = 0;
                $clubs[$fixture->away_club_id]['away_goal'] = 0;
                $clubs[$fixture->away_club_id]['away_ga'] = 0;
                $clubs[$fixture->away_club_id]['goal'] = $fixture->away_score;
                $clubs[$fixture->away_club_id]['ga'] = $fixture->home_score;
                $clubs[$fixture->away_club_id]['cs'] = 0;
                $clubs[$fixture->away_club_id]['home_cs'] = 0;
                $clubs[$fixture->away_club_id]['away_cs'] = 0;
            }

            if (trim($fixture->outcome) == 'D') {
                $drawn = $clubs[$fixture->home_club_id]['drawn'];
                $clubs[$fixture->home_club_id]['drawn'] = $drawn + 1;
                $drawn = $clubs[$fixture->away_club_id]['drawn'];
                $clubs[$fixture->away_club_id]['drawn'] = $drawn + 1;
            } else {
                if ($fixture->home_club_id == $fixture->winner) {
                    $won = $clubs[$fixture->home_club_id]['won'];
                    $clubs[$fixture->home_club_id]['won'] = $won + 1;
                } else {
                    $won = $clubs[$fixture->away_club_id]['won'];
                    $clubs[$fixture->away_club_id]['won'] = $won + 1;
                }
            }

            if ($fixture->home_score == 0 && $fixture->away_score == 0) {
                $clubs[$fixture->home_club_id]['cs'] += 1;
                $clubs[$fixture->away_club_id]['cs'] += 1;
            } elseif ($fixture->home_score == 0) {
                $clubs[$fixture->away_club_id]['cs'] += 1;
            } elseif ($fixture->away_score == 0) {
                $clubs[$fixture->home_club_id]['cs'] += 1;
            }
        }

        foreach ($fixtures as $key => $fixture) {
            $clubs[$fixture->home_club_id]['home_goal'] += $fixture->home_score;
            $clubs[$fixture->home_club_id]['home_ga'] += $fixture->away_score;

            $clubs[$fixture->away_club_id]['away_goal'] += $fixture->away_score;
            $clubs[$fixture->away_club_id]['away_ga'] += $fixture->home_score;

            if ($fixture->home_score == 0) {
                $clubs[$fixture->away_club_id]['away_cs'] += 1;
            }
            if ($fixture->away_score == 0) {
                $clubs[$fixture->home_club_id]['home_cs'] += 1;
            }
        }

        $s3Url = config('fantasy.aws_url').'/tshirts/';

        foreach ($clubs as $key => $club) {
            $won = $club['won'];
            $drawn = $club['drawn'];
            $points = (3 * $won) + (1 * $drawn);
            $clubs[$key]['points'] = $points;
            $clubs[$key]['loss'] = $club['played'] - $club['won'] - $club['drawn'];
            $clubs[$key]['gd'] = $club['goal'] - $club['ga'];

            $clubs[$key]['home_gd'] = $club['home_goal'] - $club['home_ga'];
            $clubs[$key]['away_gd'] = $club['away_goal'] - $club['away_ga'];

            $clubs[$key]['m_tshirt'] = $s3Url.$club['short_code'].'/player.png';
        }

        array_multisort(array_column($clubs, 'points'), SORT_DESC,
                        array_column($clubs, 'gd'),      SORT_DESC,
                        array_column($clubs, 'ga'),      SORT_DESC,
                        $clubs);

        return $clubs;
    }
}
