<?php

namespace App\Repositories;

use Setting;
use App\Models\Season;
use App\Models\GameWeek;
use App\Models\Division;
use App\Models\Package;
use App\Models\LogsRolloverData;

class SeasonRepository
{
    public function create($data)
    {
        // $freePackage = Package::getFree();
        // if ($freePackage) {
        //     Setting::set('free_package', $freePackage->id);
        // }
        // Setting::save();

        return Season::create([
            'name' => $data['name'],
            'default_package' => $data['package_id'],
            'default_package_for_existing_user' => $data['default_package_for_existing_user'],
            'available_packages' => $data['available_packages'],
            'premier_api_id' => $data['premier_api_id'],
            'facup_api_id' => $data['facup_api_id'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }

    public function update($season, $data)
    {

        // $freePackage = Package::getFree();
        // if ($freePackage) {
        //     Setting::set('free_package', $freePackage->id);
        // }
        // Setting::save();

        $season->fill([
            'name' => $data['name'],
            'default_package' => $data['package_id'],
            'default_package_for_existing_user' => $data['default_package_for_existing_user'],
            'available_packages' => $data['available_packages'],
            'premier_api_id' => $data['premier_api_id'],
            'facup_api_id' => $data['facup_api_id'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);

        $season->save();

        return $season;
    }

    public function getSeasons()
    {
        return Season::orderByDesc('id');
    }

    public function getSeasonsFromIds($seasonIds)
    {
        $seasons = Season::whereNotIn('id', $seasonIds)
        ->whereDate('end_at', '<=', now())
        ->orderBy('created_at', 'desc')
        ->get();

        return $seasons;
    }

    public function rollover($season, $data)
    {
        return true;
        
        info('Start season rollover data... '.now());
        $log = LogsRolloverData::begin();

        $packages = Package::where('is_enabled', 'Yes')->get();

        $seasonDivisions = Division::with(['divisionTeams' => function($q) use ($data) {
                        $q->where('season_id', $data['duplicate_from']);
                    }])->get();

        //Carry forward rules #1468 please check latest comment by Fantasy League
        //A) NUMBER OF LEAGUES + TEAMS THAT HAVE COMPLETED AN AUCTION IN 2019/20
        //B) NUMBER OF COUNT OF LEAGUES + TEAMS THAT HAVE 4 OR MORE TEAMS IN 2019/20

        $totalClosedAuction = 0;
        $graterThan4Teams = 0;
        foreach ($seasonDivisions as $seasonDivision) {

            $isCarryForward = false;
            if($seasonDivision->auction_closing_date) {
                $totalClosedAuction++;
                $isCarryForward = true;
            }

            if($seasonDivision->divisionTeams->count() >= 4) {
                $graterThan4Teams++;
                $isCarryForward = true;
            }

            if($isCarryForward) {

                if($seasonDivision->package_id == 7) {
                    $package = $packages->where('display_name','Legend')->first();
                } else {
                    $package = $packages->where('copy_from',$seasonDivision->package_id)->first();
                }

                $newSeasonDivision = $seasonDivision->replicate();
                $newSeasonDivision->auction_date = null;
                $newSeasonDivision->auction_closing_date = null;
                $newSeasonDivision->seal_bid_increment = null;
                $newSeasonDivision->seal_bid_minimum = null;
                $newSeasonDivision->first_seal_bid_deadline = null;
                $newSeasonDivision->max_seal_bids_per_team_per_round = null;
                $newSeasonDivision->is_round_process = false;
                $newSeasonDivision->is_viewed_package_selection = true;
                $newSeasonDivision->is_legacy = true;
                $newSeasonDivision->auctioneer_id = null;
                $newSeasonDivision->auction_venue = null;
                $newSeasonDivision->champions_league_team = null;
                $newSeasonDivision->europa_league_team_1 = null;
                $newSeasonDivision->europa_league_team_2 = null;
                $newSeasonDivision->package_id = $package ? $package->id : $season->default_package_for_existing_user;
                $newSeasonDivision->save();

                info('Created new league '.$newSeasonDivision->name);


                foreach ($seasonDivision->divisionPoints as $point) {
                    $newPoint = $point->replicate();
                    $newPoint->division_id = $newSeasonDivision->id;
                    $newPoint->save();
                }

                $team_budget = $newSeasonDivision->getOptionValue('pre_season_auction_budget');
                $budget_rollover = $newSeasonDivision->getOptionValue('budget_rollover');

                foreach ($seasonDivision->divisionTeams as $divisionTeam) {
                    $newDivisionTeam = $divisionTeam->replicate();
                    $newDivisionTeam->season_quota_used = 0;
                    $newDivisionTeam->monthly_quota_used = 0;
                    $newDivisionTeam->is_legacy = true;
                    $newDivisionTeam->team_budget = $budget_rollover == 'Yes' ? $divisionTeam->team_budget : $team_budget;
                    $newDivisionTeam->save();
                    $newDivisionTeam->teamDivision()->attach($newSeasonDivision->id, ['season_id'=> $season->id, 'is_free'=> 0]);

                    info('Created new team '.$newDivisionTeam->name);
                }
            }
        }

        info('NUMBER OF LEAGUES + TEAMS THAT HAVE COMPLETED AN AUCTION IN 2019/20 : '.$totalClosedAuction);
        info('NUMBER OF COUNT OF LEAGUES + TEAMS THAT HAVE 4 OR MORE TEAMS IN 2019/20 : '.$graterThan4Teams);

        // $gameWeeks = GameWeek::where('season_id', $data['duplicate_from'])->get();

        // foreach ($gameWeeks as $gameWeek) {
        //     $newGameWeek = $gameWeek->replicate();

        //     $newGameWeek->start = $gameWeek->start->addWeeks(52)->startOfDay();
        //     $newGameWeek->end = $gameWeek->end->addWeeks(52)->startOfDay();

        //     $newGameWeek->season_id = $season->id;
        //     $newGameWeek->save();

        //     foreach ($gameWeek->europeanPhases as $phaseE) {
        //         $newPhaseE = $phaseE->replicate();
        //         $newPhaseE->gameweek_id = $newGameWeek->id;
        //         $newPhaseE->save();
        //     }

        //     foreach ($gameWeek->leaguePhases as $phaseL) {
        //         $newPhaseL = $phaseL->replicate();
        //         $newPhaseL->gameweek_id = $newGameWeek->id;
        //         $newPhaseL->save();
        //     }

        //     foreach ($gameWeek->proCupPhases as $phaseP) {
        //         $newPhaseP = $phaseP->replicate();
        //         $newPhaseP->gameweek_id = $newGameWeek->id;
        //         $newPhaseP->save();
        //     }
        // }

        $log->end();
        info('End season rollover data... '.now());

        return $season;
    }

    public function getAllPackages()
    {
        return Package::all();
    }

    public function getLatestEndSeason()
    {
        return Season::find(Season::getPreviousSeason());
    }
}
