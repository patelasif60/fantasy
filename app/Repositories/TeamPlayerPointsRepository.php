<?php

namespace App\Repositories;

use App\Enums\EventsEnum;
use App\Enums\TeamPointsPositionEnum;
use App\Models\DivisionTeam;
use App\Models\Season;
use App\Models\TeamPlayerPoint;
use App\Models\TeamPlayerPointDefault;
use App\Models\TeamPoint;
use App\Models\TeamPointDefault;

class TeamPlayerPointsRepository
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
    const NO_VALUE = 0;

    public function recalculate($team_id, $player_id, $statsDetails, $is_active = 0)
    {
        $recalculate = self::NO_VALUE;
        foreach ($statsDetails as $stats) {
            $teamPoint = $playerPoint = self::NO_VALUE;
            $fields = $this->calculate($stats, $team_id, $player_id);
            if (! empty($fields)) {
                $teamPoint = $this->updateTeamPoints($fields, $team_id, $stats->updated_at, $stats->fixture_id, $player_id, $is_active);
                if ($teamPoint && $teamPoint != 'stop') {
                    $playerPoint = $this->updatePlayerPoints($fields, $player_id, $team_id, is_object($teamPoint) ? $teamPoint->id : $teamPoint);
                }
            }
            $recalculate += ($teamPoint || $playerPoint);
        }

        return $recalculate;
    }

    public function calculate($stats, $team_id, $player_id)
    {
        $playerPosition = $stats->player->currentPlayerPosition;

        if (! $playerPosition) {
            $playerPosition = $stats->player->playerContract->position;
        } else {
            $playerPosition = $playerPosition->position;
        }

        $isEventPosition = TeamPointsPositionEnum::hasValue($playerPosition);

        if ($isEventPosition) {
            $fields = [];
            $total = self::NO_VALUE;

            //Goal Points
            if ($stats->goal > self::NO_VALUE) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::GOAL);
                if ($points != self::NO_VALUE) {
                    $fields['goal'] = $stats->goal;
                    $total += (int) ($stats->goal * $points);
                }
            } else {
                $fields['goal'] = 0;
            }

            //Assist Points
            if ($stats->assist > self::NO_VALUE) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::ASSIST);
                if ($points != self::NO_VALUE) {
                    $fields['assist'] = $stats->assist;
                    $total += (int) ($stats->assist * $points);
                }
            } else {
                $fields['assist'] = 0;
            }

            //Goal Conceded Points
            if ($stats->goal_conceded > self::NO_VALUE) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::GOAL_CONCEDED);
                if ($points != self::NO_VALUE) {
                    $fields['conceded'] = $stats->goal_conceded;
                    $total += (int) ($stats->goal_conceded * $points);
                }
            } else {
                $fields['conceded'] = 0;
            }

            //Clean Sheet Points
            if ($stats->appearance >= self::CLEAN_SHEET_TIME && $stats->goal_conceded == self::NO_VALUE && $stats->clean_sheet != self::NO_VALUE) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::CLEAN_SHEET);
                if ($points != self::NO_VALUE) {
                    $fields['clean_sheet'] = self::EVENT_POINTS;
                    $total += $points;
                }
            }

            //Appearance Points
            if ($stats->appearance >= self::APPEARANCE_TIME) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::APPEARANCE);
                if ($points != self::NO_VALUE) {
                    $fields['appearance'] = self::EVENT_POINTS;
                    $total += $points;
                }

                //Club Win Points
                if ($stats->club_win != self::NO_VALUE) {
                    $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::CLUB_WIN);
                    if ($points != self::NO_VALUE) {
                        $fields['club_win'] = $stats->club_win;
                        $total += (int) ($fields['club_win'] * $points);
                    }
                }
            } else {
                $fields['appearance'] = 0;
            }

            //Red Card Points for two yellow cards case
            if ($stats->yellow_card == self::YELLOW_CARD_LIMIT) {
                //First Yellow Card Points deducted
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::YELLOW_CARD);
                if ($points != self::NO_VALUE) {
                    $total += (int) ($stats->yellow_card * $points);
                }

                //Single Red Card Points deducted
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::RED_CARD);
                if ($points != self::NO_VALUE) {
                    $fields['red_card'] = self::EVENT_POINTS;
                    $total += (int) ($stats->red_card * $points);
                }
            }

            if ($stats->red_card > self::NO_VALUE) {
                //Single Red Card Points deducted
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::RED_CARD);
                if ($points != self::NO_VALUE) {
                    $fields['red_card'] = $stats->red_card;
                    $total += (int) ($stats->red_card * $points);
                }
            } else {
                $fields['red_card'] = 0;
            }

            //Yellow Card Points
            if ($stats->yellow_card == 1) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::YELLOW_CARD);
                if ($points != self::NO_VALUE) {
                    $fields['yellow_card'] = self::EVENT_POINTS;
                    $total += (int) ($stats->yellow_card * $points);
                }
            }

            //Own Goal Points
            if ($stats->own_goal > self::NO_VALUE) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::OWN_GOAL);
                if ($points != self::NO_VALUE) {
                    $fields['own_goal'] = $stats->own_goal;
                    $total += (int) ($stats->own_goal * $points);
                }
            } else {
                $fields['own_goal'] = 0;
            }

            //Penalty Missed Points
            if ($stats->penalty_missed > self::NO_VALUE) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::PENALTY_MISSED);
                if ($points != self::NO_VALUE) {
                    $fields['penalty_missed'] = $stats->penalty_missed;

                    $total += (int) ($stats->penalty_missed * $points);
                }
            } else {
                $fields['penalty_missed'] = 0;
            }

            //Penalty Saved Points
            if ($stats->penalty_save > self::NO_VALUE) {
                $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::PENALTY_SAVE);
                if ($points != self::NO_VALUE) {
                    $fields['penalty_saved'] = $stats->penalty_save;
                    $total += (int) ($stats->penalty_save * $points);
                }
            } else {
                $fields['penalty_saved'] = 0;
            }

            //Goalkeeper Save Points
            if ($stats->goalkeeper_save > self::NO_VALUE) {
                $gkSave = $stats->penalty_save + $stats->goalkeeper_save;

                if ($gkSave >= self::GOAL_KEEPER_SAVE) {
                    $points = $this->getDivisionPointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::GOALKEEPER_SAVE_X5);
                    if ($points != self::NO_VALUE) {
                        $fields['goalkeeper_save'] = (int) ($gkSave / self::GOAL_KEEPER_SAVE);
                        $total += (int) ($fields['goalkeeper_save'] * $points);
                    }
                }
            } else {
                $fields['goalkeeper_save'] = 0;
            }

            if ($stats->yellow_card <= self::NO_VALUE) {
                $fields['yellow_card'] = 0;
            }

            $fields['total'] = $total;

            return $fields;
        } else {
            return false;
        }
    }

    public function updatePlayerPoints($fields, $player_id, $team_id, $team_point_id = null)
    {
        $playerPoint = self::NO_VALUE;
        $createPlayers = [];
        $newPlayer = false;

        //For Player points
        $playerQuery = TeamPlayerPoint::select('id')->where(
            [
                'player_id'     => $player_id,
                'team_id'       => $team_id,
                'team_point_id' => $team_point_id,
            ]
        );

        if ($playerQuery->count() == self::NO_VALUE) {
            $newPlayer = true;
            $createPlayers = [
                'team_id'       => $team_id,
                'player_id'     => $player_id,
                'team_point_id' => $team_point_id,
            ];
        }

        foreach ($fields as $key => $field) {
            if ($playerQuery->count() > self::NO_VALUE) {
                $playerQuery->increment($key, $field);
            } else {
                $createPlayers[$key] = $field;
            }
        }
        if (! $playerPoint && $newPlayer) {
            $playerPoint = TeamPlayerPoint::create($createPlayers);
        }

        return $playerPoint;
    }

    public function updateTeamPoints($fields, $team_id, $updated_at, $fixture_id, $player_id, $is_active)
    {
        $teamPoint = self::NO_VALUE;
        $createTeams = [];
        $newTeam = false;

        //For Team points
        $teamQuery = TeamPoint::where(['team_id' => $team_id, 'fixture_id' => $fixture_id])->with('playerPoints');

        if ($teamQuery->count() == self::NO_VALUE) {
            $newTeam = true;
            $createTeams = [
                'team_id'    => $team_id,
                'fixture_id' => $fixture_id,
            ];
        } else {

            $playerPoints = TeamPlayerPoint::where([
                'player_id' => $player_id,
                'team_point_id' => $teamQuery->first()->id,
                'team_id' => $team_id,
            ]);

            if ($playerPoints->count() > self::NO_VALUE) {
                //Revert point
                if($is_active == 0) {
                    
                    $object = $teamQuery->first();
                    $object->goal = $object->goal - $playerPoints->first()->goal;
                    $object->assist = $object->assist - $playerPoints->first()->assist;
                    $object->clean_sheet = $object->clean_sheet - $playerPoints->first()->clean_sheet;
                    $object->conceded = $object->conceded - $playerPoints->first()->conceded;
                    $object->appearance = $object->appearance - $playerPoints->first()->appearance;
                    $object->own_goal = $object->own_goal - $playerPoints->first()->own_goal;
                    $object->red_card = $object->red_card - $playerPoints->first()->red_card;
                    $object->yellow_card = $object->yellow_card - $playerPoints->first()->yellow_card;
                    $object->penalty_missed = $object->penalty_missed - $playerPoints->first()->penalty_missed;
                    $object->penalty_saved = $object->penalty_saved - $playerPoints->first()->penalty_saved;
                    $object->goalkeeper_save = $object->goalkeeper_save - $playerPoints->first()->goalkeeper_save;
                    $object->club_win = $object->club_win - $playerPoints->first()->club_win;
                    $object->total = $object->total - $playerPoints->first()->total;
                    $object->save();

                    $playerPoints->first()->delete();
                }

                return 'stop';
            }
        }

        foreach ($fields as $key => $field) {
            if ($teamQuery->count() > self::NO_VALUE) {
                $teamQuery->increment($key, $field);
                $teamPoint = $teamQuery->first()->id;
            } else {
                $createTeams[$key] = $field;
            }
        }

        if (! $teamPoint && $newTeam) {
            $teamPoint = TeamPoint::create($createTeams);
        }

        return $teamPoint;
    }

    public function getDivisionPointsByTeam($team_id, $column, $event)
    {
        $divisionTeam = DivisionTeam::where('team_id', $team_id)->where('season_id', Season::getLatestSeason())
            ->first();

        if (empty($divisionTeam)) {
            return false;
        }

        if ($column == self::DEFENSIVE_MID_FIELDER) {
            $column = ($divisionTeam->division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
        }

        if ($column == self::CENTRE_BACK) {
            $column = ($divisionTeam->division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
        }

        return $divisionTeam->division->getOptionValue($column, $event);
    }

    public function updateLivePoints($fixtureStat, $team_id)
    {
        $fields = $this->calculate($fixtureStat, $team_id, $fixtureStat->player_id);
        $teamPoint = TeamPoint::firstOrNew([
            'team_id'    => $team_id,
            'fixture_id' => $fixtureStat->fixture_id,
        ]);
        $teamPlayerPoint = TeamPlayerPoint::firstOrNew([
            'team_id'        => $team_id,
            'player_id'      => $fixtureStat->player_id,
            'team_point_id'  => $teamPoint->id,
        ]);

        foreach ($fields as $key => $field) {
            if ($teamPlayerPoint->$key != $field) {
                $value = ($field - $teamPlayerPoint->$key);
                $teamPoint->$key = $teamPoint->$key + $value;
            }
            $teamPlayerPoint->$key = $field;
        }

        $saveTeam = $teamPoint->save();
        $teamPlayerPoint->team_point_id = $teamPoint->id;
        $savePlayer = $teamPlayerPoint->save();

        return $saveTeam || $savePlayer;
    }

    public function updateStatsPoints($fixtureStat, $team_id)
    {
        $fields = $this->calculate($fixtureStat, $team_id, $fixtureStat->player_id);
        $teamPoint = TeamPoint:: where([
            'team_id'    => $team_id,
            'fixture_id' => $fixtureStat->fixture_id,
        ])->first();

        if ($teamPoint) {
            $teamPlayerPoint = TeamPlayerPoint::where([
                'team_id'        => $team_id,
                'player_id'      => $fixtureStat->player_id,
                'team_point_id'  => $teamPoint->id,
            ])->first();
            if ($teamPlayerPoint) {
                foreach ($fields as $key => $field) {
                    if ($teamPlayerPoint->$key != $field) {
                        $value = ($field - $teamPlayerPoint->$key);
                        $teamPoint->$key = $teamPoint->$key + $value;
                    }
                    $teamPlayerPoint->$key = $field;
                }

                $saveTeam = $teamPoint->save();
                $teamPlayerPoint->team_point_id = $teamPoint->id;
                $savePlayer = $teamPlayerPoint->save();
            }
        }

        return @$saveTeam || @$savePlayer;
    }

    public function updateStatsRankingPoints($fixtureStat, $team_id)
    {
        $fields = $this->calculateRanking($fixtureStat, $team_id, $fixtureStat->player_id);
        $teamPointDefault = TeamPointDefault::where([
            'team_id'    => $team_id,
            'fixture_id' => $fixtureStat->fixture_id,
        ])->first();

        if ($teamPointDefault) {
            $teamPlayerPointDefault = TeamPlayerPointDefault::where([
                'team_id'        => $team_id,
                'player_id'      => $fixtureStat->player_id,
                'team_point_default_id'  => $teamPointDefault->id,
            ])->first();

            if ($teamPlayerPointDefault) {
                foreach ($fields as $key => $field) {
                    if ($teamPlayerPointDefault->$key != $field) {
                        $value = ($field - $teamPlayerPointDefault->$key);
                        $teamPointDefault->$key = $teamPointDefault->$key + $value;
                    }
                    $teamPlayerPointDefault->$key = $field;
                }

                $saveTeam = $teamPointDefault->save();
                $teamPlayerPointDefault->team_point_default_id = $teamPointDefault->id;
                $savePlayer = $teamPlayerPointDefault->save();
            }
        }

        return @$saveTeam || @$savePlayer;
    }

    public function updateRankingPoints($fixtureStat, $team_id)
    {
        $fields = $this->calculateRanking($fixtureStat, $team_id, $fixtureStat->player_id);
        $teamPointDefault = TeamPointDefault::firstOrNew([
            'team_id'    => $team_id,
            'fixture_id' => $fixtureStat->fixture_id,
        ]);
        $teamPlayerPointDefault = TeamPlayerPointDefault::firstOrNew([
            'team_id'        => $team_id,
            'player_id'      => $fixtureStat->player_id,
            'team_point_default_id'  => $teamPointDefault->id,
        ]);

        foreach ($fields as $key => $field) {
            if ($teamPlayerPointDefault->$key != $field) {
                $value = ($field - $teamPlayerPointDefault->$key);
                $teamPointDefault->$key = $teamPointDefault->$key + $value;
            }
            $teamPlayerPointDefault->$key = $field;
        }

        $saveTeam = $teamPointDefault->save();
        $teamPlayerPointDefault->team_point_default_id = $teamPointDefault->id;
        $savePlayer = $teamPlayerPointDefault->save();

        return $saveTeam || $savePlayer;
    }

    public function calculateRanking($stats, $team_id, $player_id)
    {
        $playerPosition = $stats->player->playerContract->position;
        $isEventPosition = TeamPointsPositionEnum::hasValue($playerPosition);

        if ($isEventPosition) {
            $fields = [];
            $total = self::NO_VALUE;

            //Goal Points
            if ($stats->goal > self::NO_VALUE) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::GOAL);
                if ($points != self::NO_VALUE) {
                    $fields['goal'] = $stats->goal;
                    $total += (int) ($stats->goal * $points);
                }
            }

            //Assist Points
            if ($stats->assist > self::NO_VALUE) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::ASSIST);
                if ($points != self::NO_VALUE) {
                    $fields['assist'] = $stats->assist;
                    $total += (int) ($stats->assist * $points);
                }
            }

            //Goal Conceded Points
            if ($stats->goal_conceded > self::NO_VALUE) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::GOAL_CONCEDED);
                if ($points != self::NO_VALUE) {
                    $fields['conceded'] = $stats->goal_conceded;
                    $total += (int) ($stats->goal_conceded * $points);
                }
            }

            //Clean Sheet Points
            if ($stats->appearance >= self::CLEAN_SHEET_TIME && $stats->goal_conceded == self::NO_VALUE && $stats->clean_sheet != self::NO_VALUE) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::CLEAN_SHEET);
                if ($points != self::NO_VALUE) {
                    $fields['clean_sheet'] = self::EVENT_POINTS;
                    $total += $points;
                }
            }

            //Appearance Points
            if ($stats->appearance >= self::APPEARANCE_TIME) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::APPEARANCE);
                if ($points != self::NO_VALUE) {
                    $fields['appearance'] = self::EVENT_POINTS;
                    $total += $points;
                }

                //Club Win Points
                if ($stats->club_win != self::NO_VALUE) {
                    $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::CLUB_WIN);
                    if ($points != self::NO_VALUE) {
                        $fields['club_win'] = $stats->club_win;
                        $total += (int) ($fields['club_win'] * $points);
                    }
                }
            }

            //Red Card Points for two yellow cards case
            if ($stats->yellow_card == self::YELLOW_CARD_LIMIT) {
                //First Yellow Card Points deducted
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::YELLOW_CARD);
                if ($points != self::NO_VALUE) {
                    $total += (int) ($stats->yellow_card * $points);
                }

                //Single Red Card Points deducted
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::RED_CARD);
                if ($points != self::NO_VALUE) {
                    $fields['red_card'] = self::EVENT_POINTS;
                    $total += (int) ($stats->red_card * $points);
                }
            }

            if ($stats->red_card > self::NO_VALUE) {
                //Single Red Card Points deducted
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::RED_CARD);
                if ($points != self::NO_VALUE) {
                    $fields['red_card'] = $stats->red_card;
                    $total += (int) ($stats->red_card * $points);
                }
            }

            //Yellow Card Points
            if ($stats->yellow_card == 1) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::YELLOW_CARD);
                if ($points != self::NO_VALUE) {
                    $fields['yellow_card'] = self::EVENT_POINTS;
                    $total += (int) ($stats->yellow_card * $points);
                }
            }

            //Own Goal Points
            if ($stats->own_goal > self::NO_VALUE) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::OWN_GOAL);
                if ($points != self::NO_VALUE) {
                    $fields['own_goal'] = $stats->own_goal;
                    $total += (int) ($stats->own_goal * $points);
                }
            }

            //Penalty Missed Points
            if ($stats->penalty_missed > self::NO_VALUE) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::PENALTY_MISSED);
                if ($points != self::NO_VALUE) {
                    $fields['penalty_missed'] = $stats->penalty_missed;

                    $total += (int) ($stats->penalty_missed * $points);
                }
            }

            //Penalty Saved Points
            if ($stats->penalty_save > self::NO_VALUE) {
                $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::PENALTY_SAVE);
                if ($points != self::NO_VALUE) {
                    $fields['penalty_saved'] = $stats->penalty_save;
                    $total += (int) ($stats->penalty_save * $points);
                }
            }

            //Goalkeeper Save Points
            if ($stats->goalkeeper_save > self::NO_VALUE) {
                $gkSave = $stats->penalty_save + $stats->goalkeeper_save;

                if ($gkSave >= self::GOAL_KEEPER_SAVE) {
                    $points = $this->getPackagePointsByTeam($team_id, strtolower(TeamPointsPositionEnum::getKey($playerPosition)), EventsEnum::GOALKEEPER_SAVE_X5);
                    if ($points != self::NO_VALUE) {
                        $fields['goalkeeper_save'] = (int) ($gkSave / self::GOAL_KEEPER_SAVE);
                        $total += (int) ($fields['goalkeeper_save'] * $points);
                    }
                }
            }

            $fields['total'] = $total;

            return $fields;
        } else {
            return false;
        }
    }

    public function getPackagePointsByTeam($team_id, $column, $event)
    {
        $divisionTeam = DivisionTeam::where('team_id', $team_id)->where('season_id', Season::getLatestSeason())
            ->first();

        if (empty($divisionTeam)) {
            return false;
        }

        if ($column == self::DEFENSIVE_MID_FIELDER) {
            $column = ($divisionTeam->division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
        }

        if ($column == self::CENTRE_BACK) {
            $column = ($divisionTeam->division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
        }

        return $divisionTeam->division->package->getOptionValue($column, $event);
    }
}
