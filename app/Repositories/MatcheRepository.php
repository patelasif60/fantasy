<?php

namespace App\Repositories;

use App\Enums\EventsEnum;
use App\Models\Fixture;
use App\Models\FixtureEvent;
use App\Models\FixtureLineupPlayer;
use App\Models\FixtureStats;
use App\Models\GameWeek;
use App\Models\Season;
use App\Services\DivisionService;

class MatcheRepository
{
    const YELLOW_CARD_LIMIT = 2;
    const GOAL_KEEPER_SAVE = 5;
    const APPEARANCE_TIME = 45;
    const CLEAN_SHEET_TIME = 75;
    const EVENT_POINTS = 1;
    const DEFENSIVE_MID_FIELDER = 'defensive_mid_fielder';
    const MID_FIELDER = 'mid_fielder';
    const CENTRE_BACK = 'centre_back';
    const FULL_BACK = 'full_back';
    const FUTURE_FIXTURES_LIMIT = 14;

    const GOAL_EVENT = 1;

    /**
     * @var DivisionService
     */
    protected $divisionService;

    public function __construct(DivisionService $service)
    {
        $this->divisionService = $service;
    }

    public function getGameWeekMatches(GameWeek $gameWeek, $division)
    {
        $matches = Fixture::join('clubs', 'clubs.id', '=', 'fixtures.home_club_id')
                            ->whereBetween('date_time', [$gameWeek->start, $gameWeek->end])
                            ->selectRaw('fixtures.*')
                            ->where('season_id', Season::getLatestSeason())
                            ->orderByRaw('fixtures.date_time, clubs.name')
                            ->get();

        foreach ($matches as $match) {
            $match->setAttribute('time', get_date_time_in_carbon($match->date_time)->format('H:i'));
            $match->setAttribute('date', get_date_time_in_carbon($match->date_time)->format('jS F Y'));
        }

        return $matches;
    }

