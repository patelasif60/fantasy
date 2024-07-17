<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteTransferDuplicateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugfix:delete-transfer-duplicate-data';

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
        $transfer = \DB::select('select GROUP_CONCAT(id) as ids,team_id,player_in,COUNT(*) AS c FROM transfers WHERE transfers.`transfer_type`="transfer" GROUP BY team_id ,DATE_FORMAT(transfers.`transfer_date`,"%Y-%m-%d %H:%i:%S"),player_in HAVING c > 1');
        foreach ($transfer as $transferKey => $transferValue) {
            //dd(count(explode(",",$transferValue->ids)));
            $dublicatDataId = (explode(',', $transferValue->ids));
            array_pop($dublicatDataId);
            $seasonCount = \App\Models\Transfer::whereIn('id', $dublicatDataId)->delete();
        }
        $transfer = \DB::select('select GROUP_CONCAT(id) as ids,team_id,player_out,COUNT(*) AS c FROM transfers WHERE transfers.`transfer_type`="transfer" GROUP BY team_id ,DATE_FORMAT(transfers.`transfer_date`,"%Y-%m-%d %H:%i:%S"),player_out HAVING c > 1');
        foreach ($transfer as $transferKey => $transferValue) {
            //dd(count(explode(",",$transferValue->ids)));
            $dublicatDataId = (explode(',', $transferValue->ids));
            array_pop($dublicatDataId);
            $seasonCount = \App\Models\Transfer::whereIn('id', $dublicatDataId)->delete();
        }
        $transfer = \DB::select('select GROUP_CONCAT(id) as ids,team_id,player_in,player_out,COUNT(*) AS c FROM transfers WHERE transfers.`transfer_type`="transfer" GROUP BY team_id ,DATE_FORMAT(transfers.`transfer_date`,"%Y-%m-%d %H:%i"),player_in,player_out HAVING c > 1');
        foreach ($transfer as $transferKey => $transferValue) {
            //dd(count(explode(",",$transferValue->ids)));
            $dublicatDataId = (explode(',', $transferValue->ids));
            array_pop($dublicatDataId);
            $seasonCount = \App\Models\Transfer::whereIn('id', $dublicatDataId)->delete();
        }
    }
}
