<?php

namespace App\Console\Commands;

use App\Models\Division;
use Illuminate\Console\Command;

class SealBidTransferRoundProcessBugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sealbid:transfer-round-process-bug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time command for sealbid transfer round issue solve due to log file permission';

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
        $divisions = Division::join('transfer_rounds', 'transfer_rounds.division_id', '=', 'divisions.id')
            ->where('divisions.is_round_process', true)
            ->where('transfer_rounds.is_process', 'U')
            ->select('divisions.*')
            ->get();

        $this->info('Process Start '.now());

        $this->info('Total Affected Divisions => '.$divisions->count());

        foreach ($divisions as $division) {
            $division->update(['is_round_process' => false]);

            $this->info('Updated division '.$division->id);
        }

        $this->info('Process End '.now());
    }
}
