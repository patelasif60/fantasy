<?php

namespace App\Console\Commands;

use App\Models\LeagueTitle;
use Illuminate\Console\Command;
use App\Models\PastWinnerHistory;

class HallOfFameBugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:league-title-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time command for hall of fame issue';

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
        $this->info('Start '.now());

        ini_set('memory_limit', '-1');

        $pastWinnerHistorys = PastWinnerHistory::all();

        foreach ($pastWinnerHistorys->groupBy('division_id') as $pastWinnerHistory) {

            foreach ($pastWinnerHistory->groupBy('name') as $value) {
                $record = $value->first();
                $titles = LeagueTitle::where('division_id', $record->division_id)->where('name', $record->name)->get();

                $this->info('League Title Manager name '.$record->name.' Division id '.$record->division_id);

                if($titles->count()) {
                    $i = 0;
                    foreach ($titles as $title) {
                        if($i == 0) {
                            $title->titles = $value->count();
                            $title->save();
                        } else {
                            info($title);
                            $title->delete();
                        }
                        $i++;
                    }
                } else {
                    $create = LeagueTitle::create([
                        'division_id' => $record->division_id,
                        'titles' => 1,
                        'name'=> $record->name,
                    ]);
                }
            }
        }

        $this->info('End '.now());
    }
}
