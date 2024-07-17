<?php

namespace App\Providers;

use App\Events\Admin\TeamCrestUploadReminderEvent;
use App\Events\Manager\Divisions\LeagueInvitationSMSToManager;
use App\Events\Manager\Divisions\LeagueInvitationToManager;
use App\Events\Manager\Divisions\LeagueJoinEvent;
use App\Events\Manager\Divisions\LeaguePaymentReminderEvent;
use App\Events\Manager\Divisions\LeagueTeamsPaymentEvent;
use App\Events\Manager\Divisions\TeamApprovalEvent;
use App\Events\Manager\Divisions\TeamIgnoreEvent;
use App\Events\NewAdminUserInvited;
use App\Listeners\Admin\SendTeamCrestUploadReminder;
use App\Listeners\Manager\Divisions\LeagueJoinListener;
use App\Listeners\Manager\Divisions\SendLeagueInvitationSMSToManager;
use App\Listeners\Manager\Divisions\SendLeagueInvitationToManager;
use App\Listeners\Manager\Divisions\SendLeaguePaymentReceipt;
use App\Listeners\Manager\Divisions\SendLeaguePaymentReminder;
use App\Listeners\Manager\Divisions\TeamApprovalListener;
use App\Listeners\Manager\Divisions\TeamIgnoreListener;
use App\Listeners\SendAdminUserInvitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewAdminUserInvited::class => [
            SendAdminUserInvitation::class,
        ],
        LeagueInvitationToManager::class => [
            SendLeagueInvitationToManager::class,
        ],
        LeagueInvitationSMSToManager::class => [
            SendLeagueInvitationSMSToManager::class,
        ],
        TeamApprovalEvent::class => [
            TeamApprovalListener::class,
        ],
        TeamIgnoreEvent::class => [
            TeamIgnoreListener::class,
        ],
        LeagueJoinEvent::class => [
            LeagueJoinListener::class,
        ],
        LeagueTeamsPaymentEvent::class => [
            SendLeaguePaymentReceipt::class,
        ],
        LeaguePaymentReminderEvent::class => [
            SendLeaguePaymentReminder::class,
        ],
        TeamCrestUploadReminderEvent::class => [
            SendTeamCrestUploadReminder::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
