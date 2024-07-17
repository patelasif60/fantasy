<?php

namespace App\Console\Commands;

use App\Enums\TransferTypeEnum;
use App\Models\SupersubTeamPlayerContract;
use App\Models\TeamPlayerContract;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class OnetimeSupersubPlayersToLineupPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugfix:onetimesupersub_players_to_lineup_players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update supersub players to lineup players before fixture starts';

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
        $now = Carbon::now();
        $opfile = storage_path('supersub-manual-run-0817.csv');
        $ophandle = fopen($opfile, 'w');
        $file = storage_path('combines-supersub-affected-teams.csv');
        $csv = array_flatten(array_map('str_getcsv', file($file)));
        $affectedFixtures = \App\Models\Fixture::whereDate('date_time', '2019-08-17')->orderBy('date_time')->get()->pluck('date_time')->unique();
        foreach ($affectedFixtures as $key => $affectedFixture) {
            fputcsv($ophandle, [$affectedFixture]);

            $distinctFixtures = SupersubTeamPlayerContract::select('team_id', 'start_date')
                                                                ->distinct()
                                                                // ->where('is_applied', false)
                                                                ->whereNotIn('team_id', $csv)
                                                                ->where('start_date', $affectedFixture)
                                                                ->orderBy('start_date')
                                                                ->get();

            if ($distinctFixtures->count() > 0) {
                foreach ($distinctFixtures as $fixture) {
                    $fixtureDate = Carbon::parse($fixture->start_date);
                    $remTime = $fixtureDate->diffInMinutes($now);

                    //update cntracts if kickoff time before 1 min
                    if ($remTime > 1) {
                        Log::info('***** Updating Subsub Data Starts *****');
                        $fixtureDate = $fixture->start_date;
                        $team_id = $fixture->team_id;

                        //supersub data
                        $supersubData = SupersubTeamPlayerContract::where('team_id', $team_id)
                                                            ->where('start_date', $fixtureDate);
                        // ->where('is_applied', false);

                        $supersub = $supersubData->get()->keyBy('player_id')->toArray();
                        $superSubPlayers = $supersubData->where('is_active', 1)->pluck('player_id')->toArray();

                        // $deleteOldRecords = SupersubTeamPlayerContract::where('team_id', $team_id)
                        //                                 ->where('start_date', $fixtureDate)
                        //                                 ->update(['is_applied' => true]);

                        //teamlineup data
                        $teamLineupData = \App\Models\TeamPlayerContract::where('team_id', $team_id)
                                                    ->whereNull('end_date');
                        $teamLineup = $teamLineupData->get()->keyBy('player_id');
                        $teamLineupPlayers = $teamLineupData->where('is_active', 1)->pluck('player_id')->toArray();

                        $inPlayers = array_values(array_diff($superSubPlayers, $teamLineupPlayers));
                        $outPlayers = array_values(array_diff($teamLineupPlayers, $superSubPlayers));

                        if (count($inPlayers) !== count($outPlayers)) {
                            info('---------- SUPERSUB ----------- ERROR INVALID SQUAD');
                            info('teamID '.$team_id);
                            info('$inPlayers');
                            info($inPlayers);
                            info('$outPlayers');
                            info($outPlayers);
                            fputcsv($ophandle, [$team_id, '', 'IGNORED']);
                            continue;
                        }

                        $playerTransfer = false;
                        foreach ($teamLineup as $key => $value) {
                            if (isset($supersub[$value->player_id])) {
                                if ($supersub[$value->player_id]['is_active'] != $value->is_active) {
                                    Log::info('***** Player Current Status *****');
                                    Log::info(json_encode($value));

                                    $updateCurrentPlayer = TeamPlayerContract::where('id', $value->id)->update(['end_date' => $supersub[$value->player_id]['start_date']]);
                                    fputcsv($ophandle, [$team_id, $value->player_id, 'APPLIED']);
                                    $saveData = [
                                        'team_id' => $team_id,
                                        'player_id' => $value->player_id,
                                        'is_active' => $supersub[$value->player_id]['is_active'],
                                        'start_date' => $supersub[$value->player_id]['start_date'],
                                        'end_date' => null,
                                    ];

                                    $result = TeamPlayerContract::create($saveData);

                                    Log::info('Player New Status');
                                    Log::info(json_encode($saveData));

                                    $playerTransfer = true;
                                }
                            }
                        }

                        if ($playerTransfer) {
                            Log::info('***** Create entry in transfer table *****');
                            foreach ($inPlayers as $key => $value) {
                                $transfer_value = Transfer::where('team_id', $team_id)
                                                            ->where('player_in', $inPlayers[$key])
                                                            ->orderBy('transfers.transfer_date', 'desc')
                                                            ->select('transfers.transfer_value')
                                                            ->first();

                                if ($transfer_value) {
                                    $transfer_value = $transfer_value->transfer_value;
                                } else {
                                    $transfer_value = null;
                                }

                                $transfer = [
                                    'team_id' => $team_id,
                                    'player_in' => $inPlayers[$key],
                                    'player_out' => $outPlayers[$key],
                                    'transfer_type' => TransferTypeEnum::SUPERSUB,
                                    'transfer_value' => $transfer_value,
                                    'transfer_date' => now(),
                                ];
                                Transfer::create($transfer);
                                Log::info(json_encode($transfer));
                            }
                        }

                        // ->delete();

                        Log::info('***** Updating Subsub Data Ends *****');
                    }
                }
            }
        }
    }
}
