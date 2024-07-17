<?php

namespace App\Http\Controllers\Manager;

use App\DataTables\MonthTeamRankingDataTable;
use App\DataTables\SeasonTeamRankingDataTable;
use App\DataTables\WeekTeamRankingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\Package;
use App\Models\Season;
use App\Services\TeamService;
use Illuminate\Http\Request;

class LeagueStandingsController extends Controller
{
    /**
     * @var TeamService
     */
    protected $service;

    /**
     * DivisionsController constructor.
     *
     * @param DivisionService $service
     */
    public function __construct(TeamService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Division $division)
    {
        $season = Season::with('gameweeks')->find(Season::getLatestSeason());
        $gameweeks = $season->gameweeks;

        $activeWeekId = $this->service->leagStandingAcitveGameWeek($gameweeks);

        $packages = Package::whereIn('id', $season->available_packages)->where('private_league', 'Yes')->pluck('name', 'id');

        $fixturesStart = Fixture::where('season_id', Season::getLatestSeason())->orderBy('date_time', 'asc')->first();
        $fixturesEnd = Fixture::where('season_id', Season::getLatestSeason())->orderBy('date_time', 'desc')->first();

        $months = collect();
        if($fixturesStart) {
            $months = carbon_get_months_between_dates($fixturesStart->date_time, $fixturesEnd->date_time);
        }

        return view('manager.divisions.ranking.standings', compact('division', 'months', 'gameweeks', 'activeWeekId', 'packages'));
    }

    public function teamDetails(Request $request, Division $division)
    {
        $players = $this->service->getTeamPlayerPoints($division, $request->get('team_id'));

        return view('manager.divisions.ranking.team', compact('players'));
    }

    public function getSeasonRanking(SeasonTeamRankingDataTable $seasonTeamRankingDataTable)
    {
        return $seasonTeamRankingDataTable->ajax();
    }

    public function getMonthRanking(MonthTeamRankingDataTable $monthTeamRankingDataTable)
    {
        return $monthTeamRankingDataTable->ajax();
    }

    public function getWeekRanking(WeekTeamRankingDataTable $weekTeamRankingDataTable)
    {
        return $weekTeamRankingDataTable->ajax();
    }
}
