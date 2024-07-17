<?php

namespace App\Console\Commands;

use App\Jobs\OnlineSealedBidsDeadlineApproachingEmail;
use App\Models\AuctionRound;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class OnlineSealedBidsDeadlineApproaching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online-sealed-bids:deadline-approach-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Online Sealed Bids Deadline Approach Emails';

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
        $this->info('Check Online Sealed Bids Round about to finish');

        $auctionRound = AuctionRound::where('end', Carbon::now()->addHour()->format(config('fantasy.db.datetime.format')))->get();

        if ($auctionRound->count()) {
            $this->info('Online Sealed Bids Deadline Approach Emails Start');
            OnlineSealedBidsDeadlineApproachingEmail::dispatch($auctionRound);
        } else {
            $this->info('No rounds Found');
        }
    }
}
