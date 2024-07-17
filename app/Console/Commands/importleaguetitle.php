<?php

namespace App\Console\Commands;

use App\Models\LeagueTitle;
use Illuminate\Console\Command;

class importleaguetitle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:league-titles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for imprt league titile from csv';

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
        $file = storage_path('LeagueTitlesImporrt.csv');
        $file = fopen($file, 'r');
        //$handle =  storage_path('clubnotfound.csv');
        // $handle =  fopen($handle, 'w');
        while (! feof($file)) {
            $data = fgetcsv($file);
            if ($data[0] == 'Email') {
                continue;
            }
            if ($data[0] == '') {
                break;
            }
            $info = \DB::select("select teams.`id` as teamId,consumers.id as managerId FROM users INNER JOIN consumers ON users.`id`=consumers.`user_id` INNER JOIN teams ON teams.`manager_id`= consumers.`id` INNER JOIN division_teams ON division_teams.`team_id` = teams.`id`
                WHERE users.email='$data[0]' AND division_teams.`division_id` =$data[2]");
            if ($info) {
                foreach ($info as $infoKey => $infoValue) {
                    $leagueTitle = LeagueTitle::create([
                        'division_id' => $data[3],
                        'team_id' => $infoValue->teamId,
                        'manager_id' => $infoValue->managerId,
                        'titles' => $data[4],
                        'name'=> htmlspecialchars(strval($data[1])),
                    ]);
                    break;
                }
            } else {
                $leagueTitle = LeagueTitle::create([
                    'division_id' => $data[3],
                    'titles' => $data[4],
                    'name'=> htmlspecialchars(strval($data[1])),
                ]);
            }
        }
        $this->info('Done');
        fclose($file);
    }
}
