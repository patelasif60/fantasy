<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Models\Division;
use App\Models\DivisionTeam;
use Illuminate\Console\Command;

class AllocateNumbersToTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allocate:numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allocate random numbers to teams within league useful for fixture generation.';

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
        ini_set('memory_limit', '-1');
        
        $divisionsIds = DivisionTeam::where('season_id', Season::getLatestSeason())
                        ->groupBy('division_id')
                        ->pluck('division_id')
                        ->toArray();

        $divisions = Division::with('divisionTeamsCurrentSeason.divisionTeam')->whereIn('id',$divisionsIds)->get();

        $divisions->each(function ($division) {
            $this->info('id '.$division->id);
            $teams = $division->divisionTeamsCurrentSeason()->approve()->inRandomOrder();
            $this->info('count '.$teams->count());

            $allocatedNumbers = $teams->pluck('number')->filter();
            $numbers = collect(range(1, $teams->count()));
            $availableNumbers = $numbers->diff($allocatedNumbers);

            $teams->each(function ($team) use (&$availableNumbers) {
                if (is_null($team->divisionTeam->number)) {
                    info($team->id);
                    info($team->divisionTeam->number);
                    $team->divisionTeam->update([
                        'number' => $availableNumbers->shift(),
                    ]);
                }
            });
        });

        $this->info('Done');
    }
}
