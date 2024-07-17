<?php

namespace App\Jobs;

use Artisan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TeamPointsRecalculateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fixtureStat;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fixtureStat)
    {
        $this->fixtureStat = $fixtureStat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Team Point Recalculate points start');

        if ($this->fixtureStat) {
            Artisan::call('recalculate:points', ['fixture_stats'=> $this->fixtureStat]);
        }

        info('Team Point Recalculate points end');
    }
}
