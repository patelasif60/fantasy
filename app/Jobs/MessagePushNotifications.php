<?php

namespace App\Jobs;

use App\Models\Division;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MessagePushNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * @var NotificationService
     */
    protected $division;
    protected $divisionManagers;
    protected $user;
    protected $chat;

    public function __construct(Division $division, User $user, $divisionManagers, $chat)
    {
        $this->division = $division;
        $this->divisionManagers = $divisionManagers;
        $this->user = $user;
        $this->chat = $chat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationService = app(NotificationService::class);
        $notificationService->notification($this->division, $this->divisionManagers, $this->user, $this->chat);
    }
}
