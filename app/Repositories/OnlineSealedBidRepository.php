<?php

namespace App\Repositories;

use DB;
use App\Models\Team;
use App\Models\Season;
use App\Models\Player;
use App\Models\Fixture;
use App\Models\Transfer;
use App\Models\Division;
use App\Enums\YesNoEnum;
use Illuminate\Support\Arr;
use App\Models\AuctionRound;
use App\Enums\AuctionTypesEnum;
use App\Enums\CompetitionEnum;
use App\Enums\TransferTypeEnum;
use App\Models\OnlineSealedBid;
use App\Models\TeamPlayerContract;
use App\Enums\AuctionRoundProcessEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PlayerContractPosition\MergeDefenderDefensiveMidfielderEnum;

class OnlineSealedBidRepository
{
    public function create($division, $team, $round, $data)
    {
        $onlineSealedBid = OnlineSealedBid::create([
            'auction_rounds_id' => $round->id,
            'amount' => $data['amount'],
            'player_id' => $data['player_id'],
            'team_id' => $team->id,
        ]);

        return $onlineSealedBid;
    }

    public function update($onlineSealedBid, $data)
    {
        $onlineSealedBid->fill([
            'amount' => $data['amount'],
        ]);

        $onlineSealedBid->save();

        return $onlineSealedBid;
    }

    public function updateStatus($onlineSealedBid, $status)
    {
        $onlineSealedBid->fill([
            'status' => $status,
        ]);

        $onlineSealedBid->save();

        return $onlineSealedBid;
    }

