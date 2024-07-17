<?php

use App\Models\Club;
use App\Models\Division;
use App\Models\Season;
use App\Models\TeamPlayerContract;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TeamPlayerContractSeeder extends Seeder
{
    protected $clubs;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = Division::all();
        $formations = [[4, 4, 2], [4, 5, 1], [4, 3, 3], [5, 3, 2], [5, 4, 1]];
        $season = Season::find(Season::getLatestSeason());
        $start = $season->start_at->startOfMonth();

        foreach ($divisions as $division) {
            $this->clubs = Club::premier()->with('activePlayers.playerContract')->get();
            $teams = $division->divisionTeamsCurrentSeason()->approve()->get();

            // Remove already exisiting players in the league.
            $alreadyExistingPlayersIds = $teams->pluck('teamPlayerContracts')->flatten()->pluck('player_id')->all();
            $this->removePlayersById($alreadyExistingPlayersIds);
            $mergeDefenders = $division->getOptionValue('merge_defenders');

            foreach ($teams as $team) {
                // Skip if team already has players
                if ($team->teamPlayerContracts()->count()) {
                    continue;
                }

                // create starting line-up
                $players = collect([]);
                $formation = Arr::flatten(Arr::random($formations, 1));

                $players->push($this->getRandomPlayersByPosition('Goalkeeper (GK)', 1, $players));
                // Defenders
                if ($mergeDefenders === 'Yes') {
                    $cb = rand(0, $formation[0]);
                    $fb = $formation[0] - $cb;

                    if ($cb) {
                        $players->push($this->getRandomPlayersByPosition('Centre-back (CB)', $cb, $players));
                    }

                    if ($fb) {
                        $players->push($this->getRandomPlayersByPosition('Full-back (FB)', $fb, $players));
                    }
                } else {
                    $players->push($this->getRandomPlayersByPosition('Centre-back (CB)', $formation[0] - 2, $players));
                    $players->push($this->getRandomPlayersByPosition('Full-back (FB)', 2, $players));
                }
                // Midfield
                $dmf = rand(0, 1);
                $mf = $formation[1] - $dmf;
                if ($dmf) {
                    $players->push($this->getRandomPlayersByPosition('Defensive Midfielder (DMF)', $dmf, $players));
                }
                if ($mf) {
                    $players->push($this->getRandomPlayersByPosition('Midfielder (MF)', $mf, $players));
                }
                // Strikers
                $players->push($this->getRandomPlayersByPosition('Striker (ST)', $formation[2], $players));
                $players = $players->flatten();

                $players->each(function ($player) use ($team, $start) {
                    TeamPlayerContract::create([
                        'team_id' => $team->id,
                        'player_id' => $player->id,
                        'is_active'=> true,
                        'start_date'=> $start,
                    ]);
                });

                // create bench
                $bench = collect([]);
                $bench->push($this->getRandomPlayersByPosition('Goalkeeper (GK)', 1, $bench));
                $bench->push($this->getRandomPlayersByPosition('Centre-back (CB)', rand(1, 2), $bench));
                $bench->push($this->getRandomPlayersByPosition('Midfielder (MF)', rand(1, 2), $bench));
                $bench->push($this->getRandomPlayersByPosition('Striker (ST)', 1, $bench));
                $bench = $bench->flatten();

                // create team player contracts
                $bench->each(function ($player) use ($team, $start) {
                    TeamPlayerContract::create([
                        'team_id' => $team->id,
                        'player_id' => $player->id,
                        'is_active'=> false,
                        'start_date'=> $start,
                    ]);
                });
            }
        }
    }

    public function getRandomPlayersByPosition($position, $count, $players)
    {
        // Avoid picking players from clubs that already have 2 players
        $avoidClubs = $players->flatten()->groupBy('playerContract.club_id')->filter(function ($item) {
            return $item->count() > 1;
        })->keys()->all();

        // filter clubs that have the player by position
        $clubsWithRequiredPlayers = $this->clubs->shuffle()->filter(function ($club) use ($position) {
            return $club->activePlayers->filter(function ($player) use ($position) {
                return $player->playerContract->position === $position;
            })->count();
        });

        $players = collect([]);

        // Take random clubs from these and fetch one player from each of these.
        $clubsWithRequiredPlayers->each(function ($club) use ($position, $players, $count, $avoidClubs) {
            $club->activePlayers->each(function ($player) use ($position, $players, $count, $avoidClubs) {
                if ($player->playerContract->position === $position && ! in_array($player->playerContract->club_id, $avoidClubs)) {
                    $players->push($player);

                    return false;
                }
            });
            if ($players->count() >= $count) {
                return false;
            }
        });

        // Remove the player from the original list so that it does not get reassigned to other teams.
        $this->removePlayersById($players->pluck('id')->all());

        return $players;
    }

    public function removePlayersById($playersIds)
    {
        $this->clubs->each(function ($club) use ($playersIds) {
            $activePlayers = $club->activePlayers->filter(function ($player, $key) use ($playersIds, $club) {
                return ! in_array($player->id, $playersIds);
            });
            $club->activePlayers = $activePlayers;
        });
    }
}
