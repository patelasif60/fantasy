<?php

namespace App\Repositories;

use App\Enums\CompetitionEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\TransferTypeEnum;
use App\Models\Club;
use App\Models\Division;
use App\Models\Player;
use App\Models\PlayerAuctionBid;
use App\Models\Season;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\Transfer;
use App\Services\AuctionService;
use App\Services\SealedBidTransferService;
use App\Services\TransferService;
use App\Services\ValidateFormationService;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class LiveOnlineAuctionRepository
{
    protected $transferService;
    protected $sealedBidService;
    protected $auctionService;
    protected $validateFormationService;

    public function __construct(TransferService $transferService, SealedBidTransferService $sealedBidService, AuctionService $auctionService, ValidateFormationService $validateFormationService)
    {
        $this->transferService = $transferService;
        $this->sealedBidService = $sealedBidService;
        $this->auctionService = $auctionService;
        $this->validateFormationService = $validateFormationService;
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
        $roundStartDate = carbon_get_date_from_date_time($division->auction_date);

        $players = Player::join('player_contracts as latest_player_contracts', function ($join) use ($roundStartDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND ((( '".$roundStartDate."' >= player_contracts.start_date AND '".$roundStartDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$roundStartDate."')) LIMIT 1)"));
        })
                ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->leftJoin(DB::raw("(team_player_contracts as sold_team_player_contracts INNER JOIN teams ON teams.id = sold_team_player_contracts.team_id INNER JOIN transfers ON transfers.player_in = sold_team_player_contracts.player_id AND teams.id = transfers.team_id AND transfers.transfer_type = '".TransferTypeEnum::AUCTION."'  INNER JOIN division_teams ON division_teams.team_id = teams.id AND division_teams.division_id = ".$division->id.')'),
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
                    'players.id as id',
                    'players.first_name as player_first_name',
                    'players.last_name as player_last_name',
                    'player_contracts.position as position',
                    'clubs.name as club_name',
                    'clubs.short_code as shortCode',
                    'clubs.id as club_id',
                    'clubs.short_code as playerClubShortCode',
                    'soldPlayerTeams.id as team_id',
                    'soldPlayerTeams.name as team_name',
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

        // if ($isMobile) {
        //     $players = $players->paginate(config('fantasy.pagination'));
        // } else {
        //     $players = $players->get();
        // }

        $players = $players->get();

        return $players;
    }

    public function getTeamManagers($request, $division)
    {
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
        $defaultSquadSize = $division->getOptionValue('default_squad_size');

        $positions = ($division->playerPositionEnum())::toSelectArray();
        $clubs = Club::pluck('name', 'id');

        $clubCounts = [];

        $teamManagers = Team::join('division_teams', function ($join) use ($division) {
            $join->on('division_teams.team_id', '=', 'teams.id')
                            ->where('division_teams.division_id', $division->id);
        })
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->selectRaw('teams.id as team_id, teams.name as team_name, teams.manager_id, teams.crest_id, teams.team_budget, users.first_name, users.last_name, users.email')
                    ->get();

        $i = 0;
        foreach ($teamManagers as $key => $manager) {
            $manager->id = $key;
            $manager->is_remote = 0;
            $manager->order = $i;
            $manager->team_budget = (float) $manager->team_budget;
            $manager->team_crest = $manager->getCrestImageThumb();
            $i++;
        }

        $data['division'] = $division;
        $data['teamManagers'] = $teamManagers;
        $data['positions'] = $positions;
        $data['clubs'] = $clubs;
        $data['maxClubPlayer'] = $maxClubPlayer;
        $data['defaultSquadSize'] = $defaultSquadSize;

        return $data;
    }

    public function searchPlayers($request, $division)
    {
        $player = $request->player;
        $plList = Player::join('player_contracts', 'player_contracts.player_id', '=', 'players.id')
                        ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                        ->where(function ($qry) use ($player) {
                            $qry->where('players.first_name', 'like', '%'.$player.'%')
                                ->orWhere('players.last_name', 'like', '%'.$player.'%')
                                ->orWhere('players.short_code', 'like', '%'.$player.'%');
                        })
                        ->whereNotIn('players.id', function ($query) use ($division) {
                            $query->select('player_id')
                                    ->from('player_auction_bids')
                                    ->where('season_id', Season::getLatestSeason())
                                    ->where('division_id', $division->id);
                        })
                        ->selectRaw('players.id, players.first_name, players.last_name, players.short_code as psc, clubs.short_code as club_short_code, player_contracts.position, clubs.name as club_name, clubs.id as club_id')
                        ->get()
                        ->keyBy('id');

        foreach ($plList as $key => $player) {
            $playerName = get_player_name('fullName', $player->first_name, $player->last_name);
            $player->display_name = $playerName.' ('.$player->club_short_code.') '.player_position_short($player->position);
            $player->position = player_position_short($player->position);
        }

        return $plList;
    }

    public function getAvailablePositions($team_id, $division)
    {
        $availablePostions = [];

        $players = PlayerAuctionBid::where([
            'season_id' => Season::getLatestSeason(),
            'team_id' => $team_id,
            'division_id' => $division->id,
        ])
                                    ->groupBy('position')
                                    ->get(['position', \DB::raw('count(*) as count')]);

        if (isset($players)) {
            $positionArr = [];
            foreach ($players as $player) {
                $position = player_position_full($player->position);
                $positionArr[$position] = $player->count;
            }

            $availablePostions = $this->validateFormationService->getEnabledPositions($division, $positionArr);

            foreach ($availablePostions as $key => $value) {
                $availablePostions[$key] = player_position_short($value);
            }
        }

        return $availablePostions;
    }

    // public function getPlayers($request, $division)
    // {
    //     $data = $request->all();
    //     if (trim(@$request->all()['club']) == '') {
    //         unset($data['club']);
    //     }

    //     $defensiveMidfields = $division->getOptionValue('defensive_midfields');
    //     $mergeDefenders = $division->getOptionValue('merge_defenders');
    //     $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');

    //     $players = $this->transferService->getTransferPlayers($division, null, $data);

    //     $team = Auth::user()->consumer->ownTeamDetails($division);

    //     // getting formations
    //     $availablePostions = $this->getAvailablePositions($team->id, $division);

    //     // Players count by club
    //     $teamClubsPlayer = $this->sealedBidService->getClubIdWithCount($team->id)->toArray();

    //     $clubList = array_keys($teamClubsPlayer);
    //     $clubCounts = [];

    //     foreach ($players as $key => $player) {
    //         $position = player_position_short($player->position);
    //         $player->available = false;
    //         if (in_array($position, $availablePostions)) {
    //             $player->available = true;
    //         }

    //         if (in_array($player->club_id, $clubList)) {
    //             $clubCounts[$player->club_id] = (int) @$clubCounts[$player->club_id] + 1;
    //         }

    //         $player->position = $position;

    //         $player->club_quota = '';
    //         if (isset($clubCounts) && @$clubCounts[$player->club_id] >= $maxClubPlayer) {
    //             $player->club_quota = 'exosted';
    //             $player->available = false;
    //         }

    //         if ($position == 'DMF') {
    //             if ($defensiveMidfields == 'Yes') {
    //                 $player->position = 'DM';
    //             } else {
    //                 $player->position = 'MF';
    //             }
    //         } elseif ($position == 'CB' || $position == 'FB') {
    //             if ($mergeDefenders == 'Yes') {
    //                 $player->position = 'DF';
    //             }
    //         }
    //     }

    //     return $players;
    // }

    public function getTeamPlayerCountForClub($request, $division, $club, $team)
    {
        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
        // $defaultSquadSize = $division->getOptionValue('default_squad_size');

        $players = PlayerAuctionBid::where([
            'season_id' => Season::getLatestSeason(),
            'team_id' => $team,
            'division_id' => $division->id,
            'club_id' => $club,
        ])->count();

        $response = ['success' => true];
        if ($maxClubPlayer <= $players) {
            $response = ['success' => false, 'message' => 'Club quota is full. Please select player for another club.'];
        } else {
            $availablePostions = $this->getAvailablePositions($team, $division);
            if (! empty($availablePostions)) {
                $response = ['success' => true, 'availablePostions' => $availablePostions];
            }
        }

        return $response;
    }

    public function playerSold($request, $division)
    {
        $divisionData = Division::find($division);
        $result = $this->getTeamPlayerCountForClub($request, $divisionData, $request->get('club_id'), $request->get('team_id'));

        if ($result['success'] == false) {
            return $result;
        }

        if (in_array($request->get('position'), $result['availablePostions'])) {
            $data['season_id'] = Season::getLatestSeason();
            $data['division_id'] = $division;
            $data['team_id'] = $request->get('team_id');
            $data['player_id'] = $request->get('player_id');
            $data['position'] = $request->get('position');
            $data['round'] = $request->get('round');
            $data['club_id'] = $request->get('club_id');
            $data['high_bidder_id'] = $request->get('high_bidder_id');
            $data['high_bid'] = $request->get('high_bid_value');
            $data['opening_bidder_id'] = $request->get('opening_bid_manager_id');
            $data['opening_bid'] = $request->get('opening_bid');

            $response = PlayerAuctionBid::create($data);

            $returnResponse = [];

            if ($response) {
                $returnResponse = ['success' => true];
            } else {
                $returnResponse = ['success' => false, 'message' => 'Error... Please try after sometime'];
            }
        } else {
            $returnResponse = ['success' => false, 'message' => 'Invalid formation'];
        }

        return $returnResponse;
    }

    public function updateSoldPlayer($request, $division)
    {
        $divisionData = Division::find($division);

        $result = $this->getTeamPlayerCountForClub($request, $divisionData, $request->get('club_id'), $request->get('team_id'));

        if ($result['success'] == false) {
            return $result;
        }

        if (in_array($request->get('position'), $result['availablePostions'])) {
            $condition = ['player_id' => $request->get('player_id'), 'division_id' => $division, 'season_id' => Season::getLatestSeason()];
            $playerRecord = PlayerAuctionBid::where($condition)->first();

            $playerRecord->team_id = $request->get('team_id');
            $playerRecord->high_bidder_id = $request->get('bidder_id');
            $playerRecord->high_bid = $request->get('bid_price');
            $response = $playerRecord->save();

            $returnResponse = [];

            if ($response) {
                $returnResponse = ['success' => true];
            } else {
                $returnResponse = ['success' => false, 'message' => 'Error... Please try after sometime'];
            }
        } else {
            $returnResponse = ['success' => false, 'message' => 'Invalid formation'];
        }

        return $returnResponse;
    }

    public function deleteSoldPlayer($request, $division)
    {
        $condition = ['player_id' => $request->get('player_id'), 'division_id' => $division, 'season_id' => Season::getLatestSeason(), 'club_id' => $request->get('club_id'), 'position' => $request->get('position'), 'high_bidder_id' => $request->get('bidder_id')];

        $response = PlayerAuctionBid::where($condition)->delete();

        $returnResponse = [];

        if ($response) {
            $returnResponse = ['success' => true];
        } else {
            $returnResponse = ['success' => false, 'message' => 'Error... Please try after sometime'];
        }

        return $returnResponse;
    }

    public function getSoldPlayersOfTeam($request, $division, $team)
    {
        $players = PlayerAuctionBid::join('clubs', 'player_auction_bids.club_id', 'clubs.id')
                                        ->where([
                                            'season_id' => Season::getLatestSeason(),
                                            'team_id' => $team,
                                            'division_id' => $division,
                                        ])
                                        ->get();
        $playersList = [];
        foreach ($players as $key => $player) {
            $player->tshirt = player_tshirt($player->short_code, $player->position);
            $playersList[strtolower($player->position)][] = $player;
        }

        return $playersList;
    }

    public function endLonAuction($division)
    {
        if ($this->allTeamSizeFull($division)) {
            if ($this->createPlayerContracts($division)) {
                if ($this->auctionService->close($division)) {
                    return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
                }

                return response()->json(['status' => 'error', 'message' => 'Please fill players in all team of Division'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            return response()->json(['status' => 'error', 'message' => 'Please fill players in all team of Division'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function allTeamSizeFull($division)
    {
        if (! $division->divisionTeams->count()) {
            return false;
        }

        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        foreach ($division->divisionTeams as $key => $team) {
            if ($team->activeTeamPlayersFromOnlineAuction->count() < $defaultSquadSize) {
                return false;
            }
        }

        return true;
    }

    public function createPlayerContracts($division)
    {
        $players = PlayerAuctionBid::where('division_id', $division->id)->get();

        $teamBudget = [];
        foreach ($players as $key => $player) {
            $teamBudget[$player->team_id] = @$teamBudget[$player->team_id] + $player->high_bid;
            TeamPlayerContract::create([
                'team_id' => $player->team_id,
                'player_id' => $player->player_id,
                'is_active' => false,
                'start_date' => now(),
                'end_date' =>  null,
            ]);

            Transfer::create([
                'team_id' => $player->team_id,
                'player_in' => $player->player_id,
                'player_out' => null,
                'transfer_type' => TransferTypeEnum::AUCTION,
                'transfer_value' => $player->high_bid,
                'transfer_date' => now(),
            ]);
        }

        foreach ($teamBudget as $team_id => $amount) {
            $team = Team::find($team_id);
            $team->fill([
                'team_budget' => ($team->team_budget - $amount),
            ])->save();
        }

        return true;
    }
}
