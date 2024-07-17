<?php

namespace App\Console\Commands;

use App\Models\Division;
use App\Models\Package;
use Illuminate\Console\Command;

class SealBidDeadlineRepeatUpdateInDivision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:seal-bid-deadline-repeat-in-divisions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time update seal_bid_deadline_repeat in division table do not run next time';

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
        $this->info('Start update proccess '.now());
        $package = Package::find(5);

        $this->info('Package id '.$package->id);
        $this->info('Package name '.$package->name);

        Division::where('package_id', $package->id)
                ->whereNotNull('auction_date')
                ->update(['seal_bid_deadline_repeat' => null]);

        $this->info('End update proccess '.now());
    }
}
