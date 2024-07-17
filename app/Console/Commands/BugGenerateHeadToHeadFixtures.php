<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Models\Division;
use App\Models\DivisionTeam;
use Illuminate\Console\Command;
use App\Services\DivisionService;
use App\Models\HeadToHeadFixture;
use App\Models\HeadToHeadCalendar;
use Illuminate\Support\Facades\DB;

class BugGenerateHeadToHeadFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bug-head-to-head-fixtures-initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time bug command';

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
        $divisionTeams = DivisionTeam::where('division_id', 4576)->get();

        foreach ($divisionTeams as $team) {
            $team->number = null;
            $team->save();
        }
        
        HeadToHeadFixture::whereIn('home_team_id', $divisionTeams->pluck('team_id')->toArray())->orwhereIn('away_team_id', $divisionTeams->pluck('team_id')->toArray())->delete();

    }
}
