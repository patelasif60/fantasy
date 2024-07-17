<?php

namespace App\Console\Commands;

use App\Enums\TransferTypeEnum;
use App\Models\SupersubTeamPlayerContract;
use App\Models\TeamPlayerContract;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class SupersubBugFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugfix:supersub-apply';

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
        $service = app(\App\Services\TeamPlayerPointsService::class);

        $distinctFixtures = SupersubTeamPlayerContract::select('team_id', 'start_date')
                                                            ->distinct()
                                                            ->where('is_applied', false)
                                                            ->where('start_date', '<', now())
                                                            // ->whereIn('team_id', [2863,2864,2865,2866,2867,2868,3713,4335,8328])
                                                            ->orderBy('start_date')
                                                            //->offset(100)
                                                            //->limit(100)
                                                            ->get();

        $now = Carbon::now();
        $i = 0;

        if ($distinctFixtures->count() > 0) {
            foreach ($distinctFixtures as $fixture) {
                $fixtureDate = Carbon::parse($fixture->start_date);
                $remTime = $fixtureDate->diffInMinutes($now);

                //update cntracts if kickoff time before 1 min
                if ($remTime >= 1) {
                    Log::info('***** Updating Subsub Data Starts *****');
                    $fixtureDate = $fixture->start_date;
                    $team_id = $fixture->team_id;
                    info('checking for team '.$team_id);
                    //supersub data
                    $supersubData = SupersubTeamPlayerContract::where('team_id', $team_id)
                                                        ->where('start_date', $fixtureDate)
                                                        ->where('is_applied', false);
                    $supersub = $supersubData->get()->keyBy('player_id')->toArray();
                    $superSubPlayers = $supersubData->where('is_active', 1)->pluck('player_id')->toArray();

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
                        // info('$inPlayers');
                        // info($inPlayers);
                        // info('$outPlayers');
                        // info($outPlayers);
                        continue;
                    }

                    $playerTransfer = false;
                    $affectedPlayers = [];
                    foreach ($teamLineup as $key => $value) {
                        if (isset($supersub[$value->player_id])) {
                            if ($supersub[$value->player_id]['is_active'] != $value->is_active) {
                                Log::info('***** Player Current Status *****');
                                Log::info(json_encode($value));

                                $player = \App\Models\Player::find($value->player_id);
                                $team = \App\Models\Team::find($value->team_id);

                                $updateCurrentPlayer = TeamPlayerContract::where('id', $value->id)->update(['end_date' => $supersub[$value->player_id]['start_date']]);
                                // array_push($affectedPlayers, $value->player_id);
                                // recalculate
                                $i++;

                                $service->recalculate([
                                    'start_date' => [Carbon::parse($value->start_date)->format(config('fantasy.time.format'))],
                                    'end_date' => [Carbon::parse($supersub[$value->player_id]['start_date'])->format(config('fantasy.time.format'))],
                                    'is_active' => [$value->is_active],
                                ], $team, $player);

                                $saveData = [
                                    'team_id' => $team_id,
                                    'player_id' => $value->player_id,
                                    'is_active' => $supersub[$value->player_id]['is_active'],
                                    'start_date' => $supersub[$value->player_id]['start_date'],
                                    'end_date' => null,
                                ];

                                $result = TeamPlayerContract::create($saveData);
                                // $i++;
                                // recalculate
                                // array_push($affectedPlayers, $value->player_id);
                                $service->recalculate([
                                    'start_date' => [Carbon::parse($supersub[$value->player_id]['start_date'])->format(config('fantasy.time.format'))],
                                    'end_date' => [null],
                                    'is_active' => [$result->is_active],
                                ], $team, $player);

                                Log::info('Player New Status');
                                Log::info(json_encode($saveData));

                                $playerTransfer = true;
                            }
                        }
                    }

                    if ($playerTransfer) {
                        Log::info('***** Create entry in transfer table *****');
                        foreach ($inPlayers as $key => $value) {
                            $transfer = [
                                'team_id' => $team_id,
                                'player_in' => $inPlayers[$key],
                                'player_out' => $outPlayers[$key],
                                'transfer_type' => TransferTypeEnum::SUPERSUB,
                                'transfer_value' => null,
                                'transfer_date' => now(),
                            ];
                            Transfer::create($transfer);
                            Log::info(json_encode($transfer));
                        }
                    }
                    // date fixtures
                    // $fixturesOnDay = \App\Models\Fixture::where('date_time', $fixtureDate)->get();

                    // foreach ($fixturesOnDay as $key => $f) {
                    //     foreach ($affectedPlayers as $key => $p) {
                    //         $fs = \App\Models\FixtureStats::where('fixture_id', $f->id)->where('player_id', $p)->first();
                    //         if($fs) {
                    //             info('Calling recalculate for fs ' . $fs->id);
                    //             \Artisan::call('recalculate:points', ['fixture_stats'=>$fs]);
                    //         }
                    //     }
                    // }

                    $deleteOldRecords = SupersubTeamPlayerContract::where('team_id', $team_id)
                                                    ->where('start_date', $fixtureDate)
                                                    ->update(['is_applied' => true]);

                    // info('$i');
                    // info($i);
                    Log::info('***** Updating Subsub Data Ends *****');
                }
            }
        }
    }
}
