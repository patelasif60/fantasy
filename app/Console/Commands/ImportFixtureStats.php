<?php

namespace App\Console\Commands;

use App\Enums\EventsEnum;
use App\Models\Club;
use App\Models\Fixture;
use App\Models\FixtureEvent;
use App\Models\FixtureEventDetails;
use App\Models\FixtureEventType;
use App\Models\FixtureLineup;
use App\Models\FixtureLineupPlayer;
use App\Models\FixtureStats;
use App\Models\Player;
use App\Models\VarEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportFixtureStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:fixture-stats
							{--D|date= : Date for which fixture-stats needs to be imported. Format (YYYY-mm-dd)}
							{--R|daterange= : Dates between which fixture-stats needs to be imported. Format (YYYY-mm-dd:YYYY-mm-dd)}
							{--M|month= : Month of the year for which we need to load the fixture-stats. 1-12 (1-Jan, 2-Feb, 3-Mar, 4-Apr, 5-May, 6-Jun, 7-Jul, 8-Aug, 9-Sep, 10-Oct, 11-Nov, 12-Dec)}
							{--F|frequency= : Frequency for the fixture stats call back following the rate limit. M-Every minute, H-Every Hour, D-Daily}
                            {--A|apikey= : API key for particular fixture stats call back following the rate limit. M-Every minute, H-Every Hour, D-Daily}
							';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import Fixture stats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! is_dir(storage_path('app/gracenote'))) {
            mkdir(storage_path('app/gracenote'), 0777, true);
        }
        $positionArray = [
            'Goalkeeper' => 'GK',
            'Defender' => 'DF',
            'Wing Back' => 'DF',
            'Midfielder' => 'MF',
            'Defensive Midfielder' => 'MF',
            'Attacking Midfielder' => 'MF',
            'Striker' => 'ST',
            'Substitute' => 'SU',
        ];

        $actualPositionArray = [
            'Goalkeeper' => 'Goalkeeper (GK)',
            'Defender Left' => 'Full-back (FB)',
            'Defender Right' => 'Full-back (FB)',
            'Defender Centre' => 'Centre-back (CB)',
            'Defender Left/Centre' => 'Centre-back (CB)',
            'Defender Centre/Right' => 'Centre-back (CB)',
            'Wing Back' => 'Centre-back (CB)',
            'Midfielder' => 'Midfielder (MF)',
            'Attacking Midfielder' => 'Midfielder (MF)',
            'Defensive Midfielder' => 'Defensive Midfielder (DMF)',
            'Striker' => 'Striker (ST)',
            'Substitute' => 'Substitute (SU)',
        ];

        $formationArray = [
            'GK,DF,DF,DF,DF,MF,MF,MF,MF,ST,ST' => 1, //'4-4-2',
            'GK,DF,DF,DF,DF,MF,MF,MF,MF,MF,ST' => 2, //'4-5-1',
            'GK,DF,DF,DF,DF,MF,MF,MF,ST,ST,ST' => 3, //'4-3-3',
            'GK,DF,DF,DF,DF,DF,MF,MF,MF,ST,ST' => 4, //'5-3-2',
            'GK,DF,DF,DF,DF,DF,MF,MF,MF,MF,ST' => 5, //'5-4-1',
        ];

        $fixtures = [];
        if ($this->option('date')) {
            $date = $this->option('date');
            try {
                Carbon::createFromFormat('Y-m-d', $date);
            } catch (\Carbon\Exceptions\InvalidDateException $exp) {
                echo "Invalid Date format. Please use YYYY-mm-dd eg: 2019-01-15\n";

                return;
            }
            $fixtures = Fixture::whereIn('status', ['Fixture', 'Playing', 'Played'])->whereDate('date_time', $date)->pluck('id', 'api_id')->toArray();
        } elseif ($this->option('daterange')) {
            $dateRange = explode(':', $this->option('daterange'));
            $startDate = $dateRange[0];
            $endDate = $dateRange[1];
            try {
                Carbon::createFromFormat('Y-m-d', $startDate);
                Carbon::createFromFormat('Y-m-d', $endDate);
            } catch (\Carbon\Exceptions\InvalidDateException $exp) {
                echo "Invalid Date format. Please use YYYY-mm-dd:YYYY-mm-dd eg: 2019-01-15:2019-01-30 \n";

                return;
            }
            $fixtures = Fixture::whereIn('status', ['Fixture', 'Playing', 'Played'])->whereDate('date_time', '>=', $startDate)->whereDate('date_time', '<=', $endDate)->pluck('id', 'api_id')->toArray();
        } elseif ($this->option('month')) {
            $month = $this->option('month');
            if (in_array($month, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])) {
                $fixtures = Fixture::whereIn('status', ['Fixture', 'Playing', 'Played'])->whereMonth('date_time', $month)->pluck('id', 'api_id')->toArray();
            } else {
                echo "Invalid Month. Please input number between 1 - 12\n";

                return;
            }
        } elseif ($this->option('frequency')) {
            $frequency = $this->option('frequency');
            if (in_array(strtolower($frequency), ['m', 'h', 'd'])) {
                $currentDate = Carbon::now();
                // $currentDate = Carbon::createFromFormat('Y-m-d h:i:s', '2019-02-27 00:01:00');
                switch (strtolower($frequency)) {
                    case 'm':
                        $startDate = $currentDate->copy()->addHour()->toDateTimeString();
                        $endDate = $currentDate->copy()->subHours(4)->toDateTimeString();
                        break;
                    case 'h':
                        $startDate = $currentDate->copy()->subHours(4)->toDateTimeString();
                        $endDate = $currentDate->copy()->subHours(8)->toDateTimeString();
                        break;
                    case 'd':
                        $startDate = $currentDate->copy()->subHours(8)->toDateTimeString();
                        $endDate = $currentDate->copy()->subDays(7)->toDateTimeString();
                        break;
                }
                $fixtures = Fixture::whereIn('status', ['Fixture', 'Playing', 'Played'])->where('date_time', '>=', $endDate)->where('date_time', '<', $startDate)->pluck('id', 'api_id')->toArray();
            } else {
                echo "Invalid Frequency value. Please input either of M, H or D\n";

                return;
            }
        } elseif ($this->option('apikey')) {
            $apikey = $this->option('apikey');
            if (! $apikey) {
                echo "Invalid API Key value.\n";

                return;
            }

            $fixtures = Fixture::whereIn('status', ['Fixture', 'Playing', 'Played'])->where('api_id', $apikey)->pluck('id', 'api_id')->toArray();
        } else {
            $fixtures = Fixture::whereIn('status', ['Fixture', 'Playing'])
                ->where(function ($query) {
                    $query->orWhereDate('date_time', Carbon::today());
                    $query->orWhereDate('date_time', Carbon::yesterday());
                })
                ->pluck('id', 'api_id')->toArray();
        }

        if (empty($fixtures)) {
            echo "No Fixtures for Stats\n";

            return;
        }

        echo 'Procesing fixtures '.count($fixtures);
        $clubs = Club::pluck('id', 'api_id')->toArray();
        $eventTypes = FixtureEventType::pluck('id', 'key')->toArray();
        $players = Player::whereHas('playerContract', function ($query) {
            $query->whereNull('end_date');
        })->pluck('id', 'api_id')->toArray();

        $gracenote_outlet_auth_key = config('fantasy.gracenote_outlet_auth_key');
        $fixturesIds = implode(',', array_keys($fixtures));
        $fixtureStatsUrl = "http://api.performfeeds.com/soccerdata/matchstats/$gracenote_outlet_auth_key?_rt=b&_fmt=json&detailed=yes&fx=$fixturesIds";

        // $fixtureStatsUrl = "http://api.performfeeds.com/soccerdata/matchstats/1vmmaetzoxkgg1qf6pkpfmku0k?_rt=b&_fmt=json&fx=$fixturesIds";
        $fixtureStats = json_decode(file_get_contents($fixtureStatsUrl));

        // $filename = storage_path("app/gracenote/fixture-stats.json");
        // file_put_contents($filename, file_get_contents($fixtureStatsUrl));
        // exit;
        // echo "\n$fixtureStatsUrl";
        // $fixtureStats = json_decode(file_get_contents($filename));
        $matchStats = isset($fixtureStats->matchStats) ? $fixtureStats->matchStats : [$fixtureStats];
        foreach ($matchStats as $match) {
            $homeTeam = Arr::first($match->matchInfo->contestant, function ($value) {
                return strtolower($value->position) === 'home';
            });

            // get away team
            $awayTeam = Arr::first($match->matchInfo->contestant, function ($value) {
                return strtolower($value->position) === 'away';
            });

            $winnerTeam = '';
            if (isset($match->liveData->matchDetails->winner)) {
                if (strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) == 'H') {
                    $winnerTeam = $homeTeam->id;
                } elseif (strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) == 'A') {
                    $winnerTeam = $awayTeam->id;
                }
            }

            //'Fixture','Playing','Played','Cancelled','Postponed','Suspended','Awarded'
            // Code to save the Fixture Status.
            $fixture = Fixture::find($fixtures[$match->matchInfo->id]);
            $fixture->status = $match->liveData->matchDetails->matchStatus;
            $fixture->outcome = isset($match->liveData->matchDetails->winner) ? strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) : null;
            $fixture->home_score = isset($match->liveData->matchDetails->scores->total->home) ? $match->liveData->matchDetails->scores->total->home : null;
            $fixture->away_score = isset($match->liveData->matchDetails->scores->total->away) ? $match->liveData->matchDetails->scores->total->away : null;
            $fixture->ht_home_score = isset($match->liveData->matchDetails->scores->ht->home) ? $match->liveData->matchDetails->scores->ht->home : null;
            $fixture->ht_away_score = isset($match->liveData->matchDetails->scores->ht->away) ? $match->liveData->matchDetails->scores->ht->away : null;
            $fixture->ft_home_score = isset($match->liveData->matchDetails->scores->ft->home) ? $match->liveData->matchDetails->scores->ft->home : null;
            $fixture->ft_away_score = isset($match->liveData->matchDetails->scores->ft->away) ? $match->liveData->matchDetails->scores->ft->away : null;
            if (isset($match->liveData->matchDetails->winner)) {
                if (strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) == 'H') {
                    $fixture->winner = $clubs[$homeTeam->id];
                } elseif (strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) == 'A') {
                    $fixture->winner = $clubs[$awayTeam->id];
                }
            }

            $fixture->save();

            if ($match->liveData->matchDetails->matchStatus == 'Fixture' || $match->liveData->matchDetails->matchStatus == 'Played' || $match->liveData->matchDetails->matchStatus == 'Playing') {
                if (isset($match->liveData->lineUp)) {
                    foreach ($match->liveData->lineUp as $club) {
                        $positionList = [];
                        foreach ($club->player as $player) {
                            if ($positionArray[$player->position] != 'SU') {
                                array_push($positionList, $positionArray[$player->position]);
                            }
                            if (! isset($players[$player->playerId])) {
                                continue;
                            }

                            $fxLineup = FixtureLineup::firstOrCreate([
                                'lineup_type' => 'Actual',
                                'club_id' => $clubs[$club->contestantId],
                                'fixture_id' => $fixtures[$match->matchInfo->id],
                            ]);
                            $fxLineup->formation_id = isset($formationArray[implode(',', $positionList)]) ? $formationArray[implode(',', $positionList)] : 1;
                            $fxLineup->save();

                            $fixtureStat = FixtureStats::firstOrNew([
                                'fixture_id' => $fixtures[$match->matchInfo->id],
                                'fixture_api_id' => $match->matchInfo->id,
                                'player_id' => $players[$player->playerId],
                                'player_api_id' => $player->playerId,
                            ]);
                            if ($fixtureStat->wasRecentlyCreated) {
                                if (strtolower($player->position) != 'substitute') {
                                    $fixtureStat->appearance = 90;
                                    $fixtureStat->clean_sheet = 1;
                                }

                                $isUpdated = [];
                            } else {
                                $isUpdated = $fixtureStat->is_updated;
                            }

                            //Types of Penalty missed
                            $totalPenPoint = 0;
                            $playerStats = $player->stat;

                            foreach (['attPenMiss', 'attPenPost', 'attPenTarget'] as $evnt) {
                                $eventDetail = Arr::first($playerStats, function ($value, $key) use ($evnt) {
                                    return $value->type === $evnt;
                                }, new \stdClass);

                                $totalPenPoint += intval($eventDetail->value ?? 0);
                            }

                            if ($this->isUpdate($isUpdated, 'penalty_missed')) {
                                $fixtureStat->penalty_missed = $totalPenPoint;
                            }

                            foreach (['goals', 'redCard', 'yellowCard', 'goalAssist', 'goalsConceded'] as $apiEvent) {
                                $eventData = Arr::first($playerStats, function ($value, $key) use ($apiEvent) {
                                    return $value->type === $apiEvent;
                                }, new \stdClass);

                                if (! isset($eventData->type) && $apiEvent === 'goals') {
                                    if ($this->isUpdate($isUpdated, 'goal')) {
                                        $fixtureStat->goal = 0;
                                    }
                                }

                                if (! isset($eventData->type) && $apiEvent === 'redCard') {
                                    if ($this->isUpdate($isUpdated, 'red_card')) {
                                        $fixtureStat->red_card = 0;
                                    }
                                }

                                if (! isset($eventData->type) && $apiEvent === 'yellowCard') {
                                    if ($this->isUpdate($isUpdated, 'yellow_card')) {
                                        $fixtureStat->yellow_card = 0;
                                    }
                                }

                                if (! isset($eventData->type) && $apiEvent === 'goalAssist') {
                                    if ($this->isUpdate($isUpdated, 'assist')) {
                                        $fixtureStat->assist = 0;
                                    }
                                }

                                if (! isset($eventData->type) && $apiEvent === 'goalsConceded') {
                                    if ($this->isUpdate($isUpdated, 'goal_conceded')) {
                                        $fixtureStat->goal_conceded = 0;
                                    }
                                }
                            }

                            foreach ($playerStats as $stats) {
                                switch ($stats->type) {
                                    case 'goals':
                                        if ($this->isUpdate($isUpdated, 'goal')) {
                                            $fixtureStat->goal = $stats->value;
                                        }
                                        break;
                                    case 'ownGoals':
                                        if ($this->isUpdate($isUpdated, 'own_goal')) {
                                            $fixtureStat->own_goal = $stats->value;
                                        }
                                        break;
                                    case 'goalAssist':
                                        if ($this->isUpdate($isUpdated, 'assist')) {
                                            $fixtureStat->assist = $stats->value;
                                        }
                                        break;
                                    case 'goalsConceded':
                                        if ($this->isUpdate($isUpdated, 'goal_conceded')) {
                                            $fixtureStat->goal_conceded = $stats->value;
                                        }
                                        break;
                                    case 'minsPlayed':
                                        if ($match->liveData->matchDetails->periodId == 14) {
                                            if ($this->isUpdate($isUpdated, 'appearance')) {
                                                $fixtureStat->appearance = $stats->value;
                                            }
                                            if ($club->contestantId == $winnerTeam && $stats->value > 45) {
                                                if ($this->isUpdate($isUpdated, 'club_win')) {
                                                    $fixtureStat->club_win = 1;
                                                }
                                            }
                                        }
                                        // $fixtureStat->appearance = $stats->value;
                                        // if ($club->contestantId == $winnerTeam && $stats->value > 45) {
                                        //     $fixtureStat->club_win = 1;
                                        // }
                                        break;
                                    case 'redCard':
                                        if ($this->isUpdate($isUpdated, 'red_card')) {
                                            $fixtureStat->red_card = $stats->value;
                                        }
                                        break;
                                    case 'yellowCard':
                                        if ($this->isUpdate($isUpdated, 'yellow_card')) {
                                            $fixtureStat->yellow_card = $stats->value;
                                        }
                                        break;
                                    // case 'attPenMiss':
                                    //     if ($this->isUpdate($isUpdated, 'penalty_missed')) {
                                    //         $fixtureStat->penalty_missed = $stats->value;
                                    //     }
                                    //     break;
                                    case 'penaltySave':
                                        if ($this->isUpdate($isUpdated, 'penalty_save')) {
                                            $fixtureStat->penalty_save = $stats->value;
                                        }
                                        break;
                                    case 'cleanSheet':
                                        if ($match->liveData->matchDetails->periodId == 14) {
                                            if ($this->isUpdate($isUpdated, 'clean_sheet')) {
                                                $fixtureStat->clean_sheet = $stats->value;
                                            }
                                        }
                                        break;
                                    case 'saves':
                                        if ($this->isUpdate($isUpdated, 'goalkeeper_save')) {
                                            $fixtureStat->goalkeeper_save = $stats->value;
                                        }
                                        break;
                                }
                            }

                            if ($match->liveData->matchDetails->periodId == 14) {
                                if ($fixtureStat->clean_sheet != 1) {
                                    if ($fixtureStat->goal_conceded == 0 && $fixtureStat->appearance > 75) {
                                        $fixtureStat->clean_sheet = $this->isUpdate($isUpdated, 'clean_sheet') ? 1 : $fixtureStat->clean_sheet;
                                    }
                                }
                            }

                            $callRecalculatePoints = false;
                            $changedField = [];

                            if ($fixtureStat->isDirty()) {
                                // $changedField = $fixtureStat->getDirty();
                                $fixtureStat->save();
                                $callRecalculatePoints = true;
                                // if (count($changedField) == 1 && array_key_exists('appearance', $changedField)) {
                                //     if ($changedField['appearance'] < 45) {
                                //         $callRecalculatePoints = false;
                                //     } elseif ($changedField['appearance'] >= 45 && $appearancePrevValue > 45) {
                                //         $callRecalculatePoints = false;
                                //     }
                                // }
                            }

                            if ($callRecalculatePoints) {
                                /* Recalculate Points only for the Player and Fixture which were updated */
                                $this->call('recalculate:points', ['fixture_stats'=>$fixtureStat]);
                            }

                            $fixtureLineupPlayer = FixtureLineupPlayer::firstOrNew([
                                'lineup_id' => $fxLineup->id,
                                'player_id' => $players[$player->playerId],
                            ]);
                            if ($player->position == 'Defender') {
                                $fixtureLineupPlayer->lineup_position = $actualPositionArray[$player->position.' '.$player->positionSide];
                            } else {
                                $fixtureLineupPlayer->lineup_position = $actualPositionArray[$player->position];
                            }
                            $fixtureLineupPlayer->save();
                        }
                    }
                }

                if (isset($match->liveData->goal)) {
                    foreach ($match->liveData->goal as $goal) {
                        if (isset($players[$goal->scorerId])) {
                            $event_time = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $goal->lastUpdated, 'UTC')->format(config('fantasy.db.datetime.format'));
                            $fe = FixtureEvent::with('details')->where('api_event_id', $goal->optaEventId)->first();
                            if ($fe) {
                                if ($fe->event_time != $event_time) {
                                    $fe->fixture_id = $fixtures[$match->matchInfo->id];
                                    $fe->club_id = $clubs[$goal->contestantId];
                                    $fe->player_id = $players[$goal->scorerId];
                                    if ($goal->type == 'OG') {
                                        $fe->event_type = $eventTypes['own_goal'];
                                    } else {
                                        $fe->event_type = $eventTypes['goal'];
                                    }
                                    $fe->half = $goal->periodId;
                                    $fe->minute = $goal->timeMinSec;
                                    $fe->event_time = $event_time;
                                    $fe->save();

                                    if ($goal->type == 'OG') {
                                        // Handle new event details
                                        // Delete scorer
                                        $fe->details()->where('field', 'scorer')->delete();

                                        $fe->details()->updateOrCreate(
                                            ['field_value' => $players[$goal->scorerId]],
                                            ['field' => 'own_scorer']
                                        );
                                        if (isset($goal->assistPlayerId) && isset($players[$goal->assistPlayerId])) {
                                            $fe->details()->firstOrCreate(
                                                ['field_value' => $players[$goal->assistPlayerId]],
                                                ['field' => 'assist', 'field_value' => $players[$goal->assistPlayerId]]
                                            );
                                        }

                                        // foreach ($fe->details as $detail) {
                                        //     if ($detail->field == 'scorer' || $detail->field == 'own_scorer') {
                                        //         $detail->fill([
                                        //             'field'=>'own_scorer',
                                        //             'field_value'=>$players[$goal->scorerId],
                                        //         ])->push();
                                        //     }
                                        //     if ($detail->field == 'assist' || $detail->field == 'own_assist') {
                                        //         $detail->fill([
                                        //             'field'=>'own_assist',
                                        //             'field_value'=>$players[$goal->assistPlayerId],
                                        //         ])->push();
                                        //     }
                                        // }
                                    } else {
                                        // Handle new event details
                                        // Delete own_scorer
                                        $fe->details()->where('field', 'own_scorer')->delete();

                                        $fe->details()->updateOrCreate(
                                            ['field_value' => $players[$goal->scorerId]],
                                            ['field' => 'scorer']
                                        );
                                        if (isset($goal->assistPlayerId) && isset($players[$goal->assistPlayerId])) {
                                            $fe->details()->firstOrCreate(
                                                ['field_value' => $players[$goal->assistPlayerId]],
                                                ['field' => 'assist', 'field_value' => $players[$goal->assistPlayerId]]
                                            );
                                        }

                                        // foreach ($fe->details as $detail) {
                                        //     if ($detail->field == 'scorer') {
                                        //         $detail->fill([
                                        //             'field'=>'scorer',
                                        //             'field_value'=>$players[$goal->scorerId],
                                        //         ])->push();
                                        //     }
                                        //     if ($detail->field == 'assist') {
                                        //         $detail->fill([
                                        //             'field'=>'assist',
                                        //             'field_value'=>$players[$goal->assistPlayerId],
                                        //         ])->push();
                                        //     }
                                        // }
                                    }
                                }
                            } else {
                                $fe = new FixtureEvent();
                                $fe->api_event_id = $goal->optaEventId;
                                $fe->fixture_id = $fixtures[$match->matchInfo->id];
                                $fe->club_id = $clubs[$goal->contestantId];
                                $fe->player_id = $players[$goal->scorerId];
                                if ($goal->type == 'OG') {
                                    $fe->event_type = $eventTypes['own_goal'];
                                } else {
                                    $fe->event_type = $eventTypes['goal'];
                                }
                                $fe->half = $goal->periodId;
                                $fe->minute = $goal->timeMinSec;
                                $fe->event_time = $event_time;
                                $fe->save();

                                if ($goal->type == 'OG') {
                                    $fe->details()->save(new FixtureEventDetails([
                                        'field'=>'own_scorer',
                                        'field_value'=>$players[$goal->scorerId],
                                    ]));

                                    if (isset($goal->assistPlayerId) && isset($players[$goal->assistPlayerId])) {
                                        $fe->details()->save(new FixtureEventDetails([
                                            'field'=>'own_assist',
                                            'field_value'=>$players[$goal->assistPlayerId],
                                        ]));
                                    }
                                } else {
                                    $fe->details()->save(new FixtureEventDetails([
                                        'field'=>'scorer',
                                        'field_value'=>$players[$goal->scorerId],
                                    ]));

                                    if (isset($goal->assistPlayerId) && isset($players[$goal->assistPlayerId])) {
                                        $fe->details()->save(new FixtureEventDetails([
                                            'field'=>'assist',
                                            'field_value'=>$players[$goal->assistPlayerId],
                                        ]));
                                    }
                                }
                            }
                        }
                    }
                }

                if (isset($match->liveData->card)) {
                    foreach ($match->liveData->card as $card) {
                        if (isset($players[$card->playerId])) {
                            $event_time = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $card->lastUpdated, 'UTC')->format(config('fantasy.db.datetime.format'));
                            $fe = FixtureEvent::with('details')->where('api_event_id', $card->optaEventId)->first();
                            if ($fe) {
                                if ($fe->event_time != $event_time) {
                                    $fe->fixture_id = $fixtures[$match->matchInfo->id];
                                    $fe->club_id = $clubs[$card->contestantId];
                                    $fe->player_id = $players[$card->playerId];
                                    $fe->event_type = ($card->type == 'YC') ? $eventTypes['yellow_card'] : $eventTypes['red_card'];
                                    $fe->half = $card->periodId;
                                    $fe->minute = $card->timeMinSec;
                                    $fe->event_time = $event_time;
                                    $fe->save();

                                    foreach ($fe->details as $detail) {
                                        $detail->fill([
                                            'field'=>($card->type == 'YC') ? 'player_off_yellow' : 'player_off_red',
                                            'field_value'=>$players[$card->playerId],
                                        ])->push();
                                    }
                                }
                            } else {
                                $fe = new FixtureEvent();
                                $fe->api_event_id = $card->optaEventId;
                                $fe->fixture_id = $fixtures[$match->matchInfo->id];
                                $fe->club_id = $clubs[$card->contestantId];
                                $fe->player_id = $players[$card->playerId];
                                $fe->event_type = ($card->type == 'YC') ? $eventTypes['yellow_card'] : $eventTypes['red_card'];
                                $fe->half = $card->periodId;
                                $fe->minute = $card->timeMinSec;
                                $fe->event_time = $event_time;
                                $fe->save();

                                $fe->details()->save(new FixtureEventDetails([
                                    'field'=>($card->type == 'YC') ? 'player_off_yellow' : 'player_off_red',
                                    'field_value'=>$players[$card->playerId],
                                ]));
                            }
                        }
                    }
                }

                if (isset($match->liveData->substitute)) {
                    foreach ($match->liveData->substitute as $substitute) {
                        if (isset($players[$substitute->playerOffId]) && isset($players[$substitute->playerOnId])) {
                            $event_time = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $substitute->lastUpdated, 'UTC')->format(config('fantasy.db.datetime.format'));
                            $fe = FixtureEvent::firstOrCreate([
                                'fixture_id' => $fixtures[$match->matchInfo->id],
                                'club_id' => $clubs[$substitute->contestantId],
                                'player_id' => $players[$substitute->playerOffId],
                                'sub_player_id' => $players[$substitute->playerOnId],
                                'event_type' => $eventTypes['substitution'],
                                'half' => $substitute->periodId,
                                'minute' => $substitute->timeMinSec,
                                'event_time' => $event_time,
                            ]);

                            if ($fe->wasRecentlyCreated) {
                                $fe->details()->createMany([
                                    [
                                        'field'=>'player_off_sub',
                                        'field_value'=>$players[$substitute->playerOffId],
                                    ],
                                    [
                                        'field'=>'player_on_sub',
                                        'field_value'=>$players[$substitute->playerOnId],
                                    ],
                                ]);
                            }
                        }
                    }
                }

                if (isset($match->liveData->VAR)) {
                    foreach ($match->liveData->VAR as $var) {
                        if (isset($players[$var->playerId])) {
                            if ((isset($var->type) && isset($var->decision))) {
                                if (! isset($var->periodId) && ! isset($var->timeMinSec)) {
                                    continue;
                                }

                                $decision = $var->decision;
                                if ($decision === 'Cancelled') {
                                    $eventType = 0;
                                    $playerId = $players[$var->playerId];
                                    $periodId = $var->periodId;
                                    $timeMinSec = $var->timeMinSec;
                                    $optaEventId = $var->optaEventId;
                                    $type = $var->type;
                                    $fixtureId = $fixture->id;

                                    if ($type === 'Goal awarded') {
                                        $eventType = $eventTypes[EventsEnum::GOAL];
                                    }

                                    if ($type === 'Red card given') {
                                        $eventType = $eventTypes[EventsEnum::RED_CARD];
                                    }

                                    if ($type === 'Card upgrade') {
                                        $eventType = $eventTypes[EventsEnum::YELLOW_CARD];
                                    }

                                    if ($type === 'Mistaken Identity') {
                                    }

                                    if ($eventType) {
                                        $varEvent = VarEvent::firstOrCreate(['api_event_id' => $optaEventId]);

                                        if ($varEvent->wasRecentlyCreated) {
                                            $fxe = FixtureEvent::where('player_id', $playerId)
                                                ->where('half', $periodId)
                                                ->where('minute', '<', $timeMinSec)
                                                ->where('event_type', $eventType)
                                                ->where('fixture_id', $fixtureId)
                                                ->orderBy('minute', 'desc')
                                                ->first();

                                            $fxeResult = $fxe ? $fxe->delete() : false;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function isUpdate($data, $column)
    {
        if ($data) {
            if (in_array($column, $data)) {
                return false;
            }
        }

        return true;
    }
}
