<?php

namespace App\Console\Commands;

use App\Models\TransferRound;
use Illuminate\Console\Command;

class TransferRoundsNumberDuplicate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer-round:number-duplicate-bug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time command for transfer round bug';

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
        $this->info('Transfer round bug process start '.now());
        $rounds = TransferRound::select('number', 'division_id', \DB::raw('COUNT(*) as c'))
                ->groupBy('number')
                ->groupBy('division_id')
                ->havingRaw('c > ?', [1])
                ->get();

        foreach ($rounds as $round) {
            $innerRounds = TransferRound::where('division_id', $round->division_id)->get();
            $cnt = 1;
            foreach ($innerRounds as $iRpounds) {
                $this->info('Old Round number '.$iRpounds->number);

                $iRpounds->fill([
                    'number' => $cnt,
                ]);
                $cnt++;
                $iRpounds->save();

                $this->info('New Round number '.$iRpounds->number);

                $this->info('Updated round id '.$iRpounds->id);
            }
        }

        $this->info('Transfer round bug process end '.now());
    }
}
