<?php

namespace App\Jobs;

use App\Repositories\SeasonRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RolloverLeaguesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var season
     */
    protected $season;

    /**
     * @var data
     */
    protected $data;

    public function __construct($season, $data)
    {
        $this->season = $season;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $seasonRepository = app(SeasonRepository::class);
        $seasonRepository->rollover($this->season, $this->data);
    }
}