    public function getMatchePlayers(GameWeek $gameWeek)
    {
        $players = FixtureStats::join('fixtures', function ($query) use ($gameWeek) {
            $query->on('fixtures.id', '=', 'fixture_stats.fixture_id')
                                            ->whereBetween('fixtures.date_time', [$gameWeek->start, $gameWeek->end]);
        })
                                ->join('player_contracts', function ($query) {
                                    $query->on('fixture_stats.player_id', '=', 'player_contracts.player_id')
                                            ->whereNull('player_contracts.end_date');
                                })
                                ->join('players', 'players.id', '=', 'fixture_stats.player_id')
                                ->leftjoin('fixture_events', function ($query) use ($gameWeek) {
                                    $query->on('fixture_events.fixture_id', '=', 'fixture_stats.fixture_id')
                                            ->on('fixture_events.player_id', '=', 'fixture_stats.player_id')
                                            ->whereIn('fixture_events.event_type', [1, 11]);
                                })
                                ->leftjoin('fixture_event_details', function ($query) use ($gameWeek) {
                                    $query->on('fixture_event_details.event_id', '=', 'fixture_events.id')
                                            ->whereIn('fixture_event_details.field', ['assist', 'assist2', 'assist3', 'own_assist']);
                                })
                                ->selectRaw("
                                    fixtures.id as fixture_id, players.id as player_id, players.first_name, players.last_name, fixture_stats.player_id, fixture_stats.goal, fixture_stats.own_goal, fixture_stats.assist, fixture_stats.appearance, fixtures.home_club_id, fixtures.away_club_id, player_contracts.club_id, IF((fixtures.home_club_id = player_contracts.club_id), 'Home', 'Away') AS player_club, fixture_events.event_type, fixture_events.minute, fixture_event_details.field, fixture_event_details.field_value
                                ")
                                // Home => Home Club Player, Away => Away Club Player
                                ->where(function ($where) {
                                    $where->where('fixture_stats.goal', '>', 0)
                                        ->orWhere('fixture_stats.own_goal', '>', 0);
                                })
                                ->orderByRaw('fixture_stats.fixture_id, fixture_events.minute')
                                ->get();

        $tmpPlayers = [];
        foreach ($players as $key => $player) {
            // if (in_array($player->player_id, array_keys($tmpPlayers)) && $player->assist == 0 && ($player->field == 'assist' || $player->field == 'assist2' || $player->field == 'assist3')) {
            //     $tmpPlayers[$player->player_id] .= ','.$player->field_value;
            // } else {
            //     if(trim($player->field_value) != '') {
            //         $tmpPlayers[$player->player_id] = $player->field_value;
            //     }
            // }

            $minute = str_replace(':', '', $player->minute);
            $tmpPlayers[$player->player_id][$minute][] = $player->field_value;

            // if (in_array($player->player_id, array_keys($tmpPlayers))) {
            //     $tmpPlayers[$player->player_id] .= ','.$player->minute.'|'.$player->field_value;
            // } else {
            //     $tmpPlayers[$player->player_id] = $player->minute.'|'.$player->field_value;
            // }
        }

        $playerList = [];

        $oldPlayer = '';
        foreach ($players as $key => $player) {
            $player->goal_time = 999;
            $player->field_value = @$tmpPlayers[$player->player_id];

            if (! empty($oldPlayer)) {
                if ($oldPlayer->player_id == $player->player_id && $oldPlayer->field_value == $player->field_value && $oldPlayer->minute == $player->minute) {
                    continue;
                }
            }

            if ($player->minute) {
                $time = explode(':', $player->minute);
                $player->goal_time = (int) $time[0];
                if ((int) $time[1] > 0) {
                    $player->goal_time = (int) $time[0] + 1;
                }
            }
            $playerList[$player->fixture_id][] = $player->toArray();

            $oldPlayer = $player;
        }

        foreach ($playerList as $key => $players) {
            $keys = array_column($playerList[$key], 'goal_time');
            array_multisort($keys, SORT_ASC, $playerList[$key]);
        }

        return $playerList;
    }

    public function getAssistPlayers($gameWeek)
    {
        $players = FixtureStats::join('fixtures', function ($query) use ($gameWeek) {
            $query->on('fixtures.id', '=', 'fixture_stats.fixture_id')
                                    ->whereBetween('fixtures.date_time', [$gameWeek->start, $gameWeek->end]);
        })
                        ->join('players', 'players.id', '=', 'fixture_stats.player_id')
                        ->where('fixture_stats.assist', '>', 0)
                        ->get()
                        ->keyBy('player_id');

        return $players;
    }

    public function gameWeekFixtureStats($division, $gameWeek, $fixture)
    {
        $minsMatchPlayed = FixtureStats::where('fixture_id', $fixture->id)
                                ->selectRaw('max(appearance) as minsMatchPlayed')
                                ->first();

        $minsMatchPlayed = $minsMatchPlayed->minsMatchPlayed;

        if ($minsMatchPlayed < 90) {
            $minsMatchPlayed = 90;
        }

        $columns = $this->divisionService->leagueStandingColumnHideShow($division);
        $isYRCardIncluded = $columns['red_card'] + $columns['yellow_card'];

        if ($isYRCardIncluded != 0) {
            $isYRCardIncluded = true;
        } else {
            $isYRCardIncluded = false;
        }

        $isCustomisedScoring = $division->isCustomisedScoring();

        $playerStats = FixtureLineupPlayer::join('fixture_lineups', function ($query) use ($fixture) {
            $query->on('fixture_lineup_players.lineup_id', '=', 'fixture_lineups.id')
                                                ->whereIn('fixture_lineups.club_id', [$fixture->home_club_id, $fixture->away_club_id])
                                                ->where('fixture_lineups.fixture_id', $fixture->id);
        })
                                        ->join('fixture_stats', function ($query) use ($fixture) {
                                            $query->on('fixture_stats.player_id', '=', 'fixture_lineup_players.player_id')
                                                ->where('fixture_stats.fixture_id', $fixture->id);
                                        })
                                        ->join('players', 'players.id', '=', 'fixture_lineup_players.player_id')
                                        ->join('player_contracts', function ($query) {
                                            $query->on('player_contracts.player_id', '=', 'players.id')
                                                ->whereNull('player_contracts.end_date');
                                        })
                                        ->selectRaw('fixture_lineup_players.id, fixture_lineup_players.lineup_id, fixture_lineup_players.player_id, players.first_name, players.last_name, fixture_lineup_players.lineup_position, fixture_lineups.club_id, fixture_lineups.fixture_id, fixture_stats.*, player_contracts.*')
                                        ->orderBy('fixture_lineup_players.lineup_position')
                                        ->get();

        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        $positionArr['GK'] = 'goal_keeper';
        $positionArr['CB'] = 'centre_back';
        $positionArr['FB'] = 'full_back';
        $positionArr['DMF'] = 'defensive_mid_fielder';
        $positionArr['MF'] = 'mid_fielder';
        $positionArr['ST'] = 'striker';

        $clubPlayers = [];
        foreach ($playerStats as $key => $player) {
            $player->lineup_position = player_position_short($player->lineup_position);

            $player->points = 0;

            $player->position = player_position_short($player->position);
            $playerPosition = $positionArr[$player->position];

            if ($playerPosition == self::DEFENSIVE_MID_FIELDER) {
                $playerPosition = ($division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
            }

            if ($playerPosition == self::CENTRE_BACK) {
                $playerPosition = ($division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
            }

            $pointCalc['goals'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL);
            $pointCalc['assist'] = $division->getOptionValue($playerPosition, EventsEnum::ASSIST);
            $pointCalc['clean_sheet'] = $division->getOptionValue($playerPosition, EventsEnum::CLEAN_SHEET);
            $pointCalc['goal_conceded'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL_CONCEDED);
            $pointCalc['appearance'] = $division->getOptionValue($playerPosition, EventsEnum::APPEARANCE);
            $pointCalc['club_win'] = $division->getOptionValue($playerPosition, EventsEnum::CLUB_WIN);
            $pointCalc['yellow_card'] = $division->getOptionValue($playerPosition, EventsEnum::YELLOW_CARD);
            $pointCalc['red_card'] = $division->getOptionValue($playerPosition, EventsEnum::RED_CARD);
            $pointCalc['own_goal'] = $division->getOptionValue($playerPosition, EventsEnum::OWN_GOAL);
            $pointCalc['penalty_missed'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_MISSED);
            $pointCalc['penalty_save'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_SAVE);
            $pointCalc['goalkeeper_save'] = $division->getOptionValue($playerPosition, EventsEnum::GOALKEEPER_SAVE_X5);

            $player->club_win = ($player->appearance > 45 && $player->club_win != 0) ? $player->club_win : 0;

            if ($player->goalkeeper_save > 0) {
                $player->goalkeeper_save = floor(($player->penalty_save + $player->goalkeeper_save) / 5);
            } else {
                $player->goalkeeper_save = 0;
            }

            $player->pld = ($player->appearance > 0) ? 1 : 0;
            if ($player->lineup_position == 'SU') {
                $player->pld = ($player->appearance >= 45) ? 1 : 0;
            }

            
            if ($pointCalc['goal_conceded'] == 0) {
                $player->goal_conceded = 0;
            }
            if ($pointCalc['clean_sheet'] == 0) {
                $player->clean_sheet = 0;
            }

            $gpPositions = ['GK', 'FB', 'CB'];
            if ($player->appearance >= 45 && in_array($player->position, $gpPositions)) {
                $player->def_app_pts = 1;
            } else {
                $player->def_app_pts = 0;
            }

            $total = 0;
            $total += (int) (@$player->goal * $pointCalc['goals']);
            $total += (int) (@$player->assist * $pointCalc['assist']);
            $total += (int) (@$player->goal_conceded * $pointCalc['goal_conceded']);
            $total += (int) (@$player->clean_sheet * $pointCalc['clean_sheet']);
            $total += (int) (@$player->own_goal * $pointCalc['own_goal']);
            $total += (int) (@$player->penalty_missed * $pointCalc['penalty_missed']);
            $total += (int) (@$player->penalty_save * $pointCalc['penalty_save']);
            $total += (int) (@$player->goalkeeper_save * $pointCalc['goalkeeper_save']);
            $total += (int) (@$player->yellow_card * $pointCalc['yellow_card']);
            $total += (int) (@$player->red_card * $pointCalc['red_card']);
            $total += (int) (@$player->def_app_pts * $pointCalc['appearance']);

            $player->points = $total;

            $record = FixtureEvent::where('fixture_id', $fixture->id)
                                ->where('event_type', 2)
                                ->where(function ($q) use ($player) {
                                    $q->where('player_id', $player->player_id)
                                        ->orWhere('sub_player_id', $player->player_id);
                                })
                                ->first();

            $player->is_sub = '-';
            if ($record) {
                if ($record->sub_player_id == $player->player_id) {
                    $player->is_sub = 'in';
                } else {
                    $player->is_sub = 'out';
                }
            }

            if ($player->lineup_position != 'SU') {
                if ($player->position == 'GK') {
                    $clubPlayers[$player->club_id]['gk'][] = $player;
                } elseif ($player->position == 'FB') {
                    if ($mergeDefenders == 'Yes') {
                        $player->position = 'DF';
                        $clubPlayers[$player->club_id]['df'][] = $player;
                    } else {
                        $clubPlayers[$player->club_id]['fb'][] = $player;
                    }
                } elseif ($player->position == 'CB') {
                    if ($mergeDefenders == 'Yes') {
                        $player->position = 'DF';
                        $clubPlayers[$player->club_id]['df'][] = $player;
                    } else {
                        $clubPlayers[$player->club_id]['cb'][] = $player;
                    }
                } elseif ($player->position == 'DMF') {
                    if ($defensiveMidfields == 'Yes') {
                        $player->position = 'DM';
                        $clubPlayers[$player->club_id]['dm'][] = $player;
                    } else {
                        $player->position = 'MF';
                        $clubPlayers[$player->club_id]['mf'][] = $player;
                    }
                } elseif ($player->position == 'MF') {
                    $clubPlayers[$player->club_id]['mf'][] = $player;
                } elseif ($player->position == 'ST') {
                    $clubPlayers[$player->club_id]['st'][] = $player;
                }
            } elseif ($player->lineup_position == 'SU') {
                // $clubPlayers[$player->club_id]['su'][] = $player;
                if ($player->position == 'GK') {
                    $clubPlayers[$player->club_id]['sub']['gk'][] = $player;
                } elseif ($player->position == 'FB') {
                    if ($mergeDefenders == 'Yes') {
                        $player->position = 'DF';
                        $clubPlayers[$player->club_id]['sub']['df'][] = $player;
                    } else {
                        $clubPlayers[$player->club_id]['sub']['fb'][] = $player;
                    }
                } elseif ($player->position == 'CB') {
                    if ($mergeDefenders == 'Yes') {
                        $player->position = 'DF';
                        $clubPlayers[$player->club_id]['sub']['df'][] = $player;
                    } else {
                        $clubPlayers[$player->club_id]['sub']['cb'][] = $player;
                    }
                } elseif ($player->position == 'DMF') {
                    if ($defensiveMidfields == 'Yes') {
                        $player->position = 'DM';
                        $clubPlayers[$player->club_id]['sub']['dm'][] = $player;
                    } else {
                        $player->position = 'MF';
                        $clubPlayers[$player->club_id]['sub']['mf'][] = $player;
                    }
                } elseif ($player->position == 'MF') {
                    $clubPlayers[$player->club_id]['sub']['mf'][] = $player;
                } elseif ($player->position == 'ST') {
                    $clubPlayers[$player->club_id]['sub']['st'][] = $player;
                }
            }
        }

        return [
            'clubPlayers' => $clubPlayers,
            'isYRCardIncluded' => $isYRCardIncluded,
            'isCustomisedScoring' => $isCustomisedScoring,
            'columns' => $columns,
            'minsMatchPlayed' => $minsMatchPlayed,
        ];
    }
}
