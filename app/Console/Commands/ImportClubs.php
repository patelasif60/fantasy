<?php

namespace App\Console\Commands;

use App\Models\Club;
use App\Models\Season;
use Illuminate\Console\Command;
use Sdapi\Endpoints\SdapiSquads;
use Sdapi\SdapiClient;

class ImportClubs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clubs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import clubs from Gracenote API';

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
    /*public function handle()
    {
        echo "Starting the Club import from Gracenote\n";
        if (!is_dir(storage_path('app/gracenote'))) {
            mkdir(storage_path('app/gracenote'), 0777, true);
        }

        $latestSeason = Season::find(Season::getLatestSeason());

        $importFormat = "json";

        $clubImportURL = config('settings.gracenote_api_url') . "/" . config('settings.gracenote_outletauthkey') . "?_fmt=" . $importFormat . "&_rt=b&tmcl=" . $latestSeason->facup_api_id;
        echo "<pre>"; print_r($clubImportURL); exit;
        $filename = storage_path('app/gracenote/'.$latestSeason->facup_api_id.".json");
        file_put_contents($filename, file_get_contents($clubImportURL));

        $facupClubs = json_decode(file_get_contents($filename));
        foreach ($facupClubs->squad as $facupClub) {
            $club = Club::firstOrNew(['api_id' => $facupClub->contestantId]);
            $club->name = $facupClub->contestantClubName;
            $club->short_name = $facupClub->contestantShortName;
            $club->short_code = $facupClub->contestantCode;
            $club->is_premier = false;
            $club->api_id = $facupClub->contestantId;
            $club->save();
        }

        $clubImportURL = config('settings.gracenote_api_url') . "/" . config('settings.gracenote_outletauthkey') . "?_fmt=" . $importFormat . "&_rt=b&tmcl=" . $latestSeason->premier_api_id;
        $filename = storage_path('app/gracenote/'.$latestSeason->premier_api_id.".json");
        file_put_contents($filename, file_get_contents($clubImportURL));

        $premierClubs = json_decode(file_get_contents($filename));
        foreach ($premierClubs->squad as $premierClub) {
            $club = Club::firstOrNew(['api_id' => $premierClub->contestantId]);
            $club->name = $premierClub->contestantClubName;
            $club->short_name = $premierClub->contestantShortName;
            $club->short_code = $premierClub->contestantCode;
            $club->is_premier = true;
            $club->api_id = $premierClub->contestantId;
            $club->save();
        }
        echo "Club import from Gracenote imported Successfully\n";
    }*/

    public function handle()
    {
        echo "Starting the Club import from Gracenote\n";
        // if (!is_dir(storage_path('app/gracenote'))) {
        //     mkdir(storage_path('app/gracenote'), 0777, true);
        // }

        $latestSeason = Season::find(Season::getLatestSeason());
        $tournamentArray = [
            $latestSeason->facup_api_id => false,
            $latestSeason->premier_api_id => true,
        ];

        $client = new SdapiClient(config('fantasy.gracenote_outlet_auth_key'));
        $clubsQuery = new SdapiSquads($client);

        foreach ($tournamentArray as $tmcl => $isPremier) {
            $clubsResponse = $clubsQuery->getSquadsByTournament($tmcl);
            if ($clubsResponse->statusCode == 200) {
                foreach ($clubsResponse->squad as $squad) {
                    if (! isset($squad->contestantCode)) {
                        info('Not Created Club : '.$squad->contestantClubName);
                        continue;
                    }

                    $this->info($squad->contestantClubName);

                    $club = Club::firstOrNew(['api_id' => $squad->contestantId]);
                    if (! $club->exists) {
                        $club->name = $squad->contestantClubName;
                        $club->short_name = $squad->contestantShortName;
                        $club->short_code = $squad->contestantCode;
                    }

                    $club->is_premier = $isPremier;
                    $club->api_id = $squad->contestantId;
                    $club->save();
                }
            }

            /*
             * When processing for premier league, mark all clubs in response as premier league clubs
             * and all other clubs as non-premier clubs.
             */

            if ($isPremier) {
                $premierClubs = array_pluck($clubsResponse->squad, 'contestantId');
                Club::whereIn('api_id', $premierClubs)->update(['is_premier' => 1]);
                Club::whereNotIn('api_id', $premierClubs)->update(['is_premier' => 0]);
            }
        }
        echo "Club import from Gracenote imported Successfully\n";
    }
}
