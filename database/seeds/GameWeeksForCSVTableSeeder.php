<?php

use App\Models\GameWeek;
use App\Models\Season;
use App\Services\EuropeanPhaseService;
use App\Services\LeaguePhaseService;
use App\Services\ProcupPhaseService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameWeeksForCSVTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(database_path().'/seeds/files/gameweeks_phases_1920.csv', 'r')) !== false) {
            $leaguePhaseService = app(LeaguePhaseService::class);
            $procupPhaseService = app(ProcupPhaseService::class);
            $europeanPhaseService = app(EuropeanPhaseService::class);

            $championsLeagueCount = 1;
            $europaLeagueCount = 1;

            $latestSeason = Season::getLatestSeason();

            $flag = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag < 2) {
                    $flag++;
                    continue;
                }

                $number = string_preg_replace($data[1]);
                $start = Carbon::createFromFormat('d/m/y H:i', string_preg_replace($data[3]));
                $end = Carbon::createFromFormat('d/m/y H:i', string_preg_replace($data[4]));
                $notes = string_preg_replace($data[5]);
                $is_valid_cup_round = string_preg_replace($data[6]);

                $gameweek = GameWeek::create([
                    'season_id' => $latestSeason,
                    'number' => $number,
                    'is_valid_cup_round' => $is_valid_cup_round,
                    'start' => $start,
                    'end' => $end,
                    'notes' => $notes,
                ]);

                if ($gameweek) {
                    $championsLeague = string_preg_replace($data[7]);
                    $europaLeague = string_preg_replace($data[8]);

                    if ($championsLeague && $championsLeague !== '') {
                        if (Str::startsWith($championsLeague, 'G')) {
                            $championsLeague = str_replace('G', '', $championsLeague);
                            $europeanPhaseService->createChampionsLeaguePhase($gameweek, 'Group stage - game '.$championsLeague);
                        } else {
                            $europeanPhaseService->createChampionsLeaguePhase($gameweek, 'Knockout stage - game '.$championsLeagueCount);
                            $championsLeagueCount++;
                        }
                    }

                    if ($europaLeague && $europaLeague !== '') {
                        if (Str::startsWith($europaLeague, 'G')) {
                            $europaLeague = str_replace('G', '', $europaLeague);
                            $europeanPhaseService->createEuropaLeaguePhase($gameweek, 'Group stage - game '.$europaLeague);
                        } else {
                            $europeanPhaseService->createEuropaLeaguePhase($gameweek, 'Knockout stage - game '.$europaLeagueCount);
                            $europaLeagueCount++;
                        }
                    }

                    $leagueSeries_16 = string_preg_replace($data[9]);
                    $leagueSeries_14 = string_preg_replace($data[10]);
                    $leagueSeries_12 = string_preg_replace($data[11]);
                    $leagueSeries_10 = string_preg_replace($data[12]);
                    $leagueSeries_8 = string_preg_replace($data[13]);
                    $leagueSeries_6 = string_preg_replace($data[14]);

                    // League series (head to head)
                    if ($leagueSeries_16 > 0) {
                        $leagueSeries_16 = 'Phase '.$leagueSeries_16;
                        $leaguePhaseService->create($gameweek, 16, $leagueSeries_16);
                    }

                    if ($leagueSeries_14 > 0) {
                        $leagueSeries_14 = 'Phase '.$leagueSeries_14;
                        $leaguePhaseService->create($gameweek, 14, $leagueSeries_14);
                    }

                    if ($leagueSeries_12 > 0) {
                        $leagueSeries_12 = 'Phase '.$leagueSeries_12;
                        $leaguePhaseService->create($gameweek, 12, $leagueSeries_12);
                    }

                    if ($leagueSeries_10 > 0) {
                        $leagueSeries_10 = 'Phase '.$leagueSeries_10;
                        $leaguePhaseService->create($gameweek, 10, $leagueSeries_10);
                    }

                    if ($leagueSeries_8 > 0) {
                        $leagueSeries_8 = 'Phase '.$leagueSeries_8;
                        $leaguePhaseService->create($gameweek, 8, $leagueSeries_8);
                    }

                    if ($leagueSeries_6 > 0) {
                        $leagueSeries_6 = 'Phase '.$leagueSeries_6;
                        $leaguePhaseService->create($gameweek, 6, $leagueSeries_6);
                    }

                    $proCup_7 = string_preg_replace($data[15]);
                    $proCup_10 = string_preg_replace($data[16]);
                    $proCup_13 = string_preg_replace($data[17]);
                    $proCup_16 = string_preg_replace($data[18]);

                    // Pro Cup (FL Cup)
                    if ($proCup_7 > 0) {
                        $proCup_7 = 'Phase '.$proCup_7;
                        $procupPhaseService->create($gameweek, 7, $proCup_7);
                    }

                    if ($proCup_10 > 0) {
                        $proCup_10 = 'Phase '.$proCup_10;
                        $procupPhaseService->create($gameweek, 10, $proCup_10);
                    }

                    if ($proCup_13 > 0) {
                        $proCup_13 = 'Phase '.$proCup_13;
                        $procupPhaseService->create($gameweek, 13, $proCup_13);
                    }

                    if ($proCup_16 > 0) {
                        $proCup_16 = 'Phase '.$proCup_16;
                        $procupPhaseService->create($gameweek, 16, $proCup_16);
                    }
                }
            }
            fclose($handle);
        }
    }
}
