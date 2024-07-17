<?php

namespace App\Repositories;

use DB;
use App\Models\Team;
use App\Models\Fixture;
use App\Models\Player;
use App\Models\Season;
use App\Models\Transfer;
use Illuminate\Support\Arr;
use App\Models\PlayerContract;
use App\Enums\AuctionTypesEnum;
use App\Enums\CompetitionEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferTypeEnum;
use App\Models\TeamPlayerContract;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class AuctionRepository
{
    /**
     * @var OnlineSealedBidRepository
     */
    protected $onlineSealedBidRepository;

    public function __construct(OnlineSealedBidRepository $onlineSealedBidRepository)
    {
        $this->onlineSealedBidRepository = $onlineSealedBidRepository;
    }

    public function getDivisionTeamsDetails($division)
    {
        return Team::with('transferBudget')
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->whereIn('teams.id', $division->divisionTeams->pluck('id'))
                    ->approve()
                    ->select('teams.*', 'users.first_name', 'users.last_name')
                    ->get();
    }

    public function getTeamPlayers($team)
    {
        $division = $team->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->leftJoin('fixture_stats', function ($join) {
                $join->on('fixture_stats.player_id', '=', 'players.id');
                $join->whereIn('fixture_stats.fixture_id',
                    function ($query) {
                        $query->select('id')
                        ->from('fixtures')
                        ->where('season_id', Season::getPreviousSeason());
                    });
            })
                ->leftJoin('fixtures', function ($join) {
                    $join->on('fixtures.id', '=', 'fixture_stats.fixture_id');
                })

            ->join('transfers', function ($join) {
                $join->on('transfers.player_in', '=', 'team_player_contracts.player_id');
                $join->on('teams.id', '=', 'transfers.team_id');
                $join->where('transfers.transfer_type', '=', TransferTypeEnum::AUCTION);
            })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) LIMIT 1)"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
             ->selectRaw('teams.id as team_id,players.id as player_id,teams.name as team_name,players.first_name as player_first_name,players.last_name as player_last_name,clubs.short_code,player_contracts.position,clubs.name as club_name,clubs.id as club_id,transfers.transfer_value,SUM(fixture_stats.goal) as total_points,team_player_contracts.id as team_player_contract_id')
            ->where('teams.id', $team->id)
            ->where('clubs.is_premier', true)
            ->groupBy('teams.id', 'players.id', 'clubs.short_code', 'clubs.id', 'player_contracts.position', 'clubs.name', 'transfers.transfer_value', 'team_player_contracts.id')
            ->get();
    }

    public function getPlayers($division, $team, $data)
    {
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);
        $teamIds = $division->divisionTeams->pluck('id');
        $players = Player::leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) {
            $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
            $join->whereIn('fixture_stats_for_stats.fixture_id',
                        function ($query) {
                            $query->select('id')
                            ->from('fixtures')
                            ->where('competition', CompetitionEnum::PREMIER_LEAGUE)
                            ->where('season_id', Season::getPreviousSeason());
                        });
        })
            ->leftJoin('fixtures', function ($join) {
                $join->on('fixtures.id', '=', 'fixture_stats_for_stats.fixture_id');
            })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) ORDER BY id desc LIMIT 1)"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->leftJoin(DB::raw("(team_player_contracts INNER JOIN teams ON teams.id = team_player_contracts.team_id INNER JOIN transfers ON transfers.player_in = team_player_contracts.player_id AND teams.id = transfers.team_id AND transfers.transfer_type = '".TransferTypeEnum::AUCTION."'  INNER JOIN division_teams ON division_teams.team_id = teams.id AND division_teams.division_id = ".$division->id.')'),
                  function ($join) {
                      $join->on('team_player_contracts.player_id', '=', 'players.id');
                  })
                ->leftJoin('consumers', 'consumers.id', '=', 'teams.manager_id')
                ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
                ->selectRaw('players.id,players.first_name as player_first_name,players.last_name as player_last_name,players.short_code as player_short_code,clubs.id as club_id,clubs.name as club_name,player_contracts.position,REPLACE(REPLACE(player_contracts.position,"Centre-back (CB)","Defender (DF)"),"Full-back (FB)","Defender (DF)") as merge_positions,teams.id as team_id,teams.name as team_name,users.first_name as user_first_name,users.last_name as user_last_name,transfers.transfer_value as bid,clubs.short_code,team_player_contracts.id as team_player_contract_id,SUM(fixture_stats_for_stats.goal) as total_goal,SUM(fixture_stats_for_stats.assist) as total_assist,SUM(fixture_stats_for_stats.goal_conceded) as total_goal_against,SUM(fixture_stats_for_stats.clean_sheet) as total_clean_sheet,SUM(IF(fixture_stats_for_stats.appearance >= 45 , 1, 0)) as total_game_played')
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
        if (Arr::has($data, 'club')) {
            $players = $players->where('clubs.id', array_get($data, 'club'));
        }
        if (Arr::has($data, 'player')) {
            $players = $players->where(function ($query) use ($data) {
                $query->where('players.first_name', 'like', '%'.escape_like(array_get($data, 'player')).'%')
                                    ->orWhere('players.last_name', 'like', '%'.escape_like(array_get($data, 'player')).'%')
                                    ->orWhere('clubs.short_code', 'like', '%'.escape_like(array_get($data, 'player')).'%')
                                    ->orWhere('players.short_code', 'like', '%'.escape_like(array_get($data, 'player')).'%');
            });
        }
        if (Arr::has($data, 'boughtPlayers') && Arr::get($data, 'boughtPlayers') == 'no') {
            $players = $players->whereNull('team_player_contracts.id');
        }

        if ($division->getOptionValue('merge_defenders') == 'Yes') {
            $players->orderByRaw("FIELD(merge_positions, 'Goalkeeper (GK)','Defender (DF)','Defensive Midfielder (DMF)','Midfielder (MF)','Striker (ST)')");
        } else {
            $players->orderByRaw("FIELD(player_contracts.position, 'Goalkeeper (GK)','Full-back (FB)','Centre-back (CB)','Defensive Midfielder (DMF)','Midfielder (MF)','Striker (ST)')");
        }

        if (isset($data['order'][0]['column']) && $data['order'][0]['column'] == 0) {
            $players->orderBy('players.short_code', $data['order'][0]['dir']);
            $players->orderBy('clubs.short_code');
            $players->orderBy('players.last_name');
            $players->orderBy('players.first_name');
        }
        if (isset($data['order'][0]['column']) && $data['order'][0]['column'] == 1) {
            $players->orderBy('players.last_name', $data['order'][0]['dir']);
            $players->orderBy('clubs.short_code');
            $players->orderBy('players.first_name');
            $players->orderBy('players.short_code');
        }
        if (isset($data['order'][0]['column']) && $data['order'][0]['column'] == 2) {
            $players->orderBy('clubs.short_code', $data['order'][0]['dir']);
            $players->orderBy('players.last_name');
            $players->orderBy('players.first_name');
            $players->orderBy('players.short_code');
        }

        if (! isset($data['order'][0]['column']) &&
            ! isset($data['order'][1]['column'])
        ) {
            $players->orderBy('clubs.short_code');
            $players->orderBy('players.last_name');
            $players->orderBy('players.first_name');
            $players->orderBy('players.short_code');
        }

        return $players->groupBy('players.id', 'clubs.id', 'clubs.name', 'player_contracts.position', 'teams.id', 'teams.name', 'transfers.transfer_value', 'clubs.short_code', 'team_player_contracts.id')
                ->get();
    }

    public function getTeamClubPlayers($team, $club)
    {
        $oTeam = Team::find($team);
        $division = $oTeam->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        return TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
             ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                 $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) ORDER BY id desc LIMIT 1)"));
             })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team)
            ->whereNull('team_player_contracts.end_date')
            ->where('clubs.id', $club)
            ->count();
    }

    public function getplayerPosition($clubId, $playerId)
    {
        $position = PlayerContract::where('player_id', $playerId)->where('club_id', $clubId)->first();

        return $position ? $position->position : '';
    }

    public function getTeamPlayersCount($team)
    {
        return TeamPlayerContract::where('team_id', $team)->active()->count();
    }

    public function getTeamPlayerPostions($team)
    {
        $division = $team->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        return TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
             ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                 $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) ORDER BY id desc LIMIT 1)"));
             })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
    }

    public function getTeamClubsPlayer($team)
    {
        $division = $team->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        return TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
             ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                 $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) ORDER BY id desc LIMIT 1)"));
             })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(clubs.id) as total,clubs.id as club_id')
            ->groupBy('clubs.id')
            ->pluck('total', 'club_id');
    }

    public function edit($data, $team)
    {
        $transfer = Transfer::where('team_id', $team->id)
            ->where('player_in', $data['player_id'])
            ->first();

        $teamBudget = $team->team_budget + $transfer->transfer_value;

        $transfer->fill([
            'transfer_value' => $data['amount'],
        ])->save();

        return $team->fill([
            'team_budget' => ($teamBudget - $data['amount']),
        ])->save();
    }

    public function create($data, $team)
    {
        $team->fill([
            'team_budget' => ($team->team_budget - $data['amount']),
        ])->save();

        $division = $team->teamDivision->first();

        TeamPlayerContract::create([
            'team_id' => $team->id,
            'player_id' => $data['player_id'],
            'is_active' => false,
            'start_date' => $division->auction_date,
            'end_date' =>  null,
        ]);

        return Transfer::create([
            'team_id' => $team->id,
            'player_in' => $data['player_id'],
            'player_out' => null,
            'transfer_type' => TransferTypeEnum::AUCTION,
            'transfer_value' => $data['amount'],
            'transfer_date' => $division->auction_date,
        ]);
    }

    public function getTeamPlayerPositions($team)
    {
        return TeamPlayerContract::join('player_contracts', 'player_contracts.player_id', '=', 'team_player_contracts.player_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNull('player_contracts.end_date')
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
    }

    public function getTeamPlayerContracts($team)
    {
        $division = $team->teamDivision->first();

        if ($division->auction_types === AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            $auctionDate = $this->onlineSealedBidRepository->getContractStartDate($division);
        } else {
            $auctionDate = carbon_get_date_from_date_time($division->auction_date);
        }

        return TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) ORDER BY id desc LIMIT 1)"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
             ->select('teams.id as team_id', 'players.id as player_id', 'teams.name as team_name', 'players.first_name as player_first_name', 'players.last_name as player_last_name', 'clubs.short_code', 'player_contracts.position', 'clubs.name as club_name', 'team_player_contracts.id')
            ->where('teams.id', $team->id)
            ->whereNull('team_player_contracts.end_date')->get();
    }

    public function update($teamId, $playerId)
    {
        return TeamPlayerContract::where('team_id', $teamId)
            ->where('player_id', $playerId)
            ->whereNull('end_date')
            ->update(['is_active' => true]);
    }

    public function closeDivision($division)
    {
        $budgetRollover = $division->getOptionValue('budget_rollover');
        $sealBidsBudget = $division->getOptionValue('seal_bids_budget');

        foreach ($division->divisionTeams as $key => $value) {
            $remaninigBudget = $sealBidsBudget;

            if ($budgetRollover == 'Yes') {
                $remaninigBudget = $value->team_budget + $sealBidsBudget;
            }

            $value->fill([
                'team_budget' => $remaninigBudget,
            ])->save();
        }

        $division->fill([
            'auction_closing_date' => now(),
        ]);

        return $division->save();
    }

    public function startAuction($division, $start)
    {
        $division->fill([
            'auction_date' => $start,
        ]);

        return $division->save();
    }

    public function getNextFixture($club)
    {
        $nextFixture = Fixture::where(function ($query) use ($club) {
            $query->where('home_club_id', $club)
                                    ->orWhere('away_club_id', $club);
        })
                            ->where('date_time', '>', date('Y-m-d'))
                            ->orderBy('date_time')
                            ->first();

        return $nextFixture;
    }

    public function destroy($division, $team, $player)
    {
        $transferValue = Transfer::where('player_in', $player->id)
                ->where('team_id', $team->id)
                ->where('transfer_type', TransferTypeEnum::AUCTION)
                ->sum('transfer_value');

        $teamBudget = $team->team_budget + $transferValue;

        $team->fill([
            'team_budget' => $teamBudget,
        ])->save();

        Transfer::where('player_in', $player->id)
            ->where('team_id', $team->id)
            ->where('transfer_type', TransferTypeEnum::AUCTION)
            ->delete();

        TeamPlayerContract::where('player_id', $player->id)
            ->where('team_id', $team->id)
            ->delete();

        return $team;
    }

    public function resetLiveOfflineAuction($division)
    {
        $auctionBudget = $division->getOptionValue('pre_season_auction_budget');

        foreach ($division->divisionTeams as $team) {
            $team->teamPlayerContracts()->delete();
            $team->transfer()->delete();

            $team->fill([
                'team_budget' => $auctionBudget,
            ]);

            $team->save();
        }
    }

    public function getPreAuctionDetails($division)
    {
        $type = $division->getOptionValue('auction_types');
        $startTime = $division->getOptionValue('auction_date');
        $venue = $division->getOptionValue('auction_venue');
        $budget = $division->getOptionValue('pre_season_auction_budget');
        $bidIncrement = $division->getOptionValue('pre_season_auction_bid_increment');
        $isOnNominations = $division->getOptionValue('allow_passing_on_nominations');
        $nominationLimit = $division->getOptionValue('remote_nomination_time_limit');
        $bidsLimit = $division->getOptionValue('remote_bidding_time_limit');
        $budgetRollover = $division->getOptionValue('budget_rollover');
        $tiePreference = $division->getOptionValue('tie_preference');
        $auctionTypesEnum = AuctionTypesEnum::toArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $auctionRounds = $division->auctionRounds;
        $auctionMessage = 'Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi quis iaculis nulla iaculis vitae. Donec sagittis faucibus lacus eget blandit. Mauris vitae ultricies metus, at condimentum nulla. Donec quis ornare lacus. Etiam gravida mollis tortor quis porttitor.';

        return compact('type', 'startTime', 'venue', 'budget', 'bidIncrement', 'isOnNominations', 'nominationLimit', 'bidsLimit', 'division', 'budgetRollover', 'tiePreference', 'auctionTypesEnum', 'tiePreferenceEnum', 'auctionRounds','auctionMessage');
    }

    public function isAuctionEntryStart($teamIds)
    {
        return TeamPlayerContract::whereIn('team_id', $teamIds)->count();
    }

    public function checkAuctionPlayerInAnotherTeam($division, $player)
    {
        $teamIds = $division->divisionTeams->pluck('id');

        return TeamPlayerContract::whereIn('team_id', $teamIds)
        ->where('team_player_contracts.player_id', $player)
        ->whereNull('team_player_contracts.end_date')
        ->count();
    }
}