    public function getRoundStartTeams($now)
    {
        $divisionTeams = Team::join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('auction_rounds', 'auction_rounds.division_id', '=', 'divisions.id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)
            ->whereRaw('HOUR(auction_rounds.start) = ? ', $now->format('H'))
            ->whereRaw('MINUTE(auction_rounds.start) = ?', $now->format('i'))
            ->whereRaw('DATE(auction_rounds.start) = ?', $now->format('Y-m-d'))
            ->where('teams.is_approved', true)
            ->select(
                'teams.name as teamNm',
                'divisions.name as divisionNm',
                'auction_rounds.start as start',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.push_registration_id'
            )
        ->get();

        return $divisionTeams;
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
                        ->where('season_id', Season::getPreviousSeason());
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

    public function getPlayers($division, $team, $data, $activeRound, $isMobile)
    {
        $activeRoundId = $activeRound ? $activeRound->id : 0;

        $roundStartDate = $this->getContractStartDate($division);

        $players = Player::join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) ORDER BY id desc LIMIT 1)"));
            })
                ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->leftJoin(DB::raw("(team_player_contracts as sold_team_player_contracts INNER JOIN teams ON teams.id = sold_team_player_contracts.team_id INNER JOIN transfers ON transfers.player_in = sold_team_player_contracts.player_id AND teams.id = transfers.team_id AND transfers.transfer_type = '".TransferTypeEnum::AUCTION."'  INNER JOIN division_teams ON division_teams.team_id = teams.id AND division_teams.division_id = ".$division->id.')'),
                  function ($join) {
                      $join->on('sold_team_player_contracts.player_id', '=', 'players.id');
                  })
                ->leftJoin('online_sealed_bids', function ($join) use ($activeRoundId,$team) {
                    $join->on('players.id', '=', 'online_sealed_bids.player_id');
                    $join->where('online_sealed_bids.team_id', $team->id);
                    $join->where('online_sealed_bids.auction_rounds_id', $activeRoundId);
                })
                ->leftJoin('teams as soldPlayerTeams', 'soldPlayerTeams.id', '=', 'sold_team_player_contracts.team_id')
                ->whereNotNull('players.short_code')
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
                    'online_sealed_bids.id as sealed_bid_id',
                    'online_sealed_bids.amount as sealed_bid_amount',
                    'online_sealed_bids.team_id as sealed_bid_team_id',
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
                            'online_sealed_bids.id',
                            'online_sealed_bids.amount',
                            'online_sealed_bids.team_id',
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

    public function getBids($division, $team, $round, $data)
    {
        $roundStartDate = $this->getContractStartDate($division);

        $dataTabs = OnlineSealedBid::join('teams', 'teams.id', '=', 'online_sealed_bids.team_id')
                ->join('auction_rounds', 'auction_rounds.id', '=', 'online_sealed_bids.auction_rounds_id')
                ->join('players', 'players.id', '=', 'online_sealed_bids.player_id')
                ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
                    $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) ORDER BY id desc LIMIT 1)"));
                })
                ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                ->join('users', 'users.id', '=', 'consumers.user_id')
                ->where('auction_rounds.division_id', $division->id);

        if (Arr::has($data, 'round') && Arr::get($data, 'round')) {
            $dataTabs = $dataTabs->where('auction_rounds.id', $data['round']);
        }

        if (auth()->user()->can('ownTeam', $team)) {
            $dataTabs = $dataTabs->where(function ($query) use ($team) {
                $query->whereNotNull('online_sealed_bids.status')
                        ->orWhere('teams.id', '=', $team->id);
            });
        } else {
            $dataTabs = $dataTabs->whereNotNull('online_sealed_bids.status');
        }

        if (Arr::has($data, 'team') && Arr::get($data, 'team')) {
            $dataTabs = $dataTabs->where('teams.id', $data['team']);
        }

        if (Arr::has($data, 'club') && Arr::get($data, 'club')) {
            $dataTabs = $dataTabs->where('clubs.id', $data['club']);
        }

        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            if ($data['position'] == MergeDefenderDefensiveMidfielderEnum::DEFENSIVE_MIDFIELDER) {
                $data['position'] = AllPositionEnum::DEFENSIVE_MIDFIELDER;
            }
            if ($data['position'] == AllPositionEnum::DEFENDER) {
                $dataTabs = $dataTabs->where(function ($query) {
                    $query->orwhere('player_contracts.position', AllPositionEnum::CENTREBACK)
                                      ->orWhere('player_contracts.position', AllPositionEnum::FULLBACK);
                });
            } elseif ($data['position'] == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                $dataTabs = $dataTabs->where('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER);
            } elseif ($data['position'] == AllPositionEnum::MIDFIELDER) {
                if ($division->getOptionValue('defensive_midfields') == 'Yes') {
                    $dataTabs = $dataTabs->where('player_contracts.position', AllPositionEnum::MIDFIELDER);
                } else {
                    $dataTabs = $dataTabs->where(function ($query) {
                        $query->orwhere('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER)
                                      ->orWhere('player_contracts.position', AllPositionEnum::MIDFIELDER);
                    });
                }
            } else {
                $dataTabs = $dataTabs->where('player_contracts.position', $data['position']);
            }
        }

        $dataTabs = $dataTabs->select(
                    'teams.name as TeamName',
                    'online_sealed_bids.amount as sealedBidAmount',
                    'online_sealed_bids.status as sealedBidStatus',
                    'players.first_name as playerFirstName',
                    'players.last_name as playerLastName',
                    'players.id as playerId',
                    'player_contracts.position as playerPosition',
                    'users.first_name as managerFirstName',
                    'users.last_name as managerLastName',
                    'clubs.name as playerClubName',
                    'clubs.id as playerClubId',
                    'auction_rounds.number as roundNumber'
                )
                ->orderByRaw('FIELD(teams.id,'.$team->id.') desc')
                ->orderBy('online_sealed_bids.id', 'asc')
                ->get();

        return $dataTabs;
    }

    public function checkUnProcessRoundCount($division, $endDate)
    {
        $round = AuctionRound::where('auction_rounds.is_process', AuctionRoundProcessEnum::UNPROCESSED)
                    ->where('auction_rounds.end', '>', $endDate)
                    ->where('auction_rounds.division_id', $division->id)
                    ->select('auction_rounds.*')
                    ->count();

        return $round;
    }

    public function getSealBidClubIdWithCount($teamId, $round)
    {
        $team = Team::find($teamId);
        $division = $team->teamDivision->first();
        $roundStartDate = $this->getContractStartDate($division);

        return OnlineSealedBid::join('players', 'players.id', '=', 'online_sealed_bids.player_id')
             ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
                 $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) ORDER BY id desc LIMIT 1)"));
             })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('online_sealed_bids.team_id', $team->id)
            ->where('online_sealed_bids.auction_rounds_id', $round->id)
            ->selectRaw('count(clubs.id) as total,clubs.id as club_id')
            ->groupBy('clubs.id')
            ->pluck('total', 'club_id');
    }

    public function getClubIdWithCount($teamId)
    {
        $team = Team::find($teamId);
        $division = $team->teamDivision->first();
        $roundStartDate = $this->getContractStartDate($division);

        return TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
             ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
                 $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) ORDER BY id desc LIMIT 1)"));
             })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(clubs.id) as total,clubs.id as club_id')
            ->groupBy('clubs.id')
            ->pluck('total', 'club_id');
    }

    public function getBidRoundData($division, $manualBid, $round)
    {
        if($round) {

            $roundStartDate = $this->getContractStartDate($division);

            $onlineSealedBids = OnlineSealedBid::join('auction_rounds', 'auction_rounds.id', '=', 'online_sealed_bids.auction_rounds_id')
                ->join('divisions', 'divisions.id', '=', 'auction_rounds.division_id')
                ->join('teams', 'teams.id', '=', 'online_sealed_bids.team_id')
                ->join('players', 'players.id', '=', 'online_sealed_bids.player_id')
                ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
                    $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."'))  ORDER BY id desc LIMIT 1)"));
                })
                ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
                ->leftJoin('auction_tie_preferences', 'auction_tie_preferences.team_id', '=', 'teams.id')
                ->whereNull('online_sealed_bids.status')
                ->where('auction_rounds.id', $round->id)
                ->where('auction_rounds.end', '<=', now())
                ->where('auction_rounds.is_process', AuctionRoundProcessEnum::UNPROCESSED)
                ->where('teams.is_approved', true)
                ->where('divisions.id', $division->id)
                ->where('divisions.manual_bid', $manualBid)
                ->where('divisions.auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)
                ->select('online_sealed_bids.*', 'auction_tie_preferences.number', 'player_contracts.club_id')
                ->get();

            return $onlineSealedBids;
        }

        return collect();
    }

    public function getActiveBidDivision()
    {
        $divisions = Division::join('auction_rounds', 'auction_rounds.division_id', '=', 'divisions.id')
            ->join('packages', 'packages.id', '=', 'divisions.package_id')
            ->where('packages.private_league', YesNoEnum::YES)
            ->where('auction_rounds.end', '<=', now())
            ->where('auction_rounds.is_process', AuctionRoundProcessEnum::UNPROCESSED)
            ->where('divisions.manual_bid', '!=', YesNoEnum::YES)
            ->where('divisions.auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)
            ->select('divisions.*')
            ->get();

        return $divisions;
    }

    public function getSealBidTeams($division)
    {
        $teams = Team::with('onlineSealedBids')
                ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                ->join('users', 'users.id', '=', 'consumers.user_id')
                ->leftJoin('auction_tie_preferences', 'auction_tie_preferences.team_id', '=', 'teams.id')
                ->whereIn('teams.id', $division->divisionTeams->pluck('id'))
                ->approve()
                ->select('teams.*', 'auction_tie_preferences.number as tieOrder', 'users.first_name', 'users.last_name')
                ->get();

        return $teams;
    }

    public function resetSealBid($division)
    {
        $division->auctionRounds()->delete();
        $auctionBudget = $division->getOptionValue('pre_season_auction_budget');

        foreach ($division->divisionTeams as $team) {
            $team->teamPlayerContracts()->delete();
            $team->transfer()->delete();
            $team->tiePreferences()->delete();

            $team->fill([
                'team_budget' => $auctionBudget,
            ]);

            $team->save();
        }

        $division->roundProcess(false);

        return true;
    }

    public function getSealedBidTeamPlayerPositions($team, $round)
    {
        if($round) {
            return OnlineSealedBid::where('online_sealed_bids.team_id', $team->id)
            ->where('online_sealed_bids.auction_rounds_id', $round->id)
            ->join('players', 'players.id', '=', 'online_sealed_bids.player_id')
            ->join('player_contracts', 'player_contracts.player_id', '=', 'online_sealed_bids.player_id')
            ->whereNull('status')
            ->whereNull('player_contracts.end_date')
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
        }

        return collect();
    }

    public function getTeamPlayersSealBid($team, $round)
    {
        $division = $team->teamDivision->first();
        $roundStartDate = $this->getContractStartDate($division);

        return Team::join('online_sealed_bids', 'online_sealed_bids.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'online_sealed_bids.player_id')
            ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) ORDER BY id desc LIMIT 1)"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->selectRaw(
                'online_sealed_bids.amount as transfer_value,
                online_sealed_bids.id as seal_bid_id,
                teams.id as team_id,
                players.id as player_id,
                teams.name as team_name,
                players.first_name as player_first_name,
                players.last_name as player_last_name,
                clubs.short_code,
                player_contracts.position,
                clubs.name as club_name,
                clubs.id as club_id'
            )
            ->where('teams.id', $team->id)
            ->where('clubs.is_premier', true)
            ->where('online_sealed_bids.auction_rounds_id', $round->id)
            ->groupBy('online_sealed_bids.amount', 'online_sealed_bids.id', 'teams.id', 'players.id', 'clubs.short_code', 'clubs.id', 'player_contracts.position', 'clubs.name')
            ->get();
    }

    public function createTeamPlayerContract($roundStartDate, $sealBid)
    {
        if($sealBid) {

            $team = Team::find($sealBid->team_id);

            $team->fill([
                'team_budget' => ($team->team_budget - $sealBid->amount),
            ]);

            $team->save();

            TeamPlayerContract::create([
                'team_id' => $sealBid->team_id,
                'player_id' => $sealBid->player_id,
                'is_active' => false,
                'start_date' => $roundStartDate,
                'end_date' =>  null,
            ]);

            return Transfer::create([
                'team_id' => $sealBid->team_id,
                'player_in' => $sealBid->player_id,
                'player_out' => null,
                'transfer_type' => TransferTypeEnum::AUCTION,
                'transfer_value' => $sealBid->amount,
                'transfer_date' => $roundStartDate,
            ]);
        }

        return false;
    }

    public function getNextFixtures($clubIds)
    {
        $nextFixtures = Fixture::where(function ($query) use ($clubIds) {
            $query->whereIn('home_club_id', $clubIds)
                                    ->orWhereIn('away_club_id', $clubIds);
        })
                            ->where('date_time', '>', date('Y-m-d'))
                            ->orderBy('date_time')
                            ->get();

        return $nextFixtures;
    }

    public function isAuctionEntryStart($teamIds)
    {
        return OnlineSealedBid::whereIn('team_id', $teamIds)->count();
    }

    public function getSocialLeagues()
    {
        $divisions = Division::join('packages', 'packages.id', '=', 'divisions.package_id')
            ->leftJoin('auction_rounds', 'auction_rounds.division_id', '=', 'divisions.id')
            ->where('packages.private_league', YesNoEnum::NO)
            ->where('divisions.auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)
            ->where('divisions.id', 172)
            ->selectRaw(
                'divisions.*, COUNT(auction_rounds.division_id) AS auction_round_count'
            )
            ->groupBy('divisions.id')
            ->having('auction_round_count', 0)
            ->get();

        return $divisions;
    }

    public function getCurrentSealBidCount($round, $team)
    {
        return OnlineSealedBid::where('team_id', $team->id)
                ->where('auction_rounds_id', $round->id)
                ->whereNull('status')
                ->count();
    }

    public function getContractStartDate($division)
    {
        $roundStartDate = $division->auction_date;
        $firstReound = $division->auctionRounds()->first();
        if ($firstReound) {
            $roundStartDate = $firstReound->start;
        }
        $roundStartDate = carbon_get_date_from_date_time($roundStartDate);

        return $roundStartDate;
    }

    public function getTeamPlayers($team)
    {
        $division = $team->teamDivision->first();
        $roundStartDate = $this->getContractStartDate($division);

        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.player_in', '=', 'team_player_contracts.player_id');
                $join->on('teams.id', '=', 'transfers.team_id');
                $join->where('transfers.transfer_type', '=', TransferTypeEnum::AUCTION);
            })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) ORDER BY id desc LIMIT 1)"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
             ->selectRaw('teams.id as team_id,players.id as player_id,teams.name as team_name,players.first_name as player_first_name,players.last_name as player_last_name,clubs.short_code,player_contracts.position,clubs.name as club_name,clubs.id as club_id,transfers.transfer_value,team_player_contracts.id as team_player_contract_id')
            ->where('teams.id', $team->id)
            ->where('clubs.is_premier', true)
            ->groupBy('teams.id', 'players.id', 'clubs.short_code', 'clubs.id', 'player_contracts.position', 'clubs.name', 'transfers.transfer_value', 'team_player_contracts.id')
            ->get();
    }
}
