<?php

namespace App\Console\Commands;

use App\Models\TeamPlayerContract;
use DB;
use Illuminate\Console\Command;

class FixPlayerContracts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugfix:player-contracts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Single run command to fix incorrect player contracts';

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
        $records = DB::select('select team_id, player_id, count(*) as c from team_player_contracts group by team_id, player_id having c > 2 order by c desc, team_id, player_id');

        foreach ($records as $record) {
            // fetch team_player_contracts for these
            $contracts = TeamPlayerContract::where('team_id', $record->team_id)
                ->where('player_id', $record->player_id)
                ->orderBy('created_at')
                ->get();

            foreach ($contracts as $contract) {
                // delete future start date
                if ($contract->start_date > now()) {
                    $contract->delete();
                }
            }

            $contracts = TeamPlayerContract::where('team_id', $record->team_id)
                ->where('player_id', $record->player_id)
                ->orderBy('created_at')
                ->get();

            $previous = null;
            for ($i = 0; $i < count($contracts); $i++) {
                if ($i === 0) {
                    continue;
                }

                if (($contracts[$i - 1])->end_date == null) {
                    continue;
                }

                ($contracts[$i - 1])->update([
                    'end_date' => ($contracts[$i])->start_date,
                ]);
            }
        }
    }
}
