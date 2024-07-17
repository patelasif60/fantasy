<?php

namespace App\Console\Commands;

use App\Enums\UserStatusEnum;
use App\Mail\NewPlayer as MailNewPlayer;
use App\Models\Club;
use App\Models\Player;
use App\Models\PlayerContract;
use App\Models\Season;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Sdapi\Endpoints\SdapiSquads;
use Sdapi\SdapiClient;

class ImportPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:players {--initial}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import club players from Gracenote API';

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
        echo "Starting the Club's Player import from Gracenote\n";
        // if (!is_dir(storage_path('app/gracenote'))) {
        //     mkdir(storage_path('app/gracenote'), 0777, true);
        // }

        $playersPositionArray = [
            'Goalkeeper' => 'Goalkeeper (GK)',
            'FB' => 'Full-back (FB)',
            'Defender' => 'Centre-back (CB)',
            'Midfielder' => 'Midfielder (MF)',
            'Attacker' => 'Striker (ST)',
            'DFM' => 'Defensive Midfielder (DMF)',
        ];

        $latestSeason = Season::find(Season::getLatestSeason());
        $latestSeasonStartDate = $latestSeason->start_at;
        $latestSeasonEndDate = $latestSeason->end_at;

        $tournamentArray = [
            $latestSeason->premier_api_id => true,
            // $latestSeason->facup_api_id => true,
        ];
        $newPlayersAdded = [];

        $isPlayerExist = [];

        $client = new SdapiClient(config('fantasy.gracenote_outlet_auth_key'));
        $clubsQuery = new SdapiSquads($client);

        foreach ($tournamentArray as $tmcl => $isPremier) {
            $clubsResponse = $clubsQuery->getSquadsByTournament($tmcl, '', true);
            if ($clubsResponse->statusCode == 200) {
                foreach ($clubsResponse->squad as $premierClub) {
                    $club = Club::with('activePlayers')->where('api_id', $premierClub->contestantId)->first();

                    if (! isset($premierClub->person)) {
                        continue;
                    }

                    foreach ($premierClub->person as $player) {
                        /*
                                $player->active is checked instead of $player->status
                                because it will no create duplicate contract of same
                                players
                        */
                        //if ($player->type == 'player' && (strtolower($player->status) == 'active')) {
                        if ($player->type == 'player' && (strtolower($player->active) == 'yes')) {
                            $shortName = isset($player->firstName) ? mb_substr(trim($player->firstName), 0, 1).' '.explode(' ', $player->lastName)[0] : explode(' ', $player->lastName)[0];
                            
                            if (!in_array($player->id, $isPlayerExist)) {
                                array_push($isPlayerExist, $player->id);
                                $checkPlayer = Player::where('api_id', $player->id)->first();
                                if ($checkPlayer) {
                                    // $checkPlayer->first_name = removeAccents($player->firstName);
                                    // $checkPlayer->last_name = removeAccents($player->lastName);
                                    // $checkPlayer->match_name = removeAccents($player->matchName);
                                    // $checkPlayer->short_code = $shortName;
                                    // $checkPlayer->api_id = $player->id;
                                    // $checkPlayer->save();

                                    $activeContract = $club->activePlayers->where('id', $checkPlayer->id)->first();

                                    if (empty($activeContract)) { // IF Player does not have any active contract with the club, then check if the Player is having any active contract with other CLub. If there is an active contract with other club then end that contract. And finally crate a new player contract with this club. Carry forwared the Positoin of the Player from the last active contract to this new contract.
                                        $playerAciveContractWithDifferentClub = PlayerContract::where('player_id', $checkPlayer->id)->whereNull('end_date')->first();

                                        if (! isset($playersPositionArray[$player->position])) {
                                            info('Player position not found : '.$player->firstName.' '.$player->lastName);
                                            continue;
                                        }

                                        $playerContractNew = new PlayerContract();
                                        $playerContractNew->player_id = $checkPlayer->id;
                                        $playerContractNew->club_id = $club->id;
                                        $playerContractNew->position = $playersPositionArray[$player->position];

                                        if ($playerAciveContractWithDifferentClub) {
                                            $playerAciveContractWithDifferentClub->end_date = $this->option('initial') ? $latestSeasonStartDate : Carbon::now();
                                            $playerContractNew->position = $playerAciveContractWithDifferentClub->position;
                                            $playerAciveContractWithDifferentClub->save();
                                        }
                                        // $playerContractNew->is_active = (strtolower($player->status) == 'active') ? true : false;
                                        $playerContractNew->start_date = $this->option('initial') ? $latestSeasonStartDate : Carbon::now();
                                        $playerContractNew->save();

                                        $this->info($checkPlayer->first_name.' '.$checkPlayer->last_name);
                                        info('New Contract Created'.$checkPlayer->first_name.' '.$checkPlayer->last_name);

                                    } else { // Player has an active contract with this club. Then first check if this active contract is of current season. If yes then do nothing. If its not of current season, then close the current active contract and create the new contract for current season.
                                        $contractStartDate = Carbon::createFromFormat('Y-m-d', $activeContract->contract->start_date);
                                        if ($contractStartDate->between($latestSeasonStartDate, $latestSeasonEndDate)) { // Player Having active contract and its for current season.
                                        } else { // Player having active Contract for last season. so close that contract and create new contract of current season.
                                            $playerContract = PlayerContract::find($activeContract->contract->id);
                                            $playerContract->end_date = $latestSeasonStartDate;
                                            $playerContract->save();

                                            $playerContractNew = new PlayerContract();
                                            $playerContractNew->player_id = $checkPlayer->id;
                                            $playerContractNew->club_id = $club->id;
                                            $playerContractNew->position = $activeContract->contract->position;

                                            //On New season start and when first fiture is not played
                                            if(!$latestSeason->firstFixturePlayed()) {
                                                $playerContractNew->is_active = $playerContract->is_active;
                                            }
                                            // $playerContractNew->is_active = (strtolower($player->status) == 'active') ? true : false;
                                            // $playerContractNew->start_date = Carbon::now();
                                            $playerContractNew->start_date = $latestSeasonStartDate;

                                            $playerContractNew->save();

                                            $this->info($checkPlayer->first_name.' '.$checkPlayer->last_name);
                                            info('New Contract Created'.$checkPlayer->first_name.' '.$checkPlayer->last_name);
                                        }
                                    }
                                } else {
                                    if (! isset($playersPositionArray[$player->position])) {
                                        info('Player position not found : '.$player->firstName.' '.$player->lastName);
                                        continue;
                                    }

                                    $newPlayer = Player::firstOrNew(['api_id' => $player->id]);
                                    $newPlayer->first_name = isset($player->firstName) ? removeAccents($player->firstName) : null;
                                    $newPlayer->last_name = removeAccents($player->lastName);
                                    $newPlayer->match_name = removeAccents($player->matchName);
                                    // $newPlayer->short_code = $shortName;
                                    $newPlayer->api_id = $player->id;
                                    $newPlayer->save();

                                    $playerContractNew = new PlayerContract();
                                    $playerContractNew->player_id = $newPlayer->id;
                                    $playerContractNew->club_id = $club->id;
                                    $playerContractNew->position = $playersPositionArray[$player->position];
                                    // $playerContract->is_active = (strtolower($player->status) == 'active') ? true : false;
                                    $playerContractNew->is_active = false;
                                    // $playerContractNew->start_date = Carbon::now();
                                    $playerContractNew->start_date = $latestSeasonStartDate;

                                    $playerContractNew->save();

                                    $this->info($newPlayer->first_name.' '.$newPlayer->last_name);
                                    info('New Contract Created'.$newPlayer->first_name.' '.$newPlayer->last_name);

                                    array_push($newPlayersAdded, [
                                        'name' => $newPlayer->first_name.' '.$newPlayer->last_name,
                                        'club' => $club->name,
                                        'position' => $playersPositionArray[$player->position],
                                        'contract_start' => Carbon::now(),
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        if (! empty($newPlayersAdded)) {
            $adminUsers = User::superadmins()->where('status', UserStatusEnum::ACTIVE)->pluck('email', 'id')->toArray();
            Mail::to($adminUsers)->send(new MailNewPlayer($newPlayersAdded));
        }
        echo "Club's Player import from Gracenote imported Successfully\n";
    }
}
