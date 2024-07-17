<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonthlyQuotaReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:quota_reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly quota reset.';

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
        \App\Models\Team::where('is_approved', 1)->update(['monthly_quota_used'=>0]);
    }
}
