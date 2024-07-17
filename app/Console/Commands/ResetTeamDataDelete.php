<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetTeamDataDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugfix:reset-delete-transfer-data';

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
        // dd(storage_path());
        $file = storage_path('after-auction-delete-transfer-data.csv');
        $file = fopen($file, 'r');
        while (! feof($file)) {
            $data = fgetcsv($file);
            if ($data[2] == 'RESET') {
                $createAt = \DB::select("select team_player_contracts.`created_at` from team_player_contracts where team_id=$data[0] AND end_date IS NULL LIMIT 1");
                foreach ($createAt as $key => $createDate) {
                    $date = $createDate->created_at;
                }
                $delete = \DB::select("delete from transfers where team_id = $data[0] AND transfer_type<>'auction' AND transfer_date < '".$date."'");
            }
        }
        fclose($file);
    }
}
