<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\SupersubTeamPlayerContract;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Log;

class SuperSubsRepository
{
    protected $teamLineupRepository;

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

    /**
     * Create a new repository instance.
     *
     * @param TeamLineupRepository $teamLineupRepository
     */
    public function __construct(TeamLineupRepository $teamLineupRepository)
    {
        $this->teamLineupRepository = $teamLineupRepository;
    }

    public function getLineupData($teamId, $date, $test = false)
    {
        $returnArr = [];

        $activeClubPlayers = $this->teamLineupRepository->getPlayersForFixture($teamId, $date);
        $returnArr['activeClubPlayers'] = $activeClubPlayers;

        $supersubData = SupersubTeamPlayerContract::where('team_id', $teamId)
                    ->where('start_date', '<=', $date)
                    ->where('is_applied', false)
                    ->whereNull('supersub_team_player_contracts.end_date')
                    ->orderBy('start_date', 'desc')
                    ->first();

        $supersubDataCount = SupersubTeamPlayerContract::where('team_id', $teamId)
                    ->where('start_date', $date)
                    ->where('is_applied', false)
                    ->whereNull('supersub_team_player_contracts.end_date')
                    ->count();

        if (! isset($supersubData) && ! $test) {
            $returnArr['fixture_date_count'] = 0;
            $returnArr['saved_data'] = 0;
            $isSuperSubSet = false;
        } else {
            $returnArr['fixture_date_count'] = $supersubDataCount;
            $returnArr['saved_data'] = 1;
            $isSuperSubSet = true;
        }

        $team = Team::find($teamId);
        $division = $team->teamDivision->first();

        $teamPointIDs4Month = $this->teamLineupRepository->getTeamPointIDs4Month($team);

        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        if($isSuperSubSet) {
            $lineupPlayers = $this->getPlayers($team, 'active', true, $date);
            $subPlayers = $this->getPlayers($team, 'sub', true, $date);
        } else {
            $lineupPlayers = $this->teamLineupRepository->getPlayers($team, 'active', true);
            $subPlayers = $this->teamLineupRepository->getPlayers($team, 'sub', true);
        }

        $formation = '';
        $activePlayers = [];

        $gk = $fb = $cb = $dmf = $mf = $st = 0;

        foreach ($lineupPlayers as $key => $player) {
            $transfer_value = Transfer::where('player_in', $player['player_id'])
                                        ->where('team_id', $team->id)
                                        ->orderBy('transfers.transfer_date', 'desc')
                                        ->select('transfers.transfer_value')
                                        ->first();

            $nextFixture['PL'] = $this->teamLineupRepository->getNextFixtureData($division, $team, $player, 'in', 'Premier League', $date);
            $nextFixture['FA'] = $this->teamLineupRepository->getNextFixtureData($division, $team, $player, 'in', 'FA Cup',$date);

            $player->position = player_position_short($player->position);
            $player->is_processed = 0;
            $player->has_next_fixture = 0;

            $player->status = $player->player->playerStatus;
            $player->total = isset($player->total) ? (int) $player->total : 0;

            $player = $player->toArray();
            $player['next_fixture'] = $nextFixture;
            unset($player['player']);

            $player['transfer_value'] = $transfer_value->transfer_value;

            $player['month_total2'] = $this->teamLineupRepository->getPlayerPoints($teamPointIDs4Month, $player['player_id']);

            $player['week_total2_PL'] = isset($allPlayerPoints['current_week'][$player['player_id']]) ? $allPlayerPoints['current_week'][$player['player_id']]['total'] : 0;
            $player['week_total2_FA'] = isset($allPlayerPoints['current_week'][$player['player_id']]) ? $allPlayerPoints['current_week'][$player['player_id']]['total'] : 0;

            $player['current_week'] = isset($allPlayerPoints['current_week'][$player['player_id']]) ? $allPlayerPoints['current_week'][$player['player_id']] : 0;
            $player['week_total'] = isset($allPlayerPoints['week_total'][$player['player_id']]) ? $allPlayerPoints['week_total'][$player['player_id']] : 0;
            $player['facup_prev'] = isset($allPlayerPoints['facup_prev'][$player['player_id']]) ? $allPlayerPoints['facup_prev'][$player['player_id']] : 0;
            $player['facup_total'] = isset($allPlayerPoints['facup_total'][$player['player_id']]) ? $allPlayerPoints['facup_total'][$player['player_id']] : 0;

            $position = $player['position'];

            $player['tshirt'] = player_tshirt($player['short_code'], $position);

            if ($position == 'GK') {
                $activePlayers['gk'][] = $player;
                $gk++;
            } elseif ($position == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    $player['position'] = 'DF';
                    $activePlayers['df'][] = $player;
                } else {
                    $activePlayers['fb'][] = $player;
                }
                $fb++;
            } elseif ($position == 'CB') {
                if ($mergeDefenders == 'Yes') {
                    $player['position'] = 'DF';
                    $activePlayers['df'][] = $player;
                } else {
                    $activePlayers['cb'][] = $player;
                }
                $cb++;
            } elseif ($position == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    $player['curr_position'] = 'DM';
                    $player['position'] = 'DM';
                    $activePlayers['dm'][] = $player;
                } else {
                    $player['curr_position'] = 'MF';
                    $player['position'] = 'MF';
                    $activePlayers['mf'][] = $player;
                }
                $dmf++;
            } elseif ($position == 'MF') {
                $player['curr_position'] = 'MF';
                $activePlayers['mf'][] = $player;
                $mf++;
            } elseif ($position == 'ST') {
                $activePlayers['st'][] = $player;
                $st++;
            }
        }

        $formation = ($fb + $cb).'-'.($dmf + $mf).'-'.$st;

        if ($formation == '4-4-2') {
            $activePlayers = $this->teamLineupRepository->get442FormationData($activePlayers);
        } elseif ($formation == '4-5-1') {
            $activePlayers = $this->teamLineupRepository->get451FormationData($activePlayers);
        } elseif ($formation == '4-3-3') {
            $activePlayers = $this->teamLineupRepository->get433FormationData($activePlayers);
        } elseif ($formation == '5-3-2') {
            $activePlayers = $this->teamLineupRepository->get532FormationData($activePlayers);
        } elseif ($formation == '5-4-1') {
            $activePlayers = $this->teamLineupRepository->get541FormationData($activePlayers);
        }

        $teamArray = [];
        $teamArray['gk'] = @$activePlayers['gk'];
        if (isset($activePlayers['df'])) {
            $teamArray['df'] = @$activePlayers['df'];
        } else {
            if (isset($activePlayers['fb'][0])) {
                $teamArray['df'][] = @$activePlayers['fb'][0];
            }
            if (isset($activePlayers['cb'])) {
                foreach ($activePlayers['cb'] as $cb) {
                    $teamArray['df'][] = $cb;
                }
            }
            if (isset($activePlayers['fb'][1])) {
                $teamArray['df'][] = @$activePlayers['fb'][1];
            }
        }
        $teamArray['mf'] = @$activePlayers['mf'];
        $teamArray['st'] = @$activePlayers['st'];

        foreach ($subPlayers as $key => $player) {
            $transfer_value = Transfer::where('player_in', $player->player->id)
                                        ->where('team_id', $team->id)
                                        ->orderBy('transfers.transfer_date', 'desc')
                                        ->select('transfers.transfer_value')
                                        ->first();

            $player->position = player_position_short($player->position);
            $player->is_processed = 0;
            $player->has_next_fixture = 0;
            // $nextFixture = $this->teamLineupRepository->getNextFixtureData($division, $player);

            $player->player_last_name_lower = strtolower($player->player_last_name);

            $nextFixture['PL'] = $this->teamLineupRepository->getNextFixtureData($division, $team, $player, 'out', 'Premier League', $date);
            $nextFixture['FA'] = $this->teamLineupRepository->getNextFixtureData($division, $team, $player, 'out', 'FA Cup', $date);

            $player->status = $player->player->playerStatus;
            $player->total = isset($player->total) ? (int) $player->total : 0;

            $player->transfer_value = $transfer_value->transfer_value;

            if ($player->status !== null) {
                $player->status->image = config('fantasy.aws_url').'/status/'.strtolower(implode('', explode(' ', $player->status->status))).'.svg';
            }

            $player['month_total2'] = $this->teamLineupRepository->getPlayerPoints($teamPointIDs4Month, $player->player->id);

            $player->current_week = isset($allPlayerPoints['current_week'][$player->player->id]) ? $allPlayerPoints['current_week'][$player->player->id] : 0;
            $player->week_total = isset($allPlayerPoints['week_total'][$player->player->id]) ? $allPlayerPoints['week_total'][$player->player->id] : 0;
            $player->facup_prev = isset($allPlayerPoints['facup_prev'][$player->player->id]) ? $allPlayerPoints['facup_prev'][$player->player->id] : 0;
            $player->facup_total = isset($allPlayerPoints['facup_total'][$player->player->id]) ? $allPlayerPoints['facup_total'][$player->player->id] : 0;

            $player->next_fixture = $nextFixture;

            unset($player->player);
            $player['tshirt'] = player_tshirt($player['short_code'], $player->position);

            $position = $player->position;
            if ($position == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    $subPlayers[$key]->position = 'DF';
                }
            } elseif ($position == 'CB') {
                if ($mergeDefenders == 'Yes') {
                    $subPlayers[$key]->position = 'DF';
                }
            } elseif ($position == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    $subPlayers[$key]->position = 'DM';
                } else {
                    $subPlayers[$key]->position = 'MF';
                }
            }
        }

        $returnArr['activePlayers'] = $teamArray;
        $returnArr['subPlayers'] = $subPlayers;

        return $returnArr;
    }

    /*public function getPlayers($team, $playerType, $forPDF, $date)
    {
        $recentFixtureDate = SupersubTeamPlayerContract::where('supersub_team_player_contracts.start_date', '<=', $date)
                ->where('supersub_team_player_contracts.team_id', $team->id)
                ->where('is_applied', false)
                ->max('start_date');

        $query = SupersubTeamPlayerContract::join('teams', 'teams.id', '=', 'supersub_team_player_contracts.team_id')

            ->join('players', 'players.id', '=', 'supersub_team_player_contracts.player_id')
            ->join('player_contracts', 'players.id', '=', 'player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('team_player_points', function ($join) {
                $join->on('players.id', '=', 'team_player_points.player_id');
                $join->on('teams.id', '=', 'team_player_points.team_id');
            })

            ->selectRaw('count(team_player_points.player_id) as pld, supersub_team_player_contracts.team_id,supersub_team_player_contracts.player_id,player_contracts.position,players.first_name as player_first_name,players.last_name as player_last_name,users.first_name as user_first_name,users.last_name as user_last_name,player_contracts.club_id as club_id,clubs.name as club_name,clubs.short_code,teams.name as team_name,sum(team_player_points.total) total')

            ->whereNull('supersub_team_player_contracts.end_date')
            ->whereNull('player_contracts.end_date')
            ->where('supersub_team_player_contracts.team_id', $team->id)
            ->where('supersub_team_player_contracts.start_date', $recentFixtureDate)
            ->where('supersub_team_player_contracts.is_applied', false)
            // ->orderBy('supersub_team_player_contracts.start_date', "desc")
            ->orderBy('players.first_name')
            ->groupBy('supersub_team_player_contracts.team_id', 'supersub_team_player_contracts.player_id', 'player_contracts.position', 'players.first_name', 'players.last_name', 'users.first_name', 'users.last_name', 'player_contracts.club_id', 'clubs.name', 'clubs.short_code', 'teams.name');

        if ($playerType == 'active') {
            $result = $query->where('supersub_team_player_contracts.is_active', 1)->get();
        } else {
            $result = $query->where('supersub_team_player_contracts.is_active', 0)->get();
        }

        return $result;
    }*/

    public function getPlayers($team, $playerType, $forPDF, $date)
    {
        $recentFixtureDate = SupersubTeamPlayerContract::where('supersub_team_player_contracts.start_date', '<=', $date)
                ->where('supersub_team_player_contracts.team_id', $team->id)
                ->where('is_applied', false)
                ->max('start_date');

        $query = SupersubTeamPlayerContract::join('teams', 'teams.id', '=', 'supersub_team_player_contracts.team_id')

            ->join('players', 'players.id', '=', 'supersub_team_player_contracts.player_id')

            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) {
                $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))))'));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('team_player_points', function ($join) {
                $join->on('players.id', '=', 'team_player_points.player_id');
                $join->on('teams.id', '=', 'team_player_points.team_id');
            })

            ->selectRaw('count(team_player_points.player_id) as pld, supersub_team_player_contracts.team_id,supersub_team_player_contracts.player_id,player_contracts.position,players.first_name as player_first_name,players.last_name as player_last_name,users.first_name as user_first_name,users.last_name as user_last_name,player_contracts.club_id as club_id,clubs.name as club_name,clubs.short_code,teams.name as team_name,sum(team_player_points.total) total')

            ->whereNull('supersub_team_player_contracts.end_date')
            ->where('supersub_team_player_contracts.team_id', $team->id)
            ->where('supersub_team_player_contracts.start_date', $recentFixtureDate)
            ->where('supersub_team_player_contracts.is_applied', false)
            // ->orderBy('supersub_team_player_contracts.start_date', "desc")
            ->orderBy('players.first_name')
            ->groupBy('supersub_team_player_contracts.team_id', 'supersub_team_player_contracts.player_id', 'player_contracts.position', 'players.first_name', 'players.last_name', 'users.first_name', 'users.last_name', 'player_contracts.club_id', 'clubs.name', 'clubs.short_code', 'teams.name');

        if ($playerType == 'active') {
            $result = $query->where('supersub_team_player_contracts.is_active', 1)->get();
        } else {
            $result = $query->where('supersub_team_player_contracts.is_active', 0)->get();
        }

        return $result;
    }

    public function checkSuperSubData($team)
    {
        $supersubData = SupersubTeamPlayerContract::where('team_id', $team->id)
                                                ->where('is_applied', false)
                                                ->count();

        return $supersubData;
    }

    public function saveSuperSubData($data)
    {
        $team = Team::find($data['team_id']);

        if (isset($team)) {
            Log::info('setting is_applied = 1 from saveSuperSubData function');
            $updateOldRecordsStatus = SupersubTeamPlayerContract::where('team_id', $data['team_id'])
                                                ->where('start_date', $data['fixture_date'])
                                                ->update(['is_applied' => true]);

            $saveData = [];
            $gk = 0;
            $activePlayersArr = [];
            foreach ($data['active_players']['gk'] as $value) {
                $saveData[$value['player_id']] = [
                    'team_id' => $data['team_id'],
                    'player_id' => $value['player_id'],
                    'is_active' => 1,
                    'start_date' => $data['fixture_date'],
                    'end_date' => null,
                ];
                $activePlayersArr[] = $value['player_id'];
                $gk++;
            }

            $df = 0;
            foreach ($data['active_players']['df'] as $value) {
                $saveData[$value['player_id']] = [
                    'team_id' => $data['team_id'],
                    'player_id' => $value['player_id'],
                    'is_active' => 1,
                    'start_date' => $data['fixture_date'],
                    'end_date' => null,
                ];
                $activePlayersArr[] = $value['player_id'];
                $df++;
            }

            $mf = 0;
            foreach ($data['active_players']['mf'] as $value) {
                $saveData[$value['player_id']] = [
                    'team_id' => $data['team_id'],
                    'player_id' => $value['player_id'],
                    'is_active' => 1,
                    'start_date' => $data['fixture_date'],
                    'end_date' => null,
                ];
                $activePlayersArr[] = $value['player_id'];
                $mf++;
            }

            $st = 0;
            foreach ($data['active_players']['st'] as $value) {
                $saveData[$value['player_id']] = [
                    'team_id' => $data['team_id'],
                    'player_id' => $value['player_id'],
                    'is_active' => 1,
                    'start_date' => $data['fixture_date'],
                    'end_date' => null,
                ];
                $activePlayersArr[] = $value['player_id'];
                $st++;
            }

            $formation = $gk.$df.$mf.$st;
            $team = \App\Models\Team::find($data['team_id']);
            $division = $team->teamDivision->first();

            $availableFormations = $division->getOptionValue('available_formations');
            foreach ($availableFormations as $key => $value) {
                $availableFormations[$key] = '1'.$value;
            }

            Log::info('--Supersub start for team id '.$team->id.'--');
            Log::info('Team formation : '.print_r($formation, true));
            Log::info('Available Formations for team : '.print_r($availableFormations, true));
            Log::info('Is Formations Valid : '.in_array($formation, $availableFormations));

            if (in_array($formation, $availableFormations)) {
                foreach ($data['sub_players'] as $value) {
                    $saveData[$value['player_id']] = [
                        'team_id' => $data['team_id'],
                        'player_id' => $value['player_id'],
                        'is_active' => 0,
                        'start_date' => $data['fixture_date'],
                        'end_date' => null,
                    ];
                }

                $squad = count($saveData);

                if ($division->getOptionValue('default_squad_size') != $squad) {
                    return ['status' => 'error', 'message' => 'Formation is not valid'];
                }

                $isSquadBrowserCheck = $this->multipleOpenTabIssue($team, $data);
                if (! $isSquadBrowserCheck) {
                    return ['status' => 'error', 'message' => 'NOT DONE - Please refresh for current line-ups'];
                }

                Log::info('Total Squad : '.print_r($squad, true));

                foreach ($saveData as $key => $value) {
                    // $response = SupersubTeamPlayerContract::where($value)->update(['is_applied' => true]);
                    Log::info('Creating Supersub Manually : '.print_r($value, true));

                    $result = SupersubTeamPlayerContract::create($value);
                }

                $superSubFixtureDates = $this->teamLineupRepository->getTeamSuperSubFixtureDates($team);

                return ['status' => 'success', 'message' => 'Saved', 'superSubFixtureDates' => $superSubFixtureDates];
            } else {
                return ['status' => 'error', 'message' => 'Formation is not valid'];
            }
        }

        return ['status' => 'error', 'message' => 'Not Done'];
    }

    public function multipleOpenTabIssue($team, $data)
    {
        //Multiple Tab open in browser issue.
        $vSubPlayers = isset($data['sub_players']) ? collect($data['sub_players'])->pluck('player_id') : collect();
        $vActivePlayers = collect($data['active_players'])->flatten(1)->pluck('player_id');
        $vAllPlayers = $vActivePlayers->merge($vSubPlayers);
        $vContractsAll = TeamPlayerContract::where('team_id', $team->id)->whereNull('end_date')->get()->pluck('player_id');

        $isSquadBrowserCheck = false;
        if ($vContractsAll->count() === $vAllPlayers->count()) {
            $isSquadBrowserCheck = true;
            $diff = $vContractsAll->diff($vAllPlayers);
            $isSquadBrowserCheck = $diff->count() === 0 ? true : false;
        }

        return $isSquadBrowserCheck;
    }

    public function deleteSuperSubData($data)
    {
        $team = Team::find($data['team_id']);

        if (isset($team)) {
            Log::info('setting is_applied = 1 from deleteSuperSubData function');
            $updateOldRecordsStatus = SupersubTeamPlayerContract::where('team_id', $data['team_id'])
                                                ->where('start_date', $data['fixture_date'])
                                                ->update(['is_applied' => true]);

            $superSubFixtureDates = $this->teamLineupRepository->getTeamSuperSubFixtureDates($team);

            return ['status' => 'success', 'message' => 'Saved', 'superSubFixtureDates' => $superSubFixtureDates];
        }

        return ['status' => 'error', 'message' => 'Not Done'];
    }

    public function deleteAllSuperSubData($data)
    {
        $team = Team::find($data['team_id']);

        if (isset($team)) {
            Log::info('setting is_applied = 1 from deleteAllSuperSubData function');
            $updateOldRecordsStatus = SupersubTeamPlayerContract::where('team_id', $data['team_id'])
                                                ->update(['is_applied' => true]);

            return ['status' => 'success', 'message' => 'Saved'];
        }

        return ['status' => 'error', 'message' => 'Not Done'];
    }

    public function getSupersubs($teamId, $date)
    {
        $superSubs = SupersubTeamPlayerContract::where('team_id', $teamId)
                    ->where('start_date', '<=', $date)
                    ->where('is_applied', false)
                    ->whereNull('supersub_team_player_contracts.end_date')
                    ->orderBy('start_date', 'desc')
                    ->first();

        return $superSubs;
    }
}
