<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TiePreferenceBugForOneLeagueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tiePreference:revers-for-one-league';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time command for solve the tiePreference for one league';

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
        $this->info('Start Process : '.now());

        $division = \App\Models\Division::find(585);
        $teams = $division->divisionTeamsCurrentSeason()->approve()->get();
        $data = $teams->pluck('pivot.team_id')->toArray();

        $this->info('Found Team Ids : '.implode(',', $data));

        $roundOne = $division->transferRounds->where('number', 1)->first();
        $roundSix = $division->transferRounds->where('number', 6)->first();

        if (! $roundSix) {
            $this->info('Please create round 6.');

            return;
        }

        $tiePreferenceData = \App\Models\TransferTiePreference::whereIn('team_id', $data)
                                ->where('transfer_rounds_id', $roundOne->id)
                                ->orderByRaw('cast(number as unsigned) asc')
                                ->get();

        $this->info('Found Tie Preference : '.count($tiePreferenceData));

        $count = count($tiePreferenceData);
        $teamData = [];
        if ($count > 0) {
            foreach ($tiePreferenceData as $value) {
                $teamData[$value->team_id] = $count;
                $count--;
            }
        }

        print_r($teamData);
        $this->info('Set teams in order for tie preference : '.implode(',', $teamData));

        $transferTiePreferenceRepository = app(\App\Repositories\TransferTiePreferenceRepository::class);
        $transferTiePreferenceRepository->delete($data, $roundSix);
        $transferTiePreferenceRepository->create($teamData, $roundSix);

        $this->info('End Process : '.now());
    }
}
