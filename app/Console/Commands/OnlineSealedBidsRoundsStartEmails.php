<?php

namespace App\Console\Commands;

use App\Jobs\RoundStartPushNotification;
use App\Mail\Manager\OnlineSealedBid\RoundStartEmail;
use App\Services\OnlineSealedBidService;
use Illuminate\Console\Command;
use Mail;

class OnlineSealedBidsRoundsStartEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online-sealed-bids:round-start-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Online Sealed Bids Rounds Start Emails';

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
        $start = now();
        $this->info("Online sealed bids rounds start on $start");
        $service = app(OnlineSealedBidService::class);
        $divisionTeams = $service->getRoundStartTeams($start);

        foreach ($divisionTeams as $team) {
            $this->info("Email Send to $team->email on $start");

            RoundStartPushNotification::dispatch($team);

            Mail::to($team->email)->send(new RoundStartEmail($team));
        }

        $this->info('Online sealed bids round email send process end');
    }
}
