<?php

namespace App\Console\Commands;

use App\Models\HistoryStats;
use Illuminate\Console\Command;

class importHistoryStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:history-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for imprt history stats from csv';

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
        // Ticket #388 - https://aecordigital.assembla.com/spaces/dCII6i2fer6ivXaIC_Qgzw/tickets/388/details?comment=1668635443
        // Ticket #1465 - https://aecordigital.assembla.com/spaces/dCII6i2fer6ivXaIC_Qgzw/tickets/1465/details?comment=1680685831

        $this->info('import started');
        $file = storage_path('Season1920PlayerStats.csv');
        $file = fopen($file, 'r');
        $handle = storage_path('clubnotfound.csv');
        $handle = fopen($handle, 'w');
        $count = 1;
        while (! feof($file)) {
            $data = fgetcsv($file);
            if ($data[0] == 'Code') {
                continue;
            }
            if ($data[0] == '') {
                break;
            }
            $data[3] = str_replace('/', ' - 20', $data[3]);
            $count++;

            $info = \DB::select("select players.id as pid,seasons.`id` as sid,clubs.`id` as cid FROM players,seasons,clubs WHERE players.`short_code`=$data[0] AND seasons.name='$data[3]' AND clubs.`short_name` like '%$data[2]%'");
            if ($info) {
                foreach ($info as $infoKey => $infoValue) {
                    $leagueTitle = HistoryStats::create([
                        'season_id' => $infoValue->sid,
                        'club_id' =>$infoValue->cid,
                        'player_id' =>$infoValue->pid,
                        'played' =>$data[4],
                        'appearance' => $data[5],
                        'goal' => $data[6],
                        'assist' => $data[7],
                        'clean_sheet' => $data[8],
                        'goal_conceded' => $data[9],
                        'total' => $data[10],
                    ]);
                    break;
                }
            } else {
                $info = \DB::select("select players.id as pid FROM players WHERE players.`short_code`=$data[0]");
                if (! $info) {
                    //    echo $count.', '.$data[1].', '.$data[0].',';
                }
                $info = \DB::select("select id FROM seasons WHERE seasons.name='$data[3]'");
                if (! $info) {
                    //  echo $count.',seasons,';
                }
                $info = \DB::select("select id FROM clubs WHERE clubs.`short_name` like '%$data[2]%'");
                if (! $info) {
                    //echo $count.', '.$data[2];

                    fputcsv($handle, [$count, $data[2]]);
                }
            }
        }
        $this->info('Done');
        fclose($file);
    }
}
