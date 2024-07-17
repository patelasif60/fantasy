<?php

namespace App\Console\Commands;

use App\Models\PastWinnerHistory;
use Illuminate\Console\Command;

class importHalloffame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:halloffame';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for imprt halloffame from csv';

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
        $this->info('import started');
        $file = storage_path('HallOfFame1920Import.csv');
        $file = fopen($file, 'r');
        while (! feof($file)) {
            $data = fgetcsv($file);
            if ($data[0] == 'Season') {
                continue;
            }
            if ($data[0] == '') {
                break;
            }
            $year = explode('/', $data[0]);
            if ($year[0] > 19) {
                $data[0] = '19'.$year[0].' - 19'.$year[1];

                if ($year[1] == 0) {
                    $data[0] = '19'.$year[0].' - 2000';
                }
            } else {
                $data[0] = '20'.$year[0].' - 20'.$year[1];
            }
            $info = \DB::select("select id FROM seasons WHERE NAME='$data[0]' limit 1");
            if ($info) {
                foreach ($info as $infoKey => $infoValue) {
                    $leagueTitle = PastWinnerHistory::create([
                        'division_id' => $data[4],
                        'season_id' => $infoValue->id,
                        'name' => htmlspecialchars(strval($data[2])),
                    ]);
                }
            } else {
                echo $data[0].'==';
            }
        }
        $this->info('Done');
        fclose($file);
    }
}
