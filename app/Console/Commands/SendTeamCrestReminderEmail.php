<?php

namespace App\Console\Commands;

use App\Events\Admin\TeamCrestUploadReminderEvent;
use App\Services\TeamService;
use App\Services\UserService;
use Illuminate\Console\Command;

class SendTeamCrestReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:crest_uploaded_reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Send Reminder to CMS admins that team crests have been created and moderation is required';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TeamService $service, UserService $userService)
    {
        parent::__construct();
        $this->service = $service;
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = $this->userService->getActiveAdmins()->pluck('email', 'id');
        $newTeams = $this->service->getLatestTeamCrests();

        if ($newTeams->count() > 0) {
            $emailDetails['teams'] = $newTeams;

            foreach ($users as $user) {
                //Fire off Crest Upload Reminder Email
                event(new TeamCrestUploadReminderEvent($user, $emailDetails));
            }
        } else {
            echo "No New Teams Created today!\n";
        }
    }
}
