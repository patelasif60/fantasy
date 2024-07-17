<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Season;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class SeasonRolloverCopySeasonData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollover:season-copy {--D|date= : Date for which season date end and start. Format (YYYY-mm-dd)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Season copy from old season to new season';

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
        $this->info('Create new season '.now());
        // $gracenote_outlet_auth_key = config('fantasy.gracenote_outlet_auth_key');
        $tournamentCalendarUrl = "http://api.performfeeds.com/soccerdata/tournamentcalendar/1vmmaetzoxkgg1qf6pkpfmku0k?_fmt=json&_rt=b";
        $tournamentCalendar = json_decode(file_get_contents($tournamentCalendarUrl));
        $tournamentCalendar = collect($tournamentCalendar->competition);

        $faCup = $tournamentCalendar->where('id','2hj3286pqov1g1g59k2t2qcgm')->first();
        $premierLeague = $tournamentCalendar->where('id','2kwbbcootiqqgmrzs6o5inle5')->first();
        $premierLeague = $premierLeague->tournamentCalendar[0];
        $faCup = $faCup->tournamentCalendar[0];

        //Current season end date and new season start date
        $dateFormat = config('fantasy.db.datetime.format');
        if($this->option('date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $this->option('date'),'UTC');
        } else {
            $startDate = Carbon::createFromFormat('Y-m-d\Z', $premierLeague->startDate, 'UTC');
        }
        $endDate = Carbon::createFromFormat('Y-m-d\Z', $premierLeague->endDate, 'UTC');
        
        $currentSeasonEndDate = $startDate->copy()->subDays(1);

        $packages = Package::where('is_enabled', 'Yes')->get();
        $season = Season::find(Season::getLatestSeason());
        
        $newSeason = $season->replicate();
        $newSeason->name = Str::replaceFirst('/', ' - ', $premierLeague->name);
        $newSeason->premier_api_id = $premierLeague->id;
        $newSeason->facup_api_id = $faCup->id;
        $newSeason->start_at = $startDate->format($dateFormat);
        $newSeason->end_at = $endDate->format($dateFormat);
        $newSeason->default_package = $packages->where('display_name','Novice')->first()->id;
        $newSeason->default_package_for_existing_user = $packages->where('display_name','Legend')->first()->id;
        $newSeason->available_packages = $packages->pluck('id');
        $newSeason->save();

        //Current season update
        $season->end_at = $currentSeasonEndDate->format($dateFormat);
        $season->save();

        $this->info('Season : '.$newSeason->name);
        $this->info('New Season created '.now());
    }
}
