<?php

namespace App\Repositories;

use App\Enums\CompetitionEnum;
use App\Enums\EventsEnum;
use App\Enums\TeamPointsPositionEnum;
use App\Enums\TransferTypeEnum;
use App\Enums\YesNoEnum;
use App\Models\Fixture;
use App\Models\FixtureEvent;
use App\Models\FixtureStats;
use App\Models\GameWeek;
use App\Models\Player;
use App\Models\PlayerContract;
use App\Models\PointAdjustment;
use App\Models\Season;
use App\Models\SupersubGuideCounter;
use App\Models\SupersubTeamPlayerContract;
use App\Models\TeamPlayerContract;
use App\Models\TeamPlayerPoint;
use App\Models\TeamPoint;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeamLineupRepository
{
    const YELLOW_CARD_LIMIT = 2;
    const GOAL_KEEPER_SAVE = 5;
    const APPEARANCE_TIME = 45;
    const CLEAN_SHEET_TIME = 75;
    const EVENT_POINTS = 1;
    const DEFENSIVE_MID_FIELDER = 'defensive_mid_fielder';
    const MID_FIELDER = 'mid_fielder';
    const CENTRE_BACK = 'centre_back';
    const FULL_BACK = 'full_back';
    const FUTURE_FIXTURES_LIMIT = 14;
    const SEASON_AFTER_YEAR = 2017;

    /**
     * @var TeamRepository
     */
    protected $TeamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function getLineupData($division, $team)
    {
        $auctionPricing = $team->transfer->where('transfer_type', 'auction')->pluck('transfer_value', 'player_in');

        $latestSeason = Season::getLatestSeason();

        $team_stats = $this->teamRepository->getTeamStats4Lineup($team, $division);

        $pointAdjustments = PointAdjustment::where('team_id', $team->id)
                                            ->where('season_id', $latestSeason)
                                            ->selectRaw('competition_type, SUM(points) AS points')
                                            ->groupBy('competition_type')
                                            ->get();

        $adjustments = [];
        foreach ($pointAdjustments as $adjustment) {
            $adjustments[$adjustment->competition_type] = $adjustment->points;
        }

        if (isset($adjustments['regular'])) {
            $team_stats['week_total'] += $adjustments['regular'];
        }

        if (isset($adjustments['cup'])) {
            $team_stats['facup_total'] += $adjustments['cup'];
        }

        //Code Optimize 21-04-2020 11:11 AM Ashish Parmar
        $fixtures = Fixture::where('season_id', $latestSeason)
                            ->where('status', 'Played')
                            ->groupBy('competition', 'id')
                            ->select('id','competition')
                            ->get();

        $playerSeasonStats = $this->getPlayerTeamStats($team, $division, $fixtures->pluck('id'));

        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $availableFormations = $division->getOptionValue('available_formations');
        $allowWeekendChanges = $division->getOptionValue('allow_weekend_changes');

        //Get maimum and minimum number for position which is allowed based on division's formations
        $dfArr = [];
        $mfArr = [];
        $stArr = [];
        $i = 0;
        foreach ($availableFormations as $key => $value) {
            $availableFormations[$key] = '1'.$value;
            $formationArr = str_split($value);
            $dfArr[$i] = $formationArr[0];
            $mfArr[$i] = $formationArr[1];
            $stArr[$i] = $formationArr[2];
            $i++;
        }

        $minMaxNumberForPosition['fb'] = ['min' => 2, 'max' => 2];
        if (max($dfArr) == 5) {
            $minMaxNumberForPosition['cb'] = ['min' => 2, 'max' => 3];
        } else {
            $minMaxNumberForPosition['cb'] = ['min' => 2, 'max' => 2];
        }
        $minMaxNumberForPosition['df'] = ['min' => min($dfArr), 'max' => max($dfArr)];
        $minMaxNumberForPosition['mf'] = ['min' => min($mfArr), 'max' => max($mfArr)];
        $minMaxNumberForPosition['st'] = ['min' => min($stArr), 'max' => max($stArr)];

        $lineupPlayers = $this->getPlayers($team, 'active', true);
        $subPlayers = $this->getPlayers($team, 'sub', true);

        $formation = '';
        $activePlayers = [];

        $gk = $fb = $cb = $dmf = $mf = $st = 0;

        $teamPointIDs4Month = $this->getTeamPointIDs4Month($team);

        // get all players points by week, total, fa cup prev round, fa cup total
        $allPlayerPoints = $this->getPlayerStatsByType($team, $division);

        $teamPoints = TeamPoint::whereIn('fixture_id', $fixtures->where('competition',CompetitionEnum::PREMIER_LEAGUE)->pluck('id'))
                                ->where('team_id', $team->id)
                                ->pluck('id');

        $lineupPlayersIds = $lineupPlayers->pluck('player_id');
        $subPlayersids = $subPlayers->pluck('player_id');
        $merged = $lineupPlayersIds->merge($subPlayersids);
        
        $totalPlayersPoints = TeamPlayerPoint::whereIn('team_point_id', $teamPoints)
                    ->whereIn('player_id', $merged)
                    ->groupBy('player_id')
                    ->selectRaw('player_id, sum(total) as total')
                    ->get();

        $transfersAmounts = $this->getPlayersTransfersValues($team, $lineupPlayers->pluck('player_id')->merge($subPlayers->pluck('player_id'))->toArray());

        foreach ($lineupPlayers as $key => $player) {

            $totalPoints = $totalPlayersPoints->where('player_id',$player->player_id)->sum('total');

            if($totalPoints >= 0) {
                $player['total'] = $totalPoints;
            }

            $transfer_value = $transfersAmounts->where('player_in', $player['player_id'])->first();

            $nextFixture['PL'] = $this->getNextFixtureData($division, $team, $player, 'in', CompetitionEnum::PREMIER_LEAGUE);
            $nextFixture['FA'] = $this->getNextFixtureData($division, $team, $player, 'in', CompetitionEnum::FA_CUP);

            $player->position = player_position_short($player->position);
            $player->is_processed = 0;
            $player->has_next_fixture = 0;

            $player->status = $player->player->playerStatus;
            $player->total = isset($totalPoints) ? (int) $totalPoints : 0;

            $player = $player->toArray();
            $player['transfer_value'] = $transfer_value ? $transfer_value->transfer_value : 0;

            $player['next_fixture'] = $nextFixture;
            unset($player['player']);

            $player['month_total2'] = $this->getPlayerPoints($teamPointIDs4Month, $player['player_id']);

            $player['week_total2_PL'] = isset($allPlayerPoints['current_week'][$player['player_id']]) ? $allPlayerPoints['current_week'][$player['player_id']]['total'] : 0;
            $player['week_total2_FA'] = isset($allPlayerPoints['current_week'][$player['player_id']]) ? $allPlayerPoints['current_week'][$player['player_id']]['total'] : 0;

            $player['current_week'] = isset($allPlayerPoints['current_week'][$player['player_id']]) ? $allPlayerPoints['current_week'][$player['player_id']] : 0;
            $player['week_total'] = isset($allPlayerPoints['week_total'][$player['player_id']]) ? $allPlayerPoints['week_total'][$player['player_id']] : 0;
            $player['facup_prev'] = isset($allPlayerPoints['facup_prev'][$player['player_id']]) ? $allPlayerPoints['facup_prev'][$player['player_id']] : 0;
            $player['facup_total'] = isset($allPlayerPoints['facup_total'][$player['player_id']]) ? $allPlayerPoints['facup_total'][$player['player_id']] : 0;

            $position = $player['position'];

            $player['tshirt'] = player_tshirt($player['short_code'], $position);

            if ($position == 'GK') {
                $activePlayers['gk'][] = $player;
                $gk++;
            } elseif ($position == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    $player['position'] = 'DF';
                    $activePlayers['df'][] = $player;
                } else {
                    $activePlayers['fb'][] = $player;
                }
                $fb++;
            } elseif ($position == 'CB') {
                if ($mergeDefenders == 'Yes') {
                    $player['position'] = 'DF';
                    $activePlayers['df'][] = $player;
                } else {
                    $activePlayers['cb'][] = $player;
                }
                $cb++;
            } elseif ($position == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    $player['curr_position'] = 'DM';
                    $player['position'] = 'DM';
                    $activePlayers['dm'][] = $player;
                } else {
                    $player['curr_position'] = 'MF';
                    $player['position'] = 'MF';
                    $activePlayers['mf'][] = $player;
                }
                $dmf++;
            } elseif ($position == 'MF') {
                $player['curr_position'] = 'MF';
                $activePlayers['mf'][] = $player;
                $mf++;
            } elseif ($position == 'ST') {
                $activePlayers['st'][] = $player;
                $st++;
            }
        }

        $formation = ($fb + $cb).'-'.($dmf + $mf).'-'.$st;

        if ($formation == '4-4-2') {
            $activePlayers = $this->get442FormationData($activePlayers);
        } elseif ($formation == '4-5-1') {
            $activePlayers = $this->get451FormationData($activePlayers);
        } elseif ($formation == '4-3-3') {
            $activePlayers = $this->get433FormationData($activePlayers);
        } elseif ($formation == '5-3-2') {
            $activePlayers = $this->get532FormationData($activePlayers);
        } elseif ($formation == '5-4-1') {
            $activePlayers = $this->get541FormationData($activePlayers);
        }

        $teamArray = [];
        $teamArray['gk'] = @$activePlayers['gk'];
        if (isset($activePlayers['df'])) {
            $teamArray['df'] = @$activePlayers['df'];
        } else {
            if (isset($activePlayers['fb'][0])) {
                $teamArray['df'][] = @$activePlayers['fb'][0];
            }
            if (isset($activePlayers['cb'])) {
                foreach ($activePlayers['cb'] as $cb) {
                    $teamArray['df'][] = $cb;
                }
            }
            if (isset($activePlayers['fb'][1])) {
                $teamArray['df'][] = @$activePlayers['fb'][1];
            }
        }
        $teamArray['mf'] = @$activePlayers['mf'];
        $teamArray['st'] = @$activePlayers['st'];

        $gkArr = [];
        $fbArr = [];
        $cbArr = [];
        $dfArr = [];
        $dmArr = [];
        $mfArr = [];
        $stArr = [];

        foreach ($subPlayers as $key => $player) {

            $totalPoints = $totalPlayersPoints->where('player_id',$player->player_id)->sum('total');

            if($totalPoints >= 0) {
                $player->total = $totalPoints;
            }

            $transfer_value = $transfersAmounts->where('player_in', $player->player_id)->first();

            $player->position = player_position_short($player->position);
            $player->is_processed = 0;
            $player->has_next_fixture = 0;
            $player->player_last_name_lower = strtolower($player->player_last_name);

            $nextFixture['PL'] = $this->getNextFixtureData($division, $team, $player, 'out', CompetitionEnum::PREMIER_LEAGUE);
            $nextFixture['FA'] = $this->getNextFixtureData($division, $team, $player, 'out', CompetitionEnum::FA_CUP);

            $player->status = $player->player->playerStatus;
            $player->total = isset($player->total) ? (int) $player->total : 0;
            $player->transfer_value = $transfer_value ? $transfer_value->transfer_value : 0;


            if ($player->status !== null) {
                $player->status->image = player_status($player->status->status);
            }

            $player['month_total2'] = $this->getPlayerPoints($teamPointIDs4Month, $player->player->id);

            // $player['week_total2_PL'] = isset($allPlayerPoints['current_week'][$player->player->id]) ? $allPlayerPoints['current_week'][$player->player->id]['total'] : 0;
            // $player['week_total2_FA'] = isset($allPlayerPoints['current_week'][$player['player_id']]) ? $allPlayerPoints['current_week'][$player['player_id']]['total'] : 0;

            $player->current_week = isset($allPlayerPoints['current_week'][$player->player->id]) ? $allPlayerPoints['current_week'][$player->player->id] : 0;
            $player->week_total = isset($allPlayerPoints['week_total'][$player->player->id]) ? $allPlayerPoints['week_total'][$player->player->id] : 0;
            $player->facup_prev = isset($allPlayerPoints['facup_prev'][$player->player->id]) ? $allPlayerPoints['facup_prev'][$player->player->id] : 0;
            $player->facup_total = isset($allPlayerPoints['facup_total'][$player->player->id]) ? $allPlayerPoints['facup_total'][$player->player->id] : 0;

            $player->next_fixture = $nextFixture;
            unset($player->player);

            $position = $player->position;
            $player->tshirt = player_tshirt($player['short_code'], $position);

            if ($position == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    $subPlayers[$key]->position = 'DF';
                }
            } elseif ($position == 'CB') {
                if ($mergeDefenders == 'Yes') {
                    $subPlayers[$key]->position = 'DF';
                }
            } elseif ($position == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    $subPlayers[$key]->position = 'DM';
                } else {
                    $subPlayers[$key]->position = 'MF';
                }
            }

            $position = $player->position;
            if ($position == 'GK') {
                $gkArr[] = $subPlayers[$key];
            }
            if ($position == 'FB') {
                $fbArr[] = $subPlayers[$key];
            }
            if ($position == 'CB') {
                $cbArr[] = $subPlayers[$key];
            }
            if ($position == 'DF') {
                $dfArr[] = $subPlayers[$key];
            }
            if ($position == 'DM') {
                $dmArr[] = $subPlayers[$key];
            }
            if ($position == 'MF') {
                $mfArr[] = $subPlayers[$key];
            }
            if ($position == 'ST') {
                $stArr[] = $subPlayers[$key];
            }
        }

        $gkArr = collect($gkArr)->sortBy('player_last_name_lower')->toArray();
        $fbArr = collect($fbArr)->sortBy('player_last_name_lower')->toArray();
        $cbArr = collect($cbArr)->sortBy('player_last_name_lower')->toArray();
        $dfArr = collect($dfArr)->sortBy('player_last_name_lower')->toArray();
        $dmArr = collect($dmArr)->sortBy('player_last_name_lower')->toArray();
        $mfArr = collect($mfArr)->sortBy('player_last_name_lower')->toArray();
        $stArr = collect($stArr)->sortBy('player_last_name_lower')->toArray();

        $subplayersData = array_merge($gkArr, $fbArr, $cbArr, $dfArr, $dmArr, $mfArr, $stArr);

        $returnArr['activePlayers'] = $teamArray;
        $returnArr['subPlayers'] = $subplayersData;
        $returnArr['formation'] = $formation;
        $returnArr['division'] = $division;
        //$returnArr['team'] = $team;
        $returnArr['pitch'] = $team->getPitchImageThumb();
        $returnArr['availableFormations'] = $availableFormations;
        $returnArr['minMaxNumberForPosition'] = $minMaxNumberForPosition;
        $returnArr['team_stats'] = $team_stats;
        $fixtureData = $this->getTeamFixtures($team);
        $returnArr['teamClubs'] = $fixtureData['teamClubs'];
        $returnArr['futureFixturesDates'] = $fixtureData['futureFixturesDates'];
        $returnArr['superSubFixtureDates'] = $this->getTeamSuperSubFixtureDates($team);
        $returnArr['seasons'] = $this->getAvailableSeason();
        $returnArr['currentSeason'] = $latestSeason;
        $returnArr['playerSeasonStats'] = $playerSeasonStats;
        $returnArr['enableSupersubs'] = $division->package->enable_supersubs == YesNoEnum::YES ? 1 : 0;

        if ($allowWeekendChanges == YesNoEnum::NO) {
            $chkFlag = Fixture::checkFixtureForSwap();
            $returnArr['allowWeekendSwap'] = ! $chkFlag ? 1 : 0;
            $returnArr['allowWeekendChanges'] = ! $chkFlag ? 1 : 0;
            $returnArr['isSupersubDisabled'] = 0;
        } else {
            $returnArr['allowWeekendSwap'] = 1;
            $returnArr['allowWeekendChanges'] = 1;
            $returnArr['isSupersubDisabled'] = 1;
        }

        if ($returnArr['enableSupersubs'] == 0) {
            $returnArr['isSupersubDisabled'] = 0;
        }
        $returnArr['supersub_feature_live'] = config('fantasy.supersub_feature_live');

        return $returnArr;
    }

    public function getPlayersTransfersValues($team, $teamPlayersArray)
    {
        $teamPlayersString = implode(',', $teamPlayersArray);
        $transfersAmounts  = Transfer::select('transfers.transfer_value', 'transfers.player_in')
                            ->join(DB::raw('(SELECT  player_in, MAX(id) id FROM transfers WHERE transfers.player_in IN ('.$teamPlayersString.') AND transfers.`team_id` = '.$team->id.' GROUP BY player_in) transfersTwo'), 
                            function($join){
                                $join->on('transfers.id', '=', 'transfersTwo.id');
                                $join->on('transfers.player_in', '=', 'transfersTwo.player_in');
                            })
                            ->whereIn('transfers.player_in', $teamPlayersArray)
                            ->where('transfers.team_id', $team->id)
                            ->get();

        return $transfersAmounts;
    }

    public function getAvailableSeason()
    {
        $data = Season::whereYear('start_at', '>', self::SEASON_AFTER_YEAR)
                ->orderBy('id')
                ->pluck('name', 'id')
                ->toArray();

        return $data;
    }

    public function getPlayerCurrentClub($player_id)
    {
        return PlayerContract::join('clubs', 'player_contracts.club_id', 'clubs.id')
                                ->where('player_contracts.player_id', $player_id)
                                ->whereNull('player_contracts.end_date')
                                ->selectRaw('clubs.*')
                                ->first();
    }

    public function get442FormationData($activePlayers)
    {
        if (isset($activePlayers['dm'])) {
            $mfPlayersCount = isset($activePlayers['mf']) ? count($activePlayers['mf']) : 0;
            $dmPlayersCount = count($activePlayers['dm']);
            if ($mfPlayersCount == 3 && $dmPlayersCount == 1) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 2 && $dmPlayersCount == 2) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 1 && $dmPlayersCount == 3) {
                array_splice($activePlayers['mf'], 0, 0, $activePlayers['dm']);
            } else {
                $activePlayers['mf'] = $activePlayers['dm'];
            }
            unset($activePlayers['dm']);
        }

        return $activePlayers;
    }

    public function get451FormationData($activePlayers)
    {
        if (isset($activePlayers['dm'])) {
            $mfPlayersCount = isset($activePlayers['mf']) ? count($activePlayers['mf']) : 0;
            $dmPlayersCount = count($activePlayers['dm']);
            if ($mfPlayersCount == 4 && $dmPlayersCount == 1) {
                array_splice($activePlayers['mf'], 2, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 3 && $dmPlayersCount == 2) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 2 && $dmPlayersCount == 3) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 1 && $dmPlayersCount == 4) {
                array_splice($activePlayers['mf'], 0, 0, $activePlayers['dm']);
            } else {
                $activePlayers['mf'] = $activePlayers['dm'];
            }
            unset($activePlayers['dm']);
        }

        return $activePlayers;
    }

    public function get433FormationData($activePlayers)
    {
        if (isset($activePlayers['dm'])) {
            $mfPlayersCount = isset($activePlayers['mf']) ? count($activePlayers['mf']) : 0;
            $dmPlayersCount = count($activePlayers['dm']);
            if ($mfPlayersCount == 2 && $dmPlayersCount == 1) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 1 && $dmPlayersCount == 2) {
                array_splice($activePlayers['mf'], 0, 0, $activePlayers['dm']);
            } else {
                $activePlayers['mf'] = $activePlayers['dm'];
            }
            unset($activePlayers['dm']);
        }

        return $activePlayers;
    }

    public function get532FormationData($activePlayers)
    {
        if (isset($activePlayers['dm'])) {
            $mfPlayersCount = isset($activePlayers['mf']) ? count($activePlayers['mf']) : 0;
            $dmPlayersCount = count($activePlayers['dm']);
            if ($mfPlayersCount == 2 && $dmPlayersCount == 1) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 1 && $dmPlayersCount == 2) {
                array_splice($activePlayers['mf'], 0, 0, $activePlayers['dm']);
            } else {
                $activePlayers['mf'] = $activePlayers['dm'];
            }
            unset($activePlayers['dm']);
        }

        return $activePlayers;
    }

    public function get541FormationData($activePlayers)
    {
        if (isset($activePlayers['dm'])) {
            $mfPlayersCount = isset($activePlayers['mf']) ? count($activePlayers['mf']) : 0;
            $dmPlayersCount = count($activePlayers['dm']);
            if ($mfPlayersCount == 3 && $dmPlayersCount == 1) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 2 && $dmPlayersCount == 2) {
                array_splice($activePlayers['mf'], 1, 0, $activePlayers['dm']);
            } elseif ($mfPlayersCount == 1 && $dmPlayersCount == 3) {
                array_splice($activePlayers['mf'], 0, 0, $activePlayers['dm']);
            } else {
                $activePlayers['mf'] = $activePlayers['dm'];
            }
            unset($activePlayers['dm']);
        }

        return $activePlayers;
    }

    public function getClubNextFixture($club, $competition = '', $date = null)
    {
        $isCustomDate = false;

        if(!isset($date) || !$date) {
            $date = date('Y-m-d H:i:s');
        } else {
            $isCustomDate = true;
            $date = Carbon::parse($date)->format('Y-m-d H:i:s');
        }

        $nextFixture = Fixture::where(function ($query) use ($club) {
            $query->where('home_club_id', $club->id)
                    ->orWhere('away_club_id', $club->id);
        });

        if($isCustomDate) {
            $nextFixture = $nextFixture->where('date_time', '>=', $date);
        } else {
            $nextFixture = $nextFixture->where('date_time', '>', $date);
        }

        if ($competition == CompetitionEnum::FA_CUP || $competition == CompetitionEnum::PREMIER_LEAGUE) {
            $nextFixture = $nextFixture->where('competition', $competition);
        }

        $nextFixture = $nextFixture->orderBy('date_time')->first();

        return $nextFixture;
    }

    public function getNextFixtureData($division, $team, $player, $inLineup = '', $competition = '', $date = null)
    {
        $dt = date('Y-m-d');
        $playerClub = PlayerContract::join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                                    ->select('clubs.*')
                                    ->where('player_id', $player->player_id)
                                    ->where('start_date', '<=', $dt)
                                    ->where(function ($query) use($dt) {
                                        $query->whereNull('end_date')->orWhere('end_date', '>=', $dt);
                                    })->first();

        $fixture = [];
        if($playerClub) {

            $nextFixtureForSuperSub = $this->getClubNextFixture($playerClub, $competition, $date);
            $supersubData = [];
            if($nextFixtureForSuperSub) {
                
                $supersubData['date'] = carbon_format_to_date_for_fixture($nextFixtureForSuperSub->date_time);
                $playerClubId =  $playerClub->id;
                if ($playerClubId == $nextFixtureForSuperSub->home_club_id) {
                    $supersubData['type'] = 'H';
                    $supersubData['club'] = $nextFixtureForSuperSub->home_team->short_name;
                    $supersubData['short_name'] = $nextFixtureForSuperSub->away_team->short_name;
                    $supersubData['short_code'] = $nextFixtureForSuperSub->away_team->short_code;
                } else {
                    $supersubData['type'] = 'A';
                    $supersubData['club'] = $nextFixtureForSuperSub->away_team->short_name;
                    $supersubData['short_name'] = $nextFixtureForSuperSub->home_team->short_name;
                    $supersubData['short_code'] = $nextFixtureForSuperSub->home_team->short_code;
                }
            }

            $nextFixture = $this->getClubNextFixture($playerClub, $competition);
            if ($nextFixture) {
                $playerClubId =  $playerClub->id;

                if ($playerClubId == $nextFixture->home_club_id) {
                    $fixture['type'] = 'H';
                    $fixture['club'] = $nextFixture->home_team->short_name;
                    $fixture['short_name'] = $nextFixture->away_team->short_name;
                    $fixture['short_code'] = $nextFixture->away_team->short_code;
                } else {
                    $fixture['type'] = 'A';
                    $fixture['club'] = $nextFixture->away_team->short_name;
                    $fixture['short_name'] = $nextFixture->home_team->short_name;
                    $fixture['short_code'] = $nextFixture->home_team->short_code;
                }
                $fixture['date_time'] = $nextFixture->date_time;

                $fixture['date'] = carbon_format_to_date_for_fixture($nextFixture->date_time);
                $fixture['time'] = carbon_format_to_time_for_fixture($nextFixture->date_time);
                $fixture['str_date'] = carbon_format_to_date_for_fixture_format1($nextFixture->date_time);

                //check player in team or not
                $plrContract = SupersubTeamPlayerContract::where('team_id', $player->team_id)
                                ->where('player_id', $player->player_id)
                                ->where('start_date', '<=', $nextFixture->date_time)
                                ->where('is_applied', false)
                                ->select('is_active')
                                ->orderBy('start_date', 'desc')
                                ->first();

                if (! $plrContract) {
                    $plrContract = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
                                ->join('division_teams', function ($join) use ($division) {
                                    $join->on('division_teams.team_id', '=', 'teams.id')
                                        ->where('division_teams.division_id', $division->id)
                                        ->where('division_teams.season_id', Season::getLatestSeason());
                                })
                                ->where('team_player_contracts.player_id', $player->player_id)
                                ->where('team_player_contracts.start_date', '<=', $nextFixture->date_time)
                                ->where('team_player_contracts.team_id', '<=', $team->id)
                                ->where(function ($qry) use ($nextFixture) {
                                    $qry->whereNull('team_player_contracts.end_date')
                                        ->orWhere('team_player_contracts.end_date', '>=', $nextFixture->date_time);
                                })
                                ->select('team_player_contracts.is_active')
                                ->orderBy('team_player_contracts.id', 'desc')
                                ->first();
                }

                $fixture['in_lineup'] = $plrContract && $plrContract->is_active ? 'in' : 'out';

                $fixture['supersub'] = $supersubData;

            } else {
                $fixture['club'] = $playerClub->short_name;
            }
        }

        return $fixture;
    }

    public function getNextFixtureDataAfterDate($player, $inLineup = '', $competition = '', $date = '')
    {
        // $playerClub = $player->player->playerContract->club;
        $contract = PlayerContract::where('player_id', $player['player_id'])
                                    ->where('start_date', '<=', date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->whereNull('end_date')
                                            ->orWhere('end_date', '>=', date('Y-m-d'));
                                    })
                                    ->first();
        $playerClub = $contract->club;

        $fixture = [];
        $nextFixture = [];
        if (! empty($nextFixture = $playerClub->nextFixtureAfterDate($competition, $date))) {
            // $nextFixture = $playerClub->nextFixture($competition);
            $playerClubId = $playerClub->id;

            if ($playerClubId == $nextFixture->home_club_id) {
                $fixture['type'] = 'H';
                $fixture['club'] = $nextFixture->home_team->short_name;
                $fixture['short_name'] = $nextFixture->away_team->short_name;
                $fixture['short_code'] = $nextFixture->away_team->short_code;
            } else {
                $fixture['type'] = 'A';
                $fixture['club'] = $nextFixture->away_team->short_name;
                $fixture['short_name'] = $nextFixture->home_team->short_name;
                $fixture['short_code'] = $nextFixture->home_team->short_code;
            }
            $fixture['date_time'] = $nextFixture->date_time;

            $fixture['date'] = carbon_format_to_date_for_fixture($nextFixture->date_time);
            $fixture['time'] = carbon_format_to_time_for_fixture($nextFixture->date_time);
            $fixture['str_date'] = carbon_format_to_date_for_fixture_format1($nextFixture->date_time);

            //check player in team or not
            $chkSuperSubEntry = SupersubTeamPlayerContract::where('team_id', $player['team_id'])
                                        ->where('player_id', $player['player_id'])
                                        ->where('start_date', $nextFixture->date_time)
                                        ->where('is_applied', false)
                                        ->first();

            if (isset($chkSuperSubEntry)) {
                if ($chkSuperSubEntry->is_active == 1) {
                    $inLineup = 'in';
                } else {
                    $inLineup = 'out';
                }
            }
            $fixture['in_lineup'] = $inLineup;
        } else {
            $fixture['club'] = $playerClub->short_name;
        }

        return $fixture;
    }

    public function getPlayers($team, $playerType = 'active', $forPDF = false)
    {
        $division = $team->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);
        $playerIds = TeamPlayerContract::where('team_id', $team->id)
                    ->whereNull('end_date')
                    ->groupBy('player_id')
                    ->pluck('player_id');
        $pdfFields = ($forPDF) ? ',
                    SUM(team_player_points.goal) as player_goals,
                    SUM(team_player_points.assist) as player_assists,
                    SUM(team_player_points.conceded) as player_conceded,
                    SUM(team_player_points.clean_sheet) as player_clean_sheet
                ' : '';

        $query = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')

            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            // ->join('player_contracts as latest_player_contracts', function ($join) {
            //     $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))) ORDER BY id DESC LIMIT 1)'));
            // })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE id = ( SELECT IF ((SELECT transfer_type FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in AND transfers.transfer_type NOT IN ('substitution','supersub') ORDER BY id DESC LIMIT 1) = 'auction' AND '".$auctionDate."' = DATE(transfers.transfer_date) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."' ) ) ORDER BY id DESC LIMIT 1) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date) ) ) ORDER BY id DESC LIMIT 1 )) AS id ))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('team_player_points', function ($join) {
                $join->on('players.id', '=', 'team_player_points.player_id');
                $join->on('teams.id', '=', 'team_player_points.team_id');
            })

            ->selectRaw('count(team_player_points.player_id) as pld, team_player_contracts.team_id,team_player_contracts.player_id,player_contracts.position,players.first_name as player_first_name,players.last_name as player_last_name,users.first_name as user_first_name,users.last_name as user_last_name,player_contracts.club_id as club_id,clubs.name as club_name,clubs.short_code,teams.name as team_name,sum(team_player_points.total) total'.$pdfFields)

            // ->whereIn('team_player_points.team_point_id', $teamPoints)
            //->whereNull('team_player_contracts.end_date')
            ->where('team_player_contracts.team_id', $team->id)
            ->orderBy('players.first_name')
            ->groupBy('team_player_contracts.team_id', 'team_player_contracts.player_id', 'player_contracts.position', 'players.first_name', 'players.last_name', 'users.first_name', 'users.last_name', 'player_contracts.club_id', 'clubs.name', 'clubs.short_code', 'teams.name');

        if ($playerType == 'active') {
            $result = $query->whereNull('team_player_contracts.end_date')
            ->where('team_player_contracts.is_active', 1);
        } elseif ($playerType == 'sold') {
            $result = $query->whereNotIn('team_player_contracts.player_id', $playerIds);
        } else {
            $result = $query->whereNull('team_player_contracts.end_date')
            ->where('team_player_contracts.is_active', 0);
        }

        return $result->get();
    }

    public function getTeamPointIDs4Month($team)
    {
        $dtEnd = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $dtStart = $now->firstOfMonth()->format('Y-m-d');

        $teamPointIDs = TeamPoint::join('fixtures', function ($join) {
            $join->on('fixtures.id', '=', 'team_points.fixture_id')
                ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE);
        })
                        ->where(DB::raw('CONVERT(fixtures.date_time, DATE)'), '>=', $dtStart)
                        ->where(DB::raw('CONVERT(fixtures.date_time, DATE)'), '<=', $dtEnd)
                        ->where('fixtures.season_id', Season::getLatestSeason())
                        ->where('team_points.team_id', $team->id)
                        ->orderBy('team_points.id')
                        ->pluck('team_points.id');

        return $teamPointIDs;
    }

    public function getTeamPointIDs4Week($competition)
    {
        $date = Carbon::now()->format('Y-m-d');
        $gameweeks = GameWeek::where('end', '<=', $date)->where('season_id', Season::getLatestSeason());
        if ($gameweeks) {
            $gameweeks = $gameweeks->limit(1);
        }
        $gameweek = $gameweeks->orderBy('end', 'desc')->first();

        $dtStart = $gameweek->start;
        $dtEnd = $gameweek->end;
        $teamPointIDs = TeamPoint::join('fixtures', function ($join) {
            $join->on('fixtures.id', '=', 'team_points.fixture_id');
        })
                        ->where('fixtures.date_time', '>=', $dtStart)
                        ->where('fixtures.date_time', '<=', $dtEnd)
                        ->where('fixtures.season_id', Season::getLatestSeason())
                        ->where('competition', $competition)
                        ->distinct()
                        ->orderBy('team_points.id')
                        ->pluck('team_points.id');

        return $teamPointIDs;
    }

    public function getPlayerPoints($teamPointIDs, $playerId)
    {
        $total = TeamPlayerPoint::whereIn('team_point_id', $teamPointIDs)
                                ->where('player_id', $playerId)
                                ->select(DB::raw('sum(total) as total'))
                                ->first();

        return $total->total ? (int) $total->total : 0;
    }

    public function getPlayerStatsSold($division, $team)
    {
        $soldPlayers = $this->getPlayers($team, 'sold');

        $plrIds = [];
        foreach ($soldPlayers->toArray() as $key => $value) {
            $plrIds[] = $value['player_id'];
        }

        $plrStatusPreLeague = $this->getPlayerHAStats($plrIds, CompetitionEnum::PREMIER_LEAGUE, Season::getLatestSeason());
        $plrStatusFACup = $this->getPlayerHAStats($plrIds, CompetitionEnum::FA_CUP, Season::getLatestSeason());

        $plrStats = [];

        foreach ($soldPlayers as $key => $player) {
            $plrStats[$player->player->id] = $this->generateStats($player, $division, $team, $plrStatusPreLeague, $plrStatusFACup);
        }

        return $plrStats;
    }

    public function getPlayerStats($division, $team)
    {
        $lineupPlayers = $this->getPlayers($team, 'active');
        $subPlayers = $this->getPlayers($team, 'sub');

        $plrIds = [];
        foreach ($lineupPlayers->toArray() as $key => $value) {
            $plrIds[] = $value['player_id'];
        }
        foreach ($subPlayers->toArray() as $key => $value) {
            $plrIds[] = $value['player_id'];
        }

        $plrStatusPreLeague = $this->getPlayerHAStats($plrIds, CompetitionEnum::PREMIER_LEAGUE, Season::getLatestSeason());
        $plrStatusFACup = $this->getPlayerHAStats($plrIds, CompetitionEnum::FA_CUP, Season::getLatestSeason());

        $plrStats = [];

        foreach ($lineupPlayers as $key => $player) {
            $plrStats[$player->player->id] = $this->generateStats($player, $division, $team, $plrStatusPreLeague, $plrStatusFACup);
        }

        foreach ($subPlayers as $key => $player) {
            $plrStats[$player->player->id] = $this->generateStats($player, $division, $team, $plrStatusPreLeague, $plrStatusFACup);
        }

        return $plrStats;
    }

    public function getPlayerTeamStats($team, $division, $fixtures)
    {
        $teamPoints = TeamPoint::whereIn('fixture_id', $fixtures)
                                ->where('team_id', $team->id)
                                ->pluck('id');

        $playerStats = TeamPlayerPoint::selectRaw('
                        player_id,
                        COUNT(*) AS pld,
                        SUM(goal) AS gls,
                        SUM(assist) AS asst,
                        SUM(conceded) AS ga,
                        SUM(clean_sheet) AS cs,
                        SUM(appearance) AS app,
                        SUM(club_win) AS club_win,
                        SUM(own_goal) AS own_goal,
                        SUM(penalty_missed) AS penalty_missed,
                        SUM(penalty_saved) AS penalty_save,
                        SUM(goalkeeper_save) AS penalty_save,
                        SUM(red_card) AS red_card,
                        SUM(yellow_card) AS yellow_card,
                        SUM(goalkeeper_save) AS goalkeeper_save,
                        SUM(total) AS total
                    ')
                    ->groupBy('player_id')
                    ->whereIn('team_point_id', $teamPoints)
                    ->where('team_id', $team->id)
                    ->get()->keyBy('player_id');

        return $playerStats->toArray();
    }

    public function generateStats($player, $division, $team, $plrStatusPreLeague, $plrStatusFACup, $season_id = 0)
    {
        unset($data);

        if ($season_id == 0) {
            $season_id = Season::getLatestSeason();
        }

        $playerPosition = $player->position;

        $player = $player->player;
        $player->position = $playerPosition;

        $playerPosition = strtolower(TeamPointsPositionEnum::getKey($playerPosition));
        if ($playerPosition == self::DEFENSIVE_MID_FIELDER) {
            $playerPosition = ($division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
        }

        if ($playerPosition == self::CENTRE_BACK) {
            $playerPosition = ($division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
        }

        $pointCalc['goals'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL);
        $pointCalc['assist'] = $division->getOptionValue($playerPosition, EventsEnum::ASSIST);
        $pointCalc['clean_sheet'] = $division->getOptionValue($playerPosition, EventsEnum::CLEAN_SHEET);
        $pointCalc['goal_conceded'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL_CONCEDED);
        $pointCalc['appearance'] = $division->getOptionValue($playerPosition, EventsEnum::APPEARANCE);
        $pointCalc['club_win'] = $division->getOptionValue($playerPosition, EventsEnum::CLUB_WIN);
        $pointCalc['yellow_card'] = $division->getOptionValue($playerPosition, EventsEnum::YELLOW_CARD);
        $pointCalc['red_card'] = $division->getOptionValue($playerPosition, EventsEnum::RED_CARD);
        $pointCalc['own_goal'] = $division->getOptionValue($playerPosition, EventsEnum::OWN_GOAL);
        $pointCalc['penalty_missed'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_MISSED);
        $pointCalc['penalty_save'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_SAVE);
        $pointCalc['goalkeeper_save'] = $division->getOptionValue($playerPosition, EventsEnum::GOALKEEPER_SAVE_X5);

        $data['id'] = $player->id;
        $data['first_name'] = $player->first_name;
        $data['last_name'] = $player->last_name;
        $data['image'] = $player->getPlayerCrest();
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        $data['position'] = player_position_short($player->playerContract->position);
        if ($data['position'] == 'FB' || $data['position'] == 'CB') {
            if ($mergeDefenders == 'Yes') {
                $data['position'] = 'DF';
            }
        } elseif ($data['position'] == 'DMF') {
            if ($defensiveMidfields == 'Yes') {
                $data['position'] = 'DM';
            } else {
                $data['position'] = 'MF';
            }
        }

        if ($player->playerStatus) {
            $data['status'] = $player->playerStatus->toArray();
        } else {
            $data['status'] = null;
        }

        // $data['club'] = $player->playerContract->club->toArray();
        $data['club'] = $this->getPlayerCurrentClub($player->id);
        unset($data['club']['active_players']);

        $data['game_stats']['point_calculation'] = $pointCalc;

        if ($data['position'] == 'ST' || $data['position'] == 'MF') {
            if ($pointCalc['goal_conceded'] == 0) {
                $plrStatusPreLeague[$player->id]['home']['ga'] = 0;
                $plrStatusPreLeague[$player->id]['away']['ga'] = 0;
            }
            if ($pointCalc['clean_sheet'] == 0) {
                $plrStatusPreLeague[$player->id]['home']['cs'] = 0;
                $plrStatusPreLeague[$player->id]['away']['cs'] = 0;
            }
        }

        if (isset($plrStatusPreLeague[$player->id])) {
            // home total point calculation
            $total = 0;
            if (isset($plrStatusPreLeague[$player->id]['home'])) {
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['red_card'] * $pointCalc['red_card']);
            }
            $plrStatusPreLeague[$player->id]['home']['total'] = $total;
            $data['game_stats']['premier_league'] = $plrStatusPreLeague[$player->id];

            // away total point calculation
            $total = 0;
            if (isset($plrStatusPreLeague[$player->id]['away'])) {
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['red_card'] * $pointCalc['red_card']);
            }

            $plrStatusPreLeague[$player->id]['away']['total'] = $total;
            $data['game_stats']['premier_league'] = $plrStatusPreLeague[$player->id];
        }

        if (isset($plrStatusFACup[$player->id])) {
            if ($data['position'] == 'ST' || $data['position'] == 'MF') {
                if ($pointCalc['goal_conceded'] == 0) {
                    $plrStatusFACup[$player->id]['home']['ga'] = 0;
                    $plrStatusFACup[$player->id]['away']['ga'] = 0;
                }
                if ($pointCalc['clean_sheet'] == 0) {
                    $plrStatusFACup[$player->id]['home']['cs'] = 0;
                    $plrStatusFACup[$player->id]['away']['cs'] = 0;
                }
            }

            // home total point calculation
            $total = 0;
            if (isset($plrStatusFACup[$player->id]['home'])) {
                $total += (int) (@$plrStatusFACup[$player->id]['home']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['red_card'] * $pointCalc['red_card']);
            }
            $plrStatusFACup[$player->id]['home']['total'] = $total;
            $data['game_stats']['fa_cup'] = $plrStatusFACup[$player->id];

            // away total point calculation
            $total = 0;
            if (isset($plrStatusFACup[$player->id]['away'])) {
                $total += (int) (@$plrStatusFACup[$player->id]['away']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['red_card'] * $pointCalc['red_card']);
            }

            $plrStatusFACup[$player->id]['away']['total'] = $total;
            $data['game_stats']['fa_cup'] = $plrStatusFACup[$player->id];
        }

        $data['game_stats']['history'] = $this->getPlayerHistory($division, $player, $season_id, $team);
        // $data['game_stats']['fixtures'] = $this->getPlayerFutureFixtures($division, $player, $season_id);

        return $data;
    }

    public function getPlayerFutureFixtures($division, $player)
    {

        // if ($season_id == 0) {
        $season_id = Season::getLatestSeason();
        // }

        $club_id = $player->playerContract->club_id;
        $fixtures = Fixture::where('season_id', $season_id)
                            ->where(function ($query) use ($club_id) {
                                return $query->where('home_club_id', $club_id)
                                    ->orWhere('away_club_id', $club_id);
                            })
                            ->join('clubs as hc', 'hc.id', '=', 'fixtures.home_club_id')
                            ->join('clubs as ac', 'ac.id', '=', 'fixtures.away_club_id')
                            ->where('date_time', '>', Carbon::now())
                            ->selectRaw('
                                fixtures.id,
                                fixtures.home_club_id,
                                hc.name as home_club_name,
                                hc.short_code as home_short_code,
                                ac.name as away_club_name,
                                ac.short_code as away_short_code,
                                fixtures.away_club_id,
                                fixtures.date_time,
                                IF (fixtures.home_club_id = '.$club_id.",'H','A') AS ha
                                ")
                            ->orderBy('fixtures.date_time')
                            ->get();

        foreach ($fixtures as $fixture) {
            $plrContract = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
                            ->join('division_teams', function ($join) use ($division) {
                                $join->on('division_teams.team_id', '=', 'teams.id')
                                    ->where('division_teams.division_id', $division->id)
                                    ->where('division_teams.season_id', Season::getLatestSeason());
                            })
                            ->where('team_player_contracts.player_id', $player->id)
                            ->where('team_player_contracts.start_date', '<=', $fixture->date_time)
                            ->where(function ($qry) use ($fixture) {
                                $qry->whereNull('team_player_contracts.end_date')
                                    ->orWhere('team_player_contracts.end_date', '>=', $fixture->date_time);
                            })
                            ->orderBy('team_player_contracts.id', 'desc')
                            ->first();

            $fixture->player_is = 'not_in_team';
            if ($plrContract) {
                if ($plrContract->is_active) {
                    $fixture->player_is = 'in_lineup';
                } else {
                    $fixture->player_is = 'substitute';
                }
            }

            $fixture->date = carbon_format_to_date_for_fixture($fixture->date_time);
            $fixture->time = carbon_format_to_time_for_fixture($fixture->date_time);

            if ($fixture->ha == 'H') {
                $fixture->opp = $fixture->away_short_code.'(H)';
            } else {
                $fixture->opp = $fixture->home_short_code.'(A)';
            }
        }

        return $fixtures;
    }

    public function getPlayerHAStats($plrIds, $competition, $season_id = 0)
    {
        if ($season_id == 0) {
            $season_id = Season::getLatestSeason();
        }

        $data = FixtureStats::join('fixtures', function ($join) use ($competition, $season_id) {
            $join->on('fixtures.id', '=', 'fixture_stats.fixture_id')
                                    ->where('fixtures.season_id', $season_id)
                                    ->where('fixtures.competition', $competition);
        })
                        ->join('player_contracts', function ($join) use ($season_id) {
                            if ($season_id == Season::getLatestSeason()) {
                                $join->on('player_contracts.player_id', '=', 'fixture_stats.player_id')
                                ->whereNull('player_contracts.end_date');
                            } else {
                                $end_at = Season::find($season_id)->end_at;
                                $join->on('player_contracts.player_id', '=', 'fixture_stats.player_id')
                                ->where('player_contracts.end_date', '>=', $end_at);
                            }
                        })
                        ->whereIn('fixture_stats.player_id', $plrIds)
                        ->selectRaw("
                            fixture_stats.player_id,
                            SUM(IF(fixture_stats.appearance >= 45 , 1, 0)) AS pld,
                            SUM(fixture_stats.goal) AS gls,
                            SUM(fixture_stats.assist) AS asst,
                            SUM(fixture_stats.goal_conceded) AS ga,
                            SUM(IF(fixture_stats.appearance > 75 AND fixture_stats.goal_conceded = 0 AND fixture_stats.clean_sheet != 0, 1, 0)) AS cs,
                            SUM(IF(fixture_stats.appearance > 45 , 1, 0)) AS app,
                            SUM(IF(fixture_stats.appearance > 45 AND fixture_stats.club_win != 0, fixture_stats.club_win, 0)) AS club_win,
                            SUM(fixture_stats.own_goal) AS own_goal,
                            SUM(fixture_stats.penalty_missed) AS penalty_missed,
                            SUM(fixture_stats.penalty_save) AS penalty_save,
                            SUM(IF(fixture_stats.goalkeeper_save > 0, ((fixture_stats.penalty_save + fixture_stats.goalkeeper_save) DIV 5), 0)) AS goalkeeper_save,
                            SUM(fixture_stats.red_card) AS red_card,
                            SUM(fixture_stats.yellow_card) AS yellow_card,
                            IF (player_contracts.club_id = fixtures.home_club_id,'home','away') AS ha
                        ")
                        ->groupBy('fixture_stats.player_id', 'ha')
                        ->get();

        $statsList = [];
        foreach ($data as $key => $stat) {
            $statsList[$stat->player_id][$stat->ha] = $stat->toArray();
        }

        return $statsList;
    }

    public function getPlayerHistory($division, $player, $season_id = 0, $team = null)
    {
        if ($season_id == 0) {
            $season_id = Season::getLatestSeason();
        }

        $playerHistory = [];

        $fixtures = FixtureStats::join('fixtures', function ($join) use ($season_id) {
            $join->on('fixtures.id', '=', 'fixture_stats.fixture_id')
                                ->where('season_id', $season_id);
        })
                        ->where('fixture_stats.player_id', $player->id)
                        ->selectRaw('
                            fixture_stats.fixture_id,
                            fixture_stats.player_id,
                            fixture_stats.goal,
                            fixture_stats.own_goal,
                            fixture_stats.assist,
                            fixture_stats.appearance,
                            IF(fixture_stats.appearance >= 45 , 1, 0) AS app,
                            fixture_stats.goal_conceded,
                            fixture_stats.red_card,
                            fixture_stats.yellow_card,
                            fixture_stats.penalty_missed,
                            fixture_stats.penalty_save,
                            IF(fixture_stats.goalkeeper_save > 0, ((fixture_stats.penalty_save + fixture_stats.goalkeeper_save) DIV 5), 0) AS goalkeeper_save,
                            IF(fixture_stats.appearance > 75 AND fixture_stats.goal_conceded = 0 AND fixture_stats.clean_sheet != 0, 1, 0) AS clean_sheet,
                            IF(fixture_stats.appearance > 45 AND fixture_stats.club_win != 0, fixture_stats.club_win, 0) AS club_win,
                            fixtures.competition,
                            fixtures.home_club_id,
                            fixtures.away_club_id,
                            fixtures.status,
                            fixtures.home_score,
                            fixtures.away_score,
                            fixtures.ft_home_score,
                            fixtures.ft_away_score,
                            fixtures.outcome,
                            fixtures.date_time')
                        ->orderBy('fixtures.date_time', 'desc')
                        ->get();

        $playerClubs = PlayerContract::where('player_id', $player->id)->pluck('club_id');
        if (! empty($playerClubs)) {
            $playerClubs = $playerClubs->toArray();
            $playerClubs = array_unique($playerClubs);
        }

        $playerPosition = '';
        if (isset($player->position) && trim($player->position) != '') {
            $playerPosition = strtolower(TeamPointsPositionEnum::getKey($player->position));
        } else {
            $playerPosition = strtolower(TeamPointsPositionEnum::getKey($player->playerContract->position));
        }

        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        $plrPosition = player_position_short($player->playerContract->position);
        if ($plrPosition == 'FB' || $plrPosition == 'CB') {
            if ($mergeDefenders == 'Yes') {
                $plrPosition = 'DF';
            }
        } elseif ($plrPosition == 'DMF') {
            if ($defensiveMidfields == 'Yes') {
                $plrPosition = 'DM';
            } else {
                $plrPosition = 'MF';
            }
        }

        if ($playerPosition == self::DEFENSIVE_MID_FIELDER) {
            $playerPosition = ($division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
        }

        if ($playerPosition == self::CENTRE_BACK) {
            $playerPosition = ($division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
        }

        $pointCalc['goals'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL);
        $pointCalc['assist'] = $division->getOptionValue($playerPosition, EventsEnum::ASSIST);
        $pointCalc['clean_sheet'] = $division->getOptionValue($playerPosition, EventsEnum::CLEAN_SHEET);
        $pointCalc['goal_conceded'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL_CONCEDED);
        $pointCalc['appearance'] = $division->getOptionValue($playerPosition, EventsEnum::APPEARANCE);
        $pointCalc['club_win'] = $division->getOptionValue($playerPosition, EventsEnum::CLUB_WIN);
        $pointCalc['yellow_card'] = $division->getOptionValue($playerPosition, EventsEnum::YELLOW_CARD);
        $pointCalc['red_card'] = $division->getOptionValue($playerPosition, EventsEnum::RED_CARD);
        $pointCalc['own_goal'] = $division->getOptionValue($playerPosition, EventsEnum::OWN_GOAL);
        $pointCalc['penalty_missed'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_MISSED);
        $pointCalc['penalty_save'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_SAVE);
        $pointCalc['goalkeeper_save'] = $division->getOptionValue($playerPosition, EventsEnum::GOALKEEPER_SAVE_X5);

        foreach ($fixtures as $key => $fixture) {
            $playerHistory[$fixture->fixture_id]['date'] = carbon_format_to_date_for_fixture($fixture->date_time);
            $playerHistory[$fixture->fixture_id]['time'] = carbon_format_to_time_for_fixture($fixture->date_time);

            $playerHistory[$fixture->fixture_id]['competition'] = $fixture->fixture->competition;

            if (in_array($fixture->home_club_id, $playerClubs)) {
                $playerHistory[$fixture->fixture_id]['opp'] = $fixture->fixture->away_team->short_code.'(H)';

                $outcome = 'L';
                if ($fixture->home_score == $fixture->away_score) {
                    $outcome = 'D';
                } elseif ($fixture->home_score > $fixture->away_score) {
                    $outcome = 'W';
                }

                $playerHistory[$fixture->fixture_id]['res'] = $outcome.'('.$fixture->ft_home_score.'-'.$fixture->ft_away_score.')';
            } else {
                $playerHistory[$fixture->fixture_id]['opp'] = $fixture->fixture->home_team->short_code.'(A)';

                $outcome = 'L';
                if ($fixture->home_score == $fixture->away_score) {
                    $outcome = 'D';
                } elseif ($fixture->away_score > $fixture->home_score) {
                    $outcome = 'W';
                }

                $playerHistory[$fixture->fixture_id]['res'] = $outcome.'('.$fixture->ft_away_score.'-'.$fixture->ft_home_score.')';
            }

            $playerHistory[$fixture->fixture_id]['red_card'] = $fixture->red_card;
            $playerHistory[$fixture->fixture_id]['yellow_card'] = $fixture->yellow_card;
            $playerHistory[$fixture->fixture_id]['appearance'] = $fixture->appearance;
            $playerHistory[$fixture->fixture_id]['assist'] = $fixture->assist;
            $playerHistory[$fixture->fixture_id]['goal'] = $fixture->goal;

            $total = 0;
            $total += (int) ($fixture->goal * $pointCalc['goals']);
            $total += (int) ($fixture->assist * $pointCalc['assist']);

            if ($plrPosition == 'ST' || $plrPosition == 'MF') {
                if ($pointCalc['goal_conceded'] == 0) {
                    $fixture->goal_conceded = 0;
                }
            }
            $total += (int) ($fixture->goal_conceded * $pointCalc['goal_conceded']);

            if ($plrPosition == 'ST' || $plrPosition == 'MF') {
                if ($pointCalc['clean_sheet'] == 0) {
                    $fixture->clean_sheet = 0;
                }
            }
            $total += (int) ($fixture->clean_sheet * $pointCalc['clean_sheet']);

            $total += (int) ($fixture->club_win * $pointCalc['club_win']);
            $total += (int) ($fixture->app * $pointCalc['appearance']);
            $total += (int) ($fixture->own_goal * $pointCalc['own_goal']);
            $total += (int) ($fixture->penalty_missed * $pointCalc['penalty_missed']);
            $total += (int) ($fixture->penalty_save * $pointCalc['penalty_save']);
            $total += (int) ($fixture->goalkeeper_save * $pointCalc['goalkeeper_save']);
            $total += (int) ($fixture->yellow_card * $pointCalc['yellow_card']);
            $total += (int) ($fixture->red_card * $pointCalc['red_card']);

            $playerHistory[$fixture->fixture_id]['total'] = $total;

            $whereCondition = ['team_player_contracts.player_id' => $player->id];
            if ($team != null && isset($team->id)) {
                $whereCondition = ['team_player_contracts.team_id' => $team->id, 'team_player_contracts.player_id' => $player->id];
            }

            $plrContract = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
                            ->join('division_teams', function ($join) use ($division) {
                                $join->on('division_teams.team_id', '=', 'teams.id')
                                    ->where('division_teams.division_id', $division->id)
                                    ->where('division_teams.season_id', Season::getLatestSeason());
                            })
                            ->where($whereCondition)
                            ->where('team_player_contracts.start_date', '<=', $fixture->date_time)
                            ->where(function ($qry) use ($fixture) {
                                $qry->whereNull('team_player_contracts.end_date')
                                    ->orWhere('team_player_contracts.end_date', '>=', $fixture->date_time);
                            })
                            ->orderBy('team_player_contracts.id', 'desc')
                            ->first();

            $playerHistory[$fixture->fixture_id]['player_is'] = 'not_in_team';
            if ($plrContract) {
                if ($plrContract->is_active) {
                    $playerHistory[$fixture->fixture_id]['player_is'] = 'in_lineup';
                } else {
                    $playerHistory[$fixture->fixture_id]['player_is'] = 'substitute';
                }
            }

            $playerHistory[$fixture->fixture_id]['date_time'] = $fixture->date_time;

            $record = FixtureEvent::where('fixture_id', $fixture->fixture_id)
                                ->where('event_type', 2)
                                ->where(function ($q) use ($player) {
                                    $q->where('player_id', $player->id)
                                        ->orWhere('sub_player_id', $player->id);
                                })
                                ->first();

            $playerHistory[$fixture->fixture_id]['is_sub'] = '';
            if ($record) {
                if ($record->sub_player_id == $player->id) {
                    $playerHistory[$fixture->fixture_id]['is_sub'] = 'in';
                } else {
                    $playerHistory[$fixture->fixture_id]['is_sub'] = 'out';
                }
            }
        }

        $contract = PlayerContract::whereNull('end_date')
                        ->where('player_id', $player->id)
                        ->first();

        $club_id = $contract->club_id;

        $fixtures = Fixture::where('season_id', $season_id)
                            ->where(function ($query) use ($club_id) {
                                return $query->where('home_club_id', $club_id)
                                            ->orWhere('away_club_id', $club_id);
                            })
                            ->orderBy('date_time', 'asc')
                            ->get();

        $allFixtures = [];
        foreach ($fixtures as $key => $fixture) {
            if (isset($playerHistory[$fixture->id])) {
                if ($fixture->home_club_id == $club_id || $fixture->away_club_id == $club_id) {
                    $allFixtures[$fixture->id] = $playerHistory[$fixture->id];
                }
            } else {
                if ($fixture->home_club_id == $club_id || $fixture->away_club_id == $club_id) {
                    $allFixtures[$fixture->id]['date'] = carbon_format_to_date_for_fixture($fixture->date_time);
                    $allFixtures[$fixture->id]['time'] = carbon_format_to_time_for_fixture($fixture->date_time);
                    $allFixtures[$fixture->id]['competition'] = $fixture->competition;

                    $allFixtures[$fixture->id]['date_time'] = $fixture->date_time;

                    if (in_array($fixture->home_club_id, $playerClubs)) {
                        $allFixtures[$fixture->id]['opp'] = $fixture->away_team->short_code.'(H)';

                        $outcome = 'L';
                        if ($fixture->home_score == $fixture->away_score) {
                            $outcome = 'D';
                        } elseif ($fixture->home_score > $fixture->away_score) {
                            $outcome = 'W';
                        }

                        $allFixtures[$fixture->id]['res'] = $outcome.'('.$fixture->home_score.'-'.$fixture->away_score.')';
                    } else {
                        $allFixtures[$fixture->id]['opp'] = $fixture->home_team->short_code.'(A)';
                        $outcome = 'L';
                        if ($fixture->home_score == $fixture->away_score) {
                            $outcome = 'D';
                        } elseif ($fixture->away_score > $fixture->home_score) {
                            $outcome = 'W';
                        }

                        $allFixtures[$fixture->id]['res'] = $outcome.'('.$fixture->away_score.'-'.$fixture->home_score.')';
                    }

                    $fixtureDt = Carbon::parse($fixture->date_time);

                    if ($fixtureDt->lt(Carbon::now())) {
                        $whereCondition = ['team_player_contracts.player_id' => $player->id];
                        if ($team != null && isset($team->id)) {
                            $whereCondition = ['team_player_contracts.team_id' => $team->id, 'team_player_contracts.player_id' => $player->id];
                        }

                        $plrContract = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
                                        ->join('division_teams', function ($join) use ($division) {
                                            $join->on('division_teams.team_id', '=', 'teams.id')
                                                ->where('division_teams.division_id', $division->id)
                                                ->where('division_teams.season_id', Season::getLatestSeason());
                                        })
                                        ->where($whereCondition)
                                        ->where('team_player_contracts.start_date', '<=', $fixture->date_time)
                                        ->where(function ($qry) use ($fixture) {
                                            $qry->whereNull('team_player_contracts.end_date')
                                                ->orWhere('team_player_contracts.end_date', '>=', $fixture->date_time);
                                        })
                                        ->orderBy('team_player_contracts.id', 'desc')
                                        ->first();

                        $allFixtures[$fixture->id]['player_is'] = 'not_in_team';
                        if ($plrContract) {
                            if ($plrContract->is_active) {
                                $allFixtures[$fixture->id]['player_is'] = 'in_lineup';
                            } else {
                                $allFixtures[$fixture->id]['player_is'] = 'substitute';
                            }
                        }

                        $record = FixtureEvent::where('fixture_id', $fixture->id)
                                            ->where('event_type', 2)
                                            ->where(function ($q) use ($player) {
                                                $q->where('player_id', $player->id)
                                                    ->orWhere('sub_player_id', $player->id);
                                            })
                                            ->first();

                        $allFixtures[$fixture->id]['is_sub'] = '';
                        if ($record) {
                            if ($record->sub_player_id == $player->id) {
                                $allFixtures[$fixture->id]['is_sub'] = 'in';
                            } else {
                                $allFixtures[$fixture->id]['is_sub'] = 'out';
                            }
                        }
                    }

                    $fixtureDt = Carbon::parse($fixture->date_time);
                    if ($fixtureDt->gt(Carbon::now())) {
                        $allFixtures[$fixture->id]['res'] = 'NA';
                        $allFixtures[$fixture->id]['total'] = 'NA';
                        $allFixtures[$fixture->id]['is_sub'] = 'NA';
                        $allFixtures[$fixture->id]['player_is'] = 'NA';
                        $allFixtures[$fixture->id]['appearance'] = 'NA';
                    }
                }
            }
        }

        return array_values($allFixtures);
    }

    public function swapPlayer($division, $team, $lineup_player, $sub_player, $formation)
    {
        $this->deleteTeamSuperSubData($team->id);
        $now = Carbon::now();
        
        $result = TeamPlayerContract::where('team_id', $team->id)
                                    ->whereIN('player_id', [$lineup_player, $sub_player])
                                    ->whereNull('end_date')
                                    ->update(['end_date' => $now]);

        $result = TeamPlayerContract::create([
            'team_id' => $team->id,
            'player_id' => $lineup_player,
            'is_active' => 0,
            'start_date' => $now,
            'end_date' => null,
        ]);

        $result = TeamPlayerContract::create([
            'team_id' => $team->id,
            'player_id' => $sub_player,
            'is_active' => true,
            'start_date' => $now,
            'end_date' => null,
        ]);

        $transfer_value = Transfer::where('team_id', $team->id)
                                    ->where('player_in', $sub_player)
                                    ->orderBy('transfers.transfer_date', 'desc')
                                    ->select('transfers.transfer_value')
                                    ->first();

        $transfer_amount = $transfer_value ? $transfer_value->transfer_value : null;

        Transfer::create([
            'team_id' => $team->id,
            'player_in' => $sub_player,
            'player_out' => $lineup_player,
            'transfer_type' => TransferTypeEnum::SUBSTITUTION,
            'transfer_value' => $transfer_amount,
            'transfer_date' => $now,
        ]);

        return ['status' => 'success', 'message' => 'Saved'];
    }

    public function deleteTeamSuperSubData($team_id)
    {
        $deleteSuperSubRecords = SupersubTeamPlayerContract::where('team_id', $team_id)->delete();

        return true;
    }

    public function getLineupDataForReport($team, $division)
    {
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        $lineupPlayers = $this->getPlayers($team, 'active', $forPDF = true);
        $subPlayers = $this->getPlayers($team, 'sub', $forPDF = true);

        $formation = '';
        $activePlayers = [];

        $gk = $fb = $cb = $dmf = $mf = $st = 0;

        foreach ($lineupPlayers as $key => $player) {
            $player->position = player_position_short($player->position);
            $player->status = $player->player->playerStatus;
            $player->played = $this->getPlayedMatches($player->player_id);

            $player = $player->toArray();
            unset($player['player']);

            $position = $player['position'];

            if ($position == 'GK') {
                $activePlayers['gk'][] = $player;
                $gk++;
            } elseif ($position == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    $player['position'] = 'DF';
                    $activePlayers['df'][] = $player;
                } else {
                    $activePlayers['fb'][] = $player;
                }
                $fb++;
            } elseif ($position == 'CB') {
                if ($mergeDefenders == 'Yes') {
                    $player['position'] = 'DF';
                    $activePlayers['df'][] = $player;
                } else {
                    $activePlayers['cb'][] = $player;
                }
                $cb++;
            } elseif ($position == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    $player['curr_position'] = 'DM';
                    $player['position'] = 'DM';
                    $activePlayers['dm'][] = $player;
                } else {
                    $player['curr_position'] = 'MF';
                    $player['position'] = 'MF';
                    $activePlayers['mf'][] = $player;
                }
                $dmf++;
            } elseif ($position == 'MF') {
                $player['curr_position'] = 'MF';
                $activePlayers['mf'][] = $player;
                $mf++;
            } elseif ($position == 'ST') {
                $activePlayers['st'][] = $player;
                $st++;
            }
        }

        $formation = ($fb + $cb).'-'.($dmf + $mf).'-'.$st;

        if ($formation == '4-4-2') {
            $activePlayers = $this->get442FormationData($activePlayers);
        } elseif ($formation == '4-5-1') {
            $activePlayers = $this->get451FormationData($activePlayers);
        } elseif ($formation == '4-3-3') {
            $activePlayers = $this->get433FormationData($activePlayers);
        } elseif ($formation == '5-3-2') {
            $activePlayers = $this->get532FormationData($activePlayers);
        } elseif ($formation == '5-4-1') {
            $activePlayers = $this->get541FormationData($activePlayers);
        }

        $teamArray = [];
        $teamArray['gk'] = @$activePlayers['gk'];
        if (isset($activePlayers['df'])) {
            $teamArray['df'] = @$activePlayers['df'];
        } else {
            if (isset($activePlayers['fb'][0])) {
                $teamArray['df'][] = @$activePlayers['fb'][0];
            }
            if (isset($activePlayers['cb'])) {
                foreach ($activePlayers['cb'] as $cb) {
                    $teamArray['df'][] = $cb;
                }
            }
            if (isset($activePlayers['fb'][1])) {
                $teamArray['df'][] = @$activePlayers['fb'][1];
            }
        }
        $teamArray['mf'] = @$activePlayers['mf'];
        $teamArray['st'] = @$activePlayers['st'];

        foreach ($subPlayers as $key => $player) {
            $player->position = player_position_short($player->position);
            $player->status = $player->player->playerStatus;
            $player->played = $this->getPlayedMatches($player->player_id);

            unset($player->player);

            $position = $player->position;
            if ($position == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    $subPlayers[$key]->position = 'DF';
                }
            } elseif ($position == 'CB') {
                if ($mergeDefenders == 'Yes') {
                    $subPlayers[$key]->position = 'DF';
                }
            } elseif ($position == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    $subPlayers[$key]->position = 'DM';
                } else {
                    $subPlayers[$key]->position = 'MF';
                }
            }
        }

        $returnArr['team'] = $team;
        $returnArr['activePlayers'] = $teamArray;
        $returnArr['subPlayers'] = $subPlayers;

        return $returnArr;
    }

    public function getPlayedMatches($player_id)
    {
        $game = FixtureStats::select('player_id', DB::raw('COUNT(*) as played'))
            ->where('appearance', '>', 0)
            ->where('player_id', $player_id)
            ->groupBy('player_id')
            ->groupBy('appearance')->first();

        return $game['played'];
    }

    public function getTeamFixtures($team)
    {
        $clubs = TeamPlayerContract::join('player_contracts', 'team_player_contracts.player_id', '=', 'player_contracts.player_id')
                    ->where('team_id', $team->id)
                    ->whereNull('team_player_contracts.end_date')
                    ->orderBy('club_id')
                    ->select('club_id')
                    ->distinct();

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $lastDate = Carbon::now()->addDays(config('fantasy.future_fixtures_limit_supersub'))->format('Y-m-d H:i:s');

        $fixtures = Fixture::joinSub($clubs, 'clubs', function ($join) {
            $join->on('fixtures.home_club_id', '=', 'clubs.club_id')
                                    ->orOn('fixtures.away_club_id', '=', 'clubs.club_id');
        })
                                ->where('season_id', Season::getLatestSeason())
                                ->where('date_time', '>=', $currentDate)
                                ->where('date_time', '<=', $lastDate)
                                ->orderBy('date_time');

        $fixturesDatetime = $fixtures->select('date_time')
                                ->distinct()
                                ->get();

        $grouped = $fixturesDatetime->mapWithKeys(function ($item) {
            $date = carbon_format_to_datetime_for_fixture($item['date_time']);

            return [$item['date_time'] => ['date_time' => $date, 'date' => carbon_format_to_date_for_fixture($item['date_time']), 'time' => carbon_format_to_time_for_fixture($item['date_time'])]];
        });
        $futureFixturesDates = $grouped->toArray();

        $clubs = $clubs->get();
        $clubsData = $clubs->mapWithKeys(function ($item) {
            return [(string) $item['club_id'] => $item['club_id']];
        });

        $returnArr['teamClubs'] = $clubsData->toArray();
        $returnArr['futureFixturesDates'] = $futureFixturesDates;

        return $returnArr;
    }

    public function getTeamFixturesForSupersubs($team)
    {
        $clubs = TeamPlayerContract::join('player_contracts', 'team_player_contracts.player_id', '=', 'player_contracts.player_id')
                    ->where('team_id', $team->id)
                    ->whereNull('team_player_contracts.end_date')
                    ->orderBy('club_id')
                    ->select('club_id')
                    ->distinct();
        $supersubTeamPlayerContract = SupersubTeamPlayerContract::where('team_id', $team->id)->where('is_applied', false)->whereNull('end_date')->orderBy('start_date', 'desc')->first();
        if (! $supersubTeamPlayerContract) {
            return '';
        }
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $lastDate = $supersubTeamPlayerContract->start_date;

        $fixtures = Fixture::joinSub($clubs, 'clubs', function ($join) {
            $join->on('fixtures.home_club_id', '=', 'clubs.club_id')
                                    ->orOn('fixtures.away_club_id', '=', 'clubs.club_id');
        })
                                ->where('season_id', Season::getLatestSeason())
                                ->where('date_time', '>=', $currentDate)
                                ->where('date_time', '<=', $lastDate)
                                ->orderBy('date_time');

        $fixturesDatetime = $fixtures->select('date_time')
                                ->distinct()
                                ->get();

        $grouped = $fixturesDatetime->mapWithKeys(function ($item) {
            $date = carbon_format_to_datetime_for_fixture($item['date_time']);

            return [$item['date_time'] => ['date_time' => $date, 'date' => carbon_format_to_date_for_fixture($item['date_time']), 'time' => carbon_format_to_time_for_fixture($item['date_time'])]];
        });
        $futureFixturesDates = $grouped->toArray();

        $returnArr['futureFixturesDates'] = $futureFixturesDates;

        return $returnArr;
    }

    public function getPlayersForFixture($teamId, $date)
    {
        $clubs = TeamPlayerContract::join('player_contracts', function ($query) {
            return $query->on('team_player_contracts.player_id', '=', 'player_contracts.player_id')
                                ->whereNull('player_contracts.end_date');
        })
                    ->where('team_id', $teamId)
                    ->whereNull('team_player_contracts.end_date')
                    ->orderBy('club_id');

        $fixtures = Fixture::joinSub($clubs->select('club_id')->distinct(), 'clubs', function ($join) {
            $join->on('fixtures.home_club_id', '=', 'clubs.club_id')
                                    ->orOn('fixtures.away_club_id', '=', 'clubs.club_id');
        })
                                ->where('season_id', Season::getLatestSeason())
                                ->where('date_time', '=', $date)
                                ->select('fixtures.*')
                                ->distinct()
                                ->get();

        $clubPlayers = [];
        $clubFixtures = [];
        foreach ($fixtures as $value) {
            $clubFixtures[] = $value->home_club_id;
            $clubFixtures[] = $value->away_club_id;
        }

        $clubPlayersData = $clubs->whereIn('club_id', $clubFixtures)->select('team_player_contracts.*', 'club_id', 'position')->get();

        foreach ($clubPlayersData as $key => $player) {
            $clubPlayers[] = $player->player_id;
        }

        return $clubPlayers;
    }

    public function getPlayerStatsByType($team, $division)
    {
        $conditions = ['date_interval' => true, 'competition' => CompetitionEnum::PREMIER_LEAGUE];
        $player_stats['current_week'] = $this->getTeamPlayersStats($team, $division, $conditions);

        $conditions = ['date_interval' => false, 'competition' => CompetitionEnum::PREMIER_LEAGUE];
        $player_stats['week_total'] = $this->getTeamPlayersStats($team, $division, $conditions);

        $today = Carbon::now()->format('Y-m-d');

        $prevRound = Fixture::where('competition', CompetitionEnum::FA_CUP)
                            ->where('season_id', Season::getLatestSeason())
                            ->where(DB::raw('CONVERT(fixtures.date_time, DATE)'), '<=', $today)
                            ->select('stage')
                            ->orderBy('id', 'desc')
                            ->first();
        // ->skip(1)->first();

        $player_stats['facup_prev'] = [];
        if (! empty($prevRound)) {
            $conditions = ['date_interval' => false, 'competition' => CompetitionEnum::FA_CUP, 'stage' => $prevRound->stage];
            $player_stats['facup_prev'] = $this->getTeamPlayersStats($team, $division, $conditions);
        }

        $conditions = ['date_interval' => false, 'competition' => CompetitionEnum::FA_CUP];
        $player_stats['facup_total'] = $this->getTeamPlayersStats($team, $division, $conditions);

        return $player_stats;
    }

    public function getTeamPlayersStats($team, $division, $conditions)
    {

        // $seasonFixtureIDs = Fixture::where('season_id', Season::getLatestSeason())->pluck('id');

        $gameweek = '';
        if ($conditions['date_interval']) {
            $date = Carbon::now()->format('Y-m-d');

            $gameweek = GameWeek::where('season_id', Season::getLatestSeason())
                        ->where('start', '<=', now())
                        ->where('end', '>', now())
                        ->first();

            // $gameweeks = GameWeek::where('start', '<', $date)->where('season_id', Season::getLatestSeason());
            // if ($gameweeks) {
            //     $gameweeks = $gameweeks->limit(1);
            // }
            // $gameweek = $gameweeks->orderBy('start', 'desc')->first();
            // $gameweek = $activeGameWeek = GameWeek::where('season_id', Season::getLatestSeason())
            //                 ->where('start', '<=', now())
            //                 ->where('end', '>', now())
            //                 ->first();

            // $gameweek = GameWeek::find($activeGameWeek->id - 1);
        }
        
        if(is_null($gameweek)) {
            return null;
        }
        
        $playerStats = TeamPlayerPoint::join('team_points', 'team_points.id', '=', 'team_player_points.team_point_id')
                                ->join('fixtures', function ($query) use ($division, $conditions, $gameweek) {
                                    $query->on('fixtures.id', '=', 'team_points.fixture_id');
                                    if ($conditions['date_interval']) {
                                        $query->whereBetween('fixtures.date_time', [$gameweek->start, $gameweek->end]);
                                    }
                                    if (isset($conditions['stage'])) {
                                        $query->where('fixtures.stage', $conditions['stage']);
                                    }
                                    $query->where('fixtures.competition', $conditions['competition'])
                                                ->where('season_id', Season::getLatestSeason());
                                })
                                ->selectRaw('
                                    team_player_points.player_id,
                                    COUNT(*) AS pld,
                                    SUM(team_player_points.goal) as gls,
                                    SUM(team_player_points.assist) as asst,
                                    SUM(team_player_points.clean_sheet) as cs,
                                    SUM(team_player_points.conceded) as ga,
                                    SUM(team_player_points.club_win) as cw,
                                    SUM(team_player_points.yellow_card) as yc,
                                    SUM(team_player_points.red_card) as rc,
                                    SUM(team_player_points.own_goal) as og,
                                    SUM(team_player_points.penalty_missed) as pm,
                                    SUM(team_player_points.penalty_saved) as ps,
                                    SUM(team_player_points.goalkeeper_save) as gs,
                                    SUM(team_player_points.total) as total
                                ')
                                ->where('team_player_points.team_id', $team->id)
                                ->groupBy('team_player_points.player_id')
                                ->get();

        $plrStats = [];
        foreach ($playerStats as $key => $stats) {
            $query = 'SELECT count(*) as played FROM team_player_contracts LEFT JOIN fixture_stats ON fixture_stats.player_id = team_player_contracts.player_id AND fixture_stats.fixture_id IN( SELECT id FROM fixtures WHERE competition = "'.$conditions['competition'].'" AND season_id = '.Season::getLatestSeason().' AND( (team_player_contracts.start_date <= fixtures.date_time AND team_player_contracts.end_date > fixtures.date_time) OR (team_player_contracts.start_date <= fixtures.date_time AND team_player_contracts.end_date IS NULL) ) ) WHERE team_player_contracts.team_id = '.$team->id.' AND team_player_contracts.is_active = 1 AND team_player_contracts.player_id = '.$stats->player_id.' AND appearance >= 45';

            $result = DB::select($query);

            $stats->pld = @$result[0]->played;

            $plrStats[$stats->player_id] = $stats->toArray();
        }

        return $plrStats;
    }

    public function getPointCalculations($team, $division, $players)
    {
        $point_calculations = [];
        foreach ($players as $player_id => $position) {
            $playerPosition = strtolower(TeamPointsPositionEnum::getKey($position));
            $point_calculations[$player_id]['position'] = $position;
            $point_calculations[$player_id]['goals'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL);
            $point_calculations[$player_id]['assist'] = $division->getOptionValue($playerPosition, EventsEnum::ASSIST);
            $point_calculations[$player_id]['clean_sheet'] = $division->getOptionValue($playerPosition, EventsEnum::CLEAN_SHEET);
            $point_calculations[$player_id]['goal_conceded'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL_CONCEDED);
            $point_calculations[$player_id]['appearance'] = $division->getOptionValue($playerPosition, EventsEnum::APPEARANCE);
            $point_calculations[$player_id]['club_win'] = $division->getOptionValue($playerPosition, EventsEnum::CLUB_WIN);
            $point_calculations[$player_id]['yellow_card'] = $division->getOptionValue($playerPosition, EventsEnum::YELLOW_CARD);
            $point_calculations[$player_id]['red_card'] = $division->getOptionValue($playerPosition, EventsEnum::RED_CARD);
            $point_calculations[$player_id]['own_goal'] = $division->getOptionValue($playerPosition, EventsEnum::OWN_GOAL);
            $point_calculations[$player_id]['penalty_missed'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_MISSED);
            $point_calculations[$player_id]['penalty_save'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_SAVE);
            $point_calculations[$player_id]['goalkeeper_save'] = $division->getOptionValue($playerPosition, EventsEnum::GOALKEEPER_SAVE_X5);
        }

        return $point_calculations;
    }

    public function getPlayerStatsBySeason($team, $player, $season)
    {
        $player = $team->teamPlayerContract->where('player_id', $player->id)
                                        ->whereNull('end_date')
                                        ->first();

        $plrIds = [$player->player->id];
        $division = $team->teamDivision->first();

        $plrStatsPreLeague = $this->getPlayerHAStats($plrIds, CompetitionEnum::PREMIER_LEAGUE, $season->id);
        $plrStatsFACup = $this->getPlayerHAStats($plrIds, CompetitionEnum::FA_CUP, $season->id);

        $plrStats = [];

        $plrStats[$player->player->id] = $this->generateStats($player, $division, $team, $plrStatsPreLeague, $plrStatsFACup, $season->id);

        return $plrStats;
    }

    public function getPlayerSeasonStats($team, $division)
    {
        $players = TeamPlayerContract::where('team_id', $team->id)->whereNull('end_date')->pluck('player_id', 'id');
        // $clubs = PlayerContract::whereIn('player_id', $players)->pluck('player_id', 'club_id');
        // $clubs = array_keys($clubs->toArray());

        $playerStats = FixtureStats::join('fixtures', function ($join) {
            $join->on('fixtures.id', '=', 'fixture_stats.fixture_id')
                                    ->where('fixtures.season_id', Season::getLatestSeason());
        })
                        ->join('player_contracts', function ($join) {
                            $join->on('player_contracts.player_id', '=', 'fixture_stats.player_id');
                        })
                        ->whereIn('fixture_stats.player_id', $players)
                        ->selectRaw('
                            fixture_stats.player_id,
                            player_contracts.position,
                            COUNT(*) AS pld,
                            SUM(fixture_stats.goal) AS gls,
                            SUM(fixture_stats.assist) AS asst,
                            SUM(fixture_stats.goal_conceded) AS ga,
                            SUM(IF(fixture_stats.appearance > 75 AND fixture_stats.goal_conceded = 0 AND fixture_stats.clean_sheet != 0, 1, 0)) AS cs,
                            SUM(IF(fixture_stats.appearance > 45 , 1, 0)) AS app,
                            SUM(IF(fixture_stats.appearance > 45 AND fixture_stats.club_win != 0, fixture_stats.club_win, 0)) AS club_win,
                            SUM(fixture_stats.own_goal) AS own_goal,
                            SUM(fixture_stats.penalty_missed) AS penalty_missed,
                            SUM(fixture_stats.penalty_save) AS penalty_save,
                            SUM(IF(fixture_stats.goalkeeper_save > 0, ((fixture_stats.penalty_save + fixture_stats.goalkeeper_save) DIV 5), 0)) AS goalkeeper_save,
                            SUM(fixture_stats.red_card) AS red_card,
                            SUM(fixture_stats.yellow_card) AS yellow_card
                        ')
                        ->groupBy('fixture_stats.player_id', 'player_contracts.position')
                        ->get();

        foreach ($playerStats as $key => $player) {
            $playerPosition = strtolower(TeamPointsPositionEnum::getKey($player->position));
            if ($playerPosition == self::DEFENSIVE_MID_FIELDER) {
                $playerPosition = ($division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
            }

            if ($playerPosition == self::CENTRE_BACK) {
                $playerPosition = ($division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
            }

            $pointCalc[$player->player_id]['goals'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL);
            $pointCalc[$player->player_id]['assist'] = $division->getOptionValue($playerPosition, EventsEnum::ASSIST);
            $pointCalc[$player->player_id]['clean_sheet'] = $division->getOptionValue($playerPosition, EventsEnum::CLEAN_SHEET);
            $pointCalc[$player->player_id]['goal_conceded'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL_CONCEDED);
            $pointCalc[$player->player_id]['appearance'] = $division->getOptionValue($playerPosition, EventsEnum::APPEARANCE);
            $pointCalc[$player->player_id]['club_win'] = $division->getOptionValue($playerPosition, EventsEnum::CLUB_WIN);
            $pointCalc[$player->player_id]['yellow_card'] = $division->getOptionValue($playerPosition, EventsEnum::YELLOW_CARD);
            $pointCalc[$player->player_id]['red_card'] = $division->getOptionValue($playerPosition, EventsEnum::RED_CARD);
            $pointCalc[$player->player_id]['own_goal'] = $division->getOptionValue($playerPosition, EventsEnum::OWN_GOAL);
            $pointCalc[$player->player_id]['penalty_missed'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_MISSED);
            $pointCalc[$player->player_id]['penalty_save'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_SAVE);
            $pointCalc[$player->player_id]['goalkeeper_save'] = $division->getOptionValue($playerPosition, EventsEnum::GOALKEEPER_SAVE_X5);
        }

        $playerStatsArray = [];
        foreach ($playerStats as $key => $player) {
            $total = 0;
            $total += (int) ($player->app * $pointCalc[$player->player_id]['appearance']);
            $total += (int) ($player->gls * $pointCalc[$player->player_id]['goals']);
            $total += (int) ($player->asst * $pointCalc[$player->player_id]['assist']);
            $total += (int) ($player->ga * $pointCalc[$player->player_id]['goal_conceded']);
            $total += (int) ($player->cs * $pointCalc[$player->player_id]['clean_sheet']);
            $total += (int) ($player->club_win * $pointCalc[$player->player_id]['club_win']);
            $total += (int) ($player->own_goal * $pointCalc[$player->player_id]['own_goal']);
            $total += (int) ($player->penalty_missed * $pointCalc[$player->player_id]['penalty_missed']);
            $total += (int) ($player->penalty_save * $pointCalc[$player->player_id]['penalty_save']);
            $total += (int) ($player->goalkeeper_save * $pointCalc[$player->player_id]['goalkeeper_save']);
            $total += (int) ($player->yellow_card * $pointCalc[$player->player_id]['yellow_card']);
            $total += (int) ($player->red_card * $pointCalc[$player->player_id]['red_card']);
            $player->total = $total;

            $playerStatsArray[$player->player_id] = $player->toArray();
        }

        return $playerStatsArray;
    }

    public function getPlayerStatsBySeasonSingle($division, $playerId, $seasonId)
    {
        $player = Player::find($playerId);
        $plrIds = [$player->id];

        $plrStatsPreLeague = $this->getPlayerHAStats($plrIds, CompetitionEnum::PREMIER_LEAGUE, $seasonId);
        $plrStatsFACup = $this->getPlayerHAStats($plrIds, CompetitionEnum::FA_CUP, $seasonId);

        $plrStats = [];
        $plrStats[$player->id] = $this->generateStatsSingle($player, $division, $plrStatsPreLeague, $plrStatsFACup, $seasonId);

        return $plrStats;
    }

    public function generateStatsSingle($player, $division, $plrStatusPreLeague, $plrStatusFACup, $season_id = 0)
    {
        if ($season_id == 0) {
            $season_id = Season::getLatestSeason();
        }

        unset($data);

        $playerPosition = strtolower(TeamPointsPositionEnum::getKey($player->playerContract->position));
        if ($playerPosition == self::DEFENSIVE_MID_FIELDER) {
            $playerPosition = ($division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
        }

        if ($playerPosition == self::CENTRE_BACK) {
            $playerPosition = ($division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
        }

        $pointCalc['goals'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL);
        $pointCalc['assist'] = $division->getOptionValue($playerPosition, EventsEnum::ASSIST);
        $pointCalc['clean_sheet'] = $division->getOptionValue($playerPosition, EventsEnum::CLEAN_SHEET);
        $pointCalc['goal_conceded'] = $division->getOptionValue($playerPosition, EventsEnum::GOAL_CONCEDED);
        $pointCalc['appearance'] = $division->getOptionValue($playerPosition, EventsEnum::APPEARANCE);
        $pointCalc['club_win'] = $division->getOptionValue($playerPosition, EventsEnum::CLUB_WIN);
        $pointCalc['yellow_card'] = $division->getOptionValue($playerPosition, EventsEnum::YELLOW_CARD);
        $pointCalc['red_card'] = $division->getOptionValue($playerPosition, EventsEnum::RED_CARD);
        $pointCalc['own_goal'] = $division->getOptionValue($playerPosition, EventsEnum::OWN_GOAL);
        $pointCalc['penalty_missed'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_MISSED);
        $pointCalc['penalty_save'] = $division->getOptionValue($playerPosition, EventsEnum::PENALTY_SAVE);
        $pointCalc['goalkeeper_save'] = $division->getOptionValue($playerPosition, EventsEnum::GOALKEEPER_SAVE_X5);

        $data['id'] = $player->id;
        $data['first_name'] = $player->first_name;
        $data['last_name'] = $player->last_name;
        $data['image'] = $player->getPlayerCrest();
        $data['position'] = $division->getPositionShortCode(player_position_short($player->playerContract->position));
        $data['status'] = null;
        if ($player->playerStatus) {
            $data['status'] = $player->playerStatus->toArray();
        }

        $data['club'] = $player->playerContract->club->toArray();
        unset($data['club']['active_players']);

        $data['game_stats']['point_calculation'] = $pointCalc;

        if ($data['position'] == 'ST' || $data['position'] == 'MF') {
            if ($pointCalc['goal_conceded'] == 0) {
                $plrStatusPreLeague[$player->id]['home']['ga'] = 0;
                $plrStatusPreLeague[$player->id]['away']['ga'] = 0;
            }
            if ($pointCalc['clean_sheet'] == 0) {
                $plrStatusPreLeague[$player->id]['home']['cs'] = 0;
                $plrStatusPreLeague[$player->id]['away']['cs'] = 0;
            }
        }

        if (isset($plrStatusPreLeague[$player->id])) {
            // home total point calculation
            $total = 0;
            if (isset($plrStatusPreLeague[$player->id]['home'])) {
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['home']['red_card'] * $pointCalc['red_card']);
            }
            $plrStatusPreLeague[$player->id]['home']['total'] = $total;
            $data['game_stats']['premier_league'] = $plrStatusPreLeague[$player->id];

            // away total point calculation
            $total = 0;
            if (isset($plrStatusPreLeague[$player->id]['away'])) {
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusPreLeague[$player->id]['away']['red_card'] * $pointCalc['red_card']);
            }

            $plrStatusPreLeague[$player->id]['away']['total'] = $total;
            $data['game_stats']['premier_league'] = $plrStatusPreLeague[$player->id];
        }

        if (isset($plrStatusFACup[$player->id])) {
            if ($data['position'] == 'ST' || $data['position'] == 'MF') {
                if ($pointCalc['goal_conceded'] == 0) {
                    $plrStatusFACup[$player->id]['home']['ga'] = 0;
                    $plrStatusFACup[$player->id]['away']['ga'] = 0;
                }
                if ($pointCalc['clean_sheet'] == 0) {
                    $plrStatusFACup[$player->id]['home']['cs'] = 0;
                    $plrStatusFACup[$player->id]['away']['cs'] = 0;
                }
            }

            // home total point calculation
            $total = 0;
            if (isset($plrStatusFACup[$player->id]['home'])) {
                $total += (int) (@$plrStatusFACup[$player->id]['home']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusFACup[$player->id]['home']['red_card'] * $pointCalc['red_card']);
            }
            $plrStatusFACup[$player->id]['home']['total'] = $total;
            $data['game_stats']['fa_cup'] = $plrStatusFACup[$player->id];

            // away total point calculation
            $total = 0;
            if (isset($plrStatusFACup[$player->id]['away'])) {
                $total += (int) (@$plrStatusFACup[$player->id]['away']['app'] * $pointCalc['appearance']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['gls'] * $pointCalc['goals']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['asst'] * $pointCalc['assist']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['ga'] * $pointCalc['goal_conceded']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['cs'] * $pointCalc['clean_sheet']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['club_win'] * $pointCalc['club_win']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['own_goal'] * $pointCalc['own_goal']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['penalty_missed'] * $pointCalc['penalty_missed']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['penalty_save'] * $pointCalc['penalty_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['goalkeeper_save'] * $pointCalc['goalkeeper_save']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['yellow_card'] * $pointCalc['yellow_card']);
                $total += (int) (@$plrStatusFACup[$player->id]['away']['red_card'] * $pointCalc['red_card']);
            }

            $plrStatusFACup[$player->id]['away']['total'] = $total;
            $data['game_stats']['fa_cup'] = $plrStatusFACup[$player->id];
        }

        $data['game_stats']['history'] = $this->getPlayerHistory($division, $player, $season_id);
        // $data['game_stats']['fixtures'] = $this->getPlayerFutureFixtures($division, $player, $season_id);

        return $data;
    }

    public function checkTeamNextFixtureUpdatedData($data)
    {
        if (! isset($data['fixture_date'])) {
            return 0;
        }
        $count = TeamPlayerContract::where('team_id', $data['team_id'])
                                            ->where('start_date', $data['fixture_date'])
                                            ->whereNull('end_date')
                                            ->count();

        return $count;
    }

    public function getTeamSuperSubFixtures($data)
    {
        if (! is_array($data['clubs'])) {
            $data['clubs'] = json_decode($data['clubs'], true);
        }
        $clubs = Fixture::join('clubs as home_club', 'home_club.id', '=', 'fixtures.home_club_id')
                        ->join('clubs as away_club', 'away_club.id', '=', 'fixtures.away_club_id')
                        ->where(function ($query) use ($data) {
                            $query->whereIn('home_club_id', $data['clubs'])
                                  ->orWhereIn('away_club_id', $data['clubs']);
                        })
                        ->where('season_id', Season::getLatestSeason())
                        ->where('date_time', $data['date_time'])
                        ->get(['home_club.name as home_club_name', 'away_club.name as away_club_name']);

        return $clubs;
    }

    public function getSupersubGuideCounter()
    {
        $user_id = auth()->user()->id;
        $record = SupersubGuideCounter::find($user_id);
        if (isset($record)) {
            if ($record->counter <= config('app.supersub_guide_counter')) {
                $record->counter = $record->counter + 1;
                $record->save();
            }
        } else {
            $record = new SupersubGuideCounter;
            $record->user_id = $user_id;
            $record->counter = 1;
            $record->save();
        }

        if ($record->counter <= config('app.supersub_guide_counter')) {
            return true;
        } else {
            return false;
        }
    }

    public function getTeamSuperSubFixtureDates($team)
    {
        $superSubDates = SupersubTeamPlayerContract::where('team_id', $team->id)
                    ->where('is_applied', false)
                    ->select('start_date')
                    ->distinct()
                    ->pluck('start_date');

        return $superSubDates;
    }

    public function getTeamPlayersMoreStats($division, $team, $conditions)
    {
        $allPlayerPoints = $this->getPlayerStatsByType($team, $division);

        // Team player details
        $teamPlayers = TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
                                        ->join('player_contracts', function ($query) {
                                            $query->on('players.id', '=', 'player_contracts.player_id')
                                                    ->whereNull('player_contracts.end_date');
                                        })
                                        ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                                        ->where('team_player_contracts.team_id', $team->id)
                                        ->whereNull('team_player_contracts.end_date')
                                        ->selectRaw('team_player_contracts.player_id, team_player_contracts.is_active, players.first_name, players.last_name, player_contracts.position, clubs.name as club_name, clubs.short_code')
                                        ->orderByRaw('players.first_name, players.last_name')
                                        ->get();

        foreach ($teamPlayers as $key => $player) {
            $player->position = player_position_short($player->position);
        }

        // Team players stats
        $playerStats = TeamPlayerPoint::join('team_points', 'team_points.id', '=', 'team_player_points.team_point_id')
                                ->join('fixtures', function ($query) use ($division, $conditions) {
                                    $query->on('fixtures.id', '=', 'team_points.fixture_id');
                                    $query->where('fixtures.competition', $conditions['competition'])
                                                ->where('season_id', Season::getLatestSeason());
                                })
                                ->selectRaw('
                                    team_player_points.player_id,
                                    SUM(team_player_points.appearance) AS pld,
                                    SUM(team_player_points.goal) as gls,
                                    SUM(team_player_points.assist) as ass,
                                    SUM(team_player_points.clean_sheet) as cs,
                                    SUM(team_player_points.conceded) as ga,
                                    SUM(team_player_points.club_win) as cw,
                                    SUM(team_player_points.yellow_card) as yc,
                                    SUM(team_player_points.red_card) as rc,
                                    SUM(team_player_points.own_goal) as og,
                                    SUM(team_player_points.penalty_missed) as pm,
                                    SUM(team_player_points.penalty_saved) as ps,
                                    SUM(team_player_points.goalkeeper_save) as gs,
                                    SUM(team_player_points.total) as total
                                ')
                                ->where('team_player_points.team_id', $team->id)
                                ->groupBy('team_player_points.player_id')
                                ->get()->keyBy('player_id');

        $clubPlayers = [];

        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        $gk = $fb = $cb = $dmf = $mf = $st = 0;

        foreach ($teamPlayers as $key => $player) {
            $value = Transfer::where('player_in', $player->player_id)
                                    ->where('team_id', $team->id)
                                    ->orderBy('transfers.transfer_date', 'desc')
                                    ->select('transfers.transfer_value')
                                    ->first();

            $player->transfer_value = $value->transfer_value > 0 ? $value->transfer_value : '0.00';

            $player->pld = @$playerStats[$player->player_id]->pld > 0 ? $playerStats[$player->player_id]->pld : 0;
            $player->gls = @$playerStats[$player->player_id]->gls > 0 ? $playerStats[$player->player_id]->gls : 0;
            $player->ass = @$playerStats[$player->player_id]->ass > 0 ? $playerStats[$player->player_id]->ass : 0;
            $player->cs = @$playerStats[$player->player_id]->cs > 0 ? $playerStats[$player->player_id]->cs : 0;
            $player->ga = @$playerStats[$player->player_id]->ga > 0 ? $playerStats[$player->player_id]->ga : 0;
            $player->cw = @$playerStats[$player->player_id]->cw > 0 ? $playerStats[$player->player_id]->cw : 0;
            $player->yc = @$playerStats[$player->player_id]->yc > 0 ? $playerStats[$player->player_id]->yc : 0;
            $player->rc = @$playerStats[$player->player_id]->rc > 0 ? $playerStats[$player->player_id]->rc : 0;
            $player->og = @$playerStats[$player->player_id]->og > 0 ? $playerStats[$player->player_id]->og : 0;
            $player->pm = @$playerStats[$player->player_id]->pm > 0 ? $playerStats[$player->player_id]->pm : 0;
            $player->ps = @$playerStats[$player->player_id]->ps > 0 ? $playerStats[$player->player_id]->ps : 0;
            $player->gs = @$playerStats[$player->player_id]->gs > 0 ? $playerStats[$player->player_id]->gs : 0;

            $player->total = 0;
            if (isset($playerStats[$player->player_id]) && $playerStats[$player->player_id]->total > 0) {
                $player->total = $playerStats[$player->player_id]->total;
            }

            $playerObj = (object) ['player_id' => $player->player_id, 'team_id' => $team->id];

            if ($player->is_active == 1) {
                $nxtFixtureStatus = 'in';
            } else {
                $nxtFixtureStatus = 'out';
            }

            if ($conditions['competition'] == CompetitionEnum::PREMIER_LEAGUE) {
                $player->week_points = 0;
                if (isset($allPlayerPoints['current_week'][$player->player_id])
                    && trim($allPlayerPoints['current_week'][$player->player_id]) != ''
                    && $allPlayerPoints['current_week'][$player->player_id] > 0) {
                    $player->week_points = $allPlayerPoints['current_week'][$player->player_id];
                }

                $player->nextFixture = $this->getNextFixtureData($division, $team, $playerObj, $nxtFixtureStatus, CompetitionEnum::PREMIER_LEAGUE);
            } else {
                $player->week_points = isset($allPlayerPoints['facup_prev'][$player->player_id]) ? $allPlayerPoints['facup_prev'][$player->player_id] : 0;

                $player->nextFixture = $this->getNextFixtureData($division, $team, $playerObj, $nxtFixtureStatus, CompetitionEnum::FA_CUP);
            }

            if ($player->position == 'GK') {
                $clubPlayers['gk'][] = $player->toArray();
                $gk++;
            } elseif ($player->position == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    $player->position = 'DF';
                    $clubPlayers['df'][] = $player->toArray();
                } else {
                    $clubPlayers['fb'][] = $player->toArray();
                }
                $fb++;
            } elseif ($player->position == 'CB') {
                if ($mergeDefenders == 'Yes') {
                    $player->position = 'DF';
                    $clubPlayers['df'][] = $player->toArray();
                } else {
                    $clubPlayers['cb'][] = $player->toArray();
                }
                $cb++;
            } elseif ($player->position == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    $player->position = 'DM';
                    $clubPlayers['dm'][] = $player->toArray();
                } else {
                    $player->position = 'MF';
                    $clubPlayers['mf'][] = $player->toArray();
                }
                $dmf++;
            } elseif ($player->position == 'MF') {
                $clubPlayers['mf'][] = $player->toArray();
                $mf++;
            } elseif ($player->position == 'ST') {
                $clubPlayers['st'][] = $player->toArray();
                $st++;
            }
        }

        $formation = ($fb + $cb).'-'.($dmf + $mf).'-'.$st;

        if ($formation == '4-4-2') {
            $clubPlayers = $this->get442FormationData($clubPlayers);
        } elseif ($formation == '4-5-1') {
            $clubPlayers = $this->get451FormationData($clubPlayers);
        } elseif ($formation == '4-3-3') {
            $clubPlayers = $this->get433FormationData($clubPlayers);
        } elseif ($formation == '5-3-2') {
            $clubPlayers = $this->get532FormationData($clubPlayers);
        } elseif ($formation == '5-4-1') {
            $clubPlayers = $this->get541FormationData($clubPlayers);
        }

        $teamArray = [];
        $teamArray['gk'] = @$clubPlayers['gk'];

        if (isset($clubPlayers['df'])) {
            $teamArray['df'] = @$clubPlayers['df'];
        } else {
            if (isset($clubPlayers['fb'][0])) {
                $teamArray['df'][] = @$clubPlayers['fb'][0];
            }
            if (isset($clubPlayers['cb'])) {
                foreach ($clubPlayers['cb'] as $cb) {
                    $teamArray['df'][] = $cb;
                }
            }
            if (isset($clubPlayers['fb'][1])) {
                $teamArray['df'][] = @$clubPlayers['fb'][1];
            }
        }
        $teamArray['mf'] = @$clubPlayers['mf'];
        $teamArray['st'] = @$clubPlayers['st'];

        return $teamArray;
    }
}