<?php

namespace App\Repositories;

use DB;
use App\Models\Team;
use App\Models\Player;
use App\Models\Season;
use App\Models\Transfer;
use App\Models\GameWeek;
use Illuminate\Support\Arr;
use App\Models\PlayerContract;
use App\Models\SealedBidTransfer;
use App\Enums\CompetitionEnum;
use App\Models\TeamPlayerContract;
use App\Models\TeamPlayerPoint;
use App\Services\TransferRoundService;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class SealedBidTransferRepository
{
    public function getProcessBids($division, $team, $round)
    {
        $roundStartDate = $this->getContractStartDate($division);

        $transfers = SealedBidTransfer::join('division_teams', 'division_teams.team_id', '=', 'sealed_bid_transfers.team_id')
                    ->join('teams', 'teams.id', '=', 'division_teams.team_id')
                    ->join('transfer_rounds', 'transfer_rounds.id', '=', 'sealed_bid_transfers.transfer_rounds_id')
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->join('players as playersIn', 'playersIn.id', '=', 'sealed_bid_transfers.player_in')
                    ->join('player_contracts as latest_player_contracts_in', function ($join) use ($roundStartDate) {
                        $join->on('latest_player_contracts_in.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = playersIn.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) LIMIT 1)"));
                    })
                    ->join('player_contracts as player_contractsIn', 'player_contractsIn.id', '=', 'latest_player_contracts_in.id')
                    ->join('clubs as clubsIn', 'clubsIn.id', '=', 'player_contractsIn.club_id')
                    ->join('players as playersOut', 'playersOut.id', '=', 'sealed_bid_transfers.player_out')
                    ->join('player_contracts as latest_player_contracts_out', function ($join) use ($roundStartDate) {
                        $join->on('latest_player_contracts_out.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = playersOut.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) LIMIT 1)"));
                    })
                    ->join('player_contracts as player_contractsOut', 'player_contractsOut.id', '=', 'latest_player_contracts_out.id')
                    ->join('clubs as clubsOut', 'clubsOut.id', '=', 'player_contractsOut.club_id')
                    ->where('transfer_rounds.division_id', $division->id)
                    ->where('division_teams.season_id', Season::getLatestSeason())
                    ->where('sealed_bid_transfers.manually_process_status', 'completed')
                    ->whereNotNull('sealed_bid_transfers.status');

        if ($round) {
            $transfers = $transfers->where('sealed_bid_transfers.transfer_rounds_id', '!=', $round->id);
        }

        $transfers = $transfers->select(
                                'teams.id as teamId',
                                'teams.name as teamNm',
                                'users.first_name',
                                'users.last_name',
                                'playersIn.first_name as playersInFirstName',
                                'playersIn.last_name as playersInLastName',
                                'player_contractsIn.position as positionIn',
                                'clubsIn.short_code as shortCodeIn',
                                'playersOut.first_name as playersOutFirstName',
                                'playersOut.last_name as playersOutLastName',
                                'player_contractsOut.position as positionOut',
                                'clubsOut.short_code as shortCodeOut',
                                'sealed_bid_transfers.amount',
                                'sealed_bid_transfers.created_at',
                                'sealed_bid_transfers.transfer_rounds_id',
                                'sealed_bid_transfers.status',
                                'transfer_rounds.number as roundNumber',
                                'transfer_rounds.end as roundEndDate'
                            )
                            ->orderBy('sealed_bid_transfers.created_at', 'desc')
                            ->orderBy('roundNumber', 'desc')
                            ->get();

        return $transfers;
    }

    public function getPendingBids($division, $team, $user, $round)
    {
        $roundStartDate = $this->getContractStartDate($division);

        $isRoundProcessed = $this->isRoundProcessed($round);

        $transfers = SealedBidTransfer::join('division_teams', 'division_teams.team_id', '=', 'sealed_bid_transfers.team_id')
                    ->join('teams', 'teams.id', '=', 'division_teams.team_id')
                    ->join('transfer_rounds', 'transfer_rounds.id', '=', 'sealed_bid_transfers.transfer_rounds_id')
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->join('players as playersIn', 'playersIn.id', '=', 'sealed_bid_transfers.player_in')
                    ->join('player_contracts as latest_player_contracts_in', function ($join) use ($roundStartDate) {
                        $join->on('latest_player_contracts_in.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = playersIn.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')))"));
                    })
                    ->join('player_contracts as player_contractsIn', 'player_contractsIn.id', '=', 'latest_player_contracts_in.id')
                    ->join('clubs as clubsIn', 'clubsIn.id', '=', 'player_contractsIn.club_id')
                    ->join('players as playersOut', 'playersOut.id', '=', 'sealed_bid_transfers.player_out')
                    ->join('player_contracts as latest_player_contracts_out', function ($join) use ($roundStartDate) {
                        $join->on('latest_player_contracts_out.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = playersOut.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')))"));
                    })
                    ->join('player_contracts as player_contractsOut', 'player_contractsOut.id', '=', 'latest_player_contracts_out.id')
                    ->join('clubs as clubsOut', 'clubsOut.id', '=', 'player_contractsOut.club_id')
                    ->where('transfer_rounds.division_id', $division->id)
                    ->where('sealed_bid_transfers.transfer_rounds_id', $round->id)
                    ->where('division_teams.season_id', Season::getLatestSeason());

        if ($isRoundProcessed) {
            $transfers = $transfers->where(function ($query) {
                $query->whereNull('sealed_bid_transfers.status')
                            ->orWhere('sealed_bid_transfers.manually_process_status', 'processed')
                            ->orWhere('sealed_bid_transfers.manually_process_status', 'completed');
            });
        } else {
            $transfers = $transfers->where(function ($query) {
                $query->whereNull('sealed_bid_transfers.status')
                            ->orWhere('sealed_bid_transfers.is_process', false);
            })->where('teams.id', '=', $team->id);
        }

        $transfers = $transfers->select(
                                'teams.id as teamId',
                                'teams.name as teamNm',
                                'users.first_name',
                                'users.last_name',
                                'playersIn.first_name as playersInFirstName',
                                'playersIn.last_name as playersInLastName',
                                'player_contractsIn.position as positionIn',
                                'clubsIn.short_code as shortCodeIn',
                                'playersOut.first_name as playersOutFirstName',
                                'playersOut.last_name as playersOutLastName',
                                'player_contractsOut.position as positionOut',
                                'clubsOut.short_code as shortCodeOut',
                                'sealed_bid_transfers.amount',
                                'sealed_bid_transfers.created_at',
                                'sealed_bid_transfers.status',
                                'sealed_bid_transfers.manually_process_status',
                                'sealed_bid_transfers.is_process',
                                'sealed_bid_transfers.player_in',
                                'sealed_bid_transfers.id as sealBidId'
                            )
                            ->orderBy('teams.name')
                            ->get();

        return $transfers;
    }

    public function getPlayersStats($playerIds)
    {
        $players = Player::leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) {
            $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
            $join->whereIn('fixture_stats_for_stats.fixture_id',
                    function ($query) {
                        $query->select('id')
                        ->from('fixtures')
                        ->where('competition', CompetitionEnum::PREMIER_LEAGUE)
                        ->where('season_id', Season::getLatestSeason());
                    });
        })->leftJoin('fixtures', function ($join) {
            $join->on('fixtures.id', '=', 'fixture_stats_for_stats.fixture_id');
        })->select(
                    'players.id as playerId',
                    DB::raw('SUM(fixture_stats_for_stats.goal) as total_goal'),
                    DB::raw('SUM(fixture_stats_for_stats.assist) as total_assist'),
                    DB::raw('SUM(fixture_stats_for_stats.goal_conceded) as total_goal_against'),
                    DB::raw('SUM(fixture_stats_for_stats.clean_sheet) as total_clean_sheet'),
                    DB::raw('SUM(IF(fixture_stats_for_stats.appearance >= 45 , 1, 0)) as total_game_played'),
                    DB::raw('SUM(fixture_stats_for_stats.own_goal) as total_own_goal'),
                    DB::raw('SUM(fixture_stats_for_stats.red_card) as total_red_card'),
                    DB::raw('SUM(fixture_stats_for_stats.yellow_card) as total_yellow_card'),
                    DB::raw('SUM(fixture_stats_for_stats.penalty_missed) as total_penalty_missed'),
                    DB::raw('SUM(fixture_stats_for_stats.penalty_save) as total_penalty_saved'),
                    DB::raw('SUM(fixture_stats_for_stats.goalkeeper_save DIV 5) as total_goalkeeper_save'),
                    DB::raw('SUM(fixture_stats_for_stats.club_win) as total_club_win')
                )
                ->whereIn('players.id', $playerIds)
                ->groupBy('players.id')
                ->get();

        return $players;
    }

    public function getPlayers($division, $team, $data, $isMobile)
    {
        $roundStartDate = $this->getContractStartDate($division);

        $players = Player::join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) ORDER BY id desc LIMIT 1)"));
        })
                ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->leftJoin(DB::raw('(team_player_contracts as sold_team_player_contracts INNER JOIN teams ON teams.id = sold_team_player_contracts.team_id AND sold_team_player_contracts.end_date IS NULL INNER JOIN transfers ON  transfers.id = (SELECT id FROM transfers WHERE transfers.player_in = sold_team_player_contracts.player_id AND teams.id = transfers.team_id and transfers.transfer_type NOT IN ("substitution","supersub") ORDER BY transfers.transfer_date DESC LIMIT 1) INNER JOIN division_teams ON division_teams.team_id = teams.id AND division_teams.division_id = '.$division->id.')'),
                  function ($join) {
                      $join->on('sold_team_player_contracts.player_id', '=', 'players.id');
                  })
                ->leftJoin('teams as soldPlayerTeams', 'soldPlayerTeams.id', '=', 'sold_team_player_contracts.team_id')
                ->where('clubs.is_premier', true);

        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            if ($data['position'] == AllPositionEnum::DEFENDER) {
                $players = $players->where(function ($query) {
                    $query->orwhere('player_contracts.position', AllPositionEnum::CENTREBACK)
                                      ->orWhere('player_contracts.position', AllPositionEnum::FULLBACK);
                });
            } elseif ($data['position'] == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                $players = $players->where('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER);
            } elseif ($data['position'] == AllPositionEnum::MIDFIELDER) {
                if ($division->getOptionValue('defensive_midfields') != 'Yes') {
                    $players = $players->where(function ($query) {
                        $query->orwhere('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER)
                                      ->orWhere('player_contracts.position', AllPositionEnum::MIDFIELDER);
                    });
                } else {
                    $players = $players->where('player_contracts.position', AllPositionEnum::MIDFIELDER);
                }
            } else {
                $players = $players->where('player_contracts.position', $data['position']);
            }
        }

        if (Arr::has($data, 'name') && Arr::get($data, 'name')) {
            $players = $players->where(function ($query) use ($data) {
                $query->where('players.first_name', 'like', '%'.escape_like($data['name']).'%')
                                    ->orWhere('players.last_name', 'like', '%'.escape_like($data['name']).'%')
                                    ->orWhere('clubs.short_code', 'like', '%'.escape_like($data['name']).'%');
            });
        }

        if (Arr::has($data, 'club') && Arr::get($data, 'club')) {
            $players = $players->where('clubs.id', $data['club']);
        }

        if (Arr::has($data, 'bought_player') && Arr::get($data, 'bought_player') == 'no') {
            $players = $players->whereNull('sold_team_player_contracts.id');
        }

        $players = $players->select(
                    'players.id as playerId',
                    'players.first_name as playerFirstName',
                    'players.last_name as playerLastName',
                    'player_contracts.position as playerPosition',
                    'clubs.name as playerClubName',
                    'clubs.id as playerClubId',
                    'clubs.short_code as playerClubShortCode',
                    'soldPlayerTeams.id as soldPlayerTeamId',
                    'soldPlayerTeams.name as soldPlayerTeamName',
                    'transfers.transfer_value as soldPlayerTransferValue'
                )
                ->groupBy(
                            'players.id',
                            'players.first_name',
                            'players.last_name',
                            'player_contracts.position',
                            'clubs.name',
                            'clubs.id',
                            'clubs.short_code',
                            'soldPlayerTeams.id',
                            'soldPlayerTeams.name',
                            'transfers.transfer_value'
                        )
                ->orderBy('players.first_name');

        if ($isMobile) {
            $players = $players->paginate(config('fantasy.pagination'));
        } else {
            $players = $players->get();
        }

        return $players;
    }

    public function getPlayerDetails($division, $playerId)
    {
        $roundStartDate = $this->getContractStartDate($division);

        return Player::join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')))"));
        })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->selectRaw('
                players.id as player_id,
                players.first_name as player_first_name,
                players.last_name as player_last_name,
                clubs.short_code,
                player_contracts.position,
                clubs.name as club_name,
                clubs.id as club_id
            ')
            ->where('clubs.is_premier', true)
            ->where('players.id', $playerId)
            ->groupBy('player_id', 'player_first_name', 'player_last_name', 'clubs.short_code', 'player_contracts.position', 'club_name', 'club_id')
            ->first();
    }

    public function getPlayerContractIds($team)
    {
        return $team->teamPlayerContracts()->whereNull('end_date')->pluck('player_id');
    }

    public function getTeamPlayersPositionOnly($totalPlayers)
    {
        $roundStartDate = carbon_get_date_from_date_time(now());

        return player::join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')))"));
        })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->whereIn('players.id', $totalPlayers)
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
    }

    public function store($team, $round, $json_data)
    {
        $deleteIds = [];
        foreach ($json_data as $value) {
            if (Arr::has($value, 'id') && is_int(Arr::get($value, 'id'))) {
                $sb = SealedBidTransfer::find($value['id']);
                if($sb) {
                    $sb->amount = $value['newPlayerAmount'];
                    $sb->save();
                }
                array_push($deleteIds, $value['id']);
            } else {
                $insert = SealedBidTransfer::create([
                    'transfer_rounds_id' => $round->id,
                    'team_id' => $team->id,
                    'player_in' => $value['newPlayerId'],
                    'player_out' => $value['oldPlayerId'],
                    'amount' => $value['newPlayerAmount'],
                ]);

                array_push($deleteIds, $insert->id);
            }
        }

        $this->delete($team, $round, $deleteIds);

        return true;
    }

    public function delete($team, $round, $deleteIds)
    {
        return $team->onlineSealedBidsTransfer()
                ->where('transfer_rounds_id', $round->id)
                ->whereNotIn('id', $deleteIds)
                ->delete();
    }

    public function getSelectedPlayers($division, $team, $round)
    {
        $roundStartDate = $this->getContractStartDate($division);

        $selectedPlayers = SealedBidTransfer::join('players', 'players.id', '=', 'sealed_bid_transfers.player_in')
        ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) LIMIT 1)"));
        })
        ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
        ->join('player_contracts as latest_player_contracts_out', function ($join) use ($roundStartDate) {
            $join->on('latest_player_contracts_out.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = sealed_bid_transfers.player_out AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) LIMIT 1)"));
        })
        ->join('player_contracts as player_contracts_out', 'player_contracts_out.id', '=', 'latest_player_contracts_out.id')
        ->join('transfers', function ($join) {
            $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.player_in = sealed_bid_transfers.player_out AND sealed_bid_transfers.team_id = transfers.team_id and transfers.transfer_type NOT IN ("substitution","supersub") ORDER BY transfers.transfer_date DESC LIMIT 1)'));
        })
        ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
        ->join('clubs as clubs_out', 'clubs_out.id', '=', 'player_contracts_out.club_id')
        ->select(
            'sealed_bid_transfers.*',
            'players.first_name as player_first_name',
            'players.last_name as player_last_name',
            'player_contracts.player_id',
            'player_contracts.position',
            'clubs.short_code',
            'clubs.name as club_name',
            'clubs.id as club_id',
            'clubs_out.id as club_id_out',
            'transfers.transfer_value'
        )
        ->where('sealed_bid_transfers.transfer_rounds_id', $round->id)
        ->where('sealed_bid_transfers.team_id', $team->id)
        ->get();

        return $selectedPlayers;
    }

    public function getTeamPlayers($team)
    {
        $division = $team->teamDivision->first();
        $roundStartDate = $this->getContractStartDate($division);
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        $teams = Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE id = ( SELECT IF ((SELECT transfer_type FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in AND transfers.transfer_type NOT IN ('substitution','supersub') ORDER BY id DESC LIMIT 1) = 'auction' AND '".$auctionDate."' = DATE(transfers.transfer_date), (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (  player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."' ) ) ORDER BY id DESC LIMIT 1) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date) ) ) ORDER BY id DESC LIMIT 1 )) AS id ))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
             ->selectRaw('teams.id as team_id,players.id as player_id,teams.name as team_name,players.first_name as player_first_name,players.last_name as player_last_name,clubs.short_code,player_contracts.position,clubs.name as club_name,clubs.id as club_id,transfers.transfer_value')
            ->whereNull('team_player_contracts.end_date')
            ->where('clubs.is_premier', true)
            ->where('teams.id', $team->id)
            ->groupBy('teams.id', 'players.id', 'clubs.short_code', 'clubs.id', 'player_contracts.position', 'clubs.name', 'transfers.transfer_value')
            ->get();

        return $teams;
    }

    public function getPlayerTransferAmount($sealbid)
    {
        $amount = 0;

        if ($sealbid) {
            $transfer = Transfer::where('team_id', $sealbid->team_id)
                        ->where('player_in', $sealbid->player_out)
                        ->whereNotIn('transfer_type', ['substitution', 'supersub'])
                        ->orderBy('id', 'desc')
                        ->first();

            $amount = $transfer ? $transfer->transfer_value : 0;
        }

        return $amount;
    }

    public function playerWeekPoints($player_id)
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d');
        $gameweeks = GameWeek::where('start', '<=', $date)->where('season_id', Season::getLatestSeason());
        if ($gameweeks) {
            $gameweeks = $gameweeks->limit(1);
        }
        $gameweek = $gameweeks->orderBy('start', 'desc')->first();

        $playerStats = TeamPlayerPoint::join('team_points', 'team_points.id', '=', 'team_player_points.team_point_id')
                        ->join('fixtures', function ($query) use ($gameweek) {
                            $query->on('fixtures.id', '=', 'team_points.fixture_id')
                                ->whereBetween('fixtures.date_time', [$gameweek->start, $gameweek->end])
                                ->where('season_id', Season::getLatestSeason());
                        })
                        ->selectRaw('
                            team_player_points.player_id,
                            SUM(team_player_points.total) as total
                        ')
                        ->where('team_player_points.player_id', $player_id)
                        ->groupBy('team_player_points.player_id')
                        ->get();

        if (isset($playerStats[0])) {
            return $playerStats[0]->total;
        } else {
            return 0;
        }
    }

    public function getClubIdWithCount($teamId, $playerIds = null)
    {
        //$team = Team::find($teamId);
        //$division = $team->teamDivision->first();
        //$roundStartDate = $this->getContractStartDate($division);

        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->leftjoin('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) {
                $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))))'));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $teamId)
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(clubs.id) as total,clubs.id as club_id')
            ->groupBy('clubs.id')
            ->pluck('total', 'club_id');
    }

    public function getContractStartDate($division)
    {
        return carbon_get_date_from_date_time(now());

        // $date = $division->auction_date;
        // $transferRoundService = app(TransferRoundService::class);
        // $round = $transferRoundService->getActiveRound($division);
        // if ($round) {
        //     $date = $round->start;
        // }

        // return carbon_get_date_from_date_time($date);
    }

    public function getBidRoundData($division)
    {
        $roundStartDate = $this->getContractStartDate($division);

        $onlineSealedBids = SealedBidTransfer::join('transfer_rounds', 'transfer_rounds.id', '=', 'sealed_bid_transfers.transfer_rounds_id')
            ->join('divisions', 'divisions.id', '=', 'transfer_rounds.division_id')
            ->join('teams', 'teams.id', '=', 'sealed_bid_transfers.team_id')
            ->join('players', 'players.id', '=', 'online_sealed_bids.player_id')
            ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) LIMIT 1)"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->leftJoin('auction_tie_preferences', 'auction_tie_preferences.team_id', '=', 'teams.id')
            ->whereNull('online_sealed_bids.status')
            ->where('transfer_rounds.end', '<=', now())
            ->where('transfer_rounds.is_process', AuctionRoundProcessEnum::UNPROCESSED)
            ->where('teams.is_approved', true)
            ->where('divisions.id', $division->id)
            ->where('divisions.manual_bid', $manualBid)
            ->where('divisions.auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)
            ->select('online_sealed_bids.*', 'auction_tie_preferences.number', 'player_contracts.club_id')
            ->get();

        return $onlineSealedBids;
    }

    public function isRoundProcessed($round)
    {
        if ($round) {
            return SealedBidTransfer::where(function ($query) {
                $query->where('is_process', true)
                ->orWhereNotNull('status');
            })->where('transfer_rounds_id', $round->id)->count();
        }

        return false;
    }

    public function isPlayerExist($division, $playerId)
    {
        return TeamPlayerContract::whereIn('team_id', $division->divisionTeams->pluck('id'))
                ->where('player_id', $playerId)
                ->whereNull('end_date')
                ->first();
    }

    public function getTeamPlayerClubWithPlayerId($division, $team, $playerIds)
    {
        $roundStartDate = $this->getContractStartDate($division);

        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->leftjoin('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) {
                $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date)))Order By id desc limit 1)'));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereIn('team_player_contracts.player_id', $playerIds)
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(clubs.id) as total,clubs.id as club_id')
            ->groupBy('clubs.id')
            ->pluck('total', 'club_id');
    }

    public function getPlayerClubId($playerId)
    {
        return PlayerContract::where('player_id', $playerId)
        ->whereNull('end_date')
        ->where('is_active', true)
        ->first();
    }

    public function checkAnySucecessBidInAnyRound($division, $round)
    {
        $data = SealedBidTransfer::join('transfer_rounds', 'transfer_rounds.id', '=', 'sealed_bid_transfers.transfer_rounds_id')
        ->whereNotNull('sealed_bid_transfers.status')
        ->where('sealed_bid_transfers.is_process', true)
        ->where('transfer_rounds.division_id', $division->id);

        if ($round) {
            $data = $data->where('sealed_bid_transfers.transfer_rounds_id', '!=', $round->id);
        }

        return $data->count();
    }

    public function getUnProcessBids($round)
    {
        $sealedBidTransfers = SealedBidTransfer::where('transfer_rounds_id', $round->id)
        ->where('is_process', false)
        ->get();

        return $sealedBidTransfers;
    }

    public function getBidsForEarliestBids($round)
    {
        return SealedBidTransfer::where('transfer_rounds_id', $round->id)
                ->select('player_in', 'id', 'team_id', 'created_at')
                ->get();
    }
}
