<?php

namespace App\Console\Commands;

use App\Enums\PlayerContractPosition\AllPositionEnum;
use Illuminate\Console\Command;

class ResetInvalidSquads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugfix:reset-invalid-squads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $repo = app(\App\Repositories\TeamLineupRepository::class);
        $auctionRepository = app(\App\Repositories\AuctionRepository::class);
        $auctionService = app(\App\Services\AuctionService::class);
        $teamPlayerPointService = app(\App\Services\TeamPlayerPointsService::class);

        $teams = \DB::select('select team_id, division_id from teams inner join division_teams dt on dt.team_id = teams.id and dt.season_id = 30 inner join divisions d on d.id = dt.`division_id` where teams.is_approved = 1');

        $file = storage_path('fixed-invalid.csv');
        $handle = fopen($file, 'w');

        foreach ($teams as $key => $team_id) {
            $team = \App\Models\Team::find($team_id->team_id);

            if (! $team) {
                continue;
            }
            $division = \App\Models\Division::find($team_id->division_id);
            $lineup = $repo->getPlayers($team, 'active', false)->count();
            $subs = $repo->getPlayers($team, 'sub', false)->count();
            $total = $lineup + $subs;
            $managerEmail = $team->consumer->user->email;
            $defaultSquadSize = $division->getOptionValue('default_squad_size');
            if ($total === 0) {
                $op = 'NOT SET';
            } else {
                if ($total === $defaultSquadSize) {
                    $op = 'VALID';
                } else {

                    // check auction complete or not
                    if ($division->auction_closing_date === null) {
                        $op = 'NOT SET - AUCTION NOT CLOSED';
                    } else {
                        $op = 'INVALID';

                        $tpc = \DB::select("select count(*) as c from team_player_contracts where team_id = $team->id and end_date is null");

                        if ($tpc[0]->c === $defaultSquadSize) {
                            info('count of '.$team->id.' '.count($tpc));
                            info('ignore for team '.$team->id);
                            fputcsv($handle, [$team->id, $team_id->division_id, 'IGNORED']);
                            continue;
                        }
                        info('reset for team '.$team->id);
                        fputcsv($handle, [$team->id, $team_id->division_id, 'RESET']);

                        // continue;
                        // delete existing contracts for team id

                        $team->teamPlayerContracts()->delete();

                        // delete supersubs
                        \App\Models\SupersubTeamPlayerContract::where('team_id', $team->id)->delete();

                        // read auction data
                        $auctionRecords = \DB::select("select * from transfers where team_id = $team->id and transfer_type = 'auction'");

                        // create new player contracts from auction data
                        foreach ($auctionRecords as $key => $rec) {
                            $saveData = [
                                'team_id' => $team->id,
                                'player_id' => $rec->player_in,
                                'is_active' => 0,
                                'start_date' => $rec->transfer_date,
                                'end_date' => null,
                            ];

                            $result = \App\Models\TeamPlayerContract::create($saveData);
                        }

                        // create basic formation
                        $teamPlayers = $auctionRepository->getTeamPlayerContracts($team);
                        $teamPlayers->filter(function ($value, $key) use ($division) {
                            if ($division->getOptionValue('merge_defenders') == 'Yes') {
                                if ($value->position == AllPositionEnum::CENTREBACK ||
                                    $value->position == AllPositionEnum::FULLBACK
                                ) {
                                    return $value->setAttribute('position', AllPositionEnum::DEFENDER);
                                }
                            }

                            if ($value->position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                                return $value->setAttribute('position', AllPositionEnum::MIDFIELDER);
                            }
                        });
                        try {
                            $auctionService->setTeamFormations($division, $teamPlayers->groupBy('position'));
                        } catch (\Exception $e) {
                            info('ERROR: CANNOT SET TEAM FORMATION FOR '.$team->id);
                            info('MESSAGE: '.$e->getMessage());
                            continue;
                        }

                        // new contracts
                        $newContracts = \DB::select("select * from team_player_contracts where team_id = $team->id");
                        // recalualte points as per new contracts
                        foreach ($newContracts as $key => $c) {
                            $player = \App\Models\Player::find($c->player_id);
                            $teamPlayerPointService->recalculate([
                                'start_date' => [\Carbon\Carbon::parse($c->start_date)->format(config('fantasy.time.format'))],
                                'end_date' => [null],
                                'is_active' => [$c->is_active],
                            ], $team, $player);
                        }

                        // what reason
                        // check transfer, auction = squad size
                        // $count = \DB::select("select count(*) as c from transfers where team_id = $team->id and transfer_type = 'auction'");
                        // if($count[0]->c === $defaultSquadSize) {
                        //     $op = 'INVALID - INACTIVE PLAYER';
                        //     $tpc_count = \DB::select("select count(distinct player_id) as c from team_player_contracts where team_id = $team->id");

                        //     if($tpc_count[0]->c === $defaultSquadSize) {
                        //         // inactive or playercontract
                        //     }
                        // } else {
                        //     $op = 'VALID - AUCTION NOT COMPLETE';
                        // }
                    }
                }
            }
        }
        fclose($handle);
        $this->info('done');
    }
}
