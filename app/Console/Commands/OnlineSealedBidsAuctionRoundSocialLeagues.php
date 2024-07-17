<?php

namespace App\Console\Commands;

use App\Services\AuctionRoundService;
use App\Services\AuctionService;
use App\Services\OnlineSealedBidService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OnlineSealedBidsAuctionRoundSocialLeagues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online-sealed-bids:auction-start-social-league';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Online Sealed for social leagues auction start and add first round';

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
        $addHours = 72;
        $paidTeam = 5;
        $roundNumber = 1;

        $service = app(OnlineSealedBidService::class);
        $auctionRoundService = app(AuctionRoundService::class);
        $auctionService = app(AuctionService::class);
        $divisions = $service->getSocialLeagues();

        $friday = now()->format('D') === 'Fri' ? now()->endOfDay() : Carbon::parse('next friday')->endOfDay();
        $start = clone $friday;
        $end = $friday->addHours($addHours)->endOfDay();

        $this->info('Social league round and auction start process start.');

        foreach ($divisions as $division) {
            $isPaid = $division->divisionTeams()->Approve()->whereNotNull('payment_id')->count();

            $this->info('Found Paid Teams '.$isPaid);

            if ($isPaid >= $paidTeam) {
                $update = $auctionService->startAuction($division, $start);

                $data = [];
                $data['start'] = $start;
                $data['end'] = $end;
                $data['number'] = $roundNumber;
                $auctionRoundService->create($division, $data);

                $this->info('Round created for league '.$division->id.' .');
            }
        }

        $this->info('Social league round and auction start process end.');
    }
}
