<?php

namespace App\Console\Commands;

use App\Events\Manager\Divisions\LeaguePaymentReminderEvent;
use App\Services\LeaguePaymentService;
use Illuminate\Console\Command;

class SendLeaguePaymentReminderEmail extends Command
{
    protected $service;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:payment_reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Send Payment Reminder for Unpaid Leagues - to the chairman/team managers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LeaguePaymentService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $unpaidTeams = $this->service->getUnpaidLeagues();

        $emailDetails = [];
        foreach ($unpaidTeams as $divisionTeam) {
            //fetching Details of unpaid teams
            $emailDetails[$divisionTeam->division->id]['division'] = $divisionTeam->division;
            $emailDetails[$divisionTeam->division->id]['recipients'][] = $divisionTeam->division->consumer->user->email;
            $emailDetails[$divisionTeam->division->id]['recipients'][] = $divisionTeam->team->consumer->user->email;
            $emailDetails[$divisionTeam->division->id]['paymentURL'] = route('manage.division.payment.teams', ['division' => $divisionTeam->division]);
        }

        foreach ($emailDetails as $emailDetail) {
            //Fire off Payment Reminder Email
            event(new LeaguePaymentReminderEvent($emailDetail));
        }

        echo 'Payment Reminder sent successfully!';
    }
}
