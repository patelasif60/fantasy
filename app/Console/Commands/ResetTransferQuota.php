<?php

namespace App\Console\Commands;

use App\Models\Team;
use Illuminate\Console\Command;

class ResetTransferQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugfix:reset-transfer-quota';

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
        $teams = \DB::select('select team_id, division_id from teams inner join division_teams dt on dt.team_id = teams.id and dt.season_id = 30 inner join divisions d on d.id = dt.`division_id` where teams.is_approved = 1');
        foreach ($teams as $key => $team_id) {
            // $team_id->team_id=1617;
            //$team_id->division_id=223;
            $team = \App\Models\Team::find($team_id->team_id);
            if (! $team) {
                continue;
            }
            $division = \App\Models\Division::find($team_id->division_id);
            $free_agent_transfer_after = $division->getOptionValue('free_agent_transfer_after');
            $dateOfTransfer = $division->getOptionValue('auction_closing_date');
            if ($dateOfTransfer == null) {
                continue;
            }
            if ($free_agent_transfer_after == 'seasonStart') {
                $currentSeason = \App\Models\Season::find(\App\Models\Season::getLatestSeason());
                $dateOfTransfer = $currentSeason['start_at'];
            }
            $seasonCount = \App\Models\Transfer::WHERE('team_id', $team_id->team_id)->whereIn('transfer_type', ['transfer', 'sealedbids', 'swapdeal'])->where('transfer_date', '>', $dateOfTransfer)->get()->count(); //->select(\DB::raw('COUNT(id) AS  `transfersCount`'))->get()->first();
            $monthlyCount = \App\Models\Transfer::WHERE('team_id', $team_id->team_id)->whereIn('transfer_type', ['transfer', 'sealedbids', 'swapdeal'])->whereRaw('MONTH(transfer_date)= MONTH(CURRENT_DATE())')->get()->count();
            // dd($monthlyCount);
            // if($seasonCount > $division->getOptionValue('season_free_agent_transfer_limit')){
            //     $seasonCoun = $division->getOptionValue('season_free_agent_transfer_limit');
            // }
            //  if($monthlyCount > $division->getOptionValue('monthly_free_agent_transfer_limit')){
            //     $monthlyCount = $division->getOptionValue('monthly_free_agent_transfer_limit');
            // }
            // dd($monthlyCount);
            \App\Models\Team::where('id', $team_id->team_id)->update(['season_quota_used'=>$seasonCount, 'monthly_quota_used'=>$monthlyCount]);
        }
    }
}
