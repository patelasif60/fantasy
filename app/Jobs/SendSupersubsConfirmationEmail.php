<?php

namespace App\Jobs;

use App\Mail\Manager\Divisions\SupersubsConfirmationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSupersubsConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $team;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($team, $data)
    {
        $this->team = $team;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->team->consumer->user->email)
            ->send(new SupersubsConfirmationEmail($this->team, $this->data));
    }
}
