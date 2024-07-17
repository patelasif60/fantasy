<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('clean:models')->daily();

        $schedule->command('import:fixtures')->hourlyAt(05);
        $schedule->command('import:players')->hourlyAt(10);
        $schedule->command('import:fixture-stats --frequency=M')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('import:fixture-stats --frequency=H')->hourlyAt(15);
        $schedule->command('import:fixture-stats --frequency=D')->dailyAt('01:00');
        $schedule->command('report:invalid-formation-teams')->dailyAt('02:30');
        $schedule->command('report:invalid-supersub-teams')->dailyAt('03:00');
        //$schedule->command('send:crest_uploaded_reminder')->dailyAt('18:00');
        $schedule->command('update:supersub-to-lineup')->everyMinute()->withoutOverlapping();

        $schedule->command('customcupfixtures:generate')->dailyAt('01:00');
        $schedule->command('customcupfixtures:update')->dailyAt('01:05');
        $schedule->command('customcupfixtures:generate-next')->dailyAt('01:10');

        // $schedule->command('procupfixtures:generate-initial');
        //$schedule->command('procupfixtures:update')->dailyAt('01:00');
        //$schedule->command('procupfixtures:generate-next')->dailyAt('01:00');

        $schedule->command('championeuropa:generate-teams')->daily();
        $schedule->command('championeuropa:generate-fixtures')->daily();
        $schedule->command('championeuropa:update')->dailyAt('03:15');

        //$schedule->command('online-sealed-bids:round-start-email')->everyMinute();
        //$schedule->command('online-sealed-bids:process-round')->everyMinute();
        //$schedule->command('online-sealed-bids:deadline-approach-email')->everyMinute();
        //$schedule->command('online-sealed-bids:process-transfers-round')->everyMinute();
        $schedule->command('playerpoints:calculation')->dailyAt('04:00');
        $schedule->command('monthly:quota_reset')->monthlyOn(1, '00:00');

        $schedule->command('head-to-head-fixtures:update')->dailyAt('12:05');
        $schedule->command('calculate:team-ranking-points')->daily();

        $schedule->command('check:cmd-settings')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
