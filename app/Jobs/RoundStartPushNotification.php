<?php

namespace App\Jobs;

use App\Services\NotificationService;
use Fcm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RoundStartPushNotification implements ShouldQueue
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
    protected $team;

    public function __construct($team)
    {
        $this->team = $team;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Push Notifications :', ['status' => 'In']);

        $status = fcm()
            ->to($this->team->push_registration_id)
            ->data([
                'message' => 'Your league round is start now',
                'time' => $this->team->start,
            ])
                ->notification([
                    'title' => 'Your league round is start now',
                    'body' => 'Your league round is start now',
                ])
                ->send();

        info('Push notification registration id : ', ['ids' => $this->team->push_registration_id]);

        info('Push Notifications :', ['response' => json_decode(json_encode($status), true)]);

        return $status;
    }
}
